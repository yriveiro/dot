<?php
namespace Yriveiro\Dot;

use RuntimeException;
use InvalidArgumentException;
use JsonSerializable;
use Yriveiro\Dot\filter;
use Yriveiro\Dot\explode;
use Yriveiro\Dot\json_error;

class Dot implements JsonSerializable
{
    const FOUND = 0xCAFE;

    protected $data = [];

    protected $inmutable;

    public function __construct(array $data = [], $inmutable = false)
    {
        $this->data = $data;
        $this->inmutable = $inmutable;
    }

    public function get(string $path, $default = null)
    {
        if (empty($path)) {
            throw new InvalidArgumentException("path can't be empty");
        }

        $keys = explode($path);

        if ($keys === false) {
            throw new InvalidArgumentException("error exploding path"); // @codeCoverageIgnore
        }

        return filter($this->data, $keys, $default);
    }

    public function set(string $path, $value) : Dot
    {
        if (empty($path)) {
            throw new InvalidArgumentException("can't set data, path is empty");
        }

        $keys = explode($path);

        if ($keys === false) {
            throw new InvalidArgumentException("error exploding path"); // @codeCoverageIgnore
        }

        if ($this->inmutable) {
            return $this->setInmutable($keys, $value);
        }

        return $this->setMutable($keys, $value);
    }

    private function setInmutable(array $keys, $value) : Dot
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


    private function setMutable(array $keys, $value) : Dot
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

    public function contains(string $path) : bool
    {
        if (empty($path)) {
            throw new InvalidArgumentException("path can't be empty");
        }

        $keys = explode($path);

        if ($keys === false) {
            throw new InvalidArgumentException("error exploding path"); // @codeCoverageIgnore
        }

        $result = filter($this->data, $keys, self::FOUND);

        return ($result != self::FOUND);
    }

    public static function fromJson(string $data) : Dot
    {
        $data = json_decode($data, true);

        if (is_null($data)) {
            throw new RuntimeException('json_decode returns: ' . json_error(json_last_error()));
        }

        return new static($data);
    }

    public function jsonSerialize()
    {
        return $this->data;
    }
}
