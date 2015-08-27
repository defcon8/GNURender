<?php

class User {

    public $userid;
    public $fullname;
    public $language;
    public $user;
    public $password;
    public $email;

    function __construct() {
        session_start();
        $validuser = false;

        if(isset($_POST['user']) && isset($_POST['pwd'])) {
            $_SESSION['user'] = $_POST['user'];
            $_SESSION['pwd'] = $_POST['pwd'];
        }

        if(isset($_SESSION['user']) && isset($_SESSION['pwd'])) {
            $validuser = $this->IsValidUser($_SESSION['user'], $_SESSION['pwd']);
        }
        if(!$validuser) {
            $this->ShowLogin();
        } else {
            switch(@$_GET['action']) {
                case "bye":
                    session_destroy();
                case "auth":
                    echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
                    exit;
                    break;
            }
            $this->LoadUserSettings();
        }
    }

    function LoadUserSettings() {
        global $db;
        $result = $db->get_results("SELECT * FROM users WHERE name = '" . $_SESSION['user'] . "'");
        foreach($result as $row) {
            $this->userid = $row['userid'];
            $this->fullname = $row['fullname'];
            $this->language = $row['lang'];
            $this->user = $row['name'];
            $this->password = $row['pwd'];
            $this->email = $row['email'];
        }
    }

    function IsValidUser($user, $pass) {
        global $db;
        $result = $db->get_results("SELECT * FROM users WHERE name = '" . $user . "' AND pwd = '" . $pass . "'");

        $found = false;

        foreach($result as $row) {
            $found = true;
        }
        return $found;
    }

    function ShowLogin() {
        global $db;
        $template = file_get_contents("views/loginoverview.tpl");
        $loginscreen = file_get_contents("views/loginscreen.tpl");
        $template = str_replace("{LoginScreen}", $loginscreen, $template);
        echo $template;
        exit;
    }

}

?>
