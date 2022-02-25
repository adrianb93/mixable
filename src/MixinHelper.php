<?php

namespace AdrianBrown\Mixable;

use Closure;
use ReflectionClass;
use ReflectionMethod;

class MixinHelper
{
    public static function mixin(string $mixin, string $macroable, ?Closure $createMixinInstance = null): void
    {
        $createMixinInstance ??= fn () => resolve($mixin);

        $class = new ReflectionClass($mixin);
        $methods = collect($class->getMethods())
            ->filter(function (ReflectionMethod $method) use ($class) {
                return $method->isPublic()
                    && $method->isStatic() === false
                    && $method->isAbstract() === false
                    && $class->getName() === $method->getDeclaringClass()->getName()
                    && in_array($method->getName(), ['newMacroableInstance', 'newMixableInstance']) === false;
            })
            ->map->getName();

        foreach ($methods as $method) {
            $macroable::macro($method, function (...$args) use ($method, $createMixinInstance) {
                /** @phpstan-ignore-next-line */
                $mixin = $createMixinInstance->call($this);
                $result = call_user_func([$mixin, $method], ...$args);
                $resultIsMixin = $result === $mixin && in_array(Mixin::class, class_uses($mixin));
                $resultIsMixable = $result === $mixin && in_array(Mixable::class, class_uses($mixin));

                return $resultIsMixin || $resultIsMixable ? $result->newMacroableInstance() : $result;
            });
        }
    }

    /** @return mixed */
    public static function invade(null|string|object $target, Closure $callback)
    {
        if ($target === null) {
            $callback = Closure::bind($callback, null, null);
        } else {
            $target = is_object($target) ? $target : resolve($target);
            $callback = Closure::bind($callback, $target, get_class($target));
        }

        return $callback($target);
    }
}
