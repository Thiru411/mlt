<footer>
  
      <div class="footer_sec">
        <div class="container">
          <div class="row mw-1000">
            <div class="col-md-6">
              <div class="img_col">
              <?php if($user_id==''){?>
                <a href="#" class="d-flex mb-5" data-toggle="modal" data-target="#loginmodal">
                  <div class="img_text">
                    <img src="<?=$admin_url?>assets/images/yellow.png" class="immg-fluid">
                    <h6>Win</h6>
                  </div>
                  <div class="img_para">
                    <p>Describe our concept in 100 words and win a meal for yourself and your loved one.</p>
                  </div>
              </a>
                   <?php }else{?>
                <a href="#" class="d-flex mb-5" data-toggle="modal" data-target="#WinAMedal">
                  <div class="img_text">
                    <img src="<?=$admin_url?>assets/images/yellow.png" class="immg-fluid">
                    <h6>Win</h6>
                  </div>
                  <div class="img_para">
                    <p>Describe our concept in 100 words and win a meal for yourself and your loved one.</p>
                  </div>
                   </a>
                <?php }?>
                
<a href="#" class="d-flex mb-5" data-toggle="modal" data-target="#rate"> 
                  <div class="img_text">
                    <img src="<?=$admin_url?>assets/images/red.png" class="immg-fluid">
                    <h6>Rate</h6>
                  </div>
                  <div class="img_para">
                    <p>Rate your favourite Pizza so we can surprise you when you’re feeling low</p>
                  </div>
                   </a>
                   
                <a href="#" class="d-flex win-rate" data-toggle="modal" data-target="#share">  
                  <div class="img_text">
                    <img src="<?=$admin_url?>assets/images/blue.png" class="immg-fluid">
                    <h6>Share</h6>
                  </div>
                  <div class="img_para">
                    <p>Sharing with loved ones is the best thing there can be. Let’s share Love & Pizzas.</p>
                  </div>
                   </a>
              </div>
            </div>
            <div class="col-md-6 link-giftss">
              <div class="row">
                <div class="col-md-6 col-5">
                  <ul class="links">
                    <h6>Links</h6>
                   <?php if($user_id==''){?>
                    <li><a href="javascrip(0)"data-toggle="modal" data-target="#loginmodal">Gift A Cart</a></li>
                   <?php }else{?>
                    <li><a href="<?php echo base_url('/gift-a-cart')?>">Gift A Cart</a></li>
                  <?php }?>
                  <?php if($user_id==''){?>
                    <li><a href="javascrip(0)"data-toggle="modal" data-target="#loginmodal">Party Time</a></li>

                    <?php }else{?>
                      <li><a href="<?php echo base_url('/party-time')?>">Party Time</a></li>
                      <?php }?>

                    <li><a href="<?php echo base_url('/about-us')?>">About Us</a></li>
                  </ul>

                </div>
                <div class="col-md-6 col-6">
                  <ul class="links">
                    <h6>Reach Us</h6>
                    <li><a href= "tel:9292925353">+91 9292925353</a></li>
                    <li><a href="mailto:hi@mylovetriangle.pizza">hi@mylovetriangle.pizza</a></li>
                    <li class="social_links">
                    <a href="https://www.facebook.com/mylovetrianlge" title="Facebook" class="footer-icons__item-link" aria-describedby="a11y-external-message" target="_blank" rel="noopener"><img src="<?=$admin_url?>assets/images/fb.png" class="img-fluid"></a>
                    <a href="https://www.instagram.com/mylovetriangle/" title="Instagram" class="footer-icons__item-link" aria-describedby="a11y-external-message" target="_blank" rel="noopener"><img src="<?=$admin_url?>assets/images/insta.png" class="img-fluid"></a>
                    <a href="https://wa.me/919292925353" title="WhatsApp" class="footer-icons__item-link" aria-describedby="a11y-external-message" target="_blank" rel="noopener"><img src="<?=$admin_url?>assets/images/whatsapp.png" class="img-fluid"></a>  
                    </li>
                  </ul>
                </div>
              </div>
              <form id="addfrnd_footer">
              <div class="form-group d-flex get-goodness postion-relative">
                <input type="text" class="deliver_srch" name="sub" id="sub" placeholder="Get Goodness Delivered">
                <button type="submit" class="subscribe_btn default-btn subscription onclick_accordian_footer">Subscribe</button>
              </div> 
              <!-- <small class="sub-err d-none" style="display:none" >Email Already Exists</small>			-->	 
             </form>
            </div>
          </div>
        </div>
        <div class="links_sec"></div>
      </div>
        <div class="baking_sec move py-0">
          <div class="container">
            <!-- <div id="footer_gif"></div> -->
           <div class="d-md-block d-none"> <img class="img-fluid w-100 lazy" src="<?=$admin_url?>assets/gif/footer_truck.gif"></div>
            
            <!-- <lottie-player 
              src="<?=$admin_url?>assets/gif/footer.json" class="lazy"  background="transparent"  speed="1"  autoplay="flase" >
            </lottie-player> -->

            <!-- <video controls="controls" class="w-100" name="Video Name">
              <source src="<?=$admin_url?>assets/gif/footer-new.mov">
            </video> -->

             <div class="row mw-1000 bdr--btm d-md-none d-block" >
              <div class=" truck_footer">
                <img src="<?=$admin_url?>assets/images/footer_truck.png" class="yoyo">
              </div>	
              <div class="baking_text d-md-flex trigger-overflow">
                <span class="text-block">
                  <h3>Baking <br> in a <span>moving car</span></h3>
                  <h3 class="baking_word mt-4">that’s our <br><span>Superpower</span></h3>
                </span>
              </div>
            </div> 
          </div>
        </div>
          <div class="copyright">
            <div class="container">
              <div class="row mw-1000">
                <div class="col-md-6 d-md-block d-none">
                  <a href=" ">Copyrights © 2021 @mylovetriangle</a>
                </div>
                <div class="col-md-6 d-flex justify-space-terms">
              
                  <a href="<?=$admin_url?>terms-and-conditions" class="terms--condition">terms & Conditions</a>
          
                  <a href="<?=$admin_url?>refund-policy" class="terms--condition d-md-block d-none">Refund Policy</a>
              
                  <a href="<?=$admin_url?>privacy" class="terms--condition">privacy policy</a>
                
                </div>
                <div class="col-md-6 d-block d-md-none">
                  <a href=" ">Copyrights © 2021 @mylovetriangle</a>
                </div>
              </div>
            </div>
          </div>
    </footer>




<!-- Rate Modal -->
<div class="modal fade win_rate_share" id="rate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="close-modal" data-dismiss="modal" aria-label="Close">
          <img src="<?=$admin_url?>assets/images/close-modal.png" alt="">
        </div>
        <div class="bg-emoji d-flex">
          <div class="sad_emoji smiles"><img src="<?=$admin_url?>assets/images/sad.png" alt=""></div>
          <div class="satisfy_emoji smiles"><img src="<?=$admin_url?>assets/images/satisfy.png" alt=""></div>
          <div class="happy_emoji smiles"><img src="<?=$admin_url?>assets/images/happy.png" alt=""></div>
        </div>
        <div class="rate_us d-flex justify-content-center">
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio1" data-value="1" name="rateRadio" class="custom-control-input" value="sad">
            <label class="custom-control-label" for="rateRadio1">1</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio2" name="rateRadio" data-value="2" class="custom-control-input" value="sad">
            <label class="custom-control-label" for="rateRadio2">2</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio3" name="rateRadio" data-value="3" class="custom-control-input" value="sad">
            <label class="custom-control-label" for="rateRadio3">3</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio4" name="rateRadio" data-value="4" class="custom-control-input" value="sad">
            <label class="custom-control-label" for="rateRadio4">4</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio5" name="rateRadio" data-value="5" class="custom-control-input" value="sad">
            <label class="custom-control-label" for="rateRadio5">5</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio6" name="rateRadio" data-value="6" class="custom-control-input" value="sad">
            <label class="custom-control-label" for="rateRadio6">6</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio7" name="rateRadio" data-value="7" class="custom-control-input" value="satisfy">
            <label class="custom-control-label" for="rateRadio7">7</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio8" name="rateRadio" data-value="8" class="custom-control-input" value="satisfy">
            <label class="custom-control-label" for="rateRadio8">8</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio9" name="rateRadio"data-value="9" class="custom-control-input" value="happy">
            <label class="custom-control-label" for="rateRadio9">9</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline pl-0">
            <input type="radio" id="rateRadio10" name="rateRadio" data-value="10"checked class="custom-control-input" value="happy">
            <label class="custom-control-label" for="rateRadio10">10</label>
          </div>
        </div>
        <h4 class="text-center">RATE YOUR EXPERIENCE</h4>
        <p class="text-center pt-3">On a scale of 0 -10, how likely are you to recommend us to family and/or friends?</p>
        
      </div>
    </div>
  </div>
</div>

<!-- Win Modal -->
<div class="modal fade win_rate_share" id="WinAMedal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden"  class="win_user_id" value=<?=$user_id?>>
        <div class="close-modal" data-dismiss="modal" aria-label="Close">
          <img src="<?=$admin_url?>assets/images/close-modal.png" alt="">
        </div>
        <h4 class="text-center">WIN A MEAL</h4>
        <p class="text-center pt-3">Describe our concept in 100 words or less and win a surprise gift if your description makes the cut!</p>
        <form class="" id="myform" action="" method="post">
          <div class="form-group">
            <textarea class="form-control" name="describe" id="describe" placeholder="Describe in 100 words"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn_yellow sent__request">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $weblink=base_url()?>
<!-- Share Modal -->
<div class="modal fade win_rate_share" id="share" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="close-modal" data-dismiss="modal" aria-label="Close">
          <img src="<?=$admin_url?>assets/images/close-modal.png" alt="">
        </div>
        <h4 class="text-center">Share NOW</h4>
        <p class="text-center pt-3 px-md-5 mx-md-4">Save other from having to eat cold, crummy pizza by sending the word about MLT!</p>
        <ul class="share_icons d-flex flex-wrap mt-5 pt-md-2 pb-md-3">
          <li>
          <a href="https://www.facebook.com/sharer/sharer.php?u=<?=$weblink?>" target="_blank"><img src="<?=$admin_url?>assets/images/facebook1.png" alt=""></a>
          </li>
          <li>
          <a href="https://twitter.com/share?url=<?=$weblink?>" target="_blank"><img src="<?=$admin_url?>assets/images/twitter1.png" alt=""></a>
          </li>
          <li>
            <a href="https://pinterest.com/pin/create/link/?url=<?=$weblink?>" target="_blank"><img src="<?=$admin_url?>assets/images/pinterest.png" alt=""></a>
          </li>
          <li>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?=$weblink?>" target="_blank"><img src="<?=$admin_url?>assets/images/linkedin.png" alt=""></a>
          </li>
          <li>
            <a href="https://www.reddit.com/submit?url=<?=$weblink?>" target="_blank"><img src="<?=$admin_url?>assets/images/reddit.png" alt=""></a>
          </li>
          <li>
            <a href="https://telegram.me/share/url?url=<?=$weblink?>" target="_blank"><img src="<?=$admin_url?>assets/images/telegram.png" alt=""></a>
          </li>
        </ul>
        <div class="copy_url d-flex">
          <input type="text" value="<?=$weblink?>" id="myInput1">

          <div class="tooltip">
            <div onclick="myFunction()" onmouseout="outFunc()">
              <span class="tooltiptext" id="myTooltip">Copy URL</span>
              <div class="ml-auto pl-4"><img src="<?=$admin_url?>assets/images/copy.png" alt=""></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
