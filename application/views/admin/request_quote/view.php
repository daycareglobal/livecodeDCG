<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/request_quote')?>" class="tooltips" data-original-title="Request quote list" data-placement="top" data-container="body">Request quote list</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View User Detail </li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/request_quote'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
                                    <span>Request Quote Details</span>
                                </div>
                                <div class="tools">
                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body portlet-empty"> 
                            	<section style="margin-top: 20px; background-color: white; ">
							        <table class="table table-bordered table-condensed">
							            
							            <tr>
							                <th>Child Name</th>
							                <td><?php echo $record->child_first_name.' '.$record->child_last_name; ?></td>
							            </tr>

							            <tr>
							                <th>Customer Name</th>
							                <td><?php echo $record->first_name.' '.$record->last_name; ?></td>
							            </tr>

							            <tr>
							                <th>Customer Email</th>
							                <td><?php echo $record->email_address; ?></td>
							            </tr>

							            <tr>
							                <th>Child date of birth</th>
							                <td><?php echo $record->child_date_of_birth; ?></td>
							            </tr>

							            <tr>
							                <th>Funded hours 15</th>
							                <td><?php echo $record->funded_hours_15; ?></td>
							            </tr>

							            <tr>
							                <th>Funded hours 30</th>
							                <td><?php echo $record->funded_hours_30; ?></td>
							            </tr>

							            <tr>
							                <th>Fees type</th>
							                <td><?php echo $record->fees_type; ?></td>
							            </tr>

							            <tr>
							                <th>Age group</th>
							                <td>
							                	<?php 
							                	if ($record->age_group == '0_2') {
							                	    echo '0 to 2 year'; 
							                	
							                	} else if ($record->age_group == '2_3')	{
							                		echo '2 to 3 year'; 
							                	
							                	} else if ($record->age_group == '15_3_5') {
							                		echo '3 to 5 year'; 
							                	
							                	} else if ($record->age_group == '30_3_5') {
							                		echo '3 to 5 year'; 
							                	} else if ($record->age_group == 'above_5') {
							                		echo 'above 5 year'; 
							                	}

							                	?>
							                </td>
							            </tr>

							            <tr>
							                <th>Miles</th>
							                <td><?php echo $record->miles; ?></td>
							            </tr>

							            <tr>
							                <th>Post code 1</th>
							                <td><?php echo $record->post_code_1; ?></td>
							            </tr>

							            <tr>
							                <th>Post code 2</th>
							                <td><?php echo $record->post_code_2; ?></td>
							            </tr>

							            <tr>
							                <th>Post code 2</th>
							                <td><?php echo $record->post_code_2; ?></td>
							            </tr>

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