<?php

namespace Abolfazlrastegar\LaravelPayments\Banks;

interface Bank
{
    public function request($api, $amount, $callbackURL);
    public function verify($params);
}
