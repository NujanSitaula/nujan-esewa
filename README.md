
# eSewa ePay v.2 Payment Gateway Integration for Laravel

This package provides a seamless integration of the eSewa payment gateway into a Laravel project.

## Installation

You can install the package via composer:

```bash
composer require nujan/esewa:@dev
```

After installing the package, publish the configuration file:

```bash
php artisan vendor:publish --provider="Nujan\Esewa\EsewaServiceProvider"
```

This will create a `esewa.php` config file in your `config` directory.

## Configuration

The environment variables `ESEWA_MERCHANT_CODE`, `ESEWA_SECRET`, and `ESEWA_API_ENDPOINT` should be set in your `.env` file:

```dotenv
ESEWA_MERCHANT_CODE=your_merchant_code
ESEWA_SECRET=your_secret_key
ESEWA_API_ENDPOINT=your_api_endpoint
```

## Usage

Here's a basic usage example:

```php
use Nujan\Esewa\Esewa;

$esewa = new Esewa();

$data = [
    'amount' => 100,
    'tax_amount' => 10,
    'total_amount' => 110,
    'transaction_uuid' => uniqid(mt_rand(), true),
    'product_code' => 'EPAYTEST',
    'product_service_charge' => 0,
    'product_delivery_charge' => 0,
    'success_url' => 'http://review.test/esewa/success',
    'failure_url' => 'https://google.com',
    'signed_field_names' => 'total_amount,transaction_uuid,product_code',
];

$response = $esewa->sendPaymentRequest($data);

// Handle the response as needed
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
```

Please replace `your_merchant_code`, `your_secret_key`, and `your_api_endpoint` with your actual eSewa merchant code, secret key, and API endpoint.
