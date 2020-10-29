
<section class="same-section bg-color">
<div class="container">
  <form action="<?php current_url(); ?>" class="ajax_form" autocomplete="off" method="POST" id="business_service">
    <div class="row">
    <div class="col-md-7">
      <div class="page-heading">
        <h1>Your Booking</h1>
      </div>
      <div class="child-details-box">
        <h5>Child details</h5>
        <p>All Communication from DCG will be sent on the shared detail</p>
        <div class="row">
          <?php 
            $check_in = (isset($_GET['check_in'])) ? $_GET['check_in'] : '';
            $check_out = (isset($_GET['check_out'])) ? $_GET['check_out'] : ''; 
            $child = (isset($_GET['child'])) ? $_GET['child'] : ''; 
          ?>

          <div class="col-md-8">
            <div class="form-group">
              <label>Full Name</label>
              <input type="text" name="name" class="form-control">
              <input type="hidden" name="check_in" value="<?php echo $check_in; ?>">
              <input type="hidden" name="check_out" value="<?php echo $check_out; ?>">
              <input type="hidden" name="child" value="<?php echo $child; ?>">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label>Age</label>
              <input type="text" name="age" class="form-control">
            </div>
          </div>
        </div>
        <div class="form-group address-box">
          <label class="m-0">Address</label>
          <span>This address may be used in emergancy conditions. Make sure<br>it is absolutely correct.</span>
          <input type="text" name="address" class="form-control">
        </div>
        <h3 class="book-heading">Parents details</h3>
        <div class="form-group">
          <label>Parent’s Full Name</label>
          <input type="text" name="parent_name" class="form-control">
        </div>
        <div class="form-group">
          <label>Parent’s Mobile Number</label>
          <input type="text" name="parent_phone_number" class="form-control">
        </div>
        <div class="form-group">
          <label>Parent’s Email Address</label>
          <input type="text" name="parent_email_address" class="form-control">
        </div>
        <div class="form-group">
          <label>Emergancy Contact Number</label>
          <input type="text" name="emergancy_phone_number" class="form-control">
        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="book-now-dox">
        <div class="book-img"><img src="<?php echo $this->config->item('front_assets'); ?>images/book-img.png"></div>
        <div class="bookoing-summery">
          <h2>Booking Summary</h2>
          <h4><?php echo $business_list->daycare_name; ?></h4>
          <p><?php echo $business_list->daycare_address; ?></p>
          <div class="cheak-in-box">
            <div class="row">
              <div class="col-md-6">
                <p>CHECK IN</p>
                <h3><?php echo date('D d M Y', strtotime($check_in)) ?></h3>
              </div>
              <div class="col-md-6">
                <p>CHECK IN TIME</p>
                <h3><?php echo date('h:i A', strtotime($check_in)) ?></h3>
              </div>
              <div class="col-md-6">
                <p>CHECK OUT</p>
                <h3><?php echo date('D d M Y', strtotime($check_out)) ?></h3>
              </div>
              <div class="col-md-6">
                <p>CHECK OUT TIME</p>
                <h3><?php echo date('h:i A', strtotime($check_out)) ?></h3>
              </div>
            </div>
            <div class="text-wall text-center">Daycare booked for<strong> <?php echo $total_child; ?> child</strong> for<strong>&nbsp;<?php echo $total_hours; ?></strong></div>
            <h2>Payment details</h2>
            <div class="payment-details-box">
              <div class="row">
                <div class="col-md-8">
                  <h5>Booking Amount</h5>
                  <!-- <h5 class="p-0">Coupon Discount (DCG First)</h5> -->
                </div>
                <div class="col-md-4 text-right">
                  <h5 class="p-0"><strong>₹<?php echo $total_amout; ?></strong></h5>
                  <!-- <h5><strong>$250</strong></h5> -->
                </div>
              </div>
            </div>
          </div>
          <div class="payment-details-box">
            <div class="row">
              <div class="col-md-8">
                <h5>Payable Amount</h5>
                <h5>(Inclusive of all taxes)</h5>
              </div>
              <div class="col-md-4 text-right">
                <h5><strong>₹<?php echo $total_amout; ?></strong></h5>
              </div>
            </div>
          </div>
          <div class="custom-button w-100 mt-3">
            <button class="btn-primary btn w-100">book now</button>
          </div>
        </div>
      </div>
    </div>
    </div>
  </form>
</div>
</section>
