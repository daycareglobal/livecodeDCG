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
                [2, "desc"]
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
				<div class="caption"><i class="fa fa-graduation-cap"></i>List of session request</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div id="alert_area"></div>
				</div>
				<div class="">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
						<thead>
							<tr>
					    		<th>User Name</th>
					    		<th>Business Name</th>
					    		<th>Session Name</th>
								<th>Add Date</th>
								<th>Options</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($session_request as $key => $value) { ?>
								<tr>
									<td><?php echo $value->name.' '.$value->last_name; ?></td>
									<td><?php echo $value->trading_name; ?></td>
									<td><?php echo $value->own_session; ?></td>
									<td><?php echo date('M d, Y h:i A', strtotime($value->add_date)); ?></td>
									<td class="text-center">	
										<a href="javascript:void(0)" data-name="<?php echo $value->own_session; ?>" data-id="<?php echo $value->id; ?>" data-url="<?php echo base_url('admin/session_type/add_requested_session'); ?>" onClick="sessionRequest(this);" class="btn purple tooltips" data-original-title="Approve this session" data-placement="top" data-container="body"><i class="fa fa-book"></i></a>
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

<div class="modal fade bs-modal-sm" id="SessionRequestModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form role="form" method="post" action="" class="ajax_form" id="sessionForm">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<center><h4 class="modal-title">Approve</h4></center>
				</div>
				
				<div class="modal-body">
					<input type="hidden" class="form-control" name="record_id" value="" id="record_id">
					<div class="form-group form-md-line-input">
						<div class="col-md-12">
							<?php echo form_input(array('placeholder' => 'Enter Session name', 'id' => "session_name", 'name' => "session_name", 'class' => "form-control",'readonly' => "")); ?>
							<div class="form-control-focus"> </div>
						</div>
					</div>

					<div class="form-group form-md-line-input">
						<label for="form_control_title" class="control-label col-md-3">Fees Type</label>
						<div class="col-md-9">					
	                        <input id="is_funded" type="checkbox" name="is_funded">
	                        <label for="is_funded">
	                            Funded
	                        </label>
		                   
	                        <input id="is_non_funded" type="checkbox" name="is_non_funded">
	                        <label for="is_non_funded">
	                           Non Funded
	                        </label>
							<div class="form-control-focus"> </div>			
						</div>
					</div>

					<div class="form-group form-md-line-input">
						<label for="form_control_title" class="control-label col-md-3">Age Group</label>
						<div class="col-md-9">					
							
	                        <input id="age_group_0_2" type="checkbox" name="age_group_0_2">
	                        <label for="age_group_0_2">
	                            0-2
	                        </label>

	                        <input id="age_group_2_3" type="checkbox" name="age_group_2_3">
	                        <label for="age_group_2_3">
	                            2-3 for 15 hours
	                        </label>

	                        <input id="age_group_15_3_5" type="checkbox" name="age_group_15_3_5">
	                        <label for="age_group_15_3_5">
	                            3-5 for 15 hours
	                        </label>

	                        <input id="age_group_30_3_5" type="checkbox" name="age_group_30_3_5">
	                        <label for="age_group_30_3_5">
	                            3-5 for 30 hours
	                        </label>

	                        <input id="is_age_above_5" type="checkbox" name="is_age_above_5">
	                        <label for="is_age_above_5">
	                         Above 5
	                        </label>
		                 
							<div class="form-control-focus"> </div>			
						</div>
					</div>
					<br>
					<div class="form-group form-md-line-input">
						<label for="form_control_title" class="control-label col-md-3">Non-Funded Week Type</label>
						<div class="col-md-9">					
							
	                        <input id="is_week_38_non_funded" type="checkbox" name="is_week_38_non_funded">
	                        <label for="is_week_38_non_funded">
	                            38
	                        </label>
		                   
	                        <input id="is_week_52_non_funded" type="checkbox" name="is_week_52_non_funded">
	                        <label for="is_week_52_non_funded">
	                           52
	                        </label>
		                  
							<div class="form-control-focus"> </div>			
						</div>
					</div>

					<div class="form-group form-md-line-input">
						<label for="form_control_title" class="control-label col-md-3">Funded Week Type</label>
						<div class="col-md-9">					
							
	                        <input id="is_week_38_funded" type="checkbox" name="is_week_38_funded">
	                        <label for="is_week_38_funded">
	                            38
	                        </label>
		                   
	                        <input id="is_week_52_funded" type="checkbox" name="is_week_52_funded">
	                        <label for="is_week_52_funded">
	                           52
	                        </label>
							<div class="form-control-focus"> </div>			
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn red">Approve</button>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
function sessionRequest($this) {
	$('#SessionRequestModal').modal('show');
	$('#record_id').val($($this).data('id'));
	$('#session_name').val($($this).data('name'));
	$('#sessionForm').attr('action', $($this).data('url'));
}
</script>
