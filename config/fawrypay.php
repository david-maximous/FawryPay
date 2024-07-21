<?php
return [
    'FAWRY_URL' => env('FAWRY_URL', "https://atfawry.fawrystaging.com/"), //https://www.atfawry.com/ for production
    'FAWRY_SECRET' => env('FAWRY_SECRET'),
    'FAWRY_MERCHANT' => env('FAWRY_MERCHANT'),

    'VERIFY_ROUTE_NAME' => "verify-payment", //Route name for the payment verify route
    'APP_NAME'=>env('APP_NAME'),
];
