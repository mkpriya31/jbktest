<?php 
$title="Create Test";
$page="create-test";
$msg='';
include('includes/header.php');
require 'spreadsheet/vendor/autoload.php';


$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$id= isset($_REQUEST['id'])?$_REQUEST['id']:'';
$question=array();
$choices=array();
$is_correct=0;
$correct_answer=0;
$topic="";
$status='';

if($action=="delete")
{
	$where="where question_number =".$id." limit 1";
	$res=$sql->query("delete from questions $where ");
	$res=$sql->query("delete from choices $where ");
	if($res==true){$msg="delete";}
}

if($action=="enable")
{
	$where=" where question_number ='".$id."'";
	$status = 1;
	$res2=$sql->query("Update questions set status='".$status."'  $where");
	$msg="enable";
}

if($action=="disable")
{
	$where=" where question_number ='".$id."'";
	$status = 0;
	$res2=$sql->query("Update questions set status='".$status."'  $where");
	$msg="disable";
}

if(isset($_POST['submit'])&&($_POST['submit']=='add'))
{
	$field=$_POST;	
	//echo "INSERT INTO `questions` (`subject_id`, `topic_id`, `question`, `explanation`, `status`) VALUES ('".$field['subject_id']."','".$field['topic_id']."','".$field['question']."','".$field['explanation']."',".$field['active'].")"; 
	$is_reviewed=0;
	$reviewed_by=0;
	if($_SESSION['user_role']==3){
		$field['active']=0;
	}
	if($_SESSION['user_role']!=3){
		$is_reviewed=$field['is_reviewed'];
		$reviewed_by=$_SESSION['id'];
	}
	
	$res=$sql->query("INSERT INTO `questions` (`subject_id`, `topic_id`, `question`, `explanation`, `created_at`,`created_by`, `modified_by`, `level`, `reviewed_by`,`is_reviewed`,`status`) VALUES ('".$field['subject_id']."','".$field['topic_id']."','".mysqli_real_escape_string($sql,$field['question'])."','".mysqli_real_escape_string($sql,$field['explanation'])."',NOW(),".$_SESSION['id'].",0,0,".$reviewed_by.",".$is_reviewed.",".$field['active'].")");
	$question_number=$sql->insert_id;
	$choices = $field['choice'];
	foreach($choices as $choice=>$value){
		if($field['correct_answer']==$choice+1){
			$is_correct=1;
		}else {
			$is_correct=0;
		}
		
		$res=$sql->query("INSERT INTO `choices` (`question_number`, `is_correct`, `text`, `created_at`,`created_by`, `modified_by`, `status`) VALUES ('".$question_number."','".$is_correct."','".mysqli_real_escape_string($sql,$value)."',NOW(),".$_SESSION['id'].",0,".$field['active'].")");
	}
	
	if($res==true){$msg="added";}
}



if($msg!="")
{
	header('Location:create-test?msg='.$msg);exit();
}

?>
    <div id="wrapper">
        <?php include('includes/menu.php')?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?=$title?></h1>                   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php if($action=='add'||$action=='edit'){ ?> 
				<div class="row">
                	<div class="col-sm-12">
                        <form method="post" action="" class="form-horizontal" id="frm_jbk" name="frm_jbk" enctype="multipart/form-data">
						
							<div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Select Subject 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	 <select name="subject_id" class="form-control" required id="subject_id">
									<option value=''>--Please Select Subject--</option>
									<?php 
										if($subquery->num_rows >= 1 ){
											while($rows =  $subquery->fetch_assoc()){ ?>
												<option value="<?=$rows['id']?>" <?=((isset($question['subject_id'])&&($rows['id']==$question['subject_id']))?'selected':'')?>><?=$rows['subject_name']?></option>
									<?php	} 											
										}
									?>
										
								 </select>
					           </div>
					         </div> 
							
							<div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Select Topic
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	 <select name="topic_id" class="form-control" required id="topic_id">
									<option value=''>--Please Select Topic--</option>
                                    <?=$topic?>									
								 </select>
					           </div>
					         </div> 							 
							 
					         <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Question 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-8">
							      <div id="questiontext" class="hidden"><?=((isset($question['question']))?$question['question']:'')?></div>
								  <textarea class="form-control questioneditor" name="question" id='question'></textarea>  
								  <div id="questionerr" class="text-danger"></div> 
					           </div>
					         </div> 
							 							 
							<? //print_R($choices);?>
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #1 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[0]['id']))?$choices[0]['id']:'')?>]" value="<?=((isset($choices[0]['text']))?stripslashes($choices[0]['text']):'')?>" required>
					           </div>
					         </div>   
							 
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #2
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[1]['id']))?$choices[1]['id']:'')?>]" value="<?=((isset($choices[1]['text']))?stripslashes($choices[1]['text']):'')?>" required>
					           </div>
					         </div>  

							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #3 </label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[2]['id']))?$choices[2]['id']:'')?>]" value="<?=((isset($choices[2]['text']))?stripslashes($choices[2]['text']):'')?>">
					           </div>
					         </div>  	

							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #4</label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[3]['id']))?$choices[3]['id']:'')?>]" value="<?=((isset($choices[3]['text']))?stripslashes($choices[3]['text']):'')?>" >
					           </div>
					         </div>  	
							 
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #5</label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[4]['id']))?$choices[4]['id']:'')?>]" value="<?=((isset($choices[4]['text']))?stripslashes($choices[4]['text']):'')?>">
					           </div>
					         </div>  
							 
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Correct Answer
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <?php $i=1; ?>
								  <select class="form-control" name="correct_answer" required>
									<option value=''>--Please Select Answer--</option>
                                  	<?php 
									while($i<6){ ?>
										<option value="<?=$i?>" <?=((isset($correct_answer)&&($i==$correct_answer))?'selected':'')?>><?=$i?></option>
									<?php $i++; }
									?>
                                  </select>
					           </div>
					         </div>  
							 
							 
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Explanation</label>
				     		   <div class="col-sm-8">                              	  
								  <div id="explanationtext" class="hidden"><?=((isset($question['explanation']))?$question['explanation']:'')?></div>
								  <textarea class="form-control explanationeditor" name="explanation" id='explanation'></textarea>  
								  <div id="explanationerr" class="text-danger"></div> 
					           </div>
					         </div>
                             <?php 
							 if($_SESSION['user_role']!=3){ ?>	
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Status 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-2">
                              	  <select class="form-control" name="active">
                                  	<option value="1" <?=((isset($question['status'])&&$question['status']==1)?'selected':'')?>>Active</option>
                                    <option value="0" <?=((isset($question['status'])&&$question['status']==0)?'selected':'')?>>In-Active</option>
                                  </select>
					           </div>
					         </div>	

							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Review Status 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-2">
                              	  <select class="form-control" name="is_reviewed">
                                  	<option value="1" <?=((isset($question['is_reviewed'])&&$question['is_reviewed']==1)?'selected':'')?>>Approved</option>
                                    <option value="0" <?=((isset($question['is_reviewed'])&&$question['is_reviewed']==0)?'selected':'')?>>Waiting for Approval</option>
									<option value="-1" <?=((isset($question['is_reviewed'])&&$question['is_reviewed']==-1)?'selected':'')?>>Not Approved</option>
                                  </select>
					           </div>
					         </div>	
                             <?php }  ?> 							 
					         <div class="box-footer">
					              <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
			                      <div class="col-sm-10">
					              <?php if($action=='add'){ ?>
					                 <button type="submit" name="submit" class="btn btn-info" value="add" >Submit</button>
					              <?php } if($action=='edit'){?>
					                 <button type="submit" name="submit" class="btn btn-info" value="Update" >Update</button>                                  <?php } ?>
					                 <button type="button" class="btn btn-primary" onclick='return homepage()' >Cancel</button>
			                     </div>
     	                     </div><!-- /.box-footer -->
	          			</form>                    	
                    </div>
                </div>
            <?php }elseif($action=='upload'){ ?>
				<p class="text-center"><?=$status?></p>
				<form method="post" class="form-horizontal" id="frm_jbk_upload" name="frm_jbk_upload" enctype="multipart/form-data">
					<div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Upload XLS/XLSX File</label>
				     	<div class="col-sm-8">                              	  
							<input type="file" name="fileupload" id="fileupload" class="form-control" accept=".xls,.xlsx" required>
							<div id="fileuploaderr" class="text-danger"></div> 
					    </div>
					</div>
					<div class="box-footer">
					    <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
			            <div class="col-sm-10">
					        <button type="submit" name="submit" id="uploadsubmit" class="btn btn-info" value="upload" >Submit</button>
							<button type="button" class="btn btn-primary" onclick='return homepage()' >Cancel</button>
			            </div>
     	            </div><!-- /.box-footer -->
				</form>
			<?php }elseif($action=='disapprove'){ ?>
				<p class="text-center"><?=$status?></p>
				<form method="post" action="" class="form-horizontal" id="frm_jbk" name="frm_jbk" enctype="multipart/form-data">
						
					<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Select Subject 
					<span class="required">*</span></label>
				    <div class="col-sm-5">
						<select name="subject_id" class="form-control" required id="subject_id">
							<option value=''>--Please Select Subject--</option>
							<?php 
							if($subquery->num_rows >= 1 ){
							while($rows =  $subquery->fetch_assoc()){ ?>
							<option value="<?=$rows['id']?>" <?=((isset($question['subject_id'])&&($rows['id']==$question['subject_id']))?'selected':'')?>><?=$rows['subject_name']?></option>
						<?php	} 											
							}
					    ?>
										
						</select>
					</div>
					</div> 
							
				    <div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Select Topic
					    <span class="required">*</span></label>
				     	<div class="col-sm-5">
							<select name="topic_id" class="form-control" required id="topic_id">
							<option value=''>--Please Select Topic--</option>
							<?=$topic?>									
							</select>
					    </div>
					</div> 
					
					<div class="form-group">
					    <label for="inputEmail3" class="col-sm-2 control-label">Option
					    <span class="required">*</span></label>
				     	<div class="col-sm-5">
						 <label class="radio-inline">
							<input type="radio" name="option" value="1" checked>Uploaded
						 </label>
						 <label class="radio-inline">
						  <input type="radio" name="option" value="0">All
						 </label>
					    </div>
					</div> 
					
					<div class="box-footer">
					    <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
			            <div class="col-sm-10">
					        <button type="submit" name="submit" class="btn btn-info" value="disapprove" >Disapprove</button>
							<button type="button" class="btn btn-primary" onclick='return homepage()' >Cancel</button>
			            </div>
     	            </div><!-- /.box-footer -->
				</form>
			<?php }else{ ?>
                <div class="row">
                	<?php if(isset($_REQUEST['msg'])&&$_REQUEST['msg']!=''){ 
				        if($_REQUEST['msg']=='added')
                        	$msg="Successfully Added!!!";
						if($_REQUEST['msg']=='update')
                        	$msg="Successfully Updated!!!";
						if($_REQUEST['msg']=='delete')
                        	$msg="Successfully Deleted!!!";
						if($_REQUEST['msg']=='enable')
                        	$msg="Successfully Enabled!!!";
						if($_REQUEST['msg']=='disable')
                        	$msg="Successfully Disabled!!!";
						if($_REQUEST['msg']=='disable')
                        	$msg="Successfully Disapproved!!!";
						?>
						<div class="alert alert-success alert-dismissible" data-auto-dismiss="2000" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong><?=$msg?></strong>
                        </div>
				  <?php  } ?>
				    <div class="col-sm-12 mb-3">						
                        <a href="question?action=add" class="small-tile blue-back pull-right ">
                            <h5 class="btn btn-primary "><i class="fa fa-plus pr-2"></i>Create Test</h5>
                        </a>
						
                    </div>
                                        
                    <div class="col-lg-12">
                            
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                   Manage Test
                                    
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
								<?php if($_SESSION['user_role']!=3){ ?>
									<!-- Custom Filter -->
								    <table class="pull-right">
									 <tr>
									   <td>
										 <label >Search By Title:&nbsp;&nbsp;<input type='text' id='searchByTitle' placeholder='Enter Title' style="border: 2px solid #000" value=""></label>
									   </td>									   
									 </tr>
								    </table>
								<?php } ?>
                                    <table width="100%" class="dataTable display table table-striped table-hover">
                                        <thead class="background-dark">
                                            <tr>
                                                <th class="text-center">Test Name</th>
												<?php 
												if($_SESSION['user_role']!=3){ ?>
												<th class="text-center">Created By</th>
												<th class="text-center">Modified By</th>
												<th class="text-center">Created at</th>
												<th class="text-center">Modified at</th>
                                                <th class="text-center">Status</th>
												<?php } ?>											
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>                          
                                    </table>                                
                                </div>
                                <!-- /.panel-body -->
                            </div>
                            <!-- /.panel -->
                        </div>
                </div>
            <?php } ?>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
	

<?php include('includes/footer.php')?>
<script>
$(document).on('change', '#subject_id', function(){ 
  var subject_id = $(this).val(); 
  post_data = {
   'id' : subject_id, 
   'action': 'gettopics',
 };
 data = $(this).serialize() + "&" + $.param(post_data);			
	
	$.ajax({
		 type: "POST",
		 dataType: "json",
		 url: "process-topics",
		 data: data,
		 success: function(response) {			 
			 if(response.status=="success"){
				$("#topic_id").html(response.topic); 
			 }
	  }
	});
	return true;  
});  

function homepage()
{		
window.location.href ="create-test";
return false;
}
</script>