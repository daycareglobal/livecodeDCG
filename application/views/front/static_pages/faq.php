<section class="same-section bg-color faq-inner">
   <div class="container">
      <div class="heading-title">
         <h2><?php echo $record->title; ?></h2>
      </div>
      <div class="post_content">
        <?php echo $record->description; ?>
      </div>
      <!-- <div class="faq_list" id="accordion">
         <h3>About US</h3>
            <div class="card">
                  <div class="card-header" id="headingOne">
                     <a href="#feq1" data-toggle="collapse" data-target="#collapseOne" aria-controls="collapseOne" aria-expanded="false" class="collapsed">What is Digitize Limited?
                        <span class="faq_plas_icon">
                           <i class="fas fa-angle-down"></i>
                           <i class="fas fa-angle-up"></i>
                        </span>
                     </a>
                  </div>
                  <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                     <div class="faq_text_box">
                     Digitize Limited is a cryptocurrency exchange platform integrated with top crypto exchanges such as Gemini, Binance and Bittrex. The platform compares the cryptocurrency prices on these exchanges and offers the best rate to its users.
                     </div>
                  </div>
            </div>
            <div class="card">
                  <div class="card-header" id="headingtwo">
                     <a href="#feq1" data-toggle="collapse" data-target="#collapsetwo" aria-controls="collapsetwo" aria-expanded="false" class="collapsed">Why trust us?
                        <span class="faq_plas_icon">
                           <i class="fas fa-angle-down"></i>
                           <i class="fas fa-angle-up"></i>
                        </span>
                     </a>
                  </div>
                  <div id="collapsetwo" class="collapse" aria-labelledby="headingtwo" data-parent="#accordion" style="">
                     <div class="faq_text_box">
                       Digitize’s team of highly experienced tech developers has integrated the platform with reliable exchanges built with highest data security protocols.
                     </div>
                  </div>
            </div>
      </div> -->
      <div class="faq_list" id="accordion">
         <!-- <h3>Cryptocurrency trading</h3> -->

          <?php if (isset($faq_question) && !empty($faq_question)) { foreach ($faq_question as $key => $value) { ?>
            <div class="card">
                  <div class="card-header" id="heading1">
                     <a href="#feq1" data-toggle="collapse" data-target="#collapse_<?php echo $key; ?>" aria-controls="collapse_<?php echo $key; ?>"><?php echo $value->question; ?>
                        <span class="faq_plas_icon">
                           <i class="fas fa-angle-down"></i>
                           <i class="fas fa-angle-up"></i>
                        </span>
                     </a>
                  </div>
                  <div id="collapse_<?php echo $key; ?>" class="collapse " aria-labelledby="heading1" data-parent="#accordion">
                     <div class="faq_text_box">
                     <?php echo $value->answer; ?>
                     </div>
                  </div>
            </div>
          <?php } } ?>
      </div>
      <!-- <div class="faq_list" id="accordion">
         <h3>Customer support</h3>
            <div class="card">
                  <div class="card-header" id="heading8">
                     <a href="#feq1" data-toggle="collapse" data-target="#collapse8" aria-controls="collapse8">Couldn’t find answer?
                        <span class="faq_plas_icon">
                           <i class="fas fa-angle-down"></i>
                           <i class="fas fa-angle-up"></i>
                        </span>
                     </a>
                  </div>
                  <div id="collapse8" class="collapse " aria-labelledby="heading8" data-parent="#accordion">
                     <div class="faq_text_box">
                     You can chat with our customer support executive or email your query at <a href="mailto:support@digitize.limited">support@digitize.limited</a>
                     </div>
                  </div>
            </div>
      </div> -->
   </div>
</section>