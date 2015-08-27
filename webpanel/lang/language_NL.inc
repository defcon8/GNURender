<?php
/*
  GNURender language file
  Language:               Dutch,NL (Nederlands)
  Author:                 John van Breugel
  Creation Date:  19-11-2013

  Legenda:
  LOGIN_  =	Aanmeld pagina
  PROF_	=	Profiel pagina
  MENU_   =	Hoofd pagina menu
  BUTTON_ =	Knoppen
  PROJ_   =	Projecten pagina
  COMB_   =	Selectie menu
  NODE_   =	Nodes pagina
  LOGB_   =	Logboek pagina
  SETT_   =	Instellingen pagina
  MOVI_	=	Film pagina
 */

global $screen;

//      Inloggen / Uitloggen
$screen->SetLang("LOGIN_USER", "Gebruiker");
$screen->SetLang("LOGIN_PASS", "Wachtwoord");
$screen->SetLang("LOGIN_SIGN", "Aanmelden");
$screen->SetLang("LOGIN_REMM", "Onthouden");
$screen->SetLang("LOGIN_HELP", "Hulp nodig?");
$screen->SetLang("LOGIN_PROF", "Profiel");
$screen->SetLang("LOGIN_LOUT", "Uitloggen");

//		Profiel
$screen->SetLang("PROF_TITL", "Gebruiker profiel instellingen");
$screen->SetLang("PROF_USRN", "Gebruikersnaam");
$screen->SetLang("PROF_USRN_DESC", "Uw inlog naam.");
$screen->SetLang("PROF_FUNA", "Naam");
$screen->SetLang("PROF_FUNA_DESC", "Uw volledige naam.");
$screen->SetLang("PROF_PASS", "Wachtwoord");
$screen->SetLang("PROF_PASS_DESC", "Uw inlog wachtwoord.");
$screen->SetLang("PROF_MAIL", "E-Mail");
$screen->SetLang("PROF_MAIL_DESC", "Uw e-mail adres.");
$screen->SetLang("PROF_LANG", "Taal");
$screen->SetLang("BUTTON_PROF_SUBM", "Opslaan!");

//		Menu aan linker kant
$screen->SetLang("MENU_DASH", "Dashboard");
$screen->SetLang("MENU_PROJ", "Projecten");
$screen->SetLang("MENU_NODE", "Nodes");
$screen->SetLang("MENU_LOGB", "Logboek");
$screen->SetLang("MENU_SETT", "Instellingen");
$screen->SetLang("MENU_HELP", "Help");
$screen->SetLang("MENU_CRED", "Credits");

//		Projecten
$screen->SetLang("BUTTON_PROJ_CREA", "Nieuw project");
$screen->SetLang("PROJ_CREA_TITL", "Maak project aan");
$screen->SetLang("PROJ_CREA_NAME", "Naam");
$screen->SetLang("PROJ_CREA_NAME_TT", "Mijn 3D Film");    // Tooltip
$screen->SetLang("PROJ_CREA_NAME_DESC", "Korte naam van dit project.");
$screen->SetLang("PROJ_CREA_RESF", "Bron bestand (.blend of .zip)");
$screen->SetLang("PROJ_CREA_OFOR", "Doel formaat");
$screen->SetLang("PROJ_CREA_RENG", "Render engine");
$screen->SetLang("COMB_PROJ_CREA_RENG_UNDE", "Niet gedefinieerd (project standaard)");
$screen->SetLang("PROJ_CREA_FRMS", "Frames");
$screen->SetLang("PROJ_CREA_FRMS_TT", "0-100");                 // Tooltip
$screen->SetLang("PROJ_CREA_FRMS_DESC", "Frame nr. of reeks om te verwerken.");
$screen->SetLang("BUTTON_PROJ_CREA_SUBM", "Verstuur!");

$screen->SetLang("PROJ_CREA_GENE", "Algemeen");
$screen->SetLang("PROJ_CREA_SCRP", "Script");

$screen->SetLang("PROJ_PROI", "Project ID");
$screen->SetLang("PROJ_NAME", "Naam");
$screen->SetLang("PROJ_FINI", "Voortgang");
$screen->SetLang("PROJ_FRAM", "Frames");
$screen->SetLang("PROJ_LASF", "Laatste Frame");

$screen->SetLang("PROJ_OVER", "Project");
$screen->SetLang("PROJ_OVER_ID", "ID");
$screen->SetLang("PROJ_OVER_NAME", "Naam");
$screen->SetLang("PROJ_OVER_PROG", "Voortgang");
$screen->SetLang("PROJ_OVER_FRAO", "Frame overzicht");

$screen->SetLang("PROJ_RNDR", "Render");
$screen->SetLang("PROJ_RNDR_LAST", "Laatst gerenderde frame");
$screen->SetLang("PROJ_RNDR_NFRM", "Nog geen frames gerenderd.");

$screen->SetLang("PROJ_MOVS", "Films");
$screen->SetLang("BUTTON_PROJ_MOVS_RENA", "Nieuwe film");

$screen->SetLang("PROJ_TASK", "Taken");
$screen->SetLang("PROJ_TASK_ID", "Taak ID");
$screen->SetLang("PROJ_TASK_TYPE", "Type");
$screen->SetLang("PROJ_TASK_TYPE_FRAM", "Frame");
$screen->SetLang("PROJ_TASK_TYPE_MOVI", "Film");
$screen->SetLang("PROJ_TASK_FRAM", "Frame");
$screen->SetLang("PROJ_TASK_STAT", "Status");
$screen->SetLang("PROJ_TASK_STAT_IDLE", "Stationair");
$screen->SetLang("PROJ_TASK_STAT_PROC", "Verwerking");
$screen->SetLang("PROJ_TASK_STAT_ERRO", "Fout");
$screen->SetLang("PROJ_TASK_NODE", "Node");

$screen->SetLang("PROJ_LOGB", "Logboek");
$screen->SetLang("PROJ_LOGB_DATI", "Datum/Tijd");
$screen->SetLang("PROJ_LOGB_SRCE", "Bron");
$screen->SetLang("PROJ_LOGB_TASK", "Taak");
$screen->SetLang("PROJ_LOGB_MESS", "Bericht");

$screen->SetLang("PROJ_TRIG", "Triggers");
$screen->SetLang("PROJ_TRIG_ID", "ID");
$screen->SetLang("PROJ_TRIG_NAME", "Naam");
$screen->SetLang("PROJ_TRIG_STAT", "Status");
$screen->SetLang("BUTTON_PROJ_TRIG_CREA", "Toevoegen");

$screen->SetLang("PROJ_CTRL", "Besturing");
$screen->SetLang("PROJ_CTRL_FAIT", "Mislukte taken");
$screen->SetLang("BUTTON_PROJ_CTRL_RETF", "Mislukte taken opnieuw inplannen");
$screen->SetLang("BUTTON_PROJ_CTRL_DELP", "Verwijder project");

//		Taken
$screen->SetLang("TASK_STAT_0", "In afwachting");
$screen->SetLang("TASK_STAT_1", "Verwerken");
$screen->SetLang("TASK_STAT_2", "Klaar");
$screen->SetLang("TASK_STAT_3", "Fout");

$screen->SetLang("TASK_OVER", "Taak");
$screen->SetLang("TASK_OVER_PROI", "Project ID");
$screen->SetLang("TASK_OVER_FRMN", "Frame Nr");
$screen->SetLang("TASK_OVER_PROC", "Verwerkt door");

$screen->SetLang("TASK_RNDR", "Render");

$screen->SetLang("TASK_PROO", "Proces uitvoer");

$screen->SetLang("TASK_LOGB", "Logboek");

$screen->SetLang("TASK_CTRL", "Besturing");
$screen->SetLang("BUTTON_TASK_CTRL_RREN", "Re-Render");
$screen->SetLang("BUTTON_TASK_CTRL_DELE", "Verwijder");
$screen->SetLang("BUTTON_TASK_CTRL_DWNL", "Download");

$screen->SetLang("MOVI_ID", "Film ID");
$screen->SetLang("MOVI_STAT", "Status");
$screen->SetLang("MOVI_ACTI", "Actie");

$screen->SetLang("MOVI_CREA_TITL", "Film maken");
$screen->SetLang("MOVI_CREA_FPS", "FPS");
$screen->SetLang("MOVI_CREA_FPS_DEFA", "25");
$screen->SetLang("MOVI_CREA_FPS_DESC", "Aantal frames per seconde.");
$screen->SetLang("MOVI_CREA_CODC", "Codec");
$screen->SetLang("MOVI_CREA_PRES", "Preset");
$screen->SetLang("MOVI_CREA_SCAL", "Schaal");
$screen->SetLang("MOVI_CREA_ENAB", "Ingeschakeld");
$screen->SetLang("MOVI_CREA_SCAL_WIDT", "Schaal breedte");
$screen->SetLang("MOVI_CREA_SCAL_WIDT_DEFA", "1024");
$screen->SetLang("MOVI_CREA_SCAL_WIDT_DESC", "Nieuw breedte gespecificeerd in pixels.");
$screen->SetLang("MOVI_CREA_SCAL_HEIG", "Schaal hoogte");
$screen->SetLang("MOVI_CREA_SCAL_HEIG_DEFA", "768");
$screen->SetLang("MOVI_CREA_SCAL_HEIG_DESC", "Nieuwe hoogte gespecificeerd in pixels.");
$screen->SetLang("BUTTON_MOVI_SUBM", "Aanmaken");

//		Nodes
$screen->SetLang("COMB_ACTI", "Kies..");
$screen->SetLang("COMB_BENC", "Benchmark");
$screen->SetLang("COMB_STAR", "Start");
$screen->SetLang("COMB_STOP", "Stop");
$screen->SetLang("COMB_DLBL", "Download Blender");

$screen->SetLang("NODE_NODE", "Node");
$screen->SetLang("NODE_PLAT", "Platform");
$screen->SetLang("NODE_VERS", "Versie");
$screen->SetLang("NODE_TOUC", "Aangeraakt");
$screen->SetLang("NODE_ACTI", "Acties");
$screen->SetLang("BUTTON_NODE_ADD", "Toevoegen");

//		Logboek
$screen->SetLang("LOGB_DATI", "Datum/Tijd");
$screen->SetLang("LOGB_MESS", "Bericht");

//		Instellingen
$screen->SetLang("BUTTON_USRS_CREA", "Aanmaken");

$screen->SetLang("SETT_USRS", "Gebruikers");
$screen->SetLang("SETT_USRI", "Gebruikers ID");
$screen->SetLang("SETT_NAME", "Naam");
$screen->SetLang("SETT_LEVL", "Niveau");
?>
