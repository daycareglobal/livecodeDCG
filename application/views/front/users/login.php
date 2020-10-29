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
               <form action="<?php current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" id="login_form">
                  <div class="row justify-content-center">
                     <div class="col-md-6 col-lg-6">
                        <div class="login-box">
                           <div class="login-heading">
                              <h1>Welcome Back</h1>
                              <p>To keep connected with us please login with your personal information</p>
                           </div>
                           <div class="form-group">
                              <label>Email Address / Mobile Number</label>
                              <input type="text" name="email" class="form-control">
                           </div>
                           <div class="form-group">
                              <label>Password</label>
                              <input type="password" name="password" class="form-control" id="myPasswordInput">
                           </div>
                           <div class="row">
                            <div class="col-6">
                              <div class="checkbox-custom mt-0">
                                <input type="checkbox" id="me" onclick="passwordShowHide()">
                                <label for="me">Show Password</label>
                              </div>
                            </div>
                            <div class="col-6">
                             <div class="w-100 forgot-box text-right">
                                <a href="<?php echo base_url('forgot-password'); ?>">Forgot Password ?</a>
                             </div>
                            </div>
                           </div>
                           <div class="form-group mb-0">
                              <button type="submit" class="btn btn-primary w-100">Login</button>
                           </div>
                              <!-- <button  class="btn btn-primary w-100"  data-toggle="modal" data-target="#exampleModalCenter">send-otp</button> -->
                           <div class="new-user-box text-center">
                            <?php if ($_GET && isset($_GET['cf']) && $_GET['cf'] == "Business") { ?>
                                  <a href="<?php echo base_url('business-sign-up') ?>">New to DCG? Create an Account</a>
                              <?php } else { ?>
                                  <a href="<?php echo base_url('sign-up') ?>">New to DCG? Create an Account</a>
                              <?php } ?>
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
      </section>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/pagescript.js"></script>
      <script type="text/javascript">
         function passwordShowHide() {
          var x = document.getElementById("myPasswordInput");
           if (x.type === "password") {
             x.type = "text";
           } else {
             x.type = "password";
           }
        }
      </script>
      <!-- Button trigger modal -->
   </body>
</html>