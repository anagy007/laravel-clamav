<?php

return [
    'host' => env('CLAMAV_HOST', 'unix:/var/run/clamav/clamd.ctl'),
    'timeout' => env('CLAMAV_TIMEOUT', 30),
];
