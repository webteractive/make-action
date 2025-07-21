<?php

namespace Webteractive\MakeAction\Tests;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Artisan;

class MakeActionCommandTest extends TestCase
{
    #[Test]
    public function it_can_create_an_action_class_with_default_method()
    {
        $actionName = 'TestAction';
        $actionPath = app_path('Actions/'.$actionName.'.php');

        // Ensure the file doesn't exist before running the command
        if (File::exists($actionPath)) {
            File::delete($actionPath);
        }

        Artisan::call('make:action', ['name' => $actionName]);

        $this->assertTrue(File::exists($actionPath));

        $content = File::get($actionPath);
        $this->assertStringContainsString('namespace App\Actions;', $content);
        $this->assertStringContainsString('class TestAction', $content);
        $this->assertStringContainsString('public function handle()', $content);

        File::delete($actionPath);
    }

    #[Test]
    public function it_can_create_an_action_class_with_custom_method()
    {
        config()->set('make-action.method_name', 'execute');

        $actionName = 'AnotherAction';
        $actionPath = app_path('Actions/'.$actionName.'.php');

        // Ensure the file doesn't exist before running the command
        if (File::exists($actionPath)) {
            File::delete($actionPath);
        }

        Artisan::call('make:action', ['name' => $actionName]);

        $this->assertTrue(File::exists($actionPath));

        $content = File::get($actionPath);
        $this->assertStringContainsString('namespace App\Actions;', $content);
        $this->assertStringContainsString('class AnotherAction', $content);
        $this->assertStringContainsString('public function execute()', $content);

        File::delete($actionPath);
    }
}
