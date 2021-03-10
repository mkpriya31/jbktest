<?php
session_start();
	include('../includes/connect.php');
	$username = $sql->real_escape_string($_POST['username']);
	$password = $sql->real_escape_string($_POST['password']);
	$result = $sql->query("SELECT * FROM users WHERE username = '".$username."' AND password = md5('".$password."')");
	if($result->num_rows>0){
		while ($data = $result->fetch_array()) {
			$id = $data['id'];
			$user_role = $data['user_role'];
		}
		//$admin = session_name("jbk_portal");
		//session_start($admin);
		$_SESSION['username'] = $username;
		$_SESSION['id'] = $id;
		$_SESSION['user_role'] = $user_role;
		
		$output = json_encode(array('type'=>'success', 'action' => $user_role));
	} else {
		$output = json_encode(array('type'=>'error', 'action' => '<div class="alert alert-danger text-center">Incorrect Username or Password!</div>'));
	}
	die($output);	
?>