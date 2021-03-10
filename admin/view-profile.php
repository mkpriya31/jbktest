<?php 
include_once('../includes/connect.php');
include_once('../includes/functions.php');
$result=$sql->query("SELECT * FROM form_data where id=".$_GET['id']);
$data=$result->fetch_assoc();
?>
<div id="myModal" class="modal fade in" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-sm-12">
      	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                	<h4 class="modal-title text-blue m-auto text-center"><?=$data['name']?></h4> 
                </div>
            </div>
            <div class="modal-body text-secondary">
                <ul class="list-unstyled mpad-1 mb-0"  style="line-height:2rem;">                
                <?php if($data['formtype']=='quote'){ ?>
				<li><strong>Qualification:</strong> <?=$data['qualification'];?></li>
				<?php }?>
				<?php if($data['formtype']!='callback'){ ?>
				<li><strong>Regarding:</strong> <?=$data['subject'];?></li>
				<?php } ?>
				<?php if($data['formtype']=='contact'){ ?>
				<li><strong>Message:</strong> <?=$data['message'];?></li>
				<?php }?>
				<li><strong>Form:</strong> <?php if($data['formtype']=='contact'){
													echo "Contact Form";
												} else if($data['formtype']=='quote'){
													echo "Quote Form";
												} else if($data['formtype']=='callback'){
													echo "Callback Form";
												} else{
													echo "";
												}?>
												</li>
               
				<li><strong>Status:</strong> <?=$data['status'];?></li>
                </ul>
            </div>
			<div class="modal-footer text-secondary">
                <div class="text-center p-3"><i class="fa fa-envelope p-1"></i><?=$data['email'];?></div>
            	<div class="text-center"><i class="fa fa-phone p-1"></i> <?=$data['mobile'];?></div>
               
            </div>
            
        </div>
    </div>
</div>

