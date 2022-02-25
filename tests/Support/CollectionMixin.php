<?php

namespace AdrianBrown\Mixable\Tests\Support;

use AdrianBrown\Mixable\Mixin;

/** @var \Illuminate\Support\Collection $this */

class CollectionMixin
{
    use Mixin;
    use TransposeCollectionMethod;
}
