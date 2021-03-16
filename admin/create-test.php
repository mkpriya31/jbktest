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
	$where="where test_id =".$id." limit 1";
	$res=$sql->query("delete from on_demand_test $where ");
	if($res==true){$msg="delete";}
}

if($action=="enable")
{
	$where=" where test_id ='".$id."'";
	$status = 1;
	$res2=$sql->query("Update on_demand_test set status='".$status."'  $where");
	$msg="enable";
}

if($action=="disable")
{
	$where=" where test_id ='".$id."'";
	$status = 0;
	$res2=$sql->query("Update on_demand_test set status='".$status."'  $where");
	$msg="disable";
}

if(isset($_POST['submit'])&&($_POST['submit']=='add'))
{
	$field=$_POST;	
	$test_name=$_POST['test_name'];
    $subjects=implode(",",$_POST['subjects']);
    $topics=implode(",",$_POST['topics']);
	
	$res=$sql->query("INSERT INTO `on_demand_test` (`test_name`, `subjects`, `topics`, `created_at`,`created_by`, `modified_by`) VALUES ('".$test_name."','".$subjects."','".$topics."',NOW(),".$_SESSION['id'].",0)");
	$question_number=$sql->insert_id;
		
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
                        <form method="post" action="" class="form-horizontal registration-form" id="frm_jbk" name="frm_jbk" enctype="multipart/form-data">
						<fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Specify Test Name</h3>                             
                            </div>
                        </div>
                        <div class="form-bottom clearfix">
                            <div class="form-group">
							   <label for="inputEmail3" class="col-sm-2 control-label">Enter Test Name
					           <span class="required">*</span>:</label>
				     		   <div class="col-sm-7">
                                 <input type="text" class="form-control" placeholder="Enter Test Name" name="test_name" id="test_name">
							   </div>
                            </div>

                            <div class="form-group pull-right d-clear">
                            <button type="button" class="btn btn-next" data-value="step1">Next</button>
							</div>
                        </div>
						</fieldset>
						<fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3><span>Select Subject</h3>
                                <p id="entered_test_name"></p>
                            </div>
                        </div>
						
                        <div class="form-bottom clearfix">
							<div class="pull-left col-sm-12">
							<h5> Select all <input type="checkbox" id="select_all" /></h5>
							</div>
                            <div class="form-group">
                            <?php 
								$where=" WHERE active=1 ORDER BY id DESC";
								$subquery = $sql->query("SELECT * FROM subject $where");
								if($subquery->num_rows >= 1 ){
								while($rows =  $subquery->fetch_assoc()){ ?>
								<div class="col-sm-4 p-1">
									 <label class = "checkbox-inline">
							    	 <input name="subjects[]" type="checkbox" class="checkbox" value="<?=$rows['id']?>" <?=((isset($question['subject_id'])&&($rows['id']==$question['subject_id']))?'checked':'')?> data-value="<?=$rows['subject_name']?>" ><?=$rows['subject_name']?>
									 </label>
								</div>
							<?php	} } ?>
                            </div>
							<button type="button" class="btn btn-previous">Previous</button>
                            <div class="form-group pull-right d-clear">
                            <button type="button" class="btn btn-next" data-value="step2">Next</button>
							</div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="form-top">
                            <div class="form-top-left">
                                <h3>Select Topics</h3>
								<p id="entered_test_name_subject"></p>
                            </div>
                        </div>
                        <div class="form-bottom">
                            <div class="form-group">
								<div id="alltopics"></div>
                            </div>
                            <button type="button" class="btn btn-previous">Previous</button>
                            <button type="submit" name="submit" value="add" class="btn pull-right">Submit</button>
                        </div>
                    </fieldset>
	          			</form>                    	
                    </div>
                </div>
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
                        <a href="create-test?action=add" class="small-tile blue-back pull-right ">
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
								
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead class="background-dark">
                                            <tr>
												<th class="text-center">S.No</th>
                                                <th class="text-center">Test Name</th>
												<?php 
												if($_SESSION['user_role']!=3){ ?>
												<th class="text-center">Created By</th>
												<th class="text-center">Created at</th>
                                                <th class="text-center">Status</th>
												<?php } ?>											
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>    
										<tbody>                                    
                                        <?php 
                                        $result = $sql->query("SELECT * FROM on_demand_test ORDER by test_id desc");
                                        $total_subject=$result->num_rows;
                                        if($total_subject>0){
                                          $i=1;
                                           while ($data=$result->fetch_assoc()) { //print_r($data); ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?=$i?></td>
                                                <td><?php echo $data['test_name']; ?></td>
												<?php
												$where="WHERE su.created_by=".$data['created_by'];
												$res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN subject su on u.id=su.created_by JOIN user_role ur on u.user_role=ur.id $where");
												$created_by=$res->fetch_array();
												?>
											    <td class="text-center"><?=(isset($created_by['role'])?($created_by['name']." (".$created_by['role'].")"):''); ?></td>
												
												<td class="text-center"><?php echo date('d M Y, H:ia', strtotime($data['created_at'])); ?></td>
												
                                                <td class="text-center">
                                                <?php
													$enable="create-test?id=".$data['test_id']."&action=enable";
													$disable="create-test?id=".$data['test_id']."&action=disable";
													if($data['status']=='1') { echo "<span class='active'><a href=".$disable." style='color:#090 !important;'><span class='glyphicon glyphicon-ok-sign'></span></a></span>"; } 
													else { echo "<span class='deactive'><a href=".$enable." style='color:#F00 !important;'><span class='glyphicon glyphicon-remove-sign'></span></a></span>"; } 				
												 ?>
                                                </td>
                                                <td class="text-center">
                                                                                                        
                                                    <a href="create-test?id=<?=$data['test_id']?>&action=delete"><i class="fa fa-trash"></i></a>
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
function homepage()
{		
window.location.href ="create-test";
return false;
}
$(document).ready(function () {
	 $('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
        }else{
            $('#select_all').prop('checked',false);
        }
    });

    $('.registration-form fieldset:first-child').fadeIn('slow');
	
	$('.registration-form input[type="text"]').on('focus', function () {
        $(this).removeClass('input-error');
    });
    // next step
    $('.registration-form .btn-next').on('click', function () {
		var parent_fieldset = $(this).parents('fieldset');
        var next_step = true;
		$step = $(this).attr('data-value')
		
		if($step=='step1'){
			parent_fieldset.find('input[type="text"],input[type="email"]').each(function () {
				if ($(this).val() == "") {
					$(this).addClass('input-error');
					next_step = false;
				} else {
					$(this).removeClass('input-error');
				}
			});
		}
		if($step=='step2'){
			if(parent_fieldset.find(".checkbox:checkbox:checked").length>0){
				var data = { 'subjects[]' : [], 'action': 'gettopicsfortest',};
				$(".checkbox:checkbox:checked").each(function() {
				   data['subjects[]'].push($(this).val());
				});
				
				$.ajax({
					 type: "POST",
					 dataType: "json",
					 url: "process-topics",
					 data: data,
					 success: function(response) {			 
						 if(response.status=="success"){
							$("#alltopics").html(response.topic); 
						 }
				  }
				});
				next_step = true;
			}else{
				next_step = false;
			}
		}
		
        if (next_step) {
            parent_fieldset.fadeOut(400, function () {
                $(this).next().fadeIn();
				if($step=='step1'){
					$('#entered_test_name').html('Test Name:'+$('#test_name').val());
				}else{
					var subjectsname='';
				   $(".checkbox:checkbox:checked").each(function() {
						subjectsname=subjectsname+$(this).attr('data-value')+',';
					});
					console.log(data);
					$('#entered_test_name_subject').html('<b>Test Name:</b> '+$('#test_name').val()+'<br/> <b>Subject:</b> '+subjectsname);
				}
            });
        }

    });

    // previous step
    $('.registration-form .btn-previous').on('click', function () {
        $(this).parents('fieldset').fadeOut(400, function () {
			
            $(this).prev().fadeIn();
        });
    });

    // submit
    $('.registration-form').on('submit', function (e) {
        $(this).find('input[type="text"],input[type="email"]').each(function () {
            if ($(this).val() == "") {
                e.preventDefault();
                $(this).addClass('input-error');
            } else {
                $(this).removeClass('input-error');
            }
        });

    });

   
});
</script>