<?php

class Movies {

    function showMovies($projid) {
        $template = file_get_contents("views/moviestable.tpl");
        $template = str_replace("{ProjId}", $projid, $template);
        $template = str_replace("{MoviesRows}", $this->getMovies($projid), $template);
        return $template;
    }

    function getMovies($projid) {
        global $db;

        $query = "SELECT taskid,state FROM tasks WHERE type = 1 and projid = " . $projid;
        $results = $db->get_results($query);
        $task = new Tasks();
        $moviesrows = "";
        foreach($results as $row) {
            $moviesrows .= "<tr><td>" . $row['taskid'] . "</td>";
            $moviesrows .= "<td>" . $task->StateDescription($row['state']) . "</td>";
            $moviesrows .= "<td>" . ($row['state'] == 2 ? "<button id='singlebutton' name='singlebutton' type='button' class='btn btn-default' onclick='javascript:downloadMovie(" . $row['taskid'] . ");'>Download</button> <button id='singlebutton' name='singlebutton' type='button' class='btn btn-danger' onclick='javascript:deleteMovie(" . $projid . ",".$row['taskid'] . ");'>Delete</button></td></tr>" : "") . "</td></tr>";
        }
        return $moviesrows;
    }

    function ShowCreateForm() {
        $template = file_get_contents("views/moviecreate.tpl");
        return $template;
    }

    function deleteMovie($taskid) {
        global $db;
        //get data id
        $query = "select dataid from tasks where taskid =".$taskid;
        $results = $db->get_results($query);
        $dataid=-1;
        foreach($results as $row) {
            $dataid = $row['dataid'];
        }
        
        //delete data object
        $sql = "DELETE FROM data WHERE dataid = ".$dataid;
        $db->query($sql);
        
        //delete task
        $sql = "DELETE FROM tasks WHERE taskid = ".$taskid;
        $db->query($sql);
        
    }

    function CreateMovie($projid, $readrate, $codec, $preset, $scale, $scalewidth, $scaleheight) {

        //Protect optional parametes from being empty
        $scalewidth = (!is_null($scalewidth) ? $scalewidth : 0);
        $scaleheight = (!is_null($scaleheight) ? $scaleheight : 0);

        //Prepare
        $inputfiles = "{inputfiles}";
        $videofilter = "fps=" . $readrate;
        $outputfile = "{outputfile}";

        //Build CLI arguments
        $options = "";
        $options .= " -r " . $readrate;
        $options .= " -i " . $inputfiles;
        $options .= " -c:v " . $codec;
        $options .= " -vf " . $videofilter;
        $options .= " -pix_fmt yuv420p"; //compatible with all players?
        $options .= " " . $outputfile;

        global $db;
        $sql = "INSERT INTO tasks (type,application,parameters,state,framenr,projid,sourcefile,outputfile,format) VALUES (1,'ffmpeg','" . $options . "',0,0," . $projid . ",'0','','')";
        $db->query($sql);
    }

}

?>
