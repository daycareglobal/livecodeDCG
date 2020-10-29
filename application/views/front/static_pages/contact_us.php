<!-- <section class="contactus_pagemain full_wrapper padding_bottom padding_top">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contactPTitle">
            <h1 class="innerpagemaintitle"><?php echo $record->title; ?></h1>
          </div>
        </div>
        <div class="col-md-7 float-right-tab">
          <div class="contact_overleft">
            <div class="contact_overtop">
              <form action="<?php echo current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" >              
                <div class="contact_leftSide">
                    <div class="formside_helf">
                      <div class="form-group">
                        <label class="form-label" for="cfirst">First Name</label>
                        <input id="cfirst" class="form-inputt" name="first_name" type="text" />
                      </div>
                    </div>            
                    <div class="formside_helf">
                      <div class="form-group">
                        <label class="form-label" for="clast">Last Name</label>
                        <input id="clast" class="form-inputt" name="last_name" type="text" />
                      </div>
                    </div>           
                    <div class="formside_full">
                      <div class="form-group">
                        <label class="form-label" for="cemail">Email Address</label>
                        <input id="cemail" class="form-inputt" name="email" type="text" />
                      </div>
                    </div>           
                    <div class="formside_full">
                      <div class="form-group">
                        <label class="form-label" for="cnumber">Enter Phone Number (optional)</label>
                        <input id="cnumber" class="form-inputt" name="phone_number" type="text" />
                      </div>
                    </div>

                    <div class="formside_full">
                      <div class="form-group focused">
                          <label class="form-label" for="cnumber">I am</label>

                          <div class="gender_lists list_iam">
                            <div class="lisiting_genral_checklist ch_providrs">
                              <ul class="list">                            
                                <li class="list__item">
                                  <div class="list-radio-box">
                                    <input type="radio" id="aparent_choose" name="user_type" value="Parent" checked="">
                                    <label for="aparent_choose" class="label">A Parent</label>
                                  </div>
                                </li>
                                <li class="list__item">
                                  <div class="list-radio-box">
                                    <input type="radio" id="aprovider_choose" name="user_type" value="Provider">
                                    <label for="aprovider_choose" class="label">A Provider</label>
                                  </div>
                                </li>
                              </ul>
                            </div>

                          </div>
                        </div>
                    </div>

                    <div class="formside_full">
                      <div class="form-group">
                        <label class="form-label" for="cmessage">Your Message</label>
                        <textarea id="cmessage" name="message" class="form-inputt"></textarea>
                      </div>
                    </div>
                </div>
                <div class="contact_bottombutt">
                  <button type="submit" class="btn btn-primary" id="click_mess">Send Message</button>
                </div>
              </form>
            </div>
            <div class="contact_submit_message">
              <img src="<?php echo $this->config->item('front_assets'); ?>images/envelope.svg" alt="icon"/>
              <h4>Thank you for contacting us.</h4>
              <h6>A member from our team will be in touch with you shortly.</h6>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="col-md-5 float-left-tab">
          <div class="contactP_rightside">
             <h5>Please read our</h5>
            <span class="contactlablered">Frequently Asked Questions</span>
            <?php echo $record->description; ?>
            <div class="contactimgSide">
              <img src="<?php echo $this->config->item('front_assets'); ?>images/babyimg.png"/>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>--><!-- END homehead banner -->
<section class="banner-section">
  <div class="banner-img"><img src="<?php echo $this->config->item('front_assets'); ?>images/banner-img.jpg"></div>
</section>
<section class="same-section bg-color">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="page-heading">
          <h1>Contact Us</h1>
          <p>Near Jimmy Towers, Kopar Khairane, Navi Mumbai</p>
        </div>
        <form action="<?php echo current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" >
          <div class="content-box">
            <div class="form-group">
              <label>Name</label>
              <input type="text" name="first_name" class="form-control">
            </div>
            <div class="form-group">
              <label>Surname</label>
              <input type="text" name="last_name" class="form-control">
            </div>
            <div class="form-group">
              <label>Email Address</label>
              <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group">
              <label>Message</label>
              <textarea name="message" class="form-control"></textarea>
            </div>
            <div class="form-group mb-0">
              <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-md-4">
        <div class="content-box-img">
          <h4>Get in touch</h4>
          <div class="cont_info">
            <ul>
            <li><i class="fas fa-map-marker-alt"></i> <span><?php echo getSiteOption('contact_address', true) ?></span></li>
            <li><i class="fas fa-envelope"></i> <span><a href="mailto:<?php echo getSiteOption('contact_email', true) ?>"><?php echo getSiteOption('contact_email', true) ?></a></span></li>
            <li><i class="fas fa-phone"></i> <span><a href="tel:6546521"><?php echo getSiteOption('contact_phone', true) ?></a></span></li>
         </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>