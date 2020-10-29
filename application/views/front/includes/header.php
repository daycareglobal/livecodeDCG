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
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/owl.carousel.min.css"/>
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/style.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/media.css">
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
      <link rel="stylesheet" type="text/css" href="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/moment.min.js"></script>
      <script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
      <script src="<?php echo $this->config->item('admin_assets'); ?>global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
   </head>
   <body >
      <header class="<?php if (isset($extra_class)) { echo $extra_class; } ?>">
         <div class="row align-items-center m-0">
            <div class="col logo-width p-0">
               <div class="logo-box">
                  <a href="<?php echo base_url(); ?>">
                  <img src="<?php echo $this->config->item('front_assets'); ?>images/logo.png" alt="logo"/>
                  </a>
               </div>
            </div>
            <div class="col p-0 text-right">
               <div class="toggle-button d-none">
                  <button><i class="fas fa-bars"></i></button>
               </div>
               <div class="body-layer"></div>
               <div class="nav-box-cover">
                  <button class="close-nav"><i class="fas fa-times"></i></button>
                  <div class="nav-box">
                     <ul>                           
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>

                        <?php if ($this->session->userdata('user_type') == 'User' || empty($this->session->userdata('user_type'))) { ?>
                           <li><a class="<?php if (isset($_GET['business-type'])) { echo ($_GET['business-type'] == 'daycare') ? 'active' : ''; } ?>" href="<?php echo base_url('business?business-type=daycare'); ?>">Daycare</a></li>
                           <li><a class="<?php if (isset($_GET['business-type'])) { echo ($_GET['business-type'] == 'play-school') ? 'active' : ''; }  ?>" href="<?php echo base_url('business?business-type=play-school'); ?>">Play School </a></li>
                           <li><a class="<?php if (isset($_GET['business-type'])) { echo ($_GET['business-type'] == 'playing-arena') ? 'active' : ''; } ?>" href="<?php echo base_url('business?business-type=playing-arena'); ?>">Playing Arena</a></li>
                        <?php } ?>

                        <?php if ($this->session->userdata('user_type') == 'Business') { ?>
                           <li><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>
                           <li><a href="<?php echo base_url('bookings'); ?>">Bookings</a></li>

                        <?php } else { ?>

                           <?php if ($this->session->userdata('user_id')) { ?>
                              <li><a href="<?php echo base_url('my-profile'); ?>">My Profile</a></li>
                              <li><a href="<?php echo base_url('booking-history'); ?>">Bookings</a></li>
                           <?php } ?>
                        <?php }  ?>
                     </ul>
                  </div>
                  <div class="icon-box">
                     <a href="#" class="phone-icon"><img src="<?php echo $this->config->item('front_assets'); ?>images/phone-icon.png"><span><?php echo getSiteOption('contact_phone', true) ?></span></a>
                     <div class="custom-button">
                        <?php if (!$this->session->userdata('user_id')) { ?>
                           <a href="<?php echo base_url('login'); ?>" class="btn btn-info">Log in/sign up</a>
                           <a href="<?php echo base_url('business-sign-up'); ?>" class="btn btn-primary">business account</a>
                        <?php } else { ?>
                           <a href="<?php echo base_url('logout'); ?>" class="btn btn-primary">Logout</a>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>   
      </header>