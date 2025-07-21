<?php

namespace Webteractive\MakeAction;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Webteractive\MakeAction\Commands\MakeActionCommand;

class MakeActionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('make-action')
            ->hasConfigFile()
            ->hasCommand(MakeActionCommand::class);
    }
}
