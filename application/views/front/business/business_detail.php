<section class="banner-section">
   <div class="banner-img"><img src="<?php echo $this->config->item('front_assets'); ?>images/search-details-banner.jpg"></div>
</section>
<section class="same-section bg-color">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <div class="page-heading">
          <h1><?php echo $business_list->daycare_name; ?></h1>
          <p><?php echo $business_list->daycare_address; ?></p>
          <p class="rating"><span>0<i class="fas fa-star"></i></span>(0 Rating)</p>
        </div>
        <div class="service-same-box service-ul">
          <h4>Services</h4>
          <ul>
            <?php if ($business_list->business_service_types && !empty($business_list->business_service_types)) { foreach ($business_list->business_service_types as $k => $v) { ?>
              <li><span><img src="<?php echo $this->config->item('uploads').'service_icons'.'/'.$v->icon; ?>"></span><?php echo $v->name; ?></li>
            <?php } } ?>
          </ul>
        </div>
        <div class="clearfix"></div>
        <div class="service-same-box">
          <h4>About Daycare</h4>
          <p><?php echo $business_list->about_daycare_center; ?></p>
          <div class="daycare-details">
            <div class="row">
              <div class="col-md-12 col-lg-3"><h3>Days of Operation</h3></div>
              <div class="col-md-12 col-lg-9">
                <!--<h5>Mon to Sat</h5>-->  
                <div class="search-open-details working_days">
                  <?php if(isset($business_list->business_service_days) && !empty($business_list->business_service_days)) { 
                    foreach ($business_list->business_service_days as $k => $val) { ?>
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
            <!-- <div class="row space-top">
              <div class="col-md-12 col-lg-3"><h3 class="">Hours of Operation</h3></div>
              <div class="col-md-12 col-lg-9"><h5>9AM to 8PM</h5></div>
            </div> -->
            <div class="row">
              <div class="col-md-12 col-lg-3"><h3>Age Accepted</h3></div>
              <div class="col-md-12 col-lg-9"><h5><?php echo $business_list->age_accepted; ?></h5></div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-3"><h3>Total Capacity</h3></div>
              <div class="col-md-12 col-lg-9"><h5><?php echo $business_list->total_capacity; ?></h5></div>
            </div>
          </div>
        </div>
      </div>
      <?php 
        $sid = (isset($_GET['sid'])) ? $_GET['sid'] : ''; 
      ?>
      <div class="col-md-12 col-lg-4">
        <div class="service-white-box">
          <div class="form-group input-icon">
             <label>Check In</label>
             <input type="text" id="check_in" name="" class="form-control check_in">
             <span class="check_in"><i class="fas fa-calendar-alt"></i></span>
          </div>
          <div class="form-group input-icon">
             <label>Check Out</label>
             <input type="text" name="" id="check_out" class="form-control check_out">
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
            <button onclick="book_now()" class="btn btn-primary w-100">book now</button>
           </div>
        </div>
        <div class="service-same-box">
          <h4>Location</h4>
          <div class="map-box" id="map">
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14198.046587873685!2d75.67899005!3d27.17165145!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c5535ac4f7915%3A0xf0d3e2b509ea8dec!2sBhardwaj%20Chikitsalaya%20Tankarda!5e0!3m2!1sen!2sin!4v1578740394341!5m2!1sen!2sin" frameborder="0" style="border:0;" allowfullscreen=""></iframe> -->

            <!-- <div id="map"></div>   -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- <section class="same-section">
  <div class="container">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
      Launch demo modal
    </button>

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#booking-summary">
      booking summary
    </button>
  </div>
</section> -->

<!-- Modal -->
<div class="modal fade booking-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="far fa-check-circle"></i></h2>
      </div>
      <div class="modal-body text-center">
        <h4>Booking ID-:1765</h4>
        <p>your booking has been confirmed</p>
        <div class="btn-custom">
          <button class="btn btn-primary">go home</button>
          <button class="btn btn-secondary">my booking</button>
        </div>
        <p>Go to <strong>My Booking</strong> Check your email for detalis</p>
      </div>
    </div>
  </div>
</div>

<!--  -->
<div class="modal fade booking-summary-box" id="booking-summary" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Booking Sumary</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="bookoing-summery">
          <h2>Booking Summary</h2>
          <h4>Poddar Daycare Center &amp; Play School</h4>
          <p>Jaipur, Rajasthan, India</p>
          <div class="cheak-in-box">
            <div class="row">
              <div class="col-md-6">
                <p>CHECK IN</p>
                <h3>Mon 11 May 2020</h3>
              </div>
              <div class="col-md-6">
                <p>CHECK IN TIME</p>
                <h3>11:50 AM</h3>
              </div>
              <div class="col-md-6">
                <p>CHECK OUT</p>
                <h3>Fri 12 Jun 2020</h3>
              </div>
              <div class="col-md-6">
                <p>CHECK OUT TIME</p>
                <h3>11:55 AM</h3>
              </div>
            </div>
            <div class="text-wall text-center">Daycare booked for<strong> 1 child</strong> for<strong>&nbsp;5 hours</strong></div>
            <h2>Payment details</h2>
            <div class="payment-details-box">
              <div class="row">
                <div class="col-md-8">
                  <h5>Booking Amount (₹50/hr* 5hr)</h5>
                  <!-- <h5 class="p-0">Coupon Discount (DCG First)</h5> -->
                </div>
                <div class="col-md-4 text-right">
                  <h5 class="p-0"><strong>₹19150</strong></h5>
                  <!-- <h5><strong>$250</strong></h5> -->
                </div>
              </div>
            </div>
          </div>
          <div class="payment-details-box">
            <div class="row">
              <div class="col-md-8">
                <h5>Payable Amount</h5>
                <h5>(Inclusive of all taxes)</h5>
              </div>
              <div class="col-md-4 text-right">
                <h5><strong>₹19150</strong></h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
            <button class="btn-primary btn">book now</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0GdI-2EuDg4ME6qo97nbhGR_O9CXnMhk&libraries=places&callback=initialize"
      async defer></script> -->

<script type="text/javascript">
  $(function() {
    $('.check_in').datetimepicker({
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
    });
  });
</script>
<script type="text/javascript">

  function book_now() {
    var user_id = '<?php echo $this->session->userdata('user_id'); ?>';

    if (user_id) {
      var sid = '<?php echo $sid; ?>';
      var check_in = $('#check_in').val();
      var check_out = $('#check_out').val();
      var child = $('#totalChild').val();
      var site_url = '<?php echo base_url('book-now'); ?>';
      var url = site_url+'?check_in='+check_in+'&check_out='+check_out+'&child='+child+'&sid='+sid;
      var site_url_validate = '<?php echo base_url('booking/check_time'); ?>';
      var validate_url = site_url_validate+'?check_in='+check_in+'&check_out='+check_out+'&child='+child+'&sid='+sid;

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

      var redirect_url = "<?php echo base64_encode('business/business-detail/'.$id.'?sid='.$sid); ?>";
      var login_url = '<?php echo base_url('login?redirect='); ?>'+redirect_url;
      // alert(login_url);
      window.location.href = login_url;
    }
  }

/*function initialize() {
   var lat_db = <?php echo $business_list->latitude; ?>;
   var lng_db = <?php echo $business_list->longitude; ?>;
   var latlng = new google.maps.LatLng(parseFloat(lat_db),parseFloat(lng_db));
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: false,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var infowindow = new google.maps.InfoWindow();   
    google.maps.event.addListener(marker, 'click', function() {
      var iwContent = '<div id="iw_container">' +
      '<div class="iw_title"><b>Location</b> : Noida</div></div>';
      // including content to the infowindow
      infowindow.setContent(iwContent);
      // opening the infowindow in the current map and at the current marker location
      infowindow.open(map, marker);
    });
}*/
// google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
  function initMap() {
    var myLatLng = {lat: <?php echo $business_list->latitude; ?>, lng: <?php echo $business_list->longitude; ?>};

    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 7,
      center: myLatLng
    });

    var marker = new google.maps.Marker({
      position: myLatLng,
      map: map,
      title: '<?php echo $business_list->daycare_address; ?>'
    });
  }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0GdI-2EuDg4ME6qo97nbhGR_O9CXnMhk&libraries=places&callback=initMap"></script>

