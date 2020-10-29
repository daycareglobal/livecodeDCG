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
				<a href="<?php echo site_url('admin/users/profile_detail/'.$user_id	)?>" class="tooltips" data-original-title="Business List" data-placement="top" data-container="body">Business List</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update Business 
				 <?php } else { ?>
				 	Add Business 
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/users/profile_detail/'.$user_id); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
						<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">

                    	<div class="form-group form-md-line-input">
							<label for="trading_name" class="control-label col-md-2">Trading Name<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Trading Name', 'id' => "trading_name", 'name' => "trading_name", 'class' => "form-control", 'value' => "$trading_name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="number_of_children" class="control-label col-md-2">Number of Children<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Number of Children', 'id' => "number_of_children", 'name' => "number_of_children", 'class' => "form-control", 'value' => "$number_of_children")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="business_type" class="col-md-2 control-label">Business Type<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="business_type_id" class="form-control">
									<option value="">Select Business Type</option>

									<?php foreach ($business_type as $key => $value) { ?>
										<option <?php echo ($value->id == $business_type_id) ? 'selected' : ''; ?> value="<?php echo $value->id; ?>"><?php echo $value->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="business_registered_name" class="control-label col-md-2">Business Registered Name</label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Business Registered Name', 'id' => "business_registered_name", 'name' => "business_registered_name", 'class' => "form-control", 'value' => "$business_registered_name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Company Registration Number<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Company Registration Number', 'id' => "company_registration_number", 'name' => "company_registration_number", 'class' => "form-control", 'value' => "$company_registration_number")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Street Address<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Street Address', 'id' => "street_line_1", 'name' => "street_line_1", 'class' => "form-control", 'value' => "$street_line_1")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Address Line 2</label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter More Address', 'id' => "street_line_2", 'name' => "street_line_2", 'class' => "form-control", 'value' => "$street_line_2")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="country" class="col-md-2 control-label">Country<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="country_id" class="form-control country_list select2me" onchange="load_state()">
									<option></option>
									<?php foreach ($country as $key => $value) { ?>
										<option <?php echo ($value->id == $country_id) ? 'selected' : ''; ?> value="<?php echo $value->id; ?>"><?php echo $value->name ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="state" class="col-md-2 control-label">State<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="state_id" class="form-control state_list select2me" onchange="load_city()">
									<option></option>
								</select>
							</div>
						</div>
						<div class="form-group form-md-line-input">
							<label for="city" class="col-md-2 control-label">City<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="city_id" class="form-control city_list select2me">
									<option></option>
								</select>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="zipcode" class="control-label col-md-2">Postal/Zipcode<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter postal/zipcode', 'id' => "zipcode", 'name' => "zipcode", 'class' => "form-control", 'value' => "$zipcode")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="zipcode" class="control-label col-md-2">Customer Enquiry number<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Customer enquiry number', 'id' => "customer_enquiry_number", 'name' => "customer_enquiry_number", 'class' => "form-control", 'value' => "$customer_enquiry_number")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="zipcode" class="control-label col-md-2">Customer Enquiry email<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Customer enquiry email', 'id' => "customer_enquiry_email", 'name' => "customer_enquiry_email", 'class' => "form-control", 'value' => "$customer_enquiry_email")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="service_type" class="col-md-2 control-label">Service type/Type of childcare provider<span style="color:red">*</span></label>
							<div class="col-md-8">
								<?php foreach ($service_type as $key => $value) {

										$selected = '';
											if ($selected_service_type && !empty($selected_service_type)) {

												foreach ($selected_service_type as $k => $v) {

													if ($value->id == $v->service_type_id) {
														$selected = 'checked';
														break;
													}
												} 
											}
										?>
									<div class="col-md-5">
										<label><input type="checkbox" name="service_type_id[]" value="<?php echo $value->id; ?>" <?php echo $selected; ?>><?php echo $value->name ?></label>
									</div>
								<?php } ?>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="special_education" class="col-md-2 control-label">Special Education<span style="color:red">*</span></label>
							<div class="col-md-8">
								<?php foreach ($special_education as $key => $value) {

										$selected = '';
											if ($selected_education && !empty($selected_education)) {

												foreach ($selected_education as $k => $v) {

													if ($value->id == $v->special_education_id) {
														$selected = 'checked';
														break;
													}
												} 
											}
										?>
									<div class="col-md-5">
										<label><input type="checkbox" name="special_education_id[]" value="<?php echo $value->id; ?>" <?php echo $selected; ?>><?php echo $value->name ?></label>
									</div>
								<?php } ?>
								<div class="col-md-5">
									<label><input type="checkbox" class="special_education_own" name="add_own_education" value="add_your_own" <?php echo ($special_education_own && !empty($special_education_own))?'checked':''; ?>>Add Your Own</label>

									<?php if ($task == 'add') { ?>
										<div class="special_education_input append_row hide" id="append_row" data-key="0">
											<input type="text" name="special_education_own[0]" placeholder="Enter special education" value="">
											<a href="javascript:void(0)" id="add_special_edu" class=""><i class="fa fa-plus"></i></a>
										</div>

									<?php } else { ?>

										<?php if ($special_education_own && !empty($special_education_own)) { 

											foreach ($special_education_own as $k_edu => $v_edu) {
										?>

											<div class="special_education_input append_row" id="append_row">
												<input type="text" name="special_education_own[<?php echo $k_edu; ?>]" placeholder="Enter special education" value="<?php echo $v_edu->education_name; ?>">

												<?php if ($k_edu == 0) { ?>
													<a href="javascript:void(0)" id="add_special_edu" class=""><i class="fa fa-plus"></i></a>

												<?php } else { ?>
													<a href="javascript:void(0)" id="" class="" onclick="deleteSpecialEdu(this)" data-key="<?php echo $k_edu; ?>"><i class="fa fa-minus"></i></a>
												<?php } ?>

											</div>

										<?php } } ?>
									<?php } ?>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="curricular_activities" class="col-md-2 control-label">Curricular Activity<span style="color:red">*</span></label>
							<div class="col-md-8">
								<?php foreach ($curricular_activities as $key => $value) {

									$selected = '';

										if ($selected_activity && !empty($selected_activity)) {

											foreach ($selected_activity as $k => $v) {

												if ($value->id == $v->curricular_activity_id) {
													$selected = 'checked';
													break;
												}
											}
										}
									?>
									<div class="col-md-5">
										<label><input type="checkbox" name="curricular_activity_id[]" value="<?php echo $value->id; ?>" <?php echo $selected; ?>><?php echo $value->name ?></label>
									</div>
								<?php } ?>
								<div class="col-md-5">
									<label><input type="checkbox" class="curricular_activity_own" name="add_own_activity" value="add_your_own" <?php echo ($curricular_activity_own && !empty($curricular_activity_own))?'checked':''; ?>>Add Your Own</label>

									<?php if ($task == 'add') { ?>
										<div class="curricular_activity_input append_activity_row hide" id="append_activity_row" data-key="0">
											<input type="text" name="curricular_activity_own[0]" placeholder="Enter curricular activities" value="">
											<a href="javascript:void(0)" id="add_own_activity" class=""><i class="fa fa-plus"></i></a>
										</div>

									<?php } else { ?>

										<?php if ($curricular_activity_own && !empty($curricular_activity_own)) { 

											foreach ($curricular_activity_own as $k_act => $v_act) {
										?>

											<div class="curricular_activity_input append_activity_row" id="append_activity_row">
												<input type="text" name="curricular_activity_own[<?php echo $k_act; ?>]" placeholder="Enter curricular activities" value="<?php echo $v_act->activity_name; ?>">

												<?php if ($k_act == 0) { ?>
													<a href="javascript:void(0)" id="add_own_activity" class=""><i class="fa fa-plus"></i></a>

												<?php } else { ?>
													<a href="javascript:void(0)" id="" class="" onclick="deleteActivity(this)" data-key="<?php echo $key; ?>"><i class="fa fa-minus"></i></a>
												<?php } ?>
											</div>
										<?php } } ?>
									<?php } ?>
								</div>

							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="ofsted_registered" class="control-label col-md-2">Registered with Ofsted<span style="color:red">*</span></label>
							<div class="md-radio-inline">
								<div class="md-radio">
									<input id="radio19" class="md-radiobtn ofsted_registered" type="radio" name="ofsted_registered" value="Yes" <?php echo ($ofsted_registered == 'Yes')?'checked':''; ?>>
									<label for="radio19">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Yes</label>
								</div>
								<div class="md-radio">
									<input id="radio20" class="md-radiobtn ofsted_registered" type="radio" name="ofsted_registered" value="No" <?php echo ($ofsted_registered == 'No')?'checked':''; ?>>
									<label for="radio20">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>No</label>
								</div>
								<div class="md-radio">
									<input id="radio21" class="md-radiobtn ofsted_registered" type="radio" name="ofsted_registered" value="In-Process" <?php echo ($ofsted_registered == 'In-Process')?'checked':''; ?>>
									<label for="radio21">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>In the process of applying for registration</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input ofsted_registration_number_div hide">
							<label for="zipcode" class="control-label col-md-2">Ofsted Registration Number<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Ofsted Registration Number', 'id' => "ofsted_registration_number", 'name' => "ofsted_registration_number", 'class' => "form-control", 'value' => "$ofsted_registration_number")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="ofsted_rating" class="control-label col-md-2">Ofsted Rating</label>
							<div class="md-radio-inline">
								<div class="md-radio">
									<input id="radio22" class="md-radiobtn" type="radio" name="ofsted_rating" value="Outstanding" <?php echo ($ofsted_rating == 'Outstanding')?'checked':''; ?>>
									<label for="radio22">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Outstanding</label>
								</div>
								<div class="md-radio">
									<input id="radio23" class="md-radiobtn" type="radio" name="ofsted_rating" value="Good" <?php echo ($ofsted_rating == 'Good')?'checked':''; ?>>
									<label for="radio23">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Good</label>
								</div>
								<div class="md-radio">
									<input id="radio24" class="md-radiobtn" type="radio" name="ofsted_rating" value="Requires Improvement" <?php echo ($ofsted_rating == 'Requires Improvement')?'checked':''; ?>>
									<label for="radio24">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Requires Improvement</label>
								</div>
								<div class="md-radio">
									<input id="radio25" class="md-radiobtn" type="radio" name="ofsted_rating" value="Inadequate" <?php echo ($ofsted_rating == 'Inadequate')?'checked':''; ?>>
									<label for="radio25">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Inadequate</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Accept Childcare Vouchers</label>
							<div class="md-radio-inline">
								<div class="md-radio">
									<input id="radio34" class="md-radiobtn" type="radio" name="childcare_voucher" value="All" <?php echo ($childcare_voucher == 'All')?'checked':''; ?>>
									<label for="radio34">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>All</label>
								</div>
								<div class="md-radio">
									<input id="radio26" class="md-radiobtn" type="radio" name="childcare_voucher" value="Some" <?php echo ($childcare_voucher == 'Some')?'checked':''; ?>>
									<label for="radio26">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Some</label>
								</div>
								<div class="md-radio">
									<input id="radio27" class="md-radiobtn" type="radio" name="childcare_voucher" value="Most" <?php echo ($childcare_voucher == 'Most')?'checked':''; ?>>
									<label for="radio27">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Most</label>
								</div>
								<div class="md-radio">
									<input id="radio28" class="md-radiobtn" type="radio" name="childcare_voucher" value="None" <?php echo ($childcare_voucher == 'None')?'checked':''; ?>>
									<label for="radio28">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>None</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="zipcode" class="control-label col-md-2">Services that business provides</label>
							<div class="col-md-10">
								<div class="col-md-5">
									<label><input type="checkbox" name="tax_free" value="tax_free" <?php echo ($tax_free && $tax_free == 'Yes') ? 'checked':''; ?>>Tax-Free Childcare Scheme</label>
									<label><input type="checkbox" name="fifteen_funded_three_four_year" value="fifteen_funded_three_four_year" <?php echo ($fifteen_funded_three_four_year && $fifteen_funded_three_four_year == 'Yes') ? 'checked':''; ?>>15 Funded hours for 3 and 4 years old</label>
								</div>

								<div class="col-md-5">
									<label><input type="checkbox" name="fifteen_funded_two_year" value="fifteen_funded_two_year" <?php echo ($fifteen_funded_two_year && $fifteen_funded_two_year == 'Yes') ? 'checked':''; ?>>15 Funded hours for 2 years old</label>
									<label><input type="checkbox" name="thirty_funded_three_four_year" value="thirty_funded_three_four_year" <?php echo ($thirty_funded_three_four_year && $thirty_funded_three_four_year == 'Yes') ? 'checked':''; ?>>30 Funded hours for 3 and 4 years old</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Holiday Club services</label>
							<div class="md-radio-inline">
								<div class="md-radio">
									<input id="radio35" class="md-radiobtn" type="radio" name="holiday_club_services" value="No Holiday Club" <?php echo ($holiday_club_services == 'No Holiday Club')?'checked':''; ?>>
									<label for="radio35">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>No Holiday Club</label>
								</div>
								<div class="md-radio">
									<input id="radio29" class="md-radiobtn" type="radio" name="holiday_club_services" value="Registered children only" <?php echo ($holiday_club_services == 'Registered children only')?'checked':''; ?>>
									<label for="radio29">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Registered children only</label>
								</div>
								<div class="md-radio">
									<input id="radio30" class="md-radiobtn" type="radio" name="holiday_club_services" value="Registered and non-registered children" <?php echo ($holiday_club_services == 'Registered and non-registered children')?'checked':''; ?>>
									<label for="radio30">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Registered and non-registered children</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Offer Emergency Childcare</label>
							<div class="md-radio-inline">
								<div class="md-radio">
									<input id="radio31" class="md-radiobtn" type="radio" name="emergency_childcare" value="Yes" <?php echo ($emergency_childcare == 'Yes')?'checked':''; ?>>
									<label for="radio31">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Yes</label>
								</div>
								<div class="md-radio">
									<input id="radio32" class="md-radiobtn" type="radio" name="emergency_childcare" value="No" <?php echo ($emergency_childcare == 'No')?'checked':''; ?>>
									<label for="radio32">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>No</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="zipcode" class="control-label col-md-2">Business Closing Times<span style="color:red">*</span></label>
							<div class="col-md-10">
								<div class="col-md-10">
									<label><input type="checkbox" name="bank_holidays" value="Bank Holidays" <?php echo ($bank_holidays && $bank_holidays == 'Yes')?'checked':''; ?>>Bank Holidays (England)</label>
								</div>
								<div class="col-md-10">
									<label><input type="checkbox" name="christmas_week" value="Christmas Week" <?php echo ($christmas_week && $christmas_week == 'Yes')?'checked':''; ?>>Christmas Week</label>
								</div>
								<div class="col-md-10">
									<label><input type="checkbox" name="open_all_year" value="Open all Year Round" <?php echo ($open_all_year && $open_all_year == 'Yes')?'checked':''; ?>>Open all Year Round</label>
								</div>
								<div class="col-md-10">
									<!-- <div class="md-radio-inline">
										<div class="md-radio">
											<input id="radio45" class="md-radiobtn" type="radio" name="week_selected" value="38">
											<label for="radio45">
											<span class="inc"></span>
											<span class="check"></span>
											<span class="box"></span>38 Weeks</label>
										</div>
										<div class="md-radio">
											<input id="radio46" class="md-radiobtn" type="radio" name="week_selected" value="52">
											<label for="radio46">
											<span class="inc"></span>
											<span class="check"></span>
											<span class="box"></span>52 Weeks</label>
										</div>
									</div> -->
									<label>
										<input type="checkbox" name="summer_terms_check" value="Summer Terms" <?php echo ($summer_terms && !empty($summer_terms))?'checked':''; ?>>
										<select onchange="load_summer_terms_week()" name="week_summer" class="summer_terms_week">
											<option value="">Select Weeks</option>
											<option <?php echo ($week_summer == '38') ? 'selected' : ''; ?> value="38">38 Weeks</option>
											<option <?php echo ($week_summer == '52') ? 'selected' : ''; ?> value="52">52 Weeks</option>
										</select>
										<select name="38_summer_terms" class="summer_38_week_options hide">
											<option value="">Select Weeks</option>

											<?php for ($i=1; $i <= 12; $i++) { ?>
												<option <?php echo ($i == $summer_terms) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<select name="52_summer_terms" class="summer_52_week_options hide">
											<option value="">Select Weeks</option>

											<?php for ($i=1; $i <= 22; $i++) { ?>
												<option <?php echo ($i == $summer_terms) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<!-- <input type="text" name="summer_terms" placeholder="Enter summer weeks" value="<?php echo $summer_terms; ?>"> --> Weeks in Summer Terms
									</label>
								</div>
								<div class="col-md-10">
									<label>
										<input type="checkbox" name="spring_terms_check" value="Spring Terms" <?php echo ($spring_terms && !empty($spring_terms))?'checked':''; ?>>
										<select onchange="load_spring_terms_week()" name="week_spring" class="spring_terms_week">
											<option value="">Select Weeks</option>
											<option <?php echo ($week_spring == '38') ? 'selected' : ''; ?> value="38">38 Weeks</option>
											<option <?php echo ($week_spring == '52') ? 'selected' : ''; ?> value="52">52 Weeks</option>
										</select>
										<select name="38_spring_terms" class="spring_38_week_options hide">
											<option value="">Select Weeks</option>

											<?php for ($i=1; $i <= 11; $i++) { ?>
												<option <?php echo ($i == $spring_terms) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<select name="52_spring_terms" class="spring_52_week_options hide">
											<option value="">Select Weeks</option>

											<?php for ($i=1; $i <= 13; $i++) { ?>
												<option <?php echo ($i == $spring_terms) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<!-- <input type="text" name="spring_terms" placeholder="Enter spring weeks" value="<?php echo $spring_terms; ?>"> --> Weeks in Spring Terms
									</label>
								</div>

								<div class="col-md-10">
									<label>
										<input type="checkbox" name="autumn_terms_check" value="Autumn Terms" <?php echo ($autumn_terms && !empty($autumn_terms))?'checked':''; ?>>
										<select onchange="load_autumn_terms_week()" name="week_autumn" class="autumn_terms_week">
											<option value="">Select Weeks</option>
											<option <?php echo ($week_autumn == '38') ? 'selected' : ''; ?> value="38">38 Weeks</option>
											<option <?php echo ($week_autumn == '52') ? 'selected' : ''; ?> value="52">52 Weeks</option>
										</select>
										<select name="38_autumn_terms" class="autumn_38_week_options hide">
											<option value="">Select Weeks</option>

											<?php for ($i=1; $i <= 15; $i++) { ?>
												<option <?php echo ($i == $autumn_terms) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<select name="52_autumn_terms" class="autumn_52_week_options hide">
											<option value="">Select Weeks</option>

											<?php for ($i=1; $i <= 17; $i++) { ?>
												<option <?php echo ($i == $autumn_terms) ? 'selected' : ''; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
											<?php } ?>
										</select>
										<!-- <input type="text" name="autumn_terms" placeholder="Enter autumn weeks" value="<?php echo $autumn_terms; ?>"> --> Weeks in Autumn Terms
									</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="business_logo" class="col-md-2 control-label">Business Logo </label>
							<div class="col-md-10">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn default btn-file">
									<span class="fileinput-new">
									Select Image </span>
									<span class="fileinput-exists">
									Change </span>
									<input type="file" id="profile_image" name="business_logo">
									</span>
									<span class="fileinput-filename">
									</span>
									&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
									</a>
								</div>
							</div>
						</div>
						
						<div class="form-group form-md-line-input">
							<label for="business_logo" class="col-md-2 control-label">Preview</label>
							<div class="col-md-10">
								<img id="preview_image" name="business_logo" href="<?php if(isset($business_logo)){ echo $business_logo; } ?>" src="<?php if(isset($business_logo)){ echo site_url('assets/uploads/business_logo/'.$business_logo); } ?>" height="80" width="100" alt="No Image Selected" />
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="business_logo" class="col-md-2 control-label">Business Images </label>
							<div class="col-md-8">
			                    <!-- <h3 class="bluesmallTitle">Upload up to 5 images (optional)</h3> -->
			                    <div class="imageslist">
			                      <div class="uploadlogo_form">
			                        <button type="button" class="close" data-click="business_image_one" onclick="imageRemove(this)" ></button>
			                        <input type="file" id="upload_image_one_file" name="upload_image_one_file" />
			                        <label for="upload_image_one_file">Upload<br>Image<img src="<?php if(isset($business_image_one)){ echo site_url('assets/uploads/business_logo/'.$business_image_one); } ?>" class="uploadset_image" <?php if(isset($business_image_one)){ echo "style='display:block'"; } ?> /></label>
			                        <input type="hidden" name="deleted_business_image_one" class="business_image_one_input" value="" />
			                      </div>
			                      <div class="uploadlogo_form">
			                        <button type="button" class="close" data-click="business_image_two" onclick="imageRemove(this)" ></button>
			                        <input type="file" id="upload_image_two_file" name="upload_image_two_file" />
			                        <label for="upload_image_two_file">Upload<br>Image<img src="<?php if(isset($business_image_two)){ echo site_url('assets/uploads/business_logo/'.$business_image_two); } ?>" class="uploadset_image" <?php if(isset($business_image_two)){ echo "style='display:block'"; } ?> /></label>
			                        <input type="hidden" name="deleted_business_image_two" class="business_image_two_input" value="" />
			                      </div>
			                      <div class="uploadlogo_form">
			                        <button type="button" class="close" data-click="business_image_three" onclick="imageRemove(this)" ></button>
			                        <input type="file" id="upload_image_three_file" name="upload_image_three_file" />
			                        <label for="upload_image_three_file">Upload<br>Image<img src="<?php if(isset($business_image_three)){ echo site_url('assets/uploads/business_logo/'.$business_image_three); } ?>" class="uploadset_image" <?php if(isset($business_image_three)){ echo "style='display:block'"; } ?> /></label>
			                        <input type="hidden" name="deleted_business_image_three" class="business_image_three_input" value="" />
			                      </div>
			                      <div class="uploadlogo_form clearfix">
			                        <button type="button" class="close" data-click="business_image_four" onclick="imageRemove(this)" ></button>
			                        <input type="file" id="upload_image_four_file" name="upload_image_four_file" />
			                        <label for="upload_image_four_file">Upload<br>Image<img src="<?php if(isset($business_image_four)){ echo site_url('assets/uploads/business_logo/'.$business_image_four); } ?>" class="uploadset_image" <?php if(isset($business_image_four)){ echo "style='display:block'"; } ?> /></label>
			                        <input type="hidden" name="deleted_business_image_four" class="business_image_four_input" value="" />
			                      </div>
			                      <div class="uploadlogo_form">
			                        <button type="button" class="close" data-click="business_image_five" onclick="imageRemove(this)" ></button>
			                        <input type="file" id="upload_image_five_file" name="upload_image_five_file" />
			                        <label for="upload_image_five_file">Upload<br>Image<img src="<?php if(isset($business_image_five)){ echo site_url('assets/uploads/business_logo/'.$business_image_five); } ?>" class="uploadset_image" <?php if(isset($business_image_five)){ echo "style='display:block'"; } ?> /></label>
			                        <input type="hidden" name="deleted_business_image_five" class="business_image_five_input" value="" />
			                      </div>
			                    </div>
			                </div>
						</div>

						<!-- <div class="form-group form-md-line-input">
							<label for="business_image1" class="col-md-2 control-label">Business Image</label>
							<div class="col-md-2">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn default btn-file">
									<span class="fileinput-new">
									Select Image </span>
									<span class="fileinput-exists">
									Change </span>
									<input type="file" id="profile_image" name="business_image1">
									</span>
									<span class="fileinput-filename">
									</span>
									&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
									</a>
								</div>
							</div>
						</div> -->
						
						<!-- <div class="form-group form-md-line-input">
							<label for="business_image1" class="col-md-2 control-label">Preview</label>
							<div class="col-md-2">
								<img id="preview_image1" name="business_image1" href="<?php if(isset($business_image1)){ echo $business_image1; } ?>" src="<?php if(isset($business_image1)){ echo site_url('assets/uploads/business_logo/'.$business_image1); } ?>" height="80" width="100" alt="No Image Selected" />
							</div>
						</div> -->

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn green">Submit</button>
									<a href="<?php echo base_url('admin/users/profile_detail/'.$user_id); ?>" class="btn default">Cancel</a>
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
	var selected_state_id = "<?php echo $state_id; ?>";
	var selected_city_id = "<?php echo $city_id; ?>";

	$('#add_special_edu').click(function() {
	    var key = $('.append_row').length;
	    $.ajax({
	       url: "<?php echo site_url('admin/users/append_own_edu'); ?>",
	       method:'POST',
	       dataType:'json',
	       data:{key:key},
	       success:function(data){                
		        if ( data.success ) {
		           $('.append_row').last().after(data.html);
		        }
	        }
	    }); 
  	});

  	$('#add_own_activity').click(function() {
	    var key = $('.append_activity_row').length;
	    $.ajax({
	       url: "<?php echo site_url('admin/users/append_own_activity'); ?>",
	       method:'POST',
	       dataType:'json',
	       data:{key:key},
	       success:function(data) {

		        if ( data.success ) {
		           $('.append_activity_row').last().after(data.html);
		        }
	        }
	    }); 
  	});

  	function deleteSpecialEdu($this) {
	    var key = $($this).attr('data-key');
	    $($this).closest('.append_row').remove();
	}

	function deleteActivity($this) {
	    var key = $($this).attr('data-key');
	    $($this).closest('.append_activity_row').remove();
	}

	function load_summer_terms_week()
	{
		var summer_week = $(".summer_terms_week option:selected").val();

		if (summer_week == '38') {
			$('.summer_38_week_options').removeClass('hide');
			$('.summer_52_week_options').addClass('hide');
			$('.summer_52_week_options').val('');
		} else {
			$('.summer_52_week_options').removeClass('hide');
			$('.summer_38_week_options').addClass('hide');
			$('.summer_38_week_options').val('');
		}
	}

	function load_spring_terms_week()
	{
		var spring_week = $(".spring_terms_week option:selected").val();

		if (spring_week == '38') {
			$('.spring_38_week_options').removeClass('hide');
			$('.spring_52_week_options').addClass('hide');
			$('.spring_52_week_options').val('');
		} else {
			$('.spring_52_week_options').removeClass('hide');
			$('.spring_38_week_options').addClass('hide');
			$('.spring_38_week_options').val('');
		}
	}

	function load_autumn_terms_week()
	{
		var autumn_week = $(".autumn_terms_week option:selected").val();

		if (autumn_week == '38') {
			$('.autumn_38_week_options').removeClass('hide');
			$('.autumn_52_week_options').addClass('hide');
			$('.autumn_52_week_options').val('');
		} else {
			$('.autumn_52_week_options').removeClass('hide');
			$('.autumn_38_week_options').addClass('hide');
			$('.autumn_38_week_options').val('');
		}
	}
	
	$(function(){
		var task = "<?php echo $task; ?>";
		var selected_summer_terms = "<?php echo $summer_terms; ?>";
		var selected_spring_terms = "<?php echo $spring_terms; ?>";
		var selected_autumn_terms = "<?php echo $autumn_terms; ?>";

		if (task == 'edit') {

			if (selected_summer_terms) {
				load_summer_terms_week();
			}

			if (selected_spring_terms) {
				load_spring_terms_week();
			}

			if (selected_autumn_terms) {
				load_autumn_terms_week();
			}
		}

		if (selected_state_id) {
			load_state();		
		}
		$('.dob').datepicker({
			format:'yyyy-mm-dd',
			endDate: '-18y',
        	autoclose: true
		});

		var ofsted_registered = "<?php echo $ofsted_registered; ?>";

		if (ofsted_registered && ofsted_registered != 'No') {
			$('.ofsted_registration_number_div').removeClass('hide');
		}

		$(".special_education_own").click(function() {
            var radioValue = $("input[name='add_own_education']:checked").val();

            if (radioValue) {
				$('.special_education_input').removeClass('hide');
            } else {
				$('.special_education_input').addClass('hide');
            }
		});

		$(".curricular_activity_own").click(function() {
            var radioValue = $("input[name='add_own_activity']:checked").val();

            if (radioValue) {
				$('.curricular_activity_input').removeClass('hide');
            } else {
				$('.curricular_activity_input').addClass('hide');
            }
		});

		$(".ofsted_registered").click(function(){
            var radioValue = $("input[name='ofsted_registered']:checked").val();

            if (radioValue != 'No') {
                $('.ofsted_registration_number_div').removeClass('hide');

            } else {
                $('.ofsted_registration_number_div').addClass('hide');
            }

        });
	});

	function load_state()
	{
		var country_id = $(".country_list option:selected").val();
		var action_url = "<?php echo site_url('admin/users/ajax_states'); ?>";
    	// var country_id = $(".country_list option:selected").val();
    	$.getJSON(action_url,{country_id:country_id,selected_state_id:selected_state_id},function(data) {

		  	if (data.success) {
	           $('.state_list').html(data.html);
	           $('.city_list').html('');
	           
	           if (selected_state_id) {
	           	selected_state_id = '';
	           	load_city();
	           }
	        }
		});
	}

	function load_city()
	{
		var state_id = $(".state_list option:selected").val();
		var action_url = "<?php echo site_url('admin/users/ajax_city'); ?>";
    	$.getJSON(action_url,{state_id:state_id,city_id:selected_city_id},function(data) {

		  	if (data.success) {
	           $('.city_list').html(data.html);
	           selected_city_id = '';
	        }
		});
	}

	function imageRemove($this) {
		var click_button = $($this).attr('data-click');

		if (click_button == 'business_image_one') {
			$('.business_image_one_input').val('Yes');
			$($this).closest('.uploadlogo_form').find('img').attr('src', '');
			$($this).closest('.uploadlogo_form').find('img').css( "display", "none" );
			$($this).closest('.uploadlogo_form').removeClass('addplusmore');

		} else if (click_button == 'business_image_two') {
			$('.business_image_two_input').val('Yes');
			$($this).closest('.uploadlogo_form').find('img').attr('src', '');
			$($this).closest('.uploadlogo_form').find('img').css( "display", "none" );
			$($this).closest('.uploadlogo_form').removeClass('addplusmore');

		} else if (click_button == 'business_image_three') {
			$('.business_image_three_input').val('Yes');
			$($this).closest('.uploadlogo_form').find('img').attr('src', '');
			$($this).closest('.uploadlogo_form').find('img').css( "display", "none" );
			$($this).closest('.uploadlogo_form').removeClass('addplusmore');

		} else if (click_button == 'business_image_four') {
			$('.business_image_four_input').val('Yes');
			$($this).closest('.uploadlogo_form').find('img').attr('src', '');
			$($this).closest('.uploadlogo_form').find('img').css( "display", "none" );
			$($this).closest('.uploadlogo_form').removeClass('addplusmore');

		} else if (click_button == 'business_image_five') {
			$('.business_image_five_input').val('Yes');
			$($this).closest('.uploadlogo_form').find('img').attr('src', '');
			$($this).closest('.uploadlogo_form').find('img').css( "display", "none" );
			$($this).closest('.uploadlogo_form').removeClass('addplusmore');

		}
	}


</script>
<script type="text/javascript">
  $('#upload_image_one_file').change( function(event) {
    $(this).parent().addClass('addplusmore');
    $("label[for='upload_image_one_file'] img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    $('.business_image_one_input').val('');
  });

  $('#upload_image_two_file').change( function(event) {
    $(this).parent().addClass('addplusmore');
    $("label[for='upload_image_two_file'] img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    $('.business_image_two_input').val('');
  });
  $('#upload_image_three_file').change( function(event) {
    $(this).parent().addClass('addplusmore');
    $("label[for='upload_image_three_file'] img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    $('.business_image_three_input').val('');
  });
  $('#upload_image_four_file').change( function(event) {
    $(this).parent().addClass('addplusmore');
    $("label[for='upload_image_four_file'] img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    $('.business_image_four_input').val('');
  });
  $('#upload_image_five_file').change( function(event) {
    $(this).parent().addClass('addplusmore');
    $("label[for='upload_image_five_file'] img").fadeIn("fast").attr('src',URL.createObjectURL(event.target.files[0]));
    $('.business_image_five_input').val('');
  });
</script>
<style type="text/css">
	.uploadlogo_form{ display: block; clear: both; width: 100%; position: relative; }
	.uploadlogo_form input[type="file"]{ position: absolute; width: 1px; height: 1px; visibility: hidden; opacity: 0; }
	.uploadlogo_form label{ background: #eeeeeb; position: relative; overflow: hidden; display: block; border: solid 1px #d9d9d9; width: 152px; height: 152px; border-radius: 4px; text-align: center; font-size: 16px; font-weight: 500; color: #898987; line-height: 1.5; padding-top: 50px; cursor: pointer;}
	.uploadlogo_form label:hover{ background:#ddd; border-color: #bbb; }
	.imageslist .uploadlogo_form{ float: left; width: auto; clear: none; margin: 0 20px 15px 0; }
	.imageslist .uploadlogo_form label{ width: 100px; height: 100px; font-size: 14px; padding-top: 31px; }
	.uploadlogo_form.clearfix{ clear: both; }
	.uploadset_image {display: none; position: absolute; z-index: 1; top: 0; right: 0; bottom: 0; left: 0; object-fit: cover; pointer-events: none; min-height: 100%; min-width: 100%; max-width: inherit; }
	.uploadlogo_form.addplusmore label:hover:before {content: ""; position: absolute; z-index: 3; top: 0; background: rgba(0, 0, 0, 0.3) url(<?php echo base_url('assets/plus.svg'); ?>) center no-repeat; background-size: 30%; right: 0; bottom: 0; left: 0; }
</style>