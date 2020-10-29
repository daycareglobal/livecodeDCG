      <section class="same-section bg-color">
         <div class="container">
            <div class="page-heading mb-4">
              <h1>Booking History</h1>
            </div>
            <div class="tabel-overlay">
               <div class="table-box">
                  <table width="100%" cellpadding="0" cellspacing="0" class="tabel table-bordered">
                     <tr>
                        <th>Booking Id</th>
                        <th>Name & Age</th>
                        <th>School Name</th>
                        <th>Check-In Time</th>
                        <th>Check-Out Time</th>
                        <th>Detail</th>
                     </tr>

                     <?php if ($booking_list && !empty($booking_list)) { foreach ($booking_list as $key => $value) { ?>
                           <tr>
                              <td><?php echo "DCG-MH-".$value->id; ?></td>
                              <td><?php echo $value->name.' ('.$value->age.')'; ?></td>
                              <td><?php echo $value->daycare_name; ?></td>
                              <td><?php echo date('D d M Y h:i A', strtotime($value->check_in)); ?></td>
                              <td><?php echo date('D d M Y h:i A', strtotime($value->check_out)); ?></td>
                              <td><a href="javascript:void(0);" onclick="booking_detail(this)" data-daycareName="<?php echo $value->daycare_name; ?>" data-daycareaddress="<?php echo $value->daycare_address; ?>" data-checkIn="<?php echo date('D d M Y', strtotime($value->check_in)); ?>" data-checkOut="<?php echo date('D d M Y', strtotime($value->check_out)); ?>" data-checkInTime="<?php echo date('h:i A', strtotime($value->check_in)); ?>" data-checkOutTime="<?php echo date('h:i A', strtotime($value->check_out)); ?>" data-total_house_string="<?php echo $value->total_house_string; ?>" data-child="<?php echo $value->child; ?>" data-total_amount="<?php echo $value->total_amount; ?>" >View</a></td>
                           </tr>
                        <?php } ?>
                     <?php } else { ?>
                          <tr>
                            <td colspan="6"><center>No record available!!!</center></td>
                          </tr>
                     <?php } ?>
                  </table>
               </div>
            </div>
         </div>
      </section>

<div class="modal fade booking-summary-box" id="booking-summary" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Booking Sumary</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="bookoing-summery">
          <h2>Booking Summary</h2>
          <h4 class="daycare_name"></h4>
          <p class="daycareaddress"></p>
          <div class="cheak-in-box">
            <div class="row">
              <div class="col-md-6">
                <p>CHECK IN</p>
                <h3 class="checkIn"></h3>
              </div>
              <div class="col-md-6">
                <p>CHECK IN TIME</p>
                <h3 class="checkInTime"></h3>
              </div>
              <div class="col-md-6">
                <p>CHECK OUT</p>
                <h3 class="checkOut"></h3>
              </div>
              <div class="col-md-6">
                <p>CHECK OUT TIME</p>
                <h3 class="checkOutTime"></h3>
              </div>
            </div>
            <div class="text-wall text-center total_house_string"></div>
            <h2>Payment details</h2>
            <div class="payment-details-box">
              <div class="row">
                <div class="col-md-8">
                  <h5>Booking Amount</h5>
                  <!-- <h5 class="p-0">Coupon Discount (DCG First)</h5> -->
                </div>
                <div class="col-md-4 text-right">
                  <h5 class="p-0"><strong class="total_amount"></strong></h5>
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
                <h5><strong class="total_amount"></strong></h5>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
            <button class="btn-primary btn">book now</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function booking_detail($this) {
    $('.daycare_name').text($($this).attr('data-daycareName'));
     $('.daycareaddress').text($($this).attr('data-daycareaddress'));
     $('.checkIn').text($($this).attr('data-checkIn'));
     $('.checkOut').text($($this).attr('data-checkOut'));
     $('.checkInTime').text($($this).attr('data-checkInTime'));
     $('.checkOutTime').text($($this).attr('data-checkOutTime'));
     $('.total_house_string').html('Daycare booked for<strong> '+$($this).attr('data-child')+' child</strong> for<strong>&nbsp;'+$($this).attr('data-total_house_string')+'</strong>');
     $('.child').text($($this).attr('data-child'));
     $('.total_amount').text('₹'+$($this).attr('data-total_amount'));
    $("#booking-summary").modal("show");
  }
</script>