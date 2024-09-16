<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  
  <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />

  <?php  $this->load->view('website/inc/scripts-top');?>

  <title>Order-track</title>
<style>
  .stepThree.StepProgress-item.current::after {
   
    background:#5FC2AE;
  
}
  </style>
</head>

<body>
  <div class="wrapper">
  <?php $this->load->view('website/inc/header');?> 
    <!-- Location Modal -->
    <input type='hidden' value='order-track' id='redirect'>
    <!-- Location Modal -->
    
    <section class="order_track">
        <div class="container">
          <div class="d-flex d_md_none">
            <div class="ml-3">
                <a href="<?=$admin_url?>" class="back_btn"data-dismiss="modal" aria-label="Close "><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
            </div>
            <p class="add-adres trck-delivary fw-600 align-self-center text-center w-100">TRACK DELIVERY</p>
            
        </div>
          <p class="trck-delivary d_sm_none fw-600">TRACK DELIVERY</p>
            <div class="row">
            <div class="col-md-6">
 <iframe class="dark_map" src="https://<?=$trackingUrl?>" width="100%" height="572" style="border:0;" allowfullscreen="" loading="lazy"></iframe> 


<!-- <div id="map" class="order_track_map"></div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly&channel=2" async ></script>
Latitude <input type="text" id="la" name="latitude" value="15.151857"> <br>
Longitude<input type="text" id="lo" name="longitude" value="76.923595">-->



</div>
<?php $Accepted5=$Accepted4=$Accepted3=$Accepted2=$Accepted1=''; 
        switch ($order_status) {
          case 'CREATED':
            $Accepted5='current';
            break;
          case 'Accepted':
            $Accepted1='current';
            break;
          case 'Preparation/Transit':
            $Accepted2='current';
            $Accepted1='is-done';

            break;
            case 'Reached':
              $Accepted3='current';
              $Accepted2='is-done';
              $Accepted1='is-done';

              break;
              case 'Completed':
                $Accepted4='current';
                $Accepted3='is-done';
                $Accepted2='is-done';
                $Accepted1='is-done';

  
                break;
          default:$Accepted4='current';
          $Accepted2='is-done';
          $Accepted1='is-done';        }
                // if($order_status=='CREATED'){
                //   $Accepted5='current';
                // }
                // else if($order_status=='Accepted'){
                //          $Accepted1='current';
                //        }else if($order_status=='Preparation/Transit'){
                //         $Accepted2=' current';
                //        }else if($order_status=='Reached'){
                //         $Accepted3=' current';
                //            }else{
                //             $Accepted4=' current';
                //            }
                //       ?>
                <div class="col-md-6">

                
                  <!-- is-done current -->
                    <ul class="StepProgress ">
                        <li class="StepProgress-item stepOne  <?=$Accepted1?> ">
                            <img class="step_img" src="<?=$admin_url?>assets/images/confirmed.png">
                            <p>Order Confirmed</p>
                            <p class="p-sec has-confimed">Your order has been confirmed!</p>
                        </li>
                        <li class="StepProgress-item stepTwo <?=$Accepted2?> " id='step2'>
                            <img class="step_img" src="<?=$admin_url?>assets/images/delivery.png">
                            
                            <p class="">Out for Delivery</p>
                           <!-- <p class="delivery-min fs-20">Delivery in 25 mins</p>-->
                           
                            <p class="p-sec has-confimed">We are on the way, baking your pizza fresh and live!</p>
                        </li>
                        <li class="StepProgress-item stepTwo <?=$Accepted3?> " id="step3">
                            <img class="step_img" src="<?=$admin_url?>assets/images/delivery.png">
                            
                            <p class="">Reached</p>
                            <p class="delivery-min fs-20"></p>
                           
                            <p class="p-sec has-confimed"></p> 
                        </li>
                        
                        <li class="StepProgress-item stepThree <?=$Accepted4?>">
                            <p>Order Delivered</p>
                        </li>
                    </ul>
                    <div class="d-flex trcak-pad">
                      <?php if($user_id==''){?>
                        <button class="default-btn trcak-detalis fw-600" type="button" onclick="myFunction(<?=$order_id?>,'guest')" >View Order Details</button>

                      <?php }else{ ?>
                      <button class="default-btn trcak-detalis fw-600" type="button" onclick="myFunction(<?=$order_id?>,'user')" >View Order Details</button>
                      <?php } ?>
                      <?php if($user_id!=''){?>
                        <a class="default-btn refer-cart fw-600" type="button" href="<?=base_url()?>gift-a-cart">Refer/Gift a Cart</a>

                      <?php }else{?>
                        <a class="default-btn refer-cart fw-600" type="button" data-toggle="modal" data-target="#loginmodal">Refer/Gift a Cart</a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade details-order" id="order-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h class="modal-title d_sm_none" id="exampleModalLabel">ORDER DETAILS</h>
                            <button type="button" class="close d_sm_none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><div><img class="img-fluid " src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                            </button>
                        </div>
                        <div class="modal-body ">
                            <div class="d-flex d_md_none ">
                                    <div class="ml-3">
                                        <a href="<?=base_url()?>order-confirmed" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                                    </div>
                                    <p class="add-adres fw-600 align-self-center text-center w-100">ORDER DETAILS</p>
                                    
                            </div>
                            <div class="scrolling-bar custom-scrollbar rmv-scroll">
                                <div class="card order--placed">
                                    <div class="order--no">
                                        <p class="fw-600 details-no sk_order_id"></p>
                                        <input type="hidden" id="order-id-rating">
                                    </div>
                                    <div class="on-amt">
                                        <p class="p-sec mt-3 july-order date"></p>
                                            <div class="d-flex mt-3 mb-4 rate">
                                            <p class="rate-us">Rate us now</p>
                                            <!-- <div id="rateYo"></div>                                         -->
                                            <div class="rate-us-image d-flex mt-0 ml-3" data-toggle="modal" data-target="#rate">
                                               <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/starr.png" alt=""></div>
                                               <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/starr.png" alt=""></div>
                                               <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/starr.png" alt=""></div>
                                               <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/starr.png" alt=""></div>
                                               <div><img class="img-fluid starrr" src="<?=$admin_url?>assets/images/starr.png" alt=""></div>
                                            </div>
                                      </div>
                                    </div>
                                </div>
                                <div class="card order--placed mt-4">
                                    <div class="order--no">
                                        <p class="fw-600 details-no">DELIVERY ADDRESS</p>
                                    </div>
                                    <div class="on-amt home1">
                                        <div class="d-flex home-pic mt-3">
                                            <img class="img-fluid homee home1 " id="home1"src="<?=$admin_url?>assets/images/home1.png" alt="" style="display:block">
                                            <img class="img-fluid homee work1 " id="work1" src="<?=$admin_url?>assets/images/work.png" alt="" style="display:none">
                                            <img class="img-fluid homee other1 " id="other1" src="<?=$admin_url?>assets/images/other.png" alt="" style="display:none">
                                            <p class="f-20 home-text fw-600 type1"></p>
                                        </div>
                                        <p class="p-sec  flat-no mb-4 useraddress"></p>
                                    </div>
                                  
                                    
                                </div>
                                <div class="card order--invoice mt-4 displayname">
                                

                                
                                
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>

            </div>
    <?php $this->load->view('website/inc/footer');?>

  
  </div>


 

  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <?php $this->load->view('website/inc/scripts-bottom');?>
  <script>
        
        function myFunction(sk_order_id,val) {
   //alert(sk_order_id);
   $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url()?>website/vieworder",
           data: {
            sk_order_id:sk_order_id,
            val:val,
               
           },
           success: function (response)
           {
          var temp=response.split('&&');
          var slug1=temp[0];
          var slug2=temp[1];
         var slug3=temp[2];
        //   alert(slug3)
         var slug4=temp[3];
        // alert(slug5)
          var slug5=temp[4];
        // alert(slug4)
          var slug6=temp[5];
          var slug7=temp[6];

         
          var slug8=temp[7];
         var slug9=temp[7];
        
         var slug10=temp[8];
          
          var slug11=temp[10];
          var slug18=temp[17];
          var slug18=temp[17];

          var slug19=temp[18];
          //alert(slug19)
          var slug20=temp[19];
          var slug25=temp[17];
          // var slug25=temp[18];
          if(temp[19]!=''){
            var slug21=temp[20]
          }

          $('#rateRadio'+slug20).prop('checked', true);       
  if ($('#rateRadio'+slug20).val() == "sad") {
    $(".sad_emoji").fadeIn();
    $(".happy_emoji").fadeOut();
    $(".satisfy_emoji").fadeOut()


  } else if ($('#rateRadio'+slug20).val() == "satisfy") {
    $(".satisfy_emoji").fadeIn();
    $(".happy_emoji").fadeOut();
    $(".sad_emoji").fadeOut();
  } else  if ($('#rateRadio'+slug20).val() == "happy") {
      $(".happy_emoji").fadeIn();
    $(".satisfy_emoji").fadeOut();
    $(".sad_emoji").fadeOut();
  } 
  else{
    $(".happy_emoji").fadeIn()
 
  }

          var slug21=temp[20];
        //  alert(rate)
$('.sk_order_id').html("Order #"+slug1);
$('#order-id-rating').val(slug1);
slug3=slug3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
$('.date').html("Order placed on "+ slug2 +" for Amount Rs. " +slug3);
$('.type1').text(slug5);
if(slug5=='Home'){

document.getElementById('work1').style.display='none';
document.getElementById('other1').style.display='none';
            }else if(slug5=='Work'){
                document.getElementById('home1').style.display='none';

                document.getElementById('work1').style.display='block';
                document.getElementById('other1').style.display='none';

            }else{
                document.getElementById('work1').style.display='none';
                document.getElementById('other1').style.display='block';
                document.getElementById('home1').style.display='none';


            }
          if(slug4!=''){  
$('.useraddress').html(slug25+',' + slug4);
          }else{
            $('.useraddress').html(slug25 + " , " +slug19 + " , " + slug5 + " , " +slug21);

          }
$('.displayname').html(slug6); 
$('.displayname12').html(slug7); 

$('.itemnam').html("-" +slug8);   
        
$('#order-details').modal('show');

           }
           });

          } 
        var currentUrl = window.location.href;
        let url1=currentUrl.split('?');
        function worker() {
  $.ajax({
    url: url1[0]+'1?'+url1[1], 
    success: function(response) {
     // $('.result').html(data);
     var resp = $.parseJSON(response);
      if(resp.order_status=='Accepted'){
          $(".stepOne").addClass('current');
          setTimeout(worker, 100);
    }
      else if(resp.order_status=='Preparation/Transit'){
        $(".stepOne").removeClass('current');
        $(".stepOne").addClass('is-done');
        $("#step2").addClass('current');
      setTimeout(worker, 100);
    
      }else if(resp.order_status=='Reached'){
        $(".stepTwo").removeClass('current');
        $(".stepOne").addClass('is-done');
        $("#step2").addClass('is-done');
        $("#step3").addClass('current');
      setTimeout(worker, 100);
    
      }else if(resp.order_status=='Completed'){
        $("#step3").removeClass('current');
        $(".stepOne").addClass('is-done');
        $("#step2").addClass('is-done');
        $("#step3").addClass('is-done');
        $(".stepThree").addClass('current');
        clearTimeout(id);



      }else{
        $(".stepOne").removeClass('is-done');
        $("#step2").removeClass('is-done');
        $("#step3").removeClass('is-done');
        $(".stepThree").removeClass('current');
      }
    }
   
  });
};

var id=setTimeout(worker, 100);

function getStars(rating) {

// Round to nearest half
rating = Math.round(rating * 2) / 2;
let output = [];

// Append all the filled whole stars
for (var i = rating; i >= 1; i--)
  output.push('<i class="fa fa-star rateing-us" aria-hidden="true" style="color: #5FC2AE; style="width: 200px"></i>&nbsp;');

// If there is a half a star, append it
if (i == .5) output.push('<i class="fa fa-star-half-o" aria-hidden="true" style="color: #5FC2AE; style="width: 200px"></i>&nbsp;');

// Fill the empty stars
for (let i = (5 - rating); i >= 1; i--)
  output.push('<i class="fa fa-star-o" aria-hidden="true" style="color: #5FC2AE; style="width: 200px"></i>&nbsp;');

return output.join('');

}


function emojisfunction(rate){
    var order_id=$('#order-id-rating').val();
  $.ajax
           ({
              type: 'post',
              url:"<?php echo base_url('website/rating')?>",
              data: {
                 rating:rate,
                 order_id:order_id,
              },
           success: function (response)
           {
           
           }
          });
        }


// $("#rateYo").rateYo({
//     ratedFill: "#5FC2AE",
//         onSet: function (rating) {
//           alert()
//             var order_id=$('#order-id-rating').val();
//             alert(order_id)
//                 $.ajax({
//            type: 'post',
//            url:"<?php echo base_url()?>website/rating",
//            data: {
//             order_id:order_id,
//             rating:rating
//            },
//            success: function (response)
//            {
  
//         },
//     });
// }
//  });    
 
</script>
</body>
</html>