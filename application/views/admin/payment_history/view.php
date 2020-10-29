<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/payment_history')?>" class="tooltips" data-original-title="Users List" data-placement="top" data-container="body">Payment history list</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View User Detail </li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/payment_history'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
					<?php if (!empty($record)) { ?>
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
							                <th>Name</th>
							                <td><?php echo $record->name.' '.$record->last_name; ?></td>
							            </tr>

							            <tr>
							                <th>Plan name</th>
							                <td><?php echo $record->plan_name; ?></td>
							            </tr>

							            <tr>
							                <th>plan type</th>
							                <td><?php echo $record->plan_type; ?>
								                <div class="btn-group">
													<?php if($record->membership_plan_type == 'Paid') { ?>
														<button class="btn btn-xs btn-success status_label" type="button">Paid</button>
													<?php } else { ?>
														<button class="btn btn-xs btn-info status_label" type="button">Free</button>
													<?php } ?>
													
												</div>
							                </td>
							            </tr>

							            <tr>
							                <th>Amount</th>
							                <td>
							                	<?php
												if ($record->amount) {
											 	  echo '£'.$record->amount; 
												
												} else {
												  echo '£0'; 
												}
												?>
							                </td>
							            </tr>

							            <?php if($record->membership_plan_type == 'Paid') { ?>

							            <tr>
							                <th>Company</th>
							                <td><?php echo $record->company; ?></td>
							            </tr>
							            
							            <tr>
							                <th>Card holder name</th>
							                <td><?php echo $record->card_holder_name; ?></td>
							            </tr>

							            <tr>
							                <th>Country</th>
							                <td><?php echo $record->country; ?></td>
							            </tr>

							            <tr>
							                <th>Postal code</th>
							                <td><?php echo $record->postal_code; ?></td>
							            </tr>

							            <tr>
							                <th>Card type</th>
							                <td><?php echo $record->card_type; ?></td>
							            </tr>

							            <tr>
							                <th>Card number</th>
							                <td><?php echo $record->card_number; ?></td>
							            </tr>

							            <tr>
							                <th>Expiry month year</th>
							                <td><?php echo $record->expiry_month_year; ?></td>
							            </tr>

							           <?php } ?>

							            <tr>
							                <th>Add Date</th>
							                <td><?php echo date('M d, Y h:i A', strtotime($record->add_date)); ?></td>
							            </tr>
							        </table>
							    </section>								                       
							</div>
                        </div>						 
				    <?php } else {?>
				    	<div class="alert alert-info">No Record Found!</div>
				    <?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>