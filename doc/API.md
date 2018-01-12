# API

This document describes the anatomy of the Dot API.

There is three main classes, Dot, the intance builder, `DotInmutable` and `DotMutable`, that implements the methods listed in this file.

## Dot

This is a builder class that offers two sugar syntax methods to create an instance of Dot.

The utilization of this class is not mandatory.

### create(array $data, bool $inmutable = false) : DotInterface

This **static** method took a array of data and returns the repective data as a Dot instance.

##### Parameters

* `data`: data to bootstrap de Dot instance.
* `inmutable`: if true, will create an inmutable instance of Dot.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

### loadJson(string $data, bool $inmutable = false) : DotInterface

This **static** method took a json encoded string and returns the repective data as a Dot instance.

##### Parameters
* `data`: a json encoded string and return the repective data as a Dot instance.
* `inmutable`: if true, will creat\ne an inmutable instance of Dot.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

## DotMutable

This class implements all the methods defined into `DotInterface` in a mutable way.

This class uses the `DotTrait` also. This trait defines methods tha are common between `DotMutable` and`DotInmutable` classes.

### set(string $path, $value) : DotInterface

This method set a value using the given path.

##### Parameters

* `path`: the path where we will store de value.
* `value`: the value to be stored.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

### delete(string $path) : DotInterface

This method deletes a the given path.

##### Parameters

* `path`: the path where we will delete.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

### reset() : DotInterface

Wipes all data inside Dot data storage.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

## DotInmutable

This class implements all the methods defined into `DotInterface` in an imutable way. This means that every change done into Dot instance will return a new Dot intance and not self.

This class also uses the `DotTrait` to borrow the implementation of common methods with `DotMutable`.

### set(string $path, $value) : DotInterface

This method set a value using the given path.

##### Parameters

* `path`: the path where we will store de value.\b
* `value`: the value to be stored.

### delete(string $path) : DotInterface

This method deletes a the given path.

##### Parameters

* `path`: the path where we will delete.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

### reset() : DotInterface

Wipes all data inside Dot data storage.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

## DotTrait

This trait implements common methods independently Dot be configured as mutable or inmutable.


### get(string $path, $default = null) : DotInterface
### contains(string $path) : bool
### toJson(string $path = null, int $flags = 0) : string
### getIterator() : ArrayIterator
