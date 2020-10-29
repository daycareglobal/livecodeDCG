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
			
			<a href="<?php echo site_url('admin/send_email')?>" class="tooltips" data-original-title="List of email templates" data-placement="top" data-container="body">List of Templates</a>
			<i class="fa fa-arrow-right"></i>
		</li>
		<li>
			<?php if($id != '') 
				{?>Update Template<?php } 
			else 
				{?>Add Template<?php } 
			?>			
		</li>
		<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/send_email'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
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
							<label for="form_control_title" class="control-label col-md-2">Template Name<span style="color:red">*</span></label>
							<div class="col-md-10">								
								<?php echo form_input(array('placeholder' => "Enter Template Name", 'id' => "name", 'name' => "name", 'class' => "form-control", 'value' => "$name")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>				

						<div class="form-group form-md-line-input">
							<label for="form_control_subject" class="control-label col-md-2">Subject<span style="color:red">*</span></label>
							<div class="col-md-10">								
								<?php echo form_input(array('placeholder' => "Enter Subject", 'id' => "subject", 'name' => "subject", 'class' => "form-control", 'value' => "$subject")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>	

						<div class="form-group form-md-line-input">
							<label for="email_content" class="control-label col-md-2">Content<span style="color:red">*</span></label>
							<div class="col-md-10">				
								<?php echo form_textarea(array('placeholder' => "Content", 'id' => "content", 'name' => "content", 'class' => " form-control", 'value' => "$content")); ?>								
							</div>
						</div>										
					</div>
					<div class="form-actions noborder">
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/send_email'); ?>" class="btn default">Cancel</a>
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