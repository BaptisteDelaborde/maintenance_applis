<?php
require __DIR__ . '/../vendor/autoload.php';

$config = App\Config::getInstance();
echo 'debug = ' . ($config->get('debug') ? 'true' : 'false') . "\n";

$config2 = App\Config::getInstance();
echo 'Même instance : ' . ($config === $config2 ? 'oui' : 'non') . "\n";