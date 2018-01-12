<?php
namespace Yriveiro\Dot;

use IteratorAggregate;
use JsonSerializable;
use Yriveiro\Dot\DotInterface;

class DotInmutable implements DotInterface, JsonSerializable, IteratorAggregate
{
    use DotTrait;

    /**
     * Constructor.
     *
     * @param array $data if not emtpy it will boostrap Dot with the given data
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
        $chunk = $this->data;
        $data = &$chunk;

        while (count($keys)) {
            $key = array_shift($keys);
            $chunk = &$chunk[$key];
        }

        $chunk = $value;

        return new static($data);
    }

    /**
     * {@inheritdoc}
     */
    public function reset(): DotInterface
    {
        return new static([]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $path): DotInterface
    {
        $keys = explode('.', $path);
        $data = $this->data;
        $chunk = &$data;

        while (count($keys) > 1) {
            $key = array_shift($keys);
            $chunk = &$chunk[$key];
        }

        $key = array_shift($keys);

        unset($chunk[$key]);

        return new static($data);
    }
}
