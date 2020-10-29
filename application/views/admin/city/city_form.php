<?php
	if ($message) {
		echo '<div class="alert alert-danger">' . $message . '</div>';
	}
?>
<div class="portlet light" style="height:45px">
	<div class="row">
		<ul class="page-breadcrumb breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('admin')?>" class="tooltips" data-original-title="HOME" data-placement="top" data-container="body">HOME</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<a href="<?php echo site_url('admin/city')?>" class="tooltips" data-original-title="City Management" data-placement="top" data-container="body">City Management</a>
				<i class="fa fa-arrow-right"></i>
			</li>
			<li>
				<?php if($id != '') {?>Update City<?php } else {?>Add New City<?php } ?>			
			</li>	
			<li style="float:right;">
				<a class="btn red tooltips" href="<?php echo base_url('admin/city'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="GO BACK" data-placement="top" data-container="body"><i class="m-icon-swapleft m-icon-white"></i>
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
				<?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form'));?>
					<div class="form-body"> 

                    	<div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">City Name<span style="color:red">*</span></label>
							<div class="col-md-10">					
								<?php echo form_input(array('placeholder' => 'Enter City Name', 'id' => "name", 'name' => "name", 'class' => "form-control", 'value' => "$name")); ?>
								<div class="form-control-focus"> </div>			
							</div>
						</div>


						<div class="form-group form-md-line-input">
						   	<label for="form_control_title" class="control-label col-md-2">State<span style="color:red">*</span></label>
						   	<div class="col-md-10">
						      	<select name="state_id" id="state_id" class="form-control select2 language_data" style="height:40px">
							        <option value="">
							        <?php if(!empty($allStates)) { ?>
							        Select State
							       
							        <?php }else{ ?>
							        No State Found
							        <?php } ?>							        	
							        </option>
							        <?php 
							            if(!empty($allStates))
							            {
							            	foreach ($allStates as $key => $value) 
								            {
									            $selected = '';
									            if($state_id == $value->id)
									            {
									            	$selected = 'selected';
									            }
									            echo '<option '.$selected.' value="'.$value->id.'">'.$value->name.'</option>';
								        	}
						            	}
						            ?>
						    	</select>
							</div>
						</div>

						 <div class="form-group form-md-line-input">
							<label for="form_control_title" class="control-label col-md-2">Status</label>
							<div class="md-radio-inline">
								<div class="md-radio">
									<input id="radio19" class="md-radiobtn" type="radio" name="status" value="Active" <?php echo ($status == 'Active')?'checked':''; ?>>
									<label for="radio19">
										<span class="inc"></span>
										<span class="check"></span>
										<span class="box"></span>Active</label>
								</div>
								<div class="md-radio has-error">
									<input id="radio20" class="md-radiobtn" type="radio" name="status" value="Inactive" <?php echo ($status == 'Inactive')?'checked':''; ?>>
									<label for="radio20">
										<span class="inc"></span>
										<span class="check"></span>
										<span class="box"></span>Inactive</label>
								</div>
							</div>
						</div>


				</div>  
						                               	
						
						
					</div>
					<div class="form-actions noborder">
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
							<button type="submit" class="btn green">Submit</button>
							<a href="<?php echo base_url('admin/city'); ?>" class="btn default">Cancel</a>
						</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>