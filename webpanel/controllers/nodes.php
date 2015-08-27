<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    case "forget":
        $nodes = new Nodes();
        $nodes->forget($_GET['id']);
        DIE(); // This is an AJAX call.. no need to output visible stuff to callback.
        break;
        
}

switch(@$_POST['action']) {
    case "add":
        $nodes = new Nodes();
        $nodes->add($_POST['name'],$_POST['host'],$_POST['port'],$_POST['user'],$_POST['pass'],$_POST['path'],$_POST['os']);
        break;
}


//Generate View
switch(@$_GET['view']) {
    default:
    case "overview":
        $nodes = new Nodes;
        $render = str_replace("{NodesBlocks}", $nodes->ShowNodes(), $render);
        break;
    case "install":
        $nodemanager = new NodeManager();
        $nodemanager->install("10.1.1.191","root","inter00",22,"/opt/test");
        $installlog = $nodemanager->readLog();
        $render = str_replace("{InstallLog}", $installlog, $render);
        break;
}
?>
