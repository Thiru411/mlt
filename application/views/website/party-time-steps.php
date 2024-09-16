<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
<?php  $this->load->view('website/inc/scripts-top');?>
<title>Party-Time-Steps</title>
  <script>
        function RestrictFirstZero(e) {
            if (e.srcElement.value.length == 0 && e.which == 48) {
                e.preventDefault();
                return false;
            }
        };
 
        function PreventFirstZero(event) {
            if (event.srcElement.value.charAt(0) == '0') {
                event.srcElement.value = event.srcElement.value.slice(1);
            }
        };
    </script>

</head>

<body>
    <div class="wrapper">

    <?php  $this->load->view('website/inc/header.php');
            ?>
        <section class="party_time_steps mt-5">
            <div class="container">
         
                
               <div class="d-flex d_md_none ">
                        <div class="ml-3">
                            <a href="<?=base_url()?>party-time" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                         <p class="party_time_text mb-4 align-self-center text-center w-100">Party Time</p>
                 </div>
                <p class="party_time_text mb-4 d_sm_none">Party Time</p>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="row">
                    <div class="col-md-7 party-rotate">
                        <form class="form-horizontal wizard_form" action="" method="POST" id="myform">

                            <fieldset id="occasion_information" class="card party-mood partytime_step1 mb-4 ">
                                <div class="card-header" id="heading01">
                                    <button class="btn btn-link btn-block text-left fw-500" type="button" data-toggle="collapse" data-target="#collapse01" aria-expanded="true" aria-controls="collapse01">
                                        1. WHAT IS THE OCCASION?
                                        <div><img src="<?=base_url()?>assets/images/signin-tick.png" class="img-fluid float-right sign-tick"></div>
                                    </button>
                                </div>
                                <div id="collapse01" class="collapse show" aria-labelledby="heading01" data-parent="#myform">
                                    <div class="card-body">
                                        <div class="form-group mb-0  position-relative">
                                        <div class="custom-control custom-radio custom-control-inline occasion-party pl-0 ">
                                            <input type="radio" id="partytype1" name="occation" class="custom-control-input" value="Birthday">
                                            <label class="custom-control-label" for="partytype1">Birthday</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline occasion-party pl-0 ">
                                            <input type="radio" id="partytype2" name="occation" class="custom-control-input" value="Anniversary">
                                            <label class="custom-control-label" for="partytype2">Anniversary</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline occasion-party pl-0 mr-0">
                                            <input type="radio" id="partytype3" name="occation" class="custom-control-input others" value="others">
                                            <label class="custom-control-label" for="partytype3">Others</label>
                                        </div>
                                        <div class="form-group mt-4 mb-0 others_field">
                                            <input type="text" class="form-control honor-of " name="other_occassion" placeholder="Occasion is in honor of" data-bv-notempty-message="Please enter Occassion">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="next_bar  wizard_step1"><a class="default-btn next">Next</a></div>
                            </fieldset>


                            <fieldset id="party_information" class="card party-mood partytime_step2 mb-4">
                                <div class="card-header" id="heading02">
                                    <button class="btn btn-link btn-block text-left fw-500 " type="button" data-toggle="collapse" data-target="#collapse02" aria-expanded="false" aria-controls="collapse02">
                                        2. When is the party?
                                        <div><img src="<?=base_url()?>assets/images/signin-tick.png" class="img-fluid float-right sign-tick"></div>
                                    </button>
                                </div>
                                <div id="collapse02" class="collapse" aria-labelledby="heading02" data-parent="#myform">
                                    <div class="card-body d-flex">
                                        <div class="form-group d-flex mb-0 position-relative">
                                            <!-- <div class="custom-control custom-radio days-month custom-control-inline">
                                                <input type="radio" id="today1" name="today_tomorrow" value="<?php echo date("Y-m-d")?>" class="custom-control-input">
                                                <label class="custom-control-label" for="today1">
                                                    <p class="fw-500 to-dayy ">Today</p>
                                                </label>
                                            </div> -->
                                            <?php $date= date("Y-m-d", strtotime('tomorrow'));?>

                                            <div class="custom-control custom-radio days-month custom-control-inline">
                                                <input type="radio" id="party" name="today_tomorrow" value="<?=$date?>" class="custom-control-input today_tomorrow_date resetdate">
                                                <label class="custom-control-label" for="party">
                                                    <p class="fw-500 tom-dayy ">Tomorrow</p>
                                                </label>
                                            </div>
                                            <!-- <div class="form-group date position-relative">
                                               <input type='text' class='selectdate' placeholder="Select Date" data-language='en' /> 
                                               <div><img src="<?=base_url()?>assets/images/datearrow.png" ></div>
                                            
                                            </div> -->
                                            <div class="custom-control custom-radio  days-month">
                                                <input type="radio" id="party1"  name="today_tomorrow"  class="custom-control-input tomaro-today delivery_date today_tomorrow_date">
                                                <label class="custom-control-label ml-md-3 ml-2 p-0" for="party1"> 
                                                    <div class="form-group date position-relative">
                                                        <input type='text' class='selectdate selectdate3' placeholder="Select Date" data-language='en' readonly /> 
                                                        <div><img src="<?=base_url()?>assets/images/datearrow.png" ></div>
                                                    </div>
                                                </label>
                                            </div> 
                                            <!-- <div class="custom-control date-form custom-radio days-month custom-control-inline">
             
                                                <input type="radio" id="today3" name="today_tomorrow " class="custom-control-input selectdate"  data-language='en' />
                                                <label class="custom-control-label date-form" for="today3" >
                                                  <p class="fw-500 tom-dayy ">Select Date</p> 
                                                <input type='text' class='selectdate' data-language='en' /> 
                                                     <div class="  select-size select-timing   select-dates position-relative">
                                                        <select class="selectpicker  select_date form-control" >
                                                            <option value=""></option>
                                                            <option value="18/11/2021">18/11/2021</option>
                                                            <option value="19/11/2021">19/11/2021</option>
                                                            <option value="20/11/2021">20/11/2021</option>
                                                            <option value="21/11/2021">21/11/2021</option>
                                                            <option value="22/11/2021">22/11/2021</option>
                                                        </select>
                                                    </div> 
                                                </label>
                                            </div> -->
                                            <!-- <div class="form-group mb-0 select-size select-timing select-dates position-relative">
                                                <select class="selectpicker select_date form-control" name="from_date" id="from_date">
                                                    <option></option>
                                                    <option>18/11/2021</option>
                                                    <option>19/11/2021</option>
                                                    <option>20/11/2021</option>
                                                    <option>21/11/2021</option>
                                                    <option>22/11/2021</option>
                                                </select>
                                            </div> -->
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="next_bar wizard_step2"><a class="default-btn next">Next</a></div>
                            </fieldset>


                            <fieldset id="time_information" class="card party-mood partytime_step3 mb-4">
                                <div class="card-header" id="heading03">
                                    <button class="btn btn-link btn-block text-left fw-500" type="button" data-toggle="collapse" data-target="#collapse03" aria-expanded="false" aria-controls="collapse03">
                                        3. Select the timing of the party
                                        <div><img src="<?=base_url()?>assets/images/signin-tick.png" class="img-fluid float-right sign-tick"></div>
                                    </button>
                                </div>
                               <?php  $rounded = date('H:i A', ceil(strtotime(date('H:i'))/1800)*1800);?>                                
                               <div id="collapse03" class="collapse" aria-labelledby="heading03" data-parent="#myform">
                                    <div class="card-body">
                                        <div class="d-flex somedata" id="second">
                                            <div class="form-group mb-0 select-size select_from_time party_time_dropdown select-timing position-relative">
                                                <select class="selectpicker select_time form-control" name="from_time" id="from_time">
                                                    <option value=""></option>
                                                    <option value="12:00 PM">12:00 PM</option>
                                                    <option value="12:30 PM">12:30 PM</option>
                                                    <option value="01:00 PM">01:00 PM</option>
                                                    <option value="01:30 PM">01:30 PM</option>
                                                    <option value="02:00 PM">02:00 PM</option>
                                                    <option value="02:30 PM">02:30 PM</option>
                                                    <option value="03:00 PM">03:00 PM</option>
                                                    <option value="03:30 PM">03:30 PM</option>
                                                    <option value="04:00 PM">04:00 PM</option>
                                                    <option value="04:30 PM">04:30 PM</option>
                                                    <option value="05:00 PM">05:00 PM</option>
                                                    <option value="05:30 PM">05:30 PM</option>
                                                    <option value="06:00 PM">06:00 PM</option>
                                                    <option value="06:30 PM">06:30 PM</option>
                                                    <option value="07:00 PM">07:00 PM</option>
                                                    <option value="07:30 PM">07:30 PM</option>
                                                    <option value="08:00 PM">08:00 PM</option>
                                                    <option value="08:30 PM">08:30 PM</option>
                                                    <option value="09:00 PM">09:00 PM</option>
                                                    <option value="09:30 PM">09:30 PM</option>
                                                    <option value="10:00 PM">10:00 PM</option>
                                                    <option value="10:30 PM">10:30 PM</option>
                                                    <option value="11:00 PM">11:00 PM</option>
                                                    <option value="11:30 PM">11:30 PM</option>
                                                                                                  </select>
                                            </div>
                                            <div class="align-self-center mx-md-4 mx-2"><p class="fw-500">to</p></div>
                                            <div class="form-group mb-0 select-size select_to_time party_time_dropdown select-timing position-relative ">
                                                <select class="selectpicker select_time select_time22 form-control" id="to_time" name="to_time" to="to_time">
                                                   
                                                <!-- <option value="12:00 PM">12:00 PM</option>
                                                    <option value="12:30 PM">12:30 PM</option>
                                                    <option value="01:00 PM">01:00 PM</option>
                                                    <option value="01:30 PM">01:30 PM</option>
                                                    <option value="02:00 PM">02:00 PM</option>
                                                    <option value="02:30 PM">02:30 PM</option>
                                                    <option value="03:00 PM">03:00 PM</option>
                                                    <option value="03:30 PM">03:30 PM</option>
                                                    <option value="04:00 PM">04:00 PM</option>
                                                    <option value="04:30 PM">04:30 PM</option>
                                                    <option value="05:00 PM">05:00 PM</option>
                                                    <option value="05:30 PM">05:30 PM</option>
                                                    <option value="06:00 PM">06:00 PM</option>
                                                    <option value="06:30 PM">06:30 PM</option>
                                                    <option value="07:00 PM">07:00 PM</option>
                                                    <option value="07:30 PM">07:30 PM</option>
                                                    <option value="08:00 PM">08:00 PM</option>
                                                    <option value="08:30 PM">08:30 PM</option>
                                                    <option value="09:00 PM">09:00 PM</option>
                                                    <option value="09:30 PM">09:30 PM</option>
                                                    <option value="10:00 PM">10:00 PM</option>
                                                    <option value="10:30 PM">10:30 PM</option>
                                                    <option value="11:00 PM">11:00 PM</option>
                                                    <option value="11:30 PM">11:30 PM</option>
                                                    <option value="12:00 AM">12:00 AM</option>
                                                    <option value="12:30 AM">12:30 AM</option>
                                                    <option value="01:00 AM">01:00 AM</option>
                                                    <option value="01:30 AM">01:30 AM</option>
                                                    <option value="02:00 AM">02:00 AM</option>
                                                    <option value="02:30 AM">02:30 AM</option>
                                                    <option value="03:00 AM">03:00 AM</option>
                                                    <option value="03:30 AM">03:30 AM</option>
                                                    <option value="04:00 AM">04:00 AM</option>
                                                    <option value="04:30 AM">04:30 AM</option>
                                                    <option value="05:00 AM">05:00 AM</option>
                                                    <option value="05:30 AM">05:30 AM</option>
                                                    <option value="06:00 AM">06:00 AM</option>
                                                    <option value="06:30 AM">06:30 AM</option>
                                                    <option value="07:00 AM">07:00 AM</option>
                                                    <option value="07:30 AM">07:30 AM</option>
                                                    <option value="08:00 AM">08:00 AM</option>
                                                    <option value="08:30 AM">08:30 AM</option>
                                                    <option value="09:00 AM">09:00 AM</option>
                                                    <option value="09:30 AM">09:30 AM</option>
                                                    <option value="10:00 AM">10:00 AM</option>
                                                    <option value="10:30 AM">10:30 AM</option>
                                                    <option value="11:00 AM">11:00 AM</option>
                                                    <option value="11:30 AM">11:30 AM</option>
                                                    <option value="12:00 AM">12:00 AM</option> -->
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <p class="note-text mt-3">Note: If one increases the time, then extra charge to be shown.</p> -->
                                    </div>
                                </div>
                                <div class="next_bar wizard_step3"><a class="default-btn next">Next</a></div>
                            </fieldset>


                            <fieldset id="count_information" class="card party-mood partytime_step4 mb-4">
                                <div class="card-header" id="heading04">
                                    <button class="btn btn-link btn-block text-left fw-500 " type="button" data-toggle="collapse" data-target="#collapse04" aria-expanded="false" aria-controls="collapse04">
                                        4. HOW MANY PEOPLE WILL BE THERE?
                                        <div><img src="<?=base_url()?>assets/images/signin-tick.png" class="img-fluid float-right sign-tick"></div>
                                    </button>
                                </div>
                                <div id="collapse04" class="collapse" aria-labelledby="heading04" data-parent="#myform">
                                    <div class="card-body">
                                        <div class="form-group mb-0">
                                            <input type="number" class="form-control  input-members " name="no_of_people" placeholder="Enter no. of people" onkeypress="RestrictFirstZero(event)">
                                        </div>
                                    </div>
                                </div>
                                <small class='error24 d-none' style="color:red">NO SLOT AVAILABLE FOR SELECTED TIMINGS</small>
                                <div class="next_bar wizard_step4"><a class="default-btn next">Next</a></div>
                            </fieldset>


                            <fieldset id="package_information" class="card party-mood package_info partytime_step5 mb-4">
                                <p class="select">SELECT A PACKAGE</p>
                                <div class="form-group mb-0 payment_radio">
                                </div>
                                <small id="err-package" style="color:red"></small>

                                <div class="next_bar  wizard_step5"><a class="default-btn next5">Next</a></div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-md-5 pl-76 d_sm_none">
                        <div class="bg-flowers">
                            <div><img class="img-fluid" src="<?=base_url()?>assets/images/bokee.png" alt=""></div>
                            <p class="fs-20 fw-600 prep-party mt-md-5">Let’s prep for party!</p>
                            <p class="fw-500 mt-md-2 life-short">Life is short, wear your party pants.</p>
                        </div>
                    </div> 
                </div>
            </div>
        </section>
        <?php  $this->load->view('website/inc/footer');?>
</div>
<?php  $this->load->view('website/inc/scripts-bottom');?>
<script>
$("input[name=payment_radio22]").click(function(){
    if ($(this).is(':checked')) {
    $("#err-package").hide();
   } else {
    $("#err-package").show();
   }})
  // $('input[name="other_occassion"]')

$(".payment_radio22 input[type='radio']").on("change", function() {
   if ($(this).is(':checked')) {
    $("#err-package").hide();
   } else {
    $("#err-package").show();
   }
});

$(".occasion-party input[type='radio']").on("change", function() {
   if ($(".others").is(':checked')) {
     $('.others_field').show();
   } else {
     $('.others_field').hide();
   }
});
$(document).ready(function () {
    
    // $.validator.setDefaults({
    //     ignore: []
    // });
   
    $(".next").click(function(){
        
        var form = $("#myform");
        form.validate({
        
            errorElement: 'span',
            errorClass: 'help-block',
            highlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
            $(element).closest('.form-group').addClass("has-success");
            },
            rules: {
                occation: {
                    required: true,
                },
                other_occassion:{
                    required: true, 
                },
                today_tomorrow: {
                    required: true,
                },
                from_time: {
                    required: true,
                }, 
                to_time: {
                    required: true,
                }, 
                no_of_people: {
                    required: true,
                }, 
                payment_radio22: {
                    required: true,
                },    
            },
            messages: {
                occation : {
                    required: "Please select occasion",
                },
                other_occassion: {
                    required: "Please mention other occasion",
                },
                today_tomorrow : {
                    required: "Please select when is party",
                },
                from_time : {
                    required: "Please select from time",
                },
                to_time : {
                    required: "Please select to time",
                },
                no_of_people : {
                    required: "Please enter no of people",
                },
                payment_radio22: {
                    required: "Please select your package"
                }
            }
        });
        if (form.valid() === true){
            if ($(".partytime_step1 .btn-link").attr("aria-expanded") == "true"){
            
            $(".partytime_step1 .btn-link").attr("aria-expanded","false");
            $('.partytime_step1 .collapse').removeClass('show');
            $('.wizard_step1').hide();

            $(".partytime_step2 .btn-link").attr("aria-expanded","true");
            $('.partytime_step2 .collapse').addClass('show');
            //$('.partytime_step2 .btn-link').removeClass('disabled');
            next_fs = $('.wizard_step2');
            $(".progress-bar").css("width", "40%");
            next_fs.show(); 

            }else if($(".partytime_step2 .btn-link").attr("aria-expanded") == "true"){  
            
            $(".partytime_step2 .btn-link").attr("aria-expanded","false");
            $('.partytime_step2 .collapse').removeClass('show');
            $('.wizard_step2').hide();
            
            $(".partytime_step3 .btn-link").attr("aria-expanded","true");
            $('.partytime_step3 .collapse').addClass('show');
            //$('.partytime_step3 .btn-link').removeClass('disabled');
            next_fs = $('.wizard_step3');
            $(".progress-bar").css("width", "60%");
            next_fs.show(); 

            }else if($(".partytime_step3 .btn-link").attr("aria-expanded") == "true"){  
            
                $(".partytime_step3 .btn-link").attr("aria-expanded","false");
                $('.partytime_step3 .collapse').removeClass('show');
                $('.wizard_step3').hide();

                $(".partytime_step4 .btn-link").attr("aria-expanded","true");
                $('.partytime_step4 .collapse').addClass('show');
                //$('.partytime_step4 .btn-link').removeClass('disabled');
                next_fs = $('.wizard_step4');
                $(".progress-bar").css("width", "80%");
                next_fs.show(); 

            }else if($(".partytime_step4 .btn-link").attr("aria-expanded") == "true"){  
               
                   
                var select_date=$('.today_tomorrow_date:checked').val();
                var to_time=$('.select_time22').val();
                var from_time=$('.select_time').val();
                $.ajax
                ({
                type: 'post',
                url:"<?php echo base_url('website/validations_packages')?>",
                data: {select_date:select_date,to_time:to_time,from_time:from_time
                },
                success: function (response1)
                { 
                    var resp = $.parseJSON(response1);
                    if(resp.valid==false){
                   
                    $.ajax
                ({
                type: 'post',
                url:"<?php echo base_url('website/packages')?>",
                data: {
                },
                success: function (response)
                { 
                    var resp = $.parseJSON(response);
                    $('.payment_radio').html(resp.packages);
                }
                }); 
                $(".partytime_step4 .btn-link").attr("aria-expanded","false");
                    $('.partytime_step4 .collapse').removeClass('show');
                    $('.wizard_step4').hide();
                    $('.wizard_step5').show();
                    $('#occasion_information').hide();
                    $('#party_information').hide();
                    $('#time_information').hide();
                    $('#count_information').hide();
                next_fs = $('#package_information');
                    $(".progress-bar").css("width", "100%");
                    next_fs.show(); 


            }else{
                $('.error24').removeClass('d-none ');
            }
            }
            });

           
        }
      

            //current_fs.hide();
        }
    });
});


function packages_selected(){
    $("#err-package").text('');
}


$('.select_time22').change(function(){

    var to_time=$('.select_time22').val();
    var from_time=$('.select_time').val();
    var date='';

    var select_date=$('.today_tomorrow_date:checked').val(); //alert(select_date);
    if(select_date==''){
        select_date=$('#party1:checked').val();
    }

});

$('.wizard_step1 .next').click(function(){
    $(".partytime_step1 .btn-link").attr("aria-expanded","true");
    $('.partytime_step1 .collapse').addClass('show');
    $(".progress-bar").css("width", "20%");

    $(".partytime_step2 .btn-link").attr("aria-expanded","false");
    $('.partytime_step2 .collapse').removeClass('show');

    $(".partytime_step3 .btn-link").attr("aria-expanded","false");
    $('.partytime_step3 .collapse').removeClass('show');

    $(".partytime_step4 .btn-link").attr("aria-expanded","false");
    $('.partytime_step4 .collapse').removeClass('show');
});

$('.wizard_step2 .next').click(function(){
    $(".partytime_step1 .btn-link").attr("aria-expanded","false");
    $('.partytime_step1 .collapse').removeClass('show');
    $(".progress-bar").css("width", "40%");

    $(".partytime_step2 .btn-link").attr("aria-expanded","true");
    $('.partytime_step2 .collapse').addClass('show');

    $(".partytime_step3 .btn-link").attr("aria-expanded","false");
    $('.partytime_step3 .collapse').removeClass('show');

    $(".partytime_step4 .btn-link").attr("aria-expanded","false");
    $('.partytime_step4 .collapse').removeClass('show');
});

$('.wizard_step3 .next').click(function(){
    $(".partytime_step1 .btn-link").attr("aria-expanded","false");
    $('.partytime_step1 .collapse').removeClass('show');
    $(".progress-bar").css("width", "60%");

    $(".partytime_step2 .btn-link").attr("aria-expanded","false");
    $('.partytime_step2 .collapse').removeClass('show');

    $(".partytime_step3 .btn-link").attr("aria-expanded","true");
    $('.partytime_step3 .collapse').addClass('show');

    $(".partytime_step4 .btn-link").attr("aria-expanded","false");
    $('.partytime_step4 .collapse').removeClass('show');
});

$('.wizard_step 4.next').click(function(){
    $(".partytime_step1 .btn-link").attr("aria-expanded","false");
    $('.partytime_step1 .collapse').removeClass('show');
    $(".progress-bar").css("width", "80%");

    $(".partytime_step2 .btn-link").attr("aria-expanded","false");
    $('.partytime_step2 .collapse').removeClass('show');

    $(".partytime_step3 .btn-link").attr("aria-expanded","false");
    $('.partytime_step3 .collapse').removeClass('show');

    $(".partytime_step4 .btn-link").attr("aria-expanded","true");
    $('.partytime_step4 .collapse').addClass('show');
});


  $('.next5').click(function(){ //alert(2)
    if($('input[name="payment_radio22"]:checked').val()!=undefined){
        var package_id=$('input[name="payment_radio22"]:checked').val();

    var occation=$('input[name="occation"]:checked').val();
    if(occation=='others'){
      var occation=$('input[name="other_occassion"]').val();

    }
    var select_date=$('.today_tomorrow_date:checked').val();//alert(select_date);
    if(select_date==''){
        select_date=$('#party1:checked').val();
    }
    var from_time=$('#from_time').val();
    var to_time=$('#to_time').val();
    var no_of_people=$('input[name="no_of_people"]').val();

    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/addtopackages')?>",
           data:{
            occation:occation,select_date:select_date,from_time:from_time,
            to_time:to_time,no_of_people:no_of_people,package_id:package_id
           },
           success: function (response)
           {
               //console.log(response);
            var resp = $.parseJSON(response);
           // console.log(resp.redirect_url);
           window.location.href =resp.redirect_url;
           }
           });
    }else{
        $('#err-package').text('Please Select Package');
    } 
  });   



  $(".selectdate3").change(function() {
    var date = $(this).val();
    $("#party1").val(date);
});


$("#from_time").change(function(){
    var from=$('#from_time').val();
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/timing')?>",
           data: {from:from
           },
           success: function (response)
           { 
              // console.log(response)
            $(".select_time22").html(response);
           }
           });    
    });






</script>

</body>

</html>