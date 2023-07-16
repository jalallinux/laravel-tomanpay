<?php

namespace JalalLinuX\Tomanpay\Tests;

use JalalLinuX\Tomanpay\Model\Payment;

class PaymentVerifyTest extends TestCase
{
    public function testCorrectUuid()
    {
        $uuid = '7cadba50-6059-424e-9580-c12448a8046e';

        $verified = Payment::verify($uuid, false);
        $this->assertIsBool($verified);

        $this->expectExceptionCode(400);
        Payment::verify($uuid);
    }
}
