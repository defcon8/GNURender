<?php

global $render;

//Generate Actions
switch(@$_GET['action']) {
    case "savetrigger":
	$trigger = new Trigger();
	$trigger->loadData($_GET['id']);
	$trigger->setState($_GET['stateid']);
	$trigger->setActionTypeID($_GET['actionid']);
	$trigger->setTriggerTypeID($_GET['triggertypeid']);
	$trigger->save();
	break;   
    case "createtrigger":
	$trigger = new Trigger();
	$trigger->setProjID($_GET['projid']);
	$trigger->setState($_GET['stateid']);
	$trigger->setActionTypeID($_GET['actionid']);
	$trigger->setTriggerTypeID($_GET['triggertypeid']);
	$trigger->insert();
	break;
    case "delete":
	$trigger = new Trigger();
	$trigger->loadData($_GET['id']);
	$trigger->delete();
	break;  

}

switch(@$_GET['view']) {
    default:
    case "overview":
        $triggers = new Triggers();
        $render = $triggers->showTriggers($_GET['projid']);
        break;

    case "edit":
        $trigger = new Trigger();
        $trigger->loadData($_GET['id']);
        $render = $trigger->ShowEdit();
        break;

    case "create":
        $trigger = new Trigger();
        $render = $trigger->ShowCreate($_GET['projid']);
        break;

}

?>