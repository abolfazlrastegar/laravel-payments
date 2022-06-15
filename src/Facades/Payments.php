<?php
namespace abolfazlrastegar\LaravelPayments\Facades;
use Illuminate\Support\Facades\Facade;

class Payment extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor() { return 'payment'; }
}
