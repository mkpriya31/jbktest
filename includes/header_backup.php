<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('allow_url_fopen',1);
if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) { // debug mode on localhost ('127.0.0.1' IP in IPv4 and IPv6 formats)
	$siteurl="http://localhost/jbktest/";
}else{
	$siteurl="https://www.jbktest.com/";
}
//include('functions.php');
$sitename="Java By Kiran";
$logourl= $siteurl."images/logojbk.png";


//echo $_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <title><?php echo $metatitle;?></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="<?php echo $metadescription;?>">
	<meta name="robots" content="index, follow">
	<meta name="language" content="English">
	<meta name="revisit-after" content="3">
	<meta name="author" content="Java By Kiran">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<!-- Bootstrap core CSS -->
	<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="https://fonts.googleapis.com/css?family=Poppins&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/font-awesome-animation.min.css">
	<!-- Custom styles for this template -->
	<link href="css/modern-business.css" rel="stylesheet">
	<link href="css/circular-prog-bar.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
  </head>
  <body <?=($page!='index')?'class="bgb-grey"':'';?>>
  <!-- Navigation -->
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-gradient fixed-top">
    <div class="container">
      <a class="navbar-brand" href="<?=$siteurl?>"><img src="images/logo.png" title="JBK TEST" alt="JBK TEST"></a>
	  <?php if($page=='index'){?>
	  <div class="col-sm-7 text-center m-auto top-scorer"><i class="fa fa-3x fa-hand-o-down faa-bounce animated dark-blue"></i><br/><span class="awesome">Check Top Scorer</span></div>
	  <?php } ?>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
		  <li class="nav-item">
            <a class="nav-link online" href="<?=$siteurl?>online-exam#Java" data-val='Java'>Java</a>
          </li>
          <li class="nav-item">
            <a class="nav-link online" href="<?=$siteurl?>online-exam#Python" data-val='Python'>Python</a>
          </li>
          <li class="nav-item">
            <a class="nav-link online" href="<?=$siteurl?>online-exam#MySQL" data-val='MySQL'>MySQL</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact.html">FAQ</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>