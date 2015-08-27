<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    case "delete":
        deleteMovie();
        break;
    case "submit":
        CreateNewMovie();
        break;
}

$projid = (isset($_POST['projid']) ? $_POST['projid'] : $_GET['projid']);

//Generate View
switch(@$_GET['view']) {
    default:
    case "overview":
        
        $movies = new Movies;
        $render = $movies->ShowMovies($projid);
        break;
    case "create":
        $movies = new Movies;
        $template = $movies->ShowCreateForm();
        $template = str_replace("{ProjId}", $projid, $template);
        $render = str_replace("{MovieCreate}", $template, $render);
        break;
}

function CreateNewMovie() {
    $movies = new Movies();
    $movies->CreateMovie($_POST['projid'], $_POST['fps'], $_POST['codec'], $_POST['preset'], @$_POST['scale'], @$_POST['scalewidth'], @$_POST['scaleheight']);
}

function deleteMovie() {
    $movies = new Movies();
    $movies->deleteMovie($_GET['id']);
}


?>
