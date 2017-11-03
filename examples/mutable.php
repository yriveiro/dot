<?php

require __DIR__ . '/../vendor/autoload.php';

use Yriveiro\Dot\Dot;

/**
 * This example aims show how to use Dot in a general way.
 */

$dot = new Dot(['server' => ['host' => 'localhost', 'port' => 5000]]);

$conf1 = $dot->set('api-endpoint', '/api/v1/');
$conf2 = $dot->set('api-endpoint', '/api/v2/');

/**
 * Conf1 and conf2 point to the same object $dot
 */
echo 'Conf 1: ' . $conf1->get('api-endpoint'). PHP_EOL;
echo 'Conf 2: ' . $conf2->get('api-endpoint') . PHP_EOL;
echo 'Dot : ' . $dot->get('api-endpoint') . PHP_EOL;
