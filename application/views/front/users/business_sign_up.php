<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <title>Daycareglobal</title>
      <link rel="icon" href="<?php echo $this->config->item('front_assets'); ?>images/favicon.png" type="image">
      <link rel="icon" href="<?php echo $this->config->item('front_assets'); ?>images/favicon.ico" type="image">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/bootstrap.min.css"/>
      <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/owl.carousel.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/style.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/media.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.css"/>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/jquery.min.js"></script>
   </head>
   <body>
      <section class="login-full-section list-your-daycare">
         <div class="login-header">
            <div class="">
               <a href="<?php echo base_url(); ?>">
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/logo.png" alt="logo">
               </a>
            </div>
         </div>
         <div class="login-box-cover">
            <div class="container">
               <form action="<?php echo current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" id="business_registration_form">
                  <div class="row justify-content-center">
                     <div class="col-md-6">
                        <div class="login-box">
                           <div class="login-heading">
                              <h1>List your daycare</h1>
                           </div>
                           <div class="form-group select-2-input">
                              <label>Select Your Business Type</label>
                               <select id="multiple" name="business_type_id[]" class="js-states form-control business_type_id" multiple>
                                 <option value="">Business Type</option>
                                 <?php if (!empty($business_types)) { foreach ($business_types as $key => $value) { ?>
                                    <option value="<?php echo $value->id; ?>" ><?php echo $value->name; ?></option>
                                 <?php } } ?>
                               </select>
                           </div>
                           <!-- <div class="form-group">
                              <label>Enter Your Business Type</label>
                              <input type="text" name="" class="form-control">
                           </div> -->
                           <div class="form-group">
                              <label>Business Name</label>
                              <input type="text" id="business_name" name="business_name" class="form-control">
                           </div>
                           <div class="form-group">
                              <label>Email</label>
                              <input type="text" id="email" name="email" class="form-control">
                           </div>
                           <div class="form-group">
                              <label>Mobile Number</label>
                              <input type="text" id="contact_number" name="contact_number" class="form-control">
                           </div>
                           <div class="form-group">
                              <label>Password</label>
                              <input type="password" name="password" class="form-control hide_password myPasswordInput" id="myPasswordInput001">
                              <div class="checkbox-custom">
                                <input type="checkbox" id="me" onclick="passwordShowHide()">
                                <label for="me">Show Password</label>
                              </div>
                            <!-- <input type="checkbox" onclick="passwordShowHide()">Show Password  -->
                           </div>

                           <div class="form-group">
                              <label>Confirm Password</label>
                              <input type="password" name="confirm_password" class="form-control myPasswordInput" id="myConfirmPasswordInput">
                              <div class="checkbox-custom">
                                <input type="checkbox" id="me0" onclick="confirmPasswordShowHide()">
                                <label for="me0">Show Password</label>
                              </div>
                            <!-- <input type="checkbox" onclick="confirmPasswordShowHide()">Show Password  -->
                           </div>

                           <div class="form-group mb-0">
                              <a href="javascript:void(0)" onclick="send_otp()" class="btn btn-primary w-100">Sign Up</a>
                           </div>
                           <!-- <div class="form-group or-box text-center mb-0">
                              <h4>OR</h4>
                           </div>
                           <div class="form-group mb-0">
                              <button class="btn btn-sm btn-border w-100">Request OTP</button>  
                           </div> -->
                           <div class="new-user-box text-center">
                              <a href="<?php echo base_url('login?cf=Business'); ?>">Already have an account? Login</a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 align-self-center none-991">
                        <div class="login-side-text">
                          <p>SignUp to get the best<br> daycare, play school <br> and playing arena for <br>your baby</p> 
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </section>
      <div class="modal fade otp-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
            <form action="<?php echo base_url('register/send_opt'); ?>" method="post" class="ajax_form" id="register_form_opt">
               <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLongTitle">Enter OTP</h5>
                 <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button> -->
               </div>
               <div class="modal-body">
                 <p class="mb-2">Check your mobile no. for the OTP</p>
                 <div class="form-group">
                   <input type="hidden" id="hidden_business_type_id" name="business_type_id">
                   <input type="hidden" id="hidden_business_name" name="business_name">
                   <input type="hidden" id="hidden_email" name="email">
                   <input type="hidden" id="hidden_contact_number" name="contact_number">
                   <input type="hidden" id="hidden_password" name="password">
                   <input type="text" name="otp" class="form-control" placeholder="One Time Password">
                 </div> 
               </div>
               <div class="modal-footer">
                 <button type="submit" class="btn btn-primary">submit</button>
               </div>
            </form>
             </div>
         </div>
      </div>


      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/bootstrap.min.js"></script>
      <script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/jquery.form.js" type="text/javascript"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/common.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/pagescript.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
      <script type="text/javascript">
          $("#multiple").select2({
             placeholder: "",
             allowClear: true
         });

        function passwordShowHide() {
          var x_pass = document.getElementById("myPasswordInput001");

           if (x_pass.type === "password") {
             x_pass.type = "text";
           } else {
             x_pass.type = "password";
           }
        }

        function confirmPasswordShowHide() {
          var y = document.getElementById("myConfirmPasswordInput");
           if (y.type === "password") {
             y.type = "text";
           } else {
             y.type = "password";
           }
        }

        function openOTPPopup()
        {
          $('#exampleModalCenter').modal('show');
          $('#hidden_business_type_id').val($('.business_type_id').val());
          $('#hidden_business_name').val($('#business_name').val());
          $('#hidden_email').val($('#email').val());
          $('#hidden_contact_number').val($('#contact_number').val());
          $('#hidden_password').val($('.hide_password').val());
        }

        function send_otp() {
          $( "#business_registration_form" ).submit();
        }
      </script>
   </body>
</html>


