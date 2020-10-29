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
                "zeroRecords": "No matching records found"
            },
            
            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "columns": [{
                "orderable": true
            }, {
                "orderable": true
            },{
                "orderable": false
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
                'orderable': false,
                'targets': [0]
            }, {
                "searchable": false,
                "targets": [0]
            }],
            "order": [
                [0, "asc"]
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
				<div class="caption"><i class="icon-envelope-letter icons"></i>List of Static Content</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div id="alert_area"></div>
					<div class="row">
						<div class="col-md-12">
							 					
						</div>						
					</div>
				</div>
				<div class="">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
						<thead>
							<tr>
								<!-- <th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
					    		</th> -->
								<th>Page Name</th>	
								<th>Description</th>
								<th>Options</th>
							</tr>
						</thead>
						<tbody>
							<?php if( !isset($records) ) { $records = array(); } ?>
							<?php foreach ($records as $key => $value) { ?>
								<tr class="odd gradeX" id="row_<?php echo $value->id; ?>">
									<!-- <td>
										<input type="checkbox" class="case" name="chk[]" value="<?php echo $value->id; ?>" />
									</td> -->
									<td><?php echo ucfirst($value->page_name); ?></td>
									<td><?php echo strlen($value->description) > 100 ? substr(strip_tags($value->description), 0, 100)."..." : strip_tags($value->description); ?></td>
									<td>
										<a class="btn tooltips green" data-original-title="Edit Record" href="<?php echo site_url('admin/content/edit/'.$value->id); ?>" data-placement="top" data-container="body"><i class="icon-pencil"></i></a>
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