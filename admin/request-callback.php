<?php 
$title="Callback Request";
$page="callback";
$msg='';
include('includes/header.php');
$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$id= isset($_REQUEST['id'])?$_REQUEST['id']:'';
$batch=array();
if($action=="view")
{
	$where=" where id ='".$id."'";
	$res=$sql->query("SELECT * FROM callback_request $where");
	$batch=$res->fetch_array();
}

if($action=="delete")
{
	$where="where id =".$id." limit 1";
	$res=$sql->query("delete from callback_request $where ");
	if($res==true){$msg="delete";}
}

if($action=="enable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['status'] = 1;
	$res2=$sql->query("Update callback_request set status='".$field['status']."'  $where");
	$msg="enable";
}

if($action=="disable")
{
	$where=" where id ='".$id."'";
	$field = array();
	$field['status'] = 0;
	$res2=$sql->query("Update callback_request set status='".$field['status']."'  $where");
	$msg="disable";
}


if($msg!="")
{
	header('Location:request-callback?msg='.$msg);exit();
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
					           <label for="inputEmail3" class="col-sm-2 control-label">Batch Name 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="batch_name" value="<?=((isset($batch['batch_name']))?$batch['batch_name']:'')?>" required>
					           </div>
					         </div>
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Start Date 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control datepicker" name="start_date" autocomplete="off"  value="<?=((isset($batch['start_date']))?$batch['start_date']:'')?>" required>
                                  
					           </div>
					         </div>	
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">End Date 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control datepicker" name="end_date" autocomplete="off" value="<?=((isset($batch['end_date']))?$batch['end_date']:'')?>" required>
					           </div>
					         </div>	
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Timings
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="timings" value="<?=((isset($batch['timings']))?$batch['timings']:'')?>" required>
					           </div>
					         </div>	
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Days
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="days" value="<?=((isset($batch['days']))?$batch['days']:'')?>" required>
					           </div>
					         </div>
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Location
					           <span class="required">*</span></label>
				     		   <div class="col-sm-5">
                              	  <input type="text" class="form-control" name="location" value="<?=((isset($batch['location']))?$batch['location']:'')?>" required>
					           </div>
					         </div>	
                             <div class="form-group">
					           <label for="inputEmail3" class="col-sm-2 control-label">Status 
					           <span class="required">*</span></label>
				     		   <div class="col-sm-2">
                              	  <select class="form-control" name="active">
                                  	<option value="1" <?=((isset($batch['active'])&&$batch['active']==1)?'selected':'')?>>Active</option>
                                    <option value="0" <?=((isset($batch['active'])&&$batch['active']==0)?'selected':'')?>>In-Active</option>
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
						if($_REQUEST['msg']=='delete')
                        	$msg="Successfully Deleted!!!";
						if($_REQUEST['msg']=='enable')
                        	$msg="Successfully Processed Request!!!";
						if($_REQUEST['msg']=='disable')
                        	$msg="Process New Request!!!";
						?>
						<div class="alert alert-success alert-dismissible" data-auto-dismiss="2000" role="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong><?=$msg?></strong>
                        </div>
				  <?php  } ?>
                    <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">Callback Request</div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead class="background-dark">
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Mobile</th>
                                                <th class="text-center">Date & Time</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                        <?php 
                                        $result = $sql->query("SELECT * FROM callback_request ORDER BY id DESC");
                                        $total=$result->num_rows;
                                        if($total>0){
                                          $i=1;
                                           while ($data=$result->fetch_assoc()) { //print_r($data); ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?=$i?></td>
                                                <td class="text-center"><?php echo $data['name']; ?></td>
												<td class="text-center"><?php echo $data['mobile']; ?></td>
                                                <td class="text-center"><?php echo date('d M Y H:ia', strtotime($data['timestamp'])); ?></td>
                                                <td class="text-center">
                                                <?php
													$enable="request-callback?id=".$data['id']."&action=enable";
													$disable="request-callback?id=".$data['id']."&action=disable";
													if($data['status']=='1') { echo "<span class='active'><a href=".$disable." style='color:#090 !important;'>Processed</a></span>"; } 
													else { echo "<span class='deactive'><a href=".$enable." style='color:#F00 !important;'>New Request</a></span>"; } 				
												?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="request-callback?id=<?=$data['id']?>&action=delete"><i class="fa fa-trash"></i></a>
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
window.location.href ="request-callback";
return false;
}
</script>