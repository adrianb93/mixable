<?php

namespace AdrianBrown\Mixable\Tests;

test('problem: $this is an instance of the mixin meaning you are not passing the macroable elsewhere', function () {
    $this->markTestIncomplete('do better');
});

test('problem: $this is an instance of the mixable subclass meaning you are not passing the macroable parent instance elsewhere', function () {
    $this->markTestIncomplete('do better');
});

test('solution: for mixins you can use the `inScope` callback so that $this is an instance of the macroable', function () {
    $this->markTestIncomplete('do better');
});

test('solution: for mixables you can use the `inScope` callback so that $this is an instance of the macroable parent', function () {
    $this->markTestIncomplete('do better');
});

test('solution: the mixin was not called from the mixin instance, then the return value will be the macroable instead of the mixin', function () {
    $this->markTestIncomplete('do better');
});
