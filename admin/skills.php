<?php 
$title="Skills";
$page="skills";
$msg='';
include('includes/header.php');
$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$id= isset($_REQUEST['id'])?$_REQUEST['id']:'';
$skills=array();
if($action=="edit" || $action=="view")
{
	$where=" where id ='".$id."'";
	$res=$sql->query("SELECT * FROM skills $where");
	$skills=$res->fetch_array();
}
if(isset($_POST['submit'])&&($_POST['submit']=='add'))
{
	$field=$_POST;
	echo "INSERT INTO `skills` (`name`, `active`) VALUES ('".$field['name']."','".$field['active'].")";
	$res=$sql->query("INSERT INTO `skills` (`name`, `active`) VALUES ('".$field['name']."',".$field['active'].")");
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
	$res2=$sql->query("Update skills set name='".$field['name']."',active='".$field['active']."'  $where");
	$msg="update";
}

if($action=="delete")
{
	$where="where id =".$id." limit 1";
	$res=$sql->query("delete from skills $where ");
	if($res==true){$msg="delete";}
}

if($action=="enable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['active'] = 1;
	$res2=$sql->query("Update skills set active='".$field['active']."'  $where");
	$msg="enable";
}

if($action=="disable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['active'] = 0;
	$res2=$sql->query("Update skills set active='".$field['active']."'  $where");
	$msg="disable";
}


if($msg!="")
{
	header('Location:skills?msg='.$msg);exit();
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
                              	  <input type="text" class="form-control" name="name" value="<?=((isset($skills['name']))?$skills['name']:'')?>" required>
					           </div>
					         </div>                             
                             	
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Status 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-2">
                              	  <select class="form-control" name="active">
                                  	<option value="1" <?=((isset($skills['active'])&&$skills['active']==1)?'selected':'')?>>Active</option>
                                    <option value="0" <?=((isset($skills['active'])&&$skills['active']==0)?'selected':'')?>>In-Active</option>
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
				else if($action=='view'){?>
                	<div class="row">
					                        <div class="col-md-12 col-sm-12 col-xs-12">
					                           <div class="x_panel">
					                               <div class="x_content">
					                                  <div class="table-responsive">
					                                      <table class="table">
					                                          <tbody>
					                                             <tr>
					                                                <th>Name:</th>
					                                                <td><?=$skills['name']?></td>
					                                             </tr>				                                             
					                                             
					                                           </tbody>
					                                        </table>
					                                  </div>
					                               </div>
					                           </div>
					                        </div>				                        
					                        <div class="clearfix"></div>
					                        <div class="form-group">
					                             <div class="col-md-6 col-sm-6 col-xs-12">
					                                     <button type="submit" class="btn btn-primary" onclick='return homepage()' >Back</button>
					                             </div>
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
						?>
						<div class="alert alert-success alert-dismissible" data-auto-dismiss="2000" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong><?=$msg?></strong>
                        </div>
				  <?php  } ?>
                    <div class="col-sm-12 mb-3">
                        <a href="skills?action=add" class="small-tile blue-back pull-right ">
                            <h5 class="btn btn-primary "><i class="fa fa-plus pr-2"></i>Add skills</h5>
                        </a>
                    </div>
                    <div class="col-lg-12">
                            
                            <div class="panel panel-default">
                            
                                <div class="panel-heading">
                                    Skills
                                    
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead class="background-dark">
                                            <tr>
                                                <th>S.No</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                        <?php 
                                        $result = $sql->query("SELECT * FROM skills ORDER by id desc");
                                        $total_skills=$result->num_rows;
                                        if($total_skills>0){
                                          $i=1;
                                           while ($data=$result->fetch_assoc()) { //print_r($data); ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?=$i?></td>
                                                <td><?php echo $data['name']; ?></td>
                                                <td class="text-center">
                                                <?php
													$enable="skills?id=".$data['id']."&action=enable";
													$disable="skills?id=".$data['id']."&action=disable";
																	
																			if($data['active']=='1') { echo "<span class='active'><a href=".$disable." style='color:#090 !important;'><span class='glyphicon glyphicon-ok-sign'></span></a></span>"; } 
																			else { echo "<span class='deactive'><a href=".$enable." style='color:#F00 !important;'><span class='glyphicon glyphicon-remove-sign'></span></a></span>"; } 				
																		  ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="skills?id=<?=$data['id']?>&action=edit"><i class="fa fa-edit"></i></a>
                                                    <a href="skills?id=<?=$data['id']?>&action=view"><i class="fa fa-eye"></i></a>
                                                    <a href="skills?id=<?=$data['id']?>&action=delete"><i class="fa fa-trash"></i></a>
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
window.location.href ="skills";
return false;
}
</script>