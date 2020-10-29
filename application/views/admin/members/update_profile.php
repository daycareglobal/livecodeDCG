<?php
	if ($message) {
		echo '<div class="alert alert-danger">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>		
		<li>Update Profile</li>
		<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
				</a>
		</li>	
					
	</ul>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row">
					<div class="col-md-6">
						<div class="caption font-red-sunglo">
							<i class="fa fa-user"></i>
							<span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
						</div>
					</div>					
				</div>
			</div>			
			<div class="portlet-body form">
				<?php echo form_open(current_url(), array('class' => 'ajax_form'));?>			
					<div class="form-body">

						<div class="form-group form-md-line-input">
							<input type="text" name="name" class="form-control" id="form_control_first_name" placeholder="Enter full name" value="<?php echo $name; ?>">
							<label for="form_control_first_name">Full Name<span style="color:red">*</span></label>
						</div>

						<!-- <div class="form-group form-md-line-input">
							<input type="text" name="username" class="form-control" id="form_control_username" placeholder="Enter username" value="<?php echo $username; ?>">
							<label for="form_control_first_name">Username<span style="color:red">*</span></label>
						</div> -->

						<div class="form-group form-md-line-input">
							<input type="email" name="email" class="form-control" id="form_control_email" placeholder="Enter email address" value="<?php echo $email; ?>">
							<label for="form_control_first_name">Email address<span style="color:red">*</span></label>
						</div>
					</div>

					<div class="form-actions noborder">
						<button type="submit" class="btn green">Submit</button>
						<a href="<?php echo base_url('admin'); ?>" class="btn default">Cancel</a>
					</div>
							
				</form>
			</div>
		</div>
	</div>
</div>