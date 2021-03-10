<?php
	session_start();
	include('../includes/connect.php');
	if(isset($_SESSION['username'])) {
		unset($_SESSION['username']);
		unset($_SESSION['usertype']);
		session_destroy();
	 }

	header('location: index');

?>