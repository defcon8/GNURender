<?php

class Tasks {

    function StateDescription($stateid) {
        $description = "";

        switch($stateid) {
            case 0:
                $description = "{TASK_STAT_0}";
                break;
            case 1:
                $description = "{TASK_STAT_1}";
                break;
            case 2:
                $description = "{TASK_STAT_2}";
                break;
            case 3:
                $description = "{TASK_STAT_3}";
                break;
        }
        return $description;
    }

    function StateColor($stateid) {
        $color = "";

        switch($stateid) {
            case 0:
                $color = "";
                break;
            case 1:
                $color = "active";
                break;
            case 2:
                $color = "success";
                break;
            case 3:
                $color = "danger";
                break;
        }
        return $color;
    }

    function GetData($taskid, $contenttype, $filename) {
        global $db;

        $query = "SELECT dataid FROM tasks WHERE taskid = " . $taskid;
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
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Content-Transfer-Encoding: binary ");
        header("Content-type: " . $contenttype);
        echo $data;
    }

    function TypeDescription($typeid) {

        switch($typeid) {
            case 0:
                $output = "Frame";
                break;
            case 1:
                $output = "Movie";
                break;
        }

        return $output;
    }

    function ShowTasks($projid = 'all') {
        global $db;

        $template = file_get_contents("views/taskstable.tpl");

        if($projid == "all") {
            $query = "SELECT * FROM tasks ORDER BY taskid DESC";
        } else {
            $query = "SELECT * FROM tasks WHERE projid = " . $projid . " ORDER BY taskid DESC";
        }

        $results = $db->get_results($query);

        $taskrows = "";
        foreach($results as $row) {
            $taskrows .= "<tr onClick='javascript:showTaskDetails(" . $row['taskid'] . ");' class='" . $this->StateColor($row['state']) . "'>"
                    . "<td>" . $row['taskid'] . "</td>"
                    . "<td>" . $this->TypeDescription($row['type']) . "</td>"
                    . "<td>" . $row['framenr'] . "</td>"
                    . "<td>" . $this->StateDescription($row['state']) . "</td>"
                    . "<td>" . $row['node'] . "</td>"
                    . "</tr>";
        }

        $template = str_replace("{TaskRows}", $taskrows, $template);

        return $template;
    }

    function DonePercentage($projid) {

        global $db;

        $query = "SELECT count(*) as total FROM tasks WHERE projid = " . $projid;
        $data = $db->get_results($query);
        $total = $data[0]['total'];

        $query = "SELECT count(*) as total FROM tasks WHERE projid = " . $projid . " AND (state = 2 OR state = 3)";
        $data = $db->get_results($query);
        $done = $data[0]['total'];
        if($done > 0) { //division by zero protection
            $percentage = round((100 * $done) / $total);
        } else {
            $percentage = 0;
        }
        return $percentage;
    }

    function ReRender($taskid) {

        global $db;

        $query = "SELECT dataid FROM tasks WHERE taskid = " . $taskid;
        $data = $db->get_results($query);
        $dataid = $data[0]['dataid'];

        if($dataid == NULL) {
            
        } else {
            $query = "DELETE FROM data WHERE dataid = " . $dataid;
            $db->query($query);
        }

        $query = "UPDATE tasks SET dataid=NULL, procoutput='',state=0,node=NULL WHERE taskid=" . $taskid;
        $db->query($query);
    }

    function DeleteTask($taskid) {

        global $db;

        $query = "SELECT dataid FROM tasks WHERE taskid = " . $taskid;
        $data = $db->get_results($query);
        $dataid = $data[0]['dataid'];

        if($dataid == NULL) {
            
        } else {
            $query = "DELETE FROM data WHERE dataid = " . $dataid;
            $db->query($query);
        }

        $query = "DELETE FROM tasks WHERE taskid=" . $taskid;
        $db->query($query);
    }

    function ShowTaskDetails($taskid) {
        global $db;

        $template = file_get_contents("views/taskdetails.tpl");

        $query = "SELECT * FROM tasks WHERE taskid = " . $taskid;
        $results = $db->get_results($query);

        $framenr = -1;
        $projid = -1;
        $dataid = -1;
        $imgdata = "";

        foreach($results as $row) {
            $framenr = $row['framenr'];
            $state = $row['state'];
            $type = $row['type'];
            $projid = $row['projid'];
            $dataid = $row['dataid'];
            $node = $row['node'];
            $procoutput = $row['procoutput'];
        }

        $template = str_replace("{FrameNr}", $framenr, $template);
        $template = str_replace("{ProjId}", $projid, $template);
        $template = str_replace("{TaskId}", $taskid, $template);
        $template = str_replace("{Node}", $node, $template);
        $template = str_replace("{ProcOutput}", $procoutput, $template);

        switch($type) {

            case 0:
                //Image
                if($dataid > -1) {
                    $query = "SELECT data FROM data WHERE dataid = " . $dataid;
                    $results = $db->get_results($query);
                    foreach($results as $row) {
                        $imgdata = $row['data'];
                    }
                    $template = str_replace("{ImgData}", "<img src='data:image/png;base64," . base64_encode($imgdata) . "'/>", $template);
                } else {
                    $template = str_replace("{ImgData}", "Image not rendereded.", $template);
                }
                $downloadlink = "data.php?controller=tasks&view=data&action=getimage&taskid=" . $taskid;
                break;
            case 1:
                //Movie
                if($state == 2) {
                    $template = str_replace("{ImgData}", "Movie rendered! Use the download button under the 'control' tab.", $template);
                } else {
                    $template = str_replace("{ImgData}", "Movie not rendereded.", $template);
                }
                $downloadlink = "data.php?controller=tasks&view=data&action=getmovie&taskid=" . $taskid;
                break;
        }

        $template = str_replace("{FrameNr}", $framenr, $template);
        $template = str_replace("{ProjId}", $projid, $template);
        $template = str_replace("{TaskId}", $taskid, $template);
        $template = str_replace("{Node}", $node, $template);
        $template = str_replace("{ProcOutput}", $procoutput, $template);
        $template = str_replace("{DownloadLink}", $downloadlink, $template);

        return $template;
    }

}

?>
