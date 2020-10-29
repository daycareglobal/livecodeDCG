<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" type="text/css" media="screen" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<?php foreach($services as $key => $value){ ?>
  <div class="search-data">
    <div class="row m-0">
      <div class="col p-0 img">
          <div class="slider-box search-slider ">
           <div id="search-img-slider__<?php echo $key; ?>" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">

                <?php if ($value->images) { ?>

                  <?php foreach ($value->images as $k1 => $v1) { ?>
                    <div onclick="openFancyBox(this)" data-id="<?php echo 'gallery_'.$key; ?>" class="carousel-item gallery <?php echo 'gallery_'.$key; ?> <?php echo ($k1 == 0)?'active':''; ?>">
                      <!-- <img src="<?php echo base_url('assets/uploads/business_logo/'.$v1->image); ?>" alt="<?php echo $v1->image; ?>"> -->
                      <a class="<?php echo '#gallery_'.$key ; ?>" href="<?php echo $this->config->item('uploads').'business_logo/'.$v1->image; ?>">
                        <img src="<?php echo $this->config->item('uploads').'business_logo/'.$v1->image; ?>" alt="<?php echo $v1->image; ?>">
                      </a>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
              <div class="carousel-control">
                <a href="#search-img-slider__<?php echo $key; ?>" data-slide="prev">
                  <span><i class="fas fa-angle-left"></i></span>
                </a>
                <a  href="#search-img-slider__<?php echo $key; ?>" data-slide="next">
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
              <p class="rating"><span><?php echo ($value->rating > 0)?$value->rating:0; ?><i class="fas fa-star"></i></span>(0 Rating)</p>
            </div>
            <div class="search-icon-ul">

              <?php if ($value->services) { ?>
                <ul>

                  <?php foreach ($value->services as $k => $v) { ?>
                    <li><span><img src="<?php echo $this->config->item('uploads').'service_icons'.'/'.$v->icon; ?>"></span><?php echo $v->name; ?></li>
                  <?php } ?>
                  <!-- <li><span><img src="images/service-icon-4.png"></span>Meal Included</li>
                  <li><span><img src="images/service-icon-6.png"></span>Security</li> -->
                  <!-- <li>( 7+ More )</li> -->
                </ul>
              <?php } ?>
            </div>
<!--             <button class="btnDayTime" data-id="<?php echo $value->id; ?>">Show working hours</button>
 -->
<!--             <div class="search-open-details working_days-<?php echo $value->id; ?> hide">

              <?php if(isset($value->service_days) && !empty($value->service_days)) { 
                foreach ($value->service_days as $k => $val) { ?>
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
            </div>
 -->
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
          <?php 
            $check_in = $_GET['check_in'];
            $check_out = $_GET['check_out'];
          ?>
          <a href="<?php echo base_url('services/detail?sid='.$value->id.'&check_in='.$check_in.'&check_out='.$check_out); ?>" class="btn-info btn btn-sm">view detail</a>
          <a href="<?php echo base_url('services/detail?sid='.$value->id.'&check_in='.$check_in.'&check_out='.$check_out); ?>" class="btn-primary btn btn-sm">Book now</a>
        </div>
      </div>
    </div>
  </div>
<?php } ?>

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


<!-- <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
 -->