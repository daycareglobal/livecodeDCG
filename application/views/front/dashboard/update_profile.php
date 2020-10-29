<section class="same-section bg-color">
  <form action="<?php current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" id="business_service">
    <div class="container">
      <div class="page-heading">
          <h1>Edit Profile</h1>
      </div>
      <div class="vaneder-name-box mt-4">
        <div class="row">
          <div class="col-md-4">
            <div class="profile-box">
            <div class="profile-pic-box">
              <div>
                  <?php if ($user_detail->profile_image) { ?>
                    <img src="<?php echo base_url('assets/uploads/profile_image/'.$user_detail->profile_image) ?>">
                  <?php } else { ?>
                      <img src="<?php echo $this->config->item('front_assets'); ?>images/default-img.png" alt="images">
                  <?php } ?>
              </div>
                <input type="file" name="profile_image" id="profile-img">
                <label for="profile-img">
                  <span class="edit">
                    <i class="fas fa-pencil-alt"></i>
                  </span>
                </label>
            </div>
            <h4 class="image-name"></h4>
          </div>
          </div>
          <div class="col-md-8">
            <div class="row">

              <!-- <div class="col-md-4">
                <div class="form-group">
                  <label>Profile Image</label>
                  <div class="img-upload-box">
                    <input type="file" name="profile_image" id="upload">
                    <label class="btn btn-primary mb-0" for="upload">upload</label>
                    <p>default-img.png</p>
                  </div>
                  <input type="file" name="profile_image" class="form-control">
                </div>

                <div class="form-group">

                  <?php if ($user_detail->profile_image) { ?>
                    <img src="<?php echo base_url('assets/uploads/profile_image/'.$user_detail->profile_image) ?>">
                    <?php } else { ?>
                      <img src="<?php echo $this->config->item('front_assets'); ?>images/default-img.png" alt="images">
                    <?php } ?>

                </div>
              </div> -->

              <div class="col-md-4">
                <div class="form-group">
                  <label>First Name</label>
                  <?php $name = (isset($user_detail->name)) ? $user_detail->name : '' ?>
                  <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Last Name</label>
                  <?php $last_name = (isset($user_detail->last_name)) ? $user_detail->last_name : '' ?>
                  <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Email</label>
                  <?php $email = (isset($user_detail->email)) ? $user_detail->email : '' ?>

                  <input type="text" name="email" id="autocomplete" class="form-control" value="<?php echo $email; ?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Mobile Number</label>
                  <?php $contact_number = (isset($user_detail->contact_number)) ? $user_detail->contact_number : '' ?>

                  <input type="text" name="contact_number" class="form-control" value="<?php echo $contact_number; ?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Password</label>

                  <input type="password" name="password" id="password" class="form-control">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label>Confirm password</label>

                  <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                </div>
              </div>
             
            </div>
              <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary w-100 text-center">Save</button>
              </div>
          </div>
        </div>
      </div>
  </form>
</section>
<script type="text/javascript">
    $(document).ready(function(){

      $('input[type="file"]').change(function(e){
          var fileName = e.target.files[0].name;
          $('.image-name').text(fileName);
      });

  });
</script>
