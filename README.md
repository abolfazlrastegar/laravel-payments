### Laravel-payments
package laravel multi payment support form  (Zarinpal, Zibal, Idpay, Payir)

### Install package
```bash
composer require abolfazlrastegar/laravel-payments
```
### Publish provider
```bash
 php artisan vendor:publish --provider="Abolfazlrastegar\\LaravelPayments\\Providers\\PaymentServiceProvider" --force
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
