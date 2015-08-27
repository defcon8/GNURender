<?php

class Helper {

    function GetLastRender() {
        global $db;

        $query = "SELECT dataid FROM tasks WHERE state = 2 and TYPE = 0 ORDER BY taskid DESC LIMIT 1";
        $results = $db->get_results($query);

        $dataid = NULL;
        foreach($results as $row) {
            $dataid = $row['dataid'];
        }

        if(!$dataid == NULL) {
            $query = "SELECT LENGTH(data) as length, data FROM data WHERE dataid = " . $dataid;
            $results = $db->get_results($query);

            foreach($results as $row) {
                $size = $row['length'];
                $data = $row['data'];
            }
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment; filename=lastrender.png");
        header("Content-Transfer-Encoding: binary ");
        header("Content-type: image/png");

        echo $data;
    }

}

?>
