# Esewa package for Laravel

This package is for Laravel Framework making super easy for developers to integrate the eSewa
payments into Laravel Application and use instantly. For more details read Official eSewa Documentation.

## Installation

**Install this Package** – Using **Composer**.

**Composer Installation**
```
composer require zerkxubas/esewa-laravel
```
**Sail Installation**
```
sail composer require zerkxubas/esewa-laravel
```

## Publishing The Configurations
```
php artisan vendor:publish --tag=esewa
```
This will publish **esewa.php** inside the config directory of your laravel project.

## .env Settings [ Development Mode ]
inside the **.env** file use these below config values for quick setup.
For, **Production Mode** ensuure you set **ESEWA_DEBUG_MODE=false** & use The Production **ESEWA_API_URL** and also the **ESEWA_MERCHAND_CODE** in **.env** file
```
ESEWA_API_URL=https://uat.esewa.com.np
ESEWA_DEBUG_MODE=true
ESEWA_MERCHANT_CODE=EPAYTEST
ESEWA_SUCCESS_URL="http://localhost/order/success"
ESEWA_FAILURE_URL="http://localhost/payment/failure"
```

## Quick Examples

### Easily Create an eSewa Portal Payment Checkout
In this method i have made it super simpler & easier to implement & use instantly in laravel projects. Use like the below example code inside your controller and this will take the user to the esewa payment portal.

```php
// use the namespace
use Zerkxubas\EsewaLaravel\Facades\Esewa;

// Directly use like this inside the controller function code.
return Esewa::checkout($paymentID,$totalAmount,$taxAmount,$serviceCharge,$deliveryCharge);

```
**Dont Forget To Create The Success & Failure Route**

**Parameters**
1. `pid` => `paymentID`
2. `amt` => `totalAmount`
3. `txAmt` => `taxAmount`
4. `psc` => `serviceCharge`
5. `pdc` => `deliveryCharge`

### Testing Credentials
Default credentials provided by esewa for testing or development purpose.

**eSewa ID**: `9806800001/2/3/4/5`

**Password**: `Nepal@123`

**Token**: `123456`

### Verify Payment

To verify our payments status this is super simpler & easier just use like this and you are good to go.

```php
// use the namespace
use Zerkxubas\EsewaLaravel\Facades\Esewa;

// Taking the get request return parameters.
$paymentID = $_GET['oid'];
$transactionAmount = $_GET['amt'];
$refrenceID = $_GET['refId'] ;

// Verifying the Esewa Payment, [ returns, Either true or false ]
$paymentStatus = Esewa::verifyPayment($refrenceID,$paymentID,$transactionAmount);

if ($paymentStatus) {
    // Success payment.
}
```

## Additional
Reading esewa official documentation is highly recommended as there might be new changes in future so its crucial for a developer to be updated with the latest changes.


