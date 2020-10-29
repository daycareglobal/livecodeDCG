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
                "orderable": true
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
				<div class="caption"><i class="fa fa-briefcase"></i>List of fees availiability</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div id="alert_area"></div>
				</div>
				<div class="">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
						<thead>
							<tr>
								
					    		<th>User name</th>
					    		<th>Trading Name</th>
					    		<th>Service</th>
								<th>Add Date</th>
								<th>Options</th>
							</tr>
						</thead>
						
						<tbody>
							<?php foreach ($fees_availiability as $key => $value) { ?>
								<tr>
									<td><?php echo $value->name.' '.$value->last_name; ?></td>
									<td><?php echo $value->trading_name; ?></td>
									<td><?php echo $value->service_name; ?></td>
									<td><?php echo date('M d, Y h:i A', strtotime($value->add_date)); ?></td>
									<td class="text-center">	
                                        <a href="<?php echo base_url('admin/fees_availiability/trading_timing/'.$value->id) ?>" class="btn yellow tooltips" data-original-title="Trading Timing" data-placement="top" data-container="body"><i class="fa fa-clock-o"></i></a> 

                                        <a href="<?php echo base_url('admin/fees_availiability/base_room_groups/'.$value->id) ?>" class="btn yellow tooltips" data-original-title="View this record" data-placement="top" data-container="body"><i class="fa fa-home"></i></a> 

                                        <a href="<?php echo base_url('admin/fees_availiability/non_funded_children/'.$value->id) ?>" class="btn yellow tooltips" data-original-title="View this record" data-placement="top" data-container="body"><i class="fa fa-child"></i></a> 


                                      <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Funded
                                        <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a data-id="<?php echo $value->id; ?>" data-type="15-2-3" onclick="getFundedChildren(this)">15 hours 2-3 years old</a></li>
                                            <li><a data-id="<?php echo $value->id; ?>" data-type="15-3-5" onclick="getFundedChildren(this)">15 hours 3-5 years old</a></li>
                                            <li><a data-id="<?php echo $value->id; ?>" data-type="30-3-5" onclick="getFundedChildren(this)">30 hours 3-5 years old</a></li>
                                        </ul>
                                      </div>
                                     
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
<script type="text/javascript">
  function getFundedChildren($this) {
    var business_id = $($this).attr('data-id');
    var funded_type = $($this).attr('data-type');

    if (business_id && funded_type) {
        window.location.href = site_url+"admin/fees_availiability/funded_children?bid="+business_id+"&funded_type="+funded_type;
    }
  }
</script>