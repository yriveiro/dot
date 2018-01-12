<?php
namespace Yriveiro\Dot;

use RuntimeException;
use Yriveiro\Dot\DotInterface;

class Dot
{
    /**
     * Factory method that returns a Dot instance that inmplements DotInterface.
     *
     * @param array $data      initial data to bootstrap Dot
     * @param bool  $inmutable dot will perform as inmutable structure if true,
     *                         the default value is false
     *
     * @return DotInterface
     */
    public static function create(array $data = [], bool $inmutable = false): DotInterface
    {
        return ($inmutable) ? new DotInmutable($data) : new DotMutable($data);
    }

    /**
     * Sugar syntax method to bootstrap a Dot instance with Json data that use
     * the Dot::create signature under the hood.
     *
     * This method provides Json data validation, if Json data is not valid, a
     * RuntimeException will be thrown with the json error as a message.
     *
     * @param string $json      Json encoded data
     * @param bool   $inmutable dot will perform as inmutable structure if true,
     *                          the default value is false
     *
     * @return DotInterface
     *
     * @throws RuntimeException
     */
    public static function loadJson(string $json, bool $inmutable = false): DotInterface
    {
        $data = json_decode($json, true);

        if (is_null($data)) {
            throw new RuntimeException(
                'json_decode fails due: ' . json_error(json_last_error())
            );
        }

        return self::create($data, $inmutable);
    }
}
