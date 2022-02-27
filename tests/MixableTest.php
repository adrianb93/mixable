<?php

namespace AdrianBrown\Mixable\Tests;

use AdrianBrown\Mixable\Mixable;
use AdrianBrown\Mixable\Tests\Support\CollectionMixable;
use Illuminate\Support\Collection;

it('works', function () {
    CollectionMixable::mix();

    $parentCollection = Collection::make([
        [0, 1],
        [0, 1],
        [0, 1],
    ]);
    $extendCollection = CollectionMixable::make([
        [0, 1],
        [0, 1],
        [0, 1],
    ]);

    expect($parentCollection)->toBeInstanceOf(Collection::class);
    expect($extendCollection)->toBeInstanceOf(CollectionMixable::class);

    $parentCollectionTransposed = $parentCollection->transpose();
    $extendCollectionTransposed = $extendCollection->transpose();

    expect($parentCollectionTransposed)->toBeInstanceOf(Collection::class);
    expect($extendCollectionTransposed)->toBeInstanceOf(CollectionMixable::class);

    expect($parentCollectionTransposed->toArray())->toBe([
        [0, 0, 0],
        [1, 1, 1],
    ]);
    expect($extendCollectionTransposed->toArray())->toBe([
        [0, 0, 0],
        [1, 1, 1],
    ]);
});

it('does not add the macros to the class it extends if `mix()` is not called', function () {
    expect(Collection::hasMacro('transpose'))->toBe(false);

    CollectionMixable::mix();

    expect(Collection::hasMacro('transpose'))->toBe(true);
});

it("creates the subclass instance using the macroable parent class instance's state", function () {
    ($mixable = new class () extends Collection {
        use Mixable;

        protected static function newMixableInstance($parent): self
        {
            // The parent comes in.
            test()->expect($parent)->toBeInstanceOf(Collection::class);
            test()->expect($parent->toArray())->toBe(['a', 'b', 'c']);

            // New mixable instance.
            return self::make([1, 2, 3]);
        }

        public function newMacroableInstance(): Collection
        {
            // New parent instance out from mixable values.
            return Collection::make($this->items);
        }

        public function example()
        {
            expect($this->toArray())->toBe([1, 2, 3]);

            return $this;
        }
    })->mix();

    // macroable in / macroable out
    $result = collect(['a', 'b', 'c'])->example()->push('d');

    expect($result->toArray())->toBe([1, 2, 3, 'd']);
    expect($result)->toBeInstanceOf(Collection::class);
    expect($result)->not->toBeInstanceOf(get_class($mixable));
});

it("returns the macroable instance with it's state updated to be the same as the mixable subclass state", function () {
    $this->markTestIncomplete('do better');
});

test('the mixable interacts with itself', function () {
    $this->markTestIncomplete('do better');
});

test("the parent macroable instance's state is not affected within the mixable subclass", function () {
    $this->markTestIncomplete('do better');
});

test('can pull state from the macroable to the mixable', function () {
    // only class attribute keys on the macroable are pulled from
    // private attributes are pulled
    // protected attributes are pulled
    // public attributes are pulled
    $this->markTestIncomplete('do better');
});

test('can push state from the mixable to the macroable', function () {
    // only class attribute keys on the macroable are pushed to
    // private attributes are pushed
    // protected attributes are pushed
    // public attributes are pushed
    $this->markTestIncomplete('do better');
});

test('cannot pull state from the macroable to the mixable if the macroable is not set', function () {
    $this->markTestIncomplete('do better');
});

test('cannot push state from the mixable to the macroable if the macroable is not set', function () {
    $this->markTestIncomplete('do better');
});

test('returning a different mixable instance will not result in a swap of the return value to the macroable instance', function () {
    $this->markTestIncomplete('do better');
});

test('returning some primative value will not result in a swap of the return value to the macroable instance', function () {
    $this->markTestIncomplete('do better');
});

test('returning some primative value will still result in the macroable state being synced with the mixable state', function () {
    $this->markTestIncomplete('do better');
});

test("`inScope` sets the macroable parent instance's state going in, and sets the mixable subclass instance's state going out", function () {
    $this->markTestIncomplete('do better');
});

test('can implement a `bootMixable()` function to do something to the mixable after it is instantiated', function () {
    $this->markTestIncomplete('do better');
});
