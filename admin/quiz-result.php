<?php 
$title="Quiz Result";
$page="quizresult";
$msg='';
include('includes/header.php');
$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
$id= isset($_REQUEST['id'])?$_REQUEST['id']:'';

if($action=="delete")
{
	$where="where id =".$id." limit 1";
	$res=$sql->query("delete from quiz_results $where ");
	if($res==true){$msg="delete";}
}


if($msg!="")
{
	header('Location:quiz-result?msg='.$msg);exit();
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
							<div id="result" class="text-success text-center"></div> 	  
                            <div class="panel panel-default">
                                <div class="panel-heading">Quiz Result</div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
									
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead class="background-dark">
                                            <tr>
                                                <th class="text-center">S.No</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Topic</th>
                                                <th class="text-center">Score</th>
                                                <th class="text-center">Total</th>  
												<th class="text-center">Taken at</th>	
												 <?php 
													if( ($_SESSION['user_role']=='1' )){?>  
													<th class="text-center">Action</th>
												<?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody>                                    
                                        <?php 
                                        $result = $sql->query("SELECT * FROM quiz_results ORDER BY id DESC");
                                        $total=$result->num_rows;
                                        if($total>0){
                                          $i=1;
                                           while ($data=$result->fetch_assoc()) { $quizres=objectToArray(json_decode($data['result'])); ?>
                                            <tr class="odd gradeX">
                                                <td class="text-center"><?=$i?></td>
                                                <td class="text-center"><?php echo $data['email']; ?></td>
												<?php
													$where="WHERE id=".$quizres['topic_id'];
													$top=$sql->query("SELECT * FROM topics $where");
													$topic=$top->fetch_array();
												?>
												<td class="text-center"><?=(isset($topic['topic'])?$topic['topic']:'')?></td>
												<td class="text-center"><?php echo $quizres['marks']; ?></td>
												<td class="text-center"><?php echo $quizres['total']; ?></td>
												<td class="text-center"><?php echo date('d M Y, H:i a', strtotime($data['taken_at'])); ?></td>
                                             <?php 
												if( ($_SESSION['user_role']=='1' )){?>  
													<td class="text-center">													
                                                    <a href="quiz-result?id=<?=$data['id']?>&action=delete"><i class="fa fa-trash"></i></a>
                                                </td>
											<?php } ?>
												<div class="modal-container"></div>
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
            
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include('includes/footer.php')?>
<script>
function homepage()
{		
window.location.href ="quiz-result";
return false;
}
</script>