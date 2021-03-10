<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <?php
        $root = "https://www.jbktest.com/meta";
        ?>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Page Title</title>
        <!-- Twitter Share -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@Mysite">
        <meta name="twitter:creator" content="@mytwitterhandle">
        <meta name="twitter:title" content="Title">
        <meta name="twitter:image" content="https://www.jbktest.com/vendor/img/sc5.png">
        <!-- Facebook/LinkedIn Share -->
        <meta property="og:url" content="https://www.jbktest.com/meta" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Title" />
        <meta property="og:description" content="Description" />
        <meta property="og:image" content="https://www.codexworld.com/wp-content/uploads/2016/03/how-to-create-custom-social-share-links-by-codexworld.png" />
		<meta property="og:image:width" content="1366" />
	    <meta property="og:image:height" content="768" />
    </head>
    <body>
    <div>Static body content</div>
    </body>
</html>
<div id="quizresult" class="text-center" style="">	
                    <h3 class="modal-title text-danger text-center p-0 mb-3" id="quizheading">Your Result</h3>   				
					<div id="msg"><h3 class="text-warning text-center">Average!!!</h3><p>You have few more questions to clear</p></div>
					<p>Marks obtained by you <span id="score">3</span> out of <span id="total">10</span> </p>
					<div class="btn btn-outline-primary shadow text-center view-answer">View Answer</div>
				</div>
				
<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('linkedin')">Linkedin</a>
<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('facebook')">Facebook</a>
<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('twitter')">Twitter</a>
<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('whatsapp')">Whatsapp</a>


<script type="text/javascript">
function socialsharingbuttons(social){
  
  var url = 'https://www.jbktest.com/meta'; 
  params = {
	   'url' : url,
	   'title' : "How to share social media imagea",
	   'img' : 'https://www.jbktest.com/vendor/img/sc5.png'
      }; 
	console.log(params); 
 // var params = JSON.parse(params);
  var button= '';
  switch (social) {
   case 'facebook':
    button='http://www.facebook.com/share.php?u='+params.url+ '&t=' + params.title+'&picture='+params.img;
    break;
   case 'twitter':
    button='https://twitter.com/share?url='+params.url+'&amp;text='+params.title+'&amp;hashtags='+params.tags;
    break;
   case 'whatsapp':
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
     button='whatsapp://send?text='+params.url;
    }else{
     button='https://web.whatsapp.com/send?text='+params.url;
    }
    break;
   case 'linkedin':
    button='http://www.linkedin.com/shareArticle?mini=true&amp;url='+params.url;
    break;
   default:
    break;
  }
   window.open(button,'sharer','toolbar=0,status=0,width=648,height=395');
  return false;
 }
</script>