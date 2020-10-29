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
				<a href="<?php echo site_url('admin/services')?>" class="tooltips" data-original-title="Service List" data-placement="top" data-container="body">Service  List</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update Service 
				 <?php } else { ?>
				 	Add Service 
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/services'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<label for="form_control_title" class="control-label col-md-2">Business Users<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="user_id" id="user_id" class="form-control select2 language_data" style="height:40px">
							        <option value="">
								        <?php if (!empty($business_users)) { ?>
								        	Select Business User
								        <?php } else { ?>
								        	No Business User Found
								        <?php } ?>							        	
							        </option>
							        <?php if(!empty($business_users)) {
							            	foreach ($business_users as $key => $value) 
								            {
									            $selected = '';
									            if($business_type_id == $value->id)
									            {
									            	$selected = 'selected';
									            }
									            echo '<option '.$selected.' value="'.$value->id.'">'.$value->name.'</option>';
								        	}
						            	}
						            ?>
						    	</select>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Business Type<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="business_type_id" id="business_type_id" class="form-control select2 language_data" style="height:40px">
							        <option value="">
								        <?php if (!empty($business_types)) { ?>
								        	Select Business Type
								        <?php } else { ?>
								        	No Business Type Found
								        <?php } ?>							        	
							        </option>
							        <?php if(!empty($business_types)) {
							            	foreach ($business_types as $key => $value) 
								            {
									            $selected = '';
									            if($business_type_id == $value->id)
									            {
									            	$selected = 'selected';
									            }
									            echo '<option '.$selected.' value="'.$value->id.'">'.$value->name.'</option>';
								        	}
						            	}
						            ?>
						    	</select>
							</div>
						</div>

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Daycare Name<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Daycare Name', 'id' => "daycare_name", 'name' => "daycare_name", 'class' => "form-control", 'value' => "$daycare_name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Daycare Address<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Daycare Address', 'id' => "address", 'name' => "address", 'class' => "form-control", 'value' => "$address")); ?>
								<div class="form-control-focus"> </div>
							</div>
							<input type="hidden" name="latitude" id="latitude" value="0.0">
              				<input type="hidden" name="longitude" id="longitude" value="0.0">

						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Hourly Charges<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Hourly Charges ₹', 'id' => "hourly_charges", 'name' => "hourly_charges", 'class' => "form-control", 'value' => "$hourly_charges")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Monthly Charges<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Monthly Charges ₹', 'id' => "monthly_charges", 'name' => "monthly_charges", 'class' => "form-control", 'value' => "$monthly_charges")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Daily Charges<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Daily Charges ₹', 'id' => "daily_charges", 'name' => "daily_charges", 'class' => "form-control", 'value' => "$daily_charges")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>
						
						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Age Accepted<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Age Accepted', 'id' => "age_accepted", 'name' => "age_accepted", 'class' => "form-control", 'value' => "$age_accepted")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Total Capacity<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Total Capacity', 'id' => "total_capacity", 'name' => "total_capacity", 'class' => "form-control", 'value' => "$total_capacity")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">About Daycare Center<span style="color:red">*</span></label>
							<div class="col-md-10">
								<textarea name="about_daycare" class="form-control"></textarea>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Monday<span style="color:red">*</span></label>
							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '7:00 AM', 'name' => "monday[open]", 'class' => "form-control start_time")); ?>
								<div class="form-control-focus"> </div>
							</div>

							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '8:00 AM', 'name' => "monday[close]", 'class' => "form-control end_time")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Tuesday<span style="color:red">*</span></label>
							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '7:00 AM', 'name' => "tuesday[open]", 'class' => "form-control start_time")); ?>
								<div class="form-control-focus"> </div>
							</div>

							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '8:00 AM', 'name' => "tuesday[close]", 'class' => "form-control end_time")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Wednesday<span style="color:red">*</span></label>
							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '7:00 AM', 'name' => "wednesday[open]", 'class' => "form-control start_time")); ?>
								<div class="form-control-focus"> </div>
							</div>

							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '8:00 AM', 'name' => "wednesday[close]", 'class' => "form-control end_time")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>


						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Thrusday<span style="color:red">*</span></label>
							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '7:00 AM', 'name' => "thrusday[open]", 'class' => "form-control start_time")); ?>
								<div class="form-control-focus"> </div>
							</div>

							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '8:00 AM', 'name' => "thrusday[close]", 'class' => "form-control end_time")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>


						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Friday<span style="color:red">*</span></label>
							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '7:00 AM', 'name' => "friday[open]", 'class' => "form-control start_time")); ?>
								<div class="form-control-focus"> </div>
							</div>

							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '8:00 AM', 'name' => "friday[close]", 'class' => "form-control end_time")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Saturday<span style="color:red">*</span></label>
							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '7:00 AM', 'name' => "saturday[open]", 'class' => "form-control start_time")); ?>
								<div class="form-control-focus"> </div>
							</div>

							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '8:00 AM', 'name' => "saturday[close]", 'class' => "form-control end_time")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Sunday<span style="color:red">*</span></label>
							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '7:00 AM', 'name' => "sunday[open]", 'class' => "form-control start_time")); ?>
								<div class="form-control-focus"> </div>
							</div>

							<div class="col-md-5">
								<?php echo form_input(array('placeholder' => '8:00 AM', 'name' => "sunday[close]", 'class' => "form-control end_time")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<?php if (!empty($service_types)) { foreach ($service_types as $key => $value) { ?>
							<label for="form_control_title" class="control-label col-md-2"><?php echo $value->name; ?></label>
							<div class="col-md-10">					
		                        <input type="radio" name="service_types[<?php echo $value->id; ?>]" id="yes-<?php echo $key; ?>" value='Yes'>
		                        <label for=""yes-<?php echo $key; ?>">
		                            Yes
		                        </label>
			                   
		                        
		                        <input type="radio" name="service_types[<?php echo $value->id; ?>]" id="no-<?php echo $key; ?>" value='No'>
		                        <label for="no-<?php echo $key; ?>">
		                           No
		                        </label>
								<div class="form-control-focus"> </div>			
							</div>
			                  <?php } } ?>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Images<span style="color:red">*</span></label>
							<div class="col-md-10">
								<input type="file" name="files[]" id="files" multiple="">
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/services'); ?>" class="btn default">Cancel</a>
							</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
$(document).ready(function(){
    $('input.start_time').timepicker({autoclose: true});
    $('input.end_time').timepicker({autoclose: true});
});
</script>