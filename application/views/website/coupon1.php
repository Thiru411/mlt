<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php  $this->load->view('website/inc/scripts-top');?>

    <style>
        #ui-id-2{ height: 324px;width: 401px !important;padding: 30px 0 0 0;overflow-y: auto;z-index: 10000;background: #0A100D;border: 0;}
        #ui-id-2.ui-menu .ui-menu-item-wrapper{border-bottom: 1px solid rgb(170 174 187 / 16%) !important;padding: 0 0 16px 0;margin: 0 0 16px 0;}
        #ui-id-2.ui-menu .ui-menu-item-wrapper.ui-state-active{background: linear-gradient(0deg, rgba(255, 255, 255, 0.09), rgba(255, 255, 255, 0.09)), #121212;border: 0;border-color: transparent;}
        #ui-id-2 .ui-menu-item-wrapper p{font-weight: 600;font-size: 16px;color: #FFFFFA;text-transform: capitalize;line-height: 24px;}
        #ui-id-2 .ui-menu-item-wrapper span{display: block;font-size: 14px;line-height: 22px;color: rgba(255, 255, 250, 0.8) !important;text-transform: capitalize;font-weight: 400;margin-top: 8px;}

        #map1{width: 100%;height: 149px;border-radius: 16px;}
        @media only screen and (max-width: 426px) {  
            .modal-backdrop.show {opacity: 1;background: transparent;display: none;}  
            .close{display: none;}
            #ui-id-2 .ui-menu-item-wrapper p {  font-size: 12px;  line-height: 18px;}
            #ui-id-2 { width: 100% !important;  padding: 4px 23px 0 0;}
            #ui-id-2 .ui-menu-item-wrapper span {    font-size: 12px;    line-height: 18px;}
        }

        /* Rajesh */
        .pac-container {background-color: #FFF;z-index: 20000;position: fixed;display: inline-block;float: left;}
    </style>
    <style>
        #myMap {
		   height: 350px;
		   width: 680px;
		}
        </style>
    <title>Coupon page</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1Z3e-xBgzeKw10ou7QQ6NaNfcI3UZ4KM&libraries=places"></script>
    
</head>
<body>
    <div class="wrapper">
    <?php  $this->load->view('website/inc/header');?>

        <!-- Location Modal -->
        
        <!-- Location Modal -->

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
                <p class="coupon-title fw-600">Check Out</p>
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
                                    <div class="align-self-center ml-2"><img class="applied" src="<?=$admin_url?>assets/images/applied.png" alt=""></div>
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
                                            <p class="fs-20 fw-600 mb-3 next-time ">Sign in to save your details for next time </p>
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



                    <!-- Button trigger modal -->
                    
                            
                    <!-- Modal -->
                    
                    
            </div>
        </section>
            <!-- <button type="button" class=" btn proceed" data-toggle="modal" data-target="#Checkout">
                Sign in / Sign as Guest
            </button>
        <h5>If customer already signIn</h5>
            <button type="button" class=" btn proceed" data-toggle="modal" data-target="#proceed">
                If customer already signIn select options
            </button>
            <button type="button" class="btn proceed" id="add-address" data-toggle="modal" data-target="#address">
                Add Address
            </button>
            <button type="button" class="proceed" data-toggle="modal" data-target="#iframemap">Iframe Map</button>
            <button type="button" class="proceed" data-toggle="modal" data-target="#iframe_address">Iframe Map / Address</button>
        <h5>If customer already signIn</h5>
        <button type="button" class="proceed" data-toggle="modal" data-target="#guestsign-in">
            Guest Sign-in
        </button> -->

        
    </div>

   <!-- Coupon -->
    <div class="modal fade coupon-popup" id="applycoupon" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="d-flex d_md_none w-100 mb-4">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="add-adres fw-600 align-self-center text-center w-100">Add Address</p>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><div><img class="img-fluid mb-md-1 mr-md-4" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                    </button>
                    <p class="coupon-modal fw-600 mb-4 d_sm_none">Coupons</p>
                    <!-- error-coupon -->
                    <div class="">
                        <input type="text" class="coupon-note fw-500 coup-list  mb-4" placeholder="Enter Coupon Code">
                        <button type="button" class="apply fw-500">Apply</button>
                    </div>
                    <div class="scroll custom-scrollbar">

                    <?php if($coupon_details){
                            foreach($coupon_details as $info1){?>
                        <div class="custom-control custom-radio mb-3">
                            <input type="radio" id="abc<?=$info1->sk_coupon_id?>" name="couponradio" class="custom-control-input">
                            <label class="custom-control-label  d-flex " for="abc<?=$info1->sk_coupon_id?>"> <div>
                                <div><input type="hidden" value="<?=$info1->sk_coupon_id?>" id="coupon_id">
                                <p class="exl-text<?=$info1->sk_coupon_id?> fw-500"><?=$info1->coupon_code?></p>
                                <p class="discount fw-400">Get  <?=$info1->coupon_price?> off on your first order</p></div>
                                <input type="hidden" id="coupon_price<?=$info1->sk_coupon_id?>" value="<?=$info1->coupon_price?>">
                            </div>
                            <p class="apply-discount text-center ml-auto mb-3"onClick="applycoupon(<?=$info1->sk_coupon_id?>)">Apply</p></label>
                        </div>
                        <div class="d-flex error-msg<?=$info1->sk_coupon_id?>" style="display:none">
                            <div class="oops-img img-fluid  mr-2"> <img class="oops-img" src="<?=$admin_url?>assets/images/oops.png" style="display:none"></div>
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
                        <p class="add-adres fw-600 align-self-center text-center w-100 ">Add Address</p>
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
                            <input type="text" id="project1" value="" class="form-control location_search ui-autocomplete-input" placeholder="Enter delivering location" autocomplete="off">
                            <input type="hidden" id="project-id1">
                            <input type="hidden" id="city2">
                            <input type="hidden" id="cityLat">
                            <input type="hidden" id="cityLng">
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

                        </div>
                        </a>

                        <button class="default-btn p-sec fw-600 proceed1 proceed-locate ">Proceed</button>

                </div>
            
            </div>
        </div>
    </div>
    <!-- If customer already signIn select options -->
    <div class="modal fade proceed-popup" id="proceed" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <div class="d-flex d_md_none ">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="check-outt fw-600 align-self-center text-center w-100">Checkout</p>
                        
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><div><img class="img-fluid cancel-selc-option" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                    </button>
                    <h4 class="proceed-modal  fw-500 " id="username">Hello Miguel,</h4>
                    <div class="scrolling-bar custom-scrollbar">
                            <p class="whn-should mt-md-4 fw-500">When should we deliver it?</p>
                    
                            <div class="d-flex to-tom mt-3 position-relative ">
                                <div class="custom-control custom-radio  days-month">
                                    <input type="radio" id="customRadio11" name="delivery_date" value="<?=$post_date?>" class="custom-control-input today-tomaro delivery_date" checked>
                                    <label class="custom-control-label" for="customRadio11"> 
                                        <p class="fw-500 to-dayy ">Today</p>
                                    </label>
                                </div>
                                <?php $date= date("Y-m-d", strtotime('tomorrow'));?>

                                <div class="custom-control custom-radio  days-month">
                                    <input type="radio" id="customRadio21"  name="delivery_date" value="<?=$date?>" class="custom-control-input tomaro-today delivery_date">
                                    <label class="custom-control-label ml-md-3 ml-2 " for="customRadio21"> 
                                        
                                        <p class="fw-500 tom-dayy ">Tomorrow</p>   
                                    </label>
                                </div>
                                <div class="position-relative">
                                    <!-- <img class="img-fluid dwn-drop" src="<?=$admin_url?>assets/images/dwn.png" alt=""> -->
                                    <!-- <input  type="name" id="datepicker" name="delivery_date" value="Select Date" class="date-pick"> -->
                                    <!-- <div class=" select-size select-time ml-md-3 ml-2 date-slect">
                                        <select class="selectpicker size-base">
                                            <option>Select Date</option>
                                            <option>1-10-2021</option>
                                            <option>2-10-2021</option>
                                            <option>3-10-2021</option>
                                            <option>4-10-2021</option>
                                            <option>5-10-2021</option>
                                            <option>6-10-2021</option>
                                        </select>
                                    </div> -->
                                </div>
                                
                            </div>
                            
                            <div class="  today-data" id="first" >
                                <p class="whn-should  fw-500">SELECT DELIVERY Time</p>
                                <div class="d-flex mt-3" >
                                    <div class="custom-control custom-radio days-month ">
                                        <input type="radio" id="customRadio31" name="delivery_time" value="1:30 PM" class="custom-control-input" >
                                        <label class="custom-control-label" for="customRadio31"> 
                                            <p class="fw-500 noon-time time-fixed ">1:30 PM</p>
                                        </label>
                                    </div>
                                    <div class="or-popup"> <p class="whn-should orrr fw-500">OR</p></div>
                                    <div class=" select-size select-time">
                                        <select class="selectpicker size-base selct-time" >
                                            <option>Pick Another Time</option>
                                            <option value="12:00 - 12:30 PM">12:00 - 12:30 PM</option>
                                            <option value="12:30 - 1:00 PM">12:30 - 1:00 PM</option>
                                            <option value="1:00 - 1:30 PM">1:00 - 1:30 PM</option>
                                            <option value="1:30 - 2:30 PM">1:30 - 2:30 PM</option>
                                            <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                                            <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                                <label class="earli-est" >Earliest</label>
                            </div>
                            <div class="tomorrow-data">
                                <p class="whn-should mt-4 fw-500">Select delivery time from the slots</p>
                                <div class=" mt-3 somedata" id="second">
                                <div class="custom-control custom-radio custom-control-inline pl-0 mr-0">
                                    <input type="radio" id="date_select" name="customRadioInline" value="morning" class="custom-control-input slot-time1" >
                                    <label class="custom-control-label" for="date_select">
                                        <div class=" select-size select-timing">
                                            <select class="selectpicker size-base morning-slot" onChange="change_time_mrng_slot('morning')">
                                                <option >12pm - 4PM</option>
                                                <option value="12:30 - 1:00 PM">12:30 - 1:00 PM</option>
                                                <option value="1:00 - 1:30 PM">1:00 - 1:30 PM</option>
                                                <option value="1:30 - 2:00 PM">1:30 - 2:00 PM</option>
                                                <option value="2:00 - 2:30 PM">2:00 - 2:30 PM</option>
                                                <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                                                <option value="3:00 - 3:30 PM">3:00 - 3:30 PM</option>
                                                <option value="3:30 - 4:00 PM">3:30 - 4:00 PM</option>
                                            </select>
                                        </div>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline pl-0 mr-0">
                                    <input type="radio" id="date_select1" name="customRadioInline" value="noon" class="custom-control-input slot-time2">
                                    <label class="custom-control-label" for="date_select1">
                                        <div class=" select-size select-timing ml-md-3 ml-2">
                                            <select class="selectpicker size-base noon-slot " onChange="change_time_mrng_slot('noon')">
                                                <option>4pm - 8pm</option>
                                                <option value="12:30 - 1:00 PM">12:30 - 1:00 PM</option>
                                                <option value="1:00 - 1:30 PM">1:00 - 1:30 PM</option>
                                                <option value="1:00 - 1:30 PM">1:30 - 2:30 PM</option>
                                                <option value="1:00 - 1:30 PM">2:30 - 3:00 PM</option>
                                                <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                                            </select>
                                        </div>
                                    </label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline pl-0 mr-0">
                                    <input type="radio" id="date_select2" name="customRadioInline" value="night" class="custom-control-input slot-time3">
                                    <label class="custom-control-label" for="date_select2">
                                        <div class=" select-size select-timing ml-md-3 ml-2">
                                            <select class="selectpicker size-base night-slot " onChange="change_time_mrng_slot('night')">
                                                <option>8pm - 12 AM</option>
                                                <option value="12:30 - 1:00 PM">12:30 - 1:00 PM</option>
                                                <option value="1:00 - 1:30 PM">1:00 - 1:30 PM</option>
                                                <option value="1:00 - 1:30 PM">1:30 - 2:30 PM</option>
                                                <option value="1:00 - 1:30 PM">2:30 - 3:00 PM</option>
                                                <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                                            </select>
                                        </div>
                                    </label>
                                </div>
                                    
                                    
                                    
                                </div>
                                <p class="whn-should slot mt-2 fw-500">Your selected slot is <a class="exact-time" href="#"> 1:30 - 2:30 PM</a></p>
                            </div>
                            <p class="whn-should mt-40 fw-500">Where should we deliver it?</p>
                            <div class="addd-panel ">
                                <p class="save--add fw-500 ">SAVED ADDRESS</p>
                                <div class="address-add">
                            </div>
                                <button class="default-btn add--new add-address" id="add-address">Add New address<span class="ml-2">+</span> </button>
                            </div>
                            <p class="whn-should mt-40 fw-500">How would you like to pay</p>
                            <div class="addd-panel pay-panel">
                                <p class="save--add fw-500 ">Modes Of Payment</p>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio33" name="customRadio5pay" value="cash" class="custom-control-input" required>
                                    <label class="custom-control-label" for="customRadio33"><p class="p-sec amt-type">Cash/Card on Delivery</p></label>
                                </div>
                                <div class="custom-control custom-radio mt-3">
                                    <input type="radio" id="customRadio32" name="customRadio5pay" value="online" class="custom-control-input" required>
                                    <label class="custom-control-label" for="customRadio32"><p class="p-sec amt-type">Pay Online</p></label>
                                </div>
                            </div>
                    </div>   
                    </div>
                        <div class="popup-bill">
                            <div class=" two-cart d-flex">
                                <div>  
                                <h5 class="total-cost fw-500">₹1270</h5>
                                <p class="two-items ">2 Items in cart</p>
                                </div>
                                <button class="default-btn  view--cartt  place-ur fw-600 place_your_order">Place Your Order </button>
                            </div>
                        </div>
                
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
      
                            <!-- <div id="map"></div>
                                <input type="hidden" id="la" name="latitude" value=""> <br>
                                <input type="hidden" id="lo" name="longitude" value="">

                            </div> -->
                            
                            <div>
                                <div id="myMap"></div>

                                    <div>
                                        <input id="address"  type="text" style="width:600px;"/>
                                        <br/>
                                        <input type="text" id="latitude" placeholder="Latitude"/>
                                        <input type="text" id="longitude" placeholder="Longitude"/>
                                    </div>
                                </div>

                            <div class="address">
                                    <div class="d-flex mt-2">
                                          <div>
                                                 <img src="<?=$admin_url?>assets/images/modal-address.png" class="img-fluid">
                                          </div>
                                          <div>
                                              <h6 class="address-text" id="address-text">
                                                jayanagar  
                                              </h6>
                                          </div>
                                          <div class="ml-auto">
                                                  <img src="<?=$admin_url?>assets/images/modal-cross.png" class="img-fluid">
                                          </div>
                                    </div>
                                    <div>
                                          <p class="address-details" id="address-details">
                                              18th Main road, 37th F, Jayanagara Jaya Nagar, Bengaluru, Karnataka 560041
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
                                <input type="hidden" id="la1" name="latitude1" value=""> <br>
                                <input type="hidden" id="lo1" name="longitude1" value="">
                            </div>
                            <!---->
                             <div class="address">
                                    <div class="d-flex mt-2">
                                          <div>
                                                 <img src="<?=$admin_url?>assets/images/modal-address.png" class="img-fluid">
                                          </div>
                                          <div>
                                              <h6 class="address-text" id="address-text">
                                                jayanagar  
                                              </h6>
                                          </div>
                                          <div class="ml-auto">
                                                  <img src="<?=$admin_url?>assets/images/modal-cross.png" class="img-fluid">
                                          </div>
                                    </div>
                                    <div>
                                          <p class="address-details" id="address-details">
                                              18th Main road, 37th F, Jayanagara Jaya Nagar, Bengaluru, Karnataka 560041
                                          </p>
                                    </div>
                             </div>
                            
                            <form class="formvalidation">
                                <div class="modal-inputs manual-addres">
                                    <div class="mb-40 form-group house_no">
                                            <!-- <div class="holder">House/Flat No. <span class="red"> *</span></div> -->
                                            <input id="input" size="18" type="text" name="house" class="form-control" placeholder="House/Flat No.*"  data-bv-notempty-message="Please Enter house/flat no." autocomplete="off" required>
                                    </div>   
                            
                                        <div class="mb-16 form-group land_mark">
                                            <!-- <div class="holder">Lankmark <span class="red"> *</span></div> -->
                                            <input id="input" size="18" type="text" name="land" class="form-control" placeholder="Landmark *" data-bv-notempty-message="Please enter Landmark" autocomplete="off" required>
                                        </div>

                                        
                                </div>

                                <h6 class="loc-text">What type of location is this?</h6>

                                <div class="form-group home_work">
                                            <div class="d-flex flex-wrap">
                                                <div class="radio-example mx-400">
                                                        <div class="modal-radio btn-group btn-group-toggle" data-toggle="buttons">
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
                                                        </div>
                                                </div>
                                            </div>
                                </div>

                                <div class="confirm-modal pl-0 pr-0 text-right">
                                    <button type="submit" class="default-btn confirm  fw-600" id="confirm_save">Confirm & Save Address</button>
                                </div>
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
                <form class="formvalidation">
                    <div class="modal-body ">
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
                                <p class="fs-20 fw-600 mb-3 next-time">Sign in to save your details for next time </p>
                                <button class="default-btn p-sec fw-600 in--now openloginmodal"  data-toggle="modal" data-target="#loginmodal">Sign1 in Now</button>
                            </div>
                        </div>
                        
                        
                        <p class="proceed-modal  as-guestt fs-20 fw-600 ">Check out as a guest</p>

                        
                        <div class="scrolling-bar custom-scrollbar">
                            <p class="whn-should mt-4 fw-500">When should we deliver it?</p>
                            <div class="d-flex to-tom mt-3 position-relative ">
                                <div class="custom-control custom-radio mb-md-3 days-month">
                                    <input type="radio" id="today1" name="delivery_date" value="<?=$post_date?>" class="custom-control-input today-tomaro"
                                        checked>
                                    <label class="custom-control-label" for="today1">
                                        <p class="fw-500 to-dayy ">Today</p>
                                    </label>
                                </div>
                                <?php $date= date("Y-m-d", strtotime('tomorrow'));?>
                                <div class="custom-control custom-radio mb-md-3 days-month">
                                    <input type="radio" id="today2" name="delivery_date" value="<?=$date?>" class="custom-control-input tomaro-today">
                                    <label class="custom-control-label ml-md-3 ml-2 " for="today2">

                                        <p class="fw-500 tom-dayy ">Tomorrow</p>
                                    </label>
                                </div>
                                <div class="position-relative">
                                    <!-- <img class="img-fluid dwn-drop" src="<?=$admin_url?>assets/images/dwn.png" alt="">
                                    <input value="Select Date" type="name" id="datepicker" name="custom" class="date-pick"> -->
                                    <!-- <div class=" select-size select-time ml-md-3 ml-2 date-slect">
                                        <select class="selectpicker size-base">
                                            <option>Select Date</option>
                                            <option>1-10-2021</option>
                                            <option>2-10-2021</option>
                                            <option>3-10-2021</option>
                                            <option>4-10-2021</option>
                                            <option>5-10-2021</option>
                                            <option>6-10-2021</option>
                                        </select>
                                    </div> -->
                                </div>

                            </div>

                            <div class="  today-data" id="first">
                                <p class="whn-should  fw-500">SELECT DELIVERY Time</p>
                                <div class="d-flex mt-3">
                                    <div class="custom-control custom-radio days-month ">
                                        <input type="radio" id="customRadio31" name="delivery_time"
                                            class="custom-control-input" checked>
                                        <label class="custom-control-label" for="customRadio31">
                                            <p class="fw-500 noon-time ">1:30 PM</p>
                                        </label>
                                    </div>
                                    <div class="or-popup">
                                        <p class="whn-should orrr fw-500">OR</p>
                                    </div>
                                    <div class=" select-size select-time">
                                        <select class="selectpicker size-base selct-time">
                                        <option value="">Pick Another Time</option>
                                            <option value="12:00 - 12:30 PM">12:00 - 12:30 PM</option>
                                            <option value="12:30 - 1:00 PM">12:30 - 1:00 PM</option>
                                            <option value="1:00 - 1:30 PM">1:00 - 1:30 PM</option>
                                            <option value="1:30 - 2:30 PM">1:30 - 2:30 PM</option>
                                            <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                                            <option value="2:30 - 3:00 PM">2:30 - 3:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                                <label class="earli-est">Earliest</label>
                            </div>
                            <div class="tomorrow-data">
                                <p class="whn-should mt-4 fw-500">Select delivery time from the slots</p>
                                <div class="d-flex mt-3 somedata" id="second">
                                    <div class=" select-size select-timing">
                                        <select class="selectpicker size-base">
                                            <option>12pm - 4PM</option>
                                            <option>12pm - 1PM</option>
                                            <option>1:00 - 1:30 PM</option>
                                            <option>1:30 - 2:30 PM</option>
                                            <option>2:30 - 3:00 PM</option>
                                            <option>2:30 - 3:00 PM</option>
                                        </select>
                                    </div>
                                    <div class=" select-size select-timing ml-md-3 ml-2">
                                        <select class="selectpicker size-base ">
                                            <option>12pm - 4PM</option>
                                            <option>12:30 - 1:00 PM</option>
                                            <option>1:00 - 1:30 PM</option>
                                            <option>1:30 - 2:30 PM</option>
                                            <option>2:30 - 3:00 PM</option>
                                            <option>2:30 - 3:00 PM</option>
                                        </select>
                                    </div>
                                    <div class=" select-size select-timing ml-md-3 ml-2">
                                        <select class="selectpicker size-base ">
                                            <option>12pm - 4PM</option>
                                            <option>12:30 - 1:00 PM</option>
                                            <option>1:00 - 1:30 PM</option>
                                            <option>1:30 - 2:30 PM</option>
                                            <option>2:30 - 3:00 PM</option>
                                            <option>2:30 - 3:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="whn-should slot mt-2 fw-500">Your selected slot is <a class="exact-time" href="#">
                                        1:30 - 2:30 PM</a></p>
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
                                                <div class="d-md-flex">
                                                    <div class="form-group">
                                                        <label for="exampleInputname">Name*</label>
                                                        <input type="name" class="form-control input-text " placeholder="marshal matthe|" name="name"  data-bv-notempty-message="Please enter name" required="" data-bv-field="name" id="exampleInputname">
                                                    </div>
                                                    <div class="form-group position-relative number_valid country-code has-error ml-md-4">
                                                        <label for="exampleInputmoblie">Mobile*</label>
                                                        <input type="number" class="form-control log-inn restrict_alphabits input-text " placeholder=" 8959494988" name="moblie"  maxlength="10" minlength="10" autocomplete="off" required="" data-bv-notempty-message="Please enter number" required="" data-bv-field="moblie" id="exampleInputmoblie">
                                                        <span class="validity"></span>
                                                        <p>+91</p>
                                                    </div>     
                                                    </div>  
                                                    <div class="form-group mails-guest mt-md-4 pb-md-4 ">
                                                        <label for="exampleInputemail">Email*</label>
                                                        <input type="email" class="form-control input-text " placeholder="Marshal@gmail.com" name="email" data-bv-notempty-message="Please enter Email" required="" data-bv-field="email" id="exampleInputemail">
                                                    </div>                 
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                    <div class="form-group">
                                                        <label for="exampleInputname">Flat/House No.*</label>
                                                        <input type="text" class="form-control input-text  " placeholder="E-485" name="houseno" data-bv-notempty-message="Please enter house/flat number" required="" data-bv-field="houseno" id="exampleInputhouseno">
                                                    </div>
                                                    <div class="form-group ml-md-4">
                                                        <label for="exampleInputmoblie">Street Address*</label>
                                                        <input type="text" class="form-control input-text " placeholder="Raj Nagar" name="address" data-bv-notempty-message="Please enter street" required="" data-bv-field="address" id="exampleInputaddress">
                                                    </div>     
                                                </div> 
                                                    <div class="d-md-flex  mt-md-3 pb-md-4">
                                                        <div class="form-group ">
                                                            <label for="exampleInputemail">Town/City*</label>
                                                            <input type="text" class="form-control input-text" placeholder="Gurgaon" name="city" data-bv-notempty-message="Please enter town/city"  required="" data-bv-field="city" id="exampleInputcity">
                                                        </div> 
                                                        <div class="form-group mails-guest ml-md-4">
                                                            <label for="exampleInputemail">Pincode*</label>
                                                            <input type="number" class="form-control input-text " placeholder="158476" name="number" data-bv-notempty-message="Please enter code" required="" data-bv-field="number" id="exampleInputnumber">
                                                        </div> 
                                                    </div>                
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="addd-panel pay-panel">
                                    <p class="save--add fw-500 ">How would you like to pay</p>
                                    <div class="custom-control custom-radio mt-md-3 mt-4">
                                        <input type="radio" id="customRadio73"name="customRadio5pay" value="cash" class="custom-control-input">
                                        <label class="custom-control-label cash--card" for="customRadio73">Cash/Card on Delivery</label>
                                    </div>
                                    <div class="custom-control custom-radio mt-md-3 mt-4">
                                        <input type="radio" id="customRadio74" name="customRadio5pay" value="online" class="custom-control-input">
                                        <label class="custom-control-label cash--card" for="customRadio74">Pay Online</label>
                                    </div>
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
                            <button type="submit" class="default-btn  view--cartt  place-ur fw-600 place_your_order1">Place Your Order </button>
                        </div>
                    </div>
                </form>

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

    <?php  $this->load->view('website/inc/scripts-bottom');?>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
                 IsplaceChange = true;
                 document.getElementById('city2').value = place.name;
                $('.address-text').text(place.name);
                 document.getElementById('cityLat').value = place.geometry.location.lat();
                 document.getElementById('cityLng').value = place.geometry.location.lng();
                 document.getElementById('la').value = place.geometry.location.lat();
                 document.getElementById('lo').value = place.geometry.location.lng();
                 
                 var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                 geocoder = new google.maps.Geocoder();
                 geocoder.geocode({'latLng': latlng}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                         if (results[0]) {
                             for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code')
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'neighborhood'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('neighborhood').value = results[0].address_components[j].long_name;
                                 } if (results[0].address_components[j].types[0] == 'route'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('route').value = results[0].address_components[j].long_name;
                                 } if (results[0].address_components[j].types[0] == 'political'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
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
             });initMap();
             });
             
             $("#area-search").keydown(function () {
                IsplaceChange = false;
             });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

<script type="text/javascript"> 
            var map;
            var marker;
            var myLatlng = new google.maps.LatLng(20.268455824834792,85.84099235520011);
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
		       
                map = new google.maps.Map(document.getElementById("myMap"), mapOptions);
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
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(marker.getPosition().lat());
                            $('#longitude').val(marker.getPosition().lng());
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
                                $('#latitude').val(marker.getPosition().lat());
                                $('#longitude').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                            }
                        }
                    });
                });
            
            }
            
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>   
    
    
      
      <script>
        

        
        
        // function initMap() {
        //     var latitude = Number(document.getElementById("la").value);
        //     var longitude = Number(document.getElementById("lo").value);
        //     var uluru = {
        //         lat: latitude,
        //         lng: longitude
        //     };
        //     const map = new google.maps.Map(document.getElementById("map"), {
        //     zoom: 16,
        //     center: uluru,
        //     styles: [
        //       { elementType: "geometry", stylers: [{ color: "#343332" }] },
        //       { elementType: "labels.text.stroke", stylers: [{ color: "#343332" }] },
        //       { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
        //       {
        //         featureType: "road",
        //         elementType: "geometry",
        //         stylers: [{ color: "#454545" }],
        //       },
        //       {
        //         featureType: "road",
        //         elementType: "geometry.stroke",
        //         stylers: [{ color: "#343332" }],
        //       },
        //       {
        //         featureType: "road",
        //         elementType: "labels.text.fill",
        //         stylers: [{ color: "#343332" }],
        //       },
        //       {
        //         featureType: "road.highway",
        //         elementType: "geometry",
        //         stylers: [{ color: "#343332" }],
        //       },
        //       {
        //         featureType: "road.highway",
        //         elementType: "geometry.stroke",
        //         stylers: [{ color: "#343332" }],
        //       },
        //       {
        //         featureType: "road.highway",
        //         elementType: "labels.text.fill",
        //         stylers: [{ color: "#343332" }],
        //       },
        //     ],
        //   });
        //   var iconBase = '../mlt/assets/images/';
        //   marker = new google.maps.Marker({
        //     position: uluru,
        //     animation: google.maps.Animation.DROP,
        //     map: map,
        //     draggable: true,
        //     icon: iconBase + 'location_pin.png'
        //     //title: "Hello World!",
        //   });
        //   google.maps.event.addListener(marker, 'dragend',
        //     function(marker) {
        //         console.log(marker)
        //     //   currentLatitude = marker.position.lat();
        //     //   currentLongitude = marker.position.lng();
        //     //   $("#la").val(currentLatitude);
        //     //   $("#lo").val(currentLongitude);
        //     }
        //   );
        // }
        


        /******* iframe map and address  ********/ 
       
        function initMap1() {
            var latitude1 = Number(document.getElementById("la1").value);
        var longitude1 = Number(document.getElementById("lo1").value);
        
          var uluru = {
            lat: latitude1,
            lng: longitude1
          };
          const map = new google.maps.Map(document.getElementById("map1"), {
            zoom: 16,
            center: uluru,
            styles: [
              { elementType: "geometry", stylers: [{ color: "#343332" }] },
              { elementType: "labels.text.stroke", stylers: [{ color: "#343332" }] },
              { elementType: "labels.text.fill", stylers: [{ color: "#746855" }] },
              {
                featureType: "road",
                elementType: "geometry",
                stylers: [{ color: "#454545" }],
              },
              {
                featureType: "road",
                elementType: "geometry.stroke",
                stylers: [{ color: "#343332" }],
              },
              {
                featureType: "road",
                elementType: "labels.text.fill",
                stylers: [{ color: "#343332" }],
              },
              {
                featureType: "road.highway",
                elementType: "geometry",
                stylers: [{ color: "#343332" }],
              },
              {
                featureType: "road.highway",
                elementType: "geometry.stroke",
                stylers: [{ color: "#343332" }],
              },
              {
                featureType: "road.highway",
                elementType: "labels.text.fill",
                stylers: [{ color: "#343332" }],
              },
            ],
          });
          var iconBase = '../mlt/assets/images/';
          marker = new google.maps.Marker({
            position: uluru,
            animation: google.maps.Animation.DROP,
            map: map,
            draggable: true,
            icon: iconBase + 'location_pin.png'
          });
          google.maps.event.addListener(marker, 'dragend',
            function(marker) {
            //    / console.log(marker)
            }
          );
        }
       // google.maps.event.addDomListener(window, 'load', initMap1);

        /******* iframe map and address  ********/ 

      function applycoupon(coupon_id) {
          var coupon_price=$('#coupon_price'+coupon_id).val();
          var total=$("#total-amt").text();
         var amt=total.split('₹');
            var price=amt[1];
            price=parseInt(price);
            coupon_price=parseInt(coupon_price);
            if(coupon_price>price){
                $('.error1'+coupon_id).text('The item cart price is smaller than coupon price');
                $('.error1'+coupon_id).css('display:block');
            }
            else{
        $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/checkcoupon')?>",
           data: {
            coupon_id:coupon_id,    
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
            $('.coupon-apply').val(coupon_id);
            $('.coupon-cost').val(resp.coupon_save_cost);
            $('#discount-atm').text('₹'+resp.coupon_save_cost);
            setTimeout(function(){
    $('.coupon-succesfull ').fadeOut(6000);
    }, 6000);       

 } 
        
       
    });
}
}

       

  function getValue1(all,val,price1,cart_id,fun) {
      
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
      var num=$('.num').val(); 
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
             var resp = $.parseJSON(response);
             var items=resp.items;
             var cart_price=resp.price;
             document.getElementById('itemsno').innerHTML=items+' ITEMS';
            document.getElementById('total-amt').innerHTML='₹'+cart_price;
            document.getElementById('amt-final').innerHTML='₹'+cart_price;
            document.getElementById('total_items_in_cart').innerHTML=items+' ITEMS IN CART';
            document.getElementById('cart_total').innerHTML='₹'+cart_price;
            if($('#ccart_id').text()!=-1){
            document.getElementById('price-id1'+cart_id).innerHTML='₹'+price;
            }else{
                document.getElementById('price-id1'+ccart_id).innerHTML='₹'+price;   
            }
            $('#item_size'+cart_id).val(size1);
             window.location.reload();
           }
           });
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
                document.getElementById('itemsno').innerHTML=items+' ITEMS';
            document.getElementById('total-amt').innerHTML='₹'+cart_price;
            document.getElementById('amt-final').innerHTML='₹'+cart_price;

            document.getElementById('price-id'+cart_id).innerHTML='₹'+price;
            document.getElementById('total_items_in_cart').innerHTML=items+' ITEMS IN CART';
            document.getElementById('cart_total').innerHTML='₹'+cart_price;
            $('#item_size'+cart_id).val(size1);

            
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
  }
  
  $('.proceed').click(function () {
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
                $('#username').text('Hello, '+resp.name);
                $('#proceed').modal('show');
                var amt=$('.amt').text();
                var itemslist=$('.amt-item').text();
                $('.total-cost').text(amt);
                $('.two-items').text(itemslist);
               
               
               
                $('.address-add').html(resp.addressdetails);
            }
            else{
                $('#guestsign-in').modal('show');
            }
        }
  });
}else{
    
    if(isMobile.any()) {
        $('#guestsign-in').modal('show');
}
else{
    $('#Checkout').modal('show');
}
}
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
    $('.attribute_coupon').val('coupon');
   $('#Checkout').modal('hide');
   $('#loginmodal').modal('show');
//    $('#mobile').val('');
//    $(".error").html(''); 
//    $('#resend-otp').text('');

//    $('.wrong-otp').text('');
//    $('#timer').text('');
 });
    $('.place_your_order').click(function(){
        let paymode=$('input[name="customRadio5pay"]:checked').val();
        let date=$('input[name="delivery_date"]:checked').val();
        let address_id=$('input[name="customRadio-adddress"]:checked').val();
        let time=$('.selct-time').val();
        if(time!=''){
            let time=$('input[name="delivery_time"]:checked').val();
        }
        let total_price=$('.total-price').text();
        let price=total_price.split('₹');
        price=price[1];
        let coupon_id=$('.coupon-apply').val();
        let total_item=$('.total-item').text();
        total_item=total_item.split('');
        total_item=total_item[0];
         let discount_amt=$('input[name="coupon_cost"]').val();
        if(paymode=='cash'){
            $.ajax({
                type: 'post',
                url:"<?php echo base_url('website/order')?>",
                data: {
                    delivery_date:date,
                    delivery_time:time,
                    address_id:address_id,
                    payment_mode:paymode,
                    total_price:price,
                    total_item:total_item,
                    coupon_id:coupon_id,
                    discount_amt:discount_amt,
                    razor_payment_id:''
                },
                success: function (response){
                    var resp = $.parseJSON(response);
                    $('#proceed').modal('hide');
                    window.location.href =resp.redirect_url;
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
                        $.ajax({
                            type: 'post',
                            url:"<?php echo base_url('website/order')?>",
                            data: {
                                delivery_date:date,
                                delivery_time:time,
                                address_id:address_id,
                                payment_mode:paymode,
                                total_price:price,
                                total_item:total_item,
                                coupon_id:coupon_id,
                                discount_amt:discount_amt,
                                razor_payment_id:response.razorpay_payment_id
                            },
                            success: function (response){
                                var resp = $.parseJSON(response);
                                $('#proceed').modal('hide');
                                window.location.href =resp.redirect_url;

                            }
                        });
                        
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
});

$('.add-address').click(function(){
    $('#address').modal('show');
    $('#proceed').modal('hide');

});
$('.proceed1').click(function(){
    $('#iframemap').modal('show');
    $('#address').modal('hide');
});

$('.confirm').click(function(){
    $('#la1').val($('#la').val());
    $('#lo1').val($('#lo').val());
    $('#iframemap').modal('hide');
        initMap1();   
        $('#iframe_address').modal('show');

});


$('#confirm_save').click(function(){
    var city=$('#city2').val();
    var la=$('#la').val();
    var lo=$('#lo').val();
    var pincode=$('#postal_code').val();
    var countryName=$('#countryName').val();            
    var stateName=$('#stateName').val();           
    var locality=$('#locality').val();                          
    var address_deatils=$('#address-details').text();
    var address_type=$('input[name="options"]:checked').val();
    var house=$('input[name="house"]').val();
    var land=$('input[name="land"]').val();
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
            $('.address-add').html(resp.addressdetails);
            

           }

    });
});
  
$("#confirm_save").click(function () {
  if ($(".house_no.form-group").hasClass("has-success") && $(".home_work.form-group").hasClass("has-success")) {
    $('#proceed').modal('show');
    $('#iframe_address').modal('hide');
  }
});

function getlocation(){
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
            $('#cityLat').val(resp.result.latitude);
            $('#cityLng').val(resp.result.longitude);
            $('#postalCode').val(resp.result.zip_code);
            $('#locality').val(resp.result.city);
            $('#la').val(resp.result.latitude);
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
    function getToppingdetails(item_id,item_name,ccart_id){  
      veg_topping = new Array();
      non_veg_topping = new Array();
      flavor = new Array();
      base = new Array();
      sizeA = new Array();
      
      let selected_val=0;
      selected_val=$("#size_"+item_id).val(); 
      $.ajax
           ({
           type: 'post',
           url:base_url+"getToppingModal",
           data: {item_id:item_id,item_name:item_name,selected_val:selected_val},
           success: function (response)
           {
            
            $('#customizeModal').modal('show');  
            $("#toppingContent").html(response); 
            $("#card-amount").html($("#price-id"+item_id).html());
            $("#ccart_id").val(ccart_id);
            var price4=$("#price_item"+ccart_id).val();
            $('.card-amount').text('₹'+price4);
            var size=$('#item_size'+ccart_id).val();
            $('#cart_size').val(size);

           }
        })
        
  }
  </script>  
  <script>
    
    /*limited select options */
    $(document).on("click", ".id-1-select", function(event){
      var limitReached = $('.id-1-select:checked').length >= 3;   
      $('.id-1-select').not(':checked').attr('disabled', limitReached);
      let s1 = $(this).val();
      let s2 = s1.split('#');
      let i_id =  s2[2];
      let t_id = s2[1];
      
      if(!veg_topping.includes(s2[0])){          //checking weather array contain the value
        //veg[i_id].push(s2[0]);               //adding to array because value doesnt exists
        veg_topping.push(s2[0]);
        let count_num1=1;
      count=count_num1+count;
      $('.count-cust').text('+'+count+' add '+'on')

        $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');
        $('.customize').text(veg_topping+non_veg_topping+flavor+cbase+sizeA);

      }else{ 
        veg_topping.splice(veg_topping.indexOf(s2[0]), 1);
        let count_num1=1;
      count=count-count_num1;
      $('.count-cust').text('+'+count+' add '+'on')

        $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');

        $('.customize').text(veg_topping+non_veg_topping+flavor+cbase+sizeA);

          //deleting
      }
     
      
      // veg[i_id][t_id] = veg_topping[i_id];
      //$("#customization-value-"+i_id).val(veg[i_id]);
      //console.log(veg[i_id]);
      
    });
    $(document).on("click", ".id-2-select", function(event){
      var limitReached = $('.id-2-select:checked').length >= 3;   
      $('.id-2-select').not(':checked').attr('disabled', limitReached);
      let p1 = $(this).val();
      let p2 = p1.split('#');
      let p3=p2[1];
      if(!non_veg_topping.includes(p2[0])){          //checking weather array contain the value
        //veg[i_id].push(s2[0]);   
                    //adding to array because value doesnt exists
        non_veg_topping.push(p2[0]);
        let count_num1=1;
      count=count+count_num1
            $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

        $('.customize').text(veg_topping+','+non_veg_topping+flavor+cbase+sizeA);

      }else{ 
        non_veg_topping.splice(non_veg_topping.indexOf(p2[0]), 1);  //deleting
        let count_num1=1;
      count=count-count_num1
            $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

        $('.customize').text(veg_topping+','+non_veg_topping+flavor+cbase+sizeA);

      }
     
      //console.log(nveg);
    });
    $(document).on("click", ".id-3-select", function(event){
      var limitReached = $('.id-3-select:checked').length >= 3;   
      $('.id-3-select').not(':checked').attr('disabled', limitReached);
      let p1 = $(this).val();
      let p2 = p1.split('#');
      let p3=p2[1];

      if(!flavor.includes(p2[0])){          //checking weather array contain the value
        flavor.push(p2[0]); 
       // $('.count-cust').text('+'+count+' add '+'on')
       let count_num1=1;
      count=count_num1+count;
      $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

        $('.customize').text(veg_topping+non_veg_topping+flavor+cbase+sizeA);
            //adding to array because value doesnt exists
      }else{
        let count_num1=1;
      count=count-count_num1;
      $('.count-cust').text('+'+count+' add '+'on')
        //$('.count-cust').text('+'+count+' add '+'on')
        flavor.splice(flavor.indexOf(p2[0]), 1);  
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

        $('.customize').text(veg_topping+non_veg_topping+flavor+cbase+sizeA);
//deleting
      }
    
    });
    $(document).on("click", ".cbase", function(event){
      let p1 = $(this).val();
      let p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
      cbase.push(p2[0]);
 
      }else{
        cbase.pop();
      cbase.push(p2[0]);
      count=count+1;

      }
      $('.count-cust').text('+'+count+' add '+'on')
      $('.customize').text(veg_topping+non_veg_topping+flavor+cbase+sizeA);

    });
    
    $(document).on("click", ".csize", function(event){
      let p1 = $('input[name="sizes"]:checked').val();
      let p2 = p1.split('#');
      
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
 
      }else{
        sizeA.pop();
        sizeA.push(p2[0]);
      count=count+1;

      }
      $('.count-cust').text('+'+count+' add '+'on')
      $('.customize').text(veg_topping+non_veg_topping+flavor+cbase+sizeA);

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

    var amt=$('.amt').text();
                var itemslist=$('.amt-item').text();
                $('.total-cost1').text(amt);
                $('.two-items1').text(itemslist);
               
     $('#Checkout').modal('hide');

 });

 $('.place_your_order1').click(function(){
        let paymode=$('input[name="customRadio5pay"]:checked').val();
        let date=$('input[name="delivery_date"]:checked').val();
        let exampleInputname=$('#exampleInputname').val();
        let exampleInputemail=$('#exampleInputemail').val();
        let exampleInputmoblie=$('#exampleInputmoblie').val();
        let exampleInputhouseno=$('#exampleInputhouseno').val();
        let exampleInputaddress=$('#exampleInputaddress').val();
        let exampleInputcity=$('#exampleInputcity').val();
        let exampleInputnumber=$('#exampleInputnumber').val();
        let time=$('.selct-time').val();
        if(time!=''){
            let time=$('input[name="delivery_time"]:checked').val();
        }
        let total_price=$('.total-price1').text();
        let price=total_price.split('₹');
        price=price[1];
        let coupon_id=$('.coupon-apply').val();
        let total_item=$('.total-item1').text();
        total_item=total_item.split('');
        total_item=total_item[0];
         let discount_amt=$('input[name="coupon_cost"]').val();
        if(paymode=='cash'){
            $.ajax({
                type: 'post',
                url:"<?php echo base_url('website/guest_order')?>",
                data: {
                    delivery_date:date,
                    delivery_time:time,
                    payment_mode:paymode,
                     exampleInputname:exampleInputname,
                    exampleInputemail:exampleInputemail,
                    exampleInputmoblie:exampleInputmoblie,
                    exampleInputhouseno:exampleInputhouseno,
                    exampleInputaddress:exampleInputaddress,
                    exampleInputcity:exampleInputcity,
                    exampleInputnumber:exampleInputnumber,
                    total_price:price,
                    total_item:total_item,
                    coupon_id:coupon_id,
                    discount_amt:discount_amt,
                    razor_payment_id:''
                },
                success: function (response){
                    var resp = $.parseJSON(response);
                    $('#proceed').modal('hide');
                    window.location.href =resp.redirect_url;                   
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
                        $.ajax({
                            type: 'post',
                            url:"<?php echo base_url('website/guest_order')?>",
                            data: {
                                    delivery_date:date,
                                    delivery_time:time,
                                    payment_mode:paymode,
                                    exampleInputname:exampleInputname,
                                    exampleInputemail:exampleInputemail,
                                    exampleInputmoblie:exampleInputmoblie,
                                    exampleInputhouseno:exampleInputhouseno,
                                    exampleInputaddress:exampleInputaddress,
                                    exampleInputcity:exampleInputcity,
                                    exampleInputnumber:exampleInputnumber,
                                    total_price:price,
                                    total_item:total_item,
                                    coupon_id:coupon_id,
                                    discount_amt:discount_amt,
                                    razor_payment_id:response.razorpay_payment_id
                            },
                            success: function (response){
                                var resp = $.parseJSON(response);
                                $('#proceed').modal('hide');
                                window.location.href =resp.redirect_url;                                

                            }
                        });
                        
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
        });


        
        
   </script>

</body>

</html>