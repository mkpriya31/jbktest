<?php 
$title="Dashboard";
$page="dashboard";
include('includes/header.php')?>
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
			<?php 
				if($_SESSION['user_role']=='1'){?>
            <div class="row">
			
     
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
								<?php
								$result = $sql->query("SELECT * FROM users ORDER BY id DESC");
                                $total_users=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_users?></div>
                                    <div>Total Users</div>
                                </div>
                            </div>
                        </div>
                        <a href="users">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
								<?php
								$result = $sql->query("SELECT * FROM users where user_role=2 ORDER BY id DESC");
                                $total_users=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_users?></div>
                                    <div>Moderators</div>
                                </div>
                            </div>
                        </div>
                        <a href="users">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-users fa-5x"></i>
                                </div>
								<?php
								$result = $sql->query("SELECT * FROM users where user_role=3 ORDER BY id DESC");
                                $total_users=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_users?></div>
                                    <div>Content Creators</div>
                                </div>
                            </div>
                        </div>
                        <a href="users">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-edit fa-5x"></i>
                                </div>
								<?php
								$result = $sql->query("SELECT * FROM enquiry_data ORDER BY timestamp DESC");
                                $total_enquiry=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_enquiry?></div>
                                    <div>Enquiry Form!</div>
                                </div>
                            </div>
                        </div>
                        <a href="enquiry-data">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
			</div>
				<?php } ?>

            <div class="row">
			<?php 
				if($_SESSION['user_role']=='3'||$_SESSION['user_role']=='1'){?>
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-question-circle fa-5x"></i>
                                </div>
								<?php
								$result = $sql->query("SELECT * FROM questions ORDER BY question_number DESC");
                                $total_enquiry=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_enquiry?></div>
                                    <div>Total Questions <br> added by all the users</div>
                                </div>
                            </div>
                        </div>
						<?php 
			        	if($_SESSION['user_role']!='3'){?>
                        <a href="question">
                            <div class="panel-footer">
                                 <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
						<?php } ?>
                    </div>
                </div>
			
				<?php }?>
				
				<?php if($_SESSION['user_role']!='1') { ?>
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-question fa-5x"></i>
                                </div>
								<?php
								$result = $sql->query("SELECT * FROM questions where created_by=".$_SESSION['id']." ORDER BY question_number DESC");
                                $total_enquiry=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_enquiry?></div>
                                    <div>Questions Added <?=($_SESSION['user_role']==2||$_SESSION['user_role']==3)?'<br>by you':''?><br/></div>
                                </div>
                            </div>
                        </div>
                        <a href="question">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<?php } ?>
				
				<?php if($_SESSION['user_role']=='2') { ?>
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-question fa-5x"></i>
                                </div>
								<?php
								$result = $sql->query("SELECT * FROM questions where is_reviewed=0 and status=0 ORDER BY question_number DESC");
                                $total_enquiry=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_enquiry?></div>
                                    <div>Questions still <br/> need to Approve<br/></div>
                                </div>
                            </div>
                        </div>
                        <a href="question?show=needtoapprove">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
				<?php } ?>
				
				<div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-question fa-5x"></i>
                                </div>
								<?php
								$approvejoin='';
								if($_SESSION['user_role']==3){
									$approvejoin="and created_by=".$_SESSION['id'];
								}
								if($_SESSION['user_role']==2){
									$approvejoin="and created_by!=".$_SESSION['id']." and reviewed_by=".$_SESSION['id'];
								}
								$result = $sql->query("SELECT * FROM questions where is_reviewed=1 and status=1 $approvejoin ORDER BY question_number DESC");
                                $total_enquiry=$result->num_rows;
								?>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?=$total_enquiry?></div>
                                    <div>Questions Approved <?=($_SESSION['user_role']==2)?'<br>by you':''?></div>
                                </div>
                            </div>
                        </div>
                        <a href="question?show=approved">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
				</div>
            
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

<?php include('includes/footer.php')?>
