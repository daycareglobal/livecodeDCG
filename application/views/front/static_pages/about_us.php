<section class="banner-section">
   <div class="banner-img"><img src="<?php echo $this->config->item('front_assets'); ?>images/banner-img.jpg"></div>
</section>
<section class="same-section bg-color">
  <div class="container">
    <div class="page-heading text-center page-heading-mid pb-5">
      <h1>About Us</h1>
      <p><?php echo $record->description; ?></p>
    </div>
    <!-- <div class="row align-items-center">
      <div class="col-md-8">
        <div class="page-heading">
          <h2>Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo</h2>
          <p class="mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        </div>
      </div> -->
      <!-- <div class="col-md-4">
        <div class="about-us-img">
          <img src="images/slider-img-1.png">
        </div>
      </div> -->
    </div>
  </div>
</section>
<section class="same-section">
  <div class="container">
    <div class="page-heading text-center page-heading-mid mb-4">
      <h2><?php echo $team_description->title; ?></h2>
      <p><?php echo $team_description->description; ?></p>
    </div>
    <div class="row">

      <?php if (isset($teams) && $teams) { foreach ($teams as $key => $value) { ?>
        <div class="col-md-3">
          <div class="team-box">
            <div class="img"><img src="<?php echo base_url('assets/uploads/about_us/').$value->image; ?>" alt="image"/></div>
            <h4><?php echo ucfirst($value->name); ?></h4>
            <!-- <h5>(Head officer)</h5> -->
          </div>
        </div>
      <?php } } ?>
    </div>
  </div>
</section>