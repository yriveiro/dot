<?php

require __DIR__ . '/../vendor/autoload.php';

use Yriveiro\Dot\Dot;

/**
 * This example aims to show how to use Dot as a inmutable structure.
 *
 * Some times we need a stucture with some configuration that is shared
 * between objects.
 *
 * To prevent side effects (php objects are passed by reference to methods
 * by default) Dot allows you to create an inmutable structure that can be share
 * safely, ex: in a dependency injection container.
 */

$dot = Dot::create(['server' => ['host' => 'localhost', 'port' => 5000]], true);

$conf1 = $dot->set('api-endpoint', '/api/v1/');
$conf2 = $dot->set('api-endpoint', '/api/v2/');

echo 'Conf 1: ' . $conf1->get('api-endpoint'). PHP_EOL;
echo 'Conf 2: ' . $conf2->get('api-endpoint') . PHP_EOL;

