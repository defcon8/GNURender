<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once("includes/config.inc");
require_once("includes/class.db.php");
require_once("includes/class.helper.php");

$db = new DB();
$helper = new Helper();

switch(@$_GET['action']) {
    case "lastrender":
        $helper->GetLastRender();
        break;
}
?>
