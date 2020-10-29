<section class="banner-section">
   <div class="banner-img"><img src="<?php echo $this->config->item('front_assets'); ?>images/banner-img.jpg"></div>
   <div class="banner-text text-center">
      <div class="container">
         <h1>Book a daycare for <br>your little one</h1>
         <div class="banner-search-box">
            <div class="row ">
               <div class="col-md-2">
                  <div class="form-group mb-0 text-left input-icon">
                     <label>Location</label>
                     <input type="text" name="address" id="autocomplete" class="form-control">
                     <input type="hidden" name="latitude" id="latitude">
                     <input type="hidden" name="longitude" id="longitude">
                     <span><i class="fas fa-map-marker-alt"></i></span>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="form-group mb-0 text-left input-icon select">
                     <label>Services</label>
                     <select class="form-control" name="service_types">
                        <option>Select service</option>

                        <?php if ($service_types && !empty($service_types)) { foreach ($service_types as $key => $value) { ?>
                           <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                        <?php } } ?>
                     </select>
                     <span><i class="fas fa-angle-down"></i></span>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group mb-0 text-left input-icon">
                     <label>Check In</label>
                     <input type="text" name="checkInDate" class="form-control form_datetime" placeholder="7 OCT 2019, 11:30 AM">
                     <span><i class="fas fa-calendar-alt"></i></span>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group mb-0 text-left input-icon">
                     <label>Check Out</label>
                     <input type="text" name="" class="form-control" placeholder="7 OCT 2019, 11:30 AM">
                     <span><i class="fas fa-calendar-alt"></i></span>
                  </div>
               </div>
               <div class="col-md-2">
                  <div class="custom-button">
                  	<label>&nbsp;</label>
                     <button class="btn btn-primary">search</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="same-section pb-0 welcome-section">
   <div class="container">
      <div class="row">
         <div class="col-md-6 align-self-center">
            <div class="same-text-box text-center mid-box">
               <h3>welcome to</h3>
               <h4>daycaregloble</h4>
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi eu mauris eget magna iaculis maximus id sed justo. 
               Fusce et dolor maximus augue vehicula tincidunt. Suspendisse a nisl ac ex aliquam porta. Integer eu ultrices massa, 
               fringilla tempus risus. </p>
               <button class="btn-primary btn">Dicover more</button>
            </div>
         </div>
         <div class="col-md-6">
            <div class="welcome-img-box">
               <img src="<?php echo $this->config->item('front_assets'); ?>images/child-img-1.jpg"/>
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
         <div class="col-md-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/icon-1.png">
               </div>
               <h4>Join the Network</h4>
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In at justo sed nunc</p>
            </div>
         </div>
         <div class="col-md-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/icon-2.png">
               </div>
               <h4>Find a daycare</h4>
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In at justo sed nunc</p>
            </div>
         </div>
         <div class="col-md-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/icon-2.png">
               </div>
               <h4>Lock in a date</h4>
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In at justo sed nunc</p>
            </div>
         </div>
         <div class="col-md-3">
            <div class="how-i-icon-box text-center">
               <div class="icon">
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/icon-2.png">
               </div>
               <h4>peace of mind</h4>
               <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In at justo sed nunc</p>
            </div>
         </div>
      </div>
      <div class="custom-button w-100 text-center mt-5 p-2">
         <button class="btn btn-info">sign up for free</button>
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
         <div class="col-md-4">
            <div class="place-ul right-side text-right">
               <ul>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4>Dolar sit amet</h4>
                     <p>Integer blandit risus ac turpis <br>efficitur, rutrum lacinia </p>
                  </li>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4>Last-minute request</h4>
                     <p>Integer blandit risus ac turpis <br>efficitur, rutrum lacinia </p>
                  </li>
               </ul>
            </div>
         </div>
         <div class="col-md-4">
            <div class="total-place-img text-center">
               <img src="<?php echo $this->config->item('front_assets'); ?>images/child-img-2.jpg">
            </div>
         </div>
         <div class="col-md-4">
            <div class="place-ul">
               <ul>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4>Lorem Ipsum dolar</h4>
                     <p>Integer blandit risus ac turpis <br>efficitur, rutrum lacinia </p>
                  </li>
                  <li>
                     <span><img src="<?php echo $this->config->item('front_assets'); ?>images/cheak-icon.png"></span>
                     <h4>All ages childcare</h4>
                     <p>Integer blandit risus ac turpis <br>efficitur, rutrum lacinia </p>
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
         <p class="pb-0">Curabitur pellentesque tempus nisi id rutrum. Aliquam nulla elit, aliquet sed placerat quis, </p>
      </div>
      <div class="review-box">
         <div class="row justify-content-center">
            <?php if (!empty($client_feedback)) { foreach ($client_feedback as $key => $value) {?>
               <div class="col-md-5">
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
         <button class="btn btn-primary">book A daycare</button>
      </div>
   </div>
</section>
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxhgcC9Un6YMIVL5agYr7ygNvQMt306Nc&libraries=places&callback=initAutocomplete"
      async defer></script>