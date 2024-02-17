<?php

return [

    /*
    |--------------------------------------------------------------------------
    | eSewa Configuration
    |--------------------------------------------------------------------------
    |
    | Here we may specify the configuration details for eSewa integration.
    |
    */

    'api_url' => env('ESEWA_API_URL', 'https://uat.esewa.com.np'),

    'merchant_code' => env('ESEWA_MERCHANT_CODE', 'EPAYTEST'),

    // We can customize the status URL
    'success_url' => env('ESEWA_SUCCESS_URL', 'http://localhost/order/success'),

    'failure_url' => env('ESEWA_FAILURE_URL', 'http://localhost/payment/failure'),

    'debug_mode' => env('ESEWA_DEBUG_MODE', true),

];
