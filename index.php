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
<div class="topper-list-sidebar">
   <h3 class="sidebar-heading">Topper's List</h3>
   <div class="topper-list">
    <h3 class="inner-sidebar-heading">Topper's List</h3>
    <table class="table">
      <tbody>
        
      
  <?php       
     //echo "SELECT *, SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"marks\":',-1),',',1) AS scorev FROM `quiz_results` q where q.taken_at >= DATE(NOW()) - INTERVAL 7 DAY order by scorev desc LIMIT 5"; group by SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"topic_id\":',-1),',',1) 
    
    //$res=$sql->query("SELECT *, concat(round(( (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"marks\":',-1),',',1))/(TRIM(BOTH '\"' FROM (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"total\":',-1),',',1))) ) * 100 )),'%') AS percentage FROM `quiz_results` q where q.taken_at >= CURRENT_DATE - INTERVAL 7 DAY order by CAST(percentage AS unsigned) desc, RAND() LIMIT 5 ");
    //$res=$sql->query("SELECT q.*, concat(round(( (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"marks\":',-1),',',1))/(TRIM(BOTH '\"' FROM (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"total\":',-1),',',1))) ) * 100 )),'%') AS percentage FROM `quiz_results` q JOIN topics t ON t.id=TRIM(BOTH '\"}' FROM (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"topic_id\":\"',-1),',',1))) where q.taken_at >= CURRENT_DATE - INTERVAL 7 DAY group by SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"topic_id\":',-1),',',1) order by CAST(percentage AS unsigned) desc, RAND() LIMIT 5");
    $res=$sql->query("SELECT *, COUNT(email), concat(round(( (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"marks\":',-1),',',1))/(TRIM(BOTH '\"' FROM (SUBSTRING_INDEX(SUBSTRING_INDEX(result,'\"total\":',-1),',',1))) ) * 100 )),'%') AS percentage FROM quiz_results where taken_at >= CURRENT_DATE - INTERVAL 7 DAY  GROUP BY email HAVING COUNT(email) > 1 order by CAST(percentage AS unsigned) desc, RAND() LIMIT 5");
       $total_subject=$res->num_rows;
       if($total_subject>0){ 
       while ($data=$res->fetch_assoc()) { $percent=str_replace('%','',$data['percentage']);
     $result=objectToArray(json_decode($data['result']));
     $sub=$sql->query("SELECT subject_name from subject su JOIN topics t ON t.subject_id=su.id where t.id=".$result['topic_id']);
     $subject=$sub->fetch_array();
     $name_topper=substr($data['name'],0,14);
?>
    <tr>
      <td><?= $name_topper ?></td>
      <td><?=$subject['subject_name']?></td>
      <td> <?= $data['percentage']?> </td>  
    </tr>

    <?php } 
     } ?>
     </tbody>
   </table>


  </div>
</div> 


<div class="container-fluid">
    <div class="row navbar-padding banner ">

      <div class="col-md-12 text-center">
        <h1 class="mt-5"><span class="color-green">Take</span> a Online <a href="online-exam" class="btn btn-lg test-btn">Test <img src="vendor/img/arrow.png"></a>
        </h1>
        <p class="lead">Check your experties & improve your skills</p>
      </div>


    <?php       
    $res=$sql->query("SELECT * FROM `quiz_results` q where q.taken_at >= CURRENT_DATE - INTERVAL 7 DAY");
        $total_test_taken=$res->num_rows;
    ?>

       <div class="total-test-box">
        <div class="test-taken">
          <img src="vendor/img/total-test1.png">
          <h4><?=$total_test_taken*9?></h4>
        </div>
        <p>Weekly Test taken</p>
      </div>

    </div>

  

    <div class="row ">
      
      <div class="col-lg-12 text-center">

        <h1 class=" test-topic-heading">Our Test Topics</h1>
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



        </div>  

        <div class="row topic">
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
        <!-- <div class=" regular slider">
          
          <a href="#" class="t-item">
            <div class="box b-color1">
              <h3>Java</h3>
              <img src="vendor/img/javal.jpg">
            </div>
          </a>

          <a href="#" class="t-item">
            <div class="box b-color2">
              <h3>MySql</h3>
              <img src="vendor/img/mysqll.jpg">
            </div>
          </a>

          <a href="#" class="t-item">
            <div class="box b-color3">
              <h3>Python</h3>
              <img src="vendor/img/python.jpg">
            </div>
          </a>

          <a href="#" class="t-item">
            <div class="box b-color4">
              <h3>Selenium</h3>
              <img src="vendor/img/selenium.jpg">
            </div>
          </a>

          <a href="#" class="t-item">
            <div class="box b-color5">
              <h3>Php</h3>
              <img src="vendor/img/python.jpg">
            </div>
          </a>
        </div> -->


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

   <div class="row our-courses-section">
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

  </div>




</div><!-- End of col-lg-12-->
</div><!-- End of row -->

  




</div> <!-- End of container fluid -->
  
<?php include('includes/footer.php'); ?>
