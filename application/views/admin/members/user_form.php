<?php
	if (isset($message) && $message) {
		$alert = ($success)? 'alert-success':'alert-danger';
		echo '<div class="alert ' . $alert . '">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px">
	<div class="row">
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<a href="<?php echo site_url('admin/members')?>" class="tooltips" data-original-title="Members" data-placement="top" data-container="body">Members</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update Member 
				 <?php } else { ?>
				 	Add Member 
				 <?php } ?>			
			</li>	
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/members'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
				<?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form'));?>
					<div class="form-body">                               
                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">First Name<span style="color:red">*</span></label>
							<div class="col-md-10">					
								<?php echo form_input(array('placeholder' => "Enter First Name", 'id' => "first_name", 'name' => "first_name", 'class' => "form-control", 'value' => "$first_name")); ?>
								<div class="form-control-focus"> </div>			
							</div>
						</div>

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Last Name<span style="color:red">*</span></label>
							<div class="col-md-10">					
								<?php echo form_input(array('placeholder' => "Enter Last Name", 'id' => "last_name", 'name' => "last_name", 'class' => "form-control", 'value' => "$last_name")); ?>
								<div class="form-control-focus"> </div>			
							</div>
						</div>

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Email<span style="color:red">*</span></label>
							<div class="col-md-10">					
								<?php echo form_input(array('placeholder' => "Enter Email", 'id' => "email", 'name' => "email", 'class' => "form-control", 'value' => "$email")); ?>
								<div class="form-control-focus"> </div>			
							</div>
						</div>

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Password<span style="color:red"><?php echo (($task == "add")?'*':'' ); ?></span></label>
							<div class="col-md-10">					
								<?php echo form_input(array('placeholder' => "Enter Password",'type' => "password", 'id' => "password", 'name' => "password", 'class' => "form-control", 'value' => "")); ?>
								<div class="form-control-focus"> </div>			
							</div>
						</div> 
						<!-- <div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Confirm Password<span style="color:red"><?php echo (($task == "add")?'*':'' ); ?></span></label>
							<div class="col-md-10">					
								<?php echo form_input(array('placeholder' => "Enter Confirm Password",'type' => "password", 'id' => "confirm_password", 'name' => "confirm_password", 'class' => "form-control", 'value' => "")); ?>
								<div class="form-control-focus"> </div>			
							</div>
						</div> -->
						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Phone Number<span style="color:red">*</span></label>
							<div class="col-md-10">					
								<?php echo form_input(array('placeholder' => "Enter Phone Number",'type' => "text", 'id' => "phone_number", 'name' => "phone_number", 'class' => "form-control", 'value' => "$phone_number")); ?>
								<div class="form-control-focus"> </div>			
							</div>
						</div>
						<!-- <?php if ( $id != ''){ ?>
						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Image</label>
							<div class="col-md-10">		
								<input type="file" name="image" id="form_control_image" class="multifile form-control">
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2"></label>
							<div class="col-md-10">		
								<img height="200" width="200" src="<?php echo base_url('assets/uploads/members/').$image;?>" alt="">
							</div>
						</div>
						<?php } else { ?>
						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Image<span style="color:red">*</span></label>
							<div class="col-md-10">		
								<input type="file" name="image" id="form_control_image" class="multifile form-control">
							</div>
						</div>
						<?php } ?> -->

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Status</label>
							<div class="md-radio-inline">
							<div class="md-radio">
							<input id="radio19" class="md-radiobtn" type="radio" name="is_email_verified" value="Yes" <?php echo ($is_email_verified == 'Yes')?'checked':''; ?>>
							<label for="radio19">
							<span class="inc"></span>
							<span class="check"></span>
							<span class="box"></span>Yes</label>
							</div>
							<div class="md-radio has-error">
							<input id="radio20" class="md-radiobtn" type="radio" name="is_email_verified" value="No" <?php echo ($is_email_verified == 'No')?'checked':''; ?>>
							<label for="radio20">
							<span class="inc"></span>
							<span class="check"></span>
							<span class="box"></span>No</label>
							</div>
							</div>
						</div> 

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Status</label>
							<div class="md-radio-inline">
							<div class="md-radio">
							<input id="radio21" class="md-radiobtn" type="radio" name="status" value="Active" <?php echo ($status == 'Active')?'checked':''; ?>>
							<label for="radio21">
							<span class="inc"></span>
							<span class="check"></span>
							<span class="box"></span>Active</label>
							</div>
							<div class="md-radio has-error">
							<input id="radio22" class="md-radiobtn" type="radio" name="status" value="Inactive" <?php echo ($status == 'Inactive')?'checked':''; ?>>
							<label for="radio22">
							<span class="inc"></span>
							<span class="check"></span>
							<span class="box"></span>Inactive</label>
							</div>
							</div>
						</div> 

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/members'); ?>" class="btn default">Cancel</a>
							</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<script>
$(document).ready(function () {
$('#brith_date').datepicker(
{
format: 'yyyy-mm-dd',
startDate:'now', 
autoclose:true
}
);
});

</script>
