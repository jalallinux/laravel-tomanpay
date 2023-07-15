<?php

namespace JalalLinuX\Tomanpay\Tests;

use Illuminate\Foundation\Testing\WithFaker;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use WithFaker;

    protected $loadEnvironmentVariables = true;

    protected function getPackageProviders($app): array
    {
        return [

        ];
    }

    protected function setUp(): void
    {
        // Code before application created.
        parent::setUp();
        // Code after application created.
    }
}
