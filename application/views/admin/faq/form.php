<?php
	if (isset($message) && $message) {
		$alert = ($success)? 'alert-success':'alert-danger';
		echo '<div class="alert ' . $alert . '">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px" >
	<div class="row">
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="Home" data-placement="top" data-container="body">Home</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<a href="<?php echo site_url('admin/faq')?>" class="tooltips" data-original-title="FAQ'S" data-placement="top" data-container="body">FAQ'S List</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') { ?>
				 	Update FAQ'S 
				 <?php } else { ?>
				 	Add FAQ'S 
				 <?php } ?>
			</li>
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/faq'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
				</a>
			</li>
		</ul>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet light">
			<div class="portlet-title">
				<div class="row">
					<div class="col-md-6">
						<div class="caption font-red-sunglo">
							<i class="fa fa-file-image"></i>
							<span class="caption-subject bold uppercase"><?php echo $page_title; ?></span>
						</div>
					</div>
				</div>
			</div>
			<div class="portlet-body form">
				<?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form', 'autocomplete' => 'off'));?>
					<div class="form-body">

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Question<span style="color:red">*</span></label>
							<div class="col-md-10">
								<?php echo form_input(array('placeholder' => 'Enter Question', 'id' => "question", 'name' => "question", 'class' => "form-control", 'value' => "$question")); ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Answer<span style="color:red">*</span></label>
							<div class="col-md-10">
								<textarea class="form-control" id="answer" name="answer" placeholder="Enter Answer"><?php echo $answer; ?></textarea>
								<?php /* echo form_input(array('placeholder' => 'Enter Answer', 'id' => "answer", 'name' => "answer", 'class' => "form-control", 'value' => "$answer")); */ ?>
								<div class="form-control-focus"> </div>
							</div>
						</div>

						<div class="form-actions noborder">
							<div class="row">
								<div class="col-md-offset-2 col-md-10">
								<button type="submit" class="btn green">Submit</button>
								<a href="<?php echo base_url('admin/faq'); ?>" class="btn default">Cancel</a>
							</div>
							</div>
						</div>
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>