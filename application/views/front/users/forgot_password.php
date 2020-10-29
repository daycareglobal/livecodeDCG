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
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/style.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/owl.carousel.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/media.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.css"/>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/jquery.min.js"></script>
   </head>
   <body>
      <section class="login-full-section">
         <div class="login-header">
            <div class="">
               <a href="<?php echo base_url(); ?>">
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/logo.png" alt="logo">
               </a>
            </div>
         </div>
         <div class="login-box-cover">
            <div class="container">
               <form action="<?php current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" id="forgot_password_form">
                  <div class="row justify-content-center">
                     <div class="col-md-6">
                        <div class="login-box">
                           <div class="login-heading">
                            <h1>Forgot Password!</h1>
                            <p>No worries, Fill the form to reset your password.</p>
                           </div>
                           <div class="form-group">
                              <label for="eaddress">Mobile Number</label>
                              <input id="eaddress" class="form-control mobile_number" name="mobile_number" type="text" />
                           </div>
                           <div class="form-group mb-0">
                              <a href="javascript:void(0)" onclick="send_otp()" class="btn btn-primary w-100">GET A NEW PASSWORD</a>
                              <!-- <button type="submit" class="btn btn-primary btn-space w-100">GET A NEW PASSWORD</button> -->
                           </div>
                           <div class="new-user-box text-center">
                              <a href="<?php echo base_url('login'); ?>">Login</a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 align-self-center none-991">
                        <div class="login-side-text">
                          <p>Login to get the best<br> daycare, play school <br> and playing arena for <br>your baby</p> 
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>

         <div class="modal fade otp-modal" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordTitle" aria-hidden="true">
           <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content">
              <form action="<?php echo base_url('users/password_reset_form'); ?>" method="post" class="ajax_form" id="reset_password_form">
                 <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">Enter OTP</h5>
                   <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                   </button> -->
                 </div>
                 <div class="modal-body">
                   <p class="mb-2">Check your mobile no. for the OTP</p>
                    <input type="hidden" id="hidden_mobile_number" name="mobile_number">
                   <div class="form-group">
                    <!-- <label for="eaddress">OTP</label> -->
                    <input type="text" name="otp" class="form-control" placeholder="One Time Password">
                   </div>
                   <div class="form-group">
                      <label for="eaddress">Password</label>
                      <input id="eaddress" class="form-control" name="password" type="password" />
                   </div>
                   <div class="form-group">
                      <label for="eaddress">Confirm Password</label>
                      <input id="eaddress" class="form-control" name="confirm_password" type="password" />
                   </div>
                 </div>
                 <div class="modal-footer">
                   <button type="submit" class="btn btn-primary">submit</button>
                 </div>
              </form>
               </div>
           </div>
        </div>
      </section>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/pagescript.js"></script>
      <script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/jquery.form.js" type="text/javascript"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.js"></script>
      <!-- <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/common.js"></script> -->
      <script type="text/javascript">
         function passwordShowHide() {
          var x = document.getElementById("myPasswordInput");
           if (x.type === "password") {
             x.type = "text";
           } else {
             x.type = "password";
           }
        }

        function openForgotPasswordPopup()
        {
          $('#forgotPassword').modal('show');
          $('#hidden_mobile_number').val($('.mobile_number').val());
        }

        function send_otp() {
          $( "#forgot_password_form" ).submit();
        }
      </script>
   </body>
</html>