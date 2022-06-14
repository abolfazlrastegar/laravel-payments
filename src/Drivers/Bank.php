<?php

namespace Abolfazlrastegar\LaravelPayments\Drivers;

interface Bank
{
    public function request($api, $amount, $callbackURL);
    public function verify($params);
}
