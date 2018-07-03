<?php
declare(strict_types=1);

namespace Crys\Clamav;

use Xenolope\Quahog\Client as ClamavClient;
use Socket\Raw\Factory as SocketFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Validator
{
    /**
     * Validate the uploaded file for virus/malware with ClamAV
     *
     * @param  $attribute   string
     * @param  $value       mixed
     *
     * @return boolean
     * @throws ScanException
     */
    public function validate($attribute, $value)
    {
        // if were passed an instance of UploadedFile, return the path
        if ($value instanceof UploadedFile) {
            $file = $value->getPathname();
        }

        // if we're passed a PHP file upload array, return the "tmp_name"
        if (is_array($value) && null !== array_get($value, 'tmp_name')) {
            $file = $value['tmp_name'];
        }

        // fallback: we were likely passed a path already
        $file = (string) $value;

        // Create a new socket instance
        $socket = (new SocketFactory)->createClient(config('clamav.host'));

        // Create a new instance of the Client
        $client = new ClamavClient($socket, config('clamav.timeout'), PHP_NORMAL_READ);

        // Check if the file is readable
        if (!is_readable($file)) {
            throw new ScanException(sprintf('The file "%s" is not readable', $file));
        }

        // Scan the file
        $result = $client->scanResourceStream(fopen($file, 'rb'));

        if ($result['status'] === 'ERROR') {
            throw new ScanException($result['reason']);
        }

        // Check if scan result is not clean
        return $result['status'] === 'OK';
    }
}
