<?php
namespace Yriveiro\Dot;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use InvalidArgumentException;
use JsonSerializable;
use Yriveiro\Dot\filter;
use Yriveiro\Dot\DotInterface;
use Yriveiro\Dot\explode;
use Yriveiro\Dot\json_error;

class Dot implements DotInterface, JsonSerializable, IteratorAggregate
{
    const FOUND = 0xCAFE;

    /**
     * Internal storage
     *
     * @var array
     */
    protected $data = [];

    /**
     * Indicates if Dot is configured as inmutable or mutable mode
     *
     * @var boolean
     */
    protected $inmutable;

    /**
     * Constructor
     *
     * @param array $data If not emtpy it will boostrap Dot with the given data
     * @param boolean $inmutable If true Dot will work as inmutable structure
     */
    public function __construct(array $data = [], $inmutable = false)
    {
        $this->data = $data;
        $this->inmutable = $inmutable;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $path, $default = null)
    {
        $keys = explode($path);

        if ($keys === false) {
            throw new InvalidArgumentException("error exploding path"); // @codeCoverageIgnore
        }

        return filter($this->data, $keys, $default);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value) : DotInterface
    {
        $keys = explode($path);

        if ($keys === false) {
            throw new InvalidArgumentException("error exploding path"); // @codeCoverageIgnore
        }

        if ($this->inmutable) {
            return $this->setInmutable($keys, $value);
        }

        return $this->setMutable($keys, $value);
    }

    private function setInmutable(array $keys, $value) : DotInterface
    {
        $data = $this->data;
        $chunk =& $data;

        while (count($keys) > 0) {
            if (count($keys) !== 1) {
                $key = array_shift($keys);

                if (!isset($chunk[$key])) {
                    $chunk[$key] = [];
                }

                $chunk =& $chunk[$key];

                continue;
            }

            $chunk[array_shift($keys)] = $value;
        }

        return new static($data);
    }


    private function setMutable(array $keys, $value) : DotInterface
    {
        $chunk =& $this->data;

        while (count($keys) > 0) {
            if (count($keys) !== 1) {
                $key = array_shift($keys);

                if (!isset($chunk[$key])) {
                    $chunk[$key] = [];
                }

                $chunk =& $chunk[$key];

                continue;
            }

            $chunk[array_shift($keys)] = $value;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function contains(string $path) : bool
    {
        $keys = explode($path);

        if ($keys === false) {
            throw new InvalidArgumentException("error exploding path"); // @codeCoverageIgnore
        }

        $result = filter($this->data, $keys, self::FOUND);

        return ($result != self::FOUND);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromJson(string $data) : DotInterface
    {
        $data = json_decode($data, true);

        if (is_null($data)) {
            throw new RuntimeException('json_decode returns: ' . json_error(json_last_error()));
        }

        return new static($data);
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(string $path = null, int $flags = 0) : string
    {
        if (is_null($path)) {
            return json_encode($this, $flags);
        }

        return json_encode($this->get($path), $flags);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Implmentation of ArrayIterator interface
     *
     * @return \ArrayIterator
     */
    public function getIterator() : ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
