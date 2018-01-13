<?php
namespace Yriveiro\Dot;

/**
 * This interface exposes the core method to be implement by a Dot instance.
 */
interface DotInterface
{
    const MAGIC = 0xDECAFE;

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
    public function get(string $path, $default = null);

    /**
     * Sets the value in a given path.
     *
     * @param string $path  path where the value will be stored
     * @param mixed  $value value that will be store
     *
     * @return DotInterface
     */
    public function set(string $path, $value): self;

    /**
     * Checks if a given path exists into Dot.
     *
     * @param string $path path we are looking for
     *
     * @return bool
     */
    public function contains(string $path): bool;

    /**
     * Wipe all data inside Dot storage.
     *
     * @return DotInterface
     */
    public function reset(): self;

    /**
     * Remove a key from Dot internal storage.
     *
     * @return DotInterface
     */
    public function delete(string $path): self;

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
    public function toJson(string $path = null, int $flags = 0) : string;
}
