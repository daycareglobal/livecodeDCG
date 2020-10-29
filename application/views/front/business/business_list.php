<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

      <section class="same-section bg-color">
        <div class="container">
          <div class="search-page-heading">
            <div class="row">
              <div class="col-md-12">
                <h2><?php echo str_replace("-"," ", $business_type); ?></h2>
                <!-- <h2>104 Daycare center</h2> -->
              </div>
              <!-- <div class="col-md-4">
                <div class="filter-box form-group input-icon select text-right">
                  <label class="mb-0">Sort By :</label>
                  <select class="form-control">
                    <option>Select service</option>
                    <option>Select service</option>
                 </select>
                 <span><i class="fas fa-angle-down"></i></span>
                </div>
              </div> -->
            </div>
          </div>
          <?php if ($business_list && !empty($business_list)) { foreach ($business_list as $key => $value) { ?>
            <div class="search-data">
              <div class="row m-0">
                <div class="col p-0 img">
                  <div class="slider-box search-slider ">
                     <div id="search-img-slider_<?php echo $key; ?>" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                          <?php if ($value->business_images && !empty($value->business_images)) { foreach ($value->business_images as $k => $v) { ?>
                            <div onclick="openFancyBox(this)" data-id="<?php echo 'gallery_'.$key; ?>" class="carousel-item gallery <?php echo 'gallery_'.$key; ?> <?php echo ($k == 0)?'active':''; ?>">
                              <a class="<?php echo '#gallery_'.$key ; ?>" href="<?php echo $this->config->item('uploads').'business_logo/'.$v->image; ?>">
                                <img src="<?php echo $this->config->item('uploads').'business_logo/'.$v->image; ?>" alt="Los Angeles">
                              </a>
                            </div>
                          <?php } } ?>
                        </div>
                        <div class="carousel-control">
                          <a href="#search-img-slider_<?php echo $key; ?>" data-slide="prev">
                            <span><i class="fas fa-angle-left"></i></span>
                          </a>
                          <a  href="#search-img-slider_<?php echo $key; ?>" data-slide="next">
                            <span><i class="fas fa-angle-right"></i></span>
                          </a>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="col p-0">
                  <div class="search-data-box">
                    <div class="search-text-box">
                      <div class="page-heading">
                        <h5><?php echo $value->daycare_name; ?></h5>
                        <p><?php echo $value->daycare_address; ?></p>
                        <p class="rating"><span><?php echo ($value->rating > 0)?$value->rating:0; ?> <i class="fas fa-star"></i></span></p>
                      </div>
                      <div class="search-icon-ul">
                        <ul>

                          <?php if ($value->business_service_types && !empty($value->business_service_types)) { foreach ($value->business_service_types as $k => $v) { ?>
                            <li><span><img src="<?php echo $this->config->item('uploads').'service_icons'.'/'.$v->icon; ?>"></span><?php echo $v->name; ?></li>
                          <?php } } ?>
                        </ul>
                      </div>
                      <!-- <button class="btnDayTime btn-info btn btn-sm" data-id="<?php echo $value->id; ?>" >Show working hours</button> -->

                        <!-- <span class="no-record">No Record Found </span> -->
                      <!-- <div class="search-open-details working_days-<?php echo $value->id; ?> hide">
                        <?php if(isset($value->business_service_days) && !empty($value->business_service_days)) { 
                          foreach ($value->business_service_days as $k => $val) { ?>
                        <ul>
                          <li>
                            <span><i class="fas fa-sun"></i></span>
                            <p>OPEN</p>
                            <?php if($val->is_holiday == 'Yes') { ?>
                              <strong>Closed</strong>
                            <?php } else { ?>
                              <strong><?php echo $val->open_time; ?></strong>
                            <?php } ?>
                          </li>
                          <li>
                            <span><i class="fas fa-moon"></i></span>
                            <p>CLOSE</p>
                            <?php if($val->is_holiday == 'Yes') { ?>
                              <strong>Closed</strong>
                            <?php } else { ?>
                              <strong><?php echo $val->close_time; ?></strong>
                            <?php } ?>
                          </li>
                          <li>
                            <span><i class="fas fa-calendar-alt"></i></span>
                            <strong><?php echo $val->day; ?></strong>
                          </li>
                        </ul>
                        <?php } } ?>
                      </div> -->
                    </div>
                    <div class="search-charges-box">
                      <h4>CHARGES</h4>
                      <div class="charges-box">
                        <h3>HOURLY </h3>
                        <h6>₹ <?php echo $value->hourly_charges; ?></h6>
                      </div>
                      <div class="charges-box">
                        <h3>MONTHLY</h3>
                        <h6>₹ <?php echo $value->monthly_charges; ?></h6>
                      </div>
                      <div class="charges-box">
                        <h3>DAILY</h3>
                        <h6>₹ <?php echo $value->daily_charges; ?></h6>
                      </div>
                    </div>
                    <div class="cleafix"></div>
                  </div>
                  <div class="serch-button-box text-right custom-button w-100 pr-3">
                    <a href="<?php echo base_url('business/business-detail').'/'.$value->id.'?sid='.$value->id; ?>" class="btn-info btn btn-sm ">view detail</a>
                    <a href="<?php echo base_url('business/business-detail').'/'.$value->id.'?sid='.$value->id; ?>" class="btn-primary btn btn-sm">Book now</a>
                  </div>
                </div>
              </div>
            </div>
          <?php } } ?>
        </div>
      </section>

<script>
$(document).ready(function(){
  $(".btnDayTime").click(function(){
    var id = $(this).attr('data-id');
    $(".working_days-"+id).toggle(1000);
    $(".working_days-"+id).removeClass("hide");
  });
});
</script>
<script type="text/javascript">
    // $(document).ready(function() {
    //   // add all to same gallery
    //   $(".gallery a").attr("data-fancybox","mygallery");
    //   // assign captions and title from alt-attributes of images:
    //   $(".gallery a").each(function(){
    //     $(this).attr("data-caption", $(this).find("img").attr("alt"));
    //     $(this).attr("title", $(this).find("img").attr("alt"));
    //   });
    //   // start fancybox:
    //   $(".gallery a").fancybox();
    // });

    function openFancyBox($this)
    {
      var gallery = $($this).data('id');
      $(".gallery a").removeAttr("data-fancybox");
      $("."+gallery+" a").attr("data-fancybox","mygallery");
      // assign captions and title from alt-attributes of images:
      /*$("."+gallery).each(function(){
        $(this).attr("data-caption", $(this).find("img").attr("alt"));
        $(this).attr("title", $(this).find("img").attr("alt"));
      });*/
      // start fancybox:
      $("."+gallery+" a").fancybox();
      // alert('here');
    }
</script>