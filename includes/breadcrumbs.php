			<?php 
				if(isset($courselink)&&($courselink!='')){
				  if(isset($courselink)&&($courselink=='java')){
					  $cname="Java Programmer";
					  $ctrain="Java Training";
					  $courseurl='java-training-in-pune';
				  }else if(isset($courselink)&&($courselink=='selenium')) {
					 $cname="Selenium Tester";
					 $ctrain="Selenium Training";
					 $courseurl='selenium-training-in-pune';
				  }else if(isset($courselink)&&($courselink=='javaj2ee')) {
					 $cname="Java Programmer";
					 $ctrain="Java Training";
					 $courseurl='java-training-in-pune';
				  } ?>
				  <div class="row p-2 m-auto no-padding">
					<div class="col-sm-9 m-auto border shadow  font-weight-normal text-center p-3 coursead mpad-1">
						<h4 class="text-center">
						<a href="<?php echo $siteurl.$courseurl ?>">
						<p class="pull-left pt-4 pl-4 m-0 no-padding">To become a <?=$cname?> after our <?=$ctrain?> - Click Here</p>
						<i class="fa fa-hand-o-right p-0 fa-2x text-danger pull-left"></i></a></h4>						
					</div>
				  </div>
			<?php }
			?>
			
            <ol itemscope itemtype="http://schema.org/BreadcrumbList" class="breadcrumb no-padding">
              <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">
              	<a itemprop="item" href="<?php echo $siteurl;?>">
                	<span itemprop="name">Java By Kiran</span>
                </a>
                <meta itemprop="position" content="1" />
              </li>   
              <?php if(isset($mainpage)&&$mainpage!=''){?>          
              <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">
              	<a itemprop="item" href="<?php echo $siteurl.$pageurl ?>">
                	<span itemprop="name"><?php echo $mainpage;?></span>
                </a>
                <meta itemprop="position" content="2" />
              </li>              
              <?php } if(isset($courselink)&&($courselink!='')){
				  if(isset($courselink)&&($courselink=='java')){
					  $coursename="Java Training in Pune";
					  $courseurl='java-training-in-pune';
				  }else if(isset($courselink)&&($courselink=='selenium')) {
					 $coursename="Selenium Training in Pune";
					 $courseurl='selenium-training-in-pune';
				  }else if(isset($courselink)&&($courselink=='javaj2ee')) {
					 $coursename="Java Training in Pune";
					 $courseurl='java-training-in-pune';
				  }
			   ?>                       
			  <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">
              	<a itemprop="item" href="<?php echo $siteurl.$courseurl ?>">
                	<span itemprop="name"><?php echo $coursename;?></span>
                </a>
                <meta itemprop="position" content="3" />
              </li>
              <?php } if(isset($submainpage)&&$submainpage!=''){?>          
              <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item">
              	<a itemprop="item" href="<?php echo $siteurl.$subpageurl ?>">
                	<span itemprop="name"><?php echo $submainpage;?></span>
                </a>
                <meta itemprop="position" content="<?=((isset($courselink)?4:3))?>" />
              </li>
              <?php } ?> 
              <?php if($title!=''){?>          
              <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-item active">
              	<!---<a itemprop="item" href="<?php echo $siteurl.$_SERVER['REQUEST_URI']; ?>">-->
                	<span itemprop="name"><?php echo $title;?></span>
                <!--</a>-->
                <meta itemprop="position" content="<?=(isset($mainpage)&&isset($submainpage)&&isset($courselink))?5:((isset($mainpage)&&isset($submainpage))?4:(isset($mainpage)&&isset($courselink))?4:(isset($mainpage)?3:2))?>" />
              </li>
              <?php } ?>
            </ol>
            