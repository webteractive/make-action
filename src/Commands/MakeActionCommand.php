<?php

namespace Webteractive\MakeAction\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

use function Laravel\Prompts\text;

use Illuminate\Filesystem\Filesystem;

class MakeActionCommand extends Command
{
    public $signature = 'make:action {name?}';

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

        $path = app_path('Actions/'.$className.'.php');
        $namespace = 'App\\Actions';

        if ($this->files->exists($path)) {
            $this->error('Action already exists!');

            return self::FAILURE;
        }

        $this->ensureDirectoryExists(app_path('Actions'));

        $stub = $this->files->get(__DIR__.'/../../stubs/action.stub');

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}', '{{ method }}'],
            [$namespace, $className, config('make-action.method_name', 'handle')],
            $stub
        );

        $this->files->put($path, $stub);

        $this->info('Action created successfully.');
        $this->info("Action path: {$path}");

        return self::SUCCESS;
    }

    protected function ensureDirectoryExists($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0755, true);
        }
    }
}
