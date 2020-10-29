
<table class="table table-striped table-bordered table-hover" id="sample_3">
	<thead>
		<tr>
			<th class="table-checkbox"> <input type="checkbox" class="group-checkable" data-set="#sample_3 .checkboxes"/>
    		</th>
			<th><?php echo $this->lang->line('Name'); ?></th>
			<th><?php echo $this->lang->line('Subject'); ?></th>	
			<th><?php echo $this->lang->line("Status"); ?></th>
			<th><?php echo $this->lang->line("Options"); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($templates as $key => $value) { ?>
			<tr>
			<td><input type="checkbox" class="checkboxes recordcheckbox" value="<?php echo $value->id; ?>"/></td>
			<td>
				<?php echo showLimitedText($value->name,50); ?>
			</td>
			<td>
				<?php echo showLimitedText($value->subject,50); ?>
			</td>			
			<td>
				<div class="btn-group">
				<?php if($value->status == 'Active') { ?>
					<button class="btn btn-xs btn-success status_label" type="button"><?php echo $this->lang->line('Active'); ?></button>
				<?php } else { ?>
					<button class="btn btn-xs btn-danger status_label" type="button"><?php echo $this->lang->line('Inactive'); ?></button>
				<?php } ?>
					<button class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" type="button"><i class="fa fa-angle-down"></i></button>
					<ul class="dropdown-menu" role="menu" style="margin-top:-50px">
						<li><a data-id="<?php echo $value->id; ?>" data-url="<?php echo site_url('admin/mail_templates/changeStatus'); ?>" data-status="Active" onClick="changeStatusCommon(this)"><?php echo $this->lang->line('Active'); ?></a></li>
						<li><a data-id="<?php echo $value->id; ?>" data-url="<?php echo site_url('admin/mail_templates/changeStatus'); ?>" data-status="Inactive" onClick="changeStatusCommon(this)"><?php echo $this->lang->line('Inactive'); ?></a></li>
					</ul>
				</div>
			</td>
			<td class="text-center">
				<a href="<?php echo base_url('admin/mail_templates/update/'.$value->id) ?>" class="btn purple tooltips" data-original-title="<?php echo $this->lang->line("Click_to_update_this_record"); ?>" data-placement="top" data-container="body"><i class="fa fa-pencil"></i></a>			
			</td>
		</tr>								
		<?php } ?>
		<?php if(!$templates) { ?>
			<tr>
			<td colspan="10"><div class="no-record"><?php echo $this->lang->line('No_record_found'); ?></div></td>
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