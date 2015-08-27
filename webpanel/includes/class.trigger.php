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
class Trigger {

    //Init values
    var $triggerid = -1;
    var $projid = -1;
    var $triggertypeid = -1;
    var $actiontypeid = -1;
    var $state = -1;

    function showEdit() {
        $template = file_get_contents("views/triggeredit.tpl");

        $template = str_replace("{triggerid}", $this->triggerid, $template);
        $template = str_replace("{triggertypeoptions}", $this->getTriggerTypes(), $template);
        $template = str_replace("{actiontypeoptions}", $this->getActionTypes(), $template);
        $template = str_replace("{triggerstateoptions}", $this->getStateTypes(), $template);

        $template = str_replace("{projid}", $this->projid, $template);

        return $template;
    }

    function showCreate($projid) {
        $template = file_get_contents("views/triggercreate.tpl");

        $template = str_replace("{triggertypeoptions}", $this->getTriggerTypes(), $template);
        $template = str_replace("{actiontypeoptions}", $this->getActionTypes(), $template);
        $template = str_replace("{triggerstateoptions}", $this->getStateTypes(), $template);

        $template = str_replace("{projid}", $projid, $template);

        return $template;
    }

    function getTriggerTypes() {
        $result = "";
        global $db;
        $query = "SELECT * FROM triggertypes";
        $results = $db->get_results($query);
        foreach($results as $row) {
            $selected = ($row['triggertypeid'] == $this->triggertypeid ? " selected" : "");
            $result .= "<option value='" . $row['triggertypeid'] . "'" . $selected . ">" . $row['name'] . "</option>";
        }
        return $result;
    }

    function getActionTypes() {
        $result = "";
        global $db;
        $query = "SELECT * FROM actiontypes";
        $results = $db->get_results($query);
        foreach($results as $row) {
            $selected = ($row['actiontypeid'] == $this->actiontypeid ? " selected" : "");
            $result .= "<option value='" . $row['actiontypeid'] . "'" . $selected . ">" . $row['name'] . "</option>";
        }
        return $result;
    }

    function getStateTypes() {
        $result = "";
        global $db;
        $query = "SELECT * FROM triggerstatetypes";
        $results = $db->get_results($query);
        foreach($results as $row) {
            $selected = ($row['triggerstateid'] == $this->state ? " selected" : "");
            $result .= "<option value='" . $row['triggerstateid'] . "'" . $selected . ">" . $row['name'] . "</option>";
        }
        return $result;
    }

    function loadData($id) {
        global $db;
        $query = "SELECT * FROM triggers WHERE triggerid = " . $id;
        $results = $db->get_results($query);
        foreach($results as $row) {
            $this->triggerid = $row['triggerid'];
            $this->projid = $row['projid'];
            $this->triggertypeid = $row['triggertypeid'];
            $this->actiontypeid = $row['actiontypeid'];
            $this->state = $row['state'];
        }
    }

    function save() {
        global $db;
        $sql = "UPDATE triggers SET triggertypeid = " . $this->triggertypeid . ", actiontypeid = " . $this->actiontypeid . ", state = " . $this->state . " WHERE triggerid = " . $this->triggerid;
        $db->query($sql);
    }

    function insert() {
        global $db;
        $sql = "INSERT INTO triggers SET projid = " . $this->projid . ", triggertypeid = " . $this->triggertypeid . ", actiontypeid = " . $this->actiontypeid . ", state = " . $this->state;
        $db->query($sql);
    }

    function delete() {
        global $db;
        $sql = "DELETE from triggers WHERE triggerid = " . $this->triggerid;
        $db->query($sql);
    }

    function setTriggerTypeID($id) {
        $this->triggertypeid = (int) $id;
    }

    function getTriggerTypeID() {
        return $this->triggertypeid;
    }

    function setActionTypeID($id) {
        $this->actiontypeid = (int) $id;
    }

    function getActionTypeID() {
        return $this->actiontypeid;
    }

    function setProjID($id) {
        $this->projid = (int) $id;
    }

    function getProjID() {
        return $this->projid;
    }

    function setState($id) {
        $this->state = (int) $id;
    }

    function getState() {
        return $this->state;
    }

}
