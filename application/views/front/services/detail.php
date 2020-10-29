<section class="banner-section">
   <div class="banner-img"><img src="<?php echo base_url('assets/front/'); ?>images/search-details-banner.jpg"></div>
</section>
<section class="same-section bg-color">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="page-heading">
          <h1><?php echo $service_detail->daycare_name; ?></h1>
          <p><?php echo $service_detail->daycare_address; ?></p>
          <p class="rating"><span><?php echo ($service_detail->rating > 0)?$service_detail->rating:0; ?><i class="fas fa-star"></i></span>(0 Rating)</p>
        </div>
        <div class="service-same-box service-ul">
          <h4>Services</h4>

          <?php if ($service_detail->services) { ?>
            <ul>
              <?php foreach ($service_detail->services as $k => $v) { ?>
                <li><span><img src="<?php echo $this->config->item('uploads').'service_icons'.'/'.$v->icon; ?>"></span><?php echo $v->name; ?></li>
              <?php } ?>
            </ul>
          <?php } ?>
          <!-- <ul>
            <li><span><img src="images/service-icon-1.png"></span>CCTV Footage</li>
            <li><span><img src="images/service-icon-2.png"></span>Extended Hours</li>
            <li><span><img src="images/service-icon-3.png"></span>Qualified Teacher</li>
            <li><span><img src="images/service-icon-4.png"></span>Meal Included</li>
            <li><span><img src="images/service-icon-1.png"></span>Live CCTV Footage</li>
            <li><span><img src="images/service-icon-4.png"></span>Activity Space</li>
            <li><span><img src="images/service-icon-6.png"></span>Security</li>
            <li><span><img src="images/service-icon-7.png"></span>AC Rooms</li>
          </ul> -->
        </div>
        <div class="clearfix"></div>
        <div class="service-same-box">
          <h4>About Daycare</h4>
          <p><?php echo $service_detail->about_daycare_center; ?></p>
          <div class="daycare-details">
            <div class="row">
              <div class="col-md-12 col-lg-3"><h3>Days of Operation</h3></div>
              <div class="col-md-12 col-lg-9">
                <!--<h5>Mon to Sat</h5>-->  

                <div class="search-open-details working_days">
                  <?php if(isset($service_detail->service_days) && !empty($service_detail->service_days)) { 
                    foreach ($service_detail->service_days as $k => $val) { ?>
                  <ul>

                    <li>
                      <!-- <p>WORKING DAYS</p> -->
                      <strong><?php echo ucfirst($val->day); ?></strong>
                    </li>

                    <li>
                      
                      <?php if($val->is_holiday == 'Yes') { ?>
                        <strong>Closed</strong>
                      <?php } else { ?>
                        <strong><?php echo $val->open_time; ?></strong>
                      <?php } ?>
                      <span>-</span>
                     
                      <?php if($val->is_holiday == 'Yes') { ?>
                        <strong>Closed</strong>
                      <?php } else { ?>
                        <strong><?php echo $val->close_time; ?></strong>
                      <?php } ?>
                    </li>
                  </ul>
                  <?php } } ?>
                </div>
              </div>
            </div>
            <!-- <div class="row">
              <div class="col-md-3"><h3>Hours of Operation</h3></div>
              <div class="col-md-9"><h5>9AM to 8PM</h5></div>
            </div> -->
            <div class="row">
              <div class="col-md-3"><h3>Age Accepted</h3></div>
              <div class="col-md-9"><h5><?php echo $service_detail->age_accepted; ?></h5></div>
            </div>
            <div class="row">
              <div class="col-md-3"><h3>Total Capacity</h3></div>
              <div class="col-md-9"><h5><?php echo $service_detail->total_capacity; ?></h5></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="service-white-box">
          <div class="form-group input-icon">
            <label>Check In</label>
            <?php 
              $sid = (isset($_GET['sid'])) ? $_GET['sid'] : ''; 
              $check_in = (isset($check_in)) ? $check_in : ''; 
              $check_out = (isset($check_out)) ? $check_out : ''; 
            ?>
             <input type="text" name="" id="check_in" class="form-control check_in" placeholder="" value="<?php echo ($check_in) ? $check_in : ''; ?>">
             <span class="check_in"><i class="fas fa-calendar-alt"></i></span>
          </div>
          <div class="form-group input-icon">
             <label>Check Out</label>
             <input type="text" name="" id="check_out" class="form-control check_out" placeholder=""  value="<?php echo $check_out; ?>">
             <span class="check_out"><i class="fas fa-calendar-alt"></i></span>
          </div>
          <div class="form-group input-icon select">
             <label>Child</label>
             <select class="form-control" id="totalChild">
                <?php 
	              for($i=1; $i<=10; $i++) {
	                echo "<option value=".$i.">".$i."</option>";
	            } ?>
             </select>
             <span><i class="fas fa-angle-down"></i></span>
          </div>
           <div class="form-group mb-0">
            <button onclick="book_now()" class="btn btn-primary w-100">Book now</button>
           </div>
        </div>
        <div class="service-same-box">
          <h4>Location</h4>
          <div class="map-box" id="map">
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14198.046587873685!2d75.67899005!3d27.17165145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c5535ac4f7915%3A0xf0d3e2b509ea8dec!2sBhardwaj%20Chikitsalaya%20Tankarda!5e0!3m2!1sen!2sin!4v1578740394341!5m2!1sen!2sin" frameborder="0" style="border:0;" allowfullscreen=""></iframe> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
	/*$(function() {
	    $('.check_in').datetimepicker({
	       autoclose: true,
	    });
	});*/

/*	$(function() {
	    $('.check_out').datetimepicker({
	       autoclose: true,
	    });
	});
*/

$(function() {
  $('.check_in').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
  }).on('changeDate', function(e){
      $('.check_out').val('');
      var startTime = $('.datetimepicker101').val();
      // alert(startTime);
      $('.check_out').datetimepicker('setStartDate', $('.check_in').val());
  });
  $('.check_out').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
  }).on('changeDate', function(e){
      // $('.datetimepicker101').datetimepicker('setEndDate', $('.datetimepicker201').val());
  });

  /*$('.check_in').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
  }).on('changeDate', function(e){
      $('.check_out').datetimepicker('setStartDate', $('.check_in').val());
  });
  $('.check_out').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
  }).on('changeDate', function(e){
      // $('.check_in').datetimepicker('setEndDate', $('.check_out').val());
  });*/
});

  var sid = '<?php echo $sid; ?>';


  function book_now(){
   var user_id = '<?php echo $this->session->userdata('user_id'); ?>';

   if (user_id) {
     var check_in = $('#check_in').val();
     var check_out = $('#check_out').val();
     var child = $('#totalChild').val();
     var site_url = '<?php echo base_url('book-now'); ?>';
     var site_url_validate = '<?php echo base_url('booking/check_time'); ?>';
     var url = site_url+'?check_in='+check_in+'&check_out='+check_out+'&child='+child+'&sid='+sid;
     var validate_url = site_url_validate+'?check_in='+check_in+'&check_out='+check_out+'&child='+child+'&sid='+sid;
     // alert(url);return false;

     if (child && check_in && check_out) {
      $.getJSON(validate_url,function(response) {

          if (response.success) {
      		  window.location.href = url;
          } else {
            toastr.error(response.message);
          }
      });
     } else {
      toastr.error('Please select booking detail first.');
     }

   } else {

      var redirect_url = "<?php echo base64_encode('services/detail?sid='.$sid.'&check_in='.$check_in.'&check_out='.$check_in); ?>";
      var login_url = '<?php echo base_url('login?redirect='); ?>'+redirect_url;
      window.location.href = login_url;
   }

  }

  function datetimepicker()
  {
      var startdate = $('#check_in').val();
      var enddate = $('#check_out').val();

      // $("#check_in").datetimepicker('setEndDate', enddate);
      $("#check_out").datetimepicker('setStartDate', startdate);
  }
  $(document).ready(function(){
      datetimepicker();
  });
</script>
<script>
  function initMap() {
    var myLatLng = {lat: <?php echo $service_detail->latitude; ?>, lng: <?php echo $service_detail->longitude; ?>};

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 7,
      center: myLatLng
    });

    var marker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      title: '<?php echo $service_detail->daycare_address; ?>'
    });
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0GdI-2EuDg4ME6qo97nbhGR_O9CXnMhk&libraries=places&callback=initMap"></script>