<?php
namespace Yriveiro\Dot;

use ArrayIterator;
use IteratorAggregate;
use RuntimeException;
use InvalidArgumentException;
use JsonSerializable;

class Dot implements DotInterface, JsonSerializable, IteratorAggregate
{
    const MAGIC = 0xCAFE;

    /**
     * Internal storage.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Indicates if Dot is configured as inmutable or mutable mode.
     *
     * @var bool
     */
    protected $inmutable;

    /**
     * Constructor.
     *
     * @param array $data      If not emtpy it will boostrap Dot with the given data.
     * @param bool  $inmutable If true Dot will work as inmutable structure.
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
        $keys = explode('.', $path);
        $data = $this->data;

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return $default;
            }

            $data = $data[$key];
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value): DotInterface
    {
        $keys = explode('.', $path);

        if ($this->inmutable) {
            return $this->setInmutable($keys, $value);
        }

        return $this->setMutable($keys, $value);
    }

    private function setInmutable(array $keys, $value): DotInterface
    {
        $data = $this->data;
        $chunk = &$data;

        while (count($keys) > 0) {
            if (1 !== count($keys)) {
                $key = array_shift($keys);

                if (!isset($chunk[$key])) {
                    $chunk[$key] = [];
                }

                $chunk = &$chunk[$key];

                continue;
            }

            $chunk[array_shift($keys)] = $value;
        }

        return new static($data);
    }

    private function setMutable(array $keys, $value): DotInterface
    {
        $chunk = &$this->data;

        while (count($keys) > 0) {
            if (1 !== count($keys)) {
                $key = array_shift($keys);

                if (!isset($chunk[$key])) {
                    $chunk[$key] = [];
                }

                $chunk = &$chunk[$key];

                continue;
            }

            $chunk[array_shift($keys)] = $value;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function contains(string $path): bool
    {
        $check = crc32(self::MAGIC . random_int(0, 10000));

        return ($this->get($path, $check) !== $check);
    }

    /**
     * {@inheritdoc}
     */
    public static function fromJson(string $data): DotInterface
    {
        $data = json_decode($data, true);

        if (is_null($data)) {
            throw new RuntimeException('json_decode returns: '.json_error(json_last_error()));
        }

        return new static($data);
    }

    /**
     * {@inheritdoc}
     */
    public function toJson(string $path = null, int $flags = 0): string
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
     * Implmentation of ArrayIterator interface.
     *
     * @return \ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
