# Dot. Dotted access made simple

Dot has a simple goal, give you a dictionary like structure that you can query using dotted syntax.

[![Build Status](https://travis-ci.org/yriveiro/dot.svg?branch=master)](https://travis-ci.org/yriveiro/dot)
[![Coverage Status](https://coveralls.io/repos/github/yriveiro/dot/badge.svg?branch=master)](https://coveralls.io/github/yriveiro/dot?branch=master)

# API

### fromJson(string $data) : Dot

This **static** method took a json encoded string and returns the repective data as a Dot instance.

##### Parameters
* `data`: a json encoded string and return the repective data as a Dot instance.

### toJson(string $path = null, $flags = 0)

This method returns the given key as json.

##### Parameters

* `path`: the path we wan't to get as json, if null is passed will return all data.
* `flags`: the flags that PHP json_encode function accept.


### get(string $path, $default = null)

This method return the value of a given path, if the path doesn't exists will return the default value.

##### Parameters
* `path`: the path to be retrieve.
* `default`: the default value in the case of path doesn't exists.


### contains(string $path) : bool

This method checks if a given path exists into Dot.

##### Parameters
* `path`: the path to find.


### set(string $path, $value) : Dot

This method set a value using the given path, if Dot structure is initialize as inmutable every time a path is set a new instance is returned.

##### Parameters

* `path`: the path where we will store de value.
* `value`: the value to be stored.

# Usage

Dot works in two modes: **mutable** and **inmutable**.

The **mutable** mode is the default mode, and most probably the right mode to use in 90% of the uses cases. In this mode, all set operations are done over the same instance of Dot.

```php
$dot = new Yriveiro\Dot();
$dot->set('foo.bar', ['a', 'b', 'c']);

var_dump($dot->get('foo.bar.2'));
var_dump($dot->get('foo.bar'));

>>> result: 'c'
>>> result: ['a', 'b', 'c']

// as mutable, Dot has the followed behavior

$objectA = $dot->set('foo.bar', []);

var_dump($dot->get('foo.bar');
var_dump($objectA->get('foo.bar');

// $objectA and $dot are the same instance.
>>> result: []
>>> result: []
```

The **inmutable** mode aims to allow Dot to be shared between instance objects without side effects. In PHP, objects are passed to methods by reference by default.

```php
$dot = new Yriveiro\Dot([], true);

// first difference, you allways need to store the return
$dot = $dot->set('foo.bar', ['a', 'b', 'c']);

var_dump($dot->get('foo.bar.2'));
var_dump($dot->get('foo.bar'));

>>> result: 'c'
>>> result: ['a', 'b', 'c']

// as inmutable, Dot has the followed behavior

$objectA = $dot->set('foo.bar', ['a'];
$objectB = $dot->set('foo.bar', ['b'];

var_dump($objectA->get('foo.bar');
var_dump($objectB->get('foo.bar');
var_dump($dot->get('foo.bar');

// $objectA, $objectB and $dot are different instance.
>>> result: ['a']
>>> result: ['b']
>>> result: ['a', 'b', 'c']

```

It's possible also, initialize Dot with an array if necessary:

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
