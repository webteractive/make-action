<?php

namespace Webteractive\MakeAction\Tests;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Artisan;

class MakeActionCommandTest extends TestCase
{
    #[Test]
    public function it_formats_the_class_name_and_creates_the_action_successfully(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        $inputName = 'bad-action'; // not valid class name as-is
        $expectedClassName = 'BadAction';
        $expectedPath = app_path("Actions/{$expectedClassName}.php");

        File::ensureDirectoryExists(app_path('Actions'));

        if (File::exists($expectedPath)) {
            File::delete($expectedPath);
        }

        $exitCode = Artisan::call('make:action', [
            'name' => $inputName,
        ]);

        $output = Artisan::output();

        $this->assertSame(0, $exitCode);
        $this->assertStringContainsString('Action created successfully.', $output);
        $this->assertStringContainsString("Action path: {$expectedPath}", $output);

        $this->assertTrue(File::exists($expectedPath));

        $content = File::get($expectedPath);

        $this->assertStringContainsString('namespace App\\Actions;', $content);
        $this->assertStringContainsString("class {$expectedClassName}", $content);
        $this->assertStringContainsString('public function handle()', $content);

        File::delete($expectedPath);
    }

    #[Test]
    public function it_can_create_an_action_class_using_custom_path_and_namespace_overrides(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        $actionName = 'CustomLocationAction';

        // Use a deep path override (relative -> base_path())
        $relativeDir = 'plugins/Custom/src/Actions';
        $absoluteDir = base_path($relativeDir);
        $actionPath = $absoluteDir.'/'.$actionName.'.php';

        // ensure clean
        File::ensureDirectoryExists($absoluteDir);
        if (File::exists($actionPath)) {
            File::delete($actionPath);
        }

        $exitCode = Artisan::call('make:action', [
            'name' => $actionName,
            '--path' => $relativeDir,
            '--namespace' => 'Plugins\\Custom\\Actions',
        ]);

        $output = Artisan::output();

        $this->assertSame(0, $exitCode);
        $this->assertStringContainsString('Action created successfully.', $output);
        $this->assertStringContainsString("Action path: {$actionPath}", $output);

        $this->assertTrue(File::exists($actionPath));

        $content = File::get($actionPath);
        $this->assertStringContainsString('namespace Plugins\\Custom\\Actions;', $content);
        $this->assertStringContainsString("class {$actionName}", $content);
        $this->assertStringContainsString('public function handle()', $content);

        File::delete($actionPath);

        // best-effort cleanup
        @rmdir(base_path('plugins/Custom/src/Actions'));
        @rmdir(base_path('plugins/Custom/src'));
        @rmdir(base_path('plugins/Custom'));
        @rmdir(base_path('plugins'));
    }

    #[Test]
    public function it_can_create_an_action_class_with_default_settings(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        $actionName = 'TestAction';
        $actionPath = app_path('Actions/'.$actionName.'.php');

        File::ensureDirectoryExists(app_path('Actions'));

        if (File::exists($actionPath)) {
            File::delete($actionPath);
        }

        $exitCode = Artisan::call('make:action', ['name' => $actionName]);

        $this->assertSame(0, $exitCode);
        $this->assertTrue(File::exists($actionPath));

        $content = File::get($actionPath);
        $this->assertStringContainsString('namespace App\\Actions;', $content);
        $this->assertStringContainsString('class TestAction', $content);
        $this->assertStringContainsString('public function handle()', $content);

        File::delete($actionPath);
    }

    #[Test]
    public function it_can_create_an_action_class_with_custom_method_option(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        $actionName = 'AnotherAction';
        $actionPath = app_path('Actions/'.$actionName.'.php');

        File::ensureDirectoryExists(app_path('Actions'));

        if (File::exists($actionPath)) {
            File::delete($actionPath);
        }

        $exitCode = Artisan::call('make:action', [
            'name' => $actionName,
            '--method' => 'execute',
        ]);

        $this->assertSame(0, $exitCode);
        $this->assertTrue(File::exists($actionPath));

        $content = File::get($actionPath);
        $this->assertStringContainsString('namespace App\\Actions;', $content);
        $this->assertStringContainsString('class AnotherAction', $content);
        $this->assertStringContainsString('public function execute()', $content);

        File::delete($actionPath);
    }

    #[Test]
    public function it_can_create_an_action_class_using_target_alias(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        config()->set('make-action.targets', [
            'billing' => [
                'path' => base_path('plugins/Billing/src/Actions'),
                'namespace' => 'Plugins\\Billing\\Actions',
                'method' => 'execute',
            ],
        ]);

        $actionName = 'BillingAction';
        $actionDir = base_path('plugins/Billing/src/Actions');
        $actionPath = $actionDir.'/'.$actionName.'.php';

        File::ensureDirectoryExists($actionDir);

        if (File::exists($actionPath)) {
            File::delete($actionPath);
        }

        $exitCode = Artisan::call('make:action', [
            'name' => $actionName,
            '--target' => 'billing',
        ]);

        $this->assertSame(0, $exitCode);
        $this->assertTrue(File::exists($actionPath));

        $content = File::get($actionPath);
        $this->assertStringContainsString('namespace Plugins\\Billing\\Actions;', $content);
        $this->assertStringContainsString('class BillingAction', $content);
        $this->assertStringContainsString('public function execute()', $content);

        File::delete($actionPath);

        // clean up created directories if empty (best-effort)
        @rmdir(base_path('plugins/Billing/src/Actions'));
        @rmdir(base_path('plugins/Billing/src'));
        @rmdir(base_path('plugins/Billing'));
        @rmdir(base_path('plugins'));
    }

    #[Test]
    public function it_fails_when_target_alias_is_unknown(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        config()->set('make-action.targets', [
            'billing' => [
                'path' => base_path('plugins/Billing/src/Actions'),
                'namespace' => 'Plugins\\Billing\\Actions',
                'method' => 'execute',
            ],
        ]);

        $actionName = 'UnknownTargetAction';
        $defaultPath = app_path('Actions/'.$actionName.'.php');
        $billingPath = base_path('plugins/Billing/src/Actions/'.$actionName.'.php');

        if (File::exists($defaultPath)) {
            File::delete($defaultPath);
        }
        if (File::exists($billingPath)) {
            File::delete($billingPath);
        }

        $exitCode = Artisan::call('make:action', [
            'name' => $actionName,
            '--target' => 'nope',
        ]);

        $this->assertSame(1, $exitCode);
        $this->assertFalse(File::exists($defaultPath));
        $this->assertFalse(File::exists($billingPath));
    }

    #[Test]
    public function it_fails_when_method_name_is_invalid(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        $actionName = 'InvalidMethodAction';
        $actionPath = app_path('Actions/'.$actionName.'.php');

        File::ensureDirectoryExists(app_path('Actions'));

        if (File::exists($actionPath)) {
            File::delete($actionPath);
        }

        $exitCode = Artisan::call('make:action', [
            'name' => $actionName,
            '--method' => '123bad',
        ]);

        $this->assertSame(1, $exitCode);
        $this->assertFalse(File::exists($actionPath));
    }

    #[Test]
    public function it_fails_when_action_already_exists(): void
    {
        config()->set('make-action.default', [
            'path' => app_path('Actions'),
            'namespace' => 'App\\Actions',
            'method' => 'handle',
        ]);

        $actionName = 'DuplicateAction';
        $actionPath = app_path('Actions/'.$actionName.'.php');

        File::ensureDirectoryExists(app_path('Actions'));

        // Create existing file
        File::put($actionPath, '<?php // existing');

        $exitCode = Artisan::call('make:action', ['name' => $actionName]);

        $this->assertSame(1, $exitCode);
        $this->assertTrue(File::exists($actionPath));
        $this->assertSame('<?php // existing', File::get($actionPath));

        File::delete($actionPath);
    }
}
