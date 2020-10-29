<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/service_category')?>" class="tooltips" data-original-title="Service category list" data-placement="top" data-container="body">Service category list</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View service category </li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/service_category'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
					<?php if (!empty($service_category)) { ?>
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
							                <th>Name</th>
							                <td><?php echo $service_category->name; ?></td>
							            </tr>

							            <tr>
							                <th>Funded</th>
							                <td><?php echo $service_category->is_funded; ?></td>
							            </tr>

							            <tr>
							                <th>Non Funded</th>
							                <td><?php echo $service_category->is_non_funded; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 0-2</th>
							                <td><?php echo $service_category->age_group_0_2; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 2-3</th>
							                <td><?php echo $service_category->age_group_2_3 ; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 3-5 for 15 hours</th>
							                <td><?php echo $service_category->age_group_15_3_5 ; ?></td>
							            </tr>

							            <tr>
							                <th>Age Group 3-5 for 30 hours</th>
							                <td><?php echo $service_category->age_group_30_3_5 ; ?></td>
							            </tr>

							            <tr>
							                <th>Above 5</th>
							                <td><?php echo $service_category->is_age_above_5 ; ?></td>
							            </tr>

							            <tr>
							                <th>Add Date</th>
							                <td><?php echo date('M d, Y h:i A', strtotime($service_category->add_date)); ?></td>
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