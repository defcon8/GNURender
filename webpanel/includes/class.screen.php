<?php

class Screen {

    function SetLang($placeholder, $text) {
        global $render;
        $render = str_replace("{" . $placeholder . "}", $text, $render);
    }

}

?>
