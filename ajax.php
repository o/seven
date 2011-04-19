<?php
require 'lib/Autoloader.php';
Autoloader::register();

$browser = new Seven\Browser();
var_dump($browser->getRepositoryLog(0, NULL, NULL, 10));

?>
