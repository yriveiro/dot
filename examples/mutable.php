<?php

require __DIR__ . '/../vendor/autoload.php';

use Yriveiro\Dot\Dot;

/**
 * This example aims to show how to use Dot in a general way.
 *
 * Notes:
 *
 *  - In this example we are using a mutable instance of Dot object, conf1, conf2
 *    and dot point to the same instance.
 */

$dot = Dot::create(['server' => ['host' => 'localhost', 'port' => 5000]]);

$conf1 = $dot->set('api-endpoint', '/api/v1/');
$conf2 = $dot->set('api-endpoint', '/api/v2/');

/**
 * Conf1 and conf2 point to the same object $dot
 */
echo 'Conf 1: ' . $conf1->get('api-endpoint'). PHP_EOL;
echo 'Conf 2: ' . $conf2->get('api-endpoint') . PHP_EOL;
echo 'Dot : ' . $dot->get('api-endpoint') . PHP_EOL;
