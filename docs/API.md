# API

This document describes the anatomy of Dot's API.

There is three main classes into Dot package, `Dot` the intance builder, `DotInmutable` and `DotMutable`.

## Dot

This is a builder class that offers two sugar syntax methods to create an instance of Dot.

### create(array $data, bool $inmutable = false) : DotInterface

This **static** method took a array of data and returns the repective data as a Dot instance.

##### Parameters

* `data`: data to bootstrap de Dot instance.
* `inmutable`: if true, will create an inmutable instance of Dot.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object depending on how inmutable flag is set.

### loadJson(string $data, bool $inmutable = false) : DotInterface

This **static** method took a json encoded string and returns the repective data as a Dot instance.

##### Parameters
* `data`: a json encoded string and return the repective data as a Dot instance.
* `inmutable`: if true, will creat\ne an inmutable instance of Dot.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object depending on how inmutable flag is set.

**Note:** The utilization of this class is not mandatory. If you want, you can have full controll using directly `DotMutable`or `DotInmutable`.

## DotMutable

This class implements all the methods defined into `DotInterface` in a mutable way.

This class uses the `DotTrait` also. This trait, defines methods that are common between `DotMutable` and`DotInmutable` classes.

### set(string $path, $value) : DotInterface

This method set a value using the given path.

##### Parameters

* `path`: the path where we will store de value.
* `value`: the value to be stored.

##### Return

* `DotInterface`: In this case, a `DotMutable` instance.

### delete(string $path) : DotInterface

This method deletes a the given path.

##### Parameters

* `path`: the path where we will delete.

##### Return

* `DotInterface`: In this case, a `DotMutable` instance.

### reset() : DotInterface

Wipes all data inside Dot data storage.

##### Return

* `DotInterface`: In this case, a `DotMutable` instance.

## DotInmutable

This class implements all the methods defined into `DotInterface` in an imutable way. This means that every change done into Dot instance will return a new Dot intance and not itself.

This class also uses the `DotTrait` to borrow the implementation of common methods with `DotMutable`, where no changes of state are done.

### set(string $path, $value) : DotInterface

This method set a value using the given path.

##### Parameters

* `path`: the path where we will store de value.
* `value`: the value to be stored.

##### Return

* `DotInterface`: In this case, a `DotInmutable` instance.

### delete(string $path) : DotInterface

This method deletes a given path from Dot.

##### Parameters

* `path`: the path where we will delete.

##### Return

* `DotInterface`: In this case, a `DotInmutable` instance.

### reset() : DotInterface

Wipes all data inside Dot's data storage.

##### Return

* `DotInterface`: can be an `DotMutable` or `DotInmutable` object.

## DotTrait

This trait implements common methods that not perform changes over internal state of Dot.

### get(string $path, $default = null)

This method gets the value of a given path, if not exists will return the default value.

##### Parameters

* `path`: the path that we want get
* `default`: the default value in case the path doesn't exists.

##### Return

* `Mixed`: the value stored in the given key.

### contains(string $path) : bool

This method checks if a given path exists inside Dot instance.

##### Parameters

* `path`: the path that we want know if exists inside Dot instance.

##### Return

* `bool`: true if exists, false otherwise.

### toJson(string $path = null, int $flags = 0)

This method does a json encode operation over the given path and return the value stored inside the path as JSON data.

##### Parameters

* `path`: the path that we want return as JSON data, the all object if the path is set equals to null.
* `flags`: this flags are the same flags supported by native PHP json_encode function.

##### Return

* `string | null`: a JSON encoded data, null in case the json_encode operation fails.

##### Throws

* `RuntimeException`

### getIterator() : ArrayIterator

This method is the implementation of the PHP `ArrayIterator` interface.

##### Return

* `ArrayIterator`: an instance of `ArrayIterator`
