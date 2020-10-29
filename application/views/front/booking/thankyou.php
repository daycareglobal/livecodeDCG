<section class="same-section bg-color">
<div class="container">
  <h1>Thank you</h1>
  <p>Your booking has been placed successfully.</p>
</div>
</section>
<div class="modal fade booking-modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2><i class="far fa-check-circle"></i></h2>
      </div>
      <div class="modal-body text-center">
        <h4>Booking ID-:<?php echo $booking_id; ?></h4>
        <p>your booking has been confirmed</p>
        <div class="btn-custom">
          <a class="btn btn-primary" href="<?php echo base_url('');?>">go home</a>
          <button class="btn btn-secondary">my booking</button>
        </div>
        <p>Go to <strong>My Booking</strong> Check your email for detalis</p>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function(){
    $('.booking-modal').modal('show');
  })
</script>
