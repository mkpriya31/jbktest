    <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard">JBK TEST <?=(($_SESSION['user_role']==1)?'Admin':(($_SESSION['user_role']==2)?'Moderator':(($_SESSION['user_role']==3)?'Content Creator':'')))?> Panel</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">                        
                        
						<li>
                            <a href="dashboard" <?=($page=='dashboard')?'class="active"':''?>><i class="fa fa-dashboard"></i> Dashboard</a>
                        </li>
						<?php  if(($_SESSION['user_role']=='2') || ($_SESSION['user_role']=='1' )){ ?>
                        <li>
                            <a href="users"><i class="fa fa-user"></i> Manage Users</a>
                        </li>
						<?php }?>	
						<?php 
						if($_SESSION['user_role']=='1'){?>   
						<li>
							<a href="subject"><i class="fa fa-file"></i> Manage Subject</a>						
						</li>
						<?php } ?>						
                        					
						<li class="dropdown">
							<a href="question"><i class="fa fa-question-circle"></i> Manage Question</a>
						</li>
						<li class="dropdown">
							<a href="question"><i class="fa fa-check"></i> Create Test</a>
						</li>
						<?php 
						if(($_SESSION['user_role']=='2') || ($_SESSION['user_role']=='1' )){?>                  
                       
						<li>
                            <a href="quiz-result" <?=($page=='quizresult')?'class="active"':''?>><i class="fa fa-cog"></i> Quiz Results</a>
                        </li>
						<?php } ?>
                     </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
