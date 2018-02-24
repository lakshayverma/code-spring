<?php
// Web site constants
defined('DS')           ? null : define('DS', DIRECTORY_SEPARATOR);
//defined('SITE_ROOT')    ? null : define('SITE_ROOT', 'C:'.DS.'wamp'.DS.'www'.DS.'code_spring');
defined('SITE_ROOT')    ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT'].DS.'code_spring');
defined('LIB_PATH')     ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
defined('SITE_TITLE')   ? null : define('SITE_TITLE', "Code Springs");
defined('SITE_MOTO')   ? null : define('SITE_MOTO', "Manage your code.");
// load configuration file
require_once(LIB_PATH.DS."config.php");

// load basic functions
require_once(LIB_PATH.DS."functions.php");

// load core objects
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."database_object.php");

// load database-related classes
require_once(LIB_PATH.DS."department.php");
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."client.php");
require_once(LIB_PATH.DS."project.php");
require_once(LIB_PATH.DS."task.php");
require_once(LIB_PATH.DS."comment.php");
?>