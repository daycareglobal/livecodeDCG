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
                "zeroRecords": "No matching records found"
            },
            
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columns": [{
                "orderable": true
            },{
                "orderable": true
            },{
                "orderable": true
            }, {
                "orderable": true
            }],
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
                /*'orderable': false,
                'targets': [0]*/
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [3, "desc"]
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
				<div class="caption"><i class="icon-envelope-letter icons"></i>List of Email Templates</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div id="alert_area"></div>
					<div class="row">
						<div class="col-md-12">

							<div class="btn-group tooltips" data-original-title="ADD NEW">
								<a href="<?php echo base_url('admin/send_email/email_notification'); ?>" class="btn green add_link">ADD NEW<i class="fa fa-plus"></i></a>
							</div>

						</div>
					</div>
				</div>
				<div class="">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
						<thead>
							<tr>
								<th>User Name</th>
								<th>User Email</th>	
								<th>Template Subject</th>
								<th>Send Date</th>
							</tr>
						</thead>
						<tbody>

							<?php foreach ($records as $key => $value) { ?>
								<tr>
									<td><?php echo $value->name; ?></td>
									<td><?php echo $value->email; ?></td>			
									<td><?php echo $value->subject; ?></td>
									<td><?php echo date('M d, Y h:i A', strtotime($value->add_date)); ?></td>
								</tr>
							<?php } ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>