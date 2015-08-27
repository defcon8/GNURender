<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Bastiaan
 */
class Task {

    public $taskid = -1;
    public $type;
    public $sourcefile;
    public $outputfile;
    public $application;
    public $parameters;
    public $state;
    public $procoutput;
    public $procprio;
    public $dataid;
    public $framenr;
    public $projid;
    public $donebynode;

    public function getNewTask($nodeid) {
        global $db;
        $result = $db->get_results("SELECT taskid, type, application, parameters, state, procprio, sourcefile, outputfile, framenr, format, projid FROM tasks WHERE state = 0 LIMIT 1");

        //BW: TODO, Select & Update needs to be atomic, in a single transaction.
        
        if($result != false){ // if task available
        
            foreach ($result as $row) {
                $this->taskid = $row['taskid'];
                $this->type = $row['type'];
                $this->application = $row['application'];
                $this->parameters = $row['parameters'];
                $this->state = $row['state'];
                $this->procprio = $row['procprio'];
                $this->sourcefile = $row['sourcefile'];
                $this->outputfile = $row['outputfile'];
                $this->framenr = $row['framenr'];
                $this->format = $row['format'];
                $this->projid = $row['projid'];
            }
        
            $db->query("UPDATE tasks SET state = 1, node = ".$nodeid." WHERE taskid = ".$this->taskid);            
        }

        return $this->taskid;
    }

}

?>