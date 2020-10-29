<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/members')?>" class="tooltips" data-original-title="Members" data-placement="top" data-container="body">Members</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View Member </li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/members'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
						<?php if(!empty($user)) {?>
							<div class="portlet portlet-sortable box green-haze">
	                            <div class="portlet-title">
	                                <div class="caption">
	                                    <span>Member Details</span>
	                                </div>
	                                <div class="tools">
	                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
	                                </div>
	                            </div>
	                            <div class="portlet-body portlet-empty"> 
	                            	<section style="margin-top: 20px; background-color: white; ">
								        <table class="table table-bordered table-condensed">
								            <tr>
								                <th>Customer Name</th>
								                <td><?php echo $user->first_name.' '.$user->last_name; ?></td>
								            </tr>
								           
								            <tr>
								                <th>Email</th>
								                <td><?php echo $user->email; ?></td>
								            </tr>
								            <tr>
								                <th>Phone Number</th>
								                <td><?php echo $user->phone_number	; ?></td>
								            </tr>
								             <tr>
								                <th>Address</th>
								                <td><?php echo $user->address.', '.$state->state.', '.$user->city; ?></td>
								            </tr>
								            <tr>
								                <th>Zip code</th>
								                <td><?php echo $user->zip_code; ?></td>
								            </tr>
								            <tr>
								                <th>Add Date</th>
								                <td><?php echo date('M d, Y h:i a', strtotime($user->add_date)); ?></td>
								            </tr>

								            <tr>
								                <th>Status</th>
								                <td>
									                <div class="btn-group">
														<?php if($user->status == 'Active') { ?>
															<button class="btn btn-xs btn-success status_label" type="button">Active</button>
														<?php } else { ?>
															<button class="btn btn-xs btn-danger status_label" type="button">Inctive</button>
														<?php } ?>
													</div>
												</td>
								            </tr>
								          </table>
								    </section>								                       
								</div>
	                        </div>	

	                        <div class="portlet portlet-sortable box green-haze">
	                            <div class="portlet-title">
	                                <div class="caption">
	                                    <span>Plan Details</span>
	                                </div>
	                                <div class="tools">
	                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
	                                </div>
	                            </div>
	                            <div class="portlet-body portlet-empty"> 
	                            	<section style="margin-top: 20px; background-color: white; ">
								        <table class="table table-bordered table-condensed">
								            <tr>
								                <th>Plan</th>
								                <td><?php echo $plan->plan; ?></td>
								            </tr>
								            <tr>
								                <th>Number of cups</th>
								                <td><?php echo $plan->number_of_food; ?></td>
								            </tr>
								            <tr>
								                <th>Price</th>
								                <td><?php echo $plan->price; ?></td>
								            </tr>
								          </table>
								    </section>								                       
								</div>
	                        </div>
	                        <div class="portlet portlet-sortable box green-haze">
	                            <div class="portlet-title">
	                                <div class="caption">
	                                    <span>Payment Details</span>
	                                </div>
	                                <div class="tools">
	                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
	                                </div>
	                            </div>
	                            <div class="portlet-body portlet-empty"> 
	                            	<section style="margin-top: 20px; background-color: white; ">
								        <table class="table table-bordered table-condensed">
								            <tr>
								                <th>Card number</th>
								                <td><?php echo $payment_info->card_number; ?></td>
								            </tr>
								           
								            <tr>
								                <th>Exp. Date</th>
								                <td><?php echo date('M/y', strtotime($payment_info->expiry_month.'/'.$payment_info->expiry_year)); ?></td>
								            </tr>
								            <tr>
								                <th>Add Date</th>
								                <td><?php echo date('M d, Y H:i a', strtotime($payment_info->created_at)); ?></td>
								            </tr>

								          </table>
								    </section>								                       
								</div>
	                        </div>

						    <?php } else {?>
						    	<div class="alert alert-info">No record found</div>
						    <?php } ?>
					</div>
			</div>
		</div>
	</div>
</div>