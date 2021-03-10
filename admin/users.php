<?php 
$title="Users";
$page="users";
$msg='';
include('includes/header.php');
$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$id= isset($_REQUEST['id'])?$_REQUEST['id']:'';
$users=array();
$topics = array();
$topicscount = 0;
if($action=="edit" || $action=="view")
{
	$where=" where id ='".$id."'";
	$res=$sql->query("SELECT * FROM users $where");
	$users=$res->fetch_array();
}
if(isset($_POST['submit'])&&($_POST['submit']=='add'))
{
	$field=$_POST;
	if($_SESSION['user_role']==2){
		$field['user_role']=3;
	}
	$res=$sql->query("INSERT INTO `users` (`username`, `password`, `name`, `email`, `user_role`,`created_at`,`created_by`,`active`) VALUES ('".$field['email']."','".md5($field['password'])."','".$field['name']."','".$field['email']."','".$field['user_role']."',NOW(),".$_SESSION['id'].",".$field['active'].")");
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
	$user_role='';
	if($_SESSION['user_role']==1){
		$user_role="user_role='".$field['user_role']."',";
	}
	$res2=$sql->query("Update users set name='".$field['name']."',password='".md5($field['password'])."',".$user_role." modified_at=NOW(),modified_by='".$_SESSION['id']."',active='".$field['active']."' $where");
	$msg="update";
}

if($action=="delete")
{
	$where="where id =".$id." limit 1";
	$res=$sql->query("delete from users $where ");
	if($res==true){$msg="delete";}
}



if($action=="enable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['active'] = 1;
	$res2=$sql->query("Update users set active='".$field['active']."'  $where");
	$msg="enable";
}

if($action=="disable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['active'] = 0;
	$res2=$sql->query("Update users set active='".$field['active']."'  $where");
	$msg="disable";
}


if($msg!="")
{
	header('Location:users?msg='.$msg);exit();
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
                              	  <input type="text" class="form-control" name="name" value="<?=((isset($users['name']))?$users['name']:'')?>" required>
					           </div>
					         </div> 
							
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Email 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="email" class="form-control" name="email" value="<?=((isset($users['email']))?$users['email']:'')?>" <?=((isset($users['email']))?'readonly':'')?> required>
					           </div>
					         </div> 

							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Password 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="password" class="form-control" name="password" value="<?=((isset($users['password']))?$users['password']:'')?>" required>
					           </div>
					         </div>
							 <?php 
							 if($_SESSION['user_role']==1){
							    $whererole="where id !=1 ORDER by id asc";
								$res=$sql->query("SELECT * FROM user_role $whererole");
								$numrows=$res->num_rows;	
                                $user_role='';								
								if($numrows>0){
								   while($role=$res->fetch_assoc()){
									if(isset($users['user_role'])&&($role['id']==$users['user_role'])){			
									  $checked="selected";
									}else{
									  $checked="";
									}
									$user_role.='<option value="'.$role['id'].'"'.$checked.'>'.$role['role'].'</option>';
								   }
								}
							 ?>	
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">User Role 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <select name="user_role" class="form-control" required>
									<option value=''>--Please Select Topic--</option>
                                    <?=$user_role?>									
								 </select>
					           </div>
					         </div>
							 <?php } ?>
                             								 
							 <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Status 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-2">
                              	  <select class="form-control" name="active">
                                  	<option value="1" <?=((isset($users['active'])&&$users['active']==1)?'selected':'')?>>Active</option>
                                    <option value="0" <?=((isset($users['active'])&&$users['active']==0)?'selected':'')?>>In-Active</option>
                                  </select>
					           </div>
					         </div>								 
						 
					         <div class="box-footer">
					              <label for="inputPassword3" class="col-sm-2 control-label">&nbsp;</label>
			                      <div class="col-sm-10">
					              <?php if($action=='add'){ ?>
					                 <button type="submit" name="submit" class="btn btn-info" value="add" >Submit</button>
					              <?php } if($action=='edit'){?>
					                 <button type="submit" name="submit" class="btn btn-info" value="Update" >Update</button><?php } ?>
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
                        <a href="users?action=add" class="small-tile blue-back pull-right ">
                            <h5 class="btn btn-primary "><i class="fa fa-plus pr-2"></i>Add users</h5>
                        </a>
                    </div>
                    <div class="col-lg-12">
                            
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                    Manage Users
                                    
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead class="background-dark">
                                            <tr>
                                                <th>Name</th>
												<th>Email</th>
												<th class="text-center">Role</th>
												<th class="text-center">No. of Questions Created</th>
												<th class="text-center">Created By</th>
												<th class="text-center">Modified By</th>
												<th class="text-center">Created at</th>
												<th class="text-center">Modified at</th>
                                                <th class="text-center">Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                        <?php 
										$join='';
										if($_SESSION['user_role']==2){
											$join=' and user_role!=2';
										}
										
                                        $result = $sql->query("SELECT * FROM users WHERE user_role!=1 $join ORDER by id desc");
                                        $total_users=$result->num_rows;
                                        if($total_users>0){
                                          $i=1;
                                           while ($data=$result->fetch_assoc()) { //print_r($data); ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $data['name']; ?></td>
                                                <td><?php echo $data['email']; ?></td>
												<?php
												$where=" where id ='".$data['user_role']."'";
												$res=$sql->query("SELECT * FROM user_role $where");
												$user=$res->fetch_array();
												?>
                                                <td class="text-center"><?php echo $user['role']; ?></td>
												<?php
												$where=" where created_by =".$data['id'];
												$res=$sql->query("SELECT * FROM questions $where");
												$quescount=$res->num_rows;
												?>
												<td class="text-center"><?php echo $quescount; ?></td>
												<?php
												$where="WHERE us.created_by=".$data['created_by'];
												$res=$sql->query("SELECT u.name,ur.role FROM `users` u JOIN users us on us.created_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
												$created_by=$res->fetch_array();
												?>
											    <td class="text-center"><?=(isset($created_by['role'])?($created_by['name']." (".$created_by['role'].")"):''); ?></td>
												<?php
												$where="WHERE us.modified_by=".$data['modified_by'];
												$res=$sql->query("SELECT  u.name,ur.role FROM `users` u JOIN users us on us.modified_by=u.id JOIN user_role ur on u.user_role=ur.id $where");
												$modified_by=$res->fetch_array();
												?>
												<td class="text-center"><?=(isset($modified_by['role'])?($modified_by['name']." (".$modified_by['role'].")"):'')?></td>
												<td class="text-center"><?php echo date('d M Y, H:ia', strtotime($data['created_at'])); ?></td>
												<td class="text-center"><?php echo date('d M Y, H:ia', strtotime($data['modified_at'])); ?></td>
                                                <td class="text-center">
                                                <?php
													$enable="users?id=".$data['id']."&action=enable";
													$disable="users?id=".$data['id']."&action=disable";
													if($data['active']=='1') { echo "<span class='active'><a href=".$disable." style='color:#090 !important;'><span class='glyphicon glyphicon-ok-sign'></span></a></span>"; } 
													else { echo "<span class='deactive'><a href=".$enable." style='color:#F00 !important;'><span class='glyphicon glyphicon-remove-sign'></span></a></span>"; } 				
												 ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="users?id=<?=$data['id']?>&action=edit"><i class="fa fa-edit"></i></a>                                                    
                                                    <a href="users?id=<?=$data['id']?>&action=delete"><i class="fa fa-trash"></i></a>
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
window.location.href ="users";
return false;
}
</script>
