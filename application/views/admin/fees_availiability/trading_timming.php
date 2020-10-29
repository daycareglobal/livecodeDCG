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
         <a href="<?php echo site_url('admin/fees_availiability')?>" class="tooltips" data-original-title="List of fees availiability" data-placement="top" data-container="body">List of fees availiability</a>
         <i class="fa fa-arrow-right"></i>
      </li>

      <li style="float:right;">
         <a class="btn red tooltips" href="<?php echo base_url('admin/fees_availiability'); ?>" style="float:right;margin-right:3px;margin-top: -7px;" data-original-title="Go Back" data-placement="top" data-container="body">Go Back<i class="m-icon-swapleft m-icon-white"></i>
         </a>
      </li> 

   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="box grey-cascade">
         <div class="portlet-body">
         </div>
      </div>
      <div class="portlet box grey-cascade">
         <div class="portlet-title">
            <div class="caption"><i class="icon-users"></i>Trading Timing</div>
         </div>
         <div class="portlet-body">
            <div class="table-toolbar">
               <div id="alert_area"></div>
               <div class="row">
               </div>
            </div>
            <div class="row">
               <div class="col-md-12 col-sm-12">
                  <?php echo form_open(current_url(), array('class' => 'form-horizontal ajax_form'));?>
                     <div class="portlet blue-hoki box">
                        <div class="portlet-body">
                           
                           <?php if(!empty($trading_timing)) { ?>
                           <div class="row static-info">
                              <div class="col-md-3 name">
                                 Availiability
                              </div>
                              <div class="col-md-3 name">
                                 Day
                              </div>
                              <div class="col-md-3 name">
                                 Opening Time
                              </div>
                              <div class="col-md-3 name">
                                 Closing Time
                              </div>
                           </div>
                           <?php   foreach ($trading_timing as $key => $value) { ?>
                           
                              <div class="row static-info days">
                                 <div class="days-time-div col-md-12">
                                    
                                    <div class="col-md-3 value">
                                       <?php echo form_input(array('placeholder' => '$value->available', 'id' => "$value->available", 'name' => "", 'class' => "form-control day", 'readonly'=>"true", 'value' => "$value->available")); ?>
                                    </div>

                                    <div class="col-md-3 value">
                                       <?php echo form_input(array('placeholder' => '$value->trading_day', 'id' => "$value->trading_day", 'name' => "", 'class' => "form-control day", 'readonly'=>"true", 'value' => "$value->trading_day")); ?>
                                    </div>

                                    <div class="col-md-3 value">
                                       <?php echo form_input(array('placeholder' => 'Enter opening time', 'id' => "monday_opening_time", 'name' => "", 'readonly'=>"true", 'class' => "form-control opening_time", 'value' => "$value->from_time")); ?>
                                    </div>

                                    <div class="col-md-3 value">
                                       <?php echo form_input(array('placeholder' => 'Enter closing time', 'id' => "monday_closing_time", 'name' => "", 'readonly'=>"true", 'class' => "form-control closing_time", 'value' => "$value->to_time")); ?>
                                    </div>

                                 </div>
                              </div>
                           <?php } } else { ?>
                              <center><h1>No record found.</h1></center>
                           <?php } ?>


                        </div>
                     </div>
                  
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
