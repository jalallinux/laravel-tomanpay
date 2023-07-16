<?php

namespace JalalLinuX\Tomanpay\Exceptions;

use Throwable;

class Exception extends \Exception
{
    public function __construct(string $message = null, int $code = 500, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
