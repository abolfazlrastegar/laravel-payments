<?php
namespace abolfazlrastegar\LaravelPayments\Facades;
use Illuminate\Support\Facades\Facade;

class Payments extends Facade
{
  protected static function getFacadeAccessor()
  {
      return 'payments';
  }
}
