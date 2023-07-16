<?php

namespace JalalLinuX\Tomanpay\Tests;

use Illuminate\Pagination\LengthAwarePaginator;
use JalalLinuX\Tomanpay\Model\Payment;
use JalalLinuX\Tomanpay\Tomanpay;

class PaymentListTest extends TestCase
{
    public function testSuccess()
    {
        $payments = (new Tomanpay)->payment()->list();

        $this->assertInstanceOf(LengthAwarePaginator::class, $payments);
        $payments->collect()->each(fn ($payment) => $this->assertInstanceOf(Payment::class, $payment));
    }
}
