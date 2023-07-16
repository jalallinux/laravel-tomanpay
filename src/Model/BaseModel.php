<?php

namespace JalalLinuX\Tomanpay\Model;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use JalalLinuX\Tomanpay\Exceptions\TomanpayExceptionHandler;

abstract class BaseModel
{
    protected function api(bool $withThrow = true): PendingRequest
    {
        $request = Http::baseUrl($this->config('base_url'))
            ->withToken($this->config('token'));

        return $withThrow ? $request->throw(fn ($response, $e) => TomanpayExceptionHandler::make($response, $e)->handle()) : $request;
    }

    protected function config(string $key = null)
    {
        $config = collect(config('tomanpay.modes'))->firstWhere('mode', config('tomanpay.default'));
        throw_if(! isset($config), new \Exception('Payment mode '.config('tomanpay.default').' not defined in config file.'));

        return is_null($key) ? $config : data_get($config, $key);
    }
}
