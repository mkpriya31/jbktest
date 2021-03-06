<?php 
$title="Question";
$page="question";
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

if(isset($_POST['submit'])&&($_POST['submit']=='Update'))
{
	$where=" where question_number ='".$id."'";
	$field = array();
	foreach($_POST as $post=>$k){
		if($k!=''){
			$field[$post]=$k;
		}
	}	
	$choices = $field['choice'];
	$j=1;
	foreach($choices as $choice=>$value){
		if($field['correct_answer']==$j){
			$is_correct=1;
		}else {
			$is_correct=0;
		}
		$res=$sql->query("UPDATE choices SET is_correct='".$is_correct."',text='".$value."',modified_at=NOW(),modified_by='".$_SESSION['id']."',status=1 WHERE id = $choice");
		$j++;
	}
	if($_SESSION['user_role']!=3){
		$is_reviewed=$field['is_reviewed'];
		$reviewed_by=$_SESSION['id'];
	}
	if($_SESSION['user_role']==3){
		$field['active']=0;
		$is_reviewed=0;
	}
	
	$res2=$sql->query("Update questions set subject_id='".$field['subject_id']."',topic_id='".$field['topic_id']."',question='".$field['question']."',explanation='".$field['explanation']."',modified_at=NOW(),modified_by=".$_SESSION['id'].",reviewed_by=".$_SESSION['id'].",is_reviewed=".$is_reviewed.",status='".$field['active']."'  $where");
	$msg="update";
}

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
if(isset($_POST['submit'])&&$_POST['submit']=="upload"){
	$fxls=$_FILES['fileupload']['tmp_name'];
	//$fxls='sample.xls';
	$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);
	
	$xls_data = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
	//print_r($xls_data);
	$subject_name = $xls_data[1]['C']; 
	$topic_name = $xls_data[2]['C'];
	$active=1;
	$is_reviewed=0;
	$reviewed_by=0;
	$is_uploaded=1;
	if($_SESSION['user_role']==3){
		$active=0;
	}
	if($_SESSION['user_role']!=3){
		$is_reviewed=1;
		$reviewed_by=$_SESSION['id'];
	}
	$sub=$sql->query("SELECT s.id as subject_id FROM subject s where s.subject_name='".$subject_name."'");
	$subject=$sub->fetch_assoc();
	if($sub->num_rows>0){	
		$top=$sql->query("SELECT t.id as topic_id FROM topics t where t.topic='".$topic_name."' and t.subject_id=".$subject['subject_id']);
		$topic=$top->fetch_assoc();
		if($top->num_rows>0){	
			$x = 4;
			$re='';
			$cnt=count($xls_data);
			while($x <= $cnt) {
				$y = 1;
			    $numCols=count($xls_data[$x]);
				if($numCols==8){
					$question_name=$xls_data[$x]['A'];
					$explanation=$xls_data[$x]['B'];
					if($question_name!=''){
						$res=$sql->query("INSERT INTO `questions` (`subject_id`, `topic_id`, `question`, `explanation`, `created_at`,`created_by`, `reviewed_by`,`is_reviewed`,`is_uploaded`,`status`) VALUES ('".$subject['subject_id']."','".$topic['topic_id']."','".$question_name."','".$explanation."',NOW(),".$_SESSION['id'].",".$reviewed_by.",".$is_reviewed.",".$is_uploaded.",".$active.")");
						$question_number=$sql->insert_id;
						$y=3;
						$chararray=67;
						$cho=1;
						while($y<=$numCols-1) {
							if($xls_data[$x][chr($chararray)]!=''){
								if($xls_data[$x]['H']==$cho){
									$is_correct=1;
								}else {
									$is_correct=0;
								}
								$res=$sql->query("INSERT INTO `choices` (`question_number`, `is_correct`, `text`, `created_at`,`created_by`, `status`) VALUES ('".$question_number."','".$is_correct."','".$xls_data[$x][chr($chararray)]."',NOW(),".$_SESSION['id'].",".$active.")");
							}
							$y++; $cho++;$chararray++;
						}
					}
				}
			$x++;
			}
			$status="<span class='text-success'>Successfully Uploaded</span>";
		}else{
			$status="<span class='text-danger'>Topic not exists</span>";
		}
	}else{
		$status="<span class='text-danger'>Subject not exists</span>";
	}
	
	
	
	/*
	$question_number=$sql->insert_id;
	$choices = $field['choice'];
	foreach($choices as $choice=>$value){
		if($field['correct_answer']==$choice+1){
			$is_correct=1;
		}else {
			$is_correct=0;
		}
		
		$res=$sql->query("INSERT INTO `choices` (`question_number`, `is_correct`, `text`, `created_at`,`created_by`, `status`) VALUES ('".$question_number."','".$is_correct."','".$value."',NOW(),".$_SESSION['id'].",".$field['active'].")");
	}*/
}

if($action=="edit"){
	$where=" where question_number ='".$id."'";
	$res=$sql->query("SELECT * FROM questions $where");
	$question=$res->fetch_array();
	
	$res=$sql->query("SELECT * FROM choices $where");
	$j=1;
	while($choicesarr=$res->fetch_assoc()){
		$choices[]=$choicesarr;
		if($choicesarr['is_correct']==1)
			$correct_answer=$j;
		$j++;
	}
	
	$wheretopic="where subject_id =".$question['subject_id']." ORDER by id asc";
	$res=$sql->query("SELECT * FROM topics $wheretopic");
	$numrows=$res->num_rows;
	$checked='';
	if($numrows>0){
	   while($topics=$res->fetch_assoc()){
		if($topics['id']==$question['topic_id']){			
		  $checked="selected";
		}else{
		  $checked="";
		}
		$topic.='<option value="'.$topics['id'].'"'.$checked.'>'.$topics['topic'].'</option>';
	   }
	}
}
$where=" WHERE active=1 ORDER BY id DESC";
$subquery = $sql->query("SELECT * FROM subject $where");

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
	
	$res=$sql->query("INSERT INTO `questions` (`subject_id`, `topic_id`, `question`, `explanation`, `created_at`,`created_by`, `reviewed_by`,`is_reviewed`,`status`) VALUES ('".$field['subject_id']."','".$field['topic_id']."','".$field['question']."','".$field['explanation']."',NOW(),".$_SESSION['id'].",".$reviewed_by.",".$is_reviewed.",".$field['active'].")");
	$question_number=$sql->insert_id;
	$choices = $field['choice'];
	foreach($choices as $choice=>$value){
		if($field['correct_answer']==$choice+1){
			$is_correct=1;
		}else {
			$is_correct=0;
		}
		
		$res=$sql->query("INSERT INTO `choices` (`question_number`, `is_correct`, `text`, `created_at`,`created_by`, `status`) VALUES ('".$question_number."','".$is_correct."','".$value."',NOW(),".$_SESSION['id'].",".$field['active'].")");
	}
	
	if($res==true){$msg="added";}
}



if($msg!="")
{
	header('Location:question?msg='.$msg);exit();
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
							 							 
							
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #1 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[0]['id']))?$choices[0]['id']:'')?>]" value="<?=((isset($choices[0]['text']))?$choices[0]['text']:'')?>" required>
					           </div>
					         </div>   
							 
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #2
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[1]['id']))?$choices[1]['id']:'')?>]" value="<?=((isset($choices[1]['text']))?$choices[1]['text']:'')?>" required>
					           </div>
					         </div>  

							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #3 </label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[2]['id']))?$choices[2]['id']:'')?>]" value="<?=((isset($choices[2]['text']))?$choices[2]['text']:'')?>">
					           </div>
					         </div>  	

							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #4</label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[3]['id']))?$choices[3]['id']:'')?>]" value="<?=((isset($choices[3]['text']))?$choices[3]['text']:'')?>" >
					           </div>
					         </div>  	
							 
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Choice #5</label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="choice[<?=((isset($choices[4]['id']))?$choices[4]['id']:'')?>]" value="<?=((isset($choices[4]['text']))?$choices[4]['text']:'')?>">
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
						?>
						<div class="alert alert-success alert-dismissible" data-auto-dismiss="2000" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong><?=$msg?></strong>
                        </div>
				  <?php  } ?>
				    <div class="col-sm-12 mb-3">						
                        <a href="question?action=add" class="small-tile blue-back pull-right ">
                            <h5 class="btn btn-primary "><i class="fa fa-plus pr-2"></i>Add Question</h5>
                        </a>
						<a href="question?action=upload" class="small-tile blue-back pull-right mr-5">
                            <h5 class="btn btn-primary "><i class="fa fa-upload"></i> Upload XSLX</h5>
                        </a>
                    </div>
                    <div class="col-sm-12">
					    <a href="question" class="small-tile blue-back pull-left pr-2">
                            <h5 class="btn btn-primary border=radius-0"> <?=($_SESSION['user_role']!=1)?'Questions added by you':'All Questions'?></h5>
                        </a>
						<?php if($_SESSION['user_role']==2){ ?>
						<a href="question?show=needtoapprove" class="small-tile blue-back pull-left pr-2">
                            <h5 class="btn btn-warning ">Questions need to Approve</h5>
                        </a>
						<?php } ?>
						<a href="question?show=approved" class="small-tile blue-back pull-left ">
                            <h5 class="btn btn-success ">Approved</h5>
                        </a>
					</div>
                    
                    <div class="col-lg-12">
                            
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                   Manage Question
                                    
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                
                                    <table data-height="400" width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead class="background-dark">
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Topic</th>
                                                <th class="text-center">Question</th>
												<?php 
												if($_SESSION['user_role']!=3){ ?>
												<th class="text-center">Created By</th>
												<th class="text-center">Modified By</th>
												<th class="text-center">Created at</th>
												<th class="text-center">Modified at</th>
                                                <th class="text-center">Status</th>
												<th class="text-center">Reviewed By</th>
												<th class="text-center">Is Uploaded</th>
												<?php } ?>
												<th class="text-center">Review Status</th>												
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                        <?php 
										$whereq='';
										$join='';
										if($_SESSION['user_role']==3){
											if(isset($_REQUEST['show'])&&($_REQUEST['show']=='approved')){
												$join.=" and status=1 and is_reviewed=1";
											}											
											$whereq='WHERE created_by='.$_SESSION['id'].$join;
										}
										
										if($_SESSION['user_role']==2){
											$join='';
											if(isset($_REQUEST['show'])&&($_REQUEST['show']=='approved')){
												$join.=" and status=1 and is_reviewed=1 and created_by!=".$_SESSION['id'];
												$whereq='WHERE reviewed_by='.$_SESSION['id'].$join;
											}elseif(isset($_REQUEST['show'])&&($_REQUEST['show']=='needtoapprove')){
												$whereq=" WHERE status=0 and is_reviewed=0";
											}else{
												$whereq='WHERE created_by='.$_SESSION['id'];
											}
										}
										
										if($_SESSION['user_role']==1){
											$join='';
											if(isset($_REQUEST['show'])&&($_REQUEST['show']=='approved')){
												$join.="status=1 and is_reviewed=1";
												$whereq='WHERE '.$join;
											}
										}
										
										//echo "SELECT * FROM questions $whereq ORDER by question_number desc";
                                        $result = $sql->query("SELECT * FROM questions $whereq ORDER by question_number desc");
                                        $total_question=$result->num_rows;
                                        if($total_question>0){
                                          $i=1;
                                           while ($data=$result->fetch_assoc()) { //print_r($data); ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?=$i?></td>
												<?php
													$where="WHERE id=".$data['topic_id'];
													$top=$sql->query("SELECT * FROM topics $where");
													$topic=$top->fetch_array();
												?>
                                                <td class="text-center"><?=(isset($topic['topic'])?$topic['topic']:'')?></td>
                                                <td class="text-center"><?php echo substr(strip_tags($data['question']),0,75); ?></td>
												<?php
												if($_SESSION['user_role']!=3){
												$where="WHERE q.created_by=".$data['created_by'];
												$res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN questions q on q.created_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
												$created_by=$res->fetch_array();
												?>
											    <td class="text-center"><?=(isset($created_by['role'])?($created_by['name']." (".$created_by['role'].")"):''); ?></td>
												<?php
												$where="WHERE q.modified_by=".$data['modified_by'];
												$res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN questions q on q.modified_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
												$modified_by=$res->fetch_array();
												?>
												<td class="text-center"><?=(isset($modified_by['role'])?($modified_by['name']." (".$modified_by['role'].")"):'')?></td>
												<td class="text-center"><?php echo date('d M Y, H:ia', strtotime($data['created_at'])); ?></td>
												<td class="text-center"><?php echo date('d M Y, H:ia', strtotime($data['modified_at'])); ?></td>
												
                                                <td class="text-center">
                                                <?php
													$enable="question?id=".$data['question_number']."&action=enable";
													$disable="question?id=".$data['question_number']."&action=disable";
																	
																			if($data['status']=='1') { echo "<span class='active'><a href=".$disable." style='color:#090 !important;'><span class='glyphicon glyphicon-ok-sign'></span></a></span>"; } 
																			else { echo "<span class='deactive'><a href=".$enable." style='color:#F00 !important;'><span class='glyphicon glyphicon-remove-sign'></span></a></span>"; } 				
																		  ?>
                                                </td>
												<?php
												$where="WHERE q.reviewed_by=".$data['reviewed_by'];
												$res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN questions q on q.reviewed_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
												$reviewed_by=$res->fetch_array();
												?>
												<td class="text-center"><?=(isset($reviewed_by['role'])?($reviewed_by['name']." (".$reviewed_by['role'].")"):'')?></td>
												<td class="text-center"><?=($data['is_uploaded']==1)?"Yes":"No"?></td>
												<?php } ?>
												
												<td class="text-center"><?php 
												if($data['is_reviewed']==0){ echo 'Waiting for Review'; }
												else if($data['is_reviewed']==1){ echo 'Approved'; } 
												else if($data['is_reviewed']==-1){ echo 'Not Approved'; }
												
												?></td>
                                                <td class="text-center">
                                                    <a href="question?id=<?=$data['question_number']?>&action=edit"><i class="fa fa-edit"></i></a> 
												<?php if($_SESSION['user_role']!=3){ ?>                                                
                                                    <a href="question?id=<?=$data['question_number']?>&action=delete"><i class="fa fa-trash"></i></a>
												<?php } ?>
                                                </td>
                                            </tr>                                        
                                        <?php 
                                            $i++;
                                            }
                                        }?>
                                        </tbody>                                    
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
var uploaderr=0;	
$('#fileupload').on('change',function(){
   var fileupload = $('#fileupload').val();
   var allowedExtensions = /(\.xls|\.xlsx)$/i;
   if(!allowedExtensions.exec(fileupload)){
	   $('#fileuploaderr').html('Please upload only .xls/.xlsx file');
	   uploaderr=1;
   }else{
	   $('#fileuploaderr').html('');
	   uploaderr=0;
   }
});


$('#uploadsubmit').click(function(){
    $('#fileupload').trigger('change');
    if(uploaderr==1){
		return false;
	}else{
		$('#frm_jbk_upload').submit();
	}
});

$(document).ready( function() {
	$(".questioneditor").Editor({
                'texteffects':false,
				'aligneffects':false,
				'textformats':false,
				'fonteffects':false,
				'actions' : false,
				'insertoptions' : false,
				'extraeffects' : false,
				'screeneffects':false,
				'bold': false,
				'italics': false,
				'underline':false,
				'ol':false,
				'ul':false,
				'undo':false,
				'redo':false,
				'l_align':false,
				'r_align':false,
				'c_align':false,
				'justify':false,
				'insert_link':false,
				'unlink':false,
				'insert_img':false,
				'hr_line':false,
				'block_quote':false,
				'strikeout':false,
				'indent':false,
				'outdent':false,
				'fonts':false,
				'styles':false,
				'print':false,
				'rm_format':false,
				'status_bar':false,
				'font_size':false,
				'color':false,
				'splchars':false,
				'insert_table':false,
				'select_all':false,
			    'advancedoptions' : true,	
				'source':false,
				'togglescreen':true
        });
		
   $("#question").Editor("setText", $('#questiontext').html());
   
   $(".explanationeditor").Editor({
                'texteffects':false,
				'aligneffects':false,
				'textformats':false,
				'fonteffects':false,
				'actions' : false,
				'insertoptions' : false,
				'extraeffects' : false,
				'screeneffects':false,
				'bold': false,
				'italics': false,
				'underline':false,
				'ol':false,
				'ul':false,
				'undo':false,
				'redo':false,
				'l_align':false,
				'r_align':false,
				'c_align':false,
				'justify':false,
				'insert_link':false,
				'unlink':false,
				'insert_img':false,
				'hr_line':false,
				'block_quote':false,
				'strikeout':false,
				'indent':false,
				'outdent':false,
				'fonts':false,
				'styles':false,
				'print':false,
				'rm_format':false,
				'status_bar':false,
				'font_size':false,
				'color':false,
				'splchars':false,
				'insert_table':false,
				'select_all':false,
			    'advancedoptions' : true,	
				'source':false,
				'togglescreen':true
        });
		
   $("#explanation").Editor("setText", $('#explanationtext').html());
   
   $('#frm_jbk').submit(function(){
	   var err=0;	   
	   if($("#question").Editor("getText")==''){
	   	  $('#questionerr').html('This field is required');
		  err++;
	   }else{
		  $('#questionerr').html('');
		  $("#question").val($("#question").Editor("getText"));
	   } 
	   
	   if($("#explanation").Editor("getText")!=''){
		  $('#explanationerr').html('');
		  $("#explanation").val($("#explanation").Editor("getText"));
	   } 
	   	

	   if(err>0)
	   	return false;
		else
		return true;
	});
   
   
   
   
   
   $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
		$(".alert-dismissible").alert('close');
		var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        var clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }
	});       
});


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
window.location.href ="question";
return false;
}
</script>