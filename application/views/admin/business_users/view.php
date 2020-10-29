<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/business_users')?>" class="tooltips" data-original-title="Business User List" data-placement="top" data-container="body">Business User List</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View User Detail </li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/business_users'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
                                    <span>User Details</span>
                                </div>
                                <div class="tools">
                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body portlet-empty"> 
                            	<section style="margin-top: 20px; background-color: white; ">
							        <table class="table table-bordered table-condensed">
							            
							            <tr>
							                <th>First Name</th>
							                <td><?php echo $record->name; ?></td>
							            </tr>

							            <tr>
							                <th>Username</th>
							                <td><?php echo $record->username; ?></td>
							            </tr>

							            <tr>
							                <th>E-mail Address</th>
							                <td><?php echo $record->email; ?></td>
							            </tr>

							          <!--   <tr>
							                <th>Contact Number</th>
							                <td><?php echo $record->contact_number; ?></td>
							            </tr>
 -->
							            <tr>
							                <th>Study In</th>
							                <td><?php echo $record->study_type; ?></td>
							            </tr>

							            <tr>
							                <th>School/University Name</th>
							                <td><?php echo $record->education_name; ?></td>
							            </tr>

							            <tr>
							                <th>Year</th>
							                <td><?php echo $record->year; ?></td>
							            </tr>

							            <tr>
							                <th>Hourly Rate</th>
							                <td><?php echo $record->hourly_rate; ?></td>
							            </tr>

							            <!-- <tr>
							                <th>PayPal Detail</th>
							                <td><?php echo $record->paypal_email; ?></td>
							            </tr> -->

							            <tr>
							                <th>Profile Image</th>
							                <td>
												<?php if ($record->profile_image) { ?>
													<img src="<?php if(isset($record)){ echo site_url('assets/uploads/profile_image/'.$record->profile_image); } ?>" height="80" width="100" alt="No User Image" />

												<?php } else{ ?>
													<img id="preview_image"  src="<?php echo site_url('assets/uploads/'.'no_image.jpg'); ?>" height="80" width="100" alt="No User Image" />
												<?php } ?>
											</td>
							            </tr>

							            <tr>
							                <th>Add Date</th>
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
									<i class="fa fa-book"></i>Subject Detail
								</div>
								<div class="tools">
									<a href="javascript:;" class="collapse">
									</a>
									
								</div>
							</div>
							<div class="portlet-body">

								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr>
								    		<th>Subject Name</th>
								    		<th>Grade</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($record->subject_detail as $subjec) { ?>
											<tr>
												<td><?php echo ucfirst($subjec->name); ?></td>
												<td><?php echo $subjec->grade ? $subjec->grade : '---'; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>
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