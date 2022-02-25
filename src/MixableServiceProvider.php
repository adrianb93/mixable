<?php

namespace AdrianBrown\Mixable;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AdrianBrown\Mixable\Commands\MixableCommand;

class MixableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('mixable')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_mixable_table')
            ->hasCommand(MixableCommand::class);
    }
}
