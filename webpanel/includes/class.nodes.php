<?php

class Nodes {

    function add($name, $host, $port, $user, $pass, $path, $distro) {
        global $db;
        $sql = "INSERT INTO nodes SET name = '$name', host = '$host', port = '$port', user = '$user', pass = '$pass', path = '$path', distro = '$distro'";
        $db->query($sql);
    }

    function forget($id) {
        global $db;
        $sql = "DELETE FROM nodes WHERE nodeid = $id";
        $db->query($sql);
    }

    function update($id, $name, $host, $port, $user, $pass, $path, $distro) {
        global $db;
        $sql = "UPDATE nodes SET name = '$name', host = '$host', port = '$port', user = '$user', pass = '$pass', path = '$path', distro = '$distro' WHERE nodeid = $id";
        $db->query($sql);
    }

    function ShowNodes() {
        global $db;

        $query = "SELECT * FROM nodes ORDER BY touched DESC";
        $results = $db->get_results($query);

        $nodesrows = "";
        foreach ($results as $row) {
            $nodesrows .= "<div class='nodeblock' onClick='javascript:lastclickednode=".$row['nodeid'].";'>"
                    . "<div class='blockcontent'>"
                    . "<div class='nodename'>" . $row['name'] . "</div>"
                    . "<div class='nodeosname'>" . $row['osname'] . " " . $row['osbit'] ." Bit</div>"
                    . "<div class='nodetouched'>" . $row['touched'] . "</div>"
                    . "<div class='nodestate'>State: Idle</div>"
                    . "</div>"
                    . "</div>";
        }
        return $nodesrows;
    }

    function GetProjectsData() {
        global $db;

        $template = file_get_contents("views/nodestable.tpl");

        $query = "SELECT * FROM projects";
        $results = $db->get_results($query);

        $projectrows = "";
        foreach ($results as $row) {
            $task = new Tasks;
            $percdone = $task->DonePercentage($row['projid']);

            if ($percdone == 100) {
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
