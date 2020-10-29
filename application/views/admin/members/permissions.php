<?php
	if ($message) {
		echo '<div class="alert alert-danger">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url()?>"><?php echo $this->lang->line('Home'); ?></a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>
			
			<a href="<?php echo site_url('admin/members')?>" class="tooltips" data-original-title="Member Management" data-placement="top" data-container="body">Member Management</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>Update Member Permissions</li>
		<li style="float:right;">
			<a class="btn red tooltips" href="<?php echo base_url('admin/members'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body"><i class="m-icon-swapleft m-icon-white"></i>
			</a>
		</li>					
	</ul>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row">
					<div class="col-md-6">
						<div class="caption font-red-sunglo">
							<i class="fa fa-user"></i>
							<span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
						</div>
					</div>	

					<!-- <div class="col-md-6">
						<div class="btn-group tooltips pull-right" data-original-title="Select All">
							<a href="javascript:" class="btn green select_permission" checked="" data-set="">
								Select All <i class="fa fa-lock"></i></a>
						</div>
					</div>	 -->									
				</div>
			</div>			
			<div class="portlet-body form">
				<form action="<?php echo current_url()?>" role="form" id="form_setting" method="post" class=" ajax_form track-form">
					<div class="form-body">							
						<div class="portlet light" id="all_permissions">							
						<?php foreach ($permissionsCategories as $key => $value) { ?>			<div class="form-group form-md-checkboxes">
								<label class=""><?php echo $value->category  ?></label>
								<hr>
								<div class="md-checkbox-list">
									<div class="row">								
									<?php foreach ($value->permissions as $p => $permissions) { ?>
									<div class="col-md-3">
										<div class="md-checkbox has-error">
											<input <?php if(in_array($permissions->id, $user_permissions)) { ?> checked="checked" <?php } ?> name="permissions[<?php echo $permissions->id; ?>]" value="<?php echo $permissions->id; ?>" type="checkbox" id="checkbox_<?php echo $permissions->id; ?>" class="md-check">
											<label for="checkbox_<?php echo $permissions->id; ?>">
											<span></span>
											<span class="check"></span>
											<span class="box"></span>
											<?php echo $permissions->title; ?> </label>
										</div>
									</div>

								<?php } ?>
								</div>
								</div>
							</div>
						<?php } ?>
						</div>					
				
						<div class="alert alert-danger display-hide">
							<button class="close" data-close="alert"></button>
							<span class="ajax_message"></span>
						</div>
					</div>	
					<input type="hidden" name="hidden" value="1" />				
					<div class="form-actions noborder">
						<button type="submit" class="btn green"><?php echo $this->lang->line('Submit'); ?></button>
						<a href="<?php echo base_url('admin/members'); ?>" class="btn default"><?php echo $this->lang->line('Cancel'); ?></a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

jQuery(document).on('click','.select_permission',function () {
	var checked = jQuery(this).attr("data-set");
	 jQuery("#all_permissions").each(function () {
	 	if (checked == '1') {
            $(this).find('.md-check').prop("checked", true);
            $('.select_permission').attr('data-set',1);
        } else {
            $(this).find('.md-check').prop("checked", false);
            $('.select_permission').attr('data-set',2);
        }	 	
	 });
});



/* jQuery(document).on('click','.select_permission',function () {
            var set = ".md-check";
            var checked = jQuery(this).attr("data-set");           
            jQuery(set).each(function () {
                    
                if (checked) {
                    $(this).attr("checked", true);
                    $('.select_permission').html('Select All<i class="fa fa-unlock"></i>');
              		$('.select_permission').attr('data-set',true);
                } else {
                    $(this).attr("checked", false);
                    $('.select_permission').html('Select All<i class="fa fa-lock"></i>');
               		$('.select_permission').attr('data-set',false);
                }                    
            });
            jQuery.uniform.update(set);
        });*/
</script>