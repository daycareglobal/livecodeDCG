<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>			
			<a href="<?php echo site_url('admin/country')?>" class="tooltips" data-original-title="Country Management" data-placement="top" data-container="body">Country Management</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>View Country Details</li>	
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/country'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
						<?php if(!empty($country)) {?>
							<div class="portlet portlet-sortable box green-haze">
	                            <div class="portlet-title">
	                                <div class="caption">
	                                    <span>Country Details</span>
	                                </div>
	                                <div class="tools">
	                                    <a class="collapse" href="javascript:;" data-original-title="" title=""> </a>
	                                </div>
	                            </div>
	                            <div class="portlet-body portlet-empty"> 
	                            	 <section style="margin-top: 20px; background-color: white; ">
								        <table class="table table-bordered table-condensed">
											
											
								            <tr>
								                <th>Country Name</th>
								                <td><?php echo $country->name; ?></td>
								            </tr>

								            <tr>
								                <th>Country Sort Name</th>
								                <td><?php echo $country->sortname; ?></td>
								            </tr>

								            <tr>
								                <th>Country Phone Code</th>
								                <td><?php echo $country->phonecode; ?></td>
								            </tr>
								            
								            <!-- <tr>
								                <th>Add Date</th>
								                <td><?php echo date('F d, Y', strtotime($country->add_date)); ?></td>
								            </tr> -->
								            <tr>
								                <th>Status</th>
								                <td>
								                	<div class="btn-group">
														<?php if($country->status == 'Active') { ?>
															<button class="btn btn-xs btn-success status_label" type="button">Active</button>
														<?php } else { ?>
															<button class="btn btn-xs btn-danger status_label" type="button">Inactive</button>
														<?php } ?>
													</div>
								                </td>
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