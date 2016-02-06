<?php

require 'config.php';
require 'constants.php';
require 'autoloader.php';

$default_actions = array(
    'list' => array(
        'name' => 'Lister'
      ),
    /*'search' => array(
        'name' => 'Rechercher'
      ),*/
    'add' => array(
        'name' => 'Ajouter'
      ),
    /*'edit' => array(
        'name' => 'Modifier'
      ),
    'delete' => array(
        'name' => 'Supprimer'
      ),*/
  );

$g_modules = array(
    'ranking' => array(
        'name' => 'Classements',
        'actions' => array(
            'SD' => array('name' => 'Simple Dames'),
            'SH' => array('name' => 'Simple Hommes'),
            'DX' => array('name' => 'Double Mixte'),
            'DD' => array('name' => 'Double Dames'),
            'DH' => array('name' => 'Double Hommes'),
          )
      ),
    'set' => array(
        'name' => 'Sets',
        'actions' => $default_actions,
      ),
    'player' => array(
        'name' => 'Joueurs',
        'actions' => $default_actions,
      ),
  );

// define current module

$modules_codes_list = array_keys($g_modules);
$g_current_module = $modules_codes_list[0];

if (isset($_GET['module']) && in_array($_GET['module'], $modules_codes_list))
  $g_current_module = $_GET['module'];

// define current action

$g_actions = $g_modules[$g_current_module]['actions'];
$actions_codes_list = array_keys($g_actions);
$g_current_action = $actions_codes_list[0];

if (isset($_GET['action']) && in_array($_GET['action'], $actions_codes_list))
  $g_current_action = $_GET['action'];


// remove magic quotes if necessary

if (get_magic_quotes_gpc()) {
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][stripslashes($k)] = $v;
                $process[] = &$process[$key][stripslashes($k)];
            } else {
                $process[$key][stripslashes($k)] = stripslashes($v);
            }
        }
    }
    unset($process);
}


// processing page

Session::start();
Database::open();

$g_method = $_SERVER['REQUEST_METHOD'];

if ($g_method == 'GET')
{
  require 'header.php';
  require 'menu.php';
}

$filename_to_include = 'app/'.$g_current_module.'/'.$g_current_action.'_'.strtolower($g_method).'.php';

if (!file_exists($filename_to_include))
  echo "<p class=\"error\">File '".$filename_to_include."' does not exists</p>";
else
  require $filename_to_include;

if ($g_method == 'GET')
  require 'footer.php';

Database::close();