<?php
session_start();
include_once('includes/connect.php');
include_once('includes/functions.php');
$page='index';
$title='Online Quiz to test your skills in Java,Python,MySQL,Testing';
$metatitle="Online Quiz to test your skills in Java,Python,MySQL,Testing";
$metadescription="Are you Preparing for your Interview in Testing, Java, Python, MySQL Platform.?.Here you can Check your Knowledge & test skills through our Online Quiz Exam.";
include('includes/header.php');
?>


<!-- Toppers list -->



  <!-- Page Content -->

<div class="container-fluid">
    <div class="row">
		<div class="col-sm-10 col-md-8">
			<div class="row navbar-padding banner clearfix">
			
				<?php       
					$res=$sql->query("SELECT * FROM `quiz_results` q where q.taken_at >= CURRENT_DATE - INTERVAL 7 DAY");
					$total_test_taken=$res->num_rows;
				?>
			    <div class="col-md-4 col-sm-12">
					<div class="total-test-box p-0">
						<div class="test-taken">
							<img src="vendor/img/total-test1.png">
							<h4><?=$total_test_taken*9?></h4>
						</div>
						<p>Weekly Test taken</p>
					</div>
				</div>
			  
			    <div class="col-sm-12 col-md-10 col-lg-8 text-center mt-5">
					<h1 class="mt-5"><span class="color-green">Take</span> a Online <a href="online-exam" class="btn btn-lg test-btn">Test <img src="vendor/img/arrow.png"></a>
					</h1>
					<p class="lead">Check your experties & improve your skills</p>
			    </div>				
		   </div>
		   <div class="row pt-5">
				<div class="col-sm-12 px-5">
					<h1 class="test-topic-heading text-left">Our Test Topics</h1>
				</div>
		    </div>
			<div class="row topic">
			  <div class="col-md-3">
				<a href="online-exam#Java">
				<div class="box">
				<span class="icon"><img src="vendor/img/software_dev.png"></span>
				<p>Java</p>
				</div></a>

			  </div>

			  <div class="col-md-3 ">
				<a href="online-exam#Python">
				  <div class="box">
				<span class="icon"><img src="vendor/img/one.png"></span>
				<p>Python</p></div></a>
			  </div>

			  <div class="col-md-3 ">
				<a href="online-exam#MySQL">
				  <div class="box">
				<span class="icon"><img src="vendor/img/pm.png"></span>
				<p>MySql</p></div></a>
			  </div>

			  <div class="col-md-3 ">
				<a href="online-exam#Testing">
				  <div class="box">
				<span class="icon"><img src="vendor/img/hr.png"></span>
				<p>Testing</p></div>
				</a>
			  </div>

			  <div class="col-md-3">
				<div class="box">
				<span class="icon"><img src="vendor/img/sales.png"></span>
				<p>Data Science</p>
				</div>
			  </div>

			  <div class="col-md-3 ">
				<div class="box">
				<span class="icon"><img src="vendor/img/opsit.png"></span>
				<p>Tensorflow</p></div>
			  </div>

			  <div class="col-md-3 ">
				<div class="box">
				<span class="icon"><img src="vendor/img/m.png"></span>
				<p>Numpy</p></div>
			  </div>

			  <div class="col-md-3 ">
				<div class="box">
				<span class="icon"><img src="vendor/img/sales.png"></span>
				<p>Matplotlib</p></div>
			  </div>
			</div> 
		</div>
		<div class="col-sm-4">
			<div class="topper-list-sidebar" id="top-scorer">
			
			   <div class="topper-list" >
				<h3 class="inner-sidebar-heading">Top Rankers <div class="col-sm-12 social-links text-center">			  
				<ul class="list-inline m-0 p-0" id="social-share">
				   <li class="list-inline-item"><a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('facebook')"><i class="fa fa-facebook social-icon" aria-hidden="true"></i></a></li>
				   <li class="list-inline-item"><a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('twitter')"><i class="fa fa-twitter social-icon" aria-hidden="true"></i></a></li>
				   <li class="list-inline-item"><a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('linkedin')"><i class="fa fa-linkedin social-icon" aria-hidden="true"></i></a></li>
				   <li class="list-inline-item"><a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('whatsapp')"><i class="fa fa-whatsapp social-icon" aria-hidden="true"></i></a></li>
				</ul>
			</div></h3>
				<div id="particle-container"></div>
				<table class="table" >
				  <tbody> 
			  <?php       
				$res=$sql->query("SELECT *, COUNT(email), concat(round(( (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"marks\":',-1),',',1))/(TRIM(BOTH '\"' FROM (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"total\":',-1),',',1))) ) * 100 )),'%') AS percentage FROM quiz_results where taken_at >= CURRENT_DATE - INTERVAL 7 DAY  GROUP BY email HAVING COUNT(email) > 1 order by CAST(percentage AS unsigned) desc, RAND() LIMIT 10");
				$total_subject=$res->num_rows;
				if($total_subject>0){ 
				while ($data=$res->fetch_assoc()) { $percent=str_replace('%','',$data['percentage']);
				$result=objectToArray(json_decode($data['result']));
				$sub=$sql->query("SELECT subject_name from subject su JOIN topics t ON t.subject_id=su.id where t.id=".$result['topic_id']);
				$subject=$sub->fetch_array();
				$name_topper=substr($data['name'],0,14);
			?>
				<tr>
				  <td class="text-center"><?= $name_topper ?></td>
				  <td class="text-center"><?=$subject['subject_name']?></td>
				  <td class="text-center" width="20%"> <?= $data['percentage']?> </td>  
				</tr>

				<?php } 
				 } ?>
				 
				 </tbody>
			   </table>

				
			  </div>
			  
		  </div> 
		 
		</div>
		
		
		
	</div>
	<div>

	</div>
	 <div class="row">
		 <section class="earth-bg">


          <div class="img-slider hero hero-img">

          </div>
		  <div class="col-lg-12 ">
			<div class="row ">

				<div class="col-lg-4 three-section">
				  <div class="margin-box-first">
					<a href="https://javabykiran.com/" class="btn btn-primary">Classroom Training</a>
					<a href="https://javabykiran.com/" class="btn btn-info">Online Classroom Training</a>
					<a href="https://javabykiran.com/java-j2ee-ojt/" class="btn btn-danger">OTJ</a>
					<a href="https://javabykiran.com/java-by-kiran-classes-batch-schedule/" class="btn btn-warning">Course Starting Soon</a>
				  </div>
				</div>

				<div class="col-lg-4">
				  <a href="https://javabykiran.com/java-by-kiran-classes-batch-schedule/"><div class="black-box">
					<div class="inner-box">
					  <h2>Upcoming Online Batch Schedule</h2>
					</div>
				  </div>
				</a>
			  </div>

			  <div class="col-lg-4 youtube">
				<div class="margin-box">

				  <div class="ytb-box">
				   <iframe width="100%" height="250px" src="https://www.youtube.com/embed/Crx4od9e1p8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

				   <div class="ytb-heading">
					 <h4><img src="vendor/img/ytb.png">Live Videos
					 </h4>
				   </div>
				 </div>
			   </div>
			 </div>
		  </div>
		</div>
		</section> 			
	</div>
	
	<div class="row our-courses-section text-center">
    <div class="col-lg-12">
      <div class=" our-courses"><h2>Our Top Courses</h2></div>
      <p class="our-c-p">Choose from the following path or complete bundle of classroom training. Each training is handled by a team of experienced professionals who has years of experience in this perticular field.</p>

      <div class="course-section">

        <div>
          <a href="https://javabykiran.com/java-classes-in-pune/"><img src="vendor/img/java2.png">
            <h4>Core Java</h4>
          </a>
        </div>
        <div>
          <a href="https://javabykiran.com/selenium-classes-in-pune/"><img src="vendor/img/selenium2.png">
            <h4>Selenium</h4>
          </a>
        </div>
        <div>
          <a href="https://javabykiran.com/python-classes-in-pune/"><img src="vendor/img/python2.png">
            <h4>Python</h4>
          </a>
        </div>
      </div>

    </div>

    <!-- php code to send email directly form form -->
              <?php 
              $mailErr="";
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "javabykiran@gmail.com"; // this is your Email address
    $from = $_POST['email-mailUs']; // this is the sender's Email address
    /* Form Data */  

    $email = $_POST['email-mailUs'];
    $subject = "Form submission on Mail US Index page - jbktest.com";
    $subject2 = "Copy of your Form submission  on Mail US Index page - jbktest.com";
    
    if (empty($email) ){
      $mailErr="required";
    }
    else{
      $message ="Email  : ".$email; 

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;

    $sent1=mail($to,$subject,$message,$headers);
    $sent2=mail($from,$subject2,$message,$headers2); // sends a copy of the message to the sender

    echo "<div class='mail-success'>Mail Sent. We will contact you shortly.</div>";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    }
    
  }
  ?>

    <div class="container">
      <div class="subscribe row">
        <p>Get in touch with us</p>
        <form action="" method="post" >
          <input type="text" name="email-mailUs" placeholder="Enter your email">
          <span class="error"><?=$mailErr?></span>
          <button type="submit" name="mailUs" class="btn btn-mailUs">Mail Us</button>

        </form>
      </div> 
    </div>
	
	
	<!--- Image for canvas-->
		<!--<div class="topper-list-sidebar d-none" id="top-scorer" style="width: 659px; height:450px">
			   <div class="topper-list" >
				<h3 class="inner-sidebar-heading">Top Rankers <div class="col-sm-12 social-links text-center">			  
			</div></h3>
				<table class="table" >
				  <tbody> 
			  <?php       
				/*$res=$sql->query("SELECT *, COUNT(email), concat(round(( (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"marks\":',-1),',',1))/(TRIM(BOTH '\"' FROM (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"total\":',-1),',',1))) ) * 100 )),'%') AS percentage FROM quiz_results where taken_at >= CURRENT_DATE - INTERVAL 7 DAY  GROUP BY email HAVING COUNT(email) > 1 order by CAST(percentage AS unsigned) desc, RAND() LIMIT 10");
				$total_subject=$res->num_rows;
				if($total_subject>0){ 
				while ($data=$res->fetch_assoc()) { $percent=str_replace('%','',$data['percentage']);
				$result=objectToArray(json_decode($data['result']));
				$sub=$sql->query("SELECT subject_name from subject su JOIN topics t ON t.subject_id=su.id where t.id=".$result['topic_id']);
				$subject=$sub->fetch_array();
				$name_topper=substr($data['name'],0,14);*/
			?>
				<tr>
				  <td class="text-center"><?= $name_topper ?></td>
				  <td class="text-center"><?=$subject['subject_name']?></td>
				  <td class="text-center" width="20%"> <?= $data['percentage']?> </td>  
				</tr>

				<?php //} 
				 //} ?>
				 </tbody>
			   </table>
			  </div>
		  </div>-->

  </div>
</div> <!-- End of container fluid -->
 
<?php include('includes/footer.php'); ?>
<script>
/* ---- particles.js config ---- */

particlesJS("particle-container", {
  "particles": {
    "number": {
      "value": 100,
      "density": {
        "enable": true,
        "value_area": 100
      }
    },
    "color": {
      "value": "random"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#000000"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.5,
      "random": false,
      "anim": {
        "enable": false,
        "speed": 1,
        "opacity_min": 0.1,
        "sync": false
      }
    },
    "size": {
      "value": 3,
      "random": true,
      "anim": {
        "enable": false,
        "speed": 40,
        "size_min": 0.1,
        "sync": false
      }
    },
    "line_linked": {
      "enable": false,
      "distance": 150,
      "color": "#ffffff",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 10,
      "direction": "none",
      "random": false,
      "straight": false,
      "out_mode": "out",
      "bounce": true,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": false,
        "mode": "repulse"
      },
      "onclick": {
        "enable": false,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 400,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 400,
        "size": 40,
        "duration": 2,
        "opacity": 8,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});

var element = $("#top-scorer"); // global variable
var getCanvas; // global variable
function socialsharingbuttons(social){
  event.preventDefault(); 
  //$('#top-scorer').removeClass('d-none');
  post_data = {
	'title' : "JBKTEST Top Scorer of this week",
	'topscore' : $('#certificate img').attr('src'),
  }; 
  /*html2canvas(element, {
         onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
             }
         });*/
		 html2canvas($("#top-scorer"), { 
					onrendered: function(canvas) { 
						var imgsrc = canvas.toDataURL("image/png"); 
						var dataURL = canvas.toDataURL(); 
						$.ajax({ 
							type: "POST", 
							url: "script", 
							data: { 
								imgBase64: dataURL 
							} 
						}).done(function(o) { 
							console.log(); 
						}); 
					},
				});
  var d = new Date();
  var time = d.getTime();
  var url = "<?=$siteurl?>?"+time; 
  var button= '';
  switch (social) {
   case 'facebook':
    button='http://www.facebook.com/share.php?u='+url;
    break;
   case 'twitter':
    button='https://twitter.com/share?url='+url;
    break;
   case 'whatsapp':
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
     button='whatsapp://send?text='+url;
    }else{
     button='https://web.whatsapp.com/send?text='+url;
    }
    break;
   case 'linkedin':
    button='http://www.linkedin.com/sharing/share-offsite/?url='+url;
    break;
   default:
    break;
  }
 // $('#top-scorer').addClass('d-none');
   window.open(button,'sharer','toolbar=0,status=0,width=648,height=395');
  return false;
 }
</script>