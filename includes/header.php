<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('allow_url_fopen',1);
if( in_array( $_SERVER['REMOTE_ADDR'], array( '127.0.0.1', '::1' ) ) ) { // debug mode on localhost ('127.0.0.1' IP in IPv4 and IPv6 formats)
	$siteurl="http://localhost/jbktest/";
}else{
	$siteurl='https://'.$_SERVER['HTTP_HOST'].'/qa/';
}
//include('functions.php');
$sitename="Java By Kiran";
$logourl= $siteurl."images/logojbk.png";
$topperurl= $siteurl."images/top_score.png";
?>
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
  <meta property="og:locale" content="en_US">
  <meta property="og:type" content="article">
  <?php if(isset($_SERVER['QUERY_STRING'])&&(!empty($_SERVER['QUERY_STRING']))){
	  if($_SERVER['REQUEST_URI']=="/qa/online-exam"){?>
  <meta property="og:title" content="Appreciation Certificate - JBKTEST">
  <meta property="og:description" content="A complete bundle of classroom training. Each training is handled by a team of experienced professionals who has years of experience in this particular field.">
  <meta property="og:image" content="https://jbktest.com/qa/images/certificate/<?="certificate".$_SERVER['QUERY_STRING'].'.png'?>">
  <meta property="og:image:width" content="1366">
  <meta property="og:image:height" content="768">
	  <?php } else{ ?>
  <meta property="og:title" content="Celebrating Top Scorer of this Week">
  <meta property="og:description" content="JBK proudly congralute top score of this week. You can take test in various subject and check your knowledge based on your score JBK celebrates top score">
  <meta property="og:image" content="<?=$topperurl?>">
  <meta property="og:image:width" content="900">
  <meta property="og:image:height" content="500">
  <?php  } }
	else { ?>
  <meta property="og:title" content="<?=$metatitle?>">
  <meta property="og:description" content="<?=$metadescription?>">
  <meta property="og:image" content="<?=$logourl?>">
  <meta property="og:image:width" content="1366">
  <meta property="og:image:height" content="768">
  <?php }?>
  <meta property="og:site_name" content="JBKTEST">
  
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:creator" content="@jbktest" />
  <meta name="twitter:site" content="@jbktest" />
  <meta name="twitter:label1" content="Written by">
  <meta name="twitter:data1" content="JBKTEST">
  <meta name="twitter:label2" content="Est. reading time">
  <meta name="twitter:data2" content="2 minutes">
  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/css/style.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&family=Noto+Serif+JP:wght@200;400&family=Poppins:wght@400;500;600&family=Roboto&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Raleway:wght@400;600&display=swap" rel="stylesheet">

  <link href="css/style.css" rel="stylesheet">


 <!-- <link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="vendor/slick/slick-theme.css">
-->
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-148582826-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-148582826-2');
</script>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container-fluid">
      
      <a class="navbar-brand" href="<?=$siteurl ?>"><img src="vendor/img/logo5.png"></a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

       <div class="collapse navbar-collapse navbar-content" id="navbarResponsive">
        <ul class="navbar-nav margin-nav">
          <li class="nav-item active">
            <a class="nav-link" href="<?=$siteurl ?>">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://javabykiran.com/java-classes-in-pune/">Syllabus</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.jbktutorials.com/interview-questions.php#gsc.tab=0">Interview Question</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://javabykiran.com/java-classes-contact-pune/">Contact Us</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://javabykiran.com/java-by-kiran-videos/">Live Videos</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="https://www.jbktutorials.com/">Tutorials</a>
          </li>
        </ul>

        <div class="home-btn">
          <a href="contribute.php" class="btn ">Contribute 
            <img src="vendor/img/arrow.png">
          </a>
        </div>

      </div>     
    </div>
  </nav>

