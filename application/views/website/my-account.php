<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<style>
.tooltip {
  position: relative;
  display: inline-block;opacity: 1;background:transparent;border:0;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 140px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 150%;
  left: 50%;
  margin-left: -75px;

  transition: opacity 0.3s;
}
.copy{background:transparent;border:0;color: #E0AF02;letter-spacing: 0.02em;text-transform: uppercase;font-weight: 500;font-size: 12px;line-height: 22px;float:right;}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
<link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
<?php $this->load->view('website/inc/scripts-top');?>
<title>My account</title>
</head>



<body>
    <div class="wrapper">
    <?php $this->load->view('website/inc/header');?> 
        <section class="my-accountt">
            <div class="container">
                <div class="d-flex account-my">
                    <span class="fs-18 fw-600 my-acc">My Account</span>
                    
                    <a class="d-flex" href="#"  data-toggle="modal" data-target="#myaccountmodal" onclick="myFunction(<?php echo $user_id; ?>)">

                        <img class="img-fluid edit-my" src="<?=$admin_url?>assets/images/edit.png" alt="">
                        <p class="edit-acc fw-500">Edit</p>
                    </a>
                </div>
                <h4 class="helo-mig fw-500">Hello <?=$fullname;?>,</h4>
                <div class="d-flex log-acc">
                    <div class="d-md-flex mr-auto num_options">
                        <p class="phn-number fw-500 ">+91 <?=$mobile;?></p>
                        <!-- <img class="img-fluid dott" src="<?=$admin_url?>assets/images/dott.png" alt=""> -->
                        <p class="mail-design fw-500 mr-auto"><?=$email;?></p>
                    </div>
                    <div>
                        <a class=" d-flex mt-4 mt-md-0" href="<?php echo base_url('website/logout');?>">
                            <img class="img-fluid lg-out" src="<?=$admin_url?>assets/images/lg-out.png" alt="">
                            <p class=" p-sec fw-400 log-out">Logout</p>
                        </a>
                    </div>
                </div>
                <!-- <div class="order-fav  row mx-0">
                    <div class="col-md-6 timer">
                        <a class=" d-flex " href="<?php echo base_url('/order-history')?>">
                            <img class="img-fluid timer-fav" src="<?=$admin_url?>assets/images/timer.png" alt="">
                            <p class="fs-20">Your Orders</p>
                        </a>
                    </div>
                    <div class="col-md-6 timer">
                        <a class=" d-flex " href="<?php echo base_url('/my-favourites')?>">
                            <img class="img-fluid fav-love" src="<?=$admin_url?>assets/images/fav.png" alt="">
                            <p class="fs-20">Favourites</p>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a class=" d-flex " href="<?php echo base_url('/saved-address')?>">
                            <img class="img-fluid saved-add" src="<?=$admin_url?>assets/images/saved.png" alt="">
                            <p class="fs-20">Saved Address</p>
                        </a>
                    </div>
                </div> -->
                 <ul class="list-unstyled profile-list">
                    <li>
                    <a class=" d-flex " href="<?php echo base_url('/order-history')?>">
                            <div class="d-flex mr-auto">
                                <div><img src="<?=$admin_url?>assets/images/order.png" alt=""></div>
                                Your Orders
                            </div>
                            <div><img src="<?=$admin_url?>assets/images/white-arrow.png" alt=""></div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="d-flex" data-toggle="modal" data-target="#exampleModalgift">
                            <div class="d-flex mr-auto">
                                <div><img src="<?=$admin_url?>assets/images/friends.png" alt=""></div>
                                refer Friends
                            </div>
                            <div><img src="<?=$admin_url?>assets/images/white-arrow.png" alt=""></div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="d-flex" data-toggle="modal" data-target="#applycoupon">
                            <div class="d-flex mr-auto">
                                <div><img src="<?=$admin_url?>assets/images/coupon.png" alt=""></div>
                                Coupons
                            </div>
                            <div><img src="<?=$admin_url?>assets/images/white-arrow.png" alt=""></div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="d-flex" data-toggle="modal" data-target="#WinAMedal1">
                            <div class="d-flex mr-auto">
                                <div><img src="<?=$admin_url?>assets/images/feedback.png" alt=""></div>
                                Write your Feedback
                            </div>
                            <div><img src="<?=$admin_url?>assets/images/white-arrow.png" alt=""></div>
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#" class="d-flex">
                            <div class="d-flex mr-auto">
                                <div><img src="<?=$admin_url?>assets/images/chat.png" alt=""></div>
                                Chat with our Representative
                            </div>
                            <div><img src="<?=$admin_url?>assets/images/white-arrow.png" alt=""></div>
                        </a> -->
                    </li>
                    <li>
                    <a class=" d-flex " href="<?php echo base_url('/my-favourites')?>">
                            <div class="d-flex mr-auto">
                                <div><img src="<?=$admin_url?>assets/images/favourites-yellow.png" alt=""></div>
                                favourites
                            </div>
                            <div><img src="<?=$admin_url?>assets/images/white-arrow.png" alt=""></div>
                        </a>
                    </li>
                    <li>
                    <a class=" d-flex " href="<?php echo base_url('/saved-address')?>">
                            <div class="d-flex mr-auto">
                                <div><img src="<?=$admin_url?>assets/images/saved-address.png" alt=""></div>
                                Saved Address
                            </div>
                            <div><img src="<?=$admin_url?>assets/images/white-arrow.png" alt=""></div>
                        </a>
                    </li>
                </ul> 
           </div>
       </section>
       <section class=" app-store account-page position-relative">
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

      <!-- My account Modal -->
<div class="modal fade signup-view" id="myaccountmodal123" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
  
    <div class="modal-content">
      <div class="modal-body ">
        <form class="custom-form formvalidation">
          <button type="button" class="close d-md-block d-none" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <div class="d-flex d_md_none ">
            <div class="ml-3">
                <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
            </div>
            <p class="sign mb-3 text-center text-md-left w-100">Edit Details</p>
            
         </div>
          
         <input type="hidden" class="user_id" value="<?=$user_id?>">

          <div class="form-group name_field">
            <label>Name*</label>
            <input type="name" class="form-control txtOnly name" name="name"  id="name"  data-bv-notempty-message="Please enter name" required autocomplete="off">
          </div>

          <div class="form-group email_field">
            <label>Email*</label>
            <input type="email" class="form-control email" name="email" id="email"  required autocomplete="off">
          </div>

          <div class="form-group num_field number_valid country-code position-relative">
            <label>Enter your mobile number</label>
            <input type="text" class="form-control log-inn restrict_alphabits mobile" name="mobile" id="mobile1"  maxlength="10" minlenght="10" required autocomplete="off" readonly>
            <img class="number_success" src="<?=$admin_url?>assets/images/blue-tick.png" alt="">
            <p class="saved-number p-sec fw-500"><span>+91</span></p>
          </div>
          
          <button type="submit" class="default-btn SignUp" id="update">Update Details</button>
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





<div class="modal fade refer-friend" id="exampleModalgift" tabindex="-1" aria-labelledby="exampleModalLabelgift"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="fw-600">Refer a friend</h5>
                        <div class="d-flex mb-40">
                            <div class="txt-content mr-4 position-relative">1</div>
                            <div>
                                <p class="fw-600">Share the link</p>
                                <p class="link-text fw-500 p-sec">Just copy the code</p>
                            </div>
                        </div>
                        <div class="d-flex mb-40">
                            <div class="txt-content mr-4 padd position-relative">2</div>
                            <div>
                                <p class="fw-600">You recieve the gift</p>
                                <p class="link-text fw-500 p-sec">with 100 for the 1st order</p>
                            </div>
                        </div>
                        <div class="d-flex mb-40">
                            <div class="txt-contents mr-4 padd position-relative">3</div>
                            <div>
                                <p class="fw-600">Your friends get you money</p>
                                <p class="link-text fw-500 p-sec">with 200 & 300 for the consecutive order</p>
                            </div>
                        </div>
                        <div class="link-box">
                            <div class="d-flex">
                            <?php $url_code=$this->session->userdata('user_id');
                           $link=base_url()."e/referafriend".$url_code;?>
                                <input type="text" readonly class="fw-500 link" id="link-copy" value="<?=$link?>"></p>
                                <div class="tooltip ml-auto">
                                    
                                    <button  id="links" onclick="getlink()" class="copy" onmouseout="outFunc()">
                                        <span class="tooltiptext" id="myTooltip">Copy to clipboard</span>
                                         copy
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="footer-signup-gift">
                        <button type="submit" class="btn sign-up-btn fw-600" onclick="referFriends()">Refer Friends Now</button>
                    </div>

                </div>
            </div>
        </div>




        <div class="modal fade success-gift" id="socialicons" tabindex="-1" aria-labelledby="exampleModalLabelsuccess" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="">
                <h5 class="fw-600 pt-1 mb-md-3">Select a medium to share</h5>
            </div>

            <ul class="social_icons d-flex flex-wrap">
            <li><a href="sms:?body=<?=$link?>"target="_blank">
                <img src="<?=$admin_url?>assets/images/messages.png" alt="" ></a></li> 
                <li><a href="https://api.whatsapp.com/send?text=<?=$link?>"data-action="share/whatsapp/share" target="_blank">
                <img src="<?=$admin_url?>assets/images/whatsapp1.png" alt=""></a></li> 
                <li><a href="mailto:?subject=<?=$link?>"title="Share by Email" target="_blank"><img src="<?=$admin_url?>assets/images/gmail.png" alt=""></a></li>
                <li><a href="https://www.instagram.com/send/?url=<?=$link?>"  target="_blank">
                <img src="<?=$admin_url?>assets/images/instagram.png" alt=""></a></li>
            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?=$link?>" target="_blank">
                <img src="<?=$admin_url?>assets/images/facebook.png" alt=""></a></li>  
            <li><a href="https://twitter.com/share?url=<?=$link?>" target="_blank">
                        <img src="<?=$admin_url?>assets/images/twitter.png" alt=""></a></li>
                    
 
            </ul>
        </div>
      </div>
    </div>
  </div>






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







    <div class="modal fade win_rate_share" id="WinAMedal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <input type="hidden"  class="win_user_id" value=<?=$user_id?>>
        <div class="close-modal" data-dismiss="modal" aria-label="Close">
          <img src="<?=$admin_url?>assets/images/close-modal.png" alt="">
        </div>
        <h4 class="text-center">Write Your Feedback</h4>
        <form class="" id="my-accountt" action="" method="post">
          <div class="form-group">
            <textarea class="form-control" name="describe2" id="describe1" placeholder="Write Your Feedback"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn_yellow sent__request1 my-account-feedback" >Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
      <?php $this->load->view('website/inc/footer');?>
   </div>
   <?php $this->load->view('website/inc/scripts-bottom');?>
</body>
</html>
<script>
    function myFunction(user_id) {
        
        $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url()?>website/fetchdetails",
           data: {
            user_id:user_id
               
           },
           success: function (response)
           {
            var temp=response.split('&&');
var slug1=temp[0];
var slug2=temp[1];
var slug3=temp[2];
$('.name').val(slug1);
$('.email').val(slug2);
$('.mobile').val(slug3);

$('#myaccountmodal123').modal('show');

           }
           });


    }

    function myFunction(user_id) {
        $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url()?>website/fetchdetails",
           data: {
            user_id:user_id
               
           },
           success: function (response)
           {
                var temp=response.split('&&');
                var slug1=temp[0];
                var slug2=temp[1];
                var slug3=temp[2];
                $('.name').val(slug1);
                $('.email').val(slug2);
                $('.mobile').val(slug3);

                $('#myaccountmodal123').modal('show');

           }
           });
   }

   $("#update").click(function(){
       var name=$('.name').val();
       var email=$('.email').val();
       var mobile=$('.mobile').val();
       var user_id=$('.user_id').val();
       $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url()?>website/updateuserdetails",
           data: {
            user_id:user_id,name:name,mobile:mobile,email:email
               
           },
           success: function (response)
           {
            window.location.reload();
              

           }
           });
})




</script>
<script>
    $(".my-account-feedback").click(function(){
  var form = $("#my-accountt");
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
     
      describe2: {
        required: true,
    },
      

    },
    messages: {
 
        describe2: {
          required: "please enter feedback",
      }
     
         
    }
  });
  if($("#my-accountt").valid()){
    feed_back(event);
}
});

    </script>

<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js"></script>

<script>

                function getlink(){
                    var copyText=document.getElementById('link-copy');
                    copyText.select();
                    copyText.setSelectionRange(0, 99999); /* For mobile devices */
                    navigator.clipboard.writeText(copyText.value);


                      var tooltip = document.getElementById("myTooltip");
                      tooltip.innerHTML = "Copied ";
                }  

                function outFunc() {
                    var tooltip = document.getElementById("myTooltip");
                    tooltip.innerHTML = "Copy to clipboard";
                }
                

                function referFriends()
                {
                    $('#exampleModalgift').modal('hide');

                    $('#socialicons').modal('show');
                } 




               
// $('.win').click(function(e){
  function feed_back(e){
      e.preventDefault();
    var text_describe=$('#describe1').val();
    if(text_describe!=''){
  $.ajax
           ({
              type: 'post',
              url:"<?php echo base_url('website/feed_back')?>",
              data: {
                text_describe:text_describe
              },
           success: function (response)
           {
                     var resp = $.parseJSON(response);

                     if(resp.boolean!=false){

                        $('#WinAMedal1').modal('hide');
                      $('#describe1').val('');


                     }

           }
          });
        }
      }
            
               
</script>
