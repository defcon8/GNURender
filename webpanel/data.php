<?php

//Pre requirements
error_reporting(E_ALL);
ini_set('display_errors', 'on');
require_once("includes/config.inc");
require_once("includes/class.tasks.php");
require_once("includes/class.projects.php");
require_once("includes/class.nodes.php");
require_once("includes/class.movies.php");
require_once("includes/class.user.php");
require_once("includes/class.logbook.php");
require_once("includes/class.db.php");
require_once("includes/class.settings.php");
require_once("includes/class.screen.php");
require_once("includes/class.trigger.php");
require_once("includes/class.triggers.php");
require_once("includes/class.nodemanager.php");
require_once("includes/class.projectstats.php");

//Globals
$db = new DB();
$user = new User();
$screen = new Screen();

//GUI Controler & View stuff
$controller = (isset($_GET["controller"]) ? $_GET["controller"] : "projects");
$view = (isset($_GET["view"]) ? $_GET["view"] : "overview");

$render = "{Content}";

$controlleroutput = @file_get_contents("views/" . $controller . $view . ".tpl");
$render = str_replace("{Content}", $controlleroutput, $render);

include("controllers/" . $controller . ".php");

//Purge Language strings
include("lang/language_" . $user->language . ".inc");

echo $render;
?>
