<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once("includes/config.inc");
require_once("includes/class.db.php");

$db = new DB();

//Delete nodes from the list that are older then 1 hour
$db->query("DELETE FROM nodes WHERE touched < (NOW() - INTERVAL 30 MINUTE)");
?>
