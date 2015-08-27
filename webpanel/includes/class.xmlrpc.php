<?php

class XMLRPC {

    private $xml;
    private $response;

    public function init() {
        $this->xml = new DOMDocument("1.0");
    }

    public function getXML() {
        $this->xml->formatOutput = true;
        //return "<xmp>" . $this->xml->saveXML() . "</xmp>"; //for visible output in webbrowser
        return $this->xml->saveXML(); //for visible output in webbrowser
    }

    private function addValue($name, $value) {
        $this->response[] = array($name, $value);
    }

    public function saveBinairyData() {
        global $input, $db;

        // basic auth
        $nodeid = $this->IsValidNode($input['authkey']);
        $this->addValue('authenticated', ($nodeid ? "true" : "false"));

        if ($nodeid) {
            //save in database
            $stmt = $db->link->prepare("INSERT INTO data (data) VALUES(?)");
            $null = NULL;
            $stmt->bind_param("b", $null);
            $stmt->send_long_data(0, base64_decode($input['data']));
            $stmt->execute();

            $dataid = $db->link->insert_id;
            $result = false;

            if ($dataid > 0) {
                $result = true;
                $db->query("UPDATE tasks SET dataid = " . $dataid . ", procoutput = '" . $input['procoutput'] . "', state = 2 WHERE taskid = " . $input["taskid"]);
                $this->addValue('dataid', $dataid);
            } else {
                $db->query("UPDATE tasks SET state = 3 WHERE taskid = " . $input["taskid"]);
            }

            $this->addValue('stored', ($result ? "true" : "false"));
        }
    }

    public function getFrameRenderResources() {
        global $input, $db;

        // basic auth
        $nodeid = $this->IsValidNode($input['authkey']);
        $this->addValue('authenticated', ($nodeid ? "true" : "false"));

        //If task found
        if ($nodeid) {
            //return information to node
            //Get data id of this projid
            $result = $db->get_results("SELECT resourcefilename, resourcedataid FROM projects WHERE projid = " . $input['projid']);

            $dataid = $result[0]['resourcedataid'];
            $resourcefilename = $result[0]['resourcefilename'];

            $binairydata = new BinairyData();
            $binairydata->getDataID($dataid);

            $this->addValue('filename', $resourcefilename);
            $this->addValue('data', $binairydata->getBase64String());
        }
    }

    public function getScript() {
        global $input, $db;

        // basic auth
        $nodeid = $this->IsValidNode($input['authkey']);
        $this->addValue('authenticated', ($nodeid ? "true" : "false"));

        if ($nodeid) {
            //authenticated
            $result = $db->get_results("SELECT script FROM projects WHERE projid = " . $input['projid']);
            $this->addValue('script', $result[0]['script']);
        }
    }
    
    public function touchServer() {
        global $input, $db;

        // basic auth
        $nodeid = $this->IsValidNode($input['authkey']);
        $this->addValue('authenticated', ($nodeid ? "true" : "false"));

        if ($nodeid) {
            //authenticated
            $db->query("UPDATE nodes SET name = '".$input['name']."', appversion = '".$input['appversion']."', osname = '".$input['osname']."', osbit = '".$input['osbit']."', touched = NOW() WHERE nodeid = " . $nodeid);
        }
    }
    
    public function saveLog() {
        global $input, $db;

        // basic auth
        $nodeid = $this->IsValidNode($input['authkey']);
        $this->addValue('authenticated', ($nodeid ? "true" : "false"));

        if ($nodeid) {
            //authenticated
            $db->query("UPDATE tasks SET procoutput = '".$input['message']."' WHERE taskid = " . $input['taskid']);
        }
    }
    
    
    public function getTask() {
        global $input;

        // basic auth
        $nodeid = $this->IsValidNode($input['authkey']);
        $this->addValue('authenticated', ($nodeid ? "true" : "false"));

        if ($nodeid) {
            //authentica
            $task = new Task();
            $task->getNewTask($nodeid);

            //If task found
            if ($task->taskid > -1) {
                //return information to node
                $this->addValue('taskid', $task->taskid);
                $this->addValue('type', $task->type);
                $this->addValue('application', $task->application);
                $this->addValue('parameters', $task->parameters);
                $this->addValue('state', $task->state);
                $this->addValue('procoutput', $task->procoutput);
                $this->addValue('procprio', $task->procprio);
                $this->addValue('sourcefile', $task->sourcefile);
                $this->addValue('outputfile', $task->outputfile);
                $this->addValue('framenr', $task->framenr);
                $this->addValue('format', $task->format);
                $this->addValue('projid', $task->projid);
            }
        }
    }

    public function getAuth() {
        global $input;

	Debug::Write("Test");

        // basic auth
        $nodeid = $this->IsValidNode($input['authkey']);
        $this->addValue('authenticated', ($nodeid ? "true" : "false"));

        if ($nodeid) {
            //update own node information($authenticad
            $this->updateNodeInformation($nodeid);

            //return information to node
            $this->addValue('nodeid', $nodeid);
        }
    }

    public function prepare() {
        $root = $this->xml->createElement("response");
        $this->xml->appendChild($root);

        foreach ($this->response as $param) {
            $id = $this->xml->createElement($param[0]);
            $idText = $this->xml->createTextNode($param[1]);
            $id->appendChild($idText);
            $root->appendChild($id);
        }
    }

    private function updateNodeInformation($nodeid) {
        global $db, $input;
        $sql = "UPDATE nodes SET "
                . "touched = NOW(),"
                . "machinename = '" . $input['machinename'] . "',"
                . "appversion = '" . $input['appversion'] . "',"
                . "osname = '" . $input['osname'] . "',"
                . "osbit = '" . $input['osbit'] . "',"
                . "osversion = '" . $input['osversion'] . "',"
                . "processorcount = '" . $input['processorcount'] . "'"
                . "WHERE nodeid = $nodeid";
        $db->query($sql);
    }

    private function IsValidNode($key) {
        global $db;
        $result = $db->get_results("SELECT nodeid FROM nodes WHERE authkey = '" . $key . "'");

        $found = -1;

        foreach ($result as $row) {
            $found = $row['nodeid'];
        }
        return $found;
    }

}

?>