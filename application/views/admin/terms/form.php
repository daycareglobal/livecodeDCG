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
				<a href="<?php echo site_url('admin/terms')?>" class="tooltips" data-original-title="Terms" data-placement="top" data-container="body">Terms</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update terms 
				 <?php } else { ?>
				 	Add terms
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/terms'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<label for="form_control_title" class="control-label col-md-2">Term name<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php $term_name = isset($record->term_name) ? $record->term_name : ''; ?>
								<?php echo form_input(array('placeholder' => 'Enter term name', 'id' => "term_name", 'name' => "term_name", 'class' => "form-control", 'value' => "$term_name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Term start date<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php $term_start_date = isset($record->term_start_date) ? $record->term_start_date : ''; ?>
								<?php echo form_input(array('placeholder' => 'Enter term start date', 'id' => "term_start_date", 'name' => "term_start_date", 'class' => "form-control term_start_date", 'readonly' => "", 'value' => "$term_start_date")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						
						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Term end date<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php $term_end_date = isset($record->term_end_date) ? $record->term_end_date : ''; ?>
								<?php echo form_input(array('placeholder' => 'Enter term end date', 'id' => "term_end_date", 'readonly' => "", 'name' => "term_end_date", 'class' => "form-control", 'value' => "$term_end_date")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/terms'); ?>" class="btn default">Cancel</a>
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
$(function () {
	$("#term_start_date").datepicker({
		format: 'dd-MM',
		autoclose: true,
	});

	$("#term_end_date").datepicker({
		format: 'dd-MM',
		autoclose: true,
	});

}); 
</script>