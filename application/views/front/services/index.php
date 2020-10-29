<section class="same-section bg-color">
  <div class="container">
    <div class="search-page-heading">
      <div class="row">
        <div class="col-md-8">
          <?php if(isset($address) && !empty($address)) { ?>
          <h4><?php echo $address; ?></h4>
          <?php } ?>

          <?php if(isset($service_name) && !empty($service_name)) { ?>
            <h2><?php echo $service_name; ?></h2>
          <?php } ?>
        </div>
        <div class="col-md-4">
          <!-- <div class="filter-box form-group input-icon select text-right">
            <label class="mb-0">Sort By :</label>
            <select class="form-control">
              <option>Select service</option>
              <option>Select service</option>
           </select>
           <span><i class="fas fa-angle-down"></i></span>
          </div> -->
        </div>
      </div>
    </div>
    <div class="ajax-data">

    </div>
  </div>
</section>

<script type="text/javascript">
  $(function(){
    var url = "<?php echo base_url('services/get_services?address='.$address.'&latitude='.$latitude.'&longitude='.$longitude.'&service_types='.$service_types.'&check_in='.$check_in.'&check_out='.$check_out); ?>";
    getServices(url);    
  })

  function getServices(url)
  {
    $.ajax({
      url: url,
      type: 'post',
      dataType: 'json',
      success: function(data) {
        $('.ajax-data').html(data.html);
        $('.daycare_count').text(data.total_services)
      }
    })
  }
</script>
