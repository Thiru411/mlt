<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

  <link rel="shortcut icon" href="<?=$admin_url?>assets/images/Logo.svg" />

  <?php $this->load->view('website/inc/scripts-top');?>

  <style>
#ui-id-1{height: 324px;width: 305px !important;padding: 20px 0 0 0;overflow-y: auto;z-index: 10000;background: linear-gradient(0deg, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0.09)), #121212;border: 0;}
#ui-id-1.ui-menu .ui-menu-item-wrapper{border-bottom: 1px solid rgb(170 174 187 / 16%) !important;padding: 0 0 16px 0;margin: 0 0 16px 0;}
#ui-id-1.ui-menu .ui-menu-item-wrapper.ui-state-active{background: linear-gradient(0deg, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0.09)), #121212;border: 0;border-color: transparent;}
#ui-id-1 .ui-menu-item-wrapper p{font-weight: 600;font-size: 16px;color: #FFFFFA;text-transform: capitalize;line-height: 24px;}
#ui-id-1 .ui-menu-item-wrapper span{display: block;font-size: 14px;line-height: 22px;color: rgba(255, 255, 250, 0.8) !important;text-transform: capitalize;font-weight: 400;margin-top: 8px;}

  </style>
  <title>Home</title>
</head>
<body>
  <div class="wrapper">  
    <?php $this->load->view('website/inc/header');?>

    
  <!-- <div class="call-icon"><img class="call-ring" src="<?=$admin_url?>assets/images/Call_Icon.png" alt=""></div> -->
    <section class="landing-page">
      <div class="container">
        <div class="text-center">
          <div class=" position-relative align-self-center">
           
              <img class="img-fluid mlt-truck  " src="<?=$admin_url?>assets/gif/truck_banner.gif" alt="">
              <!-- <img class="rect img-fluid" src="<?=$admin_url?>assets/images/rect.png" alt="">  -->
              <!-- <img class="triangle img-fluid" src="<?=$admin_url?>assets/images/tri-round.png" alt=""> -->
        
          </div>

         
            <h2 class="baking">Baked while driving, delivered <span>HOT!</span></h2>
            <a href="<?=$admin_url?>menu" class="default-btn order-now ">Order online now </a>
    

        </div>
        <!-- <div class="best-work mb-md-5 mt-md-5">
          <p class="phases mb-3 fw-400">Currently delivering in DLF Phase 1 to 5, Gurgaon at the moment. </p>
          <p class="ring-us mb-3 fw-400">Please ring us on <a class="number" href="#"> <u> 9292925353</u> </a> If you
            are visiting from any one of other Gurgaon areas. We will do our best to work something out! </p>
          <p class="visit-outside fw-400">If visiting from outside of Gurgaon, watch this space, as we are working extra hardto
            come to your city soon!🤗 🍕</p>
        </div> -->
      </div>
     
    </section>

    <section>
      <div class="container">

        <div class="d-none d-md-block">
          <div id="cooking"></div>
        </div>

        <div class="d-block d-md-none">
          <div id="cooking_mobile"></div>
        </div>
        
      </div>
    </section>

    <section>
      <div class="container">

        <div class="d-none d-md-block">
          <div id="pizza"></div>
        </div>

        <div class="d-block d-md-none">
          <div id="pizza_mobile"></div>
        </div>

      </div>
    </section>

    
    <!-- <section class="cooking-goods">
      <div class="container position-relative">
        <img class="coocking" src="<?=$admin_url?>assets/images/coocking-goo.gif" alt="">
        <div class="mt-3">
          <p class="cooking pt-4"></p>
        </div>
      </div>
    </section> -->

   <!-- <section class="delivery-system position-relative">
      <div class="container">
        <div class="timeline-slider d-flex">
          <div class="traditional">
            <div class="d-flex">
              <div class="track-wrap">
                <div class="track">
                  <span id="white-round" class="white-round">
                    <div class="knob"></div>
                  </span>
                </div>

                <div class="traditional-food">
                  <h3 class="food-dely fw-400">Traditional <br>food delivery</h3>
                  <p class="pizza-prep fw-400"> Pizza is prepared and cooked at a kitchen itself</p>
                </div>
              </div>
            </div>
          </div>
          <div class="mlt-delivery">
            <div class="d-flex">
              <div class="track-wrap">
                <div class="track">
                  <span class="white-round" style="transform: rotate(19.5046deg);">
                    <div class="knob"></div>
                  </span>
                </div>
                <div class="traditional-food">
                  <h3 class="food-dely fw-400">MLT<br>food delivery</h3>
                  <p class="fresh-kitchen fw-400">Fresh ingredients are prepared at a central kitchen</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- <div class="carousel">
          <div class="slider">

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img1.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img1.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img1.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img1.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img1.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img.png">
            </div>

            <div class="card">
              <img src="<?=$admin_url?>assets/images/slider-img1.png">
            </div>

          </div>
        </div> -->

    <section class="faq_triangle">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                      <div class="card mb-4">
                        <div class="card-header" id="headingThirtyone">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseThirtyone" aria-expanded="true" aria-controls="collapseThirtyone">
                            <div class="float-right arr_faq"><img src="<?=$admin_url?>assets/images/arr.png" alt=""></div> 
                            Q1. What’s different about MLT delivery?
                            </button>
                          </h2>
                        </div>

                        <div id="collapseThirtyone" class="collapse show" aria-labelledby="headingThirtyone" data-parent="#accordionExample">
                          <div class="card-body">
                          Instead of baking then delivering we bake your home delivered pizza while delivering, such that your pizza is ready just when it reaches you, so that you get your pizza 3 minutes and not 30 minutes out of the oven, so that you can enjoy a hot, fresh, gourmet pizza even in the comfort of your own home. Kirk out!
                          </div>
                        </div>
                      </div>
                      <div class="card mb-4">
                        <div class="card-header" id="headingThirtytwo">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseThirtytwo" aria-expanded="false" aria-controls="collapseThirtytwo">
                            <div class="float-right arr_faq"><img src="<?=$admin_url?>assets/images/arr.png" alt=""></div> 
                            Q2. Do I have to pay a premium for the better experience that I get with MLT?
                            </button>
                          </h2>
                        </div>
                        <div id="collapseThirtytwo" class="collapse" aria-labelledby="headingThirtytwo" data-parent="#accordionExample">
                          <div class="card-body">
                          No, you don’t. Even though our pizzas reach you hotter and fresher and are made with only the highest quality ingredients, our prices are comparable even to most mass market pizza brands. That’s not all. Want to change the crust? No extra charge! Want to add a topping or two? It’s on us! No additional delivery, no additional packing, no additional tax charge! You pay what you see on the price list. Period!
                          </div>
                        </div>
                      </div>
                      <div class="card mb-4">
                        <div class="card-header" id="headingThree">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left " type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <div class="float-right arr_faq"><img src="<?=$admin_url?>assets/images/arr.png" alt=""></div> 
                            Q3. Is there a minimum order quantity?
                             
                            </button>
                          </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                          <div class="card-body">
                          Nope. We value that you chose us! We value the chance to serve you! We value your custom whatever it may be! We value you! And thus, even your smallest wish is our command! And you have more than three wishes ☺
                          </div>
                        </div>
                      </div>

                      <div class="card">
                        <div class="card-header" id="headingFour">
                          <h2 class="mb-0">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <div class="float-right arr_faq"><img src="<?=$admin_url?>assets/images/arr.png" alt=""></div> 
                            Q4. Why the terracotta packaging?
                            </button>
                          </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                          <div class="card-body">
                          Isn’t it cool ☺ On a more serious note, we aim to deliver delight at every point you interact with us, so we can hope to be your favorite pizza brand. This means delighting you when you visit our website, when you call our contact center, when you receive our van in your backyard, when you meet with our delivery divas, when you receive our packaging and of course when you experience our pizzas. Plus, terracotta is a whole lot pizza friendly, environmentally friendly, reusable and servable than the current options in circulation
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
          </div>
      </div>
    </section>

    <section class="review-slider position-relative">
      <div class="container position-relative">
      <div> <img  class="yellow_circle" src="<?=$admin_url?>assets/images/yellowcircle.png"></div>
        <h2 class="text-center fw-400 mb-5">What Our Customers are saying</h2>
        <div > <img class="pink_circle" src="<?=$admin_url?>assets/images/pinkcircle.png"></div>
        <div > <img class="blue_bigcircle" src="<?=$admin_url?>assets/images/blue_bigcircle.png"></div>
        <div class="yellow_smallcircle"> <img src="<?=$admin_url?>assets/images/yellow_smallcircle.png"></div>

        <div class="comment-slider custom_slick_quote">
          <div>
            <div class="custom_slick_quote1 position-relative">
              <div class="customer_slick_card ">
               <p class="text-center fs-18 fw-400">MLT definitely gives the best pizza at home experience. The fact that it’s made right outside my home, I am assured that it’s complete fresh. Packaging is very interesting with terracotta plates (which then becomes a canvas for my 4 year old son to paint) and cloth to hold the pizzas. 
                Taste is authentic and no other place can offer a better Neapoli pizza. I love their Popeye and Bianca pizzas. Recently tried their chocolate fudge cake which is outstanding. </p>
              </div>
            </div>
          </div>
               
          <div>
              <div class="custom_slick_quote1 position-relative">
                <div class="customer_slick_card ">
                  <p class="text-center fs-18 fw-400">The experience is innovative and the service is even better</p>
                </div>
              </div>
          </div>

          <div>
            <div class="custom_slick_quote1 position-relative">
              <div class="customer_slick_card ">
                <p class="text-center fs-18 fw-400">The best pizza we ever had in (City)!! The pizza was so delicious and with just the perfect toppings could choose that we even ordered  twice in the same day! It's amazing the concept of baking on the wheels.</p>
              </div>
            </div>
          </div>

          <div>
            <div class="custom_slick_quote1 position-relative">
              <div class="customer_slick_card ">
                <p class="text-center fs-18 fw-400">Mlt pizzas are the absolute best pizzas I have ever had in my life! They have become an instant hit in all our gatherings. I’m a fan!</p>
              </div>
            </div>
          </div>
          
          <div>
            <div class="custom_slick_quote1 position-relative">
              <div class="customer_slick_card ">
                <p class="text-center fs-18 fw-400">The Love triangle is such a fun concept. I’ve ordered from them multiple times and recently had them cater for a very special family gathering. The pizza recipes are simple and delicious and the ingredients taste fresh and totally worth it. Their pizzas definitely bring back some nostalgia from my European travels. I have already recommended them to so many friends of mine. Everything from deciding the menu to their service was such an easy experience. The packaging is also one of my favourite quirks and I’m totally a part of this love triangle !</p>
              </div>
            </div>
          </div>

        </div>

        <div class="profile-slider">

          <div>
            <h6>Vishesh Gupta </h6>
            <!-- <p>Sector 21, Delhi</p> -->
            <div class="profile_card">
              <img src="<?=$admin_url?>assets/images/slider-img.jpg">
            </div>
          </div>

          <div>
            <h6>Anurag Goel</h6>
            <!-- <p>Sector 21, Delhi</p> -->
            <div class="profile_card">
              <img src="<?=$admin_url?>assets/images/slider-img1.jpg">
            </div>
          </div>

          <div>
            <h6>Shilpa & Siddharth Mahajan</h6>
            <!-- <p>Sector 21, Delhi</p> -->
            <div class="profile_card">
              <img src="<?=$admin_url?>assets/images/slider-img2.jpg">
            </div>
          </div>

          <div>
            <h6>Ekansh Jain  </h6>
            <!-- <p>Sector 21, Delhi</p> -->
            <div class="profile_card">
              <img src="<?=$admin_url?>assets/images/slider-img3.jpg">
            </div>
          </div>

          <div>
            <h6>Mahima Kapoor</h6>
            <!-- <p>Sector 21, Delhi</p> -->
            <div class="profile_card">
              <img src="<?=$admin_url?>assets/images/slider-img4.jpg">
            </div>
          </div>
          
        </div>
        <div > <img class="blue_circle" src="<?=$admin_url?>assets/images/bluecircle.png"></div>
        <div > <img class="pink_smallcircle" src="<?=$admin_url?>assets/images/pink-small.png"></div>
      </div>
      
    </section>
  
      <section class="foooood-tabs">
          <div class="container">
            <div class="tabs-scroll">
              <ul class="nav nav-tabs row" id="myTab" role="tablist">
                <?php 
                $image_url='';
                foreach($categoryimage as $info) {
                  $category_id=$info->sk_categoryItems_id;
                 $image_url=admin_img_url.'category/'.$info->category_image;
                   ?>
                <li class="nav-item col-2" role="presentation">
                  <a href="<?=$admin_url?>menu?p=<?=$info->category_slug?>" class="nav-link border-0" ><div class=""> <img class="items-food " src="<?=$image_url?>" alt=""> </div><p class="food-items fw-400 fs-20 mt-md-4"><?=$info->Items_categoryname?></p> </a>
                </li>
              <?php } ?>
              </ul>
            </div>
          </div>
      </section>
      <section class="our-menu">
        <div class="container">
          <div class="media menu-banner">
            <img class="discover-menu img-fluid" src="<?=$admin_url?>assets/images/our-menu.png" alt="">
            <div class="media-body explore-ranges">
              <div class="d-flex">
                <div class="cut-pizza"><img src="<?=$admin_url?>assets/images/cut-pizza.png" alt=""></div>
                <h5 class="menu fw-400">Our Menu</h5>
              </div>
              <p class="delicious-ranges fw-400">Explore our range of delicious pizzas, sides, salads, drinks and many more...
              </p>
              <a href="<?=$admin_url?>menu" class="btn-yellow fw-400 ">Discover Menu</a>
            </div>
          </div>
  

          <div class="media  menu-banner  flex-md-row-reverse">
            <img class="discover-menu img-fluid"src="<?=$admin_url?>assets/images/gift-cart.png" alt="">
            <div class="media-body explore-ranges">
              <div class="d-flex ">
                <div class="gift"><img src="<?=$admin_url?>assets/images/gift-box.png" alt=""></div>
                <h5 class="menu fw-400">Gift A Cart</h5>
              </div>
              <p class="delicious-ranges fw-400">Surprise upto 3 friends and/or family with an MLT experience! Our treat, from
                you to them!</p>
                <?php if($user_id!=''){?>
              <a href="<?php echo base_url('/gift_a_cart')?>" class="btn-yellow fw-400">Gift a cart now</a>
              <?php }else{ ?>
                <a href="javascrip(0)"data-toggle="modal" data-target="#loginmodal"class="btn-yellow fw-400">Gift a cart now</a>
              <?php }?>
            </div>
          
          </div>
  
          <div class="media menu-banner">
            <img class="discover-menu img-fluid" src="<?=$admin_url?>assets/images/party-time.png" alt="">
            <div class="media-body explore-ranges">
              <div class="d-flex">
                <div class="cut-pizza"><img src="<?=$admin_url?>assets/images/party-glass.png" alt=""></div>
                <h5 class="menu fw-400">Party Time</h5>
              </div>
              <p class="delicious-ranges fw-400">Got a special occasion? hire our pizza truck and let us work our gourmet magic while
                you celebrate!</p>
                <?php if($user_id!=''){?>
              <a href="<?php echo base_url('/party-time')?>" class="btn-yellow fw-400">book for party now</a>
              <?php } else{ ?>
                <a href="javascrip(0)"data-toggle="modal" data-target="#loginmodal" class="btn-yellow fw-400">book for party now</a> 
                <?php }?>

            </div>
          </div>
  
          <!-- <div class="media  party-time flex-md-row-reverse">
            <img class="discover-menu img-fluid" src="<?=$admin_url?>assets/images/party-time.png" alt="">
            <div class="media-body explore-ranges">
              <div class="d-flex ">
                <div class="gift fw-400"><img src="<?=$admin_url?>assets/images/party-glass.png" alt=""></div>
                <h5 class="menu fw-400">Party Time</h5>
              </div>
              <p class="delicious-ranges">Got a special occasion? hire our pizza truck and let us work our gourmet magic while
                you celebrate!</p>
              <a href="#" class="btn-yellow fw-400">book for party now</a>
            </div>
            
          </div> -->

          
          <div class="media  menu-banner  flex-md-row-reverse">
            <img class="discover-menu img-fluid"src="<?=$admin_url?>assets/images/tie-up.png" alt="">
            <div class="media-body explore-ranges">
              <div class="d-flex ">
                <div class="gift"><img src="<?=$admin_url?>assets/images/Corporate tie up.png" alt=""></div>
                <h5 class="menu fw-400">Corporate Tie Up</h5>
              </div>
              <p class="delicious-ranges fw-400">Sign your business up for a corporate account and get access to special pricing,
                priority delivery & much more...</p>
              <a href="<?php echo base_url('/corporate_tie_up')?>" class="btn-yellow fw-400">learn more about tie up</a>
                               

            </div>
          
          </div>
  
        </div>
      </section>
 
    
    <!-- <section class="Currently-dely">
      <div class="container">
       
        <div class="order-online"> <a href="<?=$admin_url?>menu" class="default-btn fs-20 online-now ">Order online now</a></div>
      </div>
    </section> -->


    <section class="win_share_rate">
      <div class="container">
        <div class="card-deck">
            <?php if($user_id==''){?>
              <div class="card win_content" data-toggle="modal" data-target="#loginmodal">

            <div class="d-flex mb-4">
              <div class="wim-share-rate-img"><img  src="<?=$admin_url?>assets/images/win.png" alt=""></div>
              <h4 class="justify-self-center ">Win</h4>
            </div>

            <p>Describe our concept in 100 words and win a meal for yourself and your loved one.</p>
            <div> <a href="" class="btn_yellow  fw-600 letswin" href="#" class="d-flex mb-5" data-toggle="modal" data-target="#loginmodal">Let’s Win</a></div>
            </div>
            <?php }else{?>
              <div class="card win_content" data-toggle="modal" data-target="#WinAMedal">

            <div class="d-flex mb-4">
              <div class="wim-share-rate-img"><img src="<?=$admin_url?>assets/images/win.png" alt=""></div>
              <h4 class="justify-self-center ">Win</h4>
            </div>
            <p>Describe our concept in 100 words and win a meal for yourself and your loved one.</p>
            <div> <a href="" class="btn_yellow  fw-600 letswin" href="#" class="d-flex mb-5" data-toggle="modal" data-target="#WinAMedal">Let’s Win</a></div>
            </div>         
              <?php }?>
                 



         
            <div class="card win_content" data-toggle="modal" data-target="#rate">

          <div class="d-flex mb-4">
                    <div class="wim-share-rate-img"><img  src="<?=$admin_url?>assets/images/rate.png" alt=""></div>
                    <h4 class="justify-self-center ">Rate</h4>
              </div>
             <!-- <a href="#" class="d-flex mb-5" data-toggle="modal" data-target="#rate"> -->

                  <p>Rate your favourite Pizza so we can surprise you when you’re feeling low</p>
                  <!-- <div class="rate-us-image d-flex ">
                    <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/rateusstar.png" alt=""></div>
                    <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/rateusstar.png" alt=""></div>
                    <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/rateusstar.png" alt=""></div>
                    <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/rateusstar.png" alt=""></div>
                    <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/rateusstar.png" alt=""></div>
                  </div> -->
                  <div> <a href="" class="btn_yellow  fw-600 letswin" href="#" class="d-flex mb-5" data-toggle="modal" data-target="#rate">Let’s Rate</a></div>


                </div>
         
          



          <div class="card win_content" data-toggle="modal" data-target="#share">
            <div class="d-flex mb-4">
                <div class="wim-share-rate-img"><img src="<?=$admin_url?>assets/images/share.png" alt=""></div>
                <h4 class="justify-self-center ">Share</h4>
              </div>
              <p>Sharing with loved ones is the best thing there can be. Let’s share Love & Pizzas.</p>
              <div> <a href="" class="btn_yellow  fw-600" href="#" class="d-flex win-rate" data-toggle="modal" data-target="#share"> Let’s Share</a></div>
            </div>
        </div>

      </div>
    </section>
    <section class="about_truck ">
      <div class="container">
      
        <h2 class="text-center fw-400">How We Came About</h2>
        <p class="fw-600 text-center">Get on the journey with us to discover how we came about MyLoveTriangle.</p>
        <div class="max-844 position-relative">
          <div class="mb-md-4 pb-md-2 pt_160" >
            <input type="text" class="value1" id="demo_1" name="my_range" value="" />
          </div>
            <!-- <div class="d-flex position-relative">
              <div class=""><img class="img-fluid" src="<?=$admin_url?>assets/images/circletruck.png" alt=""></div> 
              <div class="ml-4"><img class="img-fluid main" id="" src="<?=$admin_url?>assets/images/truck-about.png" alt=""></div> 
         
            </div> -->
<!-- 
            <div><img class="img-fluid trii" src="<?=$admin_url?>assets/images/trii.png" alt=""></div> 
            <div><img class="img-fluid recc" src="<?=$admin_url?>assets/images/recc.png" alt=""></div> 
            <div><img class="img-fluid cir" src="<?=$admin_url?>assets/images/cir.png" alt=""></div>  -->

            <div><img class="img-fluid" src="<?=$admin_url?>assets/images/line.png" alt=""></div> 
            <p class="p-sec pt-md-4 truck_message fw-400">Drag the truck to the right to go!</p>
          
       </div>
      </div>
    </section>
   

    
    <section class=" app-store position-relative">
      <div class="container">
        <div class="row get-it mx-0 md-0">
          <div class="col-md-6 our-app">
            <div class="">
              <h2 class="down-load">Download our app</h2>
            </div>
            <div class="d-flex">
              <img class="mr-md-4 googlee-appp" src="<?=$admin_url?>assets/images/gooogle-play.png" alt="">
              <img class="googlee-appp" src="<?=$admin_url?>assets/images/app-store.png" alt="">
            </div>
          </div>
          <div class="col-md-6 ">
            <div class="phone-image">
              <img class="mobile-picc" src="<?=$admin_url?>assets/images/mobile-pic.png" alt="">

            </div>
            <div class="">
              <img class="color-trinagle" src="<?=$admin_url?>assets/images/color-tri.png" alt="">
            </div>
          </div>

        </div>
      </div>
    </section>
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
        <!-- <h4 class="text-center">RATE YOUR EXPERIENCE</h4> -->
        <p class="text-center ">On a scale of 1-10, how likely are you to recommend us to family or friends?</p>
        <div class="mt-3"> <a href="#" class="btn_yellow  fw-600 ratee d-flex mb-5" onClick="emojis()">Rate</a></div>
        
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



    <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#anotherlocationModal">
Another location
</button> -->

<!-- Modal -->
<!-- <div class="modal fade another_location" id="anotherlocationModal" tabindex="-1" aria-labelledby="anotherlocationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     
      
      
   
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 >Choose Another Location</h4>
        <div class="position-relative mb-5 align-self-center"> 
          <img class="ano-img"  src="<?=$admin_url?>assets/images/another-location.png"   alt="">
          <div><img class="exclamation-image"  src="<?=$admin_url?>assets/images/exclamation.png" alt=""></div>
        </div>
        <h6 class="fs-20 text-center mb-3">We Currently do not serve in this location</h6>
        <p class="p-sec text-center">Please choose another location or contact us at <span> +91-9292925353 </span> for any help or assistance</p>
      </div>
    
    </div>
  </div>
</div> -->





    <span class="test"></span>


    <?php  $this->load->view('website/inc/footer');?>
</div>
    <?php $this->load->view('website/inc/scripts-bottom');?>

  <!--<script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "547132576f756f1db79fb47571364ec707f35e78ad49dd4a115e150a8168d7ee", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.in/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);-->
 <!--<script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "a7d96324e5322fcf345f7de5e869f7754ddf32c60af6b2c4e99b0d4d8bfd9f9a009e5a27ab219d76f0903dbaf42d478a", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.in/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);-->  

 <script>
    gsap.registerPlugin(ScrollTrigger);

    function show_next_hero_panel(newSection) {
        if (newSection !== currentSection) {
            gsap.to(currentSection, { autoAlpha: 0, duration: 0.5 });
            gsap.to(newSection, { autoAlpha: 1, duration: 0.5 });
            // /currentSection = newSection;
        }
    }

    const $hero_panel_el = ".main-wrapper__panel";
    const panels = gsap.utils.toArray($hero_panel_el);

    gsap.set(panels[0], { autoAlpha: 1 });
    let currentSection = panels[0];

    ScrollTrigger.create({
        trigger: '.main-wrapper__panel-wrapper',
        start: () => 'top top',
        end: () => "+=" + (panels.length - 1) * innerHeight,
        pin: true 
    });


    panels.forEach((panel, i) => {
        ScrollTrigger.create({
            markers: true,
            trigger: ".main-wrapper__panel-wrapper",
            start: () => "top top-=" + (i - 0.5) * innerHeight,
            end: () => "+=" + innerHeight,
            onToggle: self => self.isActive && show_next_hero_panel(panel) 
        });
    });




// $(function(){
//   var shrinkHeader = 300;
//   $(window).scroll(function() {
//     var scroll = getCurrentScroll();
//     if ( scroll >= shrinkHeader ) {
//       $(".gifmain").attr("src", "assets/gif/coocking_gif1.gif");
//     }
//     else {
//       $(".gifmain").attr("src", "");
//     }
//   });
//   function getCurrentScroll() {
//     return window.pageYOffset || document.documentElement.scrollTop;
//   }
// });

// $(window).scroll(function(){
//     var fromTopPx = 200; // distance to trigger
//     var scrolledFromtop = $(window).scrollTop();
//     if(scrolledFromtop > fromTopPx){
//       $(".gifmain").attr("src", "assets/gif/coocking_gif1.gif");
//     }else{
//       $(".gifmain").attr("src", "");
//     }
// });

//   $(window).scroll(function() {
//     $('.gifmain').css('display', 'none');
//     clearTimeout($.data(this, 'scrollTimer'));
//     $.data(this, 'scrollTimer', setTimeout(function() {
//        $('.gifmain').css('display', 'block');
//     }, 200));
// });
</script>

<script>
$('.comment-slider').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  adaptiveHeight: true,
  asNavFor: '.profile-slider'
});
$('.profile-slider').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.comment-slider',
  dots: false,
  arrows: false,
  centerMode: true,
  centerPadding: '1px',

  focusOnSelect: true,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: false,
        centerPadding: '3px',
      }
    },
  
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  ]

});





$("#demo_1").ionRangeSlider({
  min: 0,
  max: 100,
  onFinish: function(data) {
    console.log(data.from);
    if(data.from>95){
      window.location.replace("<?php echo base_url('/about-us')?>");
    }
  }
 
});



$(window).scroll(function() {
  $(".test").removeClass('stop_fixed');
  if ($(window).scrollTop() >= ($(document).height() - $(window).height())*1){
      //you are at bottom
     //alert(1)
  } 
});



// $('#demo_1').on('input', function(e){
//   alert( $(this).val() );
// });
</script>
</body>

</html>
