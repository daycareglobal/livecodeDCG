<?php
	if (isset($message) && $message) {
		$alert = ($success)? 'alert-success':'alert-danger';
		echo '<div class="alert ' . $alert . '">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px" >
	<div class="row">
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<a href="<?php echo site_url('admin/users')?>" class="tooltips" data-original-title="User List" data-placement="top" data-container="body">User List</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update User 
				 <?php } else { ?>
				 	Add User 
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/users'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
				</a>
			</li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row">
					<div class="col-md-6">
						<div class="caption font-red-sunglo">
							<i class="fa fa-file-image"></i>
							<span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form', 'autocomplete' => 'off'));?>
					<div class="form-body">

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">First Name<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter First Name', 'id' => "name", 'name' => "name", 'class' => "form-control", 'value' => "$name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Last Name<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Last Name', 'id' => "last_name", 'name' => "last_name", 'class' => "form-control", 'value' => "$last_name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Gender<span style="color:red">*</span></label>
							<div class="md-radio-inline">
								<div class="md-radio">
									<input id="radio19" class="md-radiobtn" type="radio" name="gender" value="Male" <?php echo ($gender == 'Male')?'checked':''; ?>>
									<label for="radio19">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Male</label>
								</div>
								<div class="md-radio">
									<input id="radio20" class="md-radiobtn" type="radio" name="gender" value="Female" <?php echo ($gender == 'Female')?'checked':''; ?>>
									<label for="radio20">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Female</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Date of Birth<span style="color:red">*</span></label>
							<div class="col-md-10">
								<input type="text" id="dob" name="dob" value="<?php echo $dob; ?>" class="form-control dob" placeholder=" Select Date of Birth">
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">E-mail Address<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter email address', 'id' => "email", 'name' => "email", 'class' => "form-control", 'value' => "$email")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<!-- <div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Contact Number<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter contact number', 'id' => "contact_number", 'name' => "contact_number", 'class' => "form-control", 'value' => "$contact_number")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div> -->

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Password<?php if($task == 'add') { ?><span style="color:red">*</span><?php } ?></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter password', 'id' => "password", 'name' => "password", 'type' => 'password', 'class' => "form-control", 'value' => "")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Confirm Password<?php if($task == 'add') { ?><span style="color:red">*</span><?php } ?></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Re-enter password', 'id' => "confirm_password", 'type' => 'password', 'name' => "confirm_password", 'class' => "form-control", 'value' => "")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="profile_image" class="col-md-2 control-label">Profile Image </label>
							<div class="col-md-10">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn default btn-file">
									<span class="fileinput-new">
									Select Image </span>
									<span class="fileinput-exists">
									Change </span>
									<input type="file" id="profile_image" name="profile_image">
									</span>
									<span class="fileinput-filename">
									</span>
									&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
									</a>
								</div>
							</div>
						</div>
						
						<div class="form-group form-md-line-input">
							<label for="profile_image" class="col-md-2 control-label">Preview</label>
							<div class="col-md-10">
								<img id="preview_image" name="profile_image" href="<?php if(isset($profile_image)){ echo $profile_image; } ?>" src="<?php if(isset($profile_image)){ echo site_url('assets/uploads/profile_image/'.$profile_image); } ?>" height="80" width="100" alt="No Image Selected" />
							</div>
						</div>

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn green">Submit</button>
									<a href="<?php echo base_url('admin/users'); ?>" class="btn default">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.dob').datepicker({
			format:'yyyy-mm-dd',
			endDate: '-18y',
        	autoclose: true
		});
	});
</script>