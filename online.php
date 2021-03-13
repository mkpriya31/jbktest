<?php

echo $_SERVER['QUERY_STRING']
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
                <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?=$title?></title>
        <!-- Twitter Share -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@jbktest">
        <meta name="twitter:creator" content="@mytwitterhandle">
        <meta name="twitter:title" content="<?=$title?>">
        <meta name="twitter:image" content="<?="https://jbktest.com/qa/images/certificate/".$_SERVER['QUERY_STRING'].'.png'?>">
        <!-- Facebook/LinkedIn Share -->
        <meta property="og:url" content="https://www.jbktest.com/qa/online-exam" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="<?=$title?>" />
        <meta property="og:description" content="We have good news, LinkedIn has launched Post Inspector. You have to do the following to clear LinkedIn Preview cache: We have good news, LinkedIn has launched Post Inspector. You have to do the following to clear LinkedIn Preview cache: We have good news, LinkedIn has launched Post Inspector. You have to do the following to clear LinkedIn Preview cache: We have good news, LinkedIn has launched Post Inspector. You have to do the following to clear LinkedIn Preview cache:" />
        <meta property="og:image" content="<?="https://jbktest.com/qa/images/certificate/".$_SERVER['QUERY_STRING'].'.png'?>" />
		<meta property="og:image:width" content="1366" />
	    <meta property="og:image:height" content="768" />
    </head>
</html>