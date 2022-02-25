<?php

namespace AdrianBrown\Mixable;

use InvalidArgumentException;

trait Mixable
{
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
        return resolve(get_called_class());
    }

    public function newMacroableInstance()
    {
        return $this;
    }
}
