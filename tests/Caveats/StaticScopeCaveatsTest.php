<?php

namespace AdrianBrown\Mixable\Tests\Caveats;

use AdrianBrown\Mixable\Mixin;
use AdrianBrown\Mixable\Tests\Support\TestMe;

test('problem: static::class gives the mixin class name', function () {
    $mixin = new class () {
        use Mixin;

        public function mixinGetClassName()
        {
            return static::class;
        }
    };
    $mixin->mix(TestMe::class);
    expect(TestMe::hasMacro('mixinGetClassName'))->toBe(true);
    $testMe = TestMe::new();

    tap($testMe->mixinGetClassName(), function ($result) use ($mixin, $testMe) {
        expect($result)->toBe($mixin::class);
        expect($result)->not->toBe(TestMe::class);
    });
});

test('solution: static::class gives the macroable class name with these solutions', function () {
    ($mixin = new class () {
        use Mixin;

        public string $macroable = TestMe::class;

        public function invadeSolution()
        {
            return $this->invade(fn () => static::class);
        }

        public function noStaticKeywordSolution()
        {
            return TestMe::class;
        }

        public function getClassOnMacroableInstanceSolution()
        {
            return get_class($this->macroableInstance);
        }
    })->mix();

    collect([
        'invadeSolution',
        'noStaticKeywordSolution',
        'getClassOnMacroableInstanceSolution',
    ])->each(fn ($method) => tap(TestMe::new()->{$method}(), function ($result) use ($mixin) {
        expect($result)->toBe(TestMe::class);
        expect($result)->not->toBe($mixin::class);
    }));
});
