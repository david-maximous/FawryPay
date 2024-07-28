# Fawry Payment Gateway
[![Latest Version on Packagist](https://img.shields.io/packagist/v/david-maximous/fawrypay.svg?style=flat-square)](https://packagist.org/packages/david-maximous/fawrypay)
[![Awesome](https://cdn.rawgit.com/sindresorhus/awesome/d7305f38d29fed78fa85652e3a63e154dd8e8829/media/badge.svg)](https://github.com/sindresorhus/awesome)
[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)
[![Made With Love](https://img.shields.io/badge/Made%20With-Love-orange.svg)](https://github.com/chetanraj/awesome-github-badges)

Laravel Payment Helper for FawryPay/Fawry Accept

![fawrypay.png](https://developer.fawrystaging.com/fawrypay/img/brand/blue.png)


## Supported methods

- Pay By Reference Code
- Pay By Credit/Debit Card
- Pay By Mobile Wallet

## Installation

```jsx
composer require david-maximous/fawrypay
```

## Publish Vendor Files

```jsx
php artisan vendor:publish --tag="fawrypay-config"
php artisan vendor:publish --tag="fawrypay-lang"

//or use all for all configrations
php artisan vendor:publish --tag="fawrypay-all"
```

### fawrypay.php config file

```php
<?php
return [
    'FAWRY_URL' => env('FAWRY_URL', "https://atfawry.fawrystaging.com/"), //https://www.atfawry.com/ for production
    'FAWRY_SECRET' => env('FAWRY_SECRET'),
    'FAWRY_MERCHANT' => env('FAWRY_MERCHANT'),

    'VERIFY_ROUTE_NAME' => "verify-payment", //Route name for the payment verify route
    'APP_NAME'=>env('APP_NAME'),
];
```

## Web.php MUST Have Route with name “verify-payment”

```php
Route::get('/payments/verify/{payment?}',[PaymentController::class,'payment_verify'])->name('verify-payment');
```

## How To Make payment request

```jsx
use DavidMaximous\Fawrypay\Classes\FawryPayment;

$payment = new FawryPayment();

//pay function
$response = $payment->pay(
    $amount,
    $user_id,
    $user_name,
    $user_email,
    $user_phone,
    $language,
    $method,
    $item,
    $quantity,
    $description,
    $itemImage
);

//or use
$response = $payment->setUserId($user_id)
->setUserName($user_full_name)
->setUserEmail($user_email)
->setUserPhone($user_phone)
->setMethod($method)    //Optional, Use PayAtFawry/MWALLET/CARD
->setLanguage($language) //Optional, Default is en-gb
->setItem($item_name) //Optional, Default is 1
->setQuantity($quantity) //Optional, Default is 1
->setDescription($description) //Optional
->setItemImage($image_url)  //Optional
->setAmount($amount)
->pay();

dd($response);
//pay function response 
[
	'payment_id'=>"", // refrence code that should stored in your orders table
	'redirect_url'=>"", // redirect url to the payment page
]
```

## How To Make verify request

```jsx
use DavidMaximous\Fawrypay\Classes\FawryVerify;

//This method is for verifying payment after the user gets redirected back to your website, should be used inside the verify route function
$verify = new FawryVerify();

//verify function
$response = $payment->verify($verify);

dd($response);
//outputs
[
	'success'=>true,//or false
    'payment_id'=>"PID",
	'message'=>"Done Successfully",//message for client
	'process_data'=>""//fawry response
]

//For manually checking the payment status, please use the following method
$response = $payment->getPaymentStatus($payment_id);
dd($response);
//outputs
[
    'status'=>"PAID", //or New, CANCELED, REFUNDED, EXPIRED, PARTIAL_REFUNDED, FAILED
    'process_data'=>""//fawry response
]
```

## For more information, please check the official documentation

- [Checkout Link Integeration](https://developer.fawrystaging.com/docs/express-checkout/fawrypay-hosted-checkout)
- [Get Payment Status V2](https://developer.fawrystaging.com/docs/express-checkout/payment-notifications/get-payment-status-v2)
- [Test Cards](https://developer.fawrystaging.com/docs/express-checkout/testing/testing)
- [Error Codes](https://developer.fawrystaging.com/docs/express-checkout/error-codes/error-codes)

### Security

If you discover any security-related issues, please email [security@davidmaximous.me](mailto:security@davidmaximous.me) instead of using the issue tracker.
