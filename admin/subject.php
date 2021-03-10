<?php 
$title="Subject";
$page="subject";
$msg='';
include('includes/header.php');
if($_SESSION['user_role']!='1'){
	header('location: dashboard');
}
$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$id= isset($_REQUEST['id'])?$_REQUEST['id']:'';
$subject=array();
$topics = array();
$topicscount = 0;
if($action=="edit" || $action=="view")
{
	$where=" where id ='".$id."'";
	$res=$sql->query("SELECT * FROM subject $where");
	$subject=$res->fetch_array();
	
	$wheretopics = " where subject_id ='".$id."'";
	$res=$sql->query("SELECT * FROM topics $wheretopics");
	$topicscount=$res->num_rows;
	while($topicsarr=$res->fetch_assoc()){
		$topics[]=$topicsarr;
	}
}
if(isset($_POST['submit'])&&($_POST['submit']=='add'))
{
	$field=$_POST;
	$res=$sql->query("INSERT INTO `subject` (`subject_name`, `created_at`,`created_by`,`modified_by`,`active`) VALUES ('".$field['subject_name']."',NOW(),".$_SESSION['id'].",0,".$field['active'].")");
	$subject_id=$sql->insert_id;
	if($field['topic'][0]!=""){
		$topics = $field['topic'];
		foreach($topics as $topic=>$value){
			$res=$sql->query("INSERT INTO `topics` (`subject_id`, `topic` ,`created_at`,`created_by`,`modified_by`) VALUES ('".$subject_id."','".$value."',NOW(),".$_SESSION['id'].",0)");
		}
	}
	if($res==true){$msg="added";}
}
if(isset($_POST['submit'])&&($_POST['submit']=='Update'))
{
	$where=" where id ='".$id."'";
	$field = array();
	foreach($_POST as $post=>$k){
		if($k!=''){
			$field[$post]=$k;
		}
	}	
	//print_r($field['topic']); echo count($field['topic']); 
	//echo $field['topic'][0]; exit;
	if($field['topic'][0]!=""){
		$topics = $field['topic'];
		foreach($topics as $topic=>$value){
			$res=$sql->query("INSERT INTO `topics` (`subject_id`, `topic` ,`created_at`,`created_by`,`modified_by`) VALUES ('".$id."','".$value."',NOW(),".$_SESSION['id'].",0)");
		}
	}
	$res2=$sql->query("Update subject set subject_name='".$field['subject_name']."',modified_at=NOW(),modified_by='".$_SESSION['id']."',active='".$field['active']."' $where");
	$msg="update";
}

if($action=="delete")
{
	$where="where id =".$id." limit 1";
	$res=$sql->query("delete from subject $where ");
	if($res==true){$msg="delete";}
}



if($action=="enable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['active'] = 1;
	$res2=$sql->query("Update subject set active='".$field['active']."'  $where");
	$msg="enable";
}

if($action=="disable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['active'] = 0;
	$res2=$sql->query("Update subject set active='".$field['active']."'  $where");
	$msg="disable";
}


if($msg!="")
{
	header('Location:subject?msg='.$msg);exit();
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
					           <label for="inputEmail3" class="col-sm-2 control-label">Name 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="subject_name" value="<?=((isset($subject['subject_name']))?$subject['subject_name']:'')?>" required>
					           </div>
					         </div>                             
                             	
                             
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Topics</label>
				     		   <div class="col-sm-7" id="dynamic">  
								  <div class="row">
                              	     <div class="col-sm-6"><input type="text" name="topic[]" placeholder="Enter your Name" class="form-control name_list" <?=($action=='edit')?'':'required'?>/></div>
								     <div class="col-sm-6"><button type="button" name="add" id="add" class="btn btn-success">Add More</button></div>
								  </div>								  							
					           </div>							   
					         </div>	
							 
							 <?php if($topicscount>0){?>
							 <div class="form-group">
					            <label for="inputEmail3" class="col-sm-2 control-label"></label>
							    <div class="col-sm-7"> 
								   <table width="50%" class="table table-striped table-bordered table-hover">
											<thead class="bg-dark">
												<tr>                                                
													<th>Topics</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											 <?php foreach($topics as $topic=>$value){ ?>   
												<tr id="r-<?=$value['id']?>">   
													<td id="topic-<?=$value['id']?>"><?=$value['topic']?></td>
													<td><a href="#" class="edit" id="edit-<?=$value['id']?>"><i class="fa fa-edit"></i></a>
													<a href="#" class="update hide" id="update-<?=$value['id']?>"><i class="fa fa-refresh"></i></a>
													<a href="#" class="delete" id="delete-<?=$value['id']?>"><i class="fa fa-trash"></i></a></td>
												</tr>
											 <?php } ?>
											</tbody>
								</table>
							    </div>
							 </div>
							 <?php } ?>
						     
															 

							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Status 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-2">
                              	  <select class="form-control" name="active">
                                  	<option value="1" <?=((isset($subject['active'])&&$subject['active']==1)?'selected':'')?>>Active</option>
                                    <option value="0" <?=((isset($subject['active'])&&$subject['active']==0)?'selected':'')?>>In-Active</option>
                                  </select>
					           </div>
					         </div>								 
						 
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
            <?php }
				else{ ?>
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
                        <a href="subject?action=add" class="small-tile blue-back pull-right ">
                            <h5 class="btn btn-primary "><i class="fa fa-plus pr-2"></i>Add Subject</h5>
                        </a>
                    </div>
                    <div class="col-lg-12">
                            
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                    Manage Subject
                                    
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead class="background-dark">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Title</th>
                                                <th class="text-center">Created By</th>
												<th class="text-center">Modified By</th>
												<th class="text-center">Created at</th>
												<th class="text-center">Modified at</th>
												<th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                        <?php 
                                        $result = $sql->query("SELECT * FROM subject ORDER by id desc");
                                        $total_subject=$result->num_rows;
                                        if($total_subject>0){
                                          $i=1;
                                           while ($data=$result->fetch_assoc()) { //print_r($data); ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?=$i?></td>
                                                <td><?php echo $data['subject_name']; ?></td>
												<?php
												$where="WHERE su.created_by=".$data['created_by'];
												$res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN subject su on u.id=su.created_by JOIN user_role ur on u.user_role=ur.id $where");
												$created_by=$res->fetch_array();
												?>
											    <td class="text-center"><?=(isset($created_by['role'])?($created_by['name']." (".$created_by['role'].")"):''); ?></td>
												<?php
												$where="WHERE su.modified_by=".$data['modified_by'];
												$res=$sql->query("SELECT  u.name,ur.role FROM `users` u JOIN subject su on su.modified_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
												$modified_by=$res->fetch_array();
												?>
												<td class="text-center"><?=(isset($modified_by['role'])?($modified_by['name']." (".$modified_by['role'].")"):'')?></td>
												<td class="text-center"><?php echo date('d M Y, H:ia', strtotime($data['created_at'])); ?></td>
												<td class="text-center"><?php echo date('d M Y, H:ia', strtotime($data['modified_at'])); ?></td>
                                                <td class="text-center">
                                                <?php
													$enable="subject?id=".$data['id']."&action=enable";
													$disable="subject?id=".$data['id']."&action=disable";
													if($data['active']=='1') { echo "<span class='active'><a href=".$disable." style='color:#090 !important;'><span class='glyphicon glyphicon-ok-sign'></span></a></span>"; } 
													else { echo "<span class='deactive'><a href=".$enable." style='color:#F00 !important;'><span class='glyphicon glyphicon-remove-sign'></span></a></span>"; } 				
												 ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="subject?id=<?=$data['id']?>&action=edit"><i class="fa fa-edit"></i></a>                                                    
                                                    <a href="subject?id=<?=$data['id']?>&action=delete"><i class="fa fa-trash"></i></a>
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
$(document).ready( function() {
   $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
		$(".alert-dismissible").alert('close');
		var uri = window.location.toString();
    if (uri.indexOf("?") > 0) {
        var clean_uri = uri.substring(0, uri.indexOf("?"));
        window.history.replaceState({}, document.title, clean_uri);
    }
	}); 
	
});
function homepage()
{		
window.location.href ="subject";
return false;
}

var i=1;  
$('#add').click(function(){  
  i++;  
  $('#dynamic').append('<div class="row" id="row-'+i+'"><div class="col-sm-6"><input type="text" name="topic[]" placeholder="Enter your Name" class="form-control name_list" required="" /></div><div class="col-sm-6"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div>');  
});

$('.delete').click(function(){  
    var row_id = $(this).attr("id").replace('delete-', '');	 
  	post_data = {
       'id' : row_id, 
	   'action': 'deletetopic'
    };
	
    data = $(this).serialize() + "&" + $.param(post_data);			
	$.ajax({
		 type: "POST",
		 dataType: "json",
		 url: "process-topics",
		 data: data,
		 success: function(response) {
			 if(response.status=="success")
				$('#r-'+row_id+'').remove(); 
	  }
	});
		return true;  	 
});

$('.edit').click(function(){  
    var topic_id = $(this).attr("id").replace('edit-', '');	
    var topic = $("#topic-"+topic_id).html();
	$("#topic-"+topic_id).html("<input type='text' value='"+topic+"' class='form-control' id='t-"+topic_id+"'/>")
	$("#edit-"+topic_id).hide().addClass('hide');
	$("#update-"+topic_id).show().removeClass('hide');
});

$('.update').click(function(){  
    var topic_id = $(this).attr("id").replace('update-', '');	 
	var topic = $('#t-'+topic_id).val();
	
  	post_data = {
       'id' : topic_id, 
	   'action': 'updatetopic',
	   'topic' : topic
    };
	
    data = $(this).serialize() + "&" + $.param(post_data);			
	$.ajax({
		 type: "POST",
		 dataType: "json",
		 url: "process-topics",
		 data: data,
		 success: function(response) {
			 if(response.status=="success")
				$("#topic-"+topic_id).html(topic);
				$("#update-"+topic_id).hide().addClass('hide');
				$("#edit-"+topic_id).show().removeClass('hide');
	  }
	});
		return true;  	 
});


$(document).on('click', '.btn_remove', function(){ 
  var button_id = $(this).attr("id");  	   
  $('#row-'+button_id+'').remove();  
});  

</script>
