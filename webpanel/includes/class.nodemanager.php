<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author bw
 */
class NodeManager {

    private $con;
    private $stream;
    private $log;
    private $host, $user, $pass, $port, $path;

    function install($host, $user, $pass, $port, $path) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->port = $port;
        $this->path = $path;
        
        $this->connect();
        $this->login();
        $this->createFolder();
        //$this->uploadeNode();
        //Create config
    }

    function readLog() {
        return $this->log;
    }

    function connect() {

        if (!function_exists("ssh2_connect"))
            die("function ssh2_connect doesn't exist");
        // log in at server1.example.com on port 22
        if (!($this->con = ssh2_connect($this->host, $this->port))) {
            $this->log .= "Unable to establish connection with host.\n";
            DIE();
        } else {
            $this->log .= "Connected to host.\n";
        }
    }

    function login() {
        // try to authenticate with username root, password secretpassword
        if (!ssh2_auth_password($this->con, $this->user, $this->pass)) {
            $this->log .= "Unable to authenticate.\n";
            DIE();
        } else {
            $this->log .= "Authenticated.\n";
        }
    }

    function execute($command) {
        $this->log .= "Execute: " . $command . "\n";
        if (!($stream = ssh2_exec($this->con, $command))) {
            $this->log .= "Unable to execute command\n";
        } else {
            // collect returning data from command
            stream_set_blocking($stream, true);
            $data = "";
            while ($buf = fread($stream, 4096)) {
                $data .= $buf;
            }
            fclose($stream);
            return $data;
        }
    }

    function uploadFile($localfile) {
        try {
            $sftp = new SFTPConnection($this->host, $this->port);
            $sftp->login($this->user, $this->pass);
            $sftp->uploadFile($localfile, $this->path."/".$localfile);
        } catch (Exception $e) {
            $this->log .= $e->getMessage() . "\n";
            DIE();
        }
    }

    function uploadNode() {
        
    }

    function folderExist() {
        $response = $this->execute("test -d " . $this->path . " && echo true");
        $exist = (trim($response) == "true" ? true : false);
        $this->log .= "Result: Folder does" . ($exist ? "" : " not") . " exist.\n";
        return $exist;
    }

    function createFolder() {
        if (!$this->folderExist()) {
            $this->log .= $this->execute("mkdir " . $this->path);
            //check again if created succesfully
            if ($this->folderExist()) {
                $this->log .= "Result: folder created succefully.\n";
            } else {
                $this->log .= "Result: Could not create folder.\n";
                DIE();
            }
        }
    }
}
