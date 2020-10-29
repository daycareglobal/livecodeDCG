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
               <form action="<?php echo current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" id="user_registration_form">
                  <div class="row justify-content-center">
                     <div class="col-md-6 col-lg-6">
                        <div class="login-box">
                           <div class="login-heading">
                              <h1>Sign Up</h1>
                           </div>
                           <div class="form-group">
                              <label>First Name</label>
                              <input type="text" id="first_name" name="first_name" class="form-control">
                           </div>

                           <div class="form-group">
                              <label>Last Name</label>
                              <input type="text" id="last_name" name="last_name" class="form-control">
                           </div>

                           <div class="form-group">
                              <label>Email Address</label>
                              <input type="text" id="email" name="email" class="form-control">
                           </div>

                           <div class="form-group">
                              <label>Mobile Number</label>
                              <input type="text" id="contact_number" name="contact_number" class="form-control">
                           </div>
                           <div class="form-group">
                              <label>Gender</label>
                              <div class="inline-checks">
                                 <ul>
                                    <li>
                                       <input id="radio19" class="md-radiobtn" type="radio" name="gender" value="Male" <?php echo ($gender == 'Male')?'checked':''; ?>>
                                       <label for="radio19">
                                       <span class="inc"></span>
                                       <span class="check"></span>
                                       <span class="box"></span>Male</label>
                                    </li>
                                    <li>
                                       <input id="radio20" class="md-radiobtn" type="radio" name="gender" value="Female" <?php echo ($gender == 'Female')?'checked':''; ?>>
                                    <label for="radio20">
                                    <span class="inc"></span>
                                    <span class="check"></span>
                                    <span class="box"></span>Female</label>
                                    </li>
                                 </ul>
                                 <!-- <div class="md-radio">
                                    

                                    
                                 </div> -->
                              </div>
                           </div>
                           <div class="form-group">
                              <label>Password</label>
                              <input type="password" id="password" name="password" class="form-control">
                              <div class="checkbox-custom">
                                <input type="checkbox" id="me" onclick="passwordShowHide()">
                                <label for="me">Show Password</label>
                              </div>
                           </div>
                           <div class="form-group mb-0">
                              <a href="javascript:void(0)" onclick="send_otp()" class="btn btn-primary w-100">Sign Up</a>
                              <!-- <button type="submit" class="btn btn-primary w-100">Sign Up</button> -->
                           </div>
                           <!-- <div class="form-group or-box text-center mb-0">
                              <h4>OR</h4>
                           </div>
                           <div class="form-group mb-0">
                              <button class="btn btn-sm btn-border w-100">Request OTP</button>  
                           </div> -->
                           <div class="new-user-box text-center">
                              <a href="<?php echo base_url('login'); ?>">Already have an account? Login</a>
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
         <div class="modal fade otp-modal" id="userOTPModal" tabindex="-1" role="dialog" aria-labelledby="userOTPModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
               <form action="<?php echo base_url('register/send_user_opt'); ?>" method="post" class="ajax_form" id="register_form_opt">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Enter OTP</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button> -->
                  </div>
                  <div class="modal-body">
                    <p class="mb-2">Check your mobile no. for the OTP</p>
                    <div class="form-group">
                      <input type="hidden" id="hidden_first_name" name="first_name">
                      <input type="hidden" id="hidden_last_name" name="last_name">
                      <input type="hidden" id="hidden_email" name="email">
                      <input type="hidden" id="hidden_contact_number" name="contact_number">
                      <input type="hidden" id="hidden_gender" name="gender">
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
      </section>
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

         function openUserOTPPopup()
         {
            $('#userOTPModal').modal('show');
            $('#hidden_first_name').val($('#first_name').val());
            $('#hidden_last_name').val($('#last_name').val());
            $('#hidden_email').val($('#email').val());
            $('#hidden_contact_number').val($('#contact_number').val());
            $('#hidden_gender').val($("input[name='gender']:checked").val());
            $('#hidden_password').val($('#password').val());
         }

         function send_otp() {
            $( "#user_registration_form" ).submit();
         }

         function passwordShowHide() {
          var x_pass = document.getElementById("password");

           if (x_pass.type === "password") {
             x_pass.type = "text";
           } else {
             x_pass.type = "password";
           }
        }
      </script>
   </body>
</html>