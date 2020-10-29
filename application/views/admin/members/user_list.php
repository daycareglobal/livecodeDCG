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

            
            "lengthMenu": [
                [5, 15, 20, 100, -1],
                [5, 15, 20, 100, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 100,            
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
                [1, "desc"]
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
				<div class="caption"><i class="icon-users"></i>List of members</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div id="alert_area"></div>
					<div class="row">
						<div class="col-md-12">	
							
							<!-- <div class="btn-group tooltips" data-original-title="Add new member">
									<a href="<?php echo base_url('admin/members/add'); ?>" class="btn green add_link">ADD NEW<i class="fa fa-plus"></i></a>
							</div> -->
							
							<div onClick="checkForNullChecked('Active',this)" data-taskurl="<?php echo base_url('admin/members/multiTaskOperation'); ?>" class="btn green tooltips" data-original-title="Active selected record">ACTIVE<i class="fa fa-check"></i></i>
							 </div>
							 <div style="margin-left:10px;" onClick="checkForNullChecked('Inactive',this)" data-taskurl="<?php echo base_url('admin/members/multiTaskOperation'); ?>" class="btn purple tooltips" data-original-title="Inactive selected record">INACTIVE<i class="fa fa-ban"></i></div>
							
							 
						</div>						
					</div>
				</div>
				<div class="">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
						<thead>
							<tr>
								<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
					    		</th>
					    		<th>Full Name</th>
								<th>Email</th>
								<th>Status</th>
								<th>Add Date</th>
								<th>Options</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $user) { 

								$delete_label = ($user->is_delete == 'Yes')? '<br/><span class="label label-sm label-danger">Delete User</span>':'<br/>';
								$admin_label = ($user->is_admin == 'Yes')? '<br/><span class="label label-sm label-info">Admin</span>':'';
								$email_label = ($user->is_email_verified == 'Yes')? '<br/><span class="label label-sm label-success">Verified</span>':'<br/><span class="label label-sm label-danger">Not Verified</span>';
							?>
								<tr>
									<td><input type="checkbox" class="checkboxes recordcheckbox" value="<?php echo $user->id; ?>"/></td>	
									<td>
										<?php echo $user->first_name .' '. $user->last_name . $delete_label;  ?>
									</td>
									
									<td><?php echo $user->email . $email_label; ?></td>
														
									<td>
										<div class="btn-group">
										<?php if($user->status == 'Active') { ?>
											<button class="btn btn-xs btn-success status_label" type="button">Active</button>
										<?php } else { ?>
											<button class="btn btn-xs btn-danger status_label" type="button">Inactive</button>
										<?php } ?>
											<button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" type="button"><i class="fa fa-angle-down"></i></button>
											<ul class="dropdown-menu" role="menu" style="margin-top:-50px">
												<li><a data-id="<?php echo $user->id; ?>" data-url="<?php echo site_url('admin/members/changeStatus'); ?>" data-status="Active" onClick="changeStatusCommon(this)">Active</a></li>
												<li><a data-id="<?php echo $user->id; ?>" data-url="<?php echo site_url('admin/members/changeStatus'); ?>" data-status="Inactive" onClick="changeStatusCommon(this)">Inactive</a></li>
											</ul>
										
										</div>
									</td>
									<td><?php echo date('M d, Y H:m A', strtotime($user->add_date)); ?></td>
									<td class="text-center">	
										<a href="<?php echo base_url('admin/members/update/'.$user->id) ?>" class="btn purple tooltips" data-original-title="Update this record" data-placement="top" data-container="body"><i class="fa fa-pencil"></i></a>
										
										<a href="<?php echo base_url('admin/members/view/'.$user->id) ?>" class="btn yellow tooltips" data-original-title="View this record" data-placement="top" data-container="body"><i class="fa fa-eye"></i></a>
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