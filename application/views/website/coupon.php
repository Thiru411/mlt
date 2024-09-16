<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php  $this->load->view('website/inc/scripts-top');?>

    <style>
        #ui-id-2{ height: 324px;width: 401px !important;padding: 30px 0 0 0;overflow-y: auto;z-index: 10000;background: #0A100D;border: 0;}
        #ui-id-2.ui-menu .ui-menu-item-wrapper{border-bottom: 1px solid rgb(170 174 187 / 16%) !important;padding: 0 0 16px 0;margin: 0 0 16px 0;}
        #ui-id-2.ui-menu .ui-menu-item-wrapper.ui-state-active{background: linear-gradient(0deg, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0.09)), #121212;border: 0;border-color: transparent;}
        #ui-id-2 .ui-menu-item-wrapper p{font-weight: 600;font-size: 16px;color: #FFFFFA;text-transform: capitalize;line-height: 24px;}
        #ui-id-2 .ui-menu-item-wrapper span{display: block;font-size: 14px;line-height: 22px;color: rgba(255, 255, 250, 0.8) !important;text-transform: capitalize;font-weight: 400;margin-top: 8px;}

        #map1{width: 100%;height: 149px;border-radius: 16px;}

        .ui-datepicker{z-index: 2000 !important;}
        @media only screen and (max-width: 426px) {  
            .modal-backdrop.show {opacity: 1;background: transparent;display: none;}  
            .close{display: none;}
            #ui-id-2 .ui-menu-item-wrapper p {  font-size: 12px;  line-height: 18px;}
            #ui-id-2 { width: 100% !important;  padding: 4px 23px 0 0;}
            #ui-id-2 .ui-menu-item-wrapper span {    font-size: 12px;    line-height: 18px;}
        }

        /* Rajesh */
        .pac-container {background-color: #FFF;z-index: 20000;position: fixed;display: inline-block;float: left;}
        .gm-style-iw-t{display:none;}
    </style>
    <title>Coupon page</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1Z3e-xBgzeKw10ou7QQ6NaNfcI3UZ4KM&libraries=places"></script> -->
    
</head>
<body>
    <div class="wrapper">
  <!--  <div class="d-flex customize_err_message ">
      <img class="" src="<?=$admin_url?>assets/images/cust.png">
      <p class="ml-md-2 align-self-center"><span class="fw-500">OOPS!</span>You’ve chosen maximum of 3 options</p>
  </div>-->
    <?php  $this->load->view('website/inc/header');?>
                                        <?php
                                                                                    
                                        $time = strtotime(date('H:i'));
                                        $time1=date('H:i');
                                        if((strtotime(date('Y-m-d H:i')))<=(strtotime(date('Y-m-d 12:00')))){
                                              $time = strtotime(date('12:00'));
                                             $time1=date('12:00');

                                        }
                                        $round = 30*60;
                                        $rounded = round($time / $round) * $round;
                                        $cur_given_time= date("H:i", $rounded);
                                        $tomdate= date("Y-m-d", strtotime('tomorrow'));
                                        $end_time="12:00 AM";
                                        $t1 = strtotime($post_date.$time1);
                                        $t2 = strtotime("$tomdate $end_time");
                                        $diff = $t2 - $t1;
                                        $no_hrs = $diff / ( 60 * 60 );
                                        $time_int=$no_hrs*2;
                                        $time=0;
                                        $output='';
                                        $rounded1='';
                                        $start_time=''; $rounded='8888';
                                        $output=$output."<option value=''>Select Time</option>";
                                        for($i=0;$i<$time_int;$i++){ 
                                            if(date('H:i',strtotime("today"))!=$rounded){
                                             $rounded=date('h:i A',ceil((strtotime('+'.$time.' minutes',strtotime(date($cur_given_time))))/1800)*1800);
                                            $rounded1=date('H:i',strtotime($rounded));
                                            $rounded1=date('h:i A',ceil((strtotime('+30 minutes',strtotime(date($rounded1))))/1800)*1800);
                                            $output=$output."<option value='$rounded - $rounded1'>$rounded - $rounded1</option>";
                                            $rounded=date('h:i A',strtotime($rounded));
                                            $rounded1=date('h:i A',strtotime($rounded1));
                                            $time=$time+30; 
                                            }
                                        }
                                        
                                    ?>
      
        <!-- Location Modal -->
        <input type="hidden" value="<?=$cart_count?>" id="small" >
                        <input type="hidden" value="<?=$cart_count1?>" id="big">
        <section class="coupon-page">
            <div class="container ">
                <div class="coupon-succesfull mb-3" id="successfull" style="display:none">
                    <div class="d-flex">
                        <div ><img src="<?=$admin_url?>assets/images/tick.png"></div>
                        <input type="hidden" value="0" name="coupon_id" class="coupon-id">
                        <input type="hidden" value="0" name="coupon_cost" class="coupon-cost">

                          <div class="text-succesfull fw-400 ml-3 pt-1"><span class="awesome fw-500 mr-2">Awesome!</span>You saved <span class="awesome fw-500" id="saved"> ₹100</span> on this order.</div>
                     </div>
                </div>
                <p class="coupon-title fw-600 d-md-block d-none">CheckOut</p>
                <p class="coupon-title-resp fw-600 d-md-none d-block text-center ">Cart Items</p>
                <div class="row">
                    <div class="col-md-8 card-padd">
                        <div class="card coupon-card-items">
                            <div class="card-bg d-flex">
                                <p class="carditems fw-600">Cart Items</p>
                                <p class="itemsno ml-auto fw-400" id="itemsno"><?=$items?> Items</p>
                            </div>
                           
                            
                            <div class="card-content">
                                            <?=$item_details?>
                                    
                                    

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                   <button type="button" class="btn btn-primary p-0 coupon-apply " data-toggle="modal" data-target="#applycoupon">
                            <div class="apply-coupon d-flex">
                                <div class="d-flex">
                                    <p class="apply-coupontxt fw-500">Apply coupon</p>
                                    <div class="align-self-center d-flex ">                                    
                                    <p id="coupon_code_after" class="coupon_code_after_text" style="display:none">hdsgf</p>
                                    <img class="applied mr-3" src="<?=$admin_url?>assets/images/applied.png" alt=""> 
                                         </div>
                                </div>
                                <div class="ml-auto">
                                    <img  src="<?=$admin_url?>assets/images/right.png">

                                </div>
                            </div>
                        </button>

                     <div class="total">
                            <div class="total-shipping">
                                <div class="d-flex mb-3">
                                    <p class="sub-total fw-600">Subtotal</p>
                                    <p class="total-amt fw-500  ml-auto" id="total-amt">₹<?=$cart_price?></p>
                                </div>

                                <div class="d-flex mb-3">
                                    <p class="sub-total fw-400 ">Shipping</p>
                                    <p class="charge fw-400 ml-auto">No extra charge </p>
                                </div>
                                <div class="d-flex mb-3">
                                    <p class="sub-total fw-400">Packaging</p>
                                    <p class="charge fw-400  ml-auto">No extra charge </p>
                                </div>
                                <div class="d-flex mb-3">
                                    <p class="sub-total fw-400 ">Discount</p>
                                    <p class="charge fw-400  ml-auto" id="discount-atm">0</p>
                                </div>
                                <div class="d-flex ">
                                    <p class="sub-total fw-400 ">Tax</p>
                                    <p class="charge fw-400 ml-auto">No Extra Charge</p>
                                </div>
                                
                            </div>
                            <div class="amount-total d-flex ">
                                <p class="sub-totals fw-600">TOTAL</p>
                                <p class="amount-final fw-500 ml-auto" id="amt-final">₹<?=$cart_price?></p>
                            </div>
                        </div>
                        <div class="procedd-bg">
                            <div class="d-flex">
                                <div>
                                    <p class="amt fw-500 mb-1" id="cart_total">₹<?=$cart_price?></p>
                                    <p class="amt-item fw-400" id="total_items_in_cart"><?=$items?> items in cart</p>
                                </div>
                                <input type="hidden" value="<?=$user_id?>" id="user-id">
                                <button type="button" class="proceed fw-600 ml-auto" >Proceed</button>
                             
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Button trigger modal -->
                    
                    
                    <!-- Modal -->
                    <div class="modal fade checkkk-out" id="Checkout" tabindex="-1" aria-labelledby="exampleModalLabel " aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Checkout As</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 position-relative">
                                        <div class="new-userrr">
                                            <img class="img-fluid polyee" src="<?=$admin_url?>assets/images/poly.png" alt="">
                                            <img class="img-fluid recttt" src="<?=$admin_url?>assets/images/recttt.png" alt="">
                                            <img class="img-fluid half-roundd" src="<?=$admin_url?>assets/images/half-round.png" alt="">
                                            <p class="fs-20 fw-600 mb-3 next-time ">Sign In To Save Your Details For Next Time </p>
                                            <button class="default-btn p-sec fw-600 in--now openloginmodal"  data-toggle="modal" data-target="#loginmodal">Sign in Now</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="in-later ">
                                            <p class="fw-600 or-later">OR</p>
                                            <p class="p-sec fw-400 sign--inn-later">Sign in  Later</p>
                                            <button class="default-btn p-sec fw-600 as-guest checkoutasguest">Checkout as Guest</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        </div>
                    </div>
            </div>
        </section>
        
    </div>

   <!-- Coupon -->
    <div class="modal fade coupon-popup" id="applycoupon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="d-flex d_md_none w-100 ">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="add-adres fw-600 align-self-center text-center w-100">View  Coupons</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><div><img class="img-fluid mb-md-1 mr-md-4" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                    </button>
                    <p class="coupon-modal fw-600 mb-4 d_sm_none">Coupons</p>
                    <!-- error-coupon -->
                    <div class="">
                        <input type="text" class="coupon-note coupon25 fw-500 coup-list  mb-3 coupon-code" placeholder="Enter Coupon Code">
                        <button type="button" class="apply fw-500" onClick="applycoupon('coupon code')">Apply</button>
                    </div>
                    <div class="d-flex err-full-msg error-msg ">
                        </div>
                    <div class="scroll custom-scrollbar">

                    <?php echo $coupons_user; if($coupon_details){
                            foreach($coupon_details as $info1){?>
                        <div class="custom-control custom-radio mb-3 ">
                            <input type="radio"  id="abc<?=$info1->sk_coupon_id?>" name="couponradio" class=" custom-control-input ">
                            <label class="custom-control-label coupon28  d-flex coupon25<?=$info1->sk_coupon_id?> " for="abc<?=$info1->sk_coupon_id?>"> <div>
                                <div><input type="hidden" value="<?=$info1->sk_coupon_id?>" id="coupon_id">
                                <p class="exl-text fs-20 coupon_code<?=$info1->sk_coupon_id?> fw-500"><?=$info1->coupon_code?></p>
                                <p class="discount fw-400">Get  <?=$info1->coupon_price?> off on your first order</p></div>
                                <input type="hidden" id="coupon_price<?=$info1->sk_coupon_id?>" value="<?=$info1->coupon_price?>">
                            </div>
                            <p class="apply-discount applycoupons10<?=$info1->sk_coupon_id?> text-center ml-auto mb-3"onClick="applycoupon(<?=$info1->sk_coupon_id?>)">Apply</p></label>
                        </div>
                        <div class="d-flex err-full-msg error-msg<?=$info1->sk_coupon_id?>" style="display:none">
                            <div class="oops-img img-fluid  mr-2 "> <img class="oops-img image22 d-none img10<?=$info1->sk_coupon_id?>" src="<?=$admin_url?>assets/images/oops.png"></div>
                            <p class="oops-bug fw-400"><span class="oops fw-500 mr-1 error1<?=$info1->sk_coupon_id?>"></span></p>
                        </div>
                        
                        <?php }}?>
                    </div>


                        
                                
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Add Address -->
    <div class="modal fade locat-place " id="address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex d_md_none w-100">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="add-adres fw-500 align-self-center text-center w-100 ">Add Address</p>
                    </div>
                <h4 class="modal-title d_sm_none" id="exampleModalLabel">Add Address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><div><img class="img-fluid mb-md-1" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                </button>
                </div>
                <div class="modal-body searchh-locate ">
                    <form class="custom-form mt-3 location-search" action="">
                        <div class="form-group">
                            <!-- <input type="text" class="form-control location_search" placeholder="Enter delivering location"> -->
                            <input type="text" id="project1" value="" class="form-control location_search ui-autocomplete-input" placeholder="Enter delivering location" autocomplete="off" >
                            <small class="err" style="color:red"></small>
                            <input type="hidden" id="project-id1">
                            <input type="hidden" id="city2">
                            <input type="hidden" id="latitude1" value="<?=$latitude?>">
                            <input type="hidden" id="longitude1" value="<?=$longitude?>">
                            <input type="hidden" id="stateName">
                            <input type="hidden" id="countryName">
                            <input type="hidden" id="postalCode">
                            <input type="hidden" id="locality">
                            <input type="hidden" id="political">
                            
                            <input type="hidden" id="route">




                            <p id="project-description1"></p>
                        </div>
                    </form>
                    <a href="#" onclick="getlocation()"><div class="d-flex use_currext">
                        <div><img class="" src="<?=$admin_url?>assets/images/location-yellow.png"></div>
                        <p>Use Current Location</p>
                        <input type="hidden" id="guest-add-address" value="">

                        </div>
                        </a>

                        <button class="default-btn p-sec fw-600 proceed1 proceed-locate ">Proceed</button>

                </div>
            
            </div>
        </div>
    </div>
    <!-- If customer already signIn select options -->
    <div class="modal fade proceed-popup " id="proceed" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <form class="" id="adddetails"  method="post">
                    <div class="d-flex d_md_none ">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="check-outt fw-600 align-self-center text-center w-100">Checkout</p>
                        
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><div><img class="img-fluid cancel-selc-option" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                    </button>
                    <h4 class="proceed-modal  fw-500 " id="username">Hello</h4>
                    <!-- <h4 class="proceed-modal  fw-500 " id="username1">Miguel</h4> -->
                    <div class="scrolling-bar custom-scrollbar">
                    <p class="whn-should mt-40 fw-500">Where should we deliver it?</p>
                            <div class="addd-panel ">
                                <p class="save--add fw-500 ">SAVED ADDRESS</p>
                                <div class="address-add">
                            </div> 
                            <div class="d-flex"> 
                                <button class="default-btn add--new add-address300 position-relative" id="add-address">Add New address<span class="ml-2">+</span> </button>
                                <br>
                            <!-- <div class="d-flex align-self-center use_currext ml-5">
                                <div><img class="" src="http://localhost/app/mlt/assets/images/location-yellow.png"></div>
                                <p>Use Current Location</p>
                            </div> -->
                            </div>
                            <small id="msg_terms"  style="color:red"></small>

                            </div>
                            <p class="whn-should mt-md-4 fw-500">When should we deliver it?</p>
                    
                            <div class="d-flex to-tom mt-3 position-relative ">
                                <div class="custom-control custom-radio  days-month"> 
                                    <input type="radio" id="customRadio11" name="delivery_date" value="<?=$post_date?>" class="custom-control-input today-tomaro delivery_date resetdate" checked>
                                    <label class="custom-control-label" for="customRadio11">
                                        <p class="fw-500 to-dayy ">Today</p>
                                    </label>
                                </div>
                                <?php $date= date("Y-m-d", strtotime('tomorrow'));?>

                                <div class="custom-control custom-radio  days-month">
                                    <input type="radio" id="customRadio21"  name="delivery_date" value="<?=$date?>" class="custom-control-input tomaro-today delivery_date resetdate">
                                    <label class="custom-control-label ml-md-3 ml-2 " for="customRadio21"> 
                                        
                                        <p class="fw-500 tom-dayy ">Tomorrow</p>   
                                    </label>
                                </div> 
                                <div class="custom-control custom-radio  days-month">
                                    <input type="radio" id="customRadio22"  name="delivery_date" value=""  class="custom-control-input tomaro-today delivery_date datepicker_data">
                                    <label class="custom-control-label ml-md-3 ml-2 p-0" for="customRadio22"> 
                                        <div class="form-group date position-relative mb-0">
                                            <input type='text' class='selectdate calenderdata calender-for-user' placeholder="Select Date" data-language='en' readonly /> 
                                            <div><img src="<?=base_url()?>assets/images/datearrow.png" ></div>
                                        </div>
                                    </label>
                                </div> 
                                <!-- <div class="form-group date position-relative">
                                    <input type='text' class='selectdate' placeholder="Select Date" data-language='en' /> 
                                    <div><img src="<?=base_url()?>assets/images/datearrow.png" ></div>
                                </div> -->
                                
                            </div>
                            <div class="coupon-succesfull2 mb-3" id="successfull2" style="display:none">
                    <div class="d-flex">
                        <div ><img src="<?=$admin_url?>assets/images/tick.png"></div>
                        <input type="hidden" value="0" name="coupon_id" class="coupon-id">
                        <input type="hidden" value="0" name="coupon_cost" class="coupon-cost">
                        <div class="text-succesfull fw-400 ml-3 pt-1">OOP's Something Went Wrong</div>

                     </div>
                </div>
                            <div class="  today-data" id="first" >
                                <p class="whn-should  fw-500">SELECT DELIVERY Time</p>
                                <div class="d-flex mt-3" >
                                    <div>
                                        <div class="custom-control custom-radio days-month day2">
                                            <input type="radio" id="customRadio31" name="delivery_time" value="1:30 PM" class="custom-control-input realtime noon-time1" >
                                            <label class="custom-control-label" for="customRadio31">  
                                                <p class="fw-500 noon-time time-fixed realtime " id="feasability-time-guest">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</p>
                                            </label>
                                        </div>
                                        
                                        <label class="earli-est earliest-time" >Earliest</label>
                                    </div>
  

                                        <div class="or-popup"> <p class="whn-should orrr fw-500">OR</p></div>
                                       <div>
                                            <div class="custom-control custom-radio days-month day2 time_day">
                                                    <input type="radio" id="customRadio38" name="delivery_time1" value="" class="custom-control-input" >
                                                    <label class="custom-control-label" for="customRadio38">  
                                                        <div class=" select-size select-time day3"> 
                                                            <select class="selectpicker size-base selct-time select-time1" >
                                                                <option value="">Pick Another Time</option>
                                                                <?=$output?>
                                                                
                                                            </select>
                                                        </div>
                                                    </label>
                                            
                                            </div>
                                            <small class="err-available1"></small>
                                        </div>
                                        


                            
                                </div>

<!-- 
                                <label class="earli-est earliest-time" >Earliest</label> -->
                                <!-- <small class="err-available1"></small> -->

                            </div>
                            
                                    
                            <div class="tomorrow-data">
                                <p class="whn-should mt-4 fw-500">Select delivery time from the slots</p>
                                <div class="d-flex calender_wrap mt-3 somedata" id="second">
                                    <!-- <div class="d-flex mt-3" >
                                        <div class="custom-control custom-radio days-month day4 ">
                                            <input type="radio" id="customRadio323" name="delivery_time1" value="1:30 PM" class="custom-control-input realtime delivery-time1 noon-time2" >
                                            <label class="custom-control-label" for="customRadio323"> 
                                                <p class="fw-500 noon-time3 time-fixed realtime  ">1:30 PM</p>
                                            </label>
                                        </div>
                                        <div class="or-popup "> <p class="whn-should orrr fw-500">OR</p></div>
                                        <div class=" select-size select-time day5 ">
                                            <select class="selectpicker size-base selct-time select-time2" >
                                            <option value="">Pick Another Time</option>
                                                <option value="12:00-12:30 PM">12:00 - 12:30 PM</option>
                                                <option value="12:30-1:00 PM">12:30 - 1:00 PM</option>
                                                <option value="1:00-1:30 PM">1:00 - 1:30 PM</option>
                                                <option value="1:30-2:30 PM">1:30 - 2:30 PM</option>
                                                <option value="2:30-3:00 PM">2:30 - 3:00 PM</option>
                                                <option value="2:30-3:00 PM">2:30 - 3:00 PM</option>
                                            
                                            </select>
                                        </div>
                                    </div>
                                    <label class="earli-est earliest-time1" >Earliest</label> -->
                                    <div class="custom-control custom-radio custom-control-inline pl-0">
                                        <input type="radio" id="tomorrow_time1" name="tomorrow_time"  value="1" class="custom-control-input add_tomorrow">
                                        <label class="custom-control-label" for="tomorrow_time1">
                                            <div class=" select-size select-timing">
                                                <select class="selectpicker selcect_delivery_time time-need1 ">
                                                    <option value=""></option>
                                                    <option value="12:00 PM - 12:30 PM">12:00 PM - 12:30 PM</option>
                                                    <option value="12:30 PM - 1:00 PM">12:30 PM - 1:00 PM</option>
                                                    <option value="1:00 PM - 1:30 PM">1:00 PM - 1:30 PM</option>
                                                    <option value="1:30 PM - 2:00 PM">1:30 PM - 2:00 PM</option>
                                                    <option value="2:00 PM - 2:30 PM">2:00 PM - 2:30 PM</option>
                                                    <option value="2:30 PM - 3:00 PM">2:30 PM - 3:00 PM</option>
                                                    <option value="3:00 PM - 3:30 PM">3:00 PM - 3:30 PM</option>
                                                    <option value="3:30 PM - 4:00 PM">3:30 PM - 4:00 PM</option>
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline pl-0">
                                        <input type="radio" id="tomorrow_time2" name="tomorrow_time"   value="2" class="custom-control-input add_tomorrow">
                                        <label class="custom-control-label" for="tomorrow_time2">
                                            <div class=" select-size select-timing ">
                                                <select class="selectpicker selcect_delivery_time1 time-need2 ">
                                                    <option value=""></option>
                                                    <option value="4:00 PM - 4:30 PM">4:00 PM - 4:30 PM</option>
                                                    <option value="4:30 PM - 5:00 PM">4:30 PM - 5:00 PM</option>
                                                    <option value="5:00 PM - 5:30 PM">5:00 PM - 5:30 PM</option>
                                                    <option value="5:30 PM - 6:00 PM">5:30 PM - 6:00 PM</option>
                                                    <option value="6:00 PM - 6:30 PM">6:00 PM - 6:30 PM</option>
                                                    <option value="6:30 PM - 7:30 PM">6:30 PM - 7:00 PM</option>
                                                    <option value="7:00 PM - 7:30 PM">7:00 PM - 7:30 PM</option>
                                                    <option value="7:30 PM - 8:00 PM">7:30 PM - 8:00 PM</option>
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline pl-0">
                                        <input type="radio" id="tomorrow_time3" name="tomorrow_time"  value="3" class="custom-control-input add_tomorrow">
                                        <label class="custom-control-label" for="tomorrow_time3">
                                            <div class=" select-size select-timing ">
                                                <select class="selectpicker selcect_delivery_time2 time-need3 ">
                                                    <option value=""></option>
                                                    <option value="8:00 PM - 8:30 PM">8:00 PM - 8:30 PM</option>
                                                    <option value="8:30 PM - 9:00 PM">8:30 PM - 9:00 PM</option>
                                                    <option value="9:00 PM - 9:30 PM">9:00 PM - 9:30 PM</option>
                                                    <option value="9:30 PM - 10:00 PM">9:30 PM - 10:00 PM</option>
                                                    <option value="10:00 PM - 10:30 PM">10:00 PM - 10:30 PM</option>
                                                    <option value="10:30 PM - 11:00 PM">10:30 PM - 11:00 PM</option>
                                                    <option value="11:00 PM - 11:30 PM">11:00 PM - 11:30 PM</option>
                                                    <option value="11:30 PM - 12:00 AM">11:30 PM - 12:00 AM</option>
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    
                                    
                                </div>
                                <p class="whn-should slot slot22 mt-4 fw-500"> <a class="exact-time" href="#"> </a></p>
                            </div>




                            <div class="datepicker_tomorrow-data">
                                <p class="whn-should mt-4 fw-500">Select delivery time from the slots</p>
                                <div class="d-flex calender_wrap  mt-3 somedata" id="second">
                                    <div class="custom-control custom-radio custom-control-inline pl-0">
                                        <input type="radio" id="calender_time" name="guestcalender_time" value="" class="custom-control-input add_claender">
                                        <label class="custom-control-label" for="calender_time">
                                            <div class=" select-size select-timing ">
                                                <select class="selectpicker selcect_delivery_time time-need4  ">
                                                    <option value=""></option>
                                                    <option value="12:00 PM - 12:30 PM">12:00 PM - 12:30 PM</option>
                                                    <option value="12:30 PM - 1:00 PM">12:30 PM - 1:00 PM</option>
                                                    <option value="1:00 PM - 1:30 PM">1:00 PM - 1:30 PM</option>
                                                    <option value="1:30 PM - 2:00 PM">1:30 PM - 2:00 PM</option>
                                                    <option value="2:00 PM - 2:30 PM">2:00 PM - 2:30 PM</option>
                                                    <option value="2:30 PM - 3:00 PM">2:30 PM - 3:00 PM</option>
                                                    <option value="3:00 PM - 3:30 PM">3:00 PM - 3:30 PM</option>
                                                    <option value="3:30 PM - 4:00 PM">3:30 PM - 4:00 PM</option>
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline pl-0">
                                        <input type="radio" id="calender_time1"  name="guestcalender_time"  value="2" class="custom-control-input add_claender">
                                        <label class="custom-control-label" for="calender_time1">
                                            <div class=" select-size select-timing ">
                                                <select class="selectpicker selcect_delivery_time1 time-need6 ">
                                                    <option value=""></option>
                                                    <option value="4:00 PM - 4:30 PM">4:00 PM - 4:30 PM</option>
                                                    <option value="4:30 PM - 5:00 PM">4:30 PM - 5:00 PM</option>
                                                    <option value="5:00 PM - 5:30 PM">5:00 PM - 5:30 PM</option>
                                                    <option value="5:30 PM - 6:00 PM">5:30 PM - 6:00 PM</option>
                                                    <option value="6:00 PM - 6:30 PM">6:00 PM - 6:30 PM</option>
                                                    <option value="6:30 PM - 7:30 PM">6:30 PM - 7:00 PM</option>
                                                    <option value="7:00 PM - 7:30 PM">7:00 PM - 7:30 PM</option>
                                                    <option value="7:30 PM - 8:00 PM">7:30 PM - 8:00 PM</option>
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline pl-0">
                                        <input type="radio" id="calender_time2"  name="guestcalender_time" value="3" class="custom-control-input add_claender">
                                        <label class="custom-control-label" for="calender_time2">
                                            <div class=" select-size select-timing ">
                                                <select class="selectpicker selcect_delivery_time2 time-need7 ">
                                                    <option value=""></option>
                                                    <option value="8:00 PM - 8:30 PM">8:00 PM - 8:30 PM</option>
                                                    <option value="8:30 PM - 9:00 PM">8:30 PM - 9:00 PM</option>
                                                    <option value="9:00 PM - 9:30 PM">9:00 PM - 9:30 PM</option>
                                                    <option value="9:30 PM - 10:00 PM">9:30 PM - 10:00 PM</option>
                                                    <option value="10:00 PM - 10:30 PM">10:00 PM - 10:30 PM</option>
                                                    <option value="10:30 PM - 11:00 PM">10:30 PM - 11:00 PM</option>
                                                    <option value="11:00 PM - 11:30 PM">11:00 PM - 11:30 PM</option>
                                                    <option value="11:30 PM - 12:00 AM">11:30 PM - 12:00 AM</option>
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                    
                                    
                                    
                                </div>
                                <p class="whn-should slot slot24 mt-2 fw-500"> <a class="exact-time" href="#"> </a></p>
                            </div>



                            <div id="extra-order" style="display:none">
                                <p class="whn-should mt-40 fw-500">how do you want your order?</p>
                                <p class="can_choose">YOU CAN CHOOSE THE FREQUENCY OF THE DELIVERY OF YOUR ORDER</p>
                                <div class=" mt-3" >
                                    <div class="custom-control custom-radio days-month day4  custom-control-inline mb-3">
                                        <input type="radio" id="all_at_once" name="order_type" value="All At Once(₹0)" class="custom-control-input realtime delivery-time1 noon-time2" >
                                        <label class="custom-control-label" for="all_at_once"> 
                                            <p class="fw-500 noon-time3 time-fixed realtime  ">All At Once(₹0)</p>
                                        </label>
                                    </div>

                                    <div class="custom-control custom-radio days-month day4  custom-control-inline mb-3">
                                        <input type="radio" id="all_at_once1" name="order_type" value="Every 10 Mins(+₹2000)" class="custom-control-input realtime delivery-time1 noon-time2" >
                                        <label class="custom-control-label" for="all_at_once1"> 
                                            <p class="fw-500 noon-time3 time-fixed realtime  ">Every 10 Mins(+₹2000)</p>
                                        </label>
                                    </div>

                                    <div class="custom-control custom-radio days-month day4  custom-control-inline mb-3">
                                        <input type="radio" id="all_at_once2" name="order_type" value="Every 20 MINS(+₹3000)" class="custom-control-input realtime delivery-time1 noon-time2" >
                                        <label class="custom-control-label" for="all_at_once2"> 
                                            <p class="fw-500 noon-time3 time-fixed realtime  ">Every 20 MINS(+₹3000)</p>
                                        </label>
                                    </div>
                                </div>
                            </div>   

                            

                            <p class="whn-should mt-40 fw-500">How would you like to pay</p>
                            <div class="form-group addd-panel pay-panel">
                                <p class="save--add fw-500 ">Modes Of Payment</p>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio33" name="customRadio51pay" value="Cash" class="custom-control-input" >
                                    <label class="custom-control-label" for="customRadio33"><p class="p-sec amt-type">Cash/Card on Delivery</p></label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio32" name="customRadio51pay" value="online" class="custom-control-input"  >
                                    <label class="custom-control-label" for="customRadio32" ><p class="p-sec amt-type">Pay Online</p></label>
                                </div>
                            </div>
                    </div>  

                    <div class="custom-control custom-checkbox user-condition d-md-none d-block position-relative">
                        <input type="checkbox" class="custom-control-input" id="customCheck1" name="condition">
                        <label class="custom-control-label " for="customCheck1">I agree to the Terms and Conditions*</label>
                    </div> 
                    </div>
                  

                    
                     <div class="popup-bill">
                            <div class=" two-cart d-flex">
                                <div>  
                                <h5 class="total-cost fw-500">₹1270</h5>
                                <p class="two-items getitems ">2 Items in cart</p>
                                </div>
                                <button type="submit" class="default-btn  view--cartt  place-ur fw-600 place_your_order place_order">Place Your Order </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Iframe Map -->
    <div class="modal fade proceed-popup" id="iframemap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mx-480">
            <div class="modal-content">
                <div class="modal-body Pr_0">
                    <div class="d-flex d_md_none">
                        <div class="ml-3">
                            <a href="#" class="back_btn"data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="add-adres fw-600 align-self-center text-center w-100 mb-4 mb-md-0">Add Address</p>
                        
                    </div>
                        <div class="d-flex iframe-address pr_40">
                            <h4 class="proceed-modal d_sm_none fw-500 border-0 pb-0">Add Address</h4>
                            <button type="button" class="close align-self-center ml-auto" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><div><img class="img-fluid " src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                            </button>
                        </div>
                        <div class=" pop-up-pad iframe-address-scroll custom-scrollbar pr_40">
                            <div class="text-center">
      
                            <div id="map"></div>
                            </div>
                            <div class="address">
                                    <div class="d-flex mt-2">
                                          <div>
                                                 <img src="<?=$admin_url?>assets/images/modal-address.png" class="img-fluid location_images mr-2">
                                          </div>
                                          <div>
                                              <h6 class="address-text" id="address-text">
                                              </h6>
                                          </div>
                                          <div class="ml-auto">
                                                  <img src="<?=$admin_url?>assets/images/modal-cross.png" class="img-fluid">
                                          </div>
                                    </div>
                                    <div>
                                          <p class="address-details" id="address-details">
                                          </p>
                                    </div>
                             </div>
                            <div class="confirm-modal pl-0 pr-0 text-right btn__position">
                                <button class="default-btn confirm  fw-600" >Confirm </button>
                            </div>
                        </div>
                </div>
                  
                
            </div>
        </div>
    </div>
    <!-- Iframe Map and Address -->
    <div class="modal fade proceed-popup" id="iframe_address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog mx-480">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="d-flex d_md_none back-addres">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="add-adres fw-600 align-self-center text-center w-100">Add Address</p>
                        
                    </div>
                       <div class="d-flex iframe-address px-40">
                            <h4 class="proceed-modal d_sm_none fw-500 iframe-address pb-10">Add Address</h4>
                            <button type="button" class="close  align-self-center ml-auto" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><div><img class="img-fluid mb-3 mr-2" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                            </button>
                        </div>
                        <div class=" pop-up-pad manual-add custom-scrollbar">
                            <div class="text-center">

                            <div id="map1"></div>
                            </div>
                            <!---->
                             <div class="address">
                                    <div class="d-flex mt-2">
                                          <div class="align-self-center">
                                                 <img src="<?=$admin_url?>assets/images/modal-address.png" class="img-fluid location_images mr-2">
                                          </div>
                                          <div>
                                              <h6 class="address-text1" id="address-text1">
                                              </h6>
                                          </div>
                                          <div class="ml-auto">
                                                  <img src="<?=$admin_url?>assets/images/modal-cross.png" class="img-fluid">
                                          </div>
                                    </div>
                                    <div>
                                          <p class="address-details" id="address-details1">
                                          </p>
                                    </div>
                             </div>
                            
                            <form class="formvalidation">
                                <div class="modal-inputs manual-addres mb-3 ">
                                    <div class="mb-40   form-group house_no">
                                            <!-- <div class="holder">House/Flat No. <span class="red"> *</span></div> -->
                                            <input id="input" size="18" type="text"  name="house" class="form-control house-no mb-2" placeholder="House/Flat No.*"  data-bv-notempty-message="Please Enter house/flat no." autocomplete="off" required>
                                    </div>   
                            
                                        <div class="mb-16 form-group land_mark">
                                            <!-- <div class="holder">Lankmark <span class="red"> *</span></div> -->
                                            <input id="input" size="18" type="text" name="land" class="form-control landmark1" placeholder="Landmark"  autocomplete="off">
                                        </div>

                                        
                                </div>
                                <?php if($user_id!=''){?>
                                <h6 class="loc-text">What type of location is this?</h6>
                                
                                <div class="form-group home_work ">
                                            <div class="d-flex flex-wrap">
                                                <div class="radio-example mx-400">
                                                        <!-- <div class="modal-radio btn-group btn-group-toggle" data-toggle="buttons">
                                                                <div class="mr-12 radio-clr ">
                                                                    <label class="btn btn-secondary">
                                                                        <div class="align-self-end"><img class="img-fluid" src="<?=$admin_url?>assets/images/om.svg" alt=""></div>
                                                                        <input type="radio" name="options" id="option1" value="Home" data-bv-field="city"> 
                                                                        <i class="fa fa-home mr-9" aria-hidden="true"></i>Home
                                                                        
                                                                    </label>
                                                                </div>

                                                                <div class="mr-12 radio-clr">
                                                                        <label class="btn btn-secondary">
                                                                            <div class=""><img class="img-fluid" src="<?=$admin_url?>assets/images/work-iframe.png" alt=""></div>
                                                                        <input type="radio" name="options" id="option2" value="Work" data-bv-field="city">
                                                                        <i class="fa fa-briefcase mr-9" aria-hidden="true"></i>Work
                                                                        </label>
                                                                </div>

                                                                <div class="radio-clr">
                                                                        <label class="btn btn-secondary">
                                                                            <div class="align-self-end"><img class="img-fluid" src="<?=$admin_url?>assets/images/other-iframe.png" alt=""></div>
                                                                        <input type="radio" name="options" id="option3" value="Other" data-bv-field="city" data-bv-notempty-message="Please select" required>
                                                                        <i class="fa fa-map-marker mr-9" aria-hidden="true"></i>Other
                                                                        </label>
                                                                </div>
                                                        </div> -->

                                                        <div class="custom-control custom-radio custom-control-inline location_delivery">
                                                            <input type="radio" name="options"  id="option11"  value="Home"  class="custom-control-input" data-bv-field="city">
                                                            <label class="custom-control-label" for="option11">
                                                                <img class="img-fluid mr-2" src="<?=$admin_url?>assets/images/om.svg" alt="">
                                                                 Home</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline location_delivery">
                                                            <input type="radio"  name="options" id="option21" value="Work"  class="custom-control-input" data-bv-field="city">
                                                            <label class="custom-control-label" for="option21">
                                                            <img class="img-fluid mr-2" src="<?=$admin_url?>assets/images/work-iframe.png" alt="" >Work</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline location_delivery">
                                                            <input type="radio"  name="options" id="option31" value="Other"  class="custom-control-input" data-bv-field="city" data-bv-notempty-message="Please select" required>
                                                            <label class="custom-control-label" for="option31">
                                                            <img class="img-fluid mr-2" src="<?=$admin_url?>assets/images/other-iframe.png" alt="">Other</label>
                                                        </div>
                                                </div>
                                            </div>
                                </div>
                                
                                <div class="confirm-modal pl-0 pr-0 text-right">
                                    <button type="submit" class="default-btn confirm  fw-600" id="confirm_save">Confirm & Save Address</button>
                                </div>
                                <?php }else{?>
                                    <div class="confirm-modal pl-0 pr-0 text-right">
                                    <button type="submit" class="default-btn confirm  fw-600" id="confirm_save">Confirm</button>
                                </div>
                               <?php  }?>
                            </form>
                        </div>
                </div>
                    
                
            </div>
        </div>
    </div>
    <!-- Guest SignIn -->
    <div class="modal fade proceed-popup" id="guestsign-in" tabindex="-1" aria-labelledby="guestsign-inLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                    <div class="modal-body ">
                    <form class="" id="checkoutdetails" method="post">
                        <div class="d-flex d_md_none">
                            <div class="ml-3">
                                <a href="#" class="back_btn"data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                            </div>
                            <p class="check-outt fw-600 align-self-center text-center w-100">Checkout</p>
                             
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><div><img class="img-fluid cancel--head" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                        </button>
                        <div class="d_md_none position-relative">
                            <div class="new-userrr">
                            <img class="img-fluid polyeee" src="<?=$admin_url?>assets/images/polyy.png" alt="">
                            <img class="img-fluid recttts" src="<?=$admin_url?>assets/images/rectts.png" alt="">
                            <img class="img-fluid half-rounddd" src="<?=$admin_url?>assets/images/half-round.png" alt="">
                                <p class="fs-20 fw-600 mb-3 next-time">Sign In To Save Your Details For Next Time </p>
                                <button class="default-btn p-sec fw-600 in--now openloginmodal"  data-toggle="modal" data-target="#loginmodal">Sign in Now</button>
                            </div>
                        </div>
                        
                        
                        <p class="proceed-modal  as-guestt fs-20 fw-600 ">Checkout as Guest</p>
                        <div class="coupon-succesfull1 mb-3" id="successfull1" style="display:none">
                        <div class="d-flex">
                            <input type="hidden" value="0" name="coupon_id" class="coupon-id">
                            <input type="hidden" value="0" name="coupon_cost" class="coupon-cost">

                            <div class="text-succesfull fw-400 ml-3 pt-1">OOP's Something Went Wrong</div>
                        </div>
                            </div>
                            <div class="scrolling-bar custom-scrollbar">
                                <div class="guest-signin">
                                    
                                    <div class="accordion mt-4 pt-md-3" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingtwo">
                                                <h2 class="mb-0">

                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                        data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        Where should we deliver it?
                                                        <div ><img src="<?=$admin_url?>assets/images/signin-tick.png" class="img-fluid float-right sign-tick"></div>
                                                    </button>
                                                </h2>
                                            </div>

                                            <div id="collapsetwo" class="collapse show" aria-labelledby="headingtwo"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="d-md-flex">
                                                <button type="button" class="default-btn add--new add-address mt-0 btn btn-link btn-block  add-address-new">add address <span class="ml-2">+</span></button>
                                                    
                                                
                                                <a href="#" onclick="getlocation10()">
                                                <div class="d-flex use_currext mt-1 mb-3 pl-md-5">
                                                        <div><img class="pl-md-2" src="<?=$admin_url?>assets/images/location-yellow.png"></div>
                                                        <p>Use Current Location</p>
                                                    </div>
                                                    </a>

                                                </div>
                                                    <div class="row">
                                                    <div class="form-group  col-md-6 mt-3">
                                                            <label for="exampleInputmoblie">Street Address*</label>
                                                            <input type="text" class="form-control input-text txtOnly location_search ui-autocomplete-input" id="area-fill" autocomplete="off" value="" name="address" >
                                                            <!-- <input type="text" id="project2" class=" town-fill form-control input-text txtOnly location_search ui-autocomplete-input" placeholder="Enter delivering location" autocomplete="off" value="<?=$city?>" name="city" > -->
                                                            <small class="error-area" style="color:red"></small>
                                                        </div>     
                                                        <div class="form-group col-md-6 mt-3">
                                                                <label for="exampleInputemail">Town/City*</label>
                                                                <!-- <input type="text" id="project2" value="" class="form-control location_search ui-autocomplete-input" placeholder="Enter delivering location" autocomplete="off" required> -->
                                                                <input type="hidden" id="project-id1">

                                                                <input type="text" id="town-fill" class="form-control input-text txtOnly" autocomplete="off" value="" name="city"readonly >
                                                            </div> 
                                                            <div class="form-group mails-guest  col-md-6 mt-3">
                                                                <label for="exampleInputemail">Pincode*</label>
                                                                <input type="number" class="form-control input-text " id="pincode-fill"  autocomplete="off" name="pincode" value=''  maxlength="6" minlength="6">
                                                            </div> 
  
                                                        <div class="form-group col-md-6 mt-3">
                                                            <label for="exampleInputname">Flat/House No.*</label>
                                                            <input type="text" class="form-control input-text house_no1" autocomplete="off" name="house_number" id="house_number" data-bv-notempty-message="Please enter name" requried>
                                                        </div>
                                                        <div class="form-group  col-md-6 mt-3">
                                                            <label for="exampleInputname">Landmark</label>
                                                            <input type="text" class="form-control input-text landmark " autocomplete="off" name="landmark" >
                                                        </div>
                                                 </div> 
                                                                    
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <p class="whn-should mt-4 fw-500">When should we deliver it?</p>

                                <div class="d-flex to-tom mt-3 position-relative ">
                                   <div class="custom-control custom-radio mb-md-3 days-month">
                                        <input type="radio" id="today1" name="delivery_date1" value="<?=$post_date?>" class="custom-control-input today-tomaro resetdate" checked>
                                        <label class="custom-control-label" for="today1">
                                            <p class="fw-500 to-dayy ">Today</p>
                                        </label>
                                    </div>
                                    <?php $date= date("Y-m-d", strtotime('tomorrow'));?>
                                    <div class="custom-control custom-radio mb-md-3 days-month">
                                        <input type="radio" id="today2" name="delivery_date1" value="<?=$date?>" class="custom-control-input tomaro-today resetdate">
                                        <label class="custom-control-label ml-md-3 ml-2 " for="today2">

                                            <p class="fw-500 tom-dayy ">Tomorrow</p>
                                        </label>
                                    </div>
                                    <!-- <div class="form-group date position-relative ml-3">
                                        <input type='text' class='selectdate' placeholder="Select Date" data-language='en' /> 
                                        <div><img src="<?=base_url()?>assets/images/datearrow.png" ></div>
                                                
                                    </div> -->
                                    <div class="custom-control custom-radio  days-month">
                                    <input type="radio" id="today3"  name="delivery_date1" value="" class="custom-control-input tomaro-today delivery_date">
                                    <label class="custom-control-label ml-md-3 ml-2 p-0" for="today3"> 
                                        <div class="form-group date position-relative mb-0">
                                            <input type='text' class='selectdate selectdate1 calenderdata calender-for-guest' placeholder="Select Date" data-language='en'  /> 
                                            <div><img src="<?=base_url()?>assets/images/datearrow.png" ></div>
                                        </div>
                                    </label>
                                </div> 
                                <!-- <input type='text' class='selectdate selectdate1 calenderdata calender-for-guest' placeholder="Select Date" data-language='en'  />  -->
                                    <!-- <div class="custom-control custom-radio mb-md-3 days-month">
                                        <input type="radio" id="today3" name="delivery_date1" value="select date" class="custom-control-input today-tomaro">
                                        <label class="custom-control-label" for="today3">
                                            <div class=" day7">
                                                <select class="selectpicker select__date ">
                                                    <option value=""></option>
                                                    <option value="12:00-12:30 PM">12:00 - 12:30 PM</option>
                                                    <option value="12:30-1:00 PM">12:30 - 1:00 PM</option>
                                                    <option value="1:00-1:30 PM">1:00 - 1:30 PM</option>
                                                    <option value="1:30-2:30 PM">1:30 - 2:30 PM</option>
                                                    <option value="2:30-3:00 PM">2:30 - 3:00 PM</option>
                                                    <option value="2:30-3:00 PM">2:30 - 3:00 PM</option>
                                                </select>
                                            </div>
                                        </label>
                                    </div> -->



                                    
                                </div>

                                <div class="  today-data" id="first">
                                    <p class="whn-should  fw-500">SELECT DELIVERY Time</p>
                                    <div class="d-flex mt-3">
                                        <div >
                                            <div class="custom-control custom-radio days-month day6 ">
                                                <input type="radio" id="customRadio317" name="delivery_time3" class="custom-control-input realtime-feas noon-time5" value="1:30 PM">
                                                <label class="custom-control-label" for="customRadio317">
                                                    <p class="fw-500 noon-time noon-time6 ">&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp</p>
                                                </label>
                                            </div>
                                            <label class="earli-est earliest-time2">Earliest</label>
                                         </div>
                                        <div class="or-popup">
                                            <p class="whn-should orrr fw-500">OR</p>
                                        </div>
                                        <div>
                                            <div class="custom-control custom-radio days-month day2 time_day">
                                                <input type="radio" id="customRadio39" name="delivery_time" value="" class="custom-control-input" >
                                                <label class="custom-control-label" for="customRadio39"> 
                                                    <div class=" select-size select-time day7">
                                                        <select class="selectpicker size-base selct-time7 selct-time"id="selct-time7">
                                                        <option value="">Pick Another Time</option>
                                                        <?=$output?>
                                                        
                                                       </select>
                                                    </div>
                                                </label>

                                            </div>
                                         <small class="err-available"></small>
                                        </div>

                                    </div>
                                    <input type="hidden"value="" id="time_select">
<!-- 
                                    <label class="earli-est earliest-time2">Earliest</label>
                                    <small class="err-available"></small> -->

                                


        <!-- Button trigger modal -->



                                
    </div>
                                <div class="tomorrow-data">
                                    <p class="whn-should mt-4 fw-500">Select delivery time from the slots</p>
                                    <div class="d-flex calender_wrap  mt-3 somedata" id="second">
                                        <!-- <div class="d-flex mt-3" >
                                            <div class="custom-control custom-radio days-month day4 ">
                                                <input type="radio" id="customRadio323" name="delivery_time1" value="1:30 PM" class="custom-control-input realtime delivery-time1 noon-time2" >
                                                <label class="custom-control-label" for="customRadio323"> 
                                                    <p class="fw-500 noon-time3 time-fixed realtime  ">1:30 PM</p>
                                                </label>
                                            </div>
                                            <div class="or-popup "> <p class="whn-should orrr fw-500">OR</p></div>
                                            <div class=" select-size select-time day5 ">
                                                <select class="selectpicker size-base selct-time select-time2" >
                                                <option value="">Pick Another Time</option>
                                                    <option value="12:00-12:30 PM">12:00 - 12:30 PM</option>
                                                    <option value="12:30-1:00 PM">12:30 - 1:00 PM</option>
                                                    <option value="1:00-1:30 PM">1:00 - 1:30 PM</option>
                                                    <option value="1:30-2:30 PM">1:30 - 2:30 PM</option>
                                                    <option value="2:30-3:00 PM">2:30 - 3:00 PM</option>
                                                    <option value="2:30-3:00 PM">2:30 - 3:00 PM</option>
                                                
                                                </select>
                                            </div>
                                        </div>
                                        <label class="earli-est earliest-time1" >Earliest</label> -->
                                        <div class="custom-control custom-radio custom-control-inline pl-0">
                                            <input type="radio" id="tomorrow_time4" name="tomorrow_time" value="1" class="custom-control-input add_tomorrow">
                                            <label class="custom-control-label" for="tomorrow_time4">
                                                <div class=" select-size select-timing">
                                                    <select class="selectpicker  selcect_delivery_time11 time-need8 " >
                                                        <option value=""></option>
                                                        <option value="12:00 PM - 12:30 PM">12:00 PM - 12:30 PM</option>
                                                        <option value="12:30 PM - 1:00 PM">12:30 PM - 1:00 PM</option>
                                                        <option value="1:00 PM - 1:30 PM">1:00 PM - 1:30 PM</option>
                                                        <option value="1:30 PM - 2:00 PM">1:30 PM - 2:00 PM</option>
                                                        <option value="2:00 PM - 2:30 PM">2:00 PM - 2:30 PM</option>
                                                        <option value="2:30 PM - 3:00 PM">2:30 PM - 3:00 PM</option>
                                                        <option value="3:00 PM - 3:30 PM">3:00 PM - 3:30 PM</option>
                                                        <option value="3:30 PM - 4:00 PM">3:30 PM - 4:00 PM</option>
                                                    </select>
                                                </div>
                                            </label>
                                            <div>

                                        </div>
                                </div>
                                        <div class="">
                                            <div class="custom-control custom-radio  custom-control-inline pl-0">
                                                <input type="radio" id="tomorrow_time5" name="tomorrow_time" value="2" class="custom-control-input add_tomorrow">
                                                <label class="custom-control-label" for="tomorrow_time5">
                                                    <div class=" select-size select-timing ml-md-3 ">
                                                        <select class="selectpicker selcect_delivery_time selcect_delivery_time12 time-need9 " >
                                                            <option value=""></option>
                                                            <option value="4:00 PM - 4:30 PM">4:00 PM - 4:30 PM</option>
                                                            <option value="4:30 PM - 5:00 PM">4:30 PM - 5:00 PM</option>
                                                            <option value="5:00 PM - 5:30 PM">5:00 PM - 5:30 PM</option>
                                                            <option value="5:30 PM - 6:00 PM">5:30 PM - 6:00 PM</option>
                                                            <option value="6:00 PM - 6:30 PM">6:00 PM - 6:30 PM</option>
                                                            <option value="6:30 PM - 7:30 PM">6:30 PM - 7:00 PM</option>
                                                            <option value="7:00 PM - 7:30 PM">7:00 PM - 7:30 PM</option>
                                                            <option value="7:30 PM - 8:00 PM">7:30 PM - 8:00 PM</option>
                                                        </select>
                                                    </div>
                                                </label>
                                                
                                            </div>
                                        </div>
                                        <div>
                                            <div class="custom-control custom-radio custom-control-inline pl-0">
                                                <input type="radio" id="tomorrow_time6" name="tomorrow_time"  value="3" class="custom-control-input add_tomorrow">
                                                <label class="custom-control-label" for="tomorrow_time6">
                                                    <div class=" select-size select-timing ml-md-3 ">
                                                        <select class="selectpicker selcect_delivery_time selcect_delivery_time13 time-need10 ">
                                                            <option value=""></option>
                                                            <option value="8:00 PM - 8:30 PM">8:00 PM - 8:30 PM</option>
                                                            <option value="8:30 PM - 9:00 PM">8:30 PM - 9:00 PM</option>
                                                            <option value="9:00 PM - 9:30 PM">9:00 PM - 9:30 PM</option>
                                                            <option value="9:30 PM - 10:00 PM">9:30 PM - 10:00 PM</option>
                                                            <option value="10:00 PM - 10:30 PM">10:00 PM - 10:30 PM</option>
                                                            <option value="10:30 PM - 11:00 PM">10:30 PM - 11:00 PM</option>
                                                            <option value="11:00 PM - 11:30 PM">11:00 PM - 11:30 PM</option>
                                                            <option value="11:30 PM - 12:00 AM">11:30 PM - 12:00 AM</option>
                                                        </select>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        
 
                                    </div>
                                    <p class="whn-should slot slot23 mt-4 fw-500"><a class=" exact-time1" href="#"></a></p>

                                </div>

                                <div class="datepicker_tomorrow-data">
                                    <p class="whn-should mt-4 fw-500">Select delivery time from the slots</p>
                                    <div class="d-flex calender_wrap mt-3 somedata" id="second">
                                       
                                        <div class="custom-control custom-radio custom-control-inline pl-0">
                                            <input type="radio" id="guestcalender_time4" name="guestcalender_time"  value="1" class="custom-control-input add_claender">
                                            <label class="custom-control-label" for="guestcalender_time4">
                                                <div class=" select-size select-timing">
                                                    <select class="selectpicker selcect_delivery_time selcect_delivery_time14 time-need11 ">
                                                        <option value=""></option>
                                                        <option value="12:00 PM - 12:30 PM">12:00 PM - 12:30 PM</option>
                                                        <option value="12:30 PM - 1:00 PM">12:30 PM - 1:00 PM</option>
                                                        <option value="1:00 PM - 1:30 PM">1:00 PM - 1:30 PM</option>
                                                        <option value="1:30 PM - 2:00 PM">1:30 PM - 2:00 PM</option>
                                                        <option value="2:00 PM - 2:30 PM">2:00 PM - 2:30 PM</option>
                                                        <option value="2:30 PM - 3:00 PM">2:30 PM - 3:00 PM</option>
                                                        <option value="3:00 PM - 3:30 PM">3:00 PM - 3:30 PM</option>
                                                        <option value="3:30 PM - 4:00 PM">3:30 PM - 4:00 PM</option>
                                                    </select>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        <div class="custom-control custom-radio custom-control-inline pl-0">
                                            <input type="radio" id="guestcalender_time5" name="guestcalender_time"  value="2" class="custom-control-input add_claender">
                                            <label class="custom-control-label" for="guestcalender_time5">
                                                <div class=" select-size select-timing ml-md-3 ">
                                                    <select class="selectpicker selcect_delivery_time selcect_delivery_time15 time-need41 ">
                                                        <option value=""></option>
                                                        <option value="4:00 PM - 4:30 PM">4:00 PM - 4:30 PM</option>
                                                        <option value="4:30 PM - 5:00 PM">4:30 PM - 5:00 PM</option>
                                                        <option value="5:00 PM - 5:30 PM">5:00 PM - 5:30 PM</option>
                                                        <option value="5:30 PM - 6:00 PM">5:30 PM - 6:00 PM</option>
                                                        <option value="6:00 PM - 6:30 PM">6:00 PM - 6:30 PM</option>
                                                        <option value="6:30 PM - 7:30 PM">6:30 PM - 7:00 PM</option>
                                                        <option value="7:00 PM - 7:30 PM">7:00 PM - 7:30 PM</option>
                                                        <option value="7:30 PM - 8:00 PM">7:30 PM - 8:00 PM</option>
                                                    </select>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline pl-0">
                                            <input type="radio" id="guestcalender_time6" name="guestcalender_time" value="3" class="custom-control-input add_claender">
                                            <label class="custom-control-label" for="guestcalender_time6">
                                                <div class=" select-size select-timing ml-md-3 ">
                                                    <select class="selectpicker selcect_delivery_time selcect_delivery_time16 time-need12 ">
                                                        <option value=""></option>
                                                        <option value="8:00 PM - 8:30 PM">8:00 PM - 8:30 PM</option>
                                                        <option value="8:30 PM - 9:00 PM">8:30 PM - 9:00 PM</option>
                                                        <option value="9:00 PM - 9:30 PM">9:00 PM - 9:30 PM</option>
                                                        <option value="9:30 PM - 10:00 PM">9:30 PM - 10:00 PM</option>
                                                        <option value="10:00 PM - 10:30 PM">10:00 PM - 10:30 PM</option>
                                                        <option value="10:30 PM - 11:00 PM">10:30 PM - 11:00 PM</option>
                                                        <option value="11:00 PM - 11:30 PM">11:00 PM - 11:30 PM</option>
                                                        <option value="11:30 PM - 12:00 AM">11:30 PM - 12:00 AM</option>
                                                    </select>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        
                                        
                                    </div>
                                    <p class="whn-should slot slot244 mt-2 fw-500"><a class=" exact-time1" href="#"></a></p>
                                  
                                </div>

                                <div id="extra-order1" style="display:none">
                                    <div class="d-flex mt-3 flex-wrap"  >
                                        <div class="custom-control custom-radio days-month day4 mr-3 mt-3">
                                            <input type="radio" id="all_at_once3" name="order_type" value="All At Once(₹0)" class="custom-control-input realtime delivery-time1 noon-time2" >
                                            <label class="custom-control-label" for="all_at_once3"> 
                                                <p class="fw-500 noon-time3 time-fixed realtime  ">All At Once(₹0)</p>
                                            </label>
                                        </div>

                                        <div class="custom-control custom-radio days-month day4 mr-3 mt-3 ">
                                            <input type="radio" id="all_at_once4" name="order_type" value="Every 10 Mins(+₹2000)" class="custom-control-input realtime delivery-time1 noon-time2" >
                                            <label class="custom-control-label" for="all_at_once4"> 
                                                <p class="fw-500 noon-time3 time-fixed realtime  ">Every 10 Mins(+₹2000)</p>
                                            </label>
                                        </div>

                                        <div class="custom-control custom-radio days-month day4 mr-3 mt-3">
                                            <input type="radio" id="all_at_once5" name="order_type" value="Every 20 MINS(+₹3000)" class="custom-control-input realtime delivery-time1 noon-time2" >
                                            <label class="custom-control-label" for="all_at_once5"> 
                                                <p class="fw-500 noon-time3 time-fixed realtime  ">Every 20 MINS(+₹3000)</p>
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                            
                                <div class="guest-signin">
                                    
                                    <div class="accordion mt-md-4 pt-md-3" id="accordionExample">
                                        <div class="card">
                                            <div class="card-header" id="headingOne">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button"
                                                        data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        Who are we delivering to?
                                                        <div ><img src="<?=$admin_url?>assets/images/signin-tick.png" class="img-fluid float-right sign-tick"></div>
                                                    </button>

                                                </h2>
                                            </div>

                                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                                data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="form-group col-md-6 pb-3">
                                                            <label for="exampleInputname">Name*</label>
                                                            <input type="text" class="form-control txtOnly" name="guest_name" autocomplete="off" id="exampleInputname" >
                                                        </div>
                                                        <div class="form-group position-relative number_valid country-code has-error  col-md-6 pb-3">
                                                            <label for="exampleInputmoblie">Mobile*</label>
                                                            <input type="number" class="form-control log-inn restrict_alphabits input-text " id="exampleInputmoblie"  name="guest_moblie"  maxlength="10" minlength="10" autocomplete="off">
                                                            <span class="validity"></span>
                                                            <p>+91</p>
                                                        </div>     
                                                        </div>  
                                                        <div class="form-group mails-guest pl-0 col-md-6">
                                                            <label for="exampleInputemail">Email*</label>
                                                            <input type="email" class="form-control input-text " name="email" autocomplete="off" id="exampleInputemail"  >
                                                        </div>                 
                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class=" form-group addd-panel pay-panel position-relative">
                                        <p class="save--add fw-500 ">How would you like to pay</p>
                                        <div class="custom-control custom-radio mt-md-3 mt-4">
                                            <input type="radio" id="customRadio73" name="customRadio5pay" value="Cash" class="custom-control-input"  >
                                            <label class="custom-control-label cash--card" for="customRadio73">Cash/Card on Delivery</label>
                                        </div>
                                        <div class="custom-control custom-radio mt-md-3 mt-4">
                                            <input type="radio" id="customRadio74" name="customRadio5pay" value="online" class="custom-control-input" >
                                            <label class="custom-control-label cash--card" for="customRadio74">Pay Online</label>
                                        </div>
                                    </div>

                                    <div class="custom-control custom-checkbox user-condition d-md-none d-block position-relative mt-4 pt-2">
                                        <input type="checkbox" class="custom-control-input" id="customCheck2" name="condition1">
                                        <label class="custom-control-label pt-0" for="customCheck2">I agree to the Terms and Conditions*</label>
                                    </div> 
                                
                                    
                                </div>
                            </div>
                        </div>
                        <div class="popup-bill">
                        <div class=" two-cart d-flex">
                            <div>
                                <h5 class="total-cost1 fw-500 total-price1">₹1270</h5>
                                <p class="two-items1 total-item1">2 Items in cart</p>
                            </div>
                            <button type="submit" class="default-btn  view--cartt  place-ur fw-600  place_order_checkout">Place Your Order </button>
                        </div>
                        </form>
                    </div>
                

            </div>
        </div>
    </div>

    <?php  $this->load->view('website/inc/footer');?>

    <!--customize-->
  <section class="customize-page">
    <div class="modal fade" id="customizeModal" data-keyboard="false" tabindex="-1"
      aria-labelledby="customizeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" id="toppingContent">
          
        </div>
      </div>
    </div>
  </section>


  

  <!-- Modal -->
<div class="modal fade time_slot_msg" id="time_slot_msg" tabindex="-1" aria-labelledby="time_slot_msgLabel" aria-hidden="true">
     <div class="time_slot_msg_overlay">  </div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            
        
            <div class="modal-body position-relative">
            <button type="button" class="close close_timeslot ml-auto" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                We're currently not serving the area selected by you. Please select another area and try again     
            </div>
            
            </div>
        </div>
  
</div>

    <?php  $this->load->view('website/inc/scripts-bottom');?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

// $("#CoverStartDateOtherPicker").datepicker({
//     onSelect: function () {
//         $("label[for='CoverStartDateOther']").text($(this).val());
//     }
// });
// $("#CoverStartDateOther").click(function () {
//     $("#CoverStartDateOtherPicker").datepicker("show");
// });




$( function() {
    $( ".selectdate" ).datepicker();
});


$(".place_order").click(function(){
  var form = $("#adddetails");
  form.validate({
    errorElement: 'span',
    errorClass: 'help-block',
    highlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').addClass("has-error");
      $(element).closest('.form-group').removeClass("has-success");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass("has-error");
      $(element).closest('.form-group').addClass("has-success");
    },
    rules: {
        name: {
            required: true,
        },
        moblie: {
            required: true,
            minlength:10,
            maxlength:10,
            digits:true
        },
        pincode: {
            required: true,
            minlength:6,
            maxlength:6,
            digits:true
        },
        email: {
            required: true,
            noSpace: true,
            email: true
        },
        houseno: {
            required: true,
        },
        address: {
            required: true,
        },
        city: {
            required: true,
        },
        // customRadio5pay: {
        //     required: true,
        // },
        customRadio51pay: {
            required: true,
        },
        condition: {
            required: true,
        },
        condition1: {
            required: true,
        },


        // tomorrow_time: {
        //     required: true,
        // },
        // guestcalender_time: {
        //     required: true,
        // }

    
    },
    messages: {
        name : {
            required: "Please enter name",
        },
        // customRadio5pay: {
        //     required: "Please select",
        // },
        customRadio51pay: {
            required: "Please select",
        },
        condition: {
            required: "Please select",
        },
        condition1: {
            required: "Please select",
        },
        moblie : {
            required: "Please enter valid number",
            minlength: "Enter 10 digit number",
            maxlength: "Enter 10 digit number",
            digits: "Only numbers are allowed in this field"
        },
        email : {
            required: "Please enter email ID",
            email: "Please enter valid email ID",
        },
        houseno: {
            required: "Please enter flat/house No",
        },
        address : {
            required: "Please enter address",
        },
       city : {
            required: "Please enter city",
        },
        pincode : {
            required: "Please enter pincode ",
            minlength: "Enter 6 digit pincode",
            maxlength: "Enter 6 digit pincode",
            digits: "Only numbers are allowed in this field"
        },
        // tomorrow_time: {
        //     required: "Please select time",
        // },
        // guestcalender_time: {
        //     required: "Please select time",
        // }
        
    }
  });
  if($("#adddetails").valid()){
      placeOrderuser(event);
  }
});
</script>

<script>
$(".place_order_checkout").click(function(){ 
  var form = $("#checkoutdetails");
  form.validate({
    ignore: [],
    errorElement: 'span',
    errorClass: 'help-block',
    highlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').addClass("has-error");
      $(element).closest('.form-group').removeClass("has-success");
    },
    unhighlight: function(element, errorClass, validClass) {
      $(element).closest('.form-group').removeClass("has-error");
      $(element).closest('.form-group').addClass("has-success");
    },
    rules: {
        guest_name: {
            required: true,
        },
        guest_moblie: {
            required: true,
            minlength:10,
            maxlength:10,
            digits:true
        },
        pincode: {
            required: true,
            minlength:6,
            maxlength:6,
            digits:true
        },
        email: {
            required: true,
            // noSpace: true,
            email: true
        },
        house_number: {
            required: true,
        },
        landmark: {
            required: false,
        },
        address: {
            required: true,
        },
        city: {
            required: true,
        },
        customRadio5pay: {
            required: true,
        },
        // customRadio51pay: {
        //     required: true,
        // },
        // tomorrow_time: {
        //     required: true,
        // },
        // condition1: {
        //     required: true,
        // },

        // guestcalender_time: {
        //     required: true,
        // }
    },
    messages: {
        guest_name : {
            required: "Please enter name",
        },
        customRadio5pay: {
            required: "Please select",
        },
        // customRadio51pay: {
        //     required: "Please select",
        // },
        // condition1: {
        //     required: "Please select",
        // },
        guest_moblie : {
            required: "Please enter valid number",
            minlength: "Enter 10 digit number",
            maxlength: "Enter 10 digit number",
            digits: "Only numbers are allowed in this field"
        },
        email : {
            required: "Please enter email ID",
            email: "Please enter valid email ID",
        },
        house_number: {
            required: "Please enter flat/house No",
        },
        address : {
            required: "Please enter address",
        },
       city : {
            required: "Please enter city",
        },
        pincode : {
            required: "Please enter pincode ",
            minlength: "Enter 6 digit pincode",
            maxlength: "Enter 6 digit pincode",
            digits: "Only numbers are allowed in this field"
        },
        // tomorrow_time: {
        //     required: "Please select time",
        // },
        // guestcalender_time: {
        //     required: "Please select time",
        // },
        
    }
  });

  if($("#checkoutdetails").valid()){
      placeOrderGuest(event);
  }
  
});

// $('#today1').change(function () {
//     if($(this).is(':checked')) {  
//         $('.add_tomorrow').removeAttr('name');
//         $('.add_claender').removeAttr('name', 'guestcalender_time');
//     }
// });

// $('#customRadio11').change(function () {
//     if($(this).is(':checked')) {  
//         $('.add_tomorrow').removeAttr('name');
//         $('.add_claender').removeAttr('name', 'guestcalender_time');
//     }
// });

// $('#today2').change(function () {
//     if($(this).is(':checked')) {   
//         $('.add_tomorrow').attr('name', 'tomorrow_time');
//         $('.add_claender').removeAttr('name', 'guestcalender_time');
//     }
// });

// $('#customRadio21').change(function () {
//     if($(this).is(':checked')) {   
//         $('.add_tomorrow').attr('name', 'tomorrow_time');
//         $('.add_claender').removeAttr('name', 'guestcalender_time');
//     }
// });

// $(".selectdate1").datepicker({
//     onSelect: function() {
//     }
// }).on("change", function() {
//     $('.add_claender').attr('name', 'guestcalender_time');
//     $('.add_tomorrow').removeAttr('name');
// });

// $(".calender-for-user").datepicker({
//     onSelect: function() {
//     }
// }).on("change", function() {
//     $('.add_claender').attr('name', 'guestcalender_time');
//     $('.add_tomorrow').removeAttr('name');
// });
</script>
<script>
        var IsplaceChange = false;
        function initialize() { 

          var input = document.getElementById('project1');

		  var options = {
        types: ['establishment', 'geocode'],
			  componentRestrictions: {country: "IN"}
			 };


          var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
             var place = autocomplete.getPlace();
             let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:place.geometry.location.lat(),lon:place.geometry.location.lng()},
                    success: function (response){
                        var resp = $.parseJSON(response);
                         if(resp.time==2){
                            $(".err").text('');          

                            $('#time_slot_msg').modal('show');
                            $('.proceed-locate').attr('disabled',true);
                        }
                        else{ 
                            $(".err").text('');          

                 IsplaceChange = true;
                 document.getElementById('city2').value = place.name;
                $('.address-text').text(place.name);
                 document.getElementById('latitude1').value = place.geometry.location.lat();
                 document.getElementById('longitude1').value = place.geometry.location.lng();
                 
                 var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                 geocoder = new google.maps.Geocoder();
                 geocoder.geocode({'latLng': latlng}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                         if (results[0]) {
                             for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
                                 } 
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                }
                                if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'political'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;

                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                 }
                             }
                       }
                       var input2 = document.getElementById('project1').value;
                       $('#address-details').text(input2);
                       
                         } else {
                         alert("Geocoder failed due to: " + status);
                     }
             });
            
                         $(".err").html('');          
                            $('.proceed-locate').attr('disabled',false);
                            initMap();

                        }
                    }
                });
             });
             

        }
        google.maps.event.addDomListener(window, 'load', initialize);



















        function initialize2() { 
          var input = document.getElementById('area-fill');
		  var options = {
        types: ['establishment', 'geocode'],
			  componentRestrictions: {country: "IN"}
			 };
          var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
             var place = autocomplete.getPlace();
                 IsplaceChange = true;
                 $('.error-area').html('');

                 document.getElementById('city2').value = place.name;
                $('.address-text').text(place.name);
                 document.getElementById('latitude1').value = place.geometry.location.lat();
                 document.getElementById('longitude1').value = place.geometry.location.lng();
                 var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                 geocoder = new google.maps.Geocoder();
                 geocoder.geocode({'latLng': latlng}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                         if (results[0]) {
                             for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                 if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                if (results[0].address_components[j].types[0] == 'route'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('route').value = results[0].address_components[j].long_name;
                                 } if (results[0].address_components[j].types[0] == 'political'){
                                   
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;

                                 
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                 
                                 }
                             }
                             
                       }
                       var input2 = document.getElementById('project1').value;
                       $('#address-details').text(input2);
                       
                         } else {
                         alert("Geocoder failed due to: " + status);
                     }
             });
             var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==1){
                            $(".noon-time6").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                         $(".noon-time5").val('');
                            $('.place_order_checkout').attr('disabled',true);

                        }else if(resp.time==2){
                            $('#time_slot_msg').modal('show');
                            $('.place_order_checkout').attr('disabled',true);

                        }
                        else{
                            let time = resp.time;
                            let time1=time.split('-');
                            $(".noon-time6").html(time1[0]+' '+time1[1]);                                                    
                        // $(".noon-time6").html(resp.time);
                         $(".noon-time5").val(time1[0]+' '+time1[1]);
                            $('.place_order_checkout').attr('disabled',false);

                           

 
                       }
                    }
             });
            });
             $("#area-fill").keydown(function () {
                IsplaceChange = false;
             });
        }
        google.maps.event.addDomListener(window, 'load', initialize2);


        
    </script>

<script type="text/javascript">
            var latitude = Number(document.getElementById("latitude1").value);
            var longitude = Number(document.getElementById("longitude1").value);
            var map;
            var marker;
            var myLatlng = new google.maps.LatLng(latitude,longitude);
            var geocoder = new google.maps.Geocoder();
            var infowindow = new google.maps.InfoWindow();
            function initialize(){
                var mapOptions = {
                    zoom: 18,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: [
                        { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
                        {
                            featureType: "administrative.locality",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "poi",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "geometry",
                            stylers: [{ color: "#263c3f" }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#6b9a76" }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry",
                            stylers: [{ color: "#38414e" }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry.stroke",
                            stylers: [{ color: "#212a37" }],
                        },
                        {
                            featureType: "road",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#9ca5b3" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry",
                            stylers: [{ color: "#746855" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry.stroke",
                            stylers: [{ color: "#1f2835" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#f3d19c" }],
                        },
                        {
                            featureType: "transit",
                            elementType: "geometry",
                            stylers: [{ color: "#2f3948" }],
                        },
                        {
                            featureType: "transit.station",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [{ color: "#17263c" }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#515c6d" }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.stroke",
                            stylers: [{ color: "#17263c" }],
                        },
                    ],
                };
		       
                map = new google.maps.Map(document.getElementById("map"), mapOptions);
                var iconBase = '../mlt/assets/images/';
                marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    draggable: true,
                    icon: iconBase + 'location_pin.png'
                });     
                
                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            
                            $('#latitude1').val(marker.getPosition().lat());
                            $('#longitude1').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                               
                google.maps.event.addListener(marker, 'dragend', function() {

                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                                $('#address').val(results[0].formatted_address);
                                $('#latitude1').val(marker.getPosition().lat());
                                $('#longitude1').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                            }
                        }
                    });
                });
            
            }
            
            //google.maps.event.addDomListener(window, 'load', initialize);
        </script> 
      
      <script>
        
 let faddress='';
        
        
        function initMap() {
            var latitude = Number(document.getElementById("latitude1").value);
            var longitude = Number(document.getElementById("longitude1").value);
            // var uluru = {
            //     lat: latitude,
            //     lng: longitude
            // };
            var myLatlng = new google.maps.LatLng(latitude,longitude);
            var mapOptions = {
                    zoom: 18,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: [
                        { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
                        {
                            featureType: "administrative.locality",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "poi",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "geometry",
                            stylers: [{ color: "#263c3f" }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#6b9a76" }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry",
                            stylers: [{ color: "#38414e" }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry.stroke",
                            stylers: [{ color: "#212a37" }],
                        },
                        {
                            featureType: "road",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#9ca5b3" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry",
                            stylers: [{ color: "#746855" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry.stroke",
                            stylers: [{ color: "#1f2835" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#f3d19c" }],
                        },
                        {
                            featureType: "transit",
                            elementType: "geometry",
                            stylers: [{ color: "#2f3948" }],
                        },
                        {
                            featureType: "transit.station",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [{ color: "#17263c" }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#515c6d" }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.stroke",
                            stylers: [{ color: "#17263c" }],
                        },
                    ],
                };
          map = new google.maps.Map(document.getElementById("map"), mapOptions);
                var iconBase = '../mlt/assets/images/';
                marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    draggable: true,
                    icon: iconBase + 'location_pin.png'
                });     
                
                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#latitude1').val(marker.getPosition().lat());
                            $('#longitude1').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                               
                google.maps.event.addListener(marker, 'dragend', function() {

                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                            for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 }if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                  if (results[0].address_components[j].types[0] == 'political'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;

                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                 }
                             }
                                $('#address-text').text(results[0].address_components[2].long_name);
                               // $('#address-details').text(results[0].formatted_address);
                                faddress = results[0].formatted_address;
                                $('#address-details').text(faddress);
                                $('#latitude1').val(marker.getPosition().lat());
                                $('#longitude1').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                                var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                           
                            $('.confirm').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                         
                            // $(".noon-time6").html(time);
                            // $(".noon-time5").val(time);
                            $('.confirm').attr('disabled',false);

                           
                            initMap();

                        }
                    }
                });
                            }
                        }
                    });
                });
        }
        


        /******* iframe map and address  ********/ 
       
        function initMap1() {
            var latitude = Number(document.getElementById("latitude1").value);

            var longitude = Number(document.getElementById("longitude1").value);
            // var uluru = {
            //     lat: latitude,
            //     lng: longitude
            // };
            var myLatlng = new google.maps.LatLng(latitude,longitude);
            var mapOptions = {
                    zoom: 18,
                    center: myLatlng,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    styles: [
                        { elementType: "geometry", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.stroke", stylers: [{ color: "#242f3e" }] },
                        { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
                        {
                            featureType: "administrative.locality",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "poi",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "geometry",
                            stylers: [{ color: "#263c3f" }],
                        },
                        {
                            featureType: "poi.park",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#6b9a76" }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry",
                            stylers: [{ color: "#38414e" }],
                        },
                        {
                            featureType: "road",
                            elementType: "geometry.stroke",
                            stylers: [{ color: "#212a37" }],
                        },
                        {
                            featureType: "road",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#9ca5b3" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry",
                            stylers: [{ color: "#746855" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "geometry.stroke",
                            stylers: [{ color: "#1f2835" }],
                        },
                        {
                            featureType: "road.highway",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#f3d19c" }],
                        },
                        {
                            featureType: "transit",
                            elementType: "geometry",
                            stylers: [{ color: "#2f3948" }],
                        },
                        {
                            featureType: "transit.station",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#d59563" }],
                        },
                        {
                            featureType: "water",
                            elementType: "geometry",
                            stylers: [{ color: "#17263c" }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.fill",
                            stylers: [{ color: "#515c6d" }],
                        },
                        {
                            featureType: "water",
                            elementType: "labels.text.stroke",
                            stylers: [{ color: "#17263c" }],
                        },
                    ],
                };
          map = new google.maps.Map(document.getElementById("map1"), mapOptions);
                var iconBase = '../mlt/assets/images/';
                marker = new google.maps.Marker({
                    map: map,
                    position: myLatlng,
                    draggable: true,
                    icon: iconBase + 'location_pin.png'
                });     
                
                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#latitude1').val(marker.getPosition().lat());
                            $('#longitude1').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                               
  

                google.maps.event.addListener(marker, 'dragend', function() {

                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            console.log(results[0].address_components)
                            if (results[0]) {
                            for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                     
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 }if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'political'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;

                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                 }
                                
                             }
                             $('#address-details').text(results[0].formatted_address);
                                $('#address-text1').text(" "+results[0].address_components[2].long_name);
                                faddress = results[0].formatted_address;
                                $('#address-details1').text(faddress);
                                console.log(marker.getPosition().lat())

                                $('#latitude1').val(marker.getPosition().lat());
                                $('#longitude1').val(marker.getPosition().lng());
                                
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                                
                var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==1){
                            $('#confirm_save').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                         
                            // $(".noon-time6").html(time);
                            // $(".noon-time5").val(time);
                            $('#confirm_save').attr('disabled',false);
                        }
                    }
                });
                                
                   
                            }
                        }
                    });
                });
        }
       // google.maps.event.addDomListener(window, 'load', initMap1);

        /******* iframe map and address  ********/ 

      function applycoupon(coupon_id) {
        $('.apply-discount').text('Apply')
        $('.oops').text('');
        $('.image22').addClass('d-none');
        $('.coupon25').removeClass('exls');
        $('.coupon28').removeClass('exls');

          var coupon_code='';
          if(coupon_id!='coupon code'){
          var coupon_price=$('#coupon_price'+coupon_id).val();
          var total=$("#total-amt").text();
         var amt=total.split('₹');
            var price=amt[1];
            price=parseInt(price);
            coupon_price=parseInt(coupon_price);
            if(coupon_price>price){
                if(coupon_price>450){

                
               // alert()
                $('.error1'+coupon_id).text('This coupon is only applicable on orders above Rs.'+coupon_price);
                $('.coupon25'+coupon_id).addClass('exls');
                $('.error1'+coupon_id).css('display:block');
                $('.coupon28').removeClass('exls');

                $('.img10'+coupon_id).removeClass('d-none');
                }else{
                    $('.error1'+coupon_id).text('This coupon is only applicable on orders above Rs.'+coupon_price);
                $('.coupon25'+coupon_id).addClass('exls');
                $('.error1'+coupon_id).css('display:block');
                $('.coupon28').removeClass('exls');

                $('.img10'+coupon_id).removeClass('d-none');
                }
                
            }
            else{
        $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/checkcoupon')?>",
           data: {
            coupon_id:coupon_id,
            party_time:'no',    
           },
           success: function (response)
           {
            var resp = $.parseJSON(response);
            var coupon_code=$('.exl-text'+coupon_id).text();
            $('#applycoupon').modal('hide');
            document.getElementById('successfull').style.display='block';
            $('#saved').text('₹'+resp.coupon_save_cost);
            $('.amount-final').text('₹'+resp.price);
            $('.amount-final').text('₹'+resp.price);
            $('.coupon-apply').addClass('applied-coupon');
            $('.amt').text('₹'+resp.price);
            $('.apply-coupontxt').text(coupon_code);
            //alert(($('.coupon_code'+coupon_id).text()))
            $('#coupon_code_after').text(($('.coupon_code'+coupon_id).text()));
            document.getElementById('coupon_code_after').style.display='block';
            $('.coupon-apply').val(coupon_id);
            $('.coupon-cost').val(resp.coupon_save_cost);
            $('#discount-atm').text('₹'+resp.coupon_save_cost);
            $('.applycoupons10'+coupon_id).text('Applied');
            setTimeout(function(){
            $('.coupon-succesfull ').fadeOut(6000);
            }, 6000);       

 } 
        
       
    });
}
          }else{
             var coupon_code=$('.coupon-code').val();
            $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/checkcoupon')?>",
           data: {
            coupon_id:coupon_id,
            coupon_code:coupon_code,
            party_time:'no',    
           },
           success: function (response)
           {
            var resp = $.parseJSON(response);
            if(resp.coupon_save_cost!=false){
            $('#applycoupon').modal('hide');
            document.getElementById('successfull').style.display='block';
            $('#saved').text('₹'+resp.coupon_save_cost);
            $('.amount-final').text('₹'+resp.price);
            $('.amount-final').text('₹'+resp.price);
            $('.coupon-apply').addClass('applied-coupon');
            $('.amt').text('₹'+resp.price);
            $('.apply-coupontxt').text(coupon_code);
           $('#coupon_code_after_text').text($('.coupon-code').val()).text();
            document.getElementById('coupon_code_after_text').style.display='block';
            $('.coupon-apply').val(coupon_id);
            $('.coupon-cost').val(resp.coupon_save_cost);
            $('#discount-atm').text('₹'+resp.coupon_save_cost);
            setTimeout(function(){
            $('.coupon-succesfull ').fadeOut(6000);
            $('.applycoupons10'+coupon_id).text('APPLIED');

            }, 6000);       
            }else{
                var path = "<?=base_url()?>/assets/images/oops.png";
                $('.coupon25').addClass('exls');
                 //$('#oops-msg1').removeClass('d-none');
                // $('.error-msg').removeClass('d-none');
                var path1='src='+path+'';
                var image='<div class="oops-img img-fluid mr-2" id="oops-img1">';
                var img1='<img class="oops-img image22"'+path1+'>';
                var div='</div><p class="oops-bug fw-400">';
                var static=image+img1+div+"<span class='oops fw-500 mr-1 error1'> The coupon code does not existed please apply another</span></p>";
                 $('.error-msg').html(static);
                

            }
 } 
        
       
    });
          }
}

       

  function getValue1(all,val,price1,cart_id,fun) {  
     var total_amt= $('#total-amt').html();
     var disc_amt=$('#discount-atm').html();
     if(disc_amt!='0'){
      disc_amt=disc_amt.split('₹');
             disc_amt=disc_amt[1];
            disc_amt=parseInt(disc_amt);
            total_amt=total_amt.split('₹');
             total_amt=total_amt[1];
             total_amt=parseInt(total_amt);
     }
      let temp = {"item_id":val,"veg":veg_topping,"nonveg":non_veg_topping,"flavor":flavor,"base":cbase,"size":sizeA};
    let temp1 = JSON.stringify(temp);
      topping.push(temp);
      var price='';
    var price2=$('#price_item'+cart_id).val();
    // var id1=cost.split('₹');
    // var price=id1[1];
    // var price2=parseInt(price);
    if(fun=='add'){
        let l=$(all).prev().val();
        var num=parseInt(l);
      num= num+1;
      var price=num*price2;
      var size=$('#item_size'+cart_id).val();
      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }
    $(all).prev().val(+$(all).prev().val() + 1);
    }else if(fun=='sub'){
     
      if ($(all).next().val() > 1){ 
        let l=$(all).next().val()
        var num=parseInt(l);
        num= num-1;
        var price=num*price2;
        var size=$('#item_size'+cart_id).val();
      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }

        $(all).next().val(+$(all).next().val() - 1);

      }
      else{
        var num=0;
        var size=$('#item_size'+cart_id).val();
      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }
    }
    }
    else if(fun=='update'){
      var num=$('.num1'+cart_id).val(); 
      var cost=$("#card-amount").text();
      var id1=cost.split('₹');
     var price=id1[1];
     var price2=parseInt(price);
       price=num*price2;
      var size=$('#cart_size').val();
      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }    }
    else{
      var num=1;
      var size=$('#item_size'+cart_id).val();
      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }

    }
    if(num!=0){

        if(disc_amt>total_amt){
               // alert()
                // $('.error1'+coupon_id).text('This coupon is only applicable on orders above Rs.'+coupon_price);
                // $('.coupon25'+coupon_id).addClass('exls');
                // $('.error1'+coupon_id).css('display:block');
                // $('.coupon28').removeClass('exls');

                // $('.img10'+coupon_id).removeClass('d-none');
                
            }  
            else{
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/addtocart')?>",
           data: {
            item_id:val,
            price:price, 
            item_price:price2,
            num:num,
            size:size1,
            customization:temp1
           },
           success: function (response)
           { 
            topping = [];
     veg_topping = new Array();
     non_veg_topping = new Array();
     flavor = new Array();
     cbase = new Array();
     sizeA = new Array();
     count=0;
     cart_text='';
          
            //    console.log(response)
              var resp = $.parseJSON(response);
             var items=resp.items;
             var cart_price=resp.price;
            // alert(price)
             document.getElementById('itemsno').innerHTML=items+' ITEMS';
            document.getElementById('total-amt').innerHTML='₹'+cart_price;
            cart_price=cart_price-disc_amt;
            document.getElementById('amt-final').innerHTML='₹'+cart_price;
            if(isMobile.any()) {
                $('#price-id'+cart_id).text('₹'+price2);
  
            }else{
                $('#price-id1'+cart_id).text('₹'+price2);

            }
           
            document.getElementById('total_items_in_cart').innerHTML=items+' ITEMS IN CART';
            document.getElementById('cart_total').innerHTML='₹'+cart_price;
           if(resp.customization!=''){
            $('.cart-max'+cart_id).text(resp.customization);
            $('#item_size'+cart_id).val(size1)
           }
          //  $('.card-text'+val).text(output6);
            $('.cart-count1').text(items)
            $('#item_size'+cart_id).val(size1);
          //  console.log($('#item_size'+cart_id).val(size1));
           
            //  window.location.reload();
           }
           });
    }
}
    else{
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/deletecart')?>",
           data: {
            item_id:val,
            price:price, 
            size:size1, 
           },
           success: function (response)
           {
            if(response!=''){
             var resp = $.parseJSON(response);
             var items=resp.items;
             var cart_price=resp.price;
             if(cart_price!='' && items!=''){
            //     document.getElementById('itemsno').innerHTML=items+' ITEMS';
            // document.getElementById('total-amt').innerHTML='₹'+cart_price;
            // document.getElementById('amt-final').innerHTML='₹'+cart_price;
            // document.getElementById('price-id'+cart_id).innerHTML='₹'+price;
            // document.getElementById('total_items_in_cart').innerHTML=items+' ITEMS IN CART';
            // document.getElementById('cart_total').innerHTML='₹'+cart_price;
            // $('#item_size'+cart_id).val(size1);
            // // $('.card-text'+val).text(resp.customization);


            // $('.cart-count1').text(items)

           window.location.reload();


            }
            else{
              window.location.reload();

            }
            }
            
           }
      });
    
      }
      $('#customizeModal').modal('hide');
      count_veg_non=0;
  }
  
  $('.proceed').click(function () {
      $('#project1').val('');
    var user_id=$('#user-id').val();
      if(user_id!=''){
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/checksignin')?>",
           data: {
           },
           success: function (response)
           {
            var resp = $.parseJSON(response);
            if(resp.name!='' && resp.user_id!=''){ 
                var amt=$('.amt').text();
                var itemslist=$('.amt-item').text();
                amt=amt.split('₹');
                if(parseInt($('#big').val())>=4 || parseInt($('#small').val())>=6 || parseInt(amt[1])>=6000){
                 //   alert()
                    document.getElementById('extra-order').style.display="block";
                }
                $('#username').html('Hello <br class="d-block d-md-none">' + resp.name+',');
                $('#proceed').modal('show');
                var amt=$('.amt').text();
                
                var itemslist=$('.amt-item').text();
                $('.total-cost').text(amt);
                $('.two-items').text(itemslist);
                $('.address-add').html(resp.addressdetails);
                var lat=$('#latitude1').val();
                var lon=$('#longitude1').val();
                $('.day2').addClass('skeleton_loader');
                $('.day3').addClass('skeleton_loader');
           
                $('.place_your_order').addClass('skeleton_loader');

                $.ajax({
                type: 'post',
                url:"<?php echo base_url('realtime_feasabilty_check')?>",
                data: {  
                    tomorrow:0,
                    lat:lat,
                    lon:lon,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.time==1){
                            document.getElementById('successfull2').style.display='block';

                            setTimeout(function(){
                            $('.coupon-succesfull2').fadeOut(6000);
                            }, 6000);  
                            $(".noon-time1").val();
                            $(".noon-time1").prop('checked',true);
                            $(".noon-time").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.day2').removeClass('skeleton_loader');
                            $('.day3').removeClass('skeleton_loader');
                            $('.place_your_order').removeClass('skeleton_loader');
                            $('.place_your_order').attr('disabled',true);


          
                        }else if(resp.time==2){
                            $('#time_slot_msg').modal('show');

                            $('.day2').removeClass('skeleton_loader');
                            $('.day3').removeClass('skeleton_loader');
                            $('.place_your_order').removeClass('skeleton_loader');
                            $('.place_your_order').attr('disabled',true);

                        }
                        else{

                            let time = resp.time;
                            let time1=time.split('-');
                            $(".noon-time1").prop('checked',true);
                            $(".noon-time").html(time1[0]+' '+time1[1]);
                            $(".noon-time1").val(time1[0]+' '+time1[1]);
                            $('.day2').removeClass('skeleton_loader');
                            $('.day3').removeClass('skeleton_loader'); 
                            $('.place_your_order').removeClass('skeleton_loader');
                            $('.place_your_order').attr('disabled',false);

                         }
                    }                                                                        
            });

            }
            else{
                $('#guestsign-in').modal('show');
            }
        }
  });
}else{
    
    if(isMobile.any()) {

        var amt=$('.amt').text();
        var amt=amt.split('₹');
    amt=parseInt(amt[1]);
    var itemslist=$('.amt-item').text();
    if(parseInt($('#big').val())>=4 || parseInt($('#small').val())>=6 || amt>=6000){
        document.getElementById('extra-order1').style.display="block";
    }      
    $('.total-cost1').text('₹'+amt);
    $('.two-items1').text(itemslist);
    var lat=$('#latitude1').val();
    var lon=$('#longitude1').val();
    $.ajax({
                type: 'post',
                url:"<?php echo base_url('realtime_feasabilty_check')?>",
                data: {  
                    tomorrow:0,
                    lat:lat,
                    lon:lon,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.time==1){
                            document.getElementById('successfull1').style.display='block';

                        setTimeout(function(){
                        $('.coupon-succesfull1 ').fadeOut(6000);
                        }, 6000);  
                            $(".noon-time5").val();
                            $('.noon-time5').prop('checked', true);
                            $(".noon-time6").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.place_order_checkout').attr('disabled',true);


                        }else if(resp.time==2){
                            $('#time_slot_msg').modal('show');

$('.day2').removeClass('skeleton_loader');
$('.day3').removeClass('skeleton_loader');
$('.place_your_order').removeClass('skeleton_loader');
$('.place_order_checkout').attr('disabled',true);
                        }
                        else{
                            let time = resp.time;
                            let time1=time.split('-');
                            $(".noon-time6").html(time1[0]+' '+time1[1]);
                            $('.noon-time5').prop('checked', true);
                            $(".noon-time5").val(time1[0]+' '+time1[1]);
                            $('.place_order_checkout').attr('disabled',false);

                           
                        }
                    }
     });
//  $("#area-fill").blur(function(){
//  if (IsplaceChange == false) {
//     $("#area-fill").val('');
//     $(".error-area").html('please Select address');
//  }
//  });
 

    
    
        $('#guestsign-in').modal('show');
}
else{
    $('#Checkout').modal('show');
}
}
});


$('.earliest_time4').click(function(){
    let tomorrow='1';
$.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        
                        if(resp.time==1){
                            $('.delivery_time4').val();
                            $(".noon-time").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
          
$('.place_order_checkout').attr('disabled',true);
                        }else if(resp.time==2){
                            $('#time_slot_msg').modal('show');
                            $('.place_order_checkout').attr('disabled',true);

                        }
                        else{
                            let time = resp.time;
                            $(".noon-time").html(time);
                            $('.delivery_time4').val(time);
                            $('.place_order_checkout').attr('disabled',true);

                        }
                    }
                })
            });

                var isMobile= {
                Android:function(){
                return navigator.userAgent.match(/Android/i);
                },
                BlackBerry:function(){
                return navigator.userAgent.match(/BlackBerry/i);
                },
                iOS:function(){
                return navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/iPod/i);
                },
                Opera:function() {
                return navigator.userAgent.match(/Opera Mini/i);
                },
                Windows:function() {
                return navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i);
                },
                any:function(){
                return(isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                }
                };
               



$(".openloginmodal").click(function () {
    if(!isMobile.any()) {

   $('#Checkout').modal('hide');
   $('#loginmodal').modal('show');
//    $('#mobile').val('');
//    $(".error").html(''); 
//    $('#resend-otp').text('');
    }else{
    $('#guestsign-in').modal('hide');
   $('#loginmodal').modal('show');
    }
//    $('.wrong-otp').text('');
//    $('#timer').text('');
 });


 function gettime(address_id,lat,lon){
    $('.place_your_order').addClass('skeleton_loader');

     $('#msg_terms').html('');
    $.ajax({
                type: 'post',
                url:"<?php echo base_url('realtime_feasabilty_check')?>",
                data: {  
                    tomorrow:0,
                    lat:lat,
                    lon:lon,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.time==1){
                            document.getElementById('successfull2').style.display='block';
                            setTimeout(function(){
                            $('.coupon-succesfull2').fadeOut(6000);
                            }, 6000);  
                            $(".noon-time1").val();
                            $(".noon-time").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.place_your_order').attr('disabled',true);
                            $('.place_your_order').removeClass('skeleton_loader');

                                                    }else if(resp.time==2){
                                                        $('#time_slot_msg').modal('show');
                                                        $('.place_your_order').attr('disabled',true);
                            $('.place_your_order').removeClass('skeleton_loader');
                                                    }
                                                    else{
                                                        let time = resp.time;
                                                        let time1=time.split('-');
                                                        $(".noon-time").html(time1[0]+' '+time1[1]);
                                                        $(".noon-time1").val(time1[0]+' '+time1[1]);
                                                        $('.place_your_order').removeClass('skeleton_loader');
                                                        $('.place_your_order').attr('disabled',false);

                                                    }
                                                }
                                });

 }
 

 


 var currentDate = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
var day = String(currentDate.getDate()).padStart(2, '0');
var month = String(currentDate.getMonth() + 1).padStart(2, '0');
var year = currentDate.getFullYear()
var today = new Date();
var dd = String(today.getDate()).padStart(2, '0');
var mm = String(today.getMonth() + 1).padStart(2, '0');
var yyyy = today.getFullYear();

today = yyyy + '-' + mm + '-' + dd;

    //$('.place_your_order').click(function(e){
       function placeOrderuser(e){
           e.preventDefault();
        let address_id;
        let order_type='';
        var ckb_status=$(".adress-type:checked").val();
        if(ckb_status){
            address_id=$('input[name="customRadio-adddress"]:checked').val();
            let latitude=$('latitude'+address_id).val();
            let longitude=$('longitude'+address_id).val();
            let paymode=$('input[name="customRadio51pay"]:checked').val();
        let date=$('input[name="delivery_date"]:checked').val();
        order_type=$('input[name="order_type"]:checked').val();
        let time3=time2=time4='';
        if(date==((year+"-"+month+"-"+day))){
             time3=$('.exact-time').text(); 
             if(time3!=''){
             time2=time3.split('-');
             time4=time2[1];
        }else{
            time4=$('input[name="delivery_time1"]:checked').val();
        } 
        }else if(date==today)
        {
            time3=$('#customRadio38:checked').val();
            if(time3!=undefined){
             time2=time3.split('-');
             time4=time2[1];
        }   else{
            time4=$('input[name="delivery_time"]:checked').val();
        }
        }else{

            time3=$('.exact-time').text(); 
             if(time3!=''){
             time2=time3.split('-');
             time4=time2[1];
        }else{
            time4=$('input[name="delivery_time1"]:checked').val();
        } 
        }
        let total_price=$('.total-cost').text();
        let price=total_price.split('₹');
        price=price[1];

        let coupon_id=$('.coupon-apply').val();
        let lan=$('#latitude1').val();
        let lon=$('#longitude1').val();
        let total_item=$('.getitems').text();
        total_item=total_item.split('');
        total_item=total_item[0];
         let discount_amt=$('input[name="coupon_cost"]').val();
        if(paymode=='Cash'){
            $('.place_your_order').text('Processing');
            $('.place_your_order').attr('disabled',true);

            $.ajax({
                type: 'post',
                url:"<?php echo base_url('website/order')?>",
                data: {
                    delivery_date:date,
                    delivery_time:time4,
                    address_id:address_id,
                    payment_mode:paymode,
                    order_type:order_type,
                    lan:lan,
                    lon:lon,
                    party_time:'no',
                    total_price:price,
                    total_item:total_item,
                    coupon_id:coupon_id,
                    discount_amt:discount_amt,
                    razor_payment_id:''
                },
                success: function (response){
                    var resp = $.parseJSON(response);
                    if(resp.redirect_url!=false){
                    $('#proceed').modal('hide');
                    window.location.href =resp.redirect_url;
                    }else{
                        $('.place_your_order').attr('disabled',false);
                            $('.place_your_order').text('Proceed');
                            document.getElementById('successfull2').style.display='block';

                            setTimeout(function(){
                            $('.coupon-succesfull2').fadeOut(6000);
                            }, 6000); 
                    }
                }
            });
         }
         else if(paymode=='online'){
            let tamount = parseInt(price)*100;
            let pay_logo="";
            var options = {
                    "key": "<?php echo razorPayTestKey?>", //"rzp_test_my6usYJyg3dmMT",//rzp_test_HUKBQZvmYfFGxq // Enter the Key ID generated from the Dashboard//rzp_live_4PlBRaHCb5ecCv
                    "amount": tamount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                    "currency": "INR",
                    "name": "MLT",
                    "description": '',
                    "image": pay_logo, 
                    "handler": function (response){
                        // console.log(response+"===response"+"==="+response.razorpay_payment_id);
                        //$("#razorpay_payment_id").val(response.razorpay_payment_id);
                        if(response.razorpay_payment_id!=''){
                            $('.place_your_order').attr('disabled',true);
                            $('.place_your_order').text('Processing');
                            $.ajax({
                                type: 'post',
                                url:"<?php echo base_url('website/order')?>",
                                data: {
                                    delivery_date:date,
                                    delivery_time:time4,
                                    address_id:address_id,
                                    payment_mode:paymode,
                                    total_price:price,
                                    party_time:'no',
                                    order_type:order_type,
                                    total_item:total_item,
                                    coupon_id:coupon_id,
                                    discount_amt:discount_amt,
                                    razor_payment_id:response.razorpay_payment_id
                                },
                                success: function (response){
                                    var resp = $.parseJSON(response);
                                    if(resp.redirect_url!=false){
                    // $('#proceed').modal('hide');
                    window.location.href =resp.redirect_url;
                    }else{
                        $('.place_your_order').attr('disabled',true);
                            $('.place_your_order').text('Proceed');
                            setTimeout(function(){
                        $('.coupon-succesfull2').fadeOut(6000);
                        }, 6000); 

                    }

                                
                                }
                            });
                        }
                        
                    },
                    "prefill": {
                        "name": "<?=$fullname?>",
                        "email": "<?=$email?>",
                        "contact": "<?=$mobile?>"
                    },
                    "notes": {
                        "address": "Razorpay Corporate Office"
                    },
                    "theme": {
                        "color": "#F37254"
                    }
                }; 
                var rzp1 = new Razorpay(options);
                                rzp1.open();
                                e.preventDefault();

         }
        }else{
            $('#msg_terms').text('please select address');  
        }
        
    }

$('.add-address300').click(function(e){
    $('#project1').val(''); 
    e.preventDefault();
    $('#address').modal('show');
    $('#proceed').modal('hide');

});
$('.proceed1').click(function(){
    if($('#project1').val()==''){
        $('.err').text('Please Select Address');
    }else{
    $('#iframemap').modal('show');
    $('#address').modal('hide');
    }
});




$('.confirm').click(function(){
   
    let address_head=$('#address-details').text();
    let address_head1=$('#address-text').text();
    $('#address-details1').text(address_head);
    $('#address-text1').text(" "+address_head1);
    $('#iframemap').modal('hide');
        initMap1();   
        $('#iframe_address').modal('show');
// $( "#confirm_save" ).attr('disabled',true);

});

$( "#confirm_save" ).on( "click", function( event ) {        
    if($('#guest-add-address').val()!='guest'){
    
    var city=$('#city2').val();
    var land=house='';
    house=$('input[name="house"]').val();

    var la=$('#latitude1').val();
    var lo=$('#longitude1').val();
    var pincode=$('#postalCode').val();
    var countryName=$('#countryName').val();            
    var stateName=$('#stateName').val();           
    var locality=$('#locality').val();                          
    var address_deatils=$('#address-details').text();
    var address_type=$('input[name="options"]:checked').val();
    if($('input[name="land"]').val()!=''){
        land=$('input[name="land"]').val();
    }
    
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/addadress')?>",
           data: {
            city:city,
            la:la,
            lo:lo,
            pincode:pincode,
            stateName:stateName,
            countryName:countryName,
            locality:locality,
            address_deatils:address_deatils,
            address_type:address_type,
            house:house,
            land:land,
           },
           success:function (response)
           {
            var resp = $.parseJSON(response);
            $('input[name="house"]').val('');
           $('input[name="land"]').val('');
            $('.address-add').html(resp.addressdetails);
         }

    });
}else{
    $('.house_no').val($('.house-no').val());
    $('.landmark').val($('.landmark1').val());

    $('#guestsign-in').modal('show');
    $('#iframe_address').modal('hide');

}
    
});
  
$("#confirm_save").click(function (e) {
  if ($(".house_no.form-group").hasClass("has-success") && $(".home_work.form-group").hasClass("has-success")) {
    $('#proceed').modal('show');
    $('#iframe_address').modal('hide');
  }else{
    e.preventDefault();

  }
});

function getlocation1(){
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/location1')?>",
           data: { },
           success:function (response)
           {
            var resp = $.parseJSON(response);
            $('#project1').val(resp.result.city+' '+resp.result.region_name+' '+resp.result.country_name+' '+resp.result.zip_code);
            $('#countryName').val(resp.result.country_name);
            $('#stateName').val(resp.result.region_name);
            $('#latitude1').val(resp.result.latitude);
            $('#longitude1').val(resp.result.longitude);
            $('#postalCode').val(resp.result.zip_code);
            $('#locality').val(resp.result.city);
            $('#city2').val(resp.result.city);
            $('.address-text').text(resp.result.city);
            $('#lo').val(resp.result.longitude);
            $('#address-details').text(resp.result.city+' '+resp.result.region_name+' '+resp.result.country_name+' '+resp.result.zip_code);
            initMap();
            }
        });
    }

    let topping = [];
    let veg_topping = new Array();
    let non_veg_topping = new Array();
    let flavor = new Array();
    let cbase = new Array();
    let sizeA = new Array();
    let count=0;
    let cart_text='';
    
    

    function getToppingdetails(item_id,item_name,ccart_id){  
        
      veg_topping = new Array();
      non_veg_topping = new Array();
      flavor = new Array();
      base = new Array();
      sizeA = new Array();

      let selected_val=0;
       selected_val=$('#item_size'+ccart_id).val();
    //   selected_val=$("#size_"+item_id).val(); 
    //   selected_val=$("#size_"+item_id).val(); 
      $.ajax
           ({
           type: 'post',
           url:base_url+"getToppingModalcoupon",
           data: {item_id:item_id,item_name:item_name,selected_val:selected_val},
           success: function (response)
           {
            $('#customizeModal').modal('show');  
            $("#toppingContent").html(response); 
            $("#card-amount").html($("#price-id"+item_id).html());
            $("#ccart_id").val(ccart_id);
            $('.id-1-select:checked').map(function(_, el) {
                let s2 = $(el).val().split('#');
        let i_id =  s2[2];
        let t_id = s2[1];
        if(!addons.includes(s2[0])){
          addons.push(s2[0]);
        }
        else{
          addons.splice(addons.indexOf(s2[0]), 1);
        }

        if(!veg_topping.includes(s2[0])){        //checking weather array contain the value
          //veg[i_id].push(s2[0]);               //adding to array because value doesnt exists
          veg_topping.push(s2[0]);
          let count_num1=1;
        count=count_num1+count;
        count_veg_non=count_veg_non+count_num1;

        $('.count-cust').text('+'+count+' add '+'on')
        addons1 = addons.toString();
        addons2 = addons1.replace(/,+/g,',');
          $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');
          $('.customize').text(addons2);

        }else{ 
          veg_topping.splice(veg_topping.indexOf(s2[0]), 1);
          let count_num1=1;
        count=count-count_num1;
        count_veg_non=count_veg_non-count_num1;

        $('.count-cust').text('+'+count+' add '+'on')
  // alert()
          $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');
          addons1 = addons.toString();
        addons2 = addons1.replace(/,+/g,',');
          $('.customize').text(addons2);

            //deleting
        }
        //alert(count_veg_non)
       
        // veg[i_id][t_id] = veg_topping[i_id];
        //$("#customization-value-"+i_id).val(veg[i_id]);
        //console.log(veg[i_id]);
        let p1 = $(".cbase").val();
        let p2 = p1.split('#');
        if(cbase!=''){
          cbase.pop();
          cbase.push(p2[0]);
        }else{
          cbase.pop();
          cbase.push(p2[0]);
        }
        p1 = $('input[name="sizes"]:checked').val();
        let count_num1=1;
      count=count+count_num1;
        p2 = p1.split('#');

        if(sizeA!=''){
          sizeA.pop();
          sizeA.push(p2[0]);
          addons.push(sizeA[0]);
        }else{
          sizeA.pop();
          sizeA.push(p2[0]); 
        }
        let items=Array();
        items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
        items1 = items.toString();
        items1 = items1.replace(/,+/g,',');
        items1 = items1.replace(/^,|,$/g,'');
        $('.count-cust').text('+'+count+' add '+'on')

        $('.customize').text(items1);
      }).get(); 



      $('.id-2-select:checked').map(function(_, el) {
        let p2 = $(el).val().split('#');
        let p3=p2[1];
        if(!addons.includes(p2[0])){
          addons.push(p2[0]);
        }
        else{
          addons.splice(addons.indexOf(p2[0]), 1);
        }
        if(!non_veg_topping.includes(p2[0])){          //checking weather array contain the value
          //veg[i_id].push(s2[0]);   
                      //adding to array because value doesnt exists
          non_veg_topping.push(p2[0]);
          let count_num1=1;
        count=count+count_num1;
        count_veg_non=count_veg_non+count_num1;

              $('.count-cust').text('+'+count+' add '+'on')
          $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

          $('.customize').text(addons);

      }else{ 
        non_veg_topping.splice(non_veg_topping.indexOf(p2[0]), 1);  //deleting
        let count_num1=1;
      count=count-count_num1;
      count_veg_non=count_veg_non+count_num1;
        $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

        $('.customize').text(addons);

      }

     
      //console.log(nveg);
      p1 = $(".cbase").val();
      let count_num1=1;
      count=count+count_num1;
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }

      p1 = $('input[name="sizes"]:checked').val();
      p2 = p1.split('#');

      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
        
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
      let items=Array();
      
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      $('.count-cust').text('+'+count+' add '+'on')

      $('.customize').text(items1);

      }).get();







      $('.id-3-select:checked').map(function(_, el) {
      let p2 = $(el).val().split('#');
      let p3=p2[1];

      if(!addons.includes(p2[0])){
        addons.push(p2[0]);
      }
      else{
        addons.splice(addons.indexOf(p2[0]), 1);
      }

      if(!flavor.includes(p2[0])){     
     //checking weather array contain the value
        flavor.push(p2[0]); 
       // $('.count-cust').text('+'+count+' add '+'on')
       let count_num1=1;
      count=count_num1+count;

      $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

        $('.customize').text(addons);
            //adding to array because value doesnt exists
      }else{
        let count_num1=1;
      count=count-count_num1;
      $('.count-cust').text('+'+count+' add '+'on')
        //$('.count-cust').text('+'+count+' add '+'on')
        flavor.splice(flavor.indexOf(p2[0]), 1);  
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

        $('.customize').text(addons);
//deleting
      }

      p1 = $(".cbase").val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      p1 = $('input[name="sizes"]:checked').val();
      let count_num1=1;
      count=count+count_num1;
      p2 = p1.split('#');
      
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }

      let items=Array();
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
        $('.customize').text(items1);
    }).get();
    p1 = $(".cbase").val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      p1 = $('input[name="sizes"]:checked').val();
      let count_num1=1;
      count=count+count_num1;
      p2 = p1.split('#');
      
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
  

    var price4=$("#price_item"+ccart_id).val();
    $('.card-amount').text('₹'+price4);
            var size=$('#item_size'+ccart_id).val();
            $('#cart_size').val(size);     

           }
        })
        
  }
  </script>  
  <script>
    


    let count_veg_non=0;
  var limitReached1='';
  let addons=new Array();
      /*limited select options */
      $(document).on("click", ".id-1-select", function(event){
        limitReached1 = $('.id-1-select:checked').length; 
        var item_id=$('.item-id').val(); 
        var type=$('.type'+item_id).val(); 
        let s1 = $(this).val();
        let s2 = s1.split('#');
        let i_id =  s2[2];
        let t_id = s2[1];

        if(!addons.includes(s2[0])){
          addons.push(s2[0]);
        }
        else{
          addons.splice(addons.indexOf(s2[0]), 1);
        }

        if(!veg_topping.includes(s2[0])){        //checking weather array contain the value
          //veg[i_id].push(s2[0]);               //adding to array because value doesnt exists
          veg_topping.push(s2[0]);
          let count_num1=1;
        count=count_num1+count;
        count_veg_non=count_veg_non+count_num1;

        $('.count-cust').text('+'+count+' add '+'on')
        addons1 = addons.toString();
        addons2 = addons1.replace(/,+/g,',');
          $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');
          $('.customize').text(addons2);

        }else{ 
          veg_topping.splice(veg_topping.indexOf(s2[0]), 1);
          let count_num1=1;
        count=count-count_num1;
        count_veg_non=count_veg_non-count_num1;
        $('.count-cust').text('+'+count+' add '+'on')
  // alert()
          $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');
          addons1 = addons.toString();
        addons2 = addons1.replace(/,+/g,',');
          $('.customize').text(addons2);

            //deleting
        }
        //alert(count_veg_non)
        if(count_veg_non<3){
      if(type=='veg'){
          $('.id-1-select').not(':checked').attr('disabled', false);
          $('.id-2-select').not(':checked').attr('disabled', true);
        }else if(type=='non-veg'){
          $('.id-1-select').not(':checked').attr('disabled', false);
          $('.id-2-select').not(':checked').attr('disabled', false);
        }
        else{
          $('.id-1-select').not(':checked').attr('disabled', false);
          $('.id-2-select').not(':checked').attr('disabled', false);
        }
      }else{
        $('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.customize_err_message ').fadeOut(6000);
            }, 6000);  
        $('.id-1-select').not(':checked').attr('disabled', true);
        $('.id-2-select').not(':checked').attr('disabled', true);

      }
        // veg[i_id][t_id] = veg_topping[i_id];
        //$("#customization-value-"+i_id).val(veg[i_id]);
        //console.log(veg[i_id]);
        let p1 = $(".cbase").val();
        let p2 = p1.split('#');
        if(cbase!=''){
          cbase.pop();
          cbase.push(p2[0]);
        }else{
          cbase.pop();
          cbase.push(p2[0]);
        }
        p1 = $('input[name="sizes"]:checked').val();
        p2 = p1.split('#');
        if(sizeA!=''){
          sizeA.pop();
          sizeA.push(p2[0]);
          addons.push(sizeA[0]);
        }else{
          sizeA.pop();
          sizeA.push(p2[0]); 
        }
        let items=Array();
        items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
        items1 = items.toString();
        items1 = items1.replace(/,+/g,',');
        items1 = items1.replace(/^,|,$/g,'');
        items1 = items1.split(",").join(", ");
        $('.customize').text(items1);      });

      $(document).on("click", ".id-2-select", function(event){
        limitReached1= $('.id-2-select:checked').length ;  
        let p1 = $(this).val();
        let p2 = p1.split('#');
        let p3=p2[1];
        if(!addons.includes(p2[0])){
          addons.push(p2[0]);
        }
        else{
          addons.splice(addons.indexOf(p2[0]), 1);
        }
        if(!non_veg_topping.includes(p2[0])){          //checking weather array contain the value
          //veg[i_id].push(s2[0]);   
                      //adding to array because value doesnt exists
          non_veg_topping.push(p2[0]);
          let count_num1=1;
        count=count+count_num1;
        count_veg_non=count_veg_non+count_num1;

              $('.count-cust').text('+'+count+' add '+'on')
          $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

          $('.customize').text(addons);

      }else{ 
        non_veg_topping.splice(non_veg_topping.indexOf(p2[0]), 1);  //deleting
        let count_num1=1;
      count=count-count_num1;
      count_veg_non=count_veg_non-count_num1;
            $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

        $('.customize').text(addons);

      }
      if(count_veg_non>=3){
        $('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.customize_err_message ').fadeOut(6000);
            }, 6000); 
        $('.id-1-select').not(':checked').attr('disabled', true);
        $('.id-2-select').not(':checked').attr('disabled', true);
      }
      else{
        
        $('.id-1-select').not(':checked').attr('disabled', false);
        $('.id-2-select').not(':checked').attr('disabled', false);
      }
      //console.log(nveg);
      p1 = $(".cbase").val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      p1 = $('input[name="sizes"]:checked').val();
      p2 = p1.split('#');
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
      let items=Array();
      
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
        $('.customize').text(items1);        });
    $(document).on("click", ".id-3-select", function(event){
      var limitReached = $('.id-3-select:checked').length >= 3;   
      $('.id-3-select').not(':checked').attr('disabled', limitReached);
      if(limitReached){
        $('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.customize_err_message ').fadeOut(6000);
            }, 6000);
      }
      let p1 = $(this).val();
      let p2 = p1.split('#');
      let p3=p2[1];

      if(!addons.includes(p2[0])){
        addons.push(p2[0]);
      }
      else{
        addons.splice(addons.indexOf(p2[0]), 1);
      }

      if(!flavor.includes(p2[0])){          //checking weather array contain the value
        flavor.push(p2[0]); 
       // $('.count-cust').text('+'+count+' add '+'on')
       let count_num1=1;
      count=count_num1+count;
      $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

        items1 = items1.split(",").join(", ");
        $('.customize').text(items1);
            //adding to array because value doesnt exists
      }else{
        let count_num1=1;
      count=count-count_num1;
      $('.count-cust').text('+'+count+' add '+'on')
        //$('.count-cust').text('+'+count+' add '+'on')
        flavor.splice(flavor.indexOf(p2[0]), 1);  
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

        $('.customize').text(addons);
//deleting
      }
      p1 = $(".cbase").val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      p1 = $('input[name="sizes"]:checked').val();
      p2 = p1.split('#');
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
      let items=Array();
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
        $('.customize').text(items1);        });
    $(document).on("click", ".cbase", function(event){
      let p1 = $(this).val();
      let p2 = p1.split('#');
      if(cbase!=''){
        if(!addons.includes(cbase[0])){
          addons.push(cbase[0]);
        }
        else{
          addons.splice(addons.indexOf(cbase[0]), 1);
        }
        cbase.pop();
      cbase.push(p2[0]);

      }else{
        if(!addons.includes(cbase[0])){
          addons.push(cbase[0]);
        }
        else{
          addons.splice(addons.indexOf(cbase[0]), 1);
        }
        cbase.pop();
      cbase.push(p2[0]);
      addons.push(cbase[0]);

      count=count+1;

      }
      // if(!empty())
      // addons.push(cbase[0]);
      $('.count-cust').text('+'+count+' add '+'on');
      addons1 = addons.toString();
      addons2 = addons1.replace(/,+/g,',');
       
      p1 = $('input[name="sizes"]:checked').val();
      
      p2 = p1.split('#');
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
      let items=Array();
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
        $('.customize').text(items1);    
    });
    
    $(document).on("click", ".csize", function(event){
       
      let p1 = $('input[name="sizes"]:checked').val();
      let size20 = $('input[name="sizes"]:checked').attr('data-price');
      $('#card-amount').html('₹'+size20);
      let p2 = p1.split('#');
      
      if(sizeA!=''){
        if(!addons.includes(sizeA[0])){
          addons.push(sizeA[0]);
        }
        else{
          addons.splice(addons.indexOf(sizeA[0]), 1);
        }

        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        if(!addons.includes(sizeA[0])){
          addons.push(sizeA[0]);
        }
        else{
          addons.splice(addons.indexOf(sizeA[0]), 1);
        }

        sizeA.pop();
        sizeA.push(p2[0]);        
        addons.push(sizeA[0]);

        count=count+1;

      }
      $('.count-cust').text('+'+count+' add '+'on')
      $('.customize').text(addons);
      p1 =  $('input[name="cbase"]:checked').val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      let items=Array();
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
        $('.customize').text(items1);    
            });
   
   
     
   function getToppingId(id)
 {
   
  $(".list-group-item").removeClass("active");
  $(".topping"+id).addClass('active');
  /* 
   if(!$("#topping"+id))
   {

   }
  $(".list-group-item").removeClass("active");
  $("#topping"+id).addClass("active"); */
 }
 $(".checkoutasguest").click(function () {
    $('#guestsign-in').modal('show');
    $('#Checkout').modal('hide');
    var amt=$('.amt').text();
    var amt=amt.split('₹');
    amt=parseInt(amt[1]);
    var itemslist=$('.amt-item').text();
    if(parseInt($('#big').val())>=4 || parseInt($('#small').val())>=6 || amt>=6000){
        document.getElementById('extra-order1').style.display="block";
    }      
    $('.total-cost1').text('₹'+amt);
    $('.two-items1').text(itemslist);
    $('.day6').addClass('skeleton_loader');
                    $('.day7').addClass('skeleton_loader');
    var lat=$('#latitude1').val();
    var lon=$('#longitude1').val();
    $.ajax({
                type: 'post',
                url:"<?php echo base_url('realtime_feasabilty_check')?>",
                data: {  
                    tomorrow:0,
                    lat:lat,
                    lon:lon,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.time==1){
                            document.getElementById('successfull1').style.display='block';

                        setTimeout(function(){
                        $('.coupon-succesfull1 ').fadeOut(6000);
                        }, 6000);  
                            $(".noon-time5").val();
                            $('.noon-time5').prop('checked', true);
                            $(".noon-time6").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').attr('disabled',true);


                        }else if(resp.time==2){
                            $(".noon-time5").val();
                            $('.noon-time5').prop('checked', true);
                            $(".noon-time6").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').attr('disabled',true);

                        }
                        else{
                            let time = resp.time;
                            let time1=time.split('-');
                            $(".noon-time6").html(time1[0]+' '+time1[1]);
                            $('.noon-time5').prop('checked', true);
                            $(".noon-time5").val(time1[0]+' '+time1[1]);
                            $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').attr('disabled',false);

                           
                        }
                    }
     });
 });
 $("#area-fill").blur(function(){
 if (IsplaceChange == false) {
    $("#area-fill").val('');
    $(".error-area").html('please Select address');
      }
    });


    $("#project1").blur(function(){
 if (IsplaceChange == false) {
    $("#project1").val('');
    $(".err").html('please Select address');
      }else{
        $(".err").html('');

      }
    });



 //$('.place_your_order1').click(function(e){
     function placeOrderGuest(e){  
     e.preventDefault();
        let paymode=$('input[name="customRadio5pay"]:checked').val();
        let date=$('input[name="delivery_date1"]:checked').val();
        let exampleInputname=$('#exampleInputname').val();
        let lon=$('#longitude1').val();
        let lat=$('#latitude1').val();
        let exampleInputemail=$('#exampleInputemail').val();
        let exampleInputmoblie=$('#exampleInputmoblie').val();
       
        let exampleInputhouseno=$('.house_no1').val();
        let exampleInputaddress="";
        if($('.landmark').val()!=''){
            exampleInputaddress=$('.landmark').val();
        }
        let town=$('#town-fill').val();
        order_type=$('input[name="order_type"]:checked').val();
        let exampleInputcity=$('#area-fill').val();
        let exampleInputnumber=$('#pincode-fill').val();
        let time3=time2=time4='';
        if(date==(year+"-"+month+"-"+day)){
            time3=$('.exact-time').text();   
             if(time3!=''){
             time2=time3.split('-');
             time4=time2[0];
        }else{
            time4=$('input[name="delivery_time4"]:checked').val();
        } 

        }else if(date==today){
            time3=$('#customRadio39:checked').val();   
            if(time3!=undefined){
             time2=time3.split('-');
             time4=time2[1];
        }   else{
            time4=$('input[name="delivery_time3"]:checked').val();
        }
        }else{
            time3=$('.exact-time400').text();   
             if(time3!=''){
             time2=time3.split('-');
             time4=time2[1];
        }else{
            time4=$('input[name="delivery_time4"]:checked').val();
        } 
        }
        let total_price=$('.total-price1').text();
        let price=total_price.split('₹');
        price=price[1];        

        let coupon_id=$('.coupon-apply').val();
        let total_item=$('.total-item1').text();
        total_item=total_item.split('');
        total_item=total_item[0];
         let discount_amt=$('input[name="coupon_cost"]').val();

        if(paymode=='Cash'){
            $('.place_order_checkout').text('Processing');
            $('.place_order_checkout').attr('disabled',true);
            $.ajax({
                type: 'post',
                url:"<?php echo base_url('website/guest_order')?>",
                data: {
                    delivery_date:date,
                    delivery_time:time4,
                    payment_mode:paymode,
                     exampleInputname:exampleInputname,
                    exampleInputemail:exampleInputemail,
                    exampleInputmoblie:exampleInputmoblie,
                    town:town,
                    exampleInputhouseno:exampleInputhouseno,
                    exampleInputaddress:exampleInputaddress,
                    exampleInputcity:exampleInputcity,
                    exampleInputnumber:exampleInputnumber,
                    total_price:price,
                    party_time:'no',
                    lat:lat,
                    lon:lon,
                    order_type:order_type,
                    total_item:total_item,
                    coupon_id:coupon_id,
                    discount_amt:discount_amt,
                    razor_payment_id:'',
                },
                success: function (response){
                    var resp = $.parseJSON(response);
                    if(resp.redirect_url!=false){
                                // $('#proceed').modal('hide');
                                window.location.href =resp.redirect_url;  
                                }else{
                                    $('.place_your_order').attr('disabled',false);
                                        $('.place_your_order').text('Proceed');
                                        document.getElementById('succesfull1').style.display='block';

                                    setTimeout(function(){
                                    $('.coupon-succesfull1').fadeOut(6000);
                                    }, 6000); 
                        } 
                }                               
                
            });
         }
         else if(paymode=='online'){
            let tamount = parseInt(price)*100;
            let pay_logo="";
            var options = {
                    "key": "<?php echo razorPayTestKey?>", //"rzp_test_my6usYJyg3dmMT",//rzp_test_HUKBQZvmYfFGxq // Enter the Key ID generated from the Dashboard//rzp_live_4PlBRaHCb5ecCv
                    "amount": tamount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                    "currency": "INR",
                    "name": "MLT",
                    "description": '',
                    "image": pay_logo, 
                    "handler": function (response){
                         if(response.razorpay_payment_id!=''){
                            $('.place_order_checkout').text('Processing');
                        $('.place_order_checkout').attr('disabled',true);
                        //$("#razorpay_payment_id").val(response.razorpay_payment_id);
                        $.ajax({
                            type: 'post',
                            url:"<?php echo base_url('website/guest_order')?>",
                            data: {
                                    delivery_date:date,
                                    delivery_time:time4,
                                    payment_mode:paymode,
                                    exampleInputname:exampleInputname,
                                    exampleInputemail:exampleInputemail,
                                    exampleInputmoblie:exampleInputmoblie,
                                    exampleInputhouseno:exampleInputhouseno,
                                    exampleInputaddress:exampleInputaddress,
                                    exampleInputcity:exampleInputcity,
                                    exampleInputnumber:exampleInputnumber,
                                    total_price:price,
                                    party_time:'no',
                                    lat:lat,
                                    lon:lon,
                                    total_item:total_item,
                                    coupon_id:coupon_id,
                                    discount_amt:discount_amt,
                                    razor_payment_id:response.razorpay_payment_id
                            },
                            success: function (response){
                                if(resp.redirect_url!=false){
                                // $('#proceed').modal('hide');
                                window.location.href =resp.redirect_url;  
                                }else{
                                    $('.place_your_order').attr('disabled',false);
                                        $('.place_your_order').text('Proceed');
                                        document.getElementById('succesfull1').style.display='block';

                                    setTimeout(function(){
                                    $('.coupon-succesfull1').fadeOut(6000);
                                    }, 6000); 
                        }                                                  

                            }
                        });
                         }
                    },
                    "prefill": {
                        "name": "<?=$fullname?>",
                        "email": "<?=$email?>",
                        "contact": "<?=$mobile?>"
                    },
                    "notes": {
                        "address": "Razorpay Corporate Office"
                    },
                    "theme": {
                        "color": "#F37254"
                    }
                }; 
                var rzp1 = new Razorpay(options);
                                rzp1.open();
                                e.preventDefault();


         }
     }
       // });

        $('.earliest-time').click(function(){
            var address_id='';
            var ckb_status=$(".adress-type:checked").val();
        
            if($('input[name="customRadio-adddress"]:checked').val()!=undefined){ 
                address_id=$('input[name="customRadio-adddress"]:checked').val();
            var latitude=$('.latitude'+address_id).val();
        var longitude=$('.longitude'+address_id).val();
        }else{
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        }
        
            $('.day2').addClass('skeleton_loader');
            $('.day3').addClass('skeleton_loader');
            $('.place_your_order').addClass('skeleton_loader');
            let tomorrow='0';
            $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,
                           lon:longitude,
                           lat:latitude,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.time==1){
                            $(".noon-time1").val();
                            $(".noon-time1").prop('checked',true);
                            $(".noon-time").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.day2').removeClass('skeleton_loader');
                            $('.day3').removeClass('skeleton_loader');
                            $('.place_your_order').removeClass('skeleton_loader');
                            $('.place_your_order').attr('disabled',true);
                           // $('.place_your_order').prop('disabled',true);


                        }else if(resp.time==2){
                          //  $('.place_your_order').attr('disabled',true);
                          $(".noon-time1").val();
                            $(".noon-time1").prop('checked',true);
                            $(".noon-time").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.day2').removeClass('skeleton_loader');
                            $('.day3').removeClass('skeleton_loader');
                            $('.place_your_order').removeClass('skeleton_loader');
                            $('.place_your_order').attr('disabled',true);
                            $('#time_slot_msg').modal('show');
                        }
                        else{
                            $(".noon-time1").prop('checked',true);
                            $('#customRadio38').prop('checked',false);
                            let time = resp.time;
                            let time1=time.split('-');
                            
                            $(".noon-time").html(time1[0]+' '+time1[1]);
                            $(".noon-time1").val(time1[0]+' '+time1[1]);
                            $('.day2').removeClass('skeleton_loader');
                            $('.day3').removeClass('skeleton_loader');
                            $('.place_your_order').attr('disabled',false);

                            $('.place_your_order').removeClass('skeleton_loader');
                        }
                    }
                });    
                });
       
            //     $('.earliest-time1').click(function(){
            //         $('.day4').addClass('skeleton_loader');
            //         $('.day5').addClass('skeleton_loader');
            //         $('.place_your_order').addClass('skeleton_loader');
            //         let tomorrow='1';
            // $.ajax({
            //         type: 'post',
            //         url:"<?php echo base_url('realtime_feasabilty_check')?>",
            //         data:{tomorrow:tomorrow},
            //         success: function (response){
            //             var resp = $.parseJSON(response);
                        
            //             if(resp.time==false){
            //                 $('.noon-time2').val();
            //                 $(".noon-time3").html('');
            //                 $('.day4').removeClass('skeleton_loader');
            //                 $('.day5').removeClass('skeleton_loader');
            //                 $('.place_your_order').removeClass('skeleton_loader');
            //             }
            //             else{
            //                 let time = resp.time;
            //                 $(".noon-time3").html(time);
            //                 $(".noon-time2").val(time);
            //                 $('.day4').removeClass('skeleton_loader');
            //                 $('.day5').removeClass('skeleton_loader');
            //                 $('.place_your_order').removeClass('skeleton_loader');

            //             }
            //         }
            //     });    
            //     });

                
            //     $('.earliest-time4').click(function(){
            //         $('.day8').addClass('skeleton_loader');
            //         $('.day9').addClass('skeleton_loader');
            //         $('.place_your_order1').addClass('skeleton_loader');
            //         let tomorrow='1';
            // $.ajax({
            //         type: 'post',
            //         url:"<?php echo base_url('realtime_feasabilty_check')?>",
            //         data:{tomorrow:tomorrow},
            //         success: function (response){
            //             var resp = $.parseJSON(response);
            //             if(resp.time==false){
            //                 $('.delivery_time4').val();
            //                 $(".noon-time10").html('');
            //                 $('.day8').removeClass('skeleton_loader');
            //                 $('.day9').removeClass('skeleton_loader');
            //                 $('.place_your_order1').removeClass('skeleton_loader');
            //             }
            //             else{
            //                 let time = resp.time;
            //                 $(".noon-time10").html(time);
            //                 $(".delivery_time4").val(time);
            //                 $('.day8').removeClass('skeleton_loader');
            //                 $('.day9').removeClass('skeleton_loader');
            //                 $('.place_your_order1').removeClass('skeleton_loader');

            //             }
            //         }
            //     });    
            //     });




                $('.earliest-time2').click(function(){
                    $('.day6').addClass('skeleton_loader');
                    $('.day7').addClass('skeleton_loader');
                    var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    $('.place_order_checkout').addClass('skeleton_loader');
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==1){
                            $('.noon-time5').val();
                            $(".noon-time6").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.noon-time5').prop('checked', true);
                            $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').removeClass('skeleton_loader');
                            $('.place_order_checkout').attr('disabled',true);

                        }else if(resp.time==1){
                            $('#time_slot_msg').modal('show');
                            $('.place_order_checkout').attr('disabled',true);

                        }
                        else{
                            let time = resp.time;
                            let time1=time.split('-');
                            $(".noon-time6").html(time1[0]+' '+time1[1]);
                            $('.noon-time5').prop('checked', true);
                            $('.err-available').text('')
                            $('#customRadio39').prop('checked', false);

                             $(".noon-time5").val(time1[0]+' '+time1[1]);                                                                
                            // $(".noon-time6").html(time);
                            // $(".noon-time5").val(time);
                            $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').removeClass('skeleton_loader');
                            $('.place_order_checkout').attr('disabled',false);


                        }
                    }
                });    
                });


function getlocation(){
	if ("geolocation" in navigator){
		navigator.geolocation.getCurrentPosition(function(position){ 
			var currentLatitude = position.coords.latitude;
			var currentLongitude = position.coords.longitude;
            var myLatlng = new google.maps.LatLng(currentLatitude,currentLongitude);
            geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                                $('#project1').val(results[0].formatted_address);
                                for (j = 0; j < results[0].address_components.length; j++) {
                                 if (results[0].address_components[j].types[0] == 'postal_code'){

                                 if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                 }
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'political'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                    town=results[0].address_components[j].long_name
                            }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                   
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                   $('#address-text').text(results[0].address_components[2].long_name);
                                   if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
                                 }
                                $('#address-details').text(results[0].formatted_address);
                                faddress = results[0].formatted_address;
                                $('#address-details1').text(faddress);
                                $('#latitude1').val(currentLatitude);
                                $('#longitude1').val(currentLongitude);
                    var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                            $(".err").text('');          

                            $('.proceed-locate').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                         
                            // $(".noon-time6").html(time);
                            // $(".noon-time5").val(time);
                            $('.proceed-locate').attr('disabled',false);
                            $(".err").text('');          

                           
                            initMap();

                        }
                    }
                });

                                 }
                             }

                                   
                        }
                    }
                });

                               
               
                });	
	}

}







function getlocation10(){
	if ("geolocation" in navigator){
		navigator.geolocation.getCurrentPosition(function(position){ 
			var currentLatitude = position.coords.latitude;
			var currentLongitude = position.coords.longitude;
            var myLatlng = new google.maps.LatLng(currentLatitude,currentLongitude);
            geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                                $('#project1').val(results[0].formatted_address);
                                for (j = 0; j < results[0].address_components.length; j++) {
                                 if (results[0].address_components[j].types[0] == 'postal_code'){

                                
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 
                                 }
                                 if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'political'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   
                            
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                   
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
                                 
                                $('.error-area').text('');
                                $('#latitude1').val(currentLatitude);
                                $('#longitude1').val(currentLongitude);
                                $('.day6').addClass('skeleton_loader');
                    $('.day7').addClass('skeleton_loader');
                    var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    $('.place_order_checkout').addClass('skeleton_loader');
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==1){
                            $('.noon-time5').val();
                            $(".noon-time6").html('&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp');
                            $('.noon-time5').prop('checked', true);
                            $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').attr('disabled',true);
                        }else
                            if(resp.time==2){
                                $('#time_slot_msg').modal('show');
                                $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').removeClass('skeleton_loader');

                                $('.place_order_checkout').attr('disabled',true);

                        }
                        else{
                            let time = resp.time;
                            let time1=time.split('-');
                            $(".noon-time6").html(time1[0]+' '+time1[1]);
                            $('.noon-time5').prop('checked', true);

                             $(".noon-time5").val(time1[0]+' '+time1[1]);                                                                
                            // $(".noon-time6").html(time);
                            // $(".noon-time5").val(time);
                            $('.day6').removeClass('skeleton_loader');
                            $('.day7').removeClass('skeleton_loader');
                            $('.place_order_checkout').removeClass('skeleton_loader');

                        }
                    }
                });
                                 }
                             }

                                   
                        }
                    }
                });

                               
               
                });	
	}

}














$('.time-need1').change(function(){
    var time=$('.time-need1').val();
    if( time!=null){
    var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#customRadio21:checked').val();
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_your_order').attr('disabled',false);

                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot22').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                            }else if(resp.result==2){
                                $('.place_your_order').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot22').html('SELECTED SLOT NOT AVAILABLE<br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot22').text('TIME SLOT NOT AVAILABLE');
                                $('.place_your_order').attr('disabled',true);

                            }
                        
                        }
                });
            }
            });

$('.time-need2').change(function(){
    var time=$('.time-need2').val();
    if( time!=null){
    var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#customRadio21').val();
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_your_order').attr('disabled',false);

                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot22').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                            }else if(resp.result==2){
                                $('.place_your_order').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot22').html('SELECTED SLOT NOT AVAILABLE<br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot22').text('TIME SLOT NOT AVAILABLE');
                                $('.place_your_order').attr('disabled',true);

                            }
                        
                        }
                });
            }
            });

$('.time-need3').change(function(){
    var time=$('.time-need3').val();
    if( time!=null){
    var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#customRadio21').val();
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_your_order').attr('disabled',false);

                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot22').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                            }else if(resp.result==2){
                                $('.place_your_order').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot22').html('SELECTED SLOT NOT AVAILABLE<br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot22').text('TIME SLOT NOT AVAILABLE');
                                $('.place_your_order').attr('disabled',true);

                            }
                        
                        }
                });
            }
});



$('.time-need8').change(function(){
    var time=$('.time-need8').val();
    if( time!=null){
    var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#today2').val();
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot23').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');   
                               $('.place_order_checkout').attr('disabled',false);
                            }else if(resp.result==2){
                                $('.place_order_checkout').attr('disabled',false);
                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot23').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.exact-time1').text('TIME SLOT NOT AVAILABLE');
                                $('.place_order_checkout').attr('disabled',true);

                            }
                        
                        }
                });
            }
});

$('.time-need9').change(function(){  
    var time=$('.time-need9').val();  
    if( time!=null){
    var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#today2').val();
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot23').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                               $('.place_order_checkout').attr('disabled',false);
                           
                            }else if(resp.result==2){
                                $('.place_order_checkout').attr('disabled',false);
                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot23').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                                }else{
                                $('.slot23').text('TIME SLOT NOT AVAILABLE');
                                $('.place_order_checkout').attr('disabled',true);

                            }
                        
                        }
                });
    }
            });

$('.time-need10').change(function(){
    var time=$('.time-need10').val();  
    if( time!=null){
    var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#today2').val();
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        // console.log(response)
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_order_checkout').attr('disabled',false);

                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot23').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                                }else if(resp.result==2){
                                    $('.place_order_checkout').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot23').html('SELECTED SLOT NOT AVAILABLE<br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot23').text('TIME SLOT NOT AVAILABLE');
                                $('.place_order_checkout').attr('disabled',true);

                            }
                        
                        }
                });
            }
});

    $('.add-address-new').click(function(){
        $('#project1').val('');
        $('.err').html('');
        $('#guest-add-address').val('guest');
        $('#guestsign-in').modal('hide');
        $('#address').modal('show');
    });


    $('.selct-time7').change(function(){
        var time=$('.selct-time7').val(); 
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#today1').val();
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            var anchor="<a href='#' class='exact-time'>";
                            $('.err-available').html('SELECTED SLOT AVAILABLE! '+anchor+time+"</a>");
                            $('#customRadio39').val(time);
                            $('.noon-time5').prop('checked',false) 
                            $('.place_order_checkout').attr('disabled',false);

                            }else if(resp.result==2){
                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a href='#' class='exact-time'>";
                                $('.err-available').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+ end[1]+'</a>'+' EARLIEST SLOT AVAILABLE');
                                $('#customRadio39').val(time);
                                $('.noon-time5').prop('checked',false) 
                                $('.place_order_checkout').attr('disabled',false);

                            }else{
                                $('.err-available').html('TIME SLOT NOT AVAILABLE');
                                $('#customRadio39').val(time);
                                $('.noon-time5').prop('checked',false) 
                                $('.place_order_checkout').attr('disabled',true);

                            }
                        
                        }
                });
            }
    });
    $('.noon-time5').click(function(){
            $('#customRadio39').val();
            $('#customRadio39').prop('checked',false);

        
    });
    $('.select-time1').change(function(){
        var time=$('.select-time1').val();  
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('#customRadio11').val();
        var address_id='';
            var ckb_status=$(".adress-type:checked").val();
        
            if($('input[name="customRadio-adddress"]:checked').val()!=undefined){ 
                address_id=$('input[name="customRadio-adddress"]:checked').val();
            var latitude=$('.latitude'+address_id).val();
        var longitude=$('.longitude'+address_id).val();
        }else{
            var latitude=$('#latitude1').val();
            var longitude=$('#longitude1').val();
        }
        
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                            var resp = $.parseJSON(response); 
                            if(resp.result==1){
                                var anchor="<a href='#' class='exact-time'>";
                                $('.err-available1').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                            $('.noon-time1').prop('checked',false) 
                            $('#customRadio38').val(time);

                            $('.place_your_order').attr('disabled',false);

                            }else if(resp.result==2){
                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a href='#' class='exact-time'>";
                               $('.err-available1').html('SELECTED SLOT NOT AVAILABLE<br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                                $('.noon-time1').prop('checked',false) 
                                $('#customRadio38').val(time);

                                $('.place_your_order').attr('disabled',false);

                            }else{
                                $('.err-available1').text('TIME SLOT NOT AVAILABLE');
                                $('#customRadio38').val(time);
                                $('.noon-time1').prop('checked',false) 
                                $('.place_your_order').attr('disabled',true);

                            }
                        }
                });
            }
       
    });
    $('.noon-time1').click(function(){
            $('#customRadio38').val();
            $('#customRadio38').prop('checked',false);

        
    });

    $('.time-need11').change(function(){
       // alert($('.time-need11').val());  
        var time=$('.time-need11').val();
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('.calender-for-guest').val();
        var date = date.split("-").reverse().join("-");
        var latitude=$('#latitude1').val();
        var longitude=$('#longitude1').val();    
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        // console.log(response)
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_order_checkout').attr('disabled',false);

                            var anchor="<a class='exact-time exact-time400' href='#'>";
                               $('.slot244').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');                            
                            }else if(resp.result==2){
                                $('.place_order_checkout').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time exact-time400' href='#'>";
                               $('.slot244').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot244').text('TIME SLOT NOT AVAILABLE');
                                $('.place_order_checkout').attr('disabled',true);

                            }
                        
                        }
                });
        }
    });
    


    $('.time-need41').change(function(){
       // alert($('.time-need11').val());  

        var time=$('.time-need41').val();
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('.calender-for-guest').val();
        var date = date.split("-").reverse().join("-");
        var latitude=$('#latitude1').val();
        var longitude=$('#longitude1').val();    
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        // console.log(response)
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_order_checkout').attr('disabled',false);

                            var anchor="<a class=' exact-time exact-time400' href='#'>";
                               $('.slot244').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');                            
                            }else if(resp.result==2){
                                $('.place_order_checkout').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time exact-time400' href='#'>";
                               $('.slot244').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot244').text('TIME SLOT NOT AVAILABLE');
                                $('.place_order_checkout').attr('disabled',true);

                            }
                        }
                });
        }
    });
    


    
    $('.time-need12').change(function(){
       // alert($('.time-need11').val());  

        var time=$('.time-need12').val();
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('.calender-for-guest').val();
        var date = date.split("-").reverse().join("-");
        var latitude=$('#latitude1').val();
        var longitude=$('#longitude1').val();    
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        // console.log(response)
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_order_checkout').attr('disabled',false);

                            var anchor="<a class='exact-time exact-time exact-time400' href='#'>";
                               $('.slot244').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');                            
                            }else if(resp.result==2){
                                $('.place_order_checkout').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time exact-time400' href='#'>";
                               $('.slot244').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot244').text('TIME SLOT NOT AVAILABLE');
                                $('.place_order_checkout').attr('disabled',true);

                            }
                        
                        }
                });
            }
    });
    

        

    
    $('.time-need4').change(function(){
       // alert($('.time-need11').val());  

        var time=$('.time-need4').val();
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('.calender-for-user').val();
        var date = date.split("-").reverse().join("-");
        var latitude=$('#latitude1').val();
        var longitude=$('#longitude1').val();    
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        // console.log(response)
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_your_order').attr('disabled',false);

                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot24').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                            }else if(resp.result==2){
                                $('.place_your_order').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot24').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot24').text('TIME SLOT NOT AVAILABLE');
                                $('.place_your_order').attr('disabled',true);

                            }
                        
                        }
                });
            }
    });
    



    $('.time-need6').change(function(){
       // alert($('.time-need11').val());  

        var time=$('.time-need6').val();
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('.calender-for-user').val();
        var date = date.split("-").reverse().join("-");
        var latitude=$('#latitude1').val();
        var longitude=$('#longitude1').val();    
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        // console.log(response)
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_your_order').attr('disabled',false);

                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot24').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                                                       }else if(resp.result==2){
                                                        $('.place_your_order').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot24').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot24').text('TIME SLOT NOT AVAILABLE');
                                $('.place_your_order').attr('disabled',true);

                            }
                        
                        }
                });
            }
    });
    

    $('.time-need7').change(function(){
        var time=$('.time-need7').val();
        if( time!=null){
        var split_time=time.split('-');
        var time1=split_time[0];
        var date=$('.calender-for-user').val();
        var date = date.split("-").reverse().join("-");
        var latitude=$('#latitude1').val();
        var longitude=$('#longitude1').val();    
        $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check_for_tomorow_check')?>",
                    data:{time:time1,
                            date:date,
                            longitude:longitude,
                            latitude:latitude,
                    },
                    success: function (response){
                        // console.log(response)
                        var resp = $.parseJSON(response); 
                        if(resp.result==1){
                            $('.place_your_order').attr('disabled',false);

                            var anchor="<a class='exact-time' href='#'>";
                               $('.slot24').html('SELECTED SLOT AVAILABLE! '+anchor+time+'<a>');  
                                                       }else if(resp.result==2){
                                                        $('.place_your_order').attr('disabled',false);

                               var start= resp.start.split('/');
                               var end= resp.end.split('/');
                               var anchor="<a class='exact-time' href='#'>";
                               $('.slot24').html('SELECTED SLOT NOT AVAILABLE <br>'+anchor+start[1]+' - '+end[1]+'<a> EARLIEST SLOT AVAILABLE');
                            }else{
                                $('.slot24').text('TIME SLOT NOT AVAILABLE');
                                $('.place_your_order').attr('disabled',true);

                            }
                        
                        }
                });
            }
    });
    


        
        $('.calender-for-user').change(function(){
            var date=$('.calender-for-user').val();
            date = date.split("-").reverse().join("-");
            $('#customRadio22:checked').val(date);
        });
         
        $('.calender-for-guest').change(function(){
            var date=$('.calender-for-guest').val();
            $('.slot23').html('');
            date = date.split("-").reverse().join("-");
            $('#today3:checked').val(date);
        });

   </script>

</body>

</html>