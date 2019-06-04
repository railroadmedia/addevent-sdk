<?php

namespace Railroad\AddEventSdk\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Railroad\AddEventSdk\Connector;

class TestCase extends BaseTestCase
{

    protected $apiToken;

    /** @var Connector */
    protected $connector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->apiToken = config('addevent-sdk.api-token');

        $this->connector = app(Connector::class);
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     *
     * This is called *before* setUp
     */
    protected function getEnvironmentSetUp($app)
    {
        $dotenv = \Dotenv\Dotenv::create(__DIR__ . '/../');
        $dotenv->load();

        config()->set('addevent-sdk.api-token', env('ADD_EVENT_API_TOKEN'));
    }
}
