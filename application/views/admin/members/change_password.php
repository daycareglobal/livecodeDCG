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
		<!-- <li>
			
			<a href="<?php //echo site_url('admin/members')?>" class="tooltips" data-original-title="Member Management" data-placement="top" data-container="body">Member Management</a>
			<i class="fa fa-arrow-right"></i>
		</li> -->
		<li>Change Password</li>	
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
							<input type="password" name="current_password" class="form-control" id="form_control_password" placeholder="Enter current password" value="">
							<label for="form_control_first_name">Current Password<span style="color:red">*</span></label>
						</div>

						<div class="form-group form-md-line-input">
							<input type="password" name="new_password" class="form-control" id="form_control_password" placeholder="Enter new password" value="">
							<label for="form_control_first_name">New password<span style="color:red">*</span></label>
						</div>

						<div class="form-group form-md-line-input">
							<input type="password" name="re_new_password" class="form-control" id="form_control_password" placeholder="Re Enter password" value="">
							<label for="form_control_first_name">Re Enter password<span style="color:red">*</span></label>
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