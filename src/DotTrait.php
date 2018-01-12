<?php
namespace Yriveiro\Dot;

use RuntimeException;
use ArrayIterator;
use Yriveiro\Dot\DotInterface;

trait DotTrait
{
    /**
     * Internal storage.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Gets the value of a given path, if the path doesn't exists and default
     * value is configured, the default value is returned.
     *
     * @param string       $path    path where the value is stored
     * @param null | mixed $default default value to be returned in case the
     *                              path doesn't exists
     *
     * @return mixed
     */
    public function get(string $path, $default = null)
    {
        $data = $this->data;
        $keys = explode('.', $path);

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return $default;
            }

            $data = $data[$key];
        }

        return $data;
    }

    /**
     * Checks if a given path exists inside Dot storage.
     *
     * @param string $path path we are looking for
     *
     * @return bool
     */
    public function contains(string $path): bool
    {
        $check = crc32(DotInterface::MAGIC . random_int(0, 10000));

        return $this->get($path, $check) !== $check;
    }

    /**
     * Returns the given path as Json data.
     *
     * @param null | string $path  path we want as Json data.
     * @param int           $flags PHP json flags.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    public function toJson(string $path = null, int $flags = 0) : string
    {
        if (is_null($path)) {
            return json_encode($this, $flags);
        }

        $data = json_encode($this->get($path), $flags);

        if ($data === false) {
            // @codeCoverageIgnoreStart
            throw new RuntimeException(
                "$path fails json_encode, error:" . json_error(json_last_error())
            );
            // @codeCoverageIgnoreEnd
        }

        return $data;
    }

    /**
     * Implementation of PHP's JsonSerializable Interface.
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * Implementation of PHP's ArrayIterator interface.
     *
     * @return \ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
