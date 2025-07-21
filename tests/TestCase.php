<?php

namespace Webteractive\MakeAction\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Webteractive\MakeAction\MakeActionServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            MakeActionServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }
}
