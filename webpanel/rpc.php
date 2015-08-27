<?php

// Todo from config
date_default_timezone_set('Europe/Amsterdam');
setlocale(LC_ALL, 'nl_NL') or setlocale(LC_ALL, 'nld_NLD');

require_once("includes/config.inc");
require_once("includes/class.db.php");
require_once("includes/class.xmlrpc.php");
require_once("includes/class.task.php");
require_once("includes/class.binairydata.php");

//Globals
$db = new DB();

$xml_string = file_get_contents("php://input");
$xml  = simplexml_load_string($xml_string);
$json = json_encode($xml);
$input  = json_decode($json, true);


$xmlrpc = new XMLRPC();
$xmlrpc->init();

switch ($input['action']) {
    case "gettask":
        $xmlrpc->getTask();
        break;
    case "getscript":
        $xmlrpc->getScript();
        break;
    case "touchserver":
        $xmlrpc->touchServer();
        break;
    case "savelog":
        $xmlrpc->saveLog();
        break;
    case "getframerenderresources":
        $xmlrpc->getFrameRenderResources();
        break;
    case "savebinairydata":
        $xmlrpc->saveBinairyData();
        break;
    case "auth":
        $xmlrpc->getAuth();
        break;
    
}
echo $xmlrpc->prepare();
echo $xmlrpc->getXML();
?>
