<?php

namespace Webteractive\MakeAction\Tests;

use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

class BoostGuidelinesTest extends TestCase
{
    #[Test]
    public function it_includes_boost_guidelines_file()
    {
        $guidelinesPath = __DIR__.'/../resources/boost/guidelines/core.blade.php';

        $this->assertTrue(
            File::exists($guidelinesPath),
            'Boost guidelines file should exist at resources/boost/guidelines/core.blade.php'
        );
    }

    #[Test]
    public function boost_guidelines_contains_required_sections()
    {
        $guidelinesPath = __DIR__.'/../resources/boost/guidelines/core.blade.php';
        $content = File::get($guidelinesPath);

        $this->assertStringContainsString('## make:action Command', $content);
        $this->assertStringContainsString('### Features', $content);
        $this->assertStringContainsString('### Creating Actions', $content);
        $this->assertStringContainsString('### Configuration', $content);
        $this->assertStringContainsString('### Usage Examples', $content);
        $this->assertStringContainsString('### Best Practices', $content);
    }

    #[Test]
    public function boost_guidelines_contains_code_snippets()
    {
        $guidelinesPath = __DIR__.'/../resources/boost/guidelines/core.blade.php';
        $content = File::get($guidelinesPath);

        $this->assertStringContainsString('php artisan make:action', $content);
        $this->assertStringContainsString('<code-snippet', $content);
        $this->assertStringContainsString('@verbatim', $content);
    }

    #[Test]
    public function boost_guidelines_references_package_features()
    {
        $guidelinesPath = __DIR__.'/../resources/boost/guidelines/core.blade.php';
        $content = File::get($guidelinesPath);

        $this->assertStringContainsString('app/Actions', $content);
        $this->assertStringContainsString('handle', $content);
        $this->assertStringContainsString('config/make-action.php', $content);
        $this->assertStringContainsString('method_name', $content);
    }
}
