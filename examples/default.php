<?php

require __DIR__ . '/../vendor/autoload.php';

use Yriveiro\Dot\Dot;

/**
 * This example aims is show how use default values.
 *
 * Notes:
 *
 *  - this example will create a mutable Dot instance.
 */

$data = [
    'server' => [
        'host' => 'localhost',
        'port' => 5000
    ],
    'timeout' => 3,
    'retries' => 5
];

$dot = Dot::create($data);

echo 'host: ' . $dot->get('server.host') . PHP_EOL;
echo 'retries: ' . $dot->get('retries') . PHP_EOL;
echo 'connection timeout: ' . $dot->get('connection-timeout', 10) . PHP_EOL;

echo PHP_EOL;
echo 'Full data: ' . PHP_EOL;
echo PHP_EOL;
echo json_encode($dot, JSON_PRETTY_PRINT);
