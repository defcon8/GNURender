<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');
include_once("phpMyImporter.php");
if(@$_GET['step']) {
    $step = $_GET['step'];
} else {
    $step = 0;
}

echo "<!--<!DOCTYPE html>-->"
 . "<html lang='en'>"
 . "<head>"
 . "<meta content='text/html;charset=utf-8' http-equiv='Content-Type'>"
 . "<meta content='utf-8' http-equiv='encoding'>"
 . "<script src='../lib/jquery/js/jquery-1.10.2.js'></script>"
 . "<script src='../lib/bootstrap/js/bootstrap.min.js'></script>"
 . "<link href='../lib/bootstrap/css/bootstrap.min.css' rel='stylesheet'>"
 . "<link rel='stylesheet' type='text/css' href='../stylesheets/theme.css'>"
 . "<link rel='stylesheet' href='../lib/font-awesome/css/font-awesome.min.css'>"
 . "<title>GNURender Installer</title>"
 . "</head>"
 . "<body>"
 . "<div><img src='../images/logo.png'></div>";

switch($step) {
    default:
    case 0:
        // Check prerequisites
        echo "<div style='padding-left:15px;padding-top:15px;'>";
        echo "Checking prerequisities..<br>";
        echo "Filesystem access..<br>";
        $includedirwrite = is_writeable("../includes");
        if($includedirwrite) {
            echo "/includes <b>Writable!</b><br>";
        } else {
            echo "/includes <b>ERROR: NOT Writable!</b><br>";
            exit;
            break;
        }
        echo "Installed modules..<br>";
        if(extension_loaded("mysql")) {
            echo "PHP MySQL extension <b>Installed!</b><br>";
        } else {
            echo "PHP MySQL extension <b>ERROR: NOT Installed!</b><br>";
            exit;
            break;
        }
        if(extension_loaded("mysqli")) {
            echo "PHP MySQLi extension <b>Installed!</b><br>";
        } else {
            echo "PHP MySQLi extension <b>ERROR: NOT Installed!</b><br>";
            exit;
            break;
        }
        echo "Wait 5 seconds or click <a href='index.php?step=1'>here</a> to continue."
        . "</div><meta http-equiv='refresh' content='5; URL=index.php?step=1'>";
        exit;
    case 1:
        // User interrogation
        $template = file_get_contents("1.tpl");
        echo $template;
        break;
    case 2:
        // Installer
        //Create Connection
        $dbhost = $_POST['host'];
        $dbuser = $_POST['user'];
        $dbpass = $_POST['password'];
        $dbname = $_POST['database'];

        //Import structure
        $filename = "database.sql";
        $compress = false;
        $connection = @mysql_connect($dbhost, $dbuser, $dbpass);
        $dump = new phpMyImporter($dbname, $connection, $filename, $compress);
        $dump->utf8 = true;

        echo "<div style='padding-left:15px;padding-top:15px;'>";

        $success = $dump->doimport();

        if(!$success) {
            echo "<b>FAILED</b> to import database! Click <a href='javascript: history.go(-1)'>here</a> to go back and verify your information.";
            exit();
        }

        //Create admin user
        mysql_query("INSERT INTO users SET name = 'admin', pwd = '" . $_POST['adminpass'] . "', fullname='Administrator', lang='EN', level=0, email='" . $_POST['adminemail'] . "'");

        //Create config file for webpanel
        $newconfig = file_get_contents("config.tpl");
        $newconfig = str_replace("{DBHost}", $dbhost, $newconfig);
        $newconfig = str_replace("{DBUser}", $dbuser, $newconfig);
        $newconfig = str_replace("{DBPass}", $dbpass, $newconfig);
        $newconfig = str_replace("{DBName}", $dbname, $newconfig);
        $newconfig = str_replace("{AdminEMail}", $_POST['adminemail'], $newconfig);
        $fh = fopen("../includes/config.inc", 'w') or die("<b>ERROR:</b> Can't open file config file for writing!<br>");
        fwrite($fh, $newconfig);
        fclose($fh);

        echo "<br>"
        . "Don't forget to remove the /install directory from the webserver!!<br>"
        . "You can now proceed to the login panel: <a href='../index.php'>CLICK HERE</a>";

        echo "</div>";
        break;
}
?>
