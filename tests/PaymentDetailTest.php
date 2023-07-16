<?php

namespace JalalLinuX\Tomanpay\Tests;

use JalalLinuX\Tomanpay\Model\Payment;
use JalalLinuX\Tomanpay\Tomanpay;

class PaymentDetailTest extends TestCase
{
    public function testCorrectUuid()
    {
        $uuid = '7cadba50-6059-424e-9580-c12448a8046e';
        $payment = (new Tomanpay)->payment()->detail($uuid);

        $this->isInstanceOf(Payment::class);
        $this->assertEquals($uuid, $payment->getUuid());
    }
}
