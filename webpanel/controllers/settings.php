<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    case "saveprofile":
        $settings = new Settings;
        $settings->SaveProfile();
        break;
}

//Generate View
switch(@$_GET['view']) {
    default:
    case "overview":
        $settings = new Settings;
        $template = $settings->ShowSettings();
        $render = $template;
        break;
    case "profile":
        $settings = new Settings;
        $template = $settings->ShowProfile();
        $render = $template;
        break;
}
?>
