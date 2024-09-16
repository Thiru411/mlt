<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />

<?php  $this->load->view('website/inc/scripts-top');?>


<title>Party-Time</title>
<style>
 
</style>
</head>

<body>
    <div class="wrapper ">
    <?php $this->load->view('website/inc/header');?> 
        <section class="party--time-responsive">
            <div class="container">
                <!-- <div class="d-flex d_md_none">
                    <div class="ml-3">
                        <a href="#" class="back_btn"data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                    </div>
                    <p class="party-timee fw-600 align-self-center text-center w-100">Party Time</p>
                     
                </div> -->
                <p class="fs-18 fw-600 mlt-party ">Party Time</p>
                <img class="img-fluid dinning-party" src="<?=$admin_url?>assets/images/party-img.png" alt="">
                <h5 class="fw-600 mlt-experience mb-md-4">Book the MLT Experience for your party</h5>
              
            
                    <p class="fw-500 spcl-magic full d-none">Got a special occasion? hire our pizza truck and let us work our gourmet magic while you celebrate! There’s no better way to celebrate a special occasion than with an experience<span class="read_less d-none">... Read Less</span></p>
                
                    <p class="fw-500 spcl-magic half"><?php echo substr('Got a special occasion? hire our pizza truck and let us work our gourmet magic while you celebrate! There’s no better way to celebrate a special occasion than with an experience ',0,100);?>.<span class="read_more">... Read More</span></p>
                    
                    
                  </p>
                 
                <p class="p-sec fw-600 hw-works d_sm_none">HERE’S HOW IT WORKS:</p>
                <div class="card-deck party-bookings justify-content-center mx-md-0">
                    <div class="card our-bookings mr-68">
                        <div class="card-body p-51">
                            <div class="feather_calendar">
                                <img class="img-fluid gift-calender" src="<?=$admin_url?>assets/images/gift-icon.svg" alt="">
                            </div>
                            <p class="card-text dates-time">Check our bookings calendar for available dates and time slots.</p>
                        </div>
                    </div>
                    <div class="card our-bookings mr-68">
                        <div class="card-body p-51">
                            <div class="feather_calendar">
                                <img class="img-fluid gift-calender" src="<?=$admin_url?>assets/images/foodtry.svg" alt="">
                            </div>
                            <p class="card-text dates-time">Pick and create your very own gourmet MLT menu from our selection of assorted savoury and sweet offerings.</p>
                        </div>
                    </div>
                    <div class="card our-bookings ">
                        <div class="card-body p-51">
                            <div class="feather_calendar">
                                <img class="img-fluid gift-calender" src="<?=$admin_url?>assets/images/mobile-div.svg" alt="">
                            </div>
                            <p class="card-text dates-time">Pay online for your order !!</p>
                        </div>
                    </div>
                </div>
                <div class="text-center d-md-block d-none fixxed-book ">
                    <?php if($user_id!=''){?>
                      <a href="<?=base_url()?>party-time-steps" class="default-btn start-book fw-600">Start Booking</a>
                    <?php }else{ ?>
                        <a href="<?=base_url()?>party-time-steps" class="default-btn start-book fw-600" data-toggle="modal" data-target="#loginmodal">Start Booking</a>


                    <?php }?>
                    
                    </div>
                <div class="text-center d-block d-md-none fixxed-book ">
                      <a href="<?=base_url()?>party-time-steps" class="default-btn start-book fw-600">Book a party</a></div>

            </div>
        </section>
        <?php $this->load->view('website/inc/footer');?>
    </div>


  <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <?php $this->load->view('website/inc/scripts-bottom');?>

<script>

    

$(".read_more").click(function() {  
        $('.full').removeClass('d-none')
        $('.half').addClass('d-none')
        $('.read_less').addClass('d-block')

  });
  $(".read_less").click(function() {  
    $('.half').removeClass('d-none')
        $('.full').addClass('d-none')
       // $('.read_less').addClass('d-block')
  });
    

    </script>

</body>

</html>