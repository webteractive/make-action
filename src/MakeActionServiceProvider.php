<?php

namespace Glen Bangkila\MakeAction;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Glen Bangkila\MakeAction\Commands\MakeActionCommand;

class MakeActionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('make-action')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_make_action_table')
            ->hasCommand(MakeActionCommand::class);
    }
}
