<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php  $this->load->view('website/inc/scripts-top');?>
    <title>Gift A Cart</title>

    <style>
        .help-block[data-bv-validator="emailAddress"]{display: none !important;}
        .add-friends input:valid+span:after{display: none}
      
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
</head>

<body>
    <div class="wrapper">
    <?php $this->load->view('website/inc/header');?> 
        <section class="bg-corporate">
            <div class="container">
                <h5 class="fw-600 fs-18 mt-5 d-md-block d-none">GIFT/Refer</h5>
                <h5 class="fw-600 fs-18 mt-5 d-md-none d-block">Gift a Cart</h5>
                <div class="bg-workspace position-relative ">
                    <div class="overlay-img position-relative"><img src="<?=$admin_url?>assets/images/giftpiza.png" class="img-fluid">
                    </div>
                    <p class="fw-500 gift-txt">A Slice so nice, You’ve got to share it thrice!</p>
                </div>
            </div>
        </section>
        <section class="gift-cards">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div><img src="<?=$admin_url?>assets/images/semicircle.png" class="img-fluid semicircle-img"></div>
                            <div><img src="<?=$admin_url?>assets/images/gift-giftbox.png" class="img-fluid giftbox-img"></div>
                            <h5 class="fw-600 mb-4">Gift a cart</h5>
                            <p class="fs-18 fw-500 mb-5">You give us the details of upto 3 people and we deliver a 9”
                                pizza to them free of cost and from your side along with a card and a bouquet.</p>
                                <?php if($user_id!=''){?>
                            <button type="button" class="btn gift-card-btn" data-toggle="modal" data-target="#ddpeople">Gift a cart</button>
                            <?php } else{?>
                                <button type="button" class="btn gift-card-btn"  data-toggle="modal" data-target="#loginmodal">Gift a cart</button>
                    <?php }?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div><img src="<?=$admin_url?>assets/images/semicircle.png" class="img-fluid semicircle-img"></div>
                            <div><img src="<?=$admin_url?>assets/images/giftglass.png" class="img-fluid giftglass-img"></div>
                            <h5 class="fw-600 mb-4">Refer a friend</h5>
                            <p class="fs-18 fw-500 mb-5">You refer people and when they order using your code, you
                                receive 100 for the 1st order, 200 for the 2nd and 300 for the 3rd order.</p>
                                <?php if($user_id!=''){?>

                            <button type="button" class="btn gift-card-btn"  data-toggle="modal" data-target="#exampleModalgift">Refer a friend</button>
                                <?php }else{?>
                                    <button type="button" class="btn gift-card-btn"  data-toggle="modal" data-target="#loginmodal">Refer a friend</button>
                                    <?php }?>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Button trigger modal
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalgift">
            Refer a friend
        </button> -->

        <!-- Modal -->
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
        <!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ddpeople">
    Refer
  </button>-->
  
  <!-- Modal -->
  <div class="modal fade add-friends" id="ddpeople" tabindex="-1" aria-labelledby="exampleModalLabelrefer" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content ">
        <div class="modal-body">
            <form class="mb-70" id="addfrnd" data-toggle="validate" action="" method="post">
            <div class="padd-40">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              
                <div class="d-flex d_md_none w-100 mb-4 ">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <h5 class="add-adres  fw-600 align-self-center text-center w-100">GIFT A CART</h5>
                </div>
                 <h5 class="fw-600 mb-4 d-md-block d-none ">GIFT A CART</h5>
               </div>
                <div class="h-500 pb155 custom-scrollbar">
                    <div class="padd-40">
                    <p class="fw-500">ADD UPTO 3 PEOPLE</p>
                    
                    <div class="accordion mb-4 field_wrapper" id="addpeople_accordion">
                        <div class="card_hidden">
                            <div class="card mb-4">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left fw-500" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <span id="labelHead1">1. Who are we delivering to?</span> 
                                        <img src="<?=$admin_url?>assets/images/referarr.png" class="img-fluid float-right yellow-arr-img">
                                    </button>
                                    <img src="<?=$admin_url?>assets/images/cross1.png" class="img-fluid float-right remove_button cross1-img">
                                    </h2>
                                </div>
                            
                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#addpeople_accordion">
                                    <div class="card-body">
                                        
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group name_accordian">
                                                    <label for="exampleFormControlInput1">Name*</label>
                                                    <input type="text" class="form-control txtOnly" id="friend_name1" placeholder="marshal matthe|" autocomplete="off" name="friend_name1" required >
                                                    </div>
                                                </div> 
                                                <div class="col-md-6">
                                                    <div class="form-group position-relative number_valid country-code-gift num_accordian">
                                                    <label for="exampleFormControlInput2">Mobile*</label>
                                                    <input type="number" class="form-control log-inn restrict_alphabits" id="friend_number1" autocomplete="off" placeholder="8959494988" name="friend_number1" name="number" id="mobile" maxlength="10" minlength="10" autocomplete="off" data-bv-field="mobile" required>
                                                    <!-- <span class="validity"></span> -->
                                                    <p>+91</p>    
                                                </div>
                                                </div> 
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group email_accordian">
                                                    <label for="exampleFormControlInput3">Email*</label>
                                                    <input type="email" class="form-control " id="friend_email1" placeholder="marshal@gmail.com" autocomplete="off" name="friend_email1" required>
                                                    <span class="d-none msg" style="color:red;font-weight: 500;font-size: 80%;">Please enter valid email ID</span>
                                                    </div>
                                                </div> 
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="add_people mb-4 add_button">
                        <div class="d-flex ">
                        <p class="fw-500">ADD PERSON</p>
                        <div class="ml-auto"><img src="<?=$admin_url?>assets/images/plus2.png" class="img-fluid plus2-img "></div>
                        </div>
                    </div>
                </div>
              </div>
                <div class="footer-signup mb-md-3">
                    <input type="hidden" id="user_id" value="<?=$user_id?>">
                    <button type="submit" class="btn sign-up-btn  gift-cart onclick_accordian" >Gift a Cart</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Button trigger modal -->
 <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#socialicons">
    Social Icons
  </button>-->
  <!-- Modal -->
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
  <!-- Modal -->
  <div class="modal fade success-gift" id="requested" tabindex="-1" aria-labelledby="exampleModalLabelsuccess" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="d-md-block d-none">
                 <h5 class="fw-600 mb-4">GIFT A CART</h5>
              </div>
              <div class="text-center">
                <img src="<?=$admin_url?>assets/images/soul.png" class="img-fluid mb-3">
                <h6 class="fw-500 fs-20 mb-4">Your request has been received!</h6>
                <p>You will hear from us shortly</p>
              </div>
        </div>
      </div>
    </div>
  </div>
<input type="hidden" class="inputfieldcount" value="0">
        <!-- <div class="field_wrapper mb-5 pb-5">
            <div>

                <a href="javascript:void(0);" class="add_button" title="Add field">Add Item</a>
            </div>
        </div> -->

        <?php $this->load->view('website/inc/footer');?>

    </div>

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
   
    <?php $this->load->view('website/inc/scripts-bottom');?>
  <script>
      
     // $( ".gift-cart" ).click(function(e){ 
    $("#addfrnd").submit(function(e){

        e.preventDefault();
        let frnd_name=new Array();
        let friend_number=new Array();
        let friend_email=new Array(); 
        let valcount=$('.inputfieldcount').val();
        let user_id=$('#user_id').val();
        if(valcount){
        for(let i=0; i<=valcount;i++){
            //alert($('#friend_number'+i).val());
            let val=i+1;
            let email =$('#friend_email'+val).val();
            let number =$('#friend_number'+val).val();
            let name =$('#friend_name'+val).val();
           if(number.length==10){ 
                if(email!='' && number!='' && name!=''){    
                    frnd_name.push(name);
                    friend_number.push(number);
                    friend_email.push(email);
                }
            }
        }
        //alert(frnd_name.length+" "+(parseInt(valcount)+1));
        if((frnd_name.length!==0 && frnd_name.length==(parseInt(valcount)+1)) && (friend_number.length!==0 && friend_number.length==(parseInt(valcount)+1)) && (friend_email.length!==0 && friend_email.length==(parseInt(valcount)+1))){
            let temp = {"user_id":user_id,"frnd_name":frnd_name,"friend_number":friend_number,"friend_email":friend_email};
            $.ajax({
                type: 'post',
                url:"<?php echo base_url('website/add_friends_gift')?>",
                data: {
                    gift_cart:temp
                },
                success: function (response)
                { 
                    console.log(response);
                    var resp = $.parseJSON(response);
                    if(resp.value=="true"){
                        for(let i=0; i<=valcount;i++){
            let val=i+1;
            $('#friend_email'+val).val('');
           $('#friend_number'+val).val('');
            $('#friend_name'+val).val('');
           
        } 
                    $('#requested').modal('show');   
                    $("#ddpeople").modal("hide");
                        
                    }
                
                }
                
                });
        }
       
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
               
</script>

  

<!-- <script>$(".formvalidation").bootstrapValidator({fields: {email: {validators: {notEmpty: {},regexp: {regexp: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,message: "Please enter a vaild email IDddddd"}}},mobile: {validators: {notEmpty: {required: true,message: "Please enter phone number"},stringLength: {max: 10,message: "Phone number must be atleast 10 digits"}}},  }}).on("success.form.bv", function (e) {e.preventDefault();var $form = $(e.target);fv = $form.data("formValidation");if ($form.attr("action") != undefined) {$form.unbind("submit");$form.submit();}});</script> -->
</body>

</html>