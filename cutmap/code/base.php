<?php
	$g_home_path = realpath(dirname(__FILE__)."/../");
	define ("g_url_site", "labyrinthware.com");
	define ("g_name_site", "Labyrinth");

//	define ("g_db_host", "localhost");
//	define ("g_db_user", "brenton");
//	define ("g_db_pass", "NevaNumb");
//	define ("g_db_general", "general");

	//define ("g_db_host", "box1051.bluehost.com");
	define ("g_db_host", "localhost");
  //define ("g_db_user", "labyrio7_prod");
  define ("g_db_user", "labyrio7_brenton");
//	define ("g_db_pass", "Rendang0-");
	define ("g_db_pass", "NevaNumb0-");
	define ("g_db_general", "labyrio7_general");
	// In production environment, I don't want any reporting. It reveals my
	// db user name when the connection fails.
  //error_reporting(0);
  //error_reporting (E_ALL);
?>
