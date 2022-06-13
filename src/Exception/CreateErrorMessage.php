<?php

namespace Abolfazlrastegar\LaravelPayments\Exception;
use Exception;
class CreateErrorMessage extends Exception
{
    /**
     * @param $bank
     * @param $namespace
     * @return static
     */
    public static function notClassBank ($bank, $namespace) {
        return new static("Class `{$bank}` is not found  ". $namespace);
    }

    /**
     * @param $bank
     * @return static
     */
    public static function incativeBank ($bank) {
        return new static("Inactive `{$bank}` check file payments/config");
    }

    public static function messageNotSupportMethode ($bank, $methode)
    {
        return new static("Not support methode `{$methode}` to `{$bank}` and Zarinpal support");
    }
}
