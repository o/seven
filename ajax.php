<?php
require 'lib/Autoloader.php';
Autoloader::register();

$browser = new Seven\Browser();

$log = $browser->getRepositoryLog(0, NULL, NULL, 10);
$parser = new Seven\LogParser($log);
$parser->parse();
