<?php

define('PHPUNIT_TESTING', TRUE);

// for Travis-CI, from http://stackoverflow.com/a/22695608/488666 
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . "/mylib");
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . "/mylib2");
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(dirname(__FILE__)) . "/lib");

if (file_exists('config.php'))
  include 'config.php';
else
  include 'config.php.sample'; // for Travis CI

include 'constants.php';
include 'autoloader.php';