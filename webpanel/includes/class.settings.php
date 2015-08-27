<?php

class Settings {

    function ShowSettings() {

        global $render;
        global $db;
        $userstable = file_get_contents("views/userstable.tpl");

        $query = "SELECT * FROM users";
        $results = $db->get_results($query);

        $usersrows = "";
        foreach($results as $row) {
            $usersrows .= "<tr>"
                    . "<td>" . $row['userid'] . "</td>"
                    . "<td>" . $row['name'] . "</td>"
                    . "<td>" . $row['level'] . "</td>"
                    . "</tr>";
        }

        $render = str_replace("{UsersTable}", $userstable, $render);
        $render = str_replace("{UsersRows}", $usersrows, $render);

        return $render;
    }

    function SaveProfile() {
        global $db;
        global $user;
        $sql = "UPDATE users SET fullname='" . $_POST['fullname'] . "', name='" . $_POST['user'] . "', pwd='" . $_POST['password'] . "', email='" . $_POST['email'] . "', lang='" . $_POST['language'] . "' WHERE userid = " . $user->userid;
        $db->query($sql);
        echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
    }

    function ShowProfile() {

        global $render;
        global $user;
        global $db;

        $query = "SELECT * FROM users WHERE userid = " . $user->userid;
        $results = $db->get_results($query);

        $usersrows = "";
        foreach($results as $row) {
            $render = str_replace("{UserName}", $row['name'], $render);
            $render = str_replace("{FullName}", $row['fullname'], $render);
            $render = str_replace("{Password}", $row['pwd'], $render);
            $render = str_replace("{EMail}", $row['email'], $render);
            $render = str_replace("{Language}", $row['lang'], $render);
            $mylang = $row['lang']; //for select box
        }

        //language selectbox
        $languageselect = "<select id='language' name='language' class='input-xlarge'>";

        foreach(array("EN", "NL") as $language) {
            if($language == $mylang) {
                $selected = " selected";
            } else {
                $selected = "";
            }
            $languageselect .= "<option" . $selected . ">" . $language . "</option>";
        }

        $languageselect .= "</select>";

        $render = str_replace("{LangSelect}", $languageselect, $render);

        return $render;
    }

}

?>
