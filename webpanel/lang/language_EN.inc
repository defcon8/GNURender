<?php

/*
  GNURender language file
  Language:               English
  Author:                 John van Breugel
  Creation Date:  19-11-2013

  Legenda:
  LOGIN_  =	Login page
  PROF_	=	Profile page
  MENU_   =	Main page menu
  BUTTON_ =	Buttons
  PROJ_   =	Projects page
  COMB_   =	Combobox
  NODE_   =	Nodes page
  LOGB_   =	Logbook page
  SETT_   =	Settings page
  MOVI_	=	Movie page
 */

global $screen;

//      Login / Logout
$screen->SetLang("LOGIN_USER", "Username");
$screen->SetLang("LOGIN_PASS", "Password");
$screen->SetLang("LOGIN_SIGN", "Sign in");
$screen->SetLang("LOGIN_REMM", "Remember me");
$screen->SetLang("LOGIN_HELP", "Need help?");
$screen->SetLang("LOGIN_PROF", "Profile");
$screen->SetLang("LOGIN_LOUT", "Logout");

//		Profile
$screen->SetLang("PROF_TITL", "User profile settings");
$screen->SetLang("PROF_USRN", "Username");
$screen->SetLang("PROF_USRN_DESC", "The name you use at logon.");
$screen->SetLang("PROF_FUNA", "Name");
$screen->SetLang("PROF_FUNA_DESC", "Your complete name.");
$screen->SetLang("PROF_PASS", "Password");
$screen->SetLang("PROF_PASS_DESC", "The password you use to logon.");
$screen->SetLang("PROF_MAIL", "E-Mail");
$screen->SetLang("PROF_MAIL_DESC", "Your e-mail address.");
$screen->SetLang("PROF_LANG", "Language");
$screen->SetLang("BUTTON_PROF_SUBM", "Save!");

//      Left-side menu
$screen->SetLang("MENU_DASH", "Dashboard");
$screen->SetLang("MENU_PROJ", "Projects");
$screen->SetLang("MENU_NODE", "Nodes");
$screen->SetLang("MENU_LOGB", "Logbook");
$screen->SetLang("MENU_SETT", "Settings");
$screen->SetLang("MENU_HELP", "Help");
$screen->SetLang("MENU_CRED", "Credits");

//      Projects
$screen->SetLang("BUTTON_PROJ_CREA", "New project");
$screen->SetLang("PROJ_CREA_TITL", "Create Project");
$screen->SetLang("PROJ_CREA_NAME", "Name");
$screen->SetLang("PROJ_CREA_NAME_TT", "My 3D Movie");     // Tooltip
$screen->SetLang("PROJ_CREA_NAME_DESC", "The shortname of this project.");
$screen->SetLang("PROJ_CREA_RESF", "Resourcefile (.blend or .zip)");
$screen->SetLang("PROJ_CREA_OFOR", "Output format");
$screen->SetLang("PROJ_CREA_RENG", "Render engine");
$screen->SetLang("COMB_PROJ_CREA_RENG_UNDE", "Undefined (project default)");
$screen->SetLang("PROJ_CREA_FRMS", "Frames");
$screen->SetLang("PROJ_CREA_FRMS_TT", "0-100");                 // Tooltip
$screen->SetLang("PROJ_CREA_FRMS_DESC", "Frame nr. or range to render.");
$screen->SetLang("BUTTON_PROJ_CREA_SUBM", "Submit!");

$screen->SetLang("PROJ_CREA_GENE", "General");
$screen->SetLang("PROJ_CREA_SCRP", "Script");

$screen->SetLang("PROJ_PROI", "Project ID");
$screen->SetLang("PROJ_NAME", "Name");
$screen->SetLang("PROJ_FINI", "Progress");
$screen->SetLang("PROJ_FRAM", "Frames");
$screen->SetLang("PROJ_LASF", "Last Frame");

$screen->SetLang("PROJ_OVER", "Project");
$screen->SetLang("PROJ_OVER_ID", "ID");
$screen->SetLang("PROJ_OVER_NAME", "Name");
$screen->SetLang("PROJ_OVER_PROG", "Progress");
$screen->SetLang("PROJ_OVER_FRAO", "Frame overview");

$screen->SetLang("PROJ_RNDR", "Render");
$screen->SetLang("PROJ_RNDR_LAST", "Last rendered frame");
$screen->SetLang("PROJ_RNDR_NFRM", "No frames rendered yet.");

$screen->SetLang("PROJ_MOVS", "Movies");
$screen->SetLang("BUTTON_PROJ_MOVS_RENA", "New movie");

$screen->SetLang("PROJ_TASK", "Tasks");
$screen->SetLang("PROJ_TASK_ID", "Task ID");
$screen->SetLang("PROJ_TASK_TYPE", "Type");
$screen->SetLang("PROJ_TASK_TYPE_FRAM", "Frame");
$screen->SetLang("PROJ_TASK_TYPE_MOVI", "Movie");
$screen->SetLang("PROJ_TASK_FRAM", "Frame");
$screen->SetLang("PROJ_TASK_STAT", "State");
$screen->SetLang("PROJ_TASK_STAT_IDLE", "Idle");
$screen->SetLang("PROJ_TASK_STAT_PROC", "Processing");
$screen->SetLang("PROJ_TASK_STAT_ERRO", "Error");
$screen->SetLang("PROJ_TASK_NODE", "Node");

$screen->SetLang("PROJ_LOGB", "Logbook");
$screen->SetLang("PROJ_LOGB_DATI", "Date/Time");
$screen->SetLang("PROJ_LOGB_SRCE", "Source");
$screen->SetLang("PROJ_LOGB_TASK", "Task");
$screen->SetLang("PROJ_LOGB_MESS", "Message");

$screen->SetLang("PROJ_TRIG", "Triggers");
$screen->SetLang("PROJ_TRIG_ID", "ID");
$screen->SetLang("PROJ_TRIG_NAME", "Name");
$screen->SetLang("PROJ_TRIG_STAT", "State");
$screen->SetLang("BUTTON_PROJ_TRIG_CREA", "Add");

$screen->SetLang("PROJ_CTRL", "Control");
$screen->SetLang("PROJ_CTRL_FAIT", "Failed tasks");
$screen->SetLang("BUTTON_PROJ_CTRL_RETF", "Reschedule failed tasks");
$screen->SetLang("BUTTON_PROJ_CTRL_DELP", "Delete project");

//      Tasks
$screen->SetLang("TASK_STAT_0", "Pending");
$screen->SetLang("TASK_STAT_1", "Processing");
$screen->SetLang("TASK_STAT_2", "Finished");
$screen->SetLang("TASK_STAT_3", "Error");

$screen->SetLang("TASK_OVER", "Task");
$screen->SetLang("TASK_OVER_PROI", "Project ID");
$screen->SetLang("TASK_OVER_FRMN", "Frame Nr");
$screen->SetLang("TASK_OVER_PROC", "Processed by");

$screen->SetLang("TASK_RNDR", "Render");

$screen->SetLang("TASK_PROO", "Process output");

$screen->SetLang("TASK_LOGB", "Logbook");

$screen->SetLang("TASK_CTRL", "Control");
$screen->SetLang("BUTTON_TASK_CTRL_RREN", "Re-Render");
$screen->SetLang("BUTTON_TASK_CTRL_DELE", "Delete");
$screen->SetLang("BUTTON_TASK_CTRL_DWNL", "Download");

$screen->SetLang("MOVI_ID", "Movie ID");
$screen->SetLang("MOVI_STAT", "State");
$screen->SetLang("MOVI_ACTI", "Action");

$screen->SetLang("MOVI_CREA_TITL", "Create movie");
$screen->SetLang("MOVI_CREA_FPS", "FPS");
$screen->SetLang("MOVI_CREA_FPS_DEFA", "25");
$screen->SetLang("MOVI_CREA_FPS_DESC", "The number of frames per second.");
$screen->SetLang("MOVI_CREA_CODC", "Codec");
$screen->SetLang("MOVI_CREA_PRES", "Preset");
$screen->SetLang("MOVI_CREA_SCAL", "Scale");
$screen->SetLang("MOVI_CREA_ENAB", "Enabled");
$screen->SetLang("MOVI_CREA_SCAL_WIDT", "Scale width");
$screen->SetLang("MOVI_CREA_SCAL_WIDT_DEFA", "1024");
$screen->SetLang("MOVI_CREA_SCAL_WIDT_DESC", "New width specified in pixels.");
$screen->SetLang("MOVI_CREA_SCAL_HEIG", "Scale height");
$screen->SetLang("MOVI_CREA_SCAL_HEIG_DEFA", "768");
$screen->SetLang("MOVI_CREA_SCAL_HEIG_DESC", "New height specified in pixels.");
$screen->SetLang("BUTTON_MOVI_SUBM", "Create");

//      Nodes
$screen->SetLang("COMB_ACTI", "Choose..");
$screen->SetLang("COMB_BENC", "Benchmark");
$screen->SetLang("COMB_STAR", "Start");
$screen->SetLang("COMB_STOP", "Stop");
$screen->SetLang("COMB_DLBL", "Download Blender");

$screen->SetLang("NODE_NODE", "Node");
$screen->SetLang("NODE_PLAT", "Platform");
$screen->SetLang("NODE_VERS", "Version");
$screen->SetLang("NODE_TOUC", "Touched");
$screen->SetLang("NODE_ACTI", "Actions");
$screen->SetLang("BUTTON_NODE_ADD", "Add");


//      Logbook
$screen->SetLang("LOGB_DATI", "Date/Time");
$screen->SetLang("LOGB_MESS", "Message");

//      Settings
$screen->SetLang("BUTTON_USRS_CREA", "Create");

$screen->SetLang("SETT_USRS", "Users");
$screen->SetLang("SETT_USRI", "User ID");
$screen->SetLang("SETT_NAME", "Name");
$screen->SetLang("SETT_LEVL", "Level");
?>
