<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/contact_queries')?>" class="tooltips" data-original-title="List of contact queries" data-placement="top" data-container="body">List of Contact Queries</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>Queries Reply</li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/contact_queries'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<i class="icon-globe"></i>
							<span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
						</div>
					</div>					
				</div>
			</div>		
			<div class="portlet-body form">		
				<div class="form-body">
					<?php if(!empty($contactQueries)) {?>
						<div class="portlet portlet-sortable box green-haze">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span>Contact Details</span>
                                </div>
                                <div class="tools">
                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body portlet-empty"> 
                            	 <section style="margin-top: 20px; background-color: white; ">
							        <table class="table table-bordered table-condensed">
										
										
							            <tr>
							                <th>Name</th>
							                <td><?php echo $contactQueries->name?></td>
							            </tr>

							            <tr>
							                <th>Email</th>
							                <td><?php echo $contactQueries->email; ?></td>
							            </tr>

							            <tr>
							                <th>Phone Number</th>
							                <td><?php echo $contactQueries->phone_number; ?></td>
							            </tr>

							            <tr>
							                <th>Message</th>
							                <td><?php echo $contactQueries->message; ?></td>
							            </tr>
							            <tr>
							                <th>Reply</th>
							                <td><?php echo $contactQueries->is_replied; ?></td>
							            </tr>

							            <tr>
							                <th>Viewed</th>
							                <td><?php echo $contactQueries->is_viewed; ?></td>
							            </tr>
							            
							            <tr>
							                <th>Add Date</th>
							                <td><?php echo date('F d, Y', strtotime($contactQueries->add_date)); ?></td>
							            </tr>
							           
							           
							          </table>
							    </section>								                       
							</div>
                        </div>						 
				    <?php } else {?>
				    	<div class="alert alert-info">No record found</div>
				    <?php } ?>
				</div>
				<div class="form-body">
					<div class="portlet portlet-sortable box green-haze">
                        <div class="portlet-title">
                            <div class="caption">
                                <span>Reply</span>
                            </div>
                            <div class="tools">
                                <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                            </div>
                        </div>
                        <div class="portlet-body portlet-empty"> 
                        	 <section style="margin-top: 20px; background-color: white; ">
						        
                        	 <?php if( $contactQueries->reply_message ){ ?>
						    	Reply message: <?php echo $contactQueries->reply_message; ?>
						    <?php } else { ?>
						        <?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form'));?>

		                    	
								<div class="portlet-body portlet-empty">  
		                        	<div class="form-group form-md-line-input">
										<label for="form_control_tags" class="control-label col-md-2">Message Reply <span style="color:red">*</span></label>
										<div class="col-md-10">								
											<?php echo form_textarea(array('placeholder' => "Enter Reply Message", 'id' => "reply_message",'rows' =>'4', 'name' => "reply_message", 'class' => "form-control", 'value' => "")); ?>
											<div class="form-control-focus"> </div>
										</div>
									</div>						
								</div>

								<div class="form-actions noborder">
									<div class="row">
										<div class="col-md-offset-2 col-md-10">
										<button type="submit" class="btn green">Submit</button>
										<a href="<?php echo base_url('admin/contact_queries'); ?>" class="btn default">Cancel</a>
									</div>
									</div>
								</div>
						        </form>
						    <?php } ?>
						    </section>								                       
						</div>
                    </div>						 
				</div>
			</div>
		</div>
	</div>
</div>