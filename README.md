# Dot. Dotted access made simple

Dot has a simple goal, give you a dictionary like structure that you can query using dotted syntax.

# API

### __construct(array $data = [], $inmutable = false)

The constructor of Dot library.

##### Parameters
* `data`: you can bootstrap your Dot structure with existing data.
* `inmutable`: if true, every time you call set method, a new instance will be returned, useful when the structure is shared along multiples objects (more about this in the examples).


### fromJson(string $data) : Dot

This static method took a json encoded string and return the repective data as a Dot instance.

##### Parameters
* `data`: a json encoded string and return the repective data as a Dot instance.


### get(string $path, $default = null)

This method return the value of a given path, if the path doesn't exists will return the default value.

##### Parameters
* `path`: the path to be retrieve.
* `default`: the default value in the case of path doesn't exists.


### have(string $path) : bool

This method checks if a given path exists into Dot.

##### Parameters
* `path`: the path to find.


### set(string $path, $value) : Dot

This method set a value using the given path, if Dot structure is initialize as inmutable every time a path is set a new instance is returned.

##### Parameters

* `path`: the path where we will store de value.
* `value`: the value to be stored.

# Usage

As an empty structure:

```php
$dot = new Yriveiro\Dot();
$dot->set('foo.bar', ['a', 'b', 'c']);

var_dump($dot->get('foo.bar.2'));
var_dump($dot->get('foo.bar'));

>>> result: 'c'
>>> result: ['a', 'b', 'c']
```

The same but bootstraping the Dot instance at creation time:

```php
$dot = new Yriveiro\Dot(['foo' => ['bar' => ['a', 'b', 'c']]);

var_dump($dot->get('foo.bar.2'));
var_dump($dot->get('foo.bar'));

>>> result: 'c'
>>> result: ['a', 'b', 'c']
```

# Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/download/).

```sh
php composer.phar require "yriveiro/dot"
```

# Tests

Tests are performed using the `phpunit` library, to run them:

```sh
php vendor/bin/phpunit tests
```

# Know issues

None.

# How to contribute

Have an idea? Found a bug?, contributions are welcome :)

# License

Dot is licensed under MIT license.
