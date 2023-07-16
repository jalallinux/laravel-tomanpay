<?php

namespace JalalLinuX\Tomanpay\Model;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

abstract class BaseModel
{
    protected array $config;

    public function __construct()
    {
        $this->config = collect(config('tomanpay.modes'))->firstWhere('mode', config('tomanpay.default'));
    }

    protected function client(): PendingRequest
    {
        throw_if(!isset($this->config), new \Exception("Payment mode " . config('tomanpay.default') . " not defined in config file."));
        return Http::baseUrl($this->config['base_url'])->withToken($this->config['token']);
    }
}
