<?php

class Logbook {

    function ShowLogbook() {
        global $db;

        $template = file_get_contents("views/logbookscripts.tpl");
        $template .= file_get_contents("views/logbooktable.tpl");

        $query = "SELECT * FROM logbook ORDER BY logid DESC";
        $results = $db->get_results($query);

        $logbookrows = "";
        foreach($results as $row) {
            $logbookrows .= "<tr>"
                    . "<td>" . $row['datetime'] . "</a></td>"
                    . "<td>" . $row['message'] . "</td>"
                    . "<td></td>"
                    . "</tr>";
        }

        $template = str_replace("{LogbookRows}", $logbookrows, $template);
        return $template;
    }

    function GetProjectsData() {
        global $db;

        $template = file_get_contents("views/nodestable.tpl");

        $query = "SELECT * FROM projects";
        $results = $db->get_results($query);

        $projectrows = "";
        foreach($results as $row) {
            $task = new Tasks;
            $percdone = $task->DonePercentage($row['projid']);

            if($percdone == 100) {
                $active = "";
                $color = " progress-bar-success";
                $style = "";
            } else {
                $active = " active";
                $color = "";
                $style = " progress-striped";
            }


            $projectrows .= "<tr>"
                    . "<td><a href='index.php?controller=projects&view=details&projid=" . $row['projid'] . "'>" . $row['projid'] . "</a></td>"
                    . "<td>" . $row['name'] . "</td>"
                    . "<td>" . $percdone . "% "
                    . "<div class='progress" . $style . $active . "' style='width: 200px'>"
                    . "<div class='progress-bar" . $color . "' role='progressbar' aria-valuenow='" . $percdone . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $percdone . "%'>"
                    . "<span class='sr-only'>" . $percdone . "% Complete</span>"
                    . "</div>"
                    . "</div>"
                    . "</td>"
                    . "<td>" . $this->LastFrameThumb($row['projid']) . "</td>"
                    . "</tr>";
        }

        $template = str_replace("{ProjectRows}", $projectrows, $template);
        return $template;
    }

}

?>
