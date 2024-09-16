<header class="header_sec">
    	<nav class="navbar navbar-expand-lg navbar-light header_color px-md-0">
    		<div class="container">
       <a href="<?php echo base_url()?>">
          <img src="<?=$admin_url?>assets/images/Logo.svg" class="img-fluid logo_img"></a>
          <div class="d--none position-relative">
            <div class="d-flex address_info cursor-pointer"  data-toggle="modal" data-target="#locationModal">
              <div><img src="<?=$admin_url?>assets/images/location.png" class="img-fluid"></div>
              <p id="fill-add"><?=$this->session->userdata('city')?></p>
              <!-- <p class="min-max-991">Tower-A, Flat no. 854,...</p> -->
            </div>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <img class="hamberger" src="<?=$admin_url?>assets/images/Hamburger.png">
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="desktop-menu ml-auto">
              <ul class="navbar-nav ">
                <li class="nav-item active">
                  <a class="nav-link" href="<?=base_url()?>menu">Explore Menu </a>
                </li>
                <li class="nav-item">
               
                  <a class="nav-link " href="<?php echo base_url()?>gift-a-cart">Gift A Cart</a>
                </li>
                
                <li class="nav-item">
                  <a class="nav-link" href="<?=base_url()?>party-time">Party Time</a>
                </li> 

                <li class="nav-item active">
                  <a class="nav-link" href="<?=base_url()?>corporate-tie-up">Corporate Tie Up</a>
                </li>
               
               

                
               
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo base_url('/about-us')?>">About Us</a>
                </li>
                <?php if($this->session->userdata('user_id')==''){?>
                <li class="nav-item">
                  <button class="btn btn_signin ml-4" type="button" data-toggle="modal" data-target="#loginmodal">Sign In</button>
                </li>    
                <?php } else{?>
               <!-- <li class="nav-item">
                  <a class="nav-link" id="logout" href="<?php echo base_url('logout');?>">Logout</a>
                </li>-->
              <!--  <li class="nav-item">
                  <a href="<?php echo base_url('my-account');?>"><img  src="<?=$admin_url?>assets/images/empty.png" class="img-fluid empoty"></a>
                </li>-->

                <?php $str=trim($fullname);
                ?>
                <li class="nav-item">
                  <a href="<?php echo base_url('my-account');?>"><span class="Profile_letter"><?=$str[0]?></span></a>
                </li>
                <?php } if($this->session->userdata('cart_count')!=0){?>
                <li class="nav-item position-relative">
                  <a class="nav-link" href="<?=base_url()?>cart"><img  src="<?=$admin_url?>assets/images/cart.png" class="img-fluid "></a>
                  <span class="cart_count cart-count1" id="cart-count "><?php echo $this->session->userdata('cart_count');?></span>
                </li>
               <?php }else{?>
                <li class="nav-item position-relative">
                  <a class="nav-link" href="<?=base_url()?>no-order-emptystate"><img  src="<?=$admin_url?>assets/images/cart.png" class="img-fluid "></a>
                  <span class="cart_count" id="cart-count">0</span>
                </li>
               <?php }?>
              </ul>
            </div>
            <div class="side-menu">
              <ul class="navbar-nav">
                <div class="d-flex side-bottom pb-4 ">
                  
                  <!-- <div>
                    <div class="d-flex">
                      <div><a href=""><span class="Profile_letter">A</span></a></div>
                      <div>
                        <h1 class="profile-text pl-3 mb-2">Ravina Malik</h1>
                        <p class="edit-details" > <a href="#">Click</a>  to view or edit account details</p>
                      </div>
                    </div>
                  </div> -->
                 
                  <div class="">
                  <?php if($this->session->userdata('user_id')==''){?>
                    <div class="d-flex">
                        <!-- <div class="mr-3"><img class="" src="<?=$admin_url?>assets/images/empty.png1" alt=""></div> -->
                        <div>
                          <h1 class="profile-text  mb-2">Welcome!</h1>
                          <p class="fw-500"><a href="#" class="mr-2" data-toggle="modal" data-target="#loginmodal">Sign In</a> or <a href="#" class="ml-2" data-toggle="modal" data-target="#signupmodal">Sign Up</a></p>
                        </div>
                    </div>
                    
                  <?php } else {?> <div>
                    <div class="d-flex">
                    <?php $str=trim($fullname);
                ?>
                      <div><a href=""><span class="Profile_letter"><?=$str[0]?></span></a></div>
                      <div>
                        <h1 class="profile-text pl-3 mb-2"><?=$fullname?></h1>
                        <p class="edit-details" > <a href="<?php echo base_url('/my-account')?>">Click</a>  to view or edit account details</p>
                      </div>
                    </div>
                  </div><?php } ?>
                 

                  </div>
                  <img src="<?=$admin_url?>assets/images/cross.png" class="img-fluid ml-auto cross">
                  
                </div>
                
                
                <!-- active  -->
                <li class="nav-item ">
                  <a class="nav-link" href="<?=base_url()?>gift-a-cart"><img src="<?=$admin_url?>assets/images/gift.png">Gift A Cart</a>
                 
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="<?=base_url()?>party-time"><img src="<?=$admin_url?>assets/images/glass.png">Party Time</a>
                    
                </li>
                <li class="nav-item ">
                <input type="hidden" value='' class='emojis_val'>

                  <a class="nav-link" href="<?=base_url()?>corporate-tie-up"><img src="<?=$admin_url?>assets/images/corporate.png">Corporate Tie Up</a>
                </li>
                <?php if($this->session->userdata('user_id')!=''){?>
                <li class="nav-item accordion my--account" id="accordionExample">
                  <div class="card">
                    <div class="" id="headingTwo">
                        <button class="btn btn-block collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          <a class="nav-link d-flex" href="#">
                         <div>   <img class="cont--old" src="<?=$admin_url?>assets/images/my-account.png"></div>
                          <div>  <img class="cont--img" src="<?=$admin_url?>assets/images/cont.png" style='display:none'></div>
                            My Profile
                          </a>
                          <a class="nav-link" href="#"></a>
                        </button>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                      <div class="card-body pb-0">
                        <div class="nav-item ">
                          <a class="nav-link" href="<?php echo base_url('/order-history')?>"><img src="<?=$admin_url?>assets/images/clock.png">Order History</a>
                        </div>
                        <div class="nav-item ">
                          <a class="nav-link" href="<?php echo base_url('/saved-address')?>"><img src="<?=$admin_url?>assets/images/savedadd.png"> Saved Address</a>
                        </div>
                        <div class="nav-item ">
                          <a class="nav-link" href="<?php echo base_url('/my-favourites')?>"><img src="<?=$admin_url?>assets/images/favourites.png"> Favourites</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
                <?php } ?>
                <li class="nav-item  ">
                  <a class="nav-link" href="<?php echo base_url('/about-us')?>"><img src="<?=$admin_url?>assets/images/about.png">About Us</a>
                </li>
                <!-- <li class="nav-item  ">
                  <a class="nav-link" href="#"><img src="<?=$admin_url?>assets/images/contact.png">Contact Us</a>
                </li> -->
              
              </ul>
              <?php if($this->session->userdata('user_id')!=''){?>

              <ul class="navbar-nav mb-0 ">
                <li class="nav-item side-bottom-footer">
                  <a class="nav-link" href="<?php echo base_url('website/logout');?>"><img src="<?=$admin_url?>assets/images/logout.png">Logout</a>
                </li>
                <li class="reach_us mb-3">Reach Us at</li>
                <li><a class="number_ mb-2" href="#">+91 9292925353</a></li>
                <li><a class="number_ text_underline" href="#">hi@mylovetriangle.pizza</a></li>
                <!-- <li><a class="terms mb-2" href="#">Terms</a></li>
                <li><a class="terms mb-2" href="#">Privacy Policy</a></li>
                <li><a class="version" href="#">Version 0.1.02</a></li> -->
                
              </ul>
              <?php } ?>
              <div>
                
              </div>
            </div>
          </div>
		  	</div>
        
           
		  </nav>
    </header>
    <!-- Location Modal -->
    <div class="location-card" id="location-card">
      <div class="location-card-overlay"></div>
      <div class="d-flex paadd-24">
        <p class="mr-auto fw-500">Location</p>
        <div><img class="close-card cursor-pointer" data-dismiss="modal" aria-label="Close" src="<?=$admin_url?>assets/images/close.png" alt=""></div>
      </div>
      <div class="paadd-24">
      <p class="pr-md-4 pt-3 we_currently">We are currently delivering in Gurugram phase 1 to 5 only*</p>
      <form class="custom-form mt-3 location-search" action="">
        <div class="form-group">
          <input type="text" id="project13" class="form-control location_search" placeholder="Enter delivering location">
          <!-- <input type="hidden" id="project-id"> -->
          <input type="hidden" id="project-id1">
                            <input type="hidden" id="city"> 
                            <input type="hidden" id="latitude" value="">
                            <input type="hidden" id="longitude" value="">
                            <input type="hidden" id="stateName">
                            <input type="hidden" id="countryName">
                            <input type="hidden" id="postalCode">
                            <input type="hidden" id="locality">
                            <input type="hidden" id="political">
                            
                            <input type="hidden" id="route">
          <p id="project-description"></p>
        </div>
      </form>
     
      <div class="d-flex use_currext">
        <div><img class="" src="<?=$admin_url?>assets/images/location-yellow.png"></div>
        <button onclick="getLocation()"><p>Use Current Location</p><button>
      </div>
              </div>
 <?php if($this->session->userdata('user_id')!=''){ ?> 
 
      <div class=" h-209 custom-scrollbar">
        <?php 
        
     // if($getinfo){?>
         <div class="saved_locations ">
        <div class="d-flex loc_viewall mb-4 pb-2">
          <p class="p-sec mr-auto">Select from Saved Locations</p>
          <a href="<?php echo base_url('/saved-address')?>">View All</a>
        </div>
       
      
        <div class="form-group saved_addresses">
          <?php 
          $where1=array('user_id'=>$user_id);
          $getinfo=$this->cm->getRecords($where1,'mlt_address');
          if($getinfo){
         foreach($getinfo as $row){ ?>
          <div class="custom-control custom-radio pl-0">
            <input type="radio" id="savedAddress<?=$row->sk_address_id?>" name="customRadio"value="<?=$row->address_type?>" class="custom-control-input" onChange="viewAddress(<?=$row->sk_address_id?>)">
            <label class="custom-control-label" for="savedAddress<?=$row->sk_address_id?>">
              <div class="d-flex home-address">
               
                <div class="mr-2 pr-1"> <?php if($row->address_type=='Work'){?><img src="<?=$admin_url?>assets/images/work.png" alt=""><?php }
                else if($row->address_type=='Home'){?>
                  <img src="<?=$admin_url?>assets/images/home1.png" alt="">
               <?php  } elseif($row->address_type=='Other'){?>
                  <img src="<?=$admin_url?>assets/images/other.png" alt="">
                <?php } ?>
                  </div>
                <div>
                  <p class="fw-600 home"><?=$row->address_type?></p>
                  <p class="p-sec pt-2 fw-400 limit-one-line" id="full-add<?=$row->sk_address_id?>"><?=$row->house_no?> <?=$row->street?> <?=$row->area?>,<?=$row->city?>,<?=$row->state?>,<?=$row->country?>,<?=$row->pincode?></p></p>
                </div>
              </div>
            </label>

          </div>
          <?php }}?>

        </div>
      </div>
      <?php } ?>
    </div>
    </div>
        </div>

  <!-- LogIn Modal -->

    <div class="modal fade login-view" id="loginmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog mt-md-5 pt-md-3">
      <div class="modal-content">
      <div class="modal-body">
        <form class="custom-form formvalidation">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <p class="sign mb-4 ">sign in</p>
          <!-- <p class="already-in">Already have an account?<a class="in" href="#"> Sign In </a></p> -->
          <p class="already-in ">New User?<a class="in opensignupmodal" href="javascript:void(0)"  > SIGN UP </a></p>
          <div class="form-group position-relative number_valid country-code">
            <label>Enter your mobile number</label>
            <input type="number" class="form-control log-inn restrict_alphabits " name="mobile" id="mobile" maxlength="10" minlength="10" placeholder="9933554488" autocomplete="off" required>
            <p class="saved-number p-sec fw-500"><span>+91</span></p>
            <small class='error'></small>
            <img class="number_success" src="<?=$admin_url?>assets/images/blue-tick.png" alt="">
          </div>
            <!-- <p class="verification-code mt-2 ">We have sent the OTP to your mobile number</p>
            <div class="form-group">
              <label class="otp ">Enter OTP</label>
              <div class="d-flex ">
                <input type="number" class="form-control inputs mt-2 mr-3" id="number11" name="number11" maxlength="1">
                <input type="number" class="form-control inputs  mt-2 mr-3" id="number21" name="number21" maxlength="1">
                <input type="number" class="form-control inputs  mt-2 mr-3" id="number31" name="number31" maxlength="1">
                <input type="number" class="form-control inputs  mt-2 " id="number41" name="number41" maxlength="1">
              </div>
              <p class=" mt-3 "><a class="resend--otp" href="javascript:void(0)">Resend OTP</a></p>
            </div> -->
          
          <button type="submit" class="default-btn proceed45" id="sigin-proceed">Proceed</button>
          <button type="submit" class="default-btn logIn">Log In</button>
        </form>
      </div>
    </div>
  </div>
</div>

 <!-- Otp Modal -->
 <div class="modal fade login-view otp-view" id="otpmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <form class="custom-form formvalidation">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <p class="sign mb-md-4 mb-3 text-transform-none">Verify Number</p>          
            <!-- <p class="verification-code mt-2 ">We have sent the OTP to your mobile number</p> -->
            <p class="p-sec mb-2 pb-md-1 d_sm_none">We have sent the OTP to </p>
            <div class="d-flex mb-md-4  ">
              <p class="p-sec mb-md-2 pb-md-1 fs-10 d_md_none">We have sent the OTP to </p>
              <p class="saved-number p-sec fw-500  fs-10"><span id="country-code" class="gray-numb">+91</span>  <span class="otpnumber">8959494988</span></p>
              <div class="d-flex ml-2 mt-md-1 pl-md-1 edit-num cursor-pointer">
                <div class="mr-2 "><img src="<?php echo base_url()?>assets/images/edit-green.png" alt=""></div>
                <p class="p-sec fs-10" id="edit">Edit</p>
                <input type="hidden" value="" id="typemodel">
              </div>
            </div>
            <div class="form-group">
              <label class="otp ">Enter OTP</label>
              <div class="d-flex ">
                <input type="number" class="form-control inputs mt-2 mr-3" id="number11" name="number11" maxlength="1">
                <input type="number" class="form-control inputs  mt-2 mr-3" id="number21" name="number21" maxlength="1">
                <input type="number" class="form-control inputs  mt-2 mr-3" id="number31" name="number31" maxlength="1">
                <input type="number" class="form-control inputs  mt-2 " id="number41" name="number41" maxlength="1">
              </div>
              <p class=" mt-3 "><a class="resend--otp" id="resend--otp" href="javascript:void(0)" style="display:block">Resend OTP</a></p>
            <small class='wrong-otp'></small><br>
            <span id="resend-otp"></span>
            </div>
            <div><span id="timer"></span></div>

          
          <button type="submit" class="default-btn" id="proceed-otp" disabled>Proceed</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- SingnUp Modal -->
<div class="modal fade signup-view" id="signupmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body ">
        <form class="custom-form formvalidation">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <p class="sign mb-3 ">sign up</p>
          <p class="already-in mb-4">Already Have An Account?<a class="in openloginmodal" href="#"> SIGN IN </a></p>

          <div class="form-group name_field">
            <label>Name*</label>
            <input type="name" class="form-control txtOnly" name="name" id="name" placeholder="marshal matthel" onkeypress='return blockSpecialChar(event)' data-bv-notempty-message="Please enter Name" required autocomplete="off">
          </div>

          <div class="form-group email_field">
            <label>Email*</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="abc@xyz.com" required autocomplete="off">
          </div>

          <div class="form-group num_field number_valid country-code position-relative">
            <label>Enter your mobile number</label>
            <input type="number" class="form-control log-inn restrict_alphabits" name="mobile" id="mobile1" placeholder="9535113232" maxlength="10" minlenght="10" required autocomplete="off">
            <img class="number_success" src="<?=$admin_url?>assets/images/blue-tick.png" alt="">
            <p class="saved-number p-sec fw-500"><span>+91</span></p>
            <small class='error'></small>
          </div>
          <div class="open_otp">
            <p class="verification-code">We have sent the OTP to your mobile number</p>
            <div class="form-group">
              <label class="otp ">Enter OTP</label>
              <div class="d-flex ">
                <input type="number" class="form-control inputs mt-2 mr-3" id="number1" name="number1" maxlength="1">
                <input type="number" class="form-control inputs mt-2 mr-3" id="number1" name="number1" maxlength="1">
                <input type="number" class="form-control inputs mt-2 mr-3" id="number1" name="number1" maxlength="1">
                <input type="number" class="form-control inputs mt-2" id="number1" name="number1" maxlength="1">
              </div>
              <p class=" mt-3 "><a class="resend--otp" href="javascript:void(0)">Resend OTP</a></p>
            </div>
          </div>
          <button type="submit" class="default-btn SignUp" id="signup">Proceed</button>
        <!--- <p class="mt-4 mb-4 orr">or</p>
          <p class=" vth-mails">Sign In with</p>
          <div class="mt-4 mb-5 social-media">
            <a href="#"> <img class="mr-3" src="<?=$admin_url?>assets/images/mail.png" alt=""></a>
            <a href="#"> <img src="<?=$admin_url?>assets/images/facebook.png" alt=""></a>
          </div>-->
        </form>
      </div>

    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade another_location" id="anotherlocationModal" tabindex="-1" aria-labelledby="anotherlocationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
     
      
      
   
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 >Choose Another Location</h4>
        <div class="position-relative mb-5"> 
          <img class="another--images"  src="<?=$admin_url?>assets/images/another-location.png" alt="">
          <div><img class="exclamation-image"  src="<?=$admin_url?>assets/images/exclamation.png" alt=""></div>
        </div>
        <h6 class="fs-20 text-center mb-3">We Currently do not serve in this location</h6>
        <p class="p-sec text-center">Please choose another location or contact us at <span> +91-9292925353 </span> for any help or assistance</p>
      </div>
    
    </div>
  </div>
</div>