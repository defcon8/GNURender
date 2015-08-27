<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    case "rerender":
        ReRender();
        break;
    case "delete":
        DeleteTask();
        break;
    case "getmovie":
        GetMovie();
        break;
    case "getimage":
        GetImage();
        break;
}

switch(@$_GET['view']) {
    default:
    case "overview":
        $tasks = new Tasks;
        $template = $tasks->ShowTasks();
        $render = str_replace("{TasksTable}", $template, $render);
        break;
    case "details":
        $tasks = new Tasks;
        $template = $tasks->ShowTaskDetails(@$_GET['taskid']);
        $render = str_replace("{TaskDetails}", $template, $render);
        break;
    case "pbar":
        $tasks = new Tasks;
        $template = $tasks->DonePercentage(@$_GET['projid']);
        $render = str_replace("{Percentage}", $template, $render);
    case "data":
        $render = "";
        break;
}

function ReRender() {
    $task = new Tasks();
    $task->ReRender(@$_GET['taskid']);
}

function DeleteTask() {
    $task = new Tasks();
    $task->DeleteTask(@$_GET['taskid']);
}

function GetMovie() {
    $task = new Tasks();
    $task->GetData(@$_GET['taskid'], "video/avi", @$_GET['taskid'] . ".avi");
}

function GetImage() {
    $task = new Tasks();
    $task->GetData(@$_GET['taskid'], "image/png", @$_GET['taskid'] . ".png");
}

?>
