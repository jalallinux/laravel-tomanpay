<?php

namespace JalalLinuX\Tomanpay\Tests;

use Illuminate\Http\RedirectResponse;
use JalalLinuX\Tomanpay\Model\Payment;

class PaymentRedirectTest extends TestCase
{
    public function testCorrectUuid()
    {
        $uuid = '7cadba50-6059-424e-9580-c12448a8046e';
        $redirect = Payment::redirect($uuid);

        $this->assertInstanceOf(RedirectResponse::class, $redirect);
    }
}
