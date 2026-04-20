<?php

namespace Webteractive\MakeAction\Commands;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

use function Laravel\Prompts\text;

use Illuminate\Filesystem\Filesystem;

class MakeActionCommand extends Command
{
    public $signature = 'make:action
        {name? : The name of the action class}
        {--target= : Target alias defined in config/make-action.php (targets.<alias>)}
        {--method= : The action method name (overrides config)}
        {--path= : The directory where the action should be generated (overrides config)}
        {--namespace= : The namespace for the action class (overrides config)}';

    public $description = 'Create a new action class';

    protected $files;

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle(): int
    {
        $name = $this->argument('name') ?? text(
            label: 'What should the action be named?',
            placeholder: 'E.g. CreateNewUser',
            required: true,
        );

        $className = Str::studly($name);

        if (! $this->isValidClassName($className)) {
            $this->error("Invalid action class name [{$name}]. Use a valid PHP class name.");

            return self::FAILURE;
        }

        $resolved = $this->resolveTargetConfig();

        if ($resolved === null) {
            return self::FAILURE;
        }

        $method = $resolved['method'];
        $namespace = $resolved['namespace'];
        $directory = $resolved['path'];

        if (! $this->isValidMethodName($method)) {
            $this->error("Invalid method name [{$method}].");

            return self::FAILURE;
        }

        if (! $this->isValidNamespace($namespace)) {
            $this->error("Invalid namespace [{$namespace}].");

            return self::FAILURE;
        }

        $path = rtrim($directory, '/\\').DIRECTORY_SEPARATOR.$className.'.php';

        // 🚫 No force support — always fail if exists
        if ($this->files->exists($path)) {
            $this->error('Action already exists.');
            $this->line("Path: {$path}");

            return self::FAILURE;
        }

        if (! $this->ensureDirectoryExists($directory)) {
            $this->error("Unable to create directory: {$directory}");

            return self::FAILURE;
        }

        $stubPath = __DIR__.'/../../stubs/action.stub';

        if (! $this->files->exists($stubPath)) {
            $this->error("Stub file not found: {$stubPath}");

            return self::FAILURE;
        }

        $stub = $this->files->get($stubPath);

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ method }}'],
            [$namespace, $className, $method],
            $stub
        );

        $this->files->put($path, $stub);

        $this->info('Action created successfully.');
        $this->info("Action path: {$path}");

        return self::SUCCESS;
    }

    protected function resolveTargetConfig(): ?array
    {
        $config = (array) config('make-action', []);
        $defaults = (array) Arr::get($config, 'default', []);

        $resolved = [
            'path' => $defaults['path'] ?? app_path('Actions'),
            'namespace' => $defaults['namespace'] ?? 'App\\Actions',
            'method' => $defaults['method'] ?? 'handle',
        ];

        if ($alias = $this->option('target')) {
            $targets = (array) Arr::get($config, 'targets', []);

            if (! array_key_exists($alias, $targets)) {
                $this->error("Unknown target alias [{$alias}].");

                $available = array_keys($targets);
                if ($available) {
                    $this->line('Available targets: '.implode(', ', $available));
                }

                return null;
            }

            $resolved = array_replace(
                $resolved,
                Arr::only((array) $targets[$alias], ['path', 'namespace', 'method'])
            );
        }

        if ($this->option('path')) {
            $resolved['path'] = $this->normalizePath((string) $this->option('path'));
        }

        if ($this->option('namespace')) {
            $resolved['namespace'] = trim((string) $this->option('namespace'), '\\');
        }

        if ($this->option('method')) {
            $resolved['method'] = (string) $this->option('method');
        }

        $resolved['path'] = rtrim((string) $resolved['path'], '/\\');
        $resolved['namespace'] = trim((string) $resolved['namespace'], '\\');
        $resolved['method'] = (string) $resolved['method'];

        return $resolved;
    }

    protected function normalizePath(string $path): string
    {
        $isAbsolute = str_starts_with($path, DIRECTORY_SEPARATOR)
            || (bool) preg_match('/^[A-Z]:\\\\/i', $path);

        if ($isAbsolute) {
            return rtrim($path, '/\\');
        }

        return base_path(trim($path, '/\\'));
    }

    protected function ensureDirectoryExists(string $path): bool
    {
        if ($this->files->isDirectory($path)) {
            return true;
        }

        try {
            return $this->files->makeDirectory($path, 0755, true);
        } catch (\Throwable) {
            return false;
        }
    }

    protected function isValidClassName(string $class): bool
    {
        return (bool) preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $class);
    }

    protected function isValidMethodName(string $name): bool
    {
        return (bool) preg_match('/^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/', $name);
    }

    protected function isValidNamespace(string $namespace): bool
    {
        $namespace = trim($namespace, '\\');

        return $namespace !== '' && (bool) preg_match(
            '/^(?:[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*\\\\)*[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$/',
            $namespace
        );
    }
}
