<?php

namespace AdrianBrown\Mixable;

use InvalidArgumentException;

trait Mixable
{
    protected $macroableInstance;

    public static function mix(?string $macroable = null): void
    {
        $mixin = get_called_class();
        $macroable ??= get_parent_class($mixin);

        if (! is_subclass_of($mixin, $macroable)) {
            $mixinTrait = Mixin::class;
            $mixableTrait = Mixable::class;

            throw new InvalidArgumentException(
                "Cannot mixin [{$mixin}] because it is not a subclass of [{$macroable}]. Instead of the [{$mixableTrait}] trait, use the [{$mixinTrait}] trait."
            );
        }

        MixinHelper::mixin($mixin, $macroable, fn () => $mixin::newMixableInstance($this));
    }

    protected static function newMixableInstance($parent)
    {
        // Idea:
        // - Default is new mixable instance without constructor: https://www.php.net/manual/en/reflectionclass.newinstancewithoutconstructor.php
        // - Copy the properties that exist in the $parent to the mixable instance
        // - Set `$mixable->macroableInstance = $parent` on the mixin so that we can do the reverse on out
        // Fallback?
        // - This is the "in" method - do as you wish to make an instance of the mixable subclass.

        return tap(resolve(get_called_class()), function ($mixable) use ($parent) {
            $mixable->macroableInstance = $parent;
            $mixable->bootMixable();
        });
    }

    public function newMacroableInstance()
    {
        // Idea:
        // - Given we have `$mixable->macroableInstance`
        // - Copy the mixable's class properties to the macroable's class properties if it exists there.
        // - `return $this->macroableInstance;` given the state is the same as the mixable's.
        // Fallback?
        // - This is the "out" method - do as you wish to return the macroable instance, or happily return the mixable subclass instance ($this).

        return $this;
    }

    public function bootMixable()
    {
    }
}
