<?php

namespace JalalLinuX\Tomanpay\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use JalalLinuX\Tomanpay\TomanpayServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithFaker;

    protected $loadEnvironmentVariables = true;

    protected function getPackageProviders($app): array
    {
        return [
            TomanpayServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        // Code before application created.
        parent::setUp();
        // Code after application created.
    }
}
