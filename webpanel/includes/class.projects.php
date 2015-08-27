<?php

class Projects {

    function LastFrameThumb($projid) {
        return "<img src='data.php?controller=projects&view=empty&action=lastframethumb&projid=" . $projid . "' width='100' height='100'>";
    }

    function LastFrameResource($projid) {
        global $db;

        $query = "SELECT dataid FROM tasks WHERE projid = " . $projid . " AND state = 2 AND type = 0 ORDER BY taskid DESC LIMIT 1";
        $results = $db->get_results($query);

        $dataid = NULL;
        foreach($results as $row) {
            $dataid = $row['dataid'];
        }

        if(!$dataid == NULL) {
            $query = "SELECT data FROM data WHERE dataid = " . $dataid;
            $results = $db->get_results($query);

            foreach($results as $row) {
                $im = imagecreatefromstring($row['data']);
            }
        } else {
            //Nothing rendered yet
            $im = imagecreatefromstring(file_get_contents("images/rendering.png"));
        }

        $desired_width = 50;
        $desired_height = 50;
        $new = imagecreatetruecolor($desired_width, $desired_height);
        $x = imagesx($im);
        $y = imagesy($im);
        imagecopyresampled($new, $im, 0, 0, 0, 0, $desired_width, $desired_height, $x, $y);
        imagedestroy($im);
        header("Content-type: image/jpeg");
        imagejpeg($new, null, 85);
    }

    function FrameOverview($projid) {
        global $db;

        $query = "SELECT taskid, state FROM tasks WHERE projid = " . $projid . " ORDER BY framenr ASC";
        $results = $db->get_results($query);

        $output = "<FONT style='font-family: Terminal, monospace'>";
        $count = 0;

        foreach($results as $row) {
            if($count == 60) {
                $count = 0;
                $output.="<br>";
            }
            $output .= "<a href='index.php?controller=tasks&view=details&taskid=" . $row['taskid'] . "'>" . $this->AsciState($row['state']) . "</a>";
            $count++;
        }

        $output .= "</FONT>";
        return $output;
    }

    function AsciState($state) {

        $output = "";
        switch($state) {
            case 0:
                $fontcolor = "white";
                $char = "I";
                break;
            case 1:
                $fontcolor = "yellow";
                $char = "P";
                break;
            case 2:
                $fontcolor = "green";
                $char = "F";
                break;
            case 3:
                $fontcolor = "red";
                $char = "E";
                break;
        }
        return "<FONT style='BACKGROUND-COLOR: black; COLOR: " . $fontcolor . "'>" . $char . "</FONT>";
    }

    function RetryFailed($projid) {
        global $db;
        $sql = "UPDATE tasks SET state = 0 WHERE state = 3 AND projid = " . $projid;
        $db->query($sql);
    }

    function TasksFailed($projid) {
        global $db;

        $query = "SELECT count(*) as total FROM tasks WHERE projid = " . $projid . " AND state=3";
        $data = $db->get_results($query);
        $total = $data[0]['total'];

        if($total > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    function getStats($projid){

	global $db;

	$result = new ProjectStats();
	
	$query = "SELECT count(*) as total FROM tasks WHERE type = 0 AND projid = ".$projid;
	$data = $db->get_results($query);
	$result->totalframes = $data[0]['total'];

	$query = "SELECT count(*) as total FROM tasks WHERE type = 0 AND projid = ".$projid." AND (state = 2 OR state = 3)";
	$data = $db->get_results($query);
	$result->framesdone = $data[0]['total'];

	$query = "SELECT count(*) as total FROM tasks WHERE type = 0 AND projid = ".$projid." AND state = 3";
	$data = $db->get_results($query);
	$result->framesfailed = $data[0]['total'];

	$result->procent = ($result->framesdone > 0 ? (round((100*$result->framesdone)/$result->totalframes)) : 0);     

	return $result;
    }

    function GetProjectsData() {
        global $db;

        $template = file_get_contents("views/projectstable.tpl");

        $query = "SELECT * FROM projects ORDER BY projid DESC";
        $results = $db->get_results($query);

        $projectrows = "";
        foreach($results as $row) {
            $projectstats = $this->getStats($row['projid']);

            if($projectstats->procent == 100) {
                $active = "";
                $color = " progress-bar-success";
                $style = "";
		$class = "finished";
            } else {
                $active = " active";
                $color = "";
                $style = " progress-striped";
		$class = "processing";
            }

            if($projectstats->framesfailed > 0) {
                $color = " progress-bar-danger";
		$class = "error";
            }

            $projectrows .= "<tr class='$class' onClick='javascript:showProjectDetails(" . $row['projid'] . ");'>"
                    . "<td>" . $row['projid'] . "</td>"
                    . "<td>" . $row['name'] . "</td>"
                    . "<td>" . $projectstats->procent . "% "
                    . "<div class='progress" . $style . $active . "' style='width: 200px'>"
                    . "<div class='progress-bar" . $color . "' role='progressbar' aria-valuenow='" . $projectstats->procent . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $projectstats->procent . "%'>"
                    . "<span class='sr-only'>" . $projectstats->procent . "% Complete</span>"
                    . "</div>"
                    . "</div>"
                    . "</td>"
                    . "<td>$projectstats->framesdone / $projectstats->totalframes</td>"
		    ."<td>" . $this->LastFrameThumb($row['projid']) . "</td>"
                    . "</tr>";
        }

        $template = str_replace("{ProjectRows}", $projectrows, $template);
        return $template;
    }

    function TaskLogbookData($projid) {
        global $db;

        $query = "SELECT * FROM tasklog WHERE taskid IN (SELECT taskid FROM tasks WHERE projid = " . $projid . ")";
        $results = $db->get_results($query);

        $tasklogbookrows = "";
        foreach($results as $row) {

            $tasklogbookrows .= "<tr>"
                    . "<td>" . $row['datetime'] . "</td>"
                    . "<td>" . $row['source'] . "</td>"
                    . "<td><a href='index.php?controller=tasks&view=details&taskid=" . $row['taskid'] . "'>" . $row['taskid'] . "</a></td>"
                    . "<td>" . $row['message'] . "</td>"
                    . "</tr>";
        }

        return $tasklogbookrows;
    }

    function ShowLastRenderedFrame($projid) {
        global $db;

        $query = "SELECT dataid FROM tasks WHERE projid = " . $projid . " AND state = 2 AND type = 0 ORDER BY taskid DESC LIMIT 1";
        $results = $db->get_results($query);

        $dataid = NULL;
        foreach($results as $row) {
            $dataid = $row['dataid'];
        }

        if(!$dataid == NULL) {
            $query = "SELECT data FROM data WHERE dataid = " . $dataid;
            $results = $db->get_results($query);

            foreach($results as $row) {
                $data = $row['data'];
            }

            $output = "<img src='data:image/png;base64," . base64_encode($data) . "'>"; //  style='height=10%;'
        } else {
            $output = "No frames rendered yet.";
        }
        return $output;
    }

    function ShowProjectDetails($projid) {
        global $db;

        $template = file_get_contents("views/projectdetails.tpl");

        $query = "SELECT * FROM projects WHERE projid = " . $projid;
        $results = $db->get_results($query);

        $task = new Tasks;
        $percdone = $task->DonePercentage($projid);

        foreach($results as $row) {
            $projid = $row['projid'];
            $name = $row['name'];
        }

        //retreive task logbook
        $tasklogbook = file_get_contents("views/tasklogbook.tpl");
        $tasklogbookrows = $this->TaskLogbookData($projid);
        $tasklogbook = str_replace("{TaskLogbookRows}", $tasklogbookrows, $tasklogbook);

        //retreive tasks
        $movies = new Movies();
        $moviestable = $movies->showMovies($projid);

        //retreive tasks
        $tasks = new Tasks();
        $tasktable = $task->ShowTasks($projid);

        //retreive task logbook
        $triggers = new Triggers();
        $triggersview = $triggers->showTriggers($projid);

        $template = str_replace("{ProjId}", $projid, $template);
        $template = str_replace("{PercDone}", $percdone, $template);
        $template = str_replace("{Name}", $name, $template);
        $template = str_replace("{LastRenderedFrame}", $this->ShowLastRenderedFrame($projid), $template);
        $template = str_replace("{FrameOverview}", $this->FrameOverview($projid), $template);
        $template = str_replace("{MoviesOverview}", $moviestable, $template);
	$template = str_replace("{TaskLogbook}", $tasklogbook, $template);
        $template = str_replace("{Triggers}", $triggersview, $template);
        $template = str_replace("{TasksTable}", $tasktable, $template);


        return $template;
    }

}

?>
