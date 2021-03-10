<?php
session_start();
include_once('includes/connect.php');
include_once('includes/functions.php');
$page='index';
$title='Contribute | JavaByKiran';
$metatitle="Contribute | Earn Reaward Points - JavaByKiran";
$metadescription="";
include('includes/header.php');
?>


  <!-- Page Content -->



  <div class="container">
    <div class="row navbar-padding">
      <div class="col-lg-12 text-center c-padding ">



            <div class="row">

              <div class="col-md-8">
                <div class="contribute-left-heading">
                  <h2>Earn reward points and Get cash credits to your account</h2>
                  <p>Fill in the form and become a Contributor or Moderator to Earn exciting rewards and get paid.</p>
                  <img src="vendor/img/team1.png">
                  
                </div>


              </div> <!-- End of col-6 -->

              <!-- php code to send email directly form form -->
<?php 

  $nameErr=$emailErr=$numberErr=$selectErr=$first_name=$email=$number=$select="";
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "javabykiran@gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    /* Form Data */  
    $first_name = $_POST['first_name'];
    $email = $_POST['email'];
    $number = $_POST['phone_number'];
    $select = $_POST['select'];

    if (empty($first_name)) {
      $nameErr = "required";
    }
    if (empty($email) ){
      $emailErr = "required";
    }
    if (empty($number) ){
      $numberErr = "required";
    }


    if(!empty($first_name) && !empty($email) && !empty($number)){
      $subject = "Form submission on Contribute Page - jbktest.com";
    $subject2 = "Copy of your Form submission on Contribute Page - jbktest.com";
    

    $message ="Name : ".$first_name."\nEmail Id : ".$email."\nContact Number : ".$number."\nOpted for : ".$select; 

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;

    $sent1=mail($to,$subject,$message,$headers);
    $sent2=mail($from,$subject2,$message,$headers2); // sends a copy of the message to the sender

    echo "<div id='mail_success' class='mail-success'>Mail Sent. Thank you " . $first_name . ", we will contact you shortly.</div>";
    }
    
    // You can also use header('Location: thank_you.php'); to redirect to another page.
  }
  ?>

              <div class="col-md-4">
                <form class="form-style" action="" method="post">
                  <div class="form-group">
                    <label for="">Full Name *</label>
                    <input type="text" class="form-control" name="first_name" value="<?=$first_name ?>">
                    <span class="error"><?= $nameErr ?></span>
                    
                  </div>
                  <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" class="form-control" name="email" aria-describedby="nameHelp" value="<?=$email ?>">
                    <span class="error"><?= $emailErr ?></span>
                    <small id="nameHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                  </div>

                  <div class="form-group">
                    <label for="Phone Number">Phone Number *</label>
                    <input type="tel" class="form-control" id="phone" name="phone_number" placeholder="+91 xxxxxxxxxx" value="<?=$number ?>" >
                    <span class="error"><?= $numberErr ?></span>
                    
                  </div>

                  <div class="form-group">
                    <label for="exampleFormControlSelect1">Select *</label>

                    <select class="form-control" id="exampleFormControlSelect1" name="select" >
                      <option value="Contributor">Contibutor</option>
                      <option value="Moderator">Moderator</option>
                     
                    </select>
                  </div>
                  <button type="submit" name="submit" class="btn btn-contribute">Submit</button>

                </form><!-- End of form -->
              </div> <!-- End of col-4 -->


              

            </div> <!-- End of Row -->
      

      </div> <!-- End of Col-12 -->
    </div>  <!-- End of row -->
  </div>  <!-- End of Container -->

  <div class="container-fluid">
   
    <div class="row" >
      <div class="how-contributor">

        <div class="col-lg-12">
          <h2>How it works If you are a Contributor or Moderator.</h2>
          <p>Click below to know more</p>
          <div class="c-padding">
            <button class="btn btn-primary" id="show-contributor">Contributor</button>
            <button class="btn btn-danger" id="show-moderator">Moderator</button>
          </div>
          
          <div class="row intruction-contributor" id="contributor">
            
            <div class="col-lg-12 display-flex">
              <div class="col-lg-3">
               <div class="box">
                 <img src="vendor/img/contri-img1.png">
                 <p class="description">Add a Question</p>
               </div> 
             </div>

             <div class="col-lg-3">
               <div class="box">
                 <img src="vendor/img/contri-img1.png">
                 <p class="description">Question will be reviewed</p>
               </div> 
             </div>

             <div class="col-lg-3">
               <div class="box">
                 <img src="vendor/img/contri-img1.png">
                 <p class="description">Moderator will Approve</p>
               </div> 
             </div>

             <div class="col-lg-3">
               <div class="box">
                 <img src="vendor/img/contri-last-img.png">
                 <p class="description">You get reward points</p>
               </div> 
             </div>
           </div>

         </div>

         <div class="row hide intruction-contributor" id="moderator">
          <div class="col-lg-12 display-flex">
            <div class="col-lg-3">
             <div class="box">
               <img src="vendor/img/contri-img2.png">
               <p class="description">You will get question for review</p>
             </div> 
           </div>

           <div class="col-lg-3">
             <div class="box">
               <img src="vendor/img/contri-img2.png">
               <p class="description">Question will be reviewed</p>
             </div> 
           </div>

           <div class="col-lg-3">
             <div class="box">
               <img src="vendor/img/contri-img2.png">
               <p class="description">You will be approved</p>
             </div> 
           </div>

           <div class="col-lg-3">
             <div class="box">
               <img src="vendor/img/contri-last-img2.png">
               <p class="description">Reward points credited once your approval reviewed</p>
             </div> 
           </div>
         </div>

       </div>


        
        </div>

      </div>
    </div> <!-- End of Row -->

    <div class="row hide" >
      <div class="how-contributor">

        <div class="col-lg-12">
          <h2>How It works?</h2>
          
          
        
        </div>

      </div>
    </div> <!-- End of Row -->

    
  </div>  <!-- End of container fluid -->


  </div> <!-- End of container fluid -->
<?php include('includes/footer.php'); ?>

<script type="text/javascript">

  $("#show-contributor").click(function(){
  $("#moderator").hide();
  $("#contributor").show();
    });

  $("#show-moderator").click(function(){
  $("#moderator").show();
  $("#contributor").hide();

  });
</script>
