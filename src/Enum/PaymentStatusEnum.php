<?php

namespace JalalLinuX\Tomanpay\Enum;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self UNKNOWN()
 * @method static self EXPIRED()
 * @method static self FAILED()
 * @method static self REVERTED()
 * @method static self CREATED()
 * @method static self TOKEN_ACQUIRED()
 * @method static self REDIRECT_TO_PSP()
 * @method static self CALLED_BACK()
 * @method static self VERIFIED()
 */
class PaymentStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'UNKNOWN' => -3,
            'EXPIRED' => -2,
            'FAILED' => -1,
            'REVERTED' => 0,
            'CREATED' => 1,
            'TOKEN_ACQUIRED' => 2,
            'REDIRECT_TO_PSP' => 3,
            'CALLED_BACK' => 4,
            'VERIFIED' => 5,
        ];
    }

    protected static function labels(): array
    {
        return [
            'UNKNOWN' => 'The status of the payment cannot be determined automatically, this status will be tracked by our operators and resolved',
            'EXPIRED' => 'Payment has expired',
            'FAILED' => 'The payment was not successful',
            'REVERTED' => 'You rejected the payment and the money is refunded to the user',
            'CREATED' => 'The payment has just been created',
            'TOKEN_ACQUIRED' => 'Token for this payment has been acquired, you can redirect your user with the token',
            'REDIRECT_TO_PSP' => 'The user has been redirected to a payment gateway',
            'CALLED_BACK' => 'Toman has redirected the user to your callback endpoint',
            'VERIFIED' => 'Payment was verified by you and is considered successful',
        ];
    }
}
