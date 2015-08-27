<?php

/*
 * Copyright (C) 2014 bw
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Description of class
 *
 * @author bw
 */
class Triggers {

    function showTriggers($projid) {

        $condition = (!is_null($projid) ? " AND triggers.projid = " . $projid : "");

        global $db;

        $query = "SELECT triggers.triggerid as id, triggertypes.name as triggerdesc, triggers.state as state FROM triggers, triggertypes WHERE triggertypes.triggertypeid = triggers.triggertypeid" . $condition;
        $results = $db->get_results($query);

        $triggersrows = "";
        foreach($results as $row) {

            $triggersrows .= "<tr onClick='javascript:editTrigger(" . $row['id'] . ");'>"
                    . "<td>" . $row['id'] . "</td>"
                    . "<td>" . $row['triggerdesc'] . "</td>"
                    . "<td>" . $this->TriggerState($row['state']) . "</td>"
                    . "</tr>";
        }

        $triggertemplate = file_get_contents("views/triggers.tpl");
        $triggertemplate = str_replace("{TriggerRows}", $triggersrows, $triggertemplate);
	$triggertemplate = str_replace("{projid}", $projid, $triggertemplate);
	return $triggertemplate;
    }

    function TriggerState($state) {
        switch($state) {
            case 0:
                return "<i class='glyphicon glyphicon-share-alt' alt='Active'></i>";
            case 1:
                return "<i class='glyphicon glyphicon-ok' alt='Finished'></i>";
	    case 2:
                return "<i class='glyphicon glyphicon-pause' alt='Disabled'></i>";
        }
    }

}
