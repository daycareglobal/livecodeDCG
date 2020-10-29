<section class="banner-section">
   <div class="banner-img"><img src="<?php echo $this->config->item('uploads').'static_pages/'.getHomePageOption('home-page-image', true); ?>"></div>
   <div class="banner-text text-center">
      <div class="container">
         <h1>Book a daycare for <br>your little one</h1>
         <div class="banner-search-mobile d-none">
            <button id="banner-search" class="btn-primary btn">search</button>
         </div>
         <div class="banner-search-box">
               <form class="ajax_form" action="<?php echo base_url('home/search'); ?>" method="post" id="search-form">
               <div class="row justify-content-center">   
                  <div class="col-md-6 col-lg-4">
                     <div class="form-group mb-0 text-left input-icon">
                        <label>Location</label>
                        <input type="text" name="address" id="autocomplete" class="form-control">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <span><i class="fas fa-map-marker-alt"></i></span>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-2">
                     <div class="form-group mb-0 text-left input-icon select">
                        <label>Services</label>
                        <select class="form-control" name="service_types">
                           <!-- <option value=""></option> -->

                           <?php if ($service_types && !empty($service_types)) { foreach ($service_types as $key => $value) { ?>
                              <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                           <?php } } ?>
                        </select>
                        <span><i class="fas fa-angle-down"></i></span>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-2">
                     <div class="form-group mb-0 text-left input-icon">
                        <label>Check In</label>
                        <input type="text" name="check_in" id="datetimepicker101" class="form-control datetimepicker1 datetimepicker101" placeholder="Select" autocomplete="off">
                        <span id="datetimepicker101" class="datetimepicker101"><i class="fas fa-calendar-alt datetimepicker1"></i></span>
                     </div>
                  </div>
                  <div class="col-md-6 col-lg-2">
                     <div class="form-group mb-0 text-left input-icon">
                        <label>Check Out</label>
                        <input type="text" name="check_out" id="datetimepicker201" class="form-control datetimepicker2 datetimepicker201" placeholder="Select" autocomplete="off">
                        <span id="datetimepicker201" class="datetimepicker201"><i class="fas fa-calendar-alt datetimepicker2"></i></span>
                     </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-lg-2">
                     <div class="custom-button">
                     	<label>&nbsp;</label>
                        <button class="btn btn-primary" type="submit">search</button>
                     </div>
                  </div>
               </div>
               <span id="search-close-btn" class="search-close d-none"><i class="fas fa-times"></i></span>
            </form>
         </div>
      </div>
   </div>
</section>
<section class="same-section pb-0 welcome-section">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-lg-6 align-self-center">
            <div class="same-text-box text-center mid-box">
               <h3>welcome to</h3>
               <h4>daycaregloble</h4>
               <p><?php echo getHomePageOption('welcome-to-daycareglobal', true) ?> </p>
               <!-- <button class="btn-primary btn">Dicover more</button> -->               
            </div>
         </div>
         <div class="col-md-12 col-lg-6">
            <div class="welcome-img-box">
               <?php
                  $welcome_daycare = getHomePageOption('welcome-to-daycareglobal', false);

                  if ($welcome_daycare && !empty($welcome_daycare->image)) {
               ?>
                  <img src="<?php echo $this->config->item('uploads').'static_pages/'.$welcome_daycare->image; ?>"/>

               <?php } else { ?>
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/child-img-1.jpg"/>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="same-section bg-blue blue-layer">
   <div class="container">
      <div class="same-text-box white text-center">
         <h4>How it works</h4>
      </div>
      <div class="row">
         <div class="col-md-6 col-lg-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('uploads'); ?>static_pages/icon-1.png">
               </div>
               <h4>Join the Network</h4>
               <p><?php echo getHomePageOption('join-the-network', true) ?></p>
            </div>
         </div>
         <div class="col-md-6 col-lg-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('uploads'); ?>static_pages/icon-2.png">
               </div>
               <h4>Find a daycare</h4>
               <p><?php echo getHomePageOption('find-a-daycare', true) ?></p>
            </div>
         </div>
         <div class="col-md-6 col-lg-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('uploads'); ?>static_pages/icon-3.png">
               </div>
               <h4>Lock in a date</h4>
               <p><?php echo getHomePageOption('lock-in-a-date', true) ?></p>
            </div>
         </div>
         <div class="col-md-6 col-lg-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('uploads'); ?>static_pages/icon-4.png">
               </div>
               <h4>Peace of mind</h4>
               <p><?php echo getHomePageOption('peace-of-mind', true) ?></p>
            </div>
         </div>
      </div>
      <div class="custom-button w-100 text-center mt-5 p-2">
         <a href="<?php echo base_url('sign-up'); ?>" class="btn btn-info">sign up for free</a>
      </div>
   </div>
</section>
<section class="same-section pb-0 total-place-section">
   <div class="container">
      <div class="same-text-box text-center">
         <h3>our values</h3>
         <h4>total peace of mind</h4>
      </div>
      <div class="row align-items-center">
         <div class="col-md-6 col-lg-4">
            <div class="place-ul right-side text-right">
               <ul>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4><?php echo $our_values_content[0]->title; ?></h4>
                     <p><?php echo $our_values_content[0]->value; ?></p>
                  </li>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4><?php echo $our_values_content[1]->title; ?></h4>
                     <p><?php echo $our_values_content[1]->value; ?></p>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-md-6 col-lg-4 none-991">
            <div class="total-place-img text-center">
               <img src="<?php echo $this->config->item('front_assets'); ?>images/child-img-2.jpg">
            </div>
         </div>
         <div class="col-md-6 col-lg-4">
            <div class="place-ul">
               <ul>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4><?php echo $our_values_content[2]->title; ?></h4>
                     <p><?php echo $our_values_content[2]->value; ?></p>
                  </li>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4><?php echo $our_values_content[3]->title; ?></h4>
                     <p><?php echo $our_values_content[3]->value; ?></p>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="same-section bg-gray clients-section">
   <div class="container">
      <div class="same-text-box mid-box text-center">
         <h3>testimonials</h3>
         <h4>what clients say</h4>
         <!-- <p class="pb-0">Curabitur pellentesque tempus nisi id rutrum. Aliquam nulla elit, aliquet sed placerat quis, </p> -->
      </div>
      <div class="review-box">
         <div class="row justify-content-center">
            <?php if (!empty($client_feedback)) { foreach ($client_feedback as $key => $value) {?>
               <div class="col-md-6 col-lg-5">
                  <div class="clients-review">
                     <p>“<?php echo $value->description; ?>”</p>
                  </div>
                  <div class="profile-img-box">
                     <span><a href="#"><img src="<?php echo $this->config->item('uploads').'profile_image'.'/'.$value->image; ?>"></a></span>
                     <h4><a href="#"><?php echo $value->title; ?></a></h4>
                  </div>
               </div>
            <?php } } ?>
         </div>
      </div>
   </div>
</section>
<section class="same-section">
   <div class="container">
      <div class="same-text-box text-center">
         <h3>quick, easy & Problem free</h3>
         <h4>we love parents, parents love us !</h4>
         <a href="<?php echo base_url('services'); ?>" class="btn btn-primary">Book A Childcare Center</a>
      </div>
   </div>
</section>
<script type="text/javascript">
/*$(function() {
  $('#datetimepicker101').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
   minView:1,
  });
  $('#datetimepicker201').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
   minView:1,
  });

});*/

$(function() {
  $('.datetimepicker101').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
  }).on('changeDate', function(e){
      $('.datetimepicker201').val('');
      var startTime = $('.datetimepicker101').val();
      // alert(startTime);
      $('.datetimepicker201').datetimepicker('setStartDate', $('.datetimepicker101').val());
  });
  $('.datetimepicker201').datetimepicker({
   startDate: new Date(),
   autoclose: true,
   format: "yyyy-mm-dd hh:ii",
  }).on('changeDate', function(e){
      // $('.datetimepicker101').datetimepicker('setEndDate', $('.datetimepicker201').val());
  });
});

</script>
<script type="text/javascript">
   function initAutocomplete() {
        var input = document.getElementById('autocomplete');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();
        });
   }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0GdI-2EuDg4ME6qo97nbhGR_O9CXnMhk&libraries=places&callback=initAutocomplete"
      async defer></script>

<script>
$(document).ready(function(){
  $("#banner-search").click(function(){
    $(".banner-search-box").addClass("active");
    $("body").addClass("overfloww-off");
  });
});

$(document).ready(function(){
  $("#search-close-btn").click(function(){
    $(".banner-search-box").removeClass("active");
    $("body").removeClass("overfloww-off");
  });
});
</script>