<?php

namespace AdrianBrown\Mixable\Tests;

use AdrianBrown\Mixable\Mixin;
use AdrianBrown\Mixable\Tests\Support\CollectionMixin;
use AdrianBrown\Mixable\Tests\Support\TransposeCollectionMethod;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

it('does not add the macro to the macroable if mix is not called', function () {
    expect(Collection::hasMacro('transpose'))->toBe(false);
});

it('adds the macro to the macroable via mix(string)', function () {
    CollectionMixin::mix(Collection::class);

    expect(Collection::hasMacro('transpose'))->toBe(true);
});

it('adds the macro to the macroable via mix(array)', function () {
    CollectionMixin::mix([
        Collection::class,
    ]);

    expect(Collection::hasMacro('transpose'))->toBe(true);
});

it('adds the macro to the macroable via mix() where the mixin has $macroable = string', function () {
    $mixin = new class () {
        use Mixin;
        use TransposeCollectionMethod;

        public $macroable = Collection::class;
    };

    $mixin->mix();

    expect(Collection::hasMacro('transpose'))->toBe(true);
});

it('adds the macro to the macroable via mix() where the mixin has $macroable = array', function () {
    $mixin = new class () {
        use Mixin;
        use TransposeCollectionMethod;

        public $macroable = [Collection::class];
    };

    $mixin->mix();

    expect(Collection::hasMacro('transpose'))->toBe(true);
});

it('adds the macro to the macroable via mix() where the mixin has $macroables = string', function () {
    $mixin = new class () {
        use Mixin;
        use TransposeCollectionMethod;

        public $macroables = Collection::class;
    };

    $mixin->mix();

    expect(Collection::hasMacro('transpose'))->toBe(true);
});

it('adds the macro to the macroable via mix() where the mixin has $macroables = array', function () {
    $mixin = new class () {
        use Mixin;
        use TransposeCollectionMethod;

        public $macroables = [Collection::class];
    };

    $mixin->mix();

    expect(Collection::hasMacro('transpose'))->toBe(true);
});

it('adds the macro to the macroable via mix() where the mixin has $macroable and $macroables', function () {
    $mixin = new class () {
        use Mixin;
        use TransposeCollectionMethod;

        public $macroable = Collection::class;
        public $macroables = [EloquentCollection::class];
    };

    $mixin->mix();

    expect(Collection::hasMacro('transpose'))->toBe(true);
    expect(EloquentCollection::hasMacro('transpose'))->toBe(true);
});

it('works', function () {
    CollectionMixin::mix(Collection::class);

    $collection = Collection::make([
        [0, 1],
        [0, 1],
        [0, 1],
    ]);

    expect($collection)->toBeInstanceOf(Collection::class);

    $transposed = $collection->transpose();

    expect($transposed)->toBeInstanceOf(Collection::class);

    expect($transposed->toArray())->toBe([
        [0, 0, 0],
        [1, 1, 1],
    ]);
});

it('will affect the macroable instance when calling methods', function () {
    $mixin = (new class () {
        use Mixin;

        public function mixinPush($item)
        {
            $test = $this->push($item);
            $callToProtectedMethod = $test->sortByMany();

            // Because it returned $this (collection $this), but our forwarded call retutned the decorator (mixin $this)
            expect($test)->toBeInstanceOf($this::class);

            // However, if it returned static::make() the decorator is not returned because it is not the same instance as the macroable.
            expect($callToProtectedMethod)->toBeInstanceOf(Collection::class);

            return $this;
        }
    });

    $mixin->mix(Collection::class);

    $collection = Collection::make(['a']);
    $resultA = $collection->mixinPush('2');
    $resultB = $collection->push('d');

    // Even though we return the decorator, the macro will detect this and return the macroable instance for userland.
    expect($resultA)->toBeInstanceOf(Collection::class);
    expect($resultB)->toBeInstanceOf(Collection::class);
    expect($resultA)->not->toBeInstanceOf($mixin::class);
    expect($resultB)->not->toBeInstanceOf($mixin::class);
    expect($collection->toArray())->toBe(['a', '2', 'd']);
});

it('will forward static calls to the macroable', function () {
    $this->markTestIncomplete('do better');
});

it('will get attributes from the macroable', function () {
    $this->markTestIncomplete('do better');
});

it('will set attributes on the macroable', function () {
    $this->markTestIncomplete('do better');
});

it('does not macro private methods', function () {
    $this->markTestIncomplete('do better');
});

it('does not macro protected methods', function () {
    $this->markTestIncomplete('do better');
});

it('does not macro static private methods', function () {
    $this->markTestIncomplete('do better');
});

it('does not macro static protected methods', function () {
    $this->markTestIncomplete('do better');
});

it('does not macro static public methods', function () {
    $this->markTestIncomplete('do better');
});

it('does not get static attributes on the macroable via the mixin class', function () {
    $this->markTestIncomplete('do better');
});

it('does not set static attributes on the macroable via the mixin class', function () {
    $this->markTestIncomplete('do better');
});

it('will return a value that is not the macroable or the mixin', function () {
    $this->markTestIncomplete('do better');
});

it('will return the mixin instance if the macroable returned $this', function () {
    $this->markTestIncomplete('do better');
});

it('will return the macroable object if it is not the same instance as the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can forward calls to public methods on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can forward calls to protected methods on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can forward calls to private methods on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can get public attributes on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can get protected attributes on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can get private attributes on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can set public attributes on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can set protected attributes on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('the mixin can set private attributes on the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('caveat: static::class will give the mixin class (has solutions)', function () {
    $this->markTestIncomplete('do better');
});

test('caveat solution: static::class will give the macroable class if you do it in $this->invade(...)', function () {
    $this->markTestIncomplete('do better');
});

test('caveat: by reference functions will cause PHP to warn about indirect attribute changes via magic methods (has solutions)', function () {
    $this->markTestIncomplete('do better');
});

test('caveat solution: PHP warning for indirect attribute changes via magic methods will not happen if you do it in $this->invade(...)', function () {
    $this->markTestIncomplete('do better');
});

test('caveat solution: PHP warning for indirect attribute changes via magic methods will not happen if you copy the variable', function () {
    $this->markTestIncomplete('do better');
});
