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
				<a href="<?php echo site_url('admin/membership_plan')?>" class="tooltips" data-original-title="Special Education List" data-placement="top" data-container="body">Membership Plan List</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update Membership Plan 
				 <?php } else { ?>
				 	Add Membership Plan 
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/membership_plan'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<label for="form_control_title" class="control-label col-md-2">Plan Name<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Plan Name', 'id' => "plan_name", 'name' => "plan_name", 'class' => "form-control", 'value' => "$plan_name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Provision Allowed<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter provision allowed', 'id' => "provision_allowed", 'name' => "provision_allowed", 'class' => "form-control", 'value' => "$provision_allowed")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Plan Type<span style="color:red">*</span></label>
							<div class="md-radio-inline">
								<div class="md-radio has-error">
									<input id="radio19" class="md-radiobtn plan_type" type="radio" name="plan_type" value="Free" <?php echo ($plan_type == 'Free')?'checked':''; ?>>
									<label for="radio19">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Free</label>
								</div>
								<div class="md-radio">
									<input id="radio20" class="md-radiobtn plan_type" type="radio" name="plan_type" value="Paid" <?php echo ($plan_type == 'Paid')?'checked':''; ?>>
									<label for="radio20">
									<span class="inc"></span>
									<span class="check"></span>
									<span class="box"></span>Paid</label>
								</div>
							</div>
						</div>

						<div class="form-group form-md-line-input month_div hide">
							<label for="form_control_title" class="control-label col-md-2">Month<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Month', 'id' => "month", 'name' => "month", 'class' => "form-control", 'value' => "$month")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input price_div hide">
							<label for="form_control_title" class="control-label col-md-2">Price(&#163;)<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Price', 'id' => "price", 'name' => "price", 'class' => "form-control", 'value' => "$price")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input annual_discount_div hide">
							<label for="form_control_title" class="control-label col-md-2">Annual Discount(%)<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Annual Discount', 'id' => "annual_discount", 'name' => "annual_discount", 'class' => "form-control", 'value' => "$annual_discount")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/membership_plan'); ?>" class="btn default">Cancel</a>
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
	$(document).ready(function() {
		var plan_type = "<?php echo $plan_type; ?>";

		if (plan_type == 'Free') {
			$('.month_div').removeClass('hide');
			$('.price_div').addClass('hide');
			$('.annual_discount_div').addClass('hide');

		} else {
			$('.month_div').addClass('hide');
			$('.price_div').removeClass('hide');
			$('.annual_discount_div').removeClass('hide');
		}
	});

	$(".plan_type").on("click", function() {
		var plan_type = $("input[name='plan_type']:checked").val();

		if (plan_type == 'Free') {
			$('.month_div').removeClass('hide');
			$('.price_div').addClass('hide');
			$('.annual_discount_div').addClass('hide');

		} else {
			$('.month_div').addClass('hide');
			$('.price_div').removeClass('hide');
			$('.annual_discount_div').removeClass('hide');
		}
	});
</script>