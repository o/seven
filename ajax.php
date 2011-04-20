<?php
require 'lib/Autoloader.php';
Autoloader::register();
$browser = new \Seven\Browser();
echo $browser->dispatch();