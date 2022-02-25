<?php

namespace AdrianBrown\Mixable\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \AdrianBrown\Mixable\Mixable
 */
class Mixable extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'mixable';
    }
}
