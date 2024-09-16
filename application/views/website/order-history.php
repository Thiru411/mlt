<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
<?php $this->load->view('website/inc/scripts-top');?>
<style>
    .rateing-us{
        width:"100"
    }
</style>
<title>Order-History</title>
</head>

<body>
    <div class="wrapper">
    <?php $this->load->view('website/inc/header');?>
    <section class="">
    <div class="container">
               <div class="d_md_none">
                        <div class="ml-3">
                            <a href="<?php echo base_url()?>my-account" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                         <p class="fs-18 fw-600 ordr-hisotry align-self-center text-center w-100">Order History</p>
                 </div>
                  <p class="fs-18 fw-600 ordr-hisotry  d_sm_none">Order History</p>
       



        <?php 
        foreach($getdetails as $rinfo) { 
           // var_dump($rinfo);exit;
            $ordered_date=$rinfo->order_delivery_date;
            $date=date_create($ordered_date);
            $getData=date_format($date,"d M Y");
            if($rinfo->party_time=='yes'){
                $where=array('order_id'=>$rinfo->sk_order_id);
               $package_info= $this->cm->getRecords($where,'mlt_user_packages');
            if($package_info!=false){
                foreach($package_info as $info){?>
        
        <div class="card mlt-histryy histry--complete mt-4 mb-4">
            <div class="complet-histry d-flex">
                <p class="p-sec fw-600 order-numberr "><?=$info->occation?></p>
                <button class="default-btn party-histry  mr-auto">Party </button>
                <p class="deliver-hisrty compllet-histr"><?=$rinfo->order_status?></p>
            <div>   <img class="img-fluid blue-tickk" src="<?=$admin_url?>assets/images/white-tickk.png" alt=""></div>
                
            </div>
            <?php 
             $where=array('sk_package_id'=>$info->package_id,'package_status'=>1);
             $package_info1= $this->cm->getRecords($where,'mlt_package');
             if($package_info1!=false){
                foreach($package_info1 as $info20){
                    $package_name=$info20->package_name;
                }
             }?>
            <div class="spice-products ">
                <div class="d-flex pb-md-4">
                    <p class="spice-itt mr-auto"><?=$package_name?></p>
                    <div class="d-none d-md-block">
                        <div class=" d-flex  ">
                                <div class="reorder-detalis" onclick='myFunction(<?=$rinfo->sk_order_id?>,"user")'> >  <a class="default-btn spicee-details p-sec " href="#">View Order Details</a></div>
                                <!-- <div>  <a class="default-btn spicee-details spice-reorder p-sec " href="<?php echo base_url('website/order-track?id=').base64_encode($rinfo->sk_order_id);?>">Reorder1</a></div> -->
                                <div>  <a class="default-btn spicee-details spice-reorder p-sec " href="tel:9292925353">Connect To Coordinator</a></div>
                                
                        </div>
                    </div>
                </div>
                <?php $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $info->total_package_amount);?>

                <p class="spicee-amt pt-md-4 fw-600">Order Placed on <?=$getData?> for Amount <a class="twel-hundred" href="#"> Rs. <?=$num?></a></p>
                    <div class="d-md-none d-block">
                        <div class=" d-flex  ">
                                <div class="reorder-detalis" onclick="myFunction(<?=$rinfo->sk_order_id?>,'user')">  <a class="default-btn spicee-details p-sec " href="#">View Order Details</a></div>
                                <div>  <a class="default-btn spicee-details spice-reorder p-sec " href="tel:9292925353">Connect To Coordinator</a></div>

                            </div>
                    </div>
            </div>
        </div>
<?php }}?>
        <?php }else{?>

            <div class="card mlt-histryy">
            <div class="ordr-mlt-histry d-flex">
                <p class="p-sec fw-600 order-numberr mr-auto">Order #<?=$rinfo->sk_order_id?></p>
                <p class="deliver-hisrty"><?=$rinfo->order_status?></p>
            <div>   <img class="img-fluid blue-tickk" src="<?=$admin_url?>assets/images/blue-tick.png" alt=""></div>
                
            </div>
            <div class="dish-products">
                <p class="twoo-products"><?=$rinfo->total_order_quantity?> Items</p>
                    <div class="row">
                        <ul class="col-md-7 ">
                        <?php    $getOrderDetails=$this->am->fetchOrderHistoryDetails($rinfo->sk_order_id);
                                      foreach($getOrderDetails as $cinfo){ 
                                        ?>
                            <li class="lia-italy fw-600 mt-md-3 d-flex" >
                                <p class="mr-auto"><?=$cinfo->cart_count?> X <?=$cinfo->display_name?><span class="italiaaa">- <?=$cinfo->item_name?></span> </p> </p>
                                <?php $num12 = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $cinfo->cprice);?>

                                <p class="fw-500 dish-cost">₹<?=$num12?></p>
                            </li>
                            <?php }?>
                          
                        </ul>
                        <div class="col-md-5 d-md-block  align-self-center ordering-detalis ">
                                <div class=" d-md-block d-none">
                                    <div class=" d-flex justify-content-md-end">
                                       
                                        <div class="reorder-detalis" onclick="myFunction(<?=$rinfo->sk_order_id?>,'user')">  <a class="default-btn dish-details p-sec " href="#"  >View Order Details</a></div>
                                        <div>  <a class="default-btn dish-details dish-reorder p-sec " href="<?php echo base_url('website/order-track?id=').base64_encode($rinfo->sk_order_id);?>">Track-Order</a></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <?php $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $rinfo->total_order_value);?>

                            <p class="jun-amt pt-md-4 pt-3 fw-600">Order Placed on <?=$getData?> for Amount <a class="twel-hundred" href="#" class="fw-400"> Rs <?=$num?></a></p>
                            <div class="d-block d-md-none">
                                <div class=" d-flex justify-content-md-end ">
                                        
                                        <div class="reorder-detalis" onclick="myFunction(<?=$rinfo->sk_order_id?>,'user')">  <a class="default-btn dish-details p-sec " href="#"  >View Order Details</a></div>
                                        <div>  <a class="default-btn dish-details dish-reorder p-sec " href="<?php echo base_url('website/order-track?id=').base64_encode($rinfo->sk_order_id);?>">Track-Order</a></div>
                                </div>
                           </div>
            </div>
        </div>
        <?php }}?>



        
    </div>
</section>
        <!-- Button trigger modal -->
         <!--   <button type="button" class="btn btn-primary" id="" data-toggle="modal" data-target="#order-details">
                Order-Details
            </button>-->
            
            <!-- Modal -->
            <div class="modal fade details-order" id="order-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            
                            <h class="modal-title d_sm_none" id="exampleModalLabel">ORDER DETAILS</h>
                            <button type="button" class="close d_sm_none" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><div><img class="img-fluid cancel" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                            </button>
                        </div>
                        <div class="modal-body ">
                            <div class="d-flex d_md_none ">
                                    <div class="ml-3">
                                        <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
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
                                            <p class="rate-us pt-1 mr-3">Rate us now</p>
                                            <!-- <div id="rateYo"></div>                                         -->
                                            <div class="rate-us-image d-flex " data-toggle="modal" data-target="#rate">
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
            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

    </div>
<?php $this->load->view('website/inc/scripts-bottom');?>

  
 
<script>



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
    // $('#rate').rating({
    //     size:40,        
    //     hoverColor:"#5FC2AE",        
    //     count:5                         
    // });   
    $("#rateYo").rateYo({
    ratedFill: "#5FC2AE",
        onSet: function (rating) {
            var order_id=$('#order-id-rating').val();
            alert(order_id)
                $.ajax({
           type: 'post',
           url:"<?php echo base_url()?>website/rating",
           data: {
            order_id:order_id,
            rating:rating
           },
           success: function (response)
           {
  
        },
    });
}
 });    
 
</script>
<script>
function myFunction(sk_order_id,val) {
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
          slug1=slug1.replace(/\s+/g, "");
          //alert("Order #"+slug1)

          //alert("Order #"+slug1);
          var slug2=temp[1];
         var slug3=temp[2];
         var slug4=temp[3];
          var slug5=temp[4];
         //alert(slug5)
          var slug6=temp[5];
          var slug7=temp[6];

         
          var slug8=temp[7];
         var slug9=temp[7];
        
         var slug10=temp[8];
          
          var slug11=temp[10];
          var slug18=temp[17];
          var slug19=temp[18];
          var slug20=temp[19];
          var rate='';
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
        //  alert(rate)
$('.sk_order_id').html("Order #"+slug1);
$('#order-id-rating').val(slug1);
slug3=slug3.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

$('.date').html("Order placed on "+ slug2 +" for Amount Rs " +slug3);
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
            var slug25=temp[17];
$('.useraddress').html(slug25+','+slug4);

$('.displayname').html(slug6); 
$('.displayname12').html(slug7); 

$('.itemnam').html("-" +slug8);   
        
$('#order-details').modal('show');

           }
           });

           
}



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

        </script>

</body>

</html>