<?php
session_start();
include_once('includes/connect.php');
$page='fresherzone';
$title='Get Started | Take a Online Test';
$metatitle="Practice Online Quiz | Take a Online Test - JavaByKiran";
$metadescription="";
include('includes/header.php');
$colo_box=['#0061ff','#ff0476','#02363d','#00bf6f','#0061ff','#ff0476','#02363d','#00bf6f','#0061ff','#ff0476','#02363d','#00bf6f','#0061ff','#ff0476','#02363d','#00bf6f'];
?>

<div class="container-fluid bg-offwhite">
  <br><br>
  <!-- Page Content -->

  <div class="container-fluid my-5 page-container ">
    <!-- Marketing Icons Section -->
    <div class="row">
    	
    	<div class="col-lg-2 ">
    		<div class="topics ml-2 bg-white nav flex-column nav-pills">
    			<?php 
    			$where="WHERE active=1 ORDER by id desc";				
    			$res=$sql->query("SELECT * FROM subject $where");
    			$total_subject=$res->num_rows;
    			
    			if($total_subject>0){ 
    				$i=1;
    				while ($data=$res->fetch_assoc()) { 
    					$where="WHERE subject_id=".$data['id']." and status=1 and is_reviewed=1";					
    					$top=$sql->query("SELECT * FROM questions $where");
    					$total_topics=$top->num_rows;
    					$sub_name=$data['subject_name'];
    					$first_letter= $sub_name[0];
    					?>
    					<a class="nav-link <?=($i==1)?'active':''?> border-bottom p-3 text-dark" data-toggle="pill"  href="#<?=str_replace(' ','-',$data['subject_name'])?>" role="tab">
    						<div class="link-box " style="background-color:<?= $colo_box[$i]?>"><?= $first_letter?></div>
    					 <?=$sub_name?>
    					 <!-- .' <span class="text-dark">('.$total_topics.')</span>' -->
    					 	
    					 </a>		   		
    					<?php $i++;}} ?>
    		</div>
    	</div>
	  
	  <div class="col-lg-10 bg-white  p-0 tab-content" id="v-pills-tabContent">
	  <?php 
				    $where="WHERE active=1 ORDER by id desc";				
	                $res=$sql->query("SELECT * FROM subject $where");
                    $total_subject=$res->num_rows;
                    if($total_subject>0){ $i=1;
                    while ($data=$res->fetch_assoc()){ //print_r($data); 
						$where="WHERE subject_id=".$data['id']." ORDER by id desc";							
						$top=$sql->query("SELECT * FROM topics $where");
						$total_topics=$top->num_rows;
						
					?>
					<div class="tab-pane fade show <?=($i==1)?'active':''?> card border-0" id="<?=str_replace(' ','-',$data['subject_name'])?>" role="tabpanel">
						<h3 class="text-dark text-center card-header border-0 bg-white"><?=$data['subject_name']?></h3>
						<div class="row mb-1 topics-list card-body m-0">
							<?php	
							if($total_topics>0){
								while($topics=$top->fetch_assoc()){ 
								$wheretop="WHERE topic_id=".$topics['id']." and status=1 and is_reviewed=1";
								$quesres=$sql->query("SELECT * FROM questions $wheretop");
								$totalquestions=$quesres->num_rows;
								?>
									<div class="col-md-2 subject-list">
										<a data-toggle="modal" data-id="<?=$topics['id']?>" class="showmodal text-dark"><p><?=$topics['topic']?></p>
											<!-- .' <span class="text-danger">('.$totalquestions.')</span>' -->
											<div class="take_quiz_btn" style="background-color:<?= $colo_box[$i] ?>">Take Quiz</div>
										</a>
									</div>
							  <?php  } }?>
						</div>	
                    </div>					
					<?php $i++;}} ?>
	  </div>
    </div>
    <!-- /.row -->
	
  </div>
  <!-- /.container -->
</div>
<?php include('includes/footer.php'); ?>
<script>
var hash;
$(document).ready(function() {
hashtag();
function hashtag(){
	if(window.location.hash!=''){
		hash=window.location.hash;
		$(".nav-pills a[href='"+hash+"']").trigger("click");
		$('.navbar-nav .nav-link').removeClass('active');
		var title = window.location.hash.substring(1);
		$(".navbar-nav a[data-val='"+title+"']").addClass('active');
	}   
}
});

$('.online').click(function(){
	hashv=$(this).data('val');
	$('.nav-item .nav-link').removeClass('active');
	$(this).addClass('active');
	$('#v-pills-tabContent .tab-pane, .nav-pills .nav-link').removeClass('active');
	$(".nav-pills a[href='#"+hashv+"']").addClass('active');
	$('#'+hashv).addClass('active show');
});


$('.nav-pills .nav-link').click(function(){
	hashv=$(this).attr('href');
	$('.navbar-nav .nav-link').removeClass('active');
	$(".navbar-nav a[data-val='"+hashv.substring(1)+"']").addClass('active');
});

</script>
 <div id="take-quiz" class="modal hide fade mt-5" style="display: none;" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
		<div class="">
      	    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		</div>
        <form method="post" class="quiz_form" id="quiz_form">
            <input type="hidden" value="" id="#hashval">
            <div class="modal-body text-secondary p-4">
				<div id="quizcount">
				    <h3 class="modal-title text-danger text-center p-0 mb-3" id="quizheading">Take a Quiz</h3> 
				    <p class="mt-1 p-2 text-center text-secondary" id="quizcontent">How many questions you want to take</p>
					<input type="hidden" id="topic_id" name="topic_id" value="" >
					<div class="form-group text-center">                   
						 <input type="radio" name="count" value="10" checked="checked"> 10
						 <input type="radio" name="count" value="20"> 20
						 <input type="radio" name="count" value="25"> 25
					</div>
					<div class="form-group m-auto text-center">
					   <button type="submit" id="countbtn" class="btn quiz-btn btn-md next" tabindex="3">Next</button>
				    </div> 
					<a href="http://javabykiran.com/"> @javabykiran </a>
			   </div>
			   
				<div id="quizemail">
					<h3 class="modal-title text-danger text-center p-0  mb-3" id="quizheading">Personal Details</h3> 
                    <p class="mt-1 mb-0 p-2 text-center text-secondary  mb-3" id="quizcontent">Fill your email id and take a quiz</p>
					<div class="form-group">
					   <label for="name" class="text-dark">Name</label>
					   <input type="text" name="name" id="name" class="form-control" value="">
					   <div id="nameerr" class="text-center text-danger"></div> 
					</div>
					<div class="form-group">
					   <label for="email" class="text-dark">Email Address</label>
					   <input type="email" name="emailid" id="emailid" class="form-control" required='true' value="">
					   <div id="emailerr" class="text-center text-danger"></div> 
					</div>
					<div class="form-group m-auto text-center">
					   <input type="button" id="emailbtn" class="btn quiz-btn btn-md proceed" value="Proceed">
				    </div>
				</div>
				
				<div id="quiznoquestions">
					<div id="noquestion" class="pt-5"></div> 
					<div class="text-center">
						<div class="btn btn-outline-primary shadow p-2 selecttopic">Select Topic</div>
					</div>
				</div>
				
				<div id="quizsection">
					<div id="questions"></div>
					<div class="pull-right mb-3">
					<a href="#" class="btn quiz-btn qnext">Next &raquo;</a>
					<a href="#" class="btn quiz-btn-submit qsubmit" id="qsubmit">Submit</a>
					</div>
				</div>
				
				<div id="quizresult" class="text-center">	
                    <h3 class="modal-title text-danger text-center p-0 mb-3" id="quizheading">Your Result</h3>   				
					<div id="msg"></div>
					<p>Marks obtained by you <span id="score"></span> out of <span id="total"></span> </p>
					<div class="btn btn-outline-primary shadow text-center view-answer">View Answer</div><br>
					<div id="certificate" class="d-none"></div>
					<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('linkedin')">Linkedin</a>
					<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('facebook')">Facebook</a>
					<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('twitter')">Twitter</a>
					<a href="javascript:void(0)" onclick="javascript:socialsharingbuttons('whatsapp')">Whatsapp</a>
				</div>
				
				<div id="quizanswer">
					 <h3 class="modal-title text-danger text-center p-0 mb-3" id="quizheading">Check Your Answers</h3> 
					 <div id="answer"></div>
					 <div class="text-center">
					 <div class="btn btn-outline-primary shadow take-again p-2">Take a Quiz Again</div>
					 </div>
				</div>
				
				<div id="recheckanswer">
					 <h3 class="modal-title text-danger text-center p-0 mb-3" id="quizheading">Check Your Answers</h3> 
					 <div id="result_id" class="d-none"><?=$_REQUEST['id']?></div>
					 <div id="youranswer"></div>
					 <div class="text-center">
						<a href='online-exam'><div class="btn btn-outline-primary shadow p-2">Start Again</div></a>
					 </div>
				</div>
				
			   
            </div>
           
            </form>
        </div>
    </div>
</div>

<script>
  
  $(document).ready(function() {
	  $('#quizemail').hide();
	  $('#quizsection').hide();
	  $('#quizresult').hide();
	  $('#quizanswer').hide();
	  $('#quiznoquestions').hide();
	  $('#recheckanswer').hide();
  });
  $('.showmodal').click(function(){
	  var topic_id=$(this).attr('data-id');
	  $('#take-quiz').modal('show');
	  $(".modal-body #topic_id").val(topic_id);
	  $('#quizanswer').hide();
	  $('#quizcount').animate({opacity:"show"}, 500);
	  $('#quizemail').hide();
	  $('#name').val();
	  $('#emailid').val();
	  $('#emailerr').html();
	  $('#emailerr').hide();
	  $('#quizresult').hide();
	  $('#quizanswer').hide();
	  $('#quiznoquestions').hide();
	  $('#quizsection').hide();
	  $('#recheckanswer').hide();
	  $('input:radio[name=count]')[0].checked = true;
  });
	
  $('.next').click(function(event){ 
      event.preventDefault(); 
	  $('#quizcount').hide();
	  if($('#emailid').val()!=''){
	    $('#emailbtn').trigger('click'); 
	  }
	  else{
		$('#quizemail').animate({opacity:"show"}, 500); 
	  }
	  $('#countbtn').removeClass('next');
	  $('#countbtn').addClass('proceed');
  });
  
  var n;
  c = 0; // current
  
  $('.proceed').click(function(){  
	  event.preventDefault(); 
	  var proceed = true;
	  $("#quiz_form input[required=true]").each(function(){
		  $(this).css('border-color',''); 
		  if(!$.trim($(this).val())){ //if this field is empty 
			$(this).css('border-color','#dc3545'); //change border color to red   
			proceed = false; //set do not proceed flag
		  }
		  //check invalid email
		  var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
		  if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
			$(this).css('border-color','#dc3545'); //change border color to red   
			proceed = false; //set do not proceed flag        
		  } 
      });
	  if(!proceed){
		  $('#emailerr').html('Please enter valid email');
		  $('#emailerr').show();
	  }
	  if(proceed) //everything looks good! proceed...
       {
		  var form = $('.quiz_form');
		  post_data = {
		   'topic_id' : $('#topic_id').val(), 
		   'count'  : $('input[name=count]:checked').val(),
		   'name' : $('#name').val(),		   
		   'email' : $('#emailid').val(),
		   'type' : 'start'
		  };	
		  data = $(this).serialize() + "&" + $.param(post_data);		  
		  $.ajax({
			 type: "POST",
			 dataType: "json",
			 url: "ajax/process",
			 data: data,
			 success: function(response) {
				 if(response.type=='success'){
					 $('#quizcount').hide();
					 $('#quizemail').hide();				
					 $('#questions').html(response.result);
					 $('#quizsection').show();
					 //n=$('input[name=count]:checked').val();
					 n=$('.quizquestion').length;
					 c=0;
					 $('#quizemail').hide();
					 $('.qnext').show(); 
					 toggView();
					 return false;
				 }else{
					 $('#quizemail').hide();
					 $('#quiznoquestions').show();
					 $('#noquestion').html(response.msg);
				 }
			 }
		  });
		   return false;
	  }
  });

function toggView(){ 
  // content:
  $('.quizquestion').hide().eq(c).show(); 
  // buttons:
  
  if(c<=0){
    $('.qsubmit').hide(); 
  }
  if(c>=n-1){
    $('.qnext').hide(); 
	$('.qsubmit').show();
  } 
}

$('.qnext').click(function(){
  c = $(this).hasClass('qnext') ? ++c : --c;
  toggView();
});
 
$('.qsubmit').click(function(){
	 $(".qsubmit").html("Please Wait...");
	 id=$(this).attr('id');
	 if(id=='qsubmit'){
	  $(".qsubmit").removeAttr('id');	 
	  event.preventDefault(); 
	  var form = $('.quiz_form');	
	 // alert($('.quiz_form').serialize());
	  post_data = {
	   'email' : $('#emailid').val(),
	   'name' : $('#name').val(),
	   'type' : 'finish'
      }; 
	  data = $('.quiz_form').serialize() + "&" + $.param(post_data);		  
	  $.ajax({
		 type: "POST",
		 dataType: "json",
		 url: "ajax/process",
		 data: data,
		 success: function(response) {
			 if(response.type=='success'){
				$('#quizsection').hide();
				$('#score').html(response.score);
				$('#msg').html(response.msg);
				$('#total').html(response.total);
				$('#certificate').html('<img src="<?=$siteurl.'images/certificate/'?>'+response.certificate+'">');
				$('#quizresult').show();
				$('#quizanswer').hide();
				$('#answer').html(response.answer);
			 }else{
				$('#quizsection').hide();
				$('#score').html(response.score);
				$('#msg').html(response.msg);
				$('#total').html(response.total);
				$('#answer').html(response.answer);
				$('#quizresult').show();
			 }
			 $(".qsubmit").html("Submit").attr('id','qsubmit');
		 }
	  });
	 }
 });
$('.view-answer').click(function(){
	$('#quizresult').hide();
	$('#quizanswer').show();
});
$('.take-again').click(function(){
   $('.proceed').trigger('click');
   $('#answer').html('');
   $('#quizanswer').hide();
   $('#quizemail').hide();
});
$('.selecttopic').click(function(){
   $('#take-quiz').modal('hide');
});

function socialsharingbuttons(social){
  event.preventDefault(); 
  post_data = {
	'title' : "JBKTEST QUIZ Score",
	'certificate' : $('#certificate img').attr('src'),
  }; 
  data = $.param(post_data);		  
  $.ajax({
	type: "POST",
    dataType: "json",
	url: "online",
	data: data,
	success: function(response) {
	}
  });
  var url = "<?=$siteurl.'online'?>"; 
  params = {
	   'url' : url,
	   'title' : "JBKTEST QUIZ Score",
	   'img' : $('#certificate img').attr('src'),
      }; 
	console.log(params); 
 // var params = JSON.parse(params);
  var button= '';
  switch (social) {
   case 'facebook':
    button='http://www.facebook.com/share.php?u='+params.url+ '&t=' + params.title+'&picture='+params.img;
    break;
   case 'twitter':
    button='https://twitter.com/share?url='+params.url+'&text='+params.title+'&hashtags='+params.tags;
    break;
   case 'whatsapp':
    if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
     button='whatsapp://send?text='+params.url;
    }else{
     button='https://web.whatsapp.com/send?text='+params.url;
    }
    break;
   case 'linkedin':
    button='http://www.linkedin.com/shareArticle?mini=true&url='+params.url;
    break;
   default:
    break;
  }
   window.open(button,'sharer','toolbar=0,status=0,width=648,height=395');
  return false;
 }
</script>
<?php
if(isset($_REQUEST['view'])&&($_REQUEST['view']=='answer')){ ?>
<script>
 $(document).ready(function() {
	 $('#take-quiz').modal('show');
	 $('#quizcount').hide();
	 post_data = {
	   'id' : $('#result_id').html(),
	   'type' : 'recheck'
      }; 
	  data = $.param(post_data);		  
	  $.ajax({
		 type: "POST",
		 dataType: "json",
		 url: "ajax/process",
		 data: data,
		 success: function(response) {
			 if(response.type=='success'){
				$('#youranswer').html(response.answer);
			 }else{
				$('#youranswer').html(response.msg);
			 }
		 }
	  });
	 $('#recheckanswer').show();
 });
 $('#take-quiz').on('hide.bs.modal', function(e) {
        window.location.href="online-exam";
 });
 </script>
<?php }
?>