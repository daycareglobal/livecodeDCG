<div class="row margin-top-10">

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				 <div class="number">
					<h3 class="font-purple-soft"><?php echo $childcare_providers; ?></h3>
					<a class="hd_title" href="<?php echo site_url('admin/');?>">Number of Registered Childcare providers</a>
				</div>
				<div class="icon">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
			</div>
			 <div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo ($childcare_providers<100)?$childcare_providers:100; ?>%;" class="progress-bar progress-bar-success purple-soft">
					<span class="sr-only"><?php echo $childcare_providers; ?>% change</span>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				 <div class="number">
					<h3 class="font-purple-soft"><?php echo $request_quote; ?></h3>
					<a class="hd_title" href="<?php echo site_url('admin/');?>">Total Number of received request for quote</a>
				</div>
				<div class="icon">
					<i class="fa fa-quote-left" aria-hidden="true"></i>
				</div>
			</div>
			 <div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo ($request_quote<100)?$request_quote:100; ?>%;" class="progress-bar progress-bar-success purple-soft">
					<span class="sr-only"><?php echo $request_quote; ?>% change</span>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				 <div class="number">
					<h3 class="font-purple-soft"><?php echo $membership_plans_fees; ?></h3>
					<a class="hd_title" href="<?php echo site_url('admin/');?>">Total amount received as fees for membership plans</a>
				</div>
				<div class="icon">
					<i class="fa fa-money" aria-hidden="true"></i>
				</div>
			</div>
			 <div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo ($membership_plans_fees<100)?$membership_plans_fees:100; ?>%;" class="progress-bar progress-bar-success purple-soft">
					<span class="sr-only"><?php echo $membership_plans_fees; ?>% change</span>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="dashboard-stat2">
			<div class="display">
				 <div class="number">
					<h3 class="font-purple-soft"><?php echo $childrens; ?></h3>
					<a class="hd_title" href="<?php echo site_url('admin/');?>">Number of Registered Users</a>
				</div>
				<div class="icon">
					<i class="fa fa-user" aria-hidden="true"></i>
				</div>
			</div>
			 <div class="progress-info">
				<div class="progress">
					<span style="width: <?php echo ($childrens<100)?$childrens:100; ?>%;" class="progress-bar progress-bar-success purple-soft">
					<span class="sr-only"><?php echo $childrens; ?>% change</span>
					</span>
				</div>
			</div>
		</div>
	</div>