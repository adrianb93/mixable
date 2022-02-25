<?php

namespace AdrianBrown\Mixable\Tests\Support;

use AdrianBrown\Mixable\Mixable;
use Illuminate\Support\Collection as BaseCollection;

/** @var \Illuminate\Support\Collection $this */

class CollectionMixable extends BaseCollection
{
    use Mixable;
    use TransposeCollectionMethod;

    protected static function newMixableInstance(BaseCollection $parent): self
    {
        return self::make($parent->all());
    }

    public function newMacroableInstance(): BaseCollection
    {
        return BaseCollection::make($this->items);
    }
}
