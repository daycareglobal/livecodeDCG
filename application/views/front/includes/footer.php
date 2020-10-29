<footer>
         <div class="footer-nav">
            <div class="container">
             <div class="row">
               <div class=" col-md-12 col-lg-3 align-self-center">
                 <div class="footer-logo text-left p-0">
                   <a href="#" class="logo">
                     <img src="<?php echo $this->config->item('front_assets'); ?>images/footer-logo.png" alt="images"/>
                   </a>
                 </div>
               </div>
               <div class=" col-md-4 col-lg-3 col-sm-4">
                 <div class="footer-nav-box">
                  <h4>Company</h4>
                   <ul>
                     <li><a href="<?php echo base_url('about-us'); ?>">About Us</a></li>
                     <li><a href="<?php echo base_url('privacy-policy'); ?>">Privacy Policy</a></li>
                     <li><a href="<?php echo base_url('terms-conditions'); ?>">Terms & Conditions</a></li>
                   </ul>
                 </div>
               </div>
               <div class=" col-md-4 col-lg-3 col-sm-4">
                 <div class="footer-nav-box">
                  <h4>Help</h4>
                   <ul>
                     <li><a href="<?php echo base_url('faq'); ?>">FAQ’s</a></li>
                     <li><a href="<?php echo base_url('contact-us'); ?>">Contact Us</a></li>
                   </ul>
                 </div>
               </div>
               <div class=" col-md-4 col-lg-3 col-sm-4">
                 <div class="footer-nav-box">
                  <h4>Get in touch</h4>
                   <ul class="inlie-nav">
                     <li><a target="_blank" href="<?php echo getSiteOption('facebook', true) ?>"><i class="fab fa-facebook-f"></i></a></li>
                     <li><a target="_blank" href="<?php echo getSiteOption('twitter', true) ?>"><i class="fab fa-twitter"></i></a></li>
                     <li><a target="_blank" href="<?php echo getSiteOption('instagram', true) ?>"><i class="fab fa-instagram"></i></a></li>
                   </ul>
                 </div>
               </div>
             </div>
            </div>
         </div>
         <div class="copy-right-section">
            <div class="container">
               <p><?php echo getSiteOption('copyright_text', true) ?></p>
            </div>
         </div>
      </footer>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/bootstrap.min.js"></script>
          <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script> -->
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>css/bootstrap-toastr/toastr.min.js"></script>
      <script src="<?php echo $this->config->item('admin_assets'); ?>global/scripts/jquery.form.js" type="text/javascript"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/common.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/pagescript.js"></script>
      <script type="text/javascript" src="<?php echo $this->config->item('front_assets'); ?>js/bootstrap-timepicker.js"></script>

      <script type="text/javascript">
        
        $(".time_inn").timepicker({
          autoclose: true,
          minuteStep: 5,
          secondStep: 5,
          showInputs: true,
          picDate: false,
          showMeridian: true,
          useCurrent: false
        });

        $('.datetimepicker').datetimepicker();

            /*$(".form_datetime").datetimepicker({
                format: "dd MM yyyy - hh:ii"
            });*/

      </script>
      <script>
      $(document).ready(function(){
        $(".toggle-button").click(function(){
          $(".nav-box-cover").addClass("open-nav");
          $(".body-layer").addClass("active");
          $("body").addClass("overfloww-off");
        });
      });
       $(document).ready(function(){
        $(".close-nav").click(function(){
          $(".nav-box-cover").removeClass("open-nav");
          $(".body-layer").removeClass("active");
          $("body").removeClass("overfloww-off");
        });
      });$(document).ready(function(){
        $(".body-layer").click(function(){
          $(".nav-box-cover").removeClass("open-nav");
          $(".body-layer").removeClass("active");
          $("body").removeClass("overfloww-off");
        });
      });
      </script>
      <script type="text/javascript">
        /* header-fix*/
          var headerheight = $('header').innerHeight();
          $(window).scroll(function(){
            var headerheight = $('header').innerHeight();
              if ($(window).scrollTop() >= 1) {
                 $('header.homepage').addClass('fix-header');
                 // $('body').css('padding-top', headerheight);
              }
              else {
                 $('header.homepage').removeClass('fix-header');
                 // $('body').css('padding-top', '0');
              }
          });
      </script>
   </body>
</html>