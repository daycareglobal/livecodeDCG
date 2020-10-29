<?php if($records) {?>
<?php foreach ($records as $value) { ?>
	<tr>
	<td><input type="checkbox" class="checkboxes recordcheckbox" value="<?php echo $value->id; ?>"/>
	</td>	
	<td><?php echo $value->name;  ?></td>
	<td>
		<div class="btn-group">
		<?php if($value->status == 'Active') { ?>
			<button class="btn btn-xs btn-success status_label" type="button">Active</button>
		<?php } else { ?>
			<button class="btn btn-xs btn-danger status_label" type="button">Inactive</button>
		<?php } ?>
		
			<button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" type="button"><i class="fa fa-angle-down"></i></button>
			<ul class="dropdown-menu" role="menu" style="margin-top:-50px">
				<li><a data-id="<?php echo $value->id; ?>" data-url="<?php echo site_url('admin/city/changeStatus'); ?>" data-status="Active" onClick="changeStatusCommon(this)">Active</a></li>
				<li><a data-id="<?php echo $value->id; ?>" data-url="<?php echo site_url('admin/city/changeStatus'); ?>" data-status="Inactive" onClick="changeStatusCommon(this)">Inactive</a></li>
			</ul>
		</div>
	</td>
	<td class="text-center">		
		<a href="<?php echo base_url('admin/city/update/'.$value->id) ?>" class="btn purple tooltips"  data-original-title="Update this record" data-placement="top" data-container="body"><i class="fa fa-pencil"></i>
		</a>

		<a data-toggle="modal" data-id="<?php echo $value->id; ?>" data-url="<?php echo base_url('admin/city/delete'); ?>" class="btn btn-danger tooltips"  onClick="deleteRecord(this);" data-original-title="Delete this record" data-placement="top" data-container="body"><i class="fa fa-remove"></i>
		</a>
	</td>
	</tr>								
<?php } ?>
<?php } else { ?>	
	<tr>
	<td colspan="8" style="text-align: center;">No Record found</td>
	</tr>
<?php } ?>

<script type="text/javascript">
	$(function(){
		$("input:checkbox").uniform();
	})
</script>				