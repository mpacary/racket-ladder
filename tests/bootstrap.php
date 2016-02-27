<?php

chdir(dirname(__FILE__).'/..');

define('PHPUNIT_TESTING', TRUE);

if (file_exists('config.php'))
  include 'config.php';
else
  include 'config.php.sample'; // for Travis CI

include 'constants.php';
include 'autoloader.php';