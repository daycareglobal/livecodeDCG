<?php
	if (isset($message) && $message) {
		$alert = ($success)? 'alert-success':'alert-danger';
		echo '<div class="alert ' . $alert . '">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>
			
			<a href="<?php echo site_url('admin/send_email/email_sent_list')?>" class="tooltips" data-original-title="List of email templates" data-placement="top" data-container="body">List of Email Sent</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>
			Send Email Notification
		</li>
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/send_email/email_sent_list'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<i class="fa fa-chain-broken"></i>
							<span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form'));?>
					<div class="form-body">	

						<div class="form-group form-md-line-input">
							<label for="email_template" class="col-md-2 control-label">Email Template<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="email_template_id" class="form-control">
									<option value="">Select Email Template</option>

									<?php foreach ($templates_list as $key => $value) { ?>
										<option value="<?php echo $value->id?>"><?php echo $value->subject ?></option>
									<?php } ?>
								</select>

							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="user_id" class="col-md-2 control-label">Users<span style="color:red">*</span></label>
							<div class="col-md-10">
								<select name="user_id[]" id="user_id[]" class="form-control select2me" multiple="multiple">
									<option value="">Select Users</option>
									<?php foreach ($users_list as $key => $value) { 

										$selected = '';
										/*foreach ($selected_user_ids as $k => $v) {

											if ($value->id == $v) {
												$selected = 'selected';
												break;
											}
										} ?>*/
									?>

										<option  <?php echo $selected; ?> value="<?php echo $value->id?>"><?php echo $value->name ?></option>

									<?php }?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-actions noborder">
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/send_email/email_sent_list'); ?>" class="btn default">Cancel</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>