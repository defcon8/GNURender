<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    case "auth":
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['pwd'] = $_POST['pwd'];
        break;
    case "bye":
        session_destroy();
        break;
}

//Generate View
switch(@$_GET['view']) {
    
}
?>
