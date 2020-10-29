<?php
	if ($this->session->flashdata('message')) {
		echo '<div class="alert alert-success">' . $this->session->flashdata('message') . '</div>';
	}
?>
<script>
function searchRecords()
{
	var keyword = $('#keyword').val();
	var page_limit = $('#page_limit').val();	
	var surl = siteurl+'admin/state/ajaxList?keyword='+keyword+'&page_limit='+page_limit;
	getAjaxSearchData(surl);
}

function getAjaxSearchData(surl)
{
	$('body').addClass('showloader');
    $.getJSON(surl,function(data){
    	$('body').removeClass('showloader');
      if(data.success)
      {
         $('#ajax_list').html(data.html);
         $(".content_list .paging_div").html(data.paging);
      }
    })
}

$(document).ready(function(){
    searchRecords();
    $(document).on('click','.content_list .pagination a',function(e){
        e.preventDefault();
        if($(this).attr('href'))
        {
          getAjaxSearchData($(this).attr('href'));
        }
        return false;
    })
    $('#keyword').keydown(function(event) {
	    // enter has keyCode = 13, change it if you want to use another button
	    if (event.keyCode == 13) {
	      // event.preventDefault();
	      searchRecords();
	    }
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
				<div class="caption"><i class="fa fa-bars" aria-hidden="true"></i>List of States</div>
			</div>
			<div class="portlet-body">
				<div class="table-toolbar">
					<div id="alert_area"></div>
					<div class="row">
						<div class="col-md-12">	
							
							<div class="btn-group tooltips" data-original-title="ADD NEW">
									<a href="<?php echo base_url('admin/state/add'); ?>" class="btn green add_link">ADD NEW<i class="fa fa-plus"></i></a>
							</div>
							
							<div  onClick="checkForNullChecked('Active',this)" data-taskurl="<?php echo base_url('admin/state/multiTaskOperation'); ?>" class="btn green tooltips" data-original-title="ACTIVE">ACTIVE<i class="fa fa-check"></i></i>
							 </div>
							 <div style="margin-left:10px;" onClick="checkForNullChecked('Inactive',this)" data-taskurl="<?php echo base_url('admin/state/multiTaskOperation'); ?>" class="btn purple tooltips" data-original-title="INACTIVE">INACTIVE<i class="fa fa-ban"></i></div>
							
							
							 <div style="margin-left:10px;" onClick="checkForNullChecked('Delete',this)" data-taskurl="<?php echo base_url('admin/state/multiTaskOperation'); ?>" class="btn red tooltips" data-original-title="DELETE">DELETE<i class="fa fa-minus-circle"></i></div>
							 
							 
						</div>						
					</div>
				</div>
				<div class="col-md-1 col-sm-12" style="padding-left: 0px;">
					<div class="form-group">
						<select name="page_limit" class="form-control input-xsmall input-inline" id="page_limit" onchange="searchRecords(this)">	
							<option value="5">5</option>
							<option value="10" selected>10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>			
							<option value="200">200</option>		
							<option value="">All</option>			
						</select>
					</div>
				</div>

				<div class="col-md-4 col-sm-12 pull-right">
					<div class="col-md-9" style="padding-right: 0;">
						<input class="form-control" placeholder="Search By Keyword ..." type="text" id="keyword" name="keyword" value="" >
					</div>
					<div class="col-md-3">
						<button class="btn green" onclick="searchRecords()">Search</button>															
					</div>
				</div>

				<div class="content_list">
					<table class="table table-striped table-bordered table-hover" id="sample_3">
						<thead>
							<tr>
								<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
					    		</th>
					    		<th>State Name</th>								
								<th>Status</th>
								<!-- <th>Add Date</th> -->
								<th>Options</th>
							</tr>
						</thead>
						<tbody id="ajax_list">
							
						</tbody>
					</table>
					<div class="paging_div paging_div-not-space">
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.paging_div-not-space{text-align: right;}
	.paging_div-not-space ul{margin:0;}
</style>