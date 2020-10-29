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
				<a href="<?php echo site_url('admin/session_type')?>" class="tooltips" data-original-title="Session type list" data-placement="top" data-container="body">Session type list</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update session type
				 <?php } else { ?>
				 	Add session type
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/session_type'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<label for="form_control_title" class="control-label col-md-2">Session Name<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Session name', 'id' => "session_name", 'name' => "session_name", 'class' => "form-control", 'value' => "$session_name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Fees Type</label>
							<div class="col-md-10">					
								
		                        <input id="is_funded" type="checkbox" name="is_funded"  <?php echo ($is_funded == 'Yes')?'checked':''; ?>>
		                        <label for="is_funded">
		                            Funded
		                        </label>
			                   
		                        <input id="is_non_funded" type="checkbox" name="is_non_funded" <?php echo ($is_non_funded == 'Yes')?'checked':''; ?>>
		                        <label for="is_non_funded">
		                           Non Funded
		                        </label>
			                  
								<div class="form-control-focus"> </div>			
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Age Group</label>
							<div class="col-md-10">					
								
		                        <input id="age_group_0_2" type="checkbox" name="age_group_0_2" <?php echo ($age_group_0_2 == 'Yes')?'checked':''; ?>>
		                        <label for="age_group_0_2">
		                            0-2
		                        </label>

		                        <input id="age_group_2_3" type="checkbox" name="age_group_2_3" <?php echo ($age_group_2_3 == 'Yes')?'checked':''; ?>>
		                        <label for="age_group_2_3">
		                            2-3 for 15 hours
		                        </label>

		                        <input id="age_group_15_3_5" type="checkbox" name="age_group_15_3_5" <?php echo ($age_group_15_3_5 == 'Yes')?'checked':''; ?>>
		                        <label for="age_group_15_3_5">
		                            3-5 for 15 hours
		                        </label>

		                        <input id="age_group_30_3_5" type="checkbox" name="age_group_30_3_5" <?php echo ($age_group_30_3_5 == 'Yes')?'checked':''; ?>>
		                        <label for="age_group_30_3_5">
		                            3-5 for 30 hours
		                        </label>

		                        <input id="is_age_above_5" type="checkbox" name="is_age_above_5" <?php echo ($is_age_above_5 == 'Yes')?'checked':''; ?>>
		                        <label for="is_age_above_5">
		                         Above 5
		                        </label>
			                 
								<div class="form-control-focus"> </div>			
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Non-Funded Week Type</label>
							<div class="col-md-10">					
								
		                        <input id="is_week_38_non_funded" type="checkbox" name="is_week_38_non_funded" <?php echo ($is_week_38_non_funded == 'Yes')?'checked':''; ?>>
		                        <label for="is_week_38_non_funded">
		                            38
		                        </label>
			                   
		                        <input id="is_week_52_non_funded" type="checkbox" name="is_week_52_non_funded" <?php echo ($is_week_52_non_funded == 'Yes')?'checked':''; ?>>
		                        <label for="is_week_52_non_funded">
		                           52
		                        </label>
			                  
								<div class="form-control-focus"> </div>			
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Funded Week Type</label>
							<div class="col-md-10">					
								
		                        <input id="is_week_38_funded" type="checkbox" name="is_week_38_funded" <?php echo ($is_week_38_funded == 'Yes')?'checked':''; ?>>
		                        <label for="is_week_38_funded">
		                            38
		                        </label>
			                   
		                        <input id="is_week_52_funded" type="checkbox" name="is_week_52_funded" <?php echo ($is_week_52_funded == 'Yes')?'checked':''; ?>>
		                        <label for="is_week_52_funded">
		                           52
		                        </label>
			                  
								<div class="form-control-focus"> </div>			
							</div>
						</div>

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn green">Submit</button>
									<a href="<?php echo base_url('admin/session_type'); ?>" class="btn default">Cancel</a>
								</div>
							</div>
						</div>

					</form>
					</div>
				</div>
			</div>
		</div>
	</div>