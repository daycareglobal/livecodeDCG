<section class="same-section bg-color">
  <form action="<?php current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" id="business_service">
    <div class="container">
      <div class="page-heading">
          <h1>Vendor name</h1>
      </div>
      <div class="vaneder-name-box mt-4">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group input-icon select">
              <label>Business Category</label>
               <select class="form-control" name="business_type_id">
                  <option value="">Select Business Category</option>
                  
                  <?php if (!empty($business_types)) { foreach ($business_types as $key => $value) { ?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                  <?php } } ?>
               </select>
               <span><i class="fas fa-angle-down"></i></span>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Daycare Name</label>
              <input type="text" name="daycare_name" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Daycare Address</label>
              <input type="text" name="address" id="autocomplete" class="form-control">
              <input type="hidden" name="latitude" id="latitude" value="0.0">
              <input type="hidden" name="longitude" id="longitude" value="0.0">
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group input-icon select">
              <label>Hourly Charges</label>
              <input type="text" placeholder="₹" name="hourly_charges" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Monthly Charges</label>
              <input type="text" placeholder="₹" name="monthly_charges" class="form-control">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Daily Charges</label>
              <input type="text" placeholder="₹" name="daily_charges" class="form-control">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label>Age Accepted</label>
              <input type="text" name="age_accepted" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label>Total Capacity</label>
              <input type="text" name="total_capacity" class="form-control">
            </div>
          </div>

        </div>
      </div>
      <div class="vaneder-white-box">
        <div class="weekly-time-box">
          <h5>Kindly mention your weekly schedule here</h5>
          <div class="row">
            <div class="col-md-12 col-lg-6">
              <h4>Monday</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Opens at</label>
                    <input type="text" name="monday[open]" class="form-control outerborder time_inn start_time" placeholder="7:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Closes at</label>
                    <input type="text" name="monday[close]" class="form-control outerborder time_inn end_time" placeholder="8:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <h4>Tuesday</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Opens at</label>
                    <input type="text" name="tuesday[open]" class="form-control outerborder time_inn" placeholder="7:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Closes at</label>
                    <input type="text" name="tuesday[close]" class="form-control outerborder time_inn" placeholder="8:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <h4>Wednesday </h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Opens at</label>
                    <input type="text" name="wednesday[open]" class="form-control outerborder time_inn" placeholder="7:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Closes at</label>
                    <input type="text" name="wednesday[close]" class="form-control outerborder time_inn" placeholder="8:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <h4>Thrusday</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Opens at</label>
                    <input type="text" name="thrusday[open]" class="form-control outerborder time_inn" placeholder="7:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Closes at</label>
                    <input type="text" name="thrusday[close]" class="form-control outerborder time_inn" placeholder="8:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <h4>Friday</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Opens at</label>
                    <input type="text" name="friday[open]" class="form-control outerborder time_inn" placeholder="7:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Closes at</label>
                    <input type="text" name="friday[close]" class="form-control outerborder time_inn" placeholder="8:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <h4>Saturday</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Opens at</label>
                    <input type="text" name="saturday[open]" class="form-control outerborder time_inn" placeholder="7:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group input-icon">
                    <label>Daycare Closes at</label>
                    <input type="text" name="saturday[close]" class="form-control outerborder time_inn" placeholder="8:00 AM">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <h4>Sunday</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group input-icon holiday">
                    <label>Daycare Opens at</label>
                    <input type="text" name="sunday[open]" class="form-control outerborder time_inn" placeholder="Holiday">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group input-icon holiday">
                    <label>Daycare Closes at</label>
                    <input type="text" name="sunday[close]" class="form-control outerborder time_inn" placeholder="Holiday">
                    <span><i class="far fa-clock"></i></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="services-box">
          <h5>Services Provided</h5>
          <div class="radio-box">
            <?php if (!empty($service_types)) { foreach ($service_types as $key => $value) { ?>
              <div class="row">
                <div class="col-md-3"><h4><?php echo $value->name; ?></h4></div>
                <div class="col-md-9">
                  <ul>
                    <li>
                      <div class="checkbox-custom">
                        <input type="radio" name="service_types[<?php echo $value->id; ?>]" id="yes-<?php echo $key; ?>" value='Yes'>
                        <label for="yes-<?php echo $key; ?>"><span><i class="fas fa-check"></i></span>Yes</label>
                      </div>
                    </li>
                    <li>
                      <div class="checkbox-custom">
                        <input type="radio" name="service_types[<?php echo $value->id; ?>]" id="no-<?php echo $key; ?>" value='No'>
                        <label for="no-<?php echo $key; ?>"><span><i class="fas fa-check"></i></span>No</label>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            <?php } } ?>
            <!-- <div class="row">
              <div class="col-md-6">
                <button class="btn btn-border btn-sm w-100">Add More Rows For Services</button>
              </div>
            </div> -->
          </div>
          <h5>About Daycare Center </h5>
          <div class="form-group">
            <textarea name="about_daycare" class="form-control"></textarea>
          </div>
          <h5 class="mb-3">Daycare Images</h5>
          <div class="row">
            <div class="col-md-12">
              <div class="images-upload field">
                <input type="file" name="files[]" id="files" multiple="">
                <label for="files">
                  <div class="upload-img-box imagehide">
                    <img class="imagehide" src="<?php echo $this->config->item('front_assets'); ?>images/upload-img.png" alt="images">
                  </div>
                  <div class="custom-button w-100 text-center">
                    <button type="button" class="btn-primary btn" style="pointer-events: none;">Upload images</button>
                  </div>
                </label>
                <div class="img-upload-list">
                  <ul id="append_img">
                    
                  </ul>
                </div>
              </div>
            </div>
           
            <!-- <div class="col-md-7">
              <div class="slider-box-cover">
                <div class="slider-box">
                   <div id="demo" class="carousel slide" data-ride="carousel">
                      <div class="carousel-inner">
                        <div class="carousel-item active">
                          <img src="<?php echo $this->config->item('front_assets'); ?>images/slider-img-1.png" alt="Los Angeles">
                        </div>
                        <div class="carousel-item">
                          <img src="<?php echo $this->config->item('front_assets'); ?>images/slider-img-1.png" alt="Chicago">
                        </div>
                        <div class="carousel-item">
                          <img src="<?php echo $this->config->item('front_assets'); ?>images/slider-img-1.png" alt="New York" >
                        </div>
                        <div class="carousel-item">
                          <img src="<?php echo $this->config->item('front_assets'); ?>images/slider-img-1.png" alt="New York" >
                        </div>
                      </div>
                      <div class="carousel-control">
                        <a href="#demo" data-slide="prev">
                          <span><i class="fas fa-angle-left"></i></span>
                        </a>
                        <a  href="#demo" data-slide="next">
                          <span><i class="fas fa-angle-right"></i></span>
                        </a>
                      </div>
                    </div>
                </div>
                <div class="slider-btn mt-3 custom-button text-center">
                  <button class="btn-info btn btn-sm">make this image as profile photo</button>
                  <button class="btn-primary btn btn-sm">View image</button>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="form-group mb-0 w-100 text-center mt-3">
        <button type="submit" class="btn btn-primary text-center">Save</button>
      </div>
    </div>
  </form>
</section>
<style type="text/css">
  .forminput.outerborder{border: solid 1px #ccc; padding: 8px 10px; font-size: inherit; border-radius: 4px; padding-right: 20px;}
</style>
<script type="text/javascript">
  $(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          var append_html = "<li><span class=\"pip\">" +
            "<img  class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<span class=\"remove\"><i class=\"fas fa-times\"></i></span></span></li>";
          $('#append_img').append(append_html);
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
          });
          // $('.imagehide').hide();
          // Old code here
          /*$("<img></img>", {
            class: "imageThumb",
            src: e.target.result,
            title: file.name + " | Click to remove"
          }).insertAfter("#files").click(function(){$(this).remove();});*/
          
        });
        fileReader.readAsDataURL(f);
      }
    });
  } else {
    alert("Your browser doesn't support to File API")
  }
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