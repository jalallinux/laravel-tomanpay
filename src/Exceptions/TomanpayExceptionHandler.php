<?php

namespace JalalLinuX\Tomanpay\Exceptions;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class TomanpayExceptionHandler
{
    private static Response $response;

    private static RequestException $exception;

    public static function make(Response $response, RequestException $exception): self
    {
        self::$response = $response;
        self::$exception = $exception;

        return new static;
    }

    public static function getResponse(): Response
    {
        return self::$response;
    }

    public static function getGuzzleException(): RequestException
    {
        return self::$exception;
    }

    public function handle(): void
    {
        if (self::$response->serverError()) {
            logger()->critical("({$this->getStatus()}) {$this->getMessage()}", self::$response->json() ?? []);
            if (! is_null($this->getMessage())) {
                throw new Exception($this->getMessage(), $this->getStatus());
            }
        }

        if (self::$response->clientError()) {
            throw new Exception($this->getMessage(), $this->getStatus());
        }
    }

    public function getMessage(): string
    {
        $message = last(self::$response->collect()->first());

        return self::$response->status().": {$message['description']}" ?? self::$exception->getMessage();
    }

    public function getStatus(): int
    {
        return self::$response->status();
    }
}
