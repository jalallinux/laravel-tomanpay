<?php

namespace JalalLinuX\Tomanpay;

use JalalLinuX\Tomanpay\Model\Payment;

class Tomanpay
{
    public function payment(): Payment
    {
        return new Payment;
    }
}
