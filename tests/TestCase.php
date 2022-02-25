<?php

namespace AdrianBrown\Mixable\Tests;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->beforeApplicationDestroyed(function () {
            Collection::flushMacros();
            EloquentCollection::flushMacros();
        });
    }
}
