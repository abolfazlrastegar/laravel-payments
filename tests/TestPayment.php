<?php

namespace Tests;

use Abolfazlrastegar\LaravelPayments\Payment;
use PHPUnit\Framework\TestCase;

class TestPayment extends TestCase
{
    /** @test */
    public function TestRequestBank ()
    {
        $pa = Payment::create()
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
        $pa = Payment::create()
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
        $unVerified = Payment::create('Zarinpal')->unVerified();

        $this->assertEquals($unVerified, $unVerified);
    }
}
