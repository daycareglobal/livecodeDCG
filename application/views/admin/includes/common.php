<script type="text/javascript">
	var site_url = '<?php echo site_url(); ?>';
	var base_url = site_url; 
	var siteurl = site_url; 
</script>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css"/>
<!-- <link href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/> -->
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-toastr/toastr.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery-validation/cmxform.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/datepicker/css/bootstrap-datepicker.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/select2/select2.min.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>

<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/respond.min.js"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/common.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/media.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-toastr/toastr.min.js">
</script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript">
</script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript">
</script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/script.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/ckfinder/ckfinder.js"></script>

<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>

<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="<?php echo $this->config->item('admin_assets'); ?>global/datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('admin_assets'); ?>global/select2/select2.min.js" type="text/javascript"></script>

<script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<!-- END CORE PLUGINS -->


<div class="modal fade bs-modal-sm" id="DeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form role="form" method="post" action="" class="ajax_form" id="DeleteForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Remove</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="record_id" value="" id="RecordID">
					Are You Sure! You want to remove?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn red">Remove</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade bs-modal-sm" id="deleteImage" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form role="form" method="post" action="" class="ajax_form" id="DeleteForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Delete</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="record_id" value="" id="RecordID">
					Are You Sure! You want to delete?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn red">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--Code for Blank Multiple task -->
<div class="modal fade bs-modal-sm" id="alert_message_div" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header" id="alert_message_div_header">
				
			</div>
			<div class="modal-body" id="alert_message_div_message">
				
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Ok</button>
			</div>
		</div>
	</div>
</div>
<!--End Code for Blank Multiple task -->

<!--Code for Confirm Multiple Task-->
<div class="modal fade bs-modal-sm" id="alert_confirm_div" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">

			<form role="form" method="post" action="" class="ajax_form" id="DeleteMultipleForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		    		<h3 id="confirm_alert_message_header">Please Confirm </h3>
				</div>
				<input type="hidden" name="ids" value="" id="multiple_Ids">
				<input type="hidden" name="task" value="" id="task">
				 <div class="modal-body">
		       		<p id="confirm_alert_message_body">Are You Sure to this <span class="confirm_task"></span> record</p>
		        </div>
				<div class="modal-footer">
		        	<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		    		<button class="btn confirm_btn">Confirm</button>
		        </div>
			</form>			
		</div>
	</div>
</div>
<!--End Code for Confirm Multiple Task-->
                
<!--Modal for showing all media-->
<div class="modal fade" id="media" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Media</h4>
            </div>                    
            <div class="modal-body">
                 <div class="ajax_content_media">
                </div>
            </div>
            <div class="modal-footer">               
                <button type="button" class="btn green pull-left add_media">Upload New Media</button>                
                <button type="button" class="btn green use_media">Use Media</button>
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--end all media modal-->

<!---upload media-->
<div class="modal fade" id="upload_media" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Media</h4>
            </div>                    
            <div class="modal-body">
            <?php echo form_open(site_url('admin/media/uploadImage'), array('class' => 'form-horizontal ajax_form','enctype'=>"multipart/form-data"));?>  
            <div class="form-group">
                <label for="Ensavoir" class="col-sm-4 control-label">
                	Title <span style="color:red">*</span></label>
                <div class="col-sm-8">
                	<input type="text" name="title" id="title" class="form-control">
                </div>
            </div>

              <div class="form-group">
                <label for="Ensavoir" class="col-sm-4 control-label">
                	Copyright Text</label>
                <div class="col-sm-8">
                	<input type="text" name="copyright_text" id="copyright_text" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label for="Ensavoir" class="col-sm-4 control-label">
                	Content</label>
                <div class="col-sm-8">
                	<textarea type="text" name="content" id=""  class="form-control" rows="3"></textarea>                  
                </div>
              </div> 
               <div class="form-group">
                <label for="Ensavoir" class="col-sm-4 control-label">
                	Image <span style="color:red">*</span></label>
                <div class="col-sm-8">
                	<input type="file" name="image" id="form_control_image">                  
                </div>
              </div>                   
              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                  <button class="btn btn-success" type="submit">Submit</button>
                </div>
              </div>
            </form> 
            </div>
            <div class="modal-footer">               
                <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---end upload media modal-->    

<!-- <div class="modal fade bs-modal-sm" id="DeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form role="form" method="post" action="" class="ajax_form" id="DeleteForm">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Delete</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" class="form-control" name="record_id" value="" id="RecordID">
					Are You Sure! You want to delete?
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn red">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div> -->
<div class="modal fade bs-modal-sm" id="delete_permission_popup" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Permission</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete permission of this user ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" onclick="deletePermission()" class="btn btn-primary">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="force_add_item_popup" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Force Save</h4>
      </div>
      <div class="modal-body">
        <p>This food item already added for that location. Click on yes, if you want to update it.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        <button type="button" onclick="forceSaveItem()" class="btn btn-primary">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" id="csv_popup" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Import Csv</h4>
      </div>
      	<?php echo form_open_multipart(base_url('admin/csv/import_csv'), array('class' => 'form-horizontal ajax_form'));?>
		  	<div class="modal-body">
				<div class="form-body">
					<div class="form-group form-md-line-input">
						<label for="form_control_title" class="control-label col-md-2">Select CSV<span style="color:red">*</span></label>
						<div class="col-md-10">					
							<input type="file" name="csv_file" class="form-control" accept=".csv"/>
							<div class="form-control-focus"> </div>			
						</div>
					</div>
					<!-- <div class="form-actions noborder">
						<div class="row">
							<div class="col-md-offset-2 col-md-10">
							<button type="submit" class="btn green">Submit</button>
							<a href="<?php echo base_url('admin/makers'); ?>" class="btn default">Cancel</a>
						</div>
						</div>
					</div> -->
		      	</div>
		    </div>
		  	<div class="modal-footer">
		  		<button type="submit" class="btn green">Submit</button>
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<script type="text/javascript">
//Delete Record
	
	function deleteRecord($this) {
		$('#DeleteModal').modal('show');
		$('#RecordID').val($($this).data('id'));
		$('#DeleteForm').attr('action', $($this).data('url'));
	}
	function deleteFile($this) {
		$('#DeleteModal').modal('show');
		$('#RecordID').val($($this).data('id'));
		$('#DeleteForm').attr('action', $($this).data('url'));
	}
	function import_csv(){
		$('#csv_popup').modal('show');
	}
	function return_csv_upload(data){
		if(data.success){
			$('#csv_popup').modal('hide');
		}
	}
	function callBackCommonDelete(data)
	{
		$('#DeleteModal').modal('hide');
		$('#alert_confirm_div').modal('hide');
		if(data.success && data.record_id)
		{
			$('.file_'+data.record_id).fadeOut(500);
		}
		else
		{
			location.reload();
		}
		// submitSearchData();
	}

  function callBackSliderImageDelete(data)
  {
    $('#DeleteModal').modal('hide');
    $('#alert_confirm_div').modal('hide');
    
    if ( data.success && data.record_id ) {
    /*  $('.file_'+data.record_id).fadeOut(500);
      max_uplaod_file = data.file_count;*/
      location.reload();
      // initDropzone();
    } else {
      location.reload();
    }
    // submitSearchData();
  }

//Change Record Status
	function changeStatusCommon($this)  {
		var action_url = $($this).attr('data-url');
		var record_id = $($this).attr('data-id');
		var next_status = $($this).attr('data-status');
		if(action_url && record_id && next_status)
		{
			$.getJSON(action_url,{id:record_id,status:next_status},function(data){
				if(data.success)
				{
					checkTosterResponse(data);
					// submitSearchData();
					location.reload();
				} else {
					checkTosterResponse(data);
				}
			})
		}
	}
</script>
<script type="text/javascript">		
//Intailize Select2 Class
$(document).ready(function(){       
    $(".select2").select2({

    });
});
</script>
<script type="text/javascript">
	//Code for Check Checkbox is not Blank
function checkForNullChecked(task,$this)
{
	var selected = new Array();
	$("#sample_3 input.recordcheckbox:checked").each(function() {
			selected.push($(this).val());
	});
	if(selected.length==0)
	{
		$("#alert_message_div").modal('show');
		$("#alert_message_div").find("#alert_message_div_header").text('Ohh!');
		$("#alert_message_div").find("#alert_message_div_message").text('Please select at least one record');
	}
	else
	{
		var taskurl = $($this).attr('data-taskurl');		
		showConfirmDialogTableMultiple(task,taskurl);
	}
}

//Show Confirm Dialog Popup 
function showConfirmDialogTableMultiple(task,taskurl)
{
	$('#alert_confirm_div').modal('show');
	$('#alert_confirm_div').find('#confirm_alert_message_header').text('Please Confirm');
  // $('#alert_confirm_div').find('#confirm_alert_message_body').text('Are You Sure want to '+task+' this record');
	$('#alert_confirm_div').find('.confirm_btn').removeClass('green');
	$('#alert_confirm_div').find('.confirm_btn').removeClass('purple');
	$('#alert_confirm_div').find('.confirm_btn').removeClass('red');

	if(task=='Active') {
    $('#alert_confirm_div').find('.confirm_btn').addClass('green');
    $('#alert_confirm_div').find('#confirm_alert_message_body').text('Are You Sure want to Activate this record');
  }

	else if(task=='Inactive') {  
    $('#alert_confirm_div').find('.confirm_btn').addClass('purple');
    $('#alert_confirm_div').find('#confirm_alert_message_body').text('Are You Sure want to Deactivate this record');
  }

	else if(task=='Deleted') {  
    $('#alert_confirm_div').find('.confirm_btn').addClass('red');
    $('#alert_confirm_div').find('#confirm_alert_message_body').text('Are You Sure want to Remove this record');
  }

	// else if(task=='Completed') {
 //    $('#alert_confirm_div').find('.confirm_btn').addClass('green');
 //  }

	// else if(task=='Schedule')
	// $('#alert_confirm_div').find('.confirm_btn').addClass('purple');

	// else if(task=='Unschedule')
	// $('#alert_confirm_div').find('.confirm_btn').addClass('purple');

	else if(task=='Delete') {
    $('#alert_confirm_div').find('.confirm_btn').addClass('red');
    $('#alert_confirm_div').find('#confirm_alert_message_body').text('Are You Sure want to Remove this record');
  }

  else {
    $('#alert_confirm_div').find('#confirm_alert_message_body').text('Are You Sure want to '+task+' this record');
  }
  $('#alert_confirm_div').find('#DeleteMultipleForm').attr('action',taskurl);

	var selected = new Array();
   		$("#sample_3 input.recordcheckbox:checked").each(function() {
     		selected.push($(this).val());
 	});
 	$('#alert_confirm_div').find('#multiple_Ids').val(selected);
 	$('#alert_confirm_div').find('#task').val(task);
}	
</script>
<script type="text/javascript">
jQuery(document).on('change','#sample_3 .group-checkable',function () {
    var set = jQuery(this).attr("data-set");
    var checked = jQuery(this).is(":checked");
    jQuery(set).each(function () {
        if (checked) {
            $(this).attr("checked", true);
        } else {
            $(this).attr("checked", false);
        }                    
    });
    jQuery.uniform.update(set);
});	
jQuery(document).on('change','#sample_3 .recordcheckbox',function () {
	 var checked = jQuery(this).is(":checked");
	 if (checked) {
            $(this).attr("checked", true);
        } else {
            $(this).attr("checked", false);
        }   
});

</script>
<script type="text/javascript">
// $(function(){
//             var sampleTags = ['c++', 'java', 'php', 'coldfusion', 'javascript', 'asp', 'ruby', 'python', 'c', 'scala', 'groovy', 'haskell', 'perl', 'erlang', 'apl', 'cobol', 'go', 'lua'];

//             //-------------------------------
//             // Minimal
//             //-------------------------------
//             $('#myTags').tagit();

//             //-------------------------------
//             // Single field
//             //-------------------------------
//             $('#singleFieldTags').tagit({
//                 availableTags: sampleTags,
//                 // This will make Tag-it submit a single form value, as a comma-delimited field.
//                 singleField: true,
//                 singleFieldNode: $('#mySingleField')
//             });

//             // singleFieldTags2 is an INPUT element, rather than a UL as in the other 
//             // examples, so it automatically defaults to singleField.
//             $('#singleFieldTags2').tagit({
//                 availableTags: sampleTags
//             });

//             //-------------------------------
//             // Preloading data in markup
//             //-------------------------------
//             $('#myULTags').tagit({
//                 availableTags: sampleTags, // this param is of course optional. it's for autocomplete.
//                 // configure the name of the input field (will be submitted with form), default: item[tags]
//                 itemName: 'item',
//                 fieldName: 'tags'
//             });

//             //-------------------------------
//             // Tag events
//             //-------------------------------
//             var eventTags = $('#eventTags');

//             var addEvent = function(text) {
//                 $('#events_container').append(text + '<br>');
//             };

//             eventTags.tagit({
//                 availableTags: sampleTags,
//                 beforeTagAdded: function(evt, ui) {
//                     if (!ui.duringInitialization) {
//                         addEvent('beforeTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
//                     }
//                 },
//                 afterTagAdded: function(evt, ui) {
//                     if (!ui.duringInitialization) {
//                         addEvent('afterTagAdded: ' + eventTags.tagit('tagLabel', ui.tag));
//                     }
//                 },
//                 beforeTagRemoved: function(evt, ui) {
//                     addEvent('beforeTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
//                 },
//                 afterTagRemoved: function(evt, ui) {
//                     addEvent('afterTagRemoved: ' + eventTags.tagit('tagLabel', ui.tag));
//                 },
//                 onTagClicked: function(evt, ui) {
//                     addEvent('onTagClicked: ' + eventTags.tagit('tagLabel', ui.tag));
//                 },
//                 onTagExists: function(evt, ui) {
//                     addEvent('onTagExists: ' + eventTags.tagit('tagLabel', ui.existingTag));
//                 }
//             });

//             //-------------------------------
//             // Read-only
//             //-------------------------------
//             $('#readOnlyTags').tagit({
//                 readOnly: true
//             });

//             //-------------------------------
//             // Tag-it methods
//             //-------------------------------
//             $('#methodTags').tagit({
//                 availableTags: sampleTags
//             });

//             //-------------------------------
//             // Allow spaces without quotes.
//             //-------------------------------
//             $('#allowSpacesTags').tagit({
//                 availableTags: sampleTags,
//                 allowSpaces: true
//             });

//             //-------------------------------
//             // Remove confirmation
//             //-------------------------------
//             $('#removeConfirmationTags').tagit({
//                 availableTags: sampleTags,
//                 removeConfirmation: true
//             });
            
//         });

</script>