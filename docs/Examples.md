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

