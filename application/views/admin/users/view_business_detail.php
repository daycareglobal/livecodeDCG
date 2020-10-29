<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/users/profile_detail/'.$record->user_id)?>" class="tooltips" data-original-title="Users List" data-placement="top" data-container="body">User Business List</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View User Business Detail </li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/users/profile_detail/'.$record->user_id); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
				<div class="form-body row">
					<?php if (!empty($record)) { ?>
						<div class="portlet portlet-sortable box green-haze">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span>Business Details</span>
                                </div>
                                <div class="tools">
                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body portlet-empty"> 
                            	<section style="margin-top: 20px; background-color: white; ">
							        <table class="table table-bordered table-condensed">
							            
							            <tr>
							                <th>Trading name</th>
							                <td><?php echo $record->trading_name; ?></td>
							            </tr>

							            <tr>
							                <th>Number of children</th>
							                <td><?php echo $record->number_of_children; ?></td>
							            </tr>

							            <tr>
							                <th>Business type</th>
							                <td><?php echo $record->business_type; ?></td>
							            </tr>

							            <tr>
							                <th>Business registered name</th>
							                <td><?php echo $record->business_registered_name; ?></td>
							            </tr>

							            <tr>
							                <th>Company registration number</th>
							                <td><?php echo $record->company_registration_number; ?></td>
							            </tr>

							            <tr>
							                <th>Street address</th>
							                <td><?php echo $record->street_line_1; ?></td>
							            </tr>

							            <tr>
							                <th>Address line 2</th>
							                <td><?php echo $record->street_line_2; ?></td>
							            </tr>

							            <tr>
							                <th>City name</th>
							                <td><?php echo $record->city_name; ?></td>
							            </tr>

							            <tr>
							                <th>State name</th>
							                <td><?php echo $record->state_name; ?></td>
							            </tr>

							            <tr>
							                <th>Country name</th>
							                <td><?php echo $record->country_name; ?></td>
							            </tr>

							            <tr>
							                <th>Postal/Zipcode</th>
							                <td><?php echo $record->zipcode; ?></td>
							            </tr>

							            <tr>
							                <th>Customer enquiry number</th>
							                <td><?php echo $record->customer_enquiry_number; ?></td>
							            </tr>

							            <tr>
							                <th>Customer enquiry email</th>
							                <td><?php echo $record->customer_enquiry_email; ?></td>
							            </tr>

							            <tr>
							                <th>Business Logo</th>
							                <td>
												<?php if ($record->business_logo) { ?>
													<img src="<?php if(isset($record)){ echo site_url('assets/uploads/business_logo/'.$record->business_logo); } ?>" height="80" width="100" alt="No User Image" />

												<?php } else{ ?>
													<img id="preview_image"  src="<?php echo site_url('assets/uploads/'.'no_image.jpg'); ?>" height="80" width="100" alt="No User Image" />
												<?php } ?>
											</td>
							            </tr>

							            <tr>
							                <th>Business Images</th>
							                <td>
												<?php if ($record->business_image_one) { ?>
													<img src="<?php if(isset($record)){ echo site_url('assets/uploads/business_logo/'.$record->business_image_one); } ?>" height="80" width="100" alt="No User Image" />

												<?php } if ($record->business_image_two) { ?>
													<img src="<?php if(isset($record)){ echo site_url('assets/uploads/business_logo/'.$record->business_image_two); } ?>" height="80" width="100" alt="No User Image" />

												<?php } if ($record->business_image_three) { ?>
													<img src="<?php if(isset($record)){ echo site_url('assets/uploads/business_logo/'.$record->business_image_three); } ?>" height="80" width="100" alt="No User Image" />

												<?php } if ($record->business_image_four) { ?>
													<img src="<?php if(isset($record)){ echo site_url('assets/uploads/business_logo/'.$record->business_image_four); } ?>" height="80" width="100" alt="No User Image" />

												<?php } if ($record->business_image_five) { ?>
													<img src="<?php if(isset($record)){ echo site_url('assets/uploads/business_logo/'.$record->business_image_five); } ?>" height="80" width="100" alt="No User Image" />
												<?php } ?>
											</td>
							            </tr>

							            <tr>
							                <th>Add date</th>
							                <td><?php echo date('M d, Y h:i A', strtotime($record->add_date)); ?></td>
							            </tr>
							        </table>
							    </section>								                       
							</div>
                        </div>
                        <!-- BEGIN POPOVERS PORTLET FOR ADDRESS-->
						<div class="portlet box red col-md-12">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-book"></i>Service Detail
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
									
								</div>
							</div>
							<div class="portlet-body">
								<div class="row">
									<div class="col-xs-6">
										<div class="well">
											<strong>Service type/Type of childcare provider</strong><br/>
											<ul>
											  <?php foreach ($record->selected_service_type as $key => $value) { ?>
											  	<li><?php echo $value->name; ?></li>
											  <?php } ?>
											</ul>

											<strong>Special education</strong><br/>
											<ul>
											  <?php foreach ($record->selected_education as $key => $value) { ?>
											  	<li><?php echo $value->name; ?></li>
											  <?php } ?>

											  <?php if ($record->special_education_own && !empty($record->special_education_own)) { foreach ($record->special_education_own as $key => $value) { ?>
											  	<li><?php echo $value->education_name.' (Own entered)'; ?></li>
											  <?php } } ?>
											</ul>

											<strong>Curricular activity</strong><br/>
											<ul>
											  <?php foreach ($record->selected_activity as $key => $value) { ?>
											  	<li><?php echo $value->name; ?></li>
											  <?php } ?>

											  <?php if ($record->curricular_activity_own && !empty($record->curricular_activity_own)) { foreach ($record->curricular_activity_own as $key => $value) { ?>
											  	<li><?php echo $value->activity_name.' (Own entered)'; ?></li>
											  <?php } } ?>
											</ul>

											<strong>Services that business provides</strong><br/>
											<ul>
											  <?php if ($record->tax_free && $record->tax_free == 'Yes') { ?>
											  	<li>Tax-Free Childcare Scheme</li>
											  <?php } ?>

											  <?php if ($record->fifteen_funded_three_four_year && $record->fifteen_funded_three_four_year == 'Yes') { ?>
											  	<li>15 Funded hours for 3 and 4 years old</li>
											  <?php } ?>

											  <?php if ($record->fifteen_funded_two_year && $record->fifteen_funded_two_year == 'Yes') { ?>
											  	<li>15 Funded hours for 2 years old</li>
											  <?php } ?>

											  <?php if ($record->thirty_funded_three_four_year && $record->thirty_funded_three_four_year == 'Yes') { ?>
											  	<li>30 Funded hours for 3 and 4 years old</li>
											  <?php } ?>
											</ul>

											<strong>Business Closing Times</strong><br/>
											<ul>
											  <?php if ($record->bank_holidays && $record->bank_holidays == 'Yes') { ?>
											  	<li>Bank Holidays (England)</li>
											  <?php } ?>

											  <?php if ($record->christmas_week && $record->christmas_week == 'Yes') { ?>
											  	<li>Christmas Week</li>
											  <?php } ?>

											  <?php if ($record->open_all_year && $record->open_all_year == 'Yes') { ?>
											  	<li>Open all Year Round</li>
											  <?php } ?>

											  <?php if ($record->summer_terms && !empty($record->summer_terms)) { ?>
											  	<li><?php echo $record->summer_terms.' Weeks ('.$record->week_summer.' weeks total attendance) in Summer Terms' ?></li>
											  <?php } ?>

											  <?php if ($record->spring_terms && !empty($record->spring_terms)) { ?>
											  	<li><?php echo $record->spring_terms.' Weeks ('.$record->week_spring.' weeks total attendance) in Spring Terms' ?></li>
											  <?php } ?>

											  <?php if ($record->autumn_terms && !empty($record->autumn_terms)) { ?>
											  	<li><?php echo $record->autumn_terms.' Weeks ('.$record->week_autumn.' weeks total attendance) in Autumn Terms' ?></li>
											  <?php } ?>
											</ul> 
										</div>
									</div>

									<div class="col-xs-6">
										<div class="well">
											<strong>Registered with Ofsted</strong><br/>
											<ul>
											  <?php if ($record->ofsted_registered && $record->ofsted_registered) { ?>
											  	<li><?php echo ($record->ofsted_registered == 'In-Process') ? ' In the process of applying for registration' : $record->ofsted_registered; ?>

											  		<?php if ($record->ofsted_registration_number && !empty($record->ofsted_registration_number)) { ?>
											  			( <?php echo $record->ofsted_registration_number; ?> )
											  		<?php } ?>
											  	</li>
											  <?php } ?>
											</ul>

											<?php if ($record->ofsted_rating && $record->ofsted_rating) { ?>
												<strong>Ofsted Rating</strong><br/>
												<ul>
												  	<li><?php echo $record->ofsted_rating; ?></li>
												</ul> 
											<?php } ?>

											<?php if ($record->childcare_voucher && $record->childcare_voucher) { ?>
												<strong>Accept Childcare Vouchers</strong><br/>
												<ul>
												  	<li><?php echo $record->childcare_voucher; ?></li>
												</ul> 
											<?php } ?>

											<?php if ($record->emergency_childcare && $record->emergency_childcare) { ?>
												<strong>Offer Emergency Childcare</strong><br/>
												<ul>
												  	<li><?php echo $record->emergency_childcare; ?></li>
												</ul> 
											<?php } ?>

											<?php if ($record->holiday_club_services && $record->holiday_club_services) { ?>
												<strong>Holiday Club services</strong><br/>
												<ul>
												  	<li><?php echo $record->holiday_club_services; ?></li>
												</ul> 
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- END POPOVERS PORTLET FOR ADDRESS-->
				    <?php } else {?>
				    	<div class="alert alert-info">No Record Found!</div>
				    <?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>