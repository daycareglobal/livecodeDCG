<?php
	if ($message) {
		echo '<div class="alert alert-danger">' . $message . '</div>';
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
				Website Setting
			</li>	
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
				</a>
			</li>					
		</ul>			
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="caption font-red-sunglo">
					<i class="icon-settings"></i>
					<span class="caption-subject bold uppercase">Website Setting</span>
				</div>
			</div>
			<div class="portlet-body form">				
				   <?php 
					echo form_open_multipart('', array('class'=>"ajax_form"));
					?>
					<div class="form-body">						
						<div class="portlet portlet-sortable box green-haze">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings"></i>SMTP Details</div>
                                    <div class="tools">
                                        <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                        <a class="fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                                        <a class="remove" href="javascript:;" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body portlet-empty"> 
                                	<div class="row">
										<div class="col-md-6">
											<div class="form-group form-md-line-input">
												<input type="text" name="smtp_host" class="form-control" id="smtp_host" placeholder="Enter SMTP Host" value="<?php echo $options_content->smtp_host ?>">		
												<label for="form_control_smtp_host">SMTP Host <span style="color:red">*</span></label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-md-line-input">
												<input type="text" name="smtp_port" class="form-control" id="smtp_port" placeholder="Enter SMTP Port Number" value="<?php echo $options_content->smtp_port ?>">
												<label for="form_control_smtp_port">SMTP Port Number <span style="color:red">*</span></label>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group form-md-line-input">
												<input type="text" name="smtp_user" class="form-control" id="smtp_user" placeholder="Enter SMTP Port Number" value="<?php echo $options_content->smtp_user ?>">
												<label for="form_control_smtp_user">SMTP Username <span style="color:red">*</span></label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-md-line-input">
												<input type="text" name="smtp_pass" class="form-control" id="smtp_pass" placeholder="Enter SMTP Password" value="<?php echo $options_content->smtp_pass ?>">
												<label for="form_control_smtp_pass">SMTP Password <span style="color:red">*</span></label>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                            <div class="portlet portlet-sortable box green-haze">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-phone"></i>Contact Us Details</div>
                                    <div class="tools">
                                        <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                        <a class="fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                                        <a class="remove" href="javascript:;" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body portlet-empty"> 
                                	<div class="row">
										<div class="col-md-6">
											<div class="form-group form-md-line-input">
												<input type="text" name="contact_phone" class="form-control" id="contact_phone" placeholder="Enter contact number" value="<?php echo $options_content->contact_phone ?>">
												<label for="form_control_smtp_pass">Contact number <span style="color:red">*</span></label>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group form-md-line-input">
												<input type="text" name="contact_email" class="form-control" id="contact_email" placeholder="Enter website url" value="<?php echo $options_content->contact_email ?>">
												<label for="form_control_smtp_pass">Contact Email <span style="color:red">*</span></label>
											</div>
										</div>
									</div>
                                </div>
                            </div>

                            <div class="portlet portlet-sortable box green-haze">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings"></i>Copyright Text</div>
                                    <div class="tools">
                                        <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                        <a class="fullscreen" href="javascript:;" data-original-title="" title=""> </a>
                                        <a class="remove" href="javascript:;" data-original-title="" title=""> </a>
                                    </div>
                                </div>
                                <div class="portlet-body portlet-empty"> 
                                	<div class="row">
										<div class="col-md-6">
											<div class="form-group form-md-line-input">
											<textarea name="copyright_text" placeholder="Enter Copy Right Text" id="copyright_text" class="form-control"><?php echo $copyright_text; ?></textarea>
                        					<label for="form_control_smtp_pass">Copyright Text<span style="color:red">*</span></label></div>
										</div>						
									</div>
                                </div>
                            </div>

	                            <!-- <div class="portlet portlet-sortable box green-haze">
	                                <div class="portlet-title">
	                                    <div class="caption">
	                                        <i class="icon-settings"></i>Contact Details</div>
	                                    <div class="tools">
	                                        <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
	                                        <a class="fullscreen" href="javascript:;" data-original-title="" title=""> </a>
	                                        <a class="remove" href="javascript:;" data-original-title="" title=""> </a>
	                                    </div>
	                                </div>
	                                <div class="portlet-body portlet-empty"> 
	                                	<div class="row">
											<div class="col-md-6">
												<div class="form-group form-md-line-input">
												<input name="contact_email" placeholder="Enter Contact Email" id="contact_email" class="form-control" value="<?php echo $contact_email; ?>">
                            					<label for="form_control_smtp_pass">Contact Email<span style="color:red">*</span></label></div>
											</div>		
											<div class="col-md-6">
												<div class="form-group form-md-line-input">
												<input name="contact_phone" placeholder="Enter Contact Number" id="contact_phone" class="form-control" value="<?php echo $contact_phone; ?>">
                            					<label for="form_control_smtp_pass">Contact Number<span style="color:red">*</span></label></div>
											</div>						
										</div>
	                                </div>
	                            </div>

	                            <div class="portlet portlet-sortable box green-haze">
	                                <div class="portlet-title">
	                                    <div class="caption">
	                                        <i class="icon-settings"></i>Social Icon</div>
	                                    <div class="tools">
	                                        <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
	                                        <a class="fullscreen" href="javascript:;" data-original-title="" title=""> </a>
	                                        <a class="remove" href="javascript:;" data-original-title="" title=""> </a>
	                                    </div>
	                                </div>
	                                <div class="portlet-body portlet-empty"> 
	                                	<div class="row">
											<div class="col-md-6">
												<div class="form-group form-md-line-input">
												<input name="facebook_link" placeholder="Enter Facebook Link" id="facebook_link" class="form-control" value="<?php echo $facebook_link; ?>">
                            					<label for="form_control_smtp_pass">Facebook Link<span style="color:red">*</span></label></div>
											</div>		
										
											<div class="col-md-6">
												<div class="form-group form-md-line-input">
												<input name="instagram_link" placeholder="Enter Instagram Link" id="instagram_link" class="form-control" value="<?php echo $instagram_link; ?>">
                            					<label for="form_control_smtp_pass">Instagram Link<span style="color:red">*</span></label></div>
											</div>		

											<div class="col-md-6">
												<div class="form-group form-md-line-input">
												<input name="you_tube_link" placeholder="Enter Youtube Link" id="you_tube_link" class="form-control" value="<?php echo $you_tube_link; ?>">
                            					<label for="form_control_smtp_pass">Youtube Link<span style="color:red">*</span></label></div>
											</div>							
										</div>
	                                </div>
	                            </div>


	                            <div class="portlet portlet-sortable box green-haze">
	                                <div class="portlet-title">
	                                    <div class="caption">
	                                        <i class="icon-settings"></i>Footer content</div>
	                                    <div class="tools">
	                                        <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
	                                        <a class="fullscreen" href="javascript:;" data-original-title="" title=""> </a>
	                                        <a class="remove" href="javascript:;" data-original-title="" title=""> </a>
	                                    </div>
	                                </div>
	                                <div class="portlet-body portlet-empty"> 
	                                	<div class="row">
											<div class="col-md-12">
												<div class="form-group form-md-line-input">
												<input name="footer_text" placeholder="Enter Facebook Link" id="footer_text" class="form-control" value="<?php echo $footer_text; ?>">
                            					<label for="form_control_smtp_pass">Footer content<span style="color:red">*</span></label></div>
											</div>		
										</div>
	                                </div>
	                            </div> -->
						</div>
					<div class="form-actions noborder">
						<button type="submit" class="btn green">Submit</button>
					</div>
				<?php 
					echo form_close();
				?>
			</div>
		</div>
	</div>
</div>
</script>