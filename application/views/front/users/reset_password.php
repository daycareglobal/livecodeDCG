<!DOCTYPE html>
<html lang="en-US" prefix="og: http://ogp.me/ns#">
<head>
<title>Daycareglobal</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<link rel="shortcut icon" type="image/png" href="<<!DOCTYPE html>
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
                  <div class="row">
                     <div class="col-md-6">
                        <div class="login-box">
                           <div class="login-heading">
                            <h1>Reset Password!</h1>
                            <p>Enter Your new credential for future login.</p>
                           </div>
                           <div class="form-group">
                              <label for="password_form">New Password</label>
                              <input class="form-control" name="new_password" type="password" id="myPasswordInput" />
                              <input type="checkbox" onclick="passwordShowHide()">Show Password
                           </div>

                           <div class="form-group">
                              <label for="password_form">Confirm Password</label>
                              <input class="form-control" name="confirm_password" type="password" id="myConfirmPasswordInput" />
                              <input type="checkbox" onclick="confirmPasswordShowHide()">Show Password 
                           </div>

                           <div class="form-group mb-0">
                              <button type="submit" class="btn btn-primary">Save</button>
                           </div>
                           <div class="new-user-box text-center">
                              <a href="<?php echo base_url('login'); ?>">Login</a>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 align-self-center">
                        <div class="login-side-text">
                          <p>Reset password</p> 
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </section>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/bootstrap.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/pagescript.js"></script>
      <script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/jquery.form.js" type="text/javascript"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/common.js"></script>
      <script type="text/javascript">
        function passwordShowHide() {
          var x = document.getElementById("myPasswordInput");
           if (x.type === "password") {
             x.type = "text";
           } else {
             x.type = "password";
           }
        }

        function confirmPasswordShowHide() {
          var x = document.getElementById("myConfirmPasswordInput");
           if (x.type === "password") {
             x.type = "text";
           } else {
             x.type = "password";
           }
        }
      </script>
   </body>
</html>?php echo $this->config->item('front_assets'); ?>images/favicon.ico"/>
<link rel="shortcut icon" type="image/png" href="<?php echo $this->config->item('front_assets'); ?>images/favicon.png"/>

<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/bootstrap.min.css"/> 
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/owl.theme.default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/owl.carousel.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/aos.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/headermenu.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/style.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/media.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>fonts/fontstyles.css"/>
<link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome-animation/0.2.1/font-awesome-animation.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800" rel="stylesheet">
<script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/jquery.min.js"></script>

</head>
<body>

<header class="header_main full_wrapper innerPage_Header bordernoneb centerlogos">
  <div class="header_inn">
    <div class="left_logoside">
      <a href="<?php echo base_url(); ?>">
         <img src="<?php echo $this->config->item('front_assets'); ?>images/logo.png"/>
      </a>
    </div>
    <!-- <div class="headermenuRight">
      <div class="userloginside">
        <div class="imagesHuser">
          <img src="<?php echo $this->config->item('front_assets'); ?>images/userlogin.jpg"/>
        </div>
        <div class="headermenus">        
          <div id="navbar">
            <nav class="navbar navbar-default navbar-static-top" role="navigation">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
              </div>
              <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                  <li class="dropdown mainli">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Start Quote <span class="headerdropangle"><i class="fas fa-angle-down"></i></span></a> 
                    <ul class="dropdown-menu">
                      <li><a href="#">Privacy Policy</a></li>
                      <li class="active"><a href="#">Terms & Conditions</a></li>
                      <li><a href="#">FAQ’s</a></li>
                      <li><a href="#">Contact Us</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </div>      
        </div>
        <div class="header_contacts">
          <ul>
            <li><a href="#"><img src="<?php echo $this->config->item('front_assets'); ?>images/call.png"/>&nbsp; +91 0123 4567 98</a></li>
            <li><a href="#"><img src="<?php echo $this->config->item('front_assets'); ?>images/mail.png"/>&nbsp; demo@gmail.com</a></li>
          </ul>
        </div>
      </div>
    </div> --><!-- END right -->
  </div>
</header>
<section class="contactus_pagemain full_wrapper padding_bottom padding_top">
    <div class="container">
      <div class="row">
        <div class="loginpage_perent">
          <div class="col-sm-12 col-md-6">
            <form action="<?php echo current_url(); ?>" class="ajax_form" autocomplete="on" method="POST" >           
              <h1 class="innerpagemaintitle">Reset Password!</h1>
              <p class="loginsubtitle">Enter Your new credential for future login.</p>
              <div class="loginpageSide">
                <div class="formside_full">
                  <div class="form-group">
                    <label class="form-label" for="password_form">New Password</label>
                    <input id="password_form" class="form-inputt" name="new_password" type="password" />
                  </div>
                </div>
                <div class="formside_full">
                  <div class="form-group">
                    <label class="form-label" for="password_form">Confirm Password</label>
                    <input id="password_form" class="form-inputt" name="confirm_password" type="password" />
                  </div>
                </div>
              </div>
              <div class="contact_bottombutt">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <div class="col-sm-12 col-md-6">
            <div class="Login_contactimgSide">
              <img src="<?php echo $this->config->item('front_assets'); ?>images/loginbaby.jpg"/>
            </div>
          </div>
        </div>
      </div>
    </div>
</section><!-- END homehead banner -->