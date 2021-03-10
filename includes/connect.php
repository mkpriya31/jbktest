<?php
    if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) {
		define('DB_SERVER',"localhost");
		define('DB_USER',"root");
		define('DB_PASS',"");
		define('DB_NAME',"jbktest");
	}else{
		define('DB_SERVER',"localhost");
		define('DB_USER',"jbktestc_jbkuser");
		define('DB_PASS',"}WZ_CCjEg^H^1");
		define('DB_NAME',"jbktestc_online_quiz_portal");
	}

	$sql = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);

	/* check connection */
	if ($sql->connect_errno) {
		die("Database connection failed: " . $sql->connect_error);
		exit();
	}
?>
