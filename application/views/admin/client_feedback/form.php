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
				<a href="<?php echo site_url('admin/advertisement/events')?>" class="tooltips" data-original-title="Special Education List" data-placement="top" data-container="body">Event List</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update Event 
				 <?php } else { ?>
				 	Add New Event 
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/client_feedback'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<label for="form_control_title" class="control-label col-md-2">Title<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Title', 'id' => "title", 'name' => "title", 'class' => "form-control", 'value' => "$title")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Description<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Description', 'id' => "description", 'name' => "description", 'class' => "form-control", 'value' => "$description")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="image" class="col-md-2 control-label">Image </label>
							<div class="col-md-10">
								<div class="fileinput fileinput-new" data-provides="fileinput">
									<span class="btn default btn-file">
									<span class="fileinput-new">
									Select Image </span>
									<span class="fileinput-exists">
									Change </span>
									<input type="file" id="image" name="image">
									</span>
									<span class="fileinput-filename">
									</span>
									&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
									</a>
								</div>
							</div>
						</div>
						<?php if ($task =='edit') { ?>
						<div class="form-group form-md-line-input">
							<label for="profile_image" class="col-md-2 control-label">Preview</label>
							<div class="col-md-10">
								<img id="preview_image" name="image" href="<?php if(isset($image)){ echo $image; } ?>" src="<?php if(isset($image)){ echo site_url('assets/uploads/profile_image/'.$image); } ?>" height="80" width="100" alt="No Image Selected" />
							</div>
						</div>
						<?php } ?>

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/client_feedback'); ?>" class="btn default">Cancel</a>
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
	$("#date").datepicker({
		format: 'dd/mm/yyyy',
        autoclose: true, 
        todayHighlight: true
  	});
</script>