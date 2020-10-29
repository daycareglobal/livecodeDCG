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
      
      <div class="portlet light">
          <div class="portlet-title">
            <div class="row">
              <div class="col-md-6">
                <div class="caption font-red-sunglo">
                  <i class="fa fa-file-image"></i>
                  <span class="caption-subject bold font-purple-plum uppercase"><i class="fa fa-calendar"></i> Sessions: <span class="language font-red-sunglo">Funded Session for 
                    <?php if($funded_type == '15-2-3') { ?>
                      15 hours 2-3 years old age group
                    <?php } ?>
                    
                    <?php if($funded_type == '15-3-5') { ?>
                      15 hours 3-5 years old age group
                    <?php } ?>

                    <?php if($funded_type == '30-3-5') { ?>
                      30 hours 3-5 years old age group
                    <?php } ?>
                  </span></span>
                </div>
              </div>          
            </div>        
          </div>
         
          <div class="portlet-body form">           
            <div class="form-body">
              <div class="form-group form-md-line-input">
                <?php if(isset($sessions) && !empty($sessions)) { ?> 
                  <table class="table table-striped table-bordered table-hover" id="sample_3">
                    <caption>
                      <h2>Weeks Per Year<h2>
                      <?php if($sessions[0]->is_32_week_per_year == 'Yes') { ?>
                       <h4>38 weeks</h4>
                      <?php } ?>
                      
                      <?php if($sessions[0]->is_52_week_per_year == 'Yes') { ?>
                       <h4>52 weeks</h4>
                      <?php } ?>
                    </caption>
                    
                    <thead>
                      <tr>
                        <th>Session Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Excluded from</th>
                        <th>Excluded to</th>
                        <th>Days</th>
                      </tr>
                    </thead>
            
                    <tbody>
                      <?php
                       foreach ($sessions as $k => $val) { ?>
                        <tr>
                          <td><?php echo $val->session_name; ?></td>
                          <td><?php echo $val->from_time; ?></td>
                          <td><?php echo $val->to_time; ?></td>
                          <td><?php echo $val->excluded_from_time; ?></td>
                          <td><?php echo $val->excluded_to_time; ?></td>
                          <td>
                            <?php 
                              $index = 0; foreach ($val->days as $key => $value) { 
                                $index++; 
                                echo $value->day . ($index == count($val->days)?"":", ");
                              } 
                            ?>
                         </td>
                        </tr>
                      <?php } ?>
                    </tbody>

                  </table>
                <?php } else { ?>
                  <center><div class="">Session not found</div></center>
                <?php } ?>
              </div>
            </div>
          </div>
      </div>

      <div class="portlet light">
        <div class="portlet-title">
          <div class="row">
            <div class="col-md-6">
              <div class="caption font-red-sunglo">
                <i class="fa fa-file-image"></i>
                <span class="caption-subject bold font-purple-plum uppercase"><i class="fa fa-money"></i> Monthly fees: <span class="language font-red-sunglo">
                  Monthly fees for 
                   <?php if($funded_type == '15-2-3') { ?>
                    15 hours 2-3 years old age group
                  <?php } ?>
                  
                  <?php if($funded_type == '15-3-5') { ?>
                    15 hours 3-5 years old age group
                  <?php } ?>

                  <?php if($funded_type == '30-3-5') { ?>
                    30 hours 3-5 years old age group
                  <?php } ?>
                </span></span>
              </div>
            </div>          
          </div>        
        </div>
       
        <div class="portlet-body form">   
          <div class="form-body">
            <div class="form-group form-md-line-input">
            <?php if(isset($monthly_session_fees) && !empty($monthly_session_fees)) {  
                  foreach ($monthly_session_fees as $keys => $session) { ?>
              <table class="table table-striped table-bordered table-hover" id="sample_3">
               
                    
                    <thead>
                      <tr>
                        <th><h4><?php echo 'Session Name :'.$session->session_name; ?></h4></th>
                      </tr>
                      <tr>
                        <th>Week type</th>
                        <th>1 Day/Week</th>
                        <th>2 Day/Week</th>
                        <th>3 Day/Week</th>
                        <th>4 Day/Week</th>
                        <th>5 Day/Week</th>
                        <th>6 Day/Week</th>
                        <th>7 Day/Week</th>
                      </tr>
                    </thead>
                <tbody>
                  <?php foreach ($session->session_fees as $k => $val) { ?>

                    <?php if($val->week_per_year == '38') { ?>
                    <tr>
                      <td>38 weeks</td>
                      <td><?php echo $val->day_1; ?></td>
                      <td><?php echo $val->day_2; ?></td>
                      <td><?php echo $val->day_3; ?></td>
                      <td><?php echo $val->day_4; ?></td>
                      <td><?php echo $val->day_5; ?></td>
                      <td><?php echo $val->day_6; ?></td>
                      <td><?php echo $val->day_7; ?></td>
                    </tr>
                    <?php } ?>  

                    <?php if($val->week_per_year == '52') { ?>
                    <tr>
                      <td>52 weeks</td>
                       <td><?php echo $val->day_1; ?></td>
                      <td><?php echo $val->day_2; ?></td>
                      <td><?php echo $val->day_3; ?></td>
                      <td><?php echo $val->day_4; ?></td>
                      <td><?php echo $val->day_5; ?></td>
                      <td><?php echo $val->day_6; ?></td>
                      <td><?php echo $val->day_7; ?></td>
                    </tr>
                    <?php } ?>  

                  <?php } ?>
                </tbody>

              </table>
              <?php } } else { ?>
                <center><div class="">Monthly fees not found</div></center>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <div class="portlet light">
        <div class="portlet-title">
          <div class="row">
            <div class="col-md-6">
              <div class="caption font-red-sunglo">
                <i class="fa fa-file-image"></i>
                <span class="caption-subject bold font-purple-plum uppercase"><i class="fa fa-home"></i> Room Availiability </span>
              </div>
            </div>          
          </div>        
        </div>
       
        <div class="portlet-body form">   
          <div class="form-body">
            <div class="form-group form-md-line-input">
            <?php if(isset($room_availiability) && !empty($room_availiability)) { 
                  foreach ($room_availiability as $key => $value) { ?>
                   <table class="table table-striped table-bordered table-hover" id="sample_3">
                    <caption><?php echo $value->room_name; ?>
                    <?php if($value->customer_option == 'Yes') { ?>
                      <div class="left-part">
                          <span> Offer customers waiting list : Yes</span>
                      </div>
                    <?php } ?>
                    
                    <?php if($value->week_type == 'General_Availability') { ?>
                      <div class="right-part">
                        <span>Week type : General availability</span>
                      </div>
                    <?php } ?>

                    <?php if($value->week_type == '38_weeks') { ?>
                       <div class="right-part">
                        <span>Week type : 38 weeks per year attendance</span>
                      </div>
                    <?php } ?>

                    <?php if($value->week_type == '52_weeks') { ?>
                      <div class="right-part">
                        <span>Week type : 52 weeks per year attendance</span>
                      </div>
                    <?php } ?>
                      

                    </caption>
                    <thead>
                      <tr>
                        <th>Term</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php if(isset($value->rooms) && !empty($value->rooms)) { 
                      foreach ($value->rooms as $k => $val) { ?>
                      <tr>
                        <th><?php echo $val->term_name; ?></th>
                        <td><?php echo $val->monday; ?></td>
                        <td><?php echo $val->tuesday; ?></td>
                        <td><?php echo $val->wednesday; ?></td>
                        <td><?php echo $val->thursday; ?></td>
                        <td><?php echo $val->friday; ?></td>
                        <td><?php echo $val->saturday; ?></td>
                        <td><?php echo $val->sunday; ?></td>
                      </tr>
                      <?php } }?>
                    </tbody>

               <?php }  ?>

              </table>
              <?php } else { ?>
                <center><div class="">Room availiability not found</div></center>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      </div>
    </div>
  </div>

