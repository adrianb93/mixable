# Mixable

This package provides cleaner mixins for Laravel's `Macroable` classes.

## Installation

You can install the package via composer:

```bash
composer require adrianb93/mixable
```

## Usage

There are two traits available in this package, `Mixin` and `Mixable`. Each can make its public methods available to `Macroable` classes.

- `Mixin` is for a plain PHP class. It's public methods are mixed in to the `Macroable`'s of your choosing.
- `Mixable` is for subclasses of a `Macroable`. When used, the public methods defined in the subclass will be mixed into the parent macroable.

**Scope Behaviours:**

- When `$this` is returned, the macroable instance will be returned.
- Getting attributes like `$this->example` will get from the macroable instance within its scope.
- Setting attributes like `$this->example = 'code'` will set on the macroable instance within its scope.
- Calls like `$this->example()` will be forwarded to the macroable instance within its scope.
- Static calls like `static::make()` will be forwarded to the macroable instance within its scope.

**Scope Caveats:**

- `static::class` will give the mixin's class.
- Passing an attribute by reference will give a PHP warning due to indirect getting and setting. For example, the following collection mixin example has a PHP function which accepts a value, `$this->items`, by reference:
  ```php
  array_walk($this->items, fn ($item) => $item);
  ```
  To avoid a runtime warning, copy the value like so:
  ```php
  $items = $this->items;
  array_walk($items, fn ($item) => $item['status'] = 'some mutation');
  $this->items = $items;
  ```

### Mixin

Here is an example mixin. It must use the `AdrianBrown\Mixable\Mixin` trait.

```php
namespace App\Mixins;

use AdrianBrown\Mixable\Mixin;

class LoggerMixin
{
    use Mixin;

    public function info($context = [])
    {
        $message = match (true) {
            method_exists($this, 'toSql') => $this->toSql(),
            method_exists($this, 'toArray') => $this->toArray(),
            default => $this,
        };

        logger()->info($message, $context);

        return $this;
    }
}
```

The package will throw an exception if the mixin is a subclass of the macroable. It will instruct you to use `Mixable` instead.

### Mixable

`Mixable` differs from a `Mixin` in that the class extends what is being macro'd. The public methods in the mixable will be mixed into the parent class.

Here is an example mixable. It must use the `AdrianBrown\Mixable\Mixable` trait.

```php
namespace App\Models\Collections;

use AdrianBrown\Mixable\Mixable;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Collection extends EloquentCollection
{
    use Mixable;

    public function whereBelongsTo($related, $relationshipName = null)
    {
        ...

        return $this;
    }
}
```

The package will throw an exception if the mixable is not a subclass of the macroable. It will instruct you to use `Mixin` instead.

### Applying Mixins

Both `Mixin` and `Mixable` add a static function called `mix()`. In your `AppServiceProvider` call the `mix()` function on each class which uses the traits.

```php
use App\Mixins\LoggerMixin;

public function register()
{
    LoggerMixin::mix(Collection::class);

    // or

    LoggerMixin::mix([
        Builder::class,
        Request::class,
        Collection::class,
    ]);
}
```

You can also keep the macroables inside the class which uses the `Mixin` trait if you wish to do so. All you would need to do in `AppServiceProvider` is:

```php
public function register()
{
    LoggerMixin::mix();
}
```

...and the mixin can hold the macroables it applies itself to:

```php
class LoggerMixin
{
    use Mixin;

    public $macroable = Collection::class;

    // or

    public $macroable = [
        Builder::class,
        Request::class,
        Collection::class,
    ];

    ...
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Adrian Brown](https://github.com/adrianb93)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
