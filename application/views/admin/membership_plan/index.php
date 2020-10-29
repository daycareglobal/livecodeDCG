<?php
	if ($this->session->flashdata('message')) {
		echo '<div class="alert alert-success">' . $this->session->flashdata('message') . '</div>';
	}
?>
<script type="text/javascript">
$(function(){
	var table = $('#sample_3');

        // begin first table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing1 _START_ to _END_ of _TOTAL_ entries1",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found."
            },
            
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
            
            "columns": [{
                "orderable": false
            }, {
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": false
            }],
            
            
            "lengthMenu": [
                [5, 15, 20, 100, -1],
                [5, 15, 20, 100, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,            
            "pagingType": "bootstrap_full_number",
            "language": {
                "search": "Search Anything: ",
                "lengthMenu": "  _MENU_ records",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },
            "columnDefs": [{  // set default column settings
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [7, "desc"]
            ] // set first column as a default sort by asc
        });
	});
</script>
<div class="row">
	<div class="col-md-12">
		<div class="box grey-cascade">
			<div class="portlet-body">
			</div>
		</div>
		<div class="portlet box grey-cascade">
			<div class="portlet-title">
				<div class="caption"><i class="fa fa-credit-card"></i>List Of Membership Plan</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div id="alert_area"></div>
					<div class="row">
						<div class="col-md-12">	

							<div class="btn-group tooltips" data-original-title="ADD NEW">
								<a href="<?php echo base_url('admin/membership_plan/add'); ?>" class="btn green add_link">ADD NEW<i class="fa fa-plus"></i></a>
							</div>
							
							<div style="margin-left:10px;" onClick="checkForNullChecked('Active',this)" data-taskurl="<?php echo base_url('admin/membership_plan/multiTaskOperation'); ?>" class="btn green tooltips" data-original-title="Activate selected record">ACTIVATE<i class="fa fa-check"></i></i>
							 </div>
							<div style="margin-left:10px;" onClick="checkForNullChecked('Inactive',this)" data-taskurl="<?php echo base_url('admin/membership_plan/multiTaskOperation'); ?>" class="btn purple tooltips" data-original-title="Deactivate selected record">DEACTIVATE<i class="fa fa-ban"></i></div>
							  
							<!--  <div style="margin-left:10px;" onClick="checkForNullChecked('Delete',this)" data-taskurl="<?php echo base_url('admin/membership_plan/multiTaskOperation'); ?>" class="btn red tooltips" data-original-title="Delete selected record">Delete<i class="fa fa-minus-circle"></i>
							</div>  -->
						</div>
					</div>
				</div>
				<div class="">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
						<thead>
							<tr>
								<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
					    		</th>
					    		<th>Plan Name</th>
					    		<th>Provisions Allowed</th>
					    		<th>Free Month</th>
					    		<th>Price</th>
					    		<th>Annual Discount</th>
					    		<th>Status</th>
								<th>Add Date</th>
								<th>Options</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($records as $record) { ?>
								<tr>
									<td><input type="checkbox" class="checkboxes recordcheckbox" value="<?php echo $record->id; ?>"/></td>
									<td><?php echo ucfirst($record->plan_name); ?></td>
									<td><?php echo $record->provision_allowed; ?></td>
									<td><?php echo ($record->plan_type == 'Free') ? $record->month : '<span class="label label-warning">Paid</span>'; ?></td>
									<td><?php echo ($record->plan_type == 'Paid') ? $record->price. '&#163;' : '<span class="label label-warning">Free</span>'; ?></td>
									<td><?php echo ($record->plan_type == 'Paid') ? $record->annual_discount.'%' : '<span class="label label-warning">Free</span>'; ?></td>
									<td>
										<div class="btn-group">
										<?php if($record->status == 'Active') { ?>
											<button class="btn btn-xs btn-success status_label" type="button">Activate</button>
										<?php } else { ?>
											<button class="btn btn-xs btn-danger status_label" type="button">Deactivate</button>
										<?php } ?>
											<button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" type="button"><i class="fa fa-angle-down"></i></button>
											<ul class="dropdown-menu" role="menu" style="margin-top:-50px">
												<li><a data-id="<?php echo $record->id; ?>" data-url="<?php echo site_url('admin/membership_plan/changeStatus'); ?>" data-status="Active" onClick="changeStatusCommon(this)">Activate</a></li>
												<li><a data-id="<?php echo $record->id; ?>" data-url="<?php echo site_url('admin/membership_plan/changeStatus'); ?>" data-status="Inactive" onClick="changeStatusCommon(this)">Deactivate</a></li>
											</ul>
										
										</div>
									</td>
									<td><?php echo date('M d, Y h:i A', strtotime($record->add_date)); ?></td>
									<td class="text-center">	
										<a href="<?php echo base_url('admin/membership_plan/update/'.$record->id) ?>" class="btn purple tooltips" data-original-title="Update this record" data-placement="top" data-container="body"><i class="fa fa-pencil"></i></a>
										
										<!-- <a href="<?php echo base_url('admin/membership_plan/view/'.$record->id) ?>" class="btn yellow tooltips" data-original-title="View this record" data-placement="top" data-container="body"><i class="fa fa-eye"></i></a> -->
										
										<!-- <a data-toggle="modal" data-id="<?php echo $record->id; ?>" data-url="<?php echo base_url('admin/membership_plan/delete'); ?>" class="btn btn-danger tooltips" onClick="deleteRecord(this);" data-original-title="Delete this record" data-placement="top" data-container="body"><i class="fa fa-remove"></i> -->
										</a> 
									</td>
								</tr>								
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>