<?php

namespace AdrianBrown\Mixable;

use AdrianBrown\Mixable\Concerns\ForwardsScopedCalls;
use Closure;
use InvalidArgumentException;

trait Mixin
{
    use ForwardsScopedCalls;

    protected $macroableInstance;

    public static function mix($macroables = null): void
    {
        $macroables = collect()
            ->wrap((new static())->macroable ?? '')
            ->merge(collect()->wrap($macroables ?? []))
            ->merge(collect()->wrap((new static())->macroables ?? []))
            ->filter();

        $mixin = get_called_class();

        foreach ($macroables as $macroable) {
            if (is_subclass_of($mixin, $macroable)) {
                $mixinTrait = Mixin::class;
                $mixableTrait = Mixable::class;

                throw new InvalidArgumentException(
                    "Cannot mixin [{$mixin}] because it is a subclass of [{$macroable}]. Instead of the [{$mixinTrait}] trait, use the [{$mixableTrait}] trait."
                );
            }

            Mixer::mixin($mixin, $macroable, fn () => $mixin::newMixableInstance($this));
        }
    }

    public static function newMixableInstance($macroableInstance)
    {
        return tap(new self(), fn ($mixin) => $mixin->macroableInstance = $macroableInstance);
    }

    public function newMacroableInstance()
    {
        return $this->macroableInstance;
    }

    protected function inScope(Closure $callback)
    {
        return Mixer::invade($this->macroableInstance, $callback);
    }

    public function __get($attribute)
    {
        if (in_array($attribute, ['macroable', 'macroables'])) {
            return [];
        }

        return $this->inScope(fn () => $this->{$attribute});
    }

    public function __set($attribute, $value)
    {
        $this->inScope(fn () => $this->{$attribute} = $value);
    }

    public function __call($method, $parameters)
    {
        return $this->forwardDecoratedCallTo($this->macroableInstance, $method, $parameters);
    }

    public static function __callStatic($method, $parameters)
    {
        $mixin = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1)[0]['object'];

        return Mixer::invade($mixin, fn () => $this->{$method}(...$parameters));
    }
}
