<?php

namespace abolfazlrastegar\LaravelPayments\Providers;

use Abolfazlrastegar\LaravelPayments\Payments;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register ()
    {
      $this->app->bind('payments', function () {
            return new Payments();
        });
    }

    public function boot ()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/payments.php') =>  config_path('payments.php')
        ], 'config');
    }
}
