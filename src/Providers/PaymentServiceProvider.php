<?php

namespace abolfazlrastegar\LaravelPayments\Providers;

use Abolfazlrastegar\LaravelPayments\Payment;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register ()
    {
        $this->app->bind('payments', function () {
            return new Payment();
        });

    }

    public function boot ()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/payments.php') =>  config_path('payments.php')
        ], 'config');
    }
}
