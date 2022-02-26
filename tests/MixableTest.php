<?php

namespace AdrianBrown\Mixable\Tests;

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
    $this->markTestIncomplete('do better');
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

test('returning a different mixable instance will not result in a swap of the return value to the macroable instance', function () {
    $this->markTestIncomplete('do better');
});

test('returning some primative value will not result in a swap of the return value to the macroable instance', function () {
    $this->markTestIncomplete('do better');
});

test('returning some primative value will still result in the macroable state being synced with the mixable state', function () {
    $this->markTestIncomplete('do better');
});

test("invade sets the macroable parent instance's state going in, and sets the mixable subclass instance's state going out", function () {
    $this->markTestIncomplete('do better');
});
