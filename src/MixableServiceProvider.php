<?php

namespace AdrianBrown\Mixable;

use AdrianBrown\Mixable\Commands\MixableCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
