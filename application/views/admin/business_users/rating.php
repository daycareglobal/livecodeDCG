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
				<a href="<?php echo site_url('admin/business_users')?>" class="tooltips" data-original-title="Business User List" data-placement="top" data-container="body">User List</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update Rating 
				 <?php } else { ?>
				 	Add User 
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/business_users'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<label for="form_control_title" class="control-label col-md-2">Rate<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="rating" id="rating" class="form-control" style="height:40px">
							        <option <?php echo ($rating == 1)?'selected':'' ?> value="1">1 Star</option>
							        <option <?php echo ($rating == 2)?'selected':'' ?> value="2">2 Star</option>
							        <option <?php echo ($rating == 3)?'selected':'' ?> value="3">3 Star</option>
							        <option <?php echo ($rating == 4)?'selected':'' ?> value="4">4 Star</option>
							        <option <?php echo ($rating == 5)?'selected':'' ?> value="5">5 Star</option>
						    	</select>
							</div>
						</div>						

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
									<button type="submit" class="btn green">Submit</button>
									<a href="<?php echo base_url('admin/business_users'); ?>" class="btn default">Cancel</a>
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