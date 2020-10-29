<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/session_type')?>" class="tooltips" data-original-title="Session type list" data-placement="top" data-container="body">Session type list</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View session type </li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/session_type'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
					<?php if (!empty($session_type)) { ?>
						<div class="portlet portlet-sortable box green-haze">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span>Session Type Details</span>
                                </div>
                                <div class="tools">
                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
                                </div>
                            </div>
                            <div class="portlet-body portlet-empty"> 
                            	<section style="margin-top: 20px; background-color: white; ">
							        <table class="table table-bordered table-condensed">
							            <tr>
							                <th>Session Name</th>
							                <td><?php echo $session_type->session_name; ?></td>
							            </tr>

							            <tr>
							                <th>Funded</th>
							                <td><?php echo $session_type->is_funded; ?></td>
							            </tr>

							            <tr>
							                <th>Non Funded</th>
							                <td><?php echo $session_type->is_non_funded; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 0-2</th>
							                <td><?php echo $session_type->age_group_0_2; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 2-3</th>
							                <td><?php echo $session_type->age_group_2_3 ; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 3-5 for 15 hours</th>
							                <td><?php echo $session_type->age_group_15_3_5 ; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 3-5 for 30 hours</th>
							                <td><?php echo $session_type->age_group_30_3_5 ; ?></td>
							            </tr>

							            <tr>
							                <th>Above 5</th>
							                <td><?php echo $session_type->is_age_above_5 ; ?></td>
							            </tr>

							            <tr>
							                <th>Non-Funded Week 38</th>
							                <td><?php echo $session_type->is_week_38_non_funded ; ?></td>
							            </tr>

							            <tr>
							                <th>Non-Funded Week 52</th>
							                <td><?php echo $session_type->is_week_52_non_funded ; ?></td>
							            </tr>

							            <tr>
							                <th>Funded Week 38</th>
							                <td><?php echo $session_type->is_week_38_funded ; ?></td>
							            </tr>

							            <tr>
							                <th>Funded Week 52</th>
							                <td><?php echo $session_type->is_week_52_funded ; ?></td>
							            </tr>

							            <tr>
							                <th>Add Date</th>
							                <td><?php echo date('M d, Y h:i A', strtotime($session_type->add_date)); ?></td>
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