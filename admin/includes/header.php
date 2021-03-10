<?php
	session_start();ob_start();
	include_once('../includes/connect.php');
	
	if(!isset($_SESSION['username'])) {
		header('location: index');
	}
	
	if($page!='question'){
		unset($_SESSION['searchval']);
	}
	
	if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) { // debug mode on localhost ('127.0.0.1' IP in IPv4 and IPv6 formats)
		$siteurl="http://localhost/javabykiran/";
		$siteadminurl="http://localhost/javabykiran/admin/";
	}else{
		$siteurl="https://www.javabykiran.com/";
		$siteadminurl="https://www.javabykiran.com/admin/";
	}
	include('../includes/functions.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=$title." - JBK TEST"?></title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
   <!-- <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">-->

    <!-- DataTables Responsive CSS -->
    <!--<link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">-->

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
	<link href="css/jquery.dataTables.min.css" rel="stylesheet">
	
    
    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">
    
    <!-- Editor CSS -->
    <link href="vendor/editor/editor.css" rel="stylesheet">
    
    <!-- datepicker CSS -->
    <link href="vendor/bootstrap-datepicker/css/datepicker.css" rel="stylesheet">
    
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
