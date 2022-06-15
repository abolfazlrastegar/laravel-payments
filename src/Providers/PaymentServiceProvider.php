<?php

namespace abolfazlrastegar\LaravelPayments\Providers;

use Abolfazlrastegar\LaravelPayments\Payments;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use phpDocumentor\Reflection\Types\This;

class PaymentServiceProvider extends ServiceProvider
{
    public function register ()
    {
      $this->app->bind('payments', function () {
            return new Payments();
        });
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Payments', "Abolfazlrastegar\LaravelPayments\Facades\Payments");
    }

    public function boot ()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/payments.php') =>  config_path('payments.php')
        ], 'config');
    }
}
