![alt text](https://github.com/abolfazlrastegar/laravel-payments/blob/main/laravel-payment.png?raw=true)

[//]: # (<p align="center">)

[//]: # (<a href="https://packagist.org/packages/abolfazlrastegar/laravel-payments"><img src="https://img.shields.io/packagist/dt/abolfazlrastegar/laravel-payments" alt="Total Downloads"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>)

[//]: # (<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>)

[//]: # (</p>)
### Laravel-payments
package laravel multi payment support form  (Zarinpal, Zibal, Idpay, Payir)

### Install package for laravel ^7
```bash
composer require abolfazlrastegar/laravel-payments
```
### Publish provider
```bash
 php artisan vendor:publish --provider="Abolfazlrastegar\LaravelPayments\Providers\PaymentServiceProvider" --force
```

### Ues methode `request`
```bash
    Payment::create('Zarinpal')
        ->amount(10000)
        ->callbackUrl('http://127.0.0.1:8000/')
        ->request();
```
### Or
```bash
    Payment::create()
    ->defaultBank() // set name bank to payments/config
    ->amount(10000)
    ->callbackUrl('http://127.0.0.1:8000/')
    ->request();
```
### Ues methode `verify`
```bash
     Payment::create('Zarinpal')
        ->params()
        ->verfiy();
```
### Or 
```bash
     Payment::create()
        ->defaultBank() // set name bank to payments/config
        ->params() 
        ->verify();
```

### Ues methods zarinpal
```bash
    // method 
    Payment::create('Zarinpal')
       ->amount(10000)
       ->callbackUrl('http://127.0.0.1:8000/')
       ->api(true)
       ->defaultBank()
        ->params([
           [
               "iban" => "IR130570028780010957775103",
               "amount" => 1000,
               "description" => "....تسهیم سود فروش از محصول به "
           ],
           [
               "iban" => "IR670170000000352965862009",
               "amount" => 5000,
               "description" => "....تسهیم سود فروش از محصول به "
           ]
       ])
       ->checkout();
       
       // method 
       Payment::create('Zarinpal')->refund('A00000000000000000000000000243676791')
       
       // method
       Payment::create('Zarinpal')->unVerified()
```
### config 
```bash
    /*
    |----------------------------------------------
    | set type payment [ریال = rtr] [ تومان = rtt]
    |-----------------------------------------------
    */
    'currency' => 'rtt',

    /*
     |-------------------------------------------------
     |
     |-------------------------------------------------
     */

    'http_verify' => true,
    /*
    |--------------------------------------------
    | set default payment
    |--------------------------------------------
    | from 'Zibal', 'PayIr', 'IdPay', 'Zarinpal'
    */

    'Default_payment' => 'Zibal',

    /*
    |-------------------------------------------
    | set description payment
    |-------------------------------------------
    */
    'Description_payment' => 'شارژ کیف پول',

    /*
    |-------------------------------------------
    | set description payment
    |-------------------------------------------
    */
    'Test_payment' => false,

    /*
     |------------------------------------------
     | active and inactive Bank portal
     |------------------------------------------
     | active = 'true'  and inactive = 'false'
     */
    'drivers' => [
        'Zarinpal' => [
            'key' => '',
            'access_Token' => '',
            'status' => true
        ],

        'Zibal' =>  [
            'key' => '',
            'status' => true
        ],

        'PayIr' =>  [
            'key' => '',
            'status' => true
        ],

        'IdPay' =>  [
            'key' => '',
            'status' => true
        ],
    ]
```
