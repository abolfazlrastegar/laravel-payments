<?php

namespace Tests;

use Abolfazlrastegar\LaravelPayments\Payments;
use PHPUnit\Framework\TestCase;

class TestPayment extends TestCase
{
    /** @test */
    public function TestRequestBank ()
    {
        $pa = Payments::create()
            ->defaultBank()
            ->api(true)
            ->amount(10000)
            ->callbackUrl('http://127.0.0.1:8000')
            ->request();

        $this->assertEquals($pa, $pa);
    }

    /** @test */
    public function TestCheckoutBank ()
    {
        $pa = Payments::create()
            ->defaultBank()
            ->api(true)
            ->amount(10000)
            ->callbackUrl('http://127.0.0.1:8000')
            ->checkout();

        $this->assertEquals('ok method checkout', $pa);
    }

    /** @test */
    public function TestUnVerifiedZarinpal ()
    {
        $unVerified = Payments::create('Zarinpal')->unVerified();

        $this->assertEquals($unVerified, $unVerified);
    }
}
