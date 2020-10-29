<table class="table table-striped table-bordered table-hover" id="sample_3">
	<thead>
		<tr>
			<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
    		</th>
    		<th>Full Name</th>
			<th>Username</th>
			<th>Email</th>
			<th>Status</th>
			<th>Options</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user) { ?>
			<?php  
				$delete_label = ($user->is_delete == 'Yes')? '<br/><span class="label label-sm label-danger">Delete User</span>':'<br/>';
				$admin_label = ($user->is_admin == 'Yes')? '<br/><span class="label label-sm label-info">Admin</span>':'';
				$email_label = ($user->is_email_verified == 'Yes')? '<br/><span class="label label-sm label-success">Verified</span>':'<br/><span class="label label-sm label-danger">Not Verified</span>';
			?>
			<tr>
			<td><input type="checkbox" class="checkboxes recordcheckbox" value="<?php echo $user->id; ?>"/></td>	
			<td>
				<?php echo $user->first_name .' '.$user->last_name . $delete_label;  ?>
			</td>
			<td><?php echo $user->username . $admin_label; ?></td>
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
			<td class="text-center">	

				
					<a href="<?php echo base_url('admin/members/update-permission/'.$user->id) ?>" class="btn green tooltips" data-original-title="Permissions" data-placement="top" data-container="body"><i class="fa fa-lock"></i></a>

					<a href="<?php echo base_url('admin/members/update/'.$user->id) ?>" class="btn purple tooltips" data-original-title="Click to update this record" data-placement="top" data-container="body"><i class="fa fa-pencil"></i></a>
				
				<a href="<?php echo base_url('admin/members/view/'.$user->id) ?>" class="btn yellow tooltips" data-original-title="View this record" data-placement="top" data-container="body"><i class="fa fa-eye"></i></a>

				
					<a data-toggle="modal" data-id="<?php echo $user->id; ?>" data-url="<?php echo base_url('admin/members/delete'); ?>" class="btn btn-danger tooltips" onClick="deleteRecord(this);" data-original-title="" data-placement="top" data-container="body"><i class="fa fa-remove"></i></a>
				
				
			</td>
			</tr>								
		<?php } ?>
		<?php if(!$users) { ?>
			<tr>
			<td colspan="10"><div class="no-record">No record found</div></td>
			</tr>

		<?php } ?>
							
	</tbody>
</table>
<div class="row">
	<div class="col-md-5 col-sm-12"></div>
	<div class="col-md-7 col-sm-12">
		<div class="pull-right">
			<?php echo $paging; ?>
		</div>						
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$("input:checkbox").uniform();
	})
</script>