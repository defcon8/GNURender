<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    
}

//Generate View
switch(@$_GET['view']) {
    default:
    case "overview":
        $logbook = new Logbook;
        $template = $logbook->ShowLogbook();
        $render = str_replace("{LogbookTable}", $template, $render);
        break;
    case "data":
    //$projects = new Projects;
    //$render = $projects->GetProjectsData();
    //break;
    case "details":
    //$projects = new Projects;
    //$template = $projects->ShowProjectDetails(@$_GET['projid']);
    //$render = str_replace("{ProjectDetails}",$template,$render);
    //break;	
}
?>
