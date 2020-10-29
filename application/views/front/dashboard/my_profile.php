<section class="banner-section">
   <div class="banner-img"><img src="<?php echo $this->config->item('front_assets'); ?>images/search-details-banner.jpg"></div>
</section>
<section class="same-section bg-color">
  <div class="container">
    <div class="page-heading">
        <div class="col-md-12">
            <h1>personal info...</h1>
        </div>
    </div>
    <div class="vaneder-name-box mt-4">
      <div class="row">
        <div class="col-md-4">
          <div class="profile-box">
            <div class="profile-pic-box <?php if (!$user_record->profile_image) { echo "default-img"; } ?>">
              <div>
                <?php if ($user_record->profile_image) { ?>
                <img src="<?php echo base_url('assets/uploads/profile_image/'.$user_record->profile_image) ?>">
                <?php } else { ?>
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/default-img.png" alt="images">
                <?php } ?>
              </div>
                <!-- <input type="file" name="" id="profile-img">
                <label for="profile-img">
                  <span class="edit">
                    <i class="fas fa-pencil-alt"></i>
                  </span>
                </label> -->
            </div>
            <h4><?php echo $user_record->name.' '.$user_record->last_name; ?></h4>
          </div>
        </div>              
        <div class="col-md-8">
          <!-- <div class="profile-data-row pt-3">
            <div class="row">
              <div class="col-md-3">
                <h4>Business Type</h4>
              </div>
              <div class="col-md-9">
                <h4><strong>Business Type</strong></h4>
              </div>
            </div>
          </div> -->
           <div class="profile-data-row ">
            <div class="w-100 text-right mb-3">
              <a class=" btn btn-primary btn-sm" href="<?php echo base_url('update-profile') ?>">Edit</a>
            </div>
            <div class="row">
              <div class="col-md-3">
                <h4> Name</h4>
              </div>
              <div class="col-md-9">
                <h4><strong> <?php echo $user_record->name.' '.$user_record->last_name; ?></strong></h4>
              </div>
            </div>
          </div>
          <div class="profile-data-row ">
            <div class="row">
              <div class="col-md-3">
                <h4>Gender</h4>
              </div>
              <div class="col-md-9">
                <h4><strong><?php echo $user_record->gender; ?></strong></h4>
              </div>
            </div>
          </div>
          <div class="profile-data-row ">
            <div class="row">
              <div class="col-md-3">
                <h4>Email Address</h4>
              </div>
              <div class="col-md-9">
                <h4><strong><?php echo $user_record->email; ?></strong></h4>
              </div>
            </div>
          </div>
          <div class="profile-data-row ">
            <div class="row">
              <div class="col-md-3">
                <h4>Mobile Number</h4>
              </div>
              <div class="col-md-9">
                <h4><strong><?php echo $user_record->contact_number; ?></strong></h4>
              </div>
            </div>
          </div>
        </div>     
      </div>
    </div>
  </div>
</section>