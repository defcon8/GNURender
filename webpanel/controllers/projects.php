<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    case "submit":
        SaveResourceFile();
        break;
    case "delete":
        DeleteProject();
        break;
    case "lastframethumb":
        LastFrameThumb(@$_GET['projid']);
        break;
    case "retryfailed":
        RetryFailed(@$_GET['projid']);
        break;
    case "renderavi":
        RenderAVI(@$_GET['projid']);
        break;
}

//Generate View
switch(@$_GET['view']) {
    default:
    case "overview":
        $projects = new Projects;
        $template = $projects->GetProjectsData();
        $render = str_replace("{ProjectsTable}", $template, $render);
        break;
    case "data":
        $projects = new Projects;
        $render = $projects->GetProjectsData();
        break;
    case "details":
        $projects = new Projects;
        $template = $projects->ShowProjectDetails(@$_GET['projid']);
        $render = str_replace("{ProjectDetails}", $template, $render);
        break;
    case "add":
        break;
    case "empty":
        break;
}

function RenderAVI($projid) {
    global $db;
    $sql = "INSERT INTO tasks (type,application,parameters,state,framenr,projid,sourcefile,outputfile,format) VALUES (1,'ffmpeg','-f image2 -i {inputfiles} -r 24 {outputfile}',0,0," . $projid . ",'0','','')";
    $db->query($sql);
}

function LastFrameThumb($projid) {
    $projects = new Projects;
    $projects->LastFrameResource($projid);
}

function RetryFailed($projid) {
    $projects = new Projects;
    $projects->RetryFailed($projid);
}

function SaveResourceFile() {
    if($_FILES["resourcefile"]["error"] > 0) {
        echo "Error: " . $_FILES["resourcefile"]["error"] . "<br>";
    } else {
        global $db;

        $resourcedata = file_get_contents($_FILES['resourcefile']['tmp_name']);
        $resourcefilename = $_FILES["resourcefile"]["name"];

        $name = $_POST["name"];
        $frames = $_POST["frames"];
        $format = $_POST["format"];
        $engine = $_POST["engine"];
        $script = $_POST["renderscript"];
        $filesize = $_FILES['resourcefile']['size'];

        //store data
        $sql = "INSERT INTO data (data) VALUES ('" . mysql_escape_string($resourcedata) . "')";
        $results = $db->query($sql);
        $dataid = $db->lastid();

        //generate project
        $sql = "INSERT INTO projects (resourcedataid,resourcefilename,name,frames,resourcesize,script) VALUES ('" . $dataid . "', '" . $resourcefilename . "','" . $name . "', '" . $frames . "','" . $filesize . "','" . mysqli_real_escape_string($db->getlink(), $script) . "')";
        $results = $db->query($sql);

        //get project id
        $projid = $db->lastid();

        //Set Engine
        switch($engine) {
            default:
            case "Undefined (project default)":
                $engine = "";
                break;
            case "Blender Render":
                $engine = "-E BLENDER_RENDER ";
                break;
            case "Blender Game":
                $engine = "-E BLENDER_GAME ";
                break;
            case "Cycles":
                $engine = "-E CYCLES ";
                break;
        }

        //generate tasks
        $framenumbers = explode("-", $frames);
        for($framenr = $framenumbers[0]; $framenr <= $framenumbers[1]; $framenr++) {
            $sql = "INSERT INTO tasks (type,application,parameters,state,framenr,projid,sourcefile,outputfile,format) VALUES (0,'blender','" . $engine . "-b \$sourcefile -o \$outputfile -F \$format -x 1 -s \$prevframe -e \$framenr -a',0," . $framenr . "," . $projid . ",'" . $resourcefilename . "','frame-','" . $format . "')";
            //$sql="INSERT INTO tasks (type,application,parameters,state,framenr,projid,sourcefile,outputfile,format) VALUES (0,'blender','-b \$sourcefile -o \$outputfile ".$engine."-F \$format -x 1 -f \$framenr',0,".$framenr.",".$projid.",'".$resourcefilename."','frame-','".$format."')";
            $results = $db->query($sql);
        }
    }
}

function DeleteProject() {
    global $db;
    $projid = $_GET["projid"];

    //Find task data
    $sql = "SELECT dataid FROM tasks WHERE projid = " . $projid;
    $results = $db->get_results($sql);

    foreach($results as $row) {
        if($row['dataid'] != NULL) {
            $sql = "DELETE FROM data WHERE dataid = " . $row['dataid'];
            $db->query($sql);
        }
    }

    //Resource data
    $sql = "SELECT resourcedataid FROM projects WHERE projid = " . $projid;
    $results = $db->get_results($sql);

    foreach($results as $row) {
        if($row['resourcedataid'] != NULL) {
            $sql = "DELETE FROM data WHERE dataid = " . $row['resourcedataid'];
            $db->query($sql);
        }
    }

    //Delete Tasks
    $sql = "DELETE FROM tasks WHERE projid = " . $projid;
    $db->query($sql);



    //Delete Project
    $sql = "DELETE FROM projects WHERE projid = " . $projid;
    $db->query($sql);
}

?>
