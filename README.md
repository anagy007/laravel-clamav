# ClamAV integration for Laravel 5.5+

[![Latest Stable Version](https://poser.pugx.org/sunspikes/clamav-validator/v/stable)](https://packagist.org/packages/crys/laravel-clamav)
[![License](https://poser.pugx.org/sunspikes/clamav-validator/license)](https://packagist.org/packages/crys/laravel-clamav)

Custom Laravel 5 anti-virus validator for file uploads.

## Requirements

You must have ClamAV anti-virus scanner running on the server to make this package work.

You can see the ClamAV installation instructions on the official [ClamAV documentation](http://www.clamav.net/documents/installing-clamav).

For example on an Ubuntu machine, you can do:

```sh
# Install clamav virus scanner
sudo apt update && apt install -y clamav-daemon

# Update virus definitions
sudo freshclam

# Start the scanner service
sudo systemctl enable --now clamav-daemon clamav-freshclam
```

This package is not tested on windows, but if you have ClamAV running (usually on port 3310) it should work.

## Installation

Install the package through [Composer](http://getcomposer.org).

Run `composer require crys/laravel-clamav`

Add the following to your `providers` array in `config/app.php`:

```php
'providers' => [
	// ...

	Crys\Clamav\ServiceProvider::class,
],
```

## Usage

Use it like any `Validator` rule:

```php
$rules = [
	'my_file_field' => 'clamav',
];
```

## Configuration

By default the package will try to connect the clamav daemon via the default unix socket (`/var/run/clamav/clamd.ctl`)

But you can set the `CLAMAV_HOST` environment variable to override this.
