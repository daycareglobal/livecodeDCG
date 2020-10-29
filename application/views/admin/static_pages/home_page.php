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
					<span class="caption-subject bold uppercase">Home Page</span>
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
                                        <i class="icon-settings"></i>Home Page Image</div>
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
												<label for="profile_image" class="col-md-2 control-label">Home Page Image </label>
												<div class="col-md-10">
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<span class="btn default btn-file">
														<span class="fileinput-new">
														Select Image </span>
														<span class="fileinput-exists">
														Change </span>
														<input type="file" id="profile_image" name="home_page_image">
														</span>
														<span class="fileinput-filename">
														</span>
														&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
														</a>
													</div>
												</div>
											</div>
											
											<div class="form-group form-md-line-input">
												<label for="profile_image" class="col-md-2 control-label">Preview</label>
												<div class="col-md-10">
													<img id="preview_image" name="profile_image" href="<?php if(isset($records[9]->value)){ echo $records[9]->value; } ?>" src="<?php if(isset($records[9]->value)){ echo site_url('assets/uploads/static_pages/'.$records[9]->value); } ?>" height="80" width="100" alt="No Image Selected" />
												</div>
											</div>
											<div class="col-md-12">
												<span style="color: red" class="fileinput-filename">Image should be more then or equals to 1920*900 ratio.</span>
											</div>
										</div>
									</div>
                                </div>
                            </div>

                            <div class="portlet portlet-sortable box green-haze">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings"></i>Welcome to daycareglobal</div>
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
												<label for="profile_image" class="col-md-2 control-label">Welcome Daycare Image </label>
												<div class="col-md-10">
													<div class="fileinput fileinput-new" data-provides="fileinput">
														<span class="btn default btn-file">
														<span class="fileinput-new">
														Select Image </span>
														<span class="fileinput-exists">
														Change </span>
														<input type="file" id="profile_image_1" name="welcome_daycare_image">
														</span>
														<span class="fileinput-filename">
														</span>
														&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
														</a>
													</div>
												</div>
											</div>
											
											<div class="form-group form-md-line-input">
												<label for="profile_image_1" class="col-md-2 control-label">Preview</label>
												<div class="col-md-10">
													<img id="preview_image_1" name="profile_image_1" href="<?php if(isset($records[0]->image)){ echo $records[0]->image; } ?>" src="<?php if(isset($records[0]->image)){ echo site_url('assets/uploads/static_pages/'.$records[0]->image); } ?>" height="80" width="100" alt="No Image Selected" />
												</div>
											</div>
											<div class="col-md-12">
												<span style="color: red" class="fileinput-filename">Image should be more then or equals to 400*600 ratio.</span>
											</div>
										</div>
										<div class="col-md-12">
											<div class="form-group form-md-line-input">
												<textarea type="text" name="welcome-to-daycareglobal" class="form-control" id="welcome-to-daycareglobal" placeholder="Enter Welcome Message" value=""> <?php echo $records[0]->value; ?> </textarea>		
												<!-- <label for="form_control_smtp_host">Welcome to daycareglobal <span style="color:red">*</span></label> -->
											</div>
										</div>
									</div>
                                </div>
                            </div>
                            <div class="portlet portlet-sortable box green-haze">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>How it works</div>
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
												<input type="text" name="<?php echo $records[1]->slug; ?>" class="form-control" id="<?php echo $records[1]->slug; ?>" placeholder="Enter <?php echo $records[1]->title; ?>" value="<?php echo $records[1]->value; ?>">
												<label for="form_control_smtp_pass"><?php echo $records[1]->title; ?> <span style="color:red">*</span></label>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group form-md-line-input">
												<input type="text" name="<?php echo $records[2]->slug; ?>" class="form-control" id="<?php echo $records[2]->slug; ?>" placeholder="Enter <?php echo $records[2]->title; ?>" value="<?php echo $records[2]->value; ?>">
												<label for="form_control_smtp_pass"><?php echo $records[2]->title; ?> <span style="color:red">*</span></label>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group form-md-line-input">
												<input type="text" name="<?php echo $records[3]->slug; ?>" class="form-control" id="<?php echo $records[3]->slug; ?>" placeholder="Enter <?php echo $records[3]->title; ?>" value="<?php echo $records[3]->value; ?>">
												<label for="form_control_smtp_pass"><?php echo $records[3]->title; ?> <span style="color:red">*</span></label>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group form-md-line-input">
												<input type="text" name="<?php echo $records[4]->slug; ?>" class="form-control" id="<?php echo $records[4]->slug; ?>" placeholder="Enter <?php echo $records[4]->title; ?>" value="<?php echo $records[4]->value; ?>">
												<label for="form_control_smtp_pass"><?php echo $records[4]->title; ?> <span style="color:red">*</span></label>
											</div>
										</div>
									</div>
                                </div>
                            </div>

                            <div class="portlet portlet-sortable box green-haze">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-phone"></i>Our Values</div>
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
												<input type="text" name="our_value[0][title]" class="form-control" id="our_value[0][title]" placeholder="Enter <?php echo $records[5]->title; ?>" value="<?php echo $records[5]->title; ?>">

												<textarea type="text" name="our_value[0][value]" class="form-control" id="our_value[0][value]" placeholder="Enter <?php echo $records[5]->title; ?>"><?php echo $records[5]->value; ?></textarea>
												<!-- <label for="form_control_smtp_pass"><?php echo $records[5]->title; ?> <span style="color:red">*</span></label> -->
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group form-md-line-input">
												<input type="text" name="our_value[1][title]" class="form-control" id="our_value[1][title]" placeholder="Enter <?php echo $records[6]->title; ?>" value="<?php echo $records[6]->title; ?>">

												<textarea type="text" name="our_value[1][value]" class="form-control" id="our_value[1][value]" placeholder="Enter <?php echo $records[6]->title; ?>"><?php echo $records[6]->value; ?></textarea>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group form-md-line-input">
												<input type="text" name="our_value[2][title]" class="form-control" id="our_value[2][title]" placeholder="Enter <?php echo $records[7]->title; ?>" value="<?php echo $records[7]->title; ?>">

												<textarea type="text" name="our_value[2][value]" class="form-control" id="our_value[2][value]" placeholder="Enter <?php echo $records[7]->title; ?>"><?php echo $records[7]->value; ?></textarea>
											</div>
										</div>

										<div class="col-md-12">
											<div class="form-group form-md-line-input">
												<input type="text" name="our_value[3][title]" class="form-control" id="our_value[3][title]" placeholder="Enter <?php echo $records[8]->title; ?>" value="<?php echo $records[8]->title; ?>">

												<textarea type="text" name="our_value[3][value]" class="form-control" id="our_value[3][value]" placeholder="Enter <?php echo $records[8]->title; ?>"><?php echo $records[8]->value; ?></textarea>
											</div>
										</div>
									</div>
                                </div>
                            </div>

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