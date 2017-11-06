<?php
namespace Yriveiro\Dot;

interface DotInterface
{
    /**
     * Creates a Dot instace using json data as input.
     *
     * @param string $data json encoded data
     *
     * @return Yriveiro\Dot
     *
     * @throws RuntimeException
     */
    public static function fromJson(string $data) : Dot;

    /**
     * Gets the value of a given path, if the path doesn't exists and default
     * value is configured, the default value is returned.
     *
     * @param string $path          path where the value is stored.
     * @param null | mixed $default default value to be returned in case the
     *                              path doesn't exists.
     * @return mixed
     */
    public function get(string $path, $default = null);

    /**
     * Sets the valeu in a given path
     *
     * @param string $path path where the value will be stored.
     * @param mixed $value value that will be store.
     *
     * @return Yriveiro\Dot
     *
     * @throws InvalidArgumentException
     */
    public function set(string $path, $value) : Dot;

    /**
     * Checks if a given path exists into Dot.
     *
     * @param string $path path we are looking for.
     *
     * @return boolean
     *
     * @throws InvalidArgumentException
     */
    public function contains(string $path) : bool;


    /**
     * Return the given path as json data.
     *
     * @param null | string $path path we want as json.
     * @param int $flag           PHP json flags.
     *
     */
    public function toJson(string $path = null, int $flags = 0) : string;
}
