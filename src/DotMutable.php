<?php
namespace Yriveiro\Dot;

use IteratorAggregate;
use JsonSerializable;

class DotMutable implements DotInterface, JsonSerializable, IteratorAggregate
{
    use DotTrait;

    /**
     * Constructor.
     *
     * @param array $data if it's not emtpy it will boostrap Dot with the
     *                    given data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value): DotInterface
    {
        $keys = explode('.', $path);
        $chunk = &$this->data;

        while (count($keys)) {
            $key = array_shift($keys);
            $chunk = &$chunk[$key];
        }

        $chunk = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): DotInterface
    {
        $this->data = [];

        return $this;
    }

    public function delete(string $path): DotInterface
    {
        $keys = explode('.', $path);
        $chunk = &$this->data;

        while (count($keys) > 1) {
            $key = array_shift($keys);
            $chunk = &$chunk[$key];
        }

        $key = array_shift($keys);

        unset($chunk[$key]);

        return $this;
    }
}
