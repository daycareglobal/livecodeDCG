<!--BEGIN CONTAINER -->

<?php
	if (isset($message) && $message) {
		$alert = ($success)? 'alert-success':'alert-danger';
		echo '<div class="alert ' . $alert . '">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px">
	<ul class="page-breadcrumb breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>
			
			<a href="<?php echo site_url('admin/content')?>" class="tooltips" data-original-title="List of  email templates" data-placement="top" data-container="body">List of Static Contents</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>
			<?php if($id != '') 
				{?>Update Static Content<?php } 
			else 
				{?>Add Static Content<?php } 
			?>			
		</li>
		<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/content'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<i class="fa fa-chain-broken"></i>
							<span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
						</div>
					</div>					
				</div>				
			</div>
			<div class="portlet-body form">
				<?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form'));?>
					<div class="form-body">	

						<div class="form-group form-md-line-input">
							<label for="page_name" class="col-md-3 control-label">Page Name <span class="required">
							* </span></label>
							<div class="col-md-9">
								<input type="text" id="page_name" name="page_name" value="<?php if(isset($record)){ echo $record->page_name; } ?>" class="form-control input-inline input-large" readonly>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="title" class="col-md-3 control-label">Title <span class="required">
							* </span></label>
							<div class="col-md-9">
								<input type="text" id="title" name="title" value="<?php if(isset($record)){ echo $record->title; } ?>" class="form-control input-inline input-large">
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="description" class="col-md-3 control-label">Description <span class="required">
							* </span></label>
							<div class="col-md-9">
								<textarea id="description" name="description" class="ckeditor form-control input-inline input-large"><?php if(isset($record->description)){ echo $record->description; } ?></textarea>
							</div>
						</div>

						<?php if ($record->slug == 'about-us') { ?>
							<div class="form-group form-md-line-input">
								<label for="about_us" class="col-md-3 control-label">About Us Image<span class="required">
								* </span></label>
								<div class="col-md-9">
									<div class="fileinput fileinput-new" data-provides="fileinput">
										<span class="btn default btn-file">
										<span class="fileinput-new">
										Select Image </span>
										<span class="fileinput-exists">
										Change </span>
										<input type="file" id="profile_image" name="about_us">
										</span>
										<span class="fileinput-filename">
										</span>
										&nbsp; <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput">
										</a>
									</div>
								</div>
							</div>
							
							<div class="form-group form-md-line-input">
								<label for="about_us" class="col-md-3 control-label">Preview</label>
								<div class="col-md-9">
									<img id="preview_image" name="about_us" href="<?php if(isset($record->image)){ echo $record->image; } ?>" src="<?php if(isset($record->image)){ echo site_url('assets/uploads/about_us/'.$record->image); } ?>" height="80" width="100" alt="No Image Selected" />
								</div>
							</div>
						<?php } ?>
					</div>
					<div class="form-actions noborder">
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/content'); ?>" class="btn default">Cancel</a>
							</div>
						</div>
					</div>
				</form>
			</div>			
		</div>
	</div>
</div>
<script type="text/javascript">
var element = 'content';
CKEDITOR.replace(element,
{
	   
});	
</script>
<script type="text/javascript">
	$('.ajax_form').submit(function(event){
		for (instance in CKEDITOR.instances)
	    {
	        CKEDITOR.instances[instance].updateElement();
	    }
	});
</script>