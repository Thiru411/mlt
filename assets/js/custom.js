// $(document).ready(function(){
//   $('.skeleton_loader').removeClass('skeleton_loader');
// });

 /*************Header shrink *****************/ 
//  $.validator.setDefaults({ ignore: [] });

if (navigator.userAgent.indexOf('Mac OS X') != -1) {
  $("body").addClass("mac-os");
} else {
  $("body").removeClass("mac-os");
}
// if(navigator.userAgent.indexOf('Mac') > 0)
// $('body').addClass('mac-os');

$(window).scroll(function(e) {
  if ($(window).scrollTop() > 10) {
      $('body').addClass('sticky');
  } else {
      $('body').removeClass('sticky');
  }
})

if (window.matchMedia('(min-width: 768px)').matches) {
  var lastScrollTop = 0;
  $(window).scroll(function(e) {
    var st = $(this).scrollTop();
    if (st > lastScrollTop) {
        if ($(window).scrollTop() > 20) {
            $('header').removeClass('nav-down').addClass('nav-up');
        } else {
            $('header').addClass('nav-down').removeClass('nav-up');
        }
    } else {
        $('header').addClass('nav-down').removeClass('nav-up');
    }
  lastScrollTop = st;
  })
};

 $(function(){
  var shrinkHeader = 180;
    $(window).scroll(function() {
     var scroll = getCurrentScroll();
        if ( scroll >= shrinkHeader ) 
            {
             $('.fixed-tabs').addClass('fied_to_top');
             $('.tab_background').addClass('top600');
             
            }
        else
           {
             $('.fixed-tabs').removeClass('fied_to_top');
             $('.tab_background').removeClass('top600');
           }
   });
      function getCurrentScroll() {
        return window.pageYOffset || document.documentElement.scrollTop;
      }
});

$(function(){
  var shrinkHeader = 400;
    $(window).scroll(function() {
     var scroll = getCurrentScroll();
        if ( scroll >= shrinkHeader ) 
            {
             $('.pizza_top').addClass('pizza_top_field');
            
            }
        else
           {
             $('.pizza_top').removeClass('pizza_top_field');
           
           }
   });
      function getCurrentScroll() {
        return window.pageYOffset || document.documentElement.scrollTop;
      }
});



if (window.matchMedia('(max-width: 768px)').matches) {
  $(function(){
    var shrinkHeader = 60;
      $(window).scroll(function() {
       var scroll = getCurrentScroll();
          if ( scroll >= shrinkHeader ) 
              {
               $('.fixed-tabs').addClass('fied_to_top');
               $('.tab_background').addClass('top600');
               
              }
          else
             {
               $('.fixed-tabs').removeClass('fied_to_top');
               $('.tab_background').removeClass('top600');
             }
     });
        function getCurrentScroll() {
          return window.pageYOffset || document.documentElement.scrollTop;
        }
  });
};






// $(function(){
//   var shrinkHeader = 100;
//     $(window).scroll(function() {
//      var scroll = getCurrentScroll();
//         if ( scroll >= shrinkHeader ) 
//             {
//              $('header').addClass('shrink');
//             }
//         else
//            {
//              $('header').removeClass('shrink');
//            }
//    });
//        function getCurrentScroll() {
//            return window.pageYOffset || document.documentElement.scrollTop;
//            }
// });


// $(".sign_in").click(function(){
//   var form = $("#signindetails");
//   form.validate({
//     errorElement: 'span',
//     errorClass: 'help-block',
//     highlight: function(element, errorClass, validClass) {
//       $(element).closest('.form-group').addClass("has-error");
//       $(element).closest('.form-group').removeClass("has-success");
//     },
//     unhighlight: function(element, errorClass, validClass) {
//       $(element).closest('.form-group').removeClass("has-error");
//       $(element).closest('.form-group').addClass("has-success");
//     },
//     rules: {
       
//         moblie: {
//             required: true,
//             minlength:10,
//             maxlength:10,
//             digits:true
//         },
       
     
    
//     },
//     messages: {
        
//         moblie : {
//             required: "Please enter valid number",
//             minlength: "Enter 10 digit number",
//             maxlength: "Enter 10 digit number",
//             digits: "Only numbers are allowed in this field"
//         },
//     }
//   });
// });



// $('yourIframe').contents().find('#yourItemYouWantToChange').css({
//   opacity: 0,
//   color: 'purple'
// });

$('.formvalidation').bootstrapValidator({
  fields: {
    email: {
      validators: {
          notEmpty: {
              message: 'Please enter your Email ID'
          },
          regexp: {
            regexp: /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/,
            message: 'Please enter a vaild Email ID'
          }
      }
    },
    mobile: {
      validators: {
          notEmpty: {
            required: true,
              message: 'Please enter mobile number'
          },
          stringLength: {
            max: 10,
            message: 'Mobile number must be atleast 10 digits'
          }
      }
    },
    number: {
      validators: {
          notEmpty: {
            required: true,
              message: 'Please enter pincode number'
          },
          stringLength: {
            max: 6,
            message: 'Pincode must be atleast 6 digits'
          }
      }
    },    
    mobliechechout: {
      validators: {
          notEmpty: {
            required: true,
              message: 'Please enter mobile number'
          },
          stringLength: {
            max: 10,
            message: 'Mobile number must be atleast 10 digits'
          }
      }
    }
  }
}).on('success.form.bv', function (e) {
    // Prevent form submission
    e.preventDefault();
    var $form = $(e.target);
    fv = $form.data('formValidation');
    if ($form.attr('action') != undefined) {
      $form.unbind('submit');
      $form.submit();
    }
});

 

/* Restrict Text */
$('.restrict_alphabits').keydown(function (e) {
  var key = e.charCode || e.keyCode || 0;
  $text = $(this); 
  if (key !== 8 && key !== 9) {
  }
  return (key == 8 || key == 9 || key == 46 || key == 37 || key == 39 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
})

/* Restrict Number */
$( ".txtOnly" ).keypress(function(e) {
  var key = e.keyCode;
  if (key >= 48 && key <= 57) {
      e.preventDefault();
  }
});

/* restrict space */
$('#email').keypress(function( e ) {
  if(e.which === 32) 
  return false;
});

/* restrict space for first letter */
$("input").on("keypress", function(e) {
  if (e.which === 32 && !this.value.length)
  e.preventDefault();
});



$(".address_info").click(function (e) {
  e.preventDefault(), e.stopPropagation(), $('.location-card').show(); 
});
$(".location-card").click(function (e) {
    e.stopPropagation();
});
$("body").click(function () {
  $('.location-card').hide();
});

// $('.address_info').click( function(e) {  
//   $('.location-card').show();
// });    
// $("body").click (
//   function(e) {
//     if(e.target.className !== "address_info") {
//       $('.location-card').hide();
//     }
//   }
// );

$(".close-card").click(function () {
  $('.location-card').hide(); 
});

$(".hamberger").click(function () {
  $('.fixed-tabs').addClass('z_index'); 
});
$(".cross").click(function () {
  $('.fixed-tabs').removeClass('z_index'); 
}); 




$(".opensignupmodal").click(function () {
  
  $('#signupmodal').modal('show');
  $('#loginmodal').modal('hide');
  $('#mobile1').val('');
  $('#email').val('');
  $('#name').val('');
  $(".error").html(''); 
  $('.wrong-otp').text('');
  $('#timer').text('');
  $('#resend-otp').text('');



 
});

// $(".btn_timeslot").click(function () {
//   $('#time_slot_msg').modal('show');
//   $('#guestsign-in').modal('hide');
// });

// $(".close_timeslot").click(function () {
//   $('#time_slot_msg').modal('hide');
//   $('#guestsign-in').modal('show');
// });

// $(".btn_timeslot").click(function () {
//   $('#time_slot_msg').modal('show');
//   $('.proceed-popup ').modal('hide');
// });

// $(".close_timeslot").click(function () {
//   $('#time_slot_msg').modal('hide');
//   $('.proceed-popup ').modal('show');
// });


$(".openloginmodal").click(function () {
   $('#signupmodal').modal('hide');
   $('#loginmodal').modal('show');
   $('#mobile').val('');
   $(".error").html(''); 
   $('#resend-otp').text('');

   $('.wrong-otp').text('');
   $('#timer').text('');
 });
 
 $('#signupmodal, #loginmodal').on('shown.bs.modal', function (e) {
  $('body').addClass('modal-open');
})
 $(function() {
  var rotation = 0, 
      scrollLoc = $(document).scrollTop();
  $(window).scroll(function() {
      var newLoc = $(document).scrollTop();
      var diff = scrollLoc - newLoc;
      rotation += diff, scrollLoc = newLoc;
      var rotationStr = "rotate(" + rotation + "deg)";
      $(".white-round").css({
          "-webkit-transform": rotationStr,
          "-moz-transform": rotationStr,
          "transform": rotationStr
      });
  });
})


$(".cross").click(function () {  
    $('.navbar-collapse').removeClass("show");
});

$(".size-base").select2({
    placeholder: "Select Base"
});
$(".selct-time").select2({
  placeholder: "Pick Another Time"
});

$(".size-selct").select2({
  placeholder: "Select size"
});

$(function () {
    var charLimit = 1;
    $(".inputs").keydown(function (e) {

      var keys = [8, 9, /*16, 17, 18,*/ 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145];

      if (e.which == 8 && this.value.length == 0) {
        $(this).prev('.inputs').focus();
      } else if ($.inArray(e.which, keys) >= 0) {
        return true;
      } else if (this.value.length >= charLimit) {
        $(this).next('.inputs').focus();
        return false;
      }
    }).keyup(function () {
      if (this.value.length >= charLimit) {
        $(this).next('.inputs').focus();
        return false;
      }
    });
  });
 

  $(".hamberger").click(function(){
    $("body").addClass("removeoverflow");
  });

  $(".cross").click(function(){
    $("body").removeClass("removeoverflow");
  });

  
  $(".payment_radio .custom-control").click(function(){ alert()
    $("#err-package").hide();
  });
  

// /*increment and decrement*/
// $('.add').click(function () {
//   if ($(this).prev().val() < 1000) {
//       $(this).prev().val(+$(this).prev().val() + 1);
//   }
// });
// $('.sub').click(function () {
//   if ($(this).next().val() > 1) {
//       if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
//   }
// });
/*increment and decrement*/

/*select */
$(".js-example-placeholder-multiple").select2({
  placeholder: "Customize",
  allowClear: true
});
/*select */

/*fadeout*/
// setTimeout(function(){
//     $('.coupon-succesfull ').fadeOut(3000);
// }, 3000);
/*fadeout*/

// setTimeout(function(){
//     $('.customize_err_message').fadeOut(3000);
//  }, 5000);

setTimeout(function(){
    $('.saved--mesaages').fadeOut(3000);
    }, 5000);

/* inc dec */
  $('.add-cart').click(function(){
    $(this).closest('.cost ').find(this).fadeOut(700);
    $(this).closest('.cost ').find('.inc-dec').fadeIn(700);
  });
/* inc dec */  

$('.heart').click(function () {
  $(this).closest('.like-heart').find(this).fadeOut(700);
  $(this).closest('.like-heart').find('.red-heart').fadeIn(700);
});

$('.red-heart').click(function () {
  $(this).closest('.like-heart').find(this).fadeOut(700);
  $(this).closest('.like-heart').find('.heart').fadeIn(700);
});
/*add address map pin script v*/


$("#customRadio11").on("click", function(){
  check = $(this).prop("checked");
  $('.slot22').html('');
  $('.slot24').html('');
  $('.err-available1').html('');
  $('.place_order_checkout').prop('disabled',true)
    $("#tomorrow_time1").prop('checked', false);
    $("#tomorrow_time2").prop('checked', false);
    $("#tomorrow_time3").prop('checked', false);

    $("#calender_time").prop('checked', false);
    $("#calender_time1").prop('checked', false);
    $("#calender_time2").prop('checked', false);
    
});

$("#customRadio21").on("click", function(){
  check = $(this).prop("checked");
  $('.place_order_checkout').prop('disabled',true)

  $('.slot22').html('');
  $('.slot24').html('');
  $('.err-available1').html('');
  $("#customRadio38").prop('checked', false);

    $("#calender_time").prop('checked', false);
    $("#calender_time1").prop('checked', false);
    $("#calender_time2").prop('checked', false);
    
});

$(".calenderdata").on("click", function(){
  check = $(this).prop("checked");
  $('.place_order_checkout').prop('disabled',true)

  $('.slot22').html('');
  $('.slot24').html('');
  $('.err-available1').html('');
  $("#customRadio38").prop('checked', false);

  $("#tomorrow_time1").prop('checked', false);
  $("#tomorrow_time2").prop('checked', false);
  $("#tomorrow_time3").prop('checked', false);
   
    
});


$("#today1").on("click", function(){
  check = $(this).prop("checked");
  $('.place_order_checkout').prop('disabled',true)

   $('.slot23').html('');
   $('.slot24').html('');
   $('.err-available').html('');
    $("#tomorrow_time4").prop('checked', false);
    $("#tomorrow_time5").prop('checked', false);
    $("#tomorrow_time6").prop('checked', false);

    $("#guestcalender_time4").prop('checked', false);
    $("#guestcalender_time5").prop('checked', false);
    $("#guestcalender_time6").prop('checked', false);
    
});


$("#today2").on("click", function(){
  check = $(this).prop("checked");
  $('.place_order_checkout').prop('disabled',true)

  $('.slot23').html('');
  $('.slot24').html('');
  $('.err-available').html('');
    $("#customRadio39").prop('checked', false);
  
    $("#guestcalender_time4").prop('checked', false);
    $("#guestcalender_time5").prop('checked', false);
    $("#guestcalender_time6").prop('checked', false);
    
});

$(".calender-for-guest").on("click", function(){
  check = $(this).prop("checked");
  $('.place_order_checkout').prop('disabled',true)

  $('.slot23').html('');
  $('.slot24').html('');
  $('.err-available').html('');
    $("#customRadio39").prop('checked', false);

    $("#tomorrow_time4").prop('checked', false);
    $("#tomorrow_time5").prop('checked', false);
    $("#tomorrow_time6").prop('checked', false);

    
});


/*add address map pin script ^*/
var check = $("#customRadio11").prop("checked");
if(check){
  $("#first").addClass("activeTab");
}

//click on yes
$(".today-tomaro").on("click", function(){
  check = $(this).prop("checked");
  $('.place_order_checkout').prop('disabled',false)

    $(".tomorrow-data").hide();
    $(".datepicker_tomorrow-data").hide();
    $(".today-data").show();
});
//click on No
$(".tomaro-today").on("click", function(){
  $('.place_your_order').prop('disabled',true)

  check = $(this).prop("checked");
    $(".today-data").hide();
    $(".datepicker_tomorrow-data").hide();
    $(".tomorrow-data").show();
  //console.log(check);
});

$(".calenderdata").on("click", function(){
  $('.place_your_order').prop('disabled',true)

  check = $(this).prop("checked");
    $(".today-data").hide();
    $(".tomorrow-data").hide();
    $(".datepicker_tomorrow-data").show();
  //console.log(check);
});

$(".date_select").on("click", function(){
  $('.place_your_order').prop('disabled',true)

  check = $(this).prop("checked");
              $(".today-data").hide();
              $(".tomorrow-data").show();
  
});


$(".select__date").select2({
  placeholder: "Select Date"
});

$(".listing_tabs .pic-blurrr").click(function() {
  $('html, body').animate({ 
    scrollTop: $('.wrapper').offset().top }, 1500);
});

$(".party_flow").click(function() {
  $('html, body').animate({ 
    scrollTop: $('.wrapper').offset().top }, 1500);
});

// //trigger the scroll
// $(window).scroll();
// $(document).ready(function() {
//   var topOfDivScroll = $(".stop-bar").offset().top - $(window).height();

//   $(window).scroll(function() {
//     if ($(window).scrollTop() > topOfDivScroll) {
//       $(".fixed_bar").addClass('stop_fixed');
//     } else {
//       console.log("failed")
//       $(".fixed_bar").removeClass('stop_fixed');}
//   });
// });

// $(window).scroll(function() {
//   if($(window).scrollTop() + $(window).height() == $(document).height() - 70) {
//     $(".fixed_bar").addClass('stop_fixed');
//   } else {
//     $(".fixed_bar").removeClass('stop_fixed');
//   }
// });
// var processing;

// $(document).ready(function(){

//     $(document).scroll(function(e){

//         if (processing)
//             return false;

//         if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.7){
//             processing = true;
//             $.post('/echo/html/', 'html=<div class="loadedcontent">new div</div>', function(data){
//                 $('#container').append(data);
//                 processing = false;
//             });
//         }
//     });
// });

// $(window).scroll(function() {
//   $(".fixed_bar").removeClass('stop_fixed');
//   if ($(window).scrollTop() >= ($(document).height() - $(window).height())*0.92){
//       //you are at bottom
//       $(".fixed_bar").addClass('stop_fixed');
//   } 
// });


$(".rate-us-image").click(function(){
  $('.details-order').modal('hide')
});



$(".close-modal").click(function(){
  $('.details-order').modal('show')
});



$( function() {
  $( "#datepicker" ).datepicker();
});


$(".selcect_delivery_time").select2({
  placeholder: "12 PM - 4 PM"
});
$(".selcect_delivery_time1").select2({
  placeholder: "4 PM - 8 PM"
});
$(".selcect_delivery_time2").select2({
  placeholder: "8 PM - 12 AM"
});
    
     /*limited select options */
     $(".selcect_delivery_time11").select2({
      placeholder: "12 PM - 4 PM"
    });

    $(".selcect_delivery_time12").select2({
      placeholder: "4 PM - 8 PM"
    });

    $(".selcect_delivery_time13").select2({
      placeholder: "8 PM - 12 AM"
    });

    $(".selcect_delivery_time14").select2({
      placeholder: "12 PM - 4 PM"
    });

    $(".selcect_delivery_time15").select2({
      placeholder: "4 PM - 8 PM"
    });

    $(".selcect_delivery_time16").select2({
      placeholder: "8 PM - 12 AM"
    });
     /* NEW JS */

$(".js-example-placeholder-single").select2({
  placeholder: "Corporate Id",
}).on('change', function() {
  $(this).valid();
});
$(".js-example-placeholder-single-add").select2({
  placeholder: "Official Address proof",
}).on('change', function() {
  $(this).valid();
});

$(".select_time").select2({
  placeholder: "Select Time"
}).on('change', function() {
  $(this).valid();
});
$(".select_date").select2({
  placeholder: "Select Date"
}).on('change', function() {
  $(this).valid();
});

var m=n=2;
var maxField  = 2; 
var addButton = $('.add_button'); 
var wrapper   = $('.field_wrapper'); 
var x = 0; 
var gift_count=1;
$(addButton).click(function(){
  $('.inputfieldcount').val(x+1);
  if(x < maxField){ 
    x++; 
    if(x<=2)
    var fieldHTML = '<div class="card_hidden"><div class="card mb-4"><div class="card-header" id="headingOne'+m+'"><h2 class="mb-0"><button class="btn btn-link btn-block text-left fw-500" type="button" data-toggle="collapse" data-target="#collapseOne'+m+'" aria-expanded="true" aria-controls="collapseOne'+m+'"><span id="labelHead'+n+'">'+n+'. Who are we delivering to?</span> <img src="'+base_url+'/assets/images/referarr.png" class="img-fluid float-right yellow-arr-img"></button><img src="'+base_url+'/assets/images/cross1.png" class="img-fluid float-right remove_button cross1-img"></h2></div><div id="collapseOne'+m+'" class="collapse show" aria-labelledby="headingOne'+m+'" data-parent="#addpeople_accordion"><div class="card-body"><div class="row"><div class="col-md-6"><div class="form-group "><label>Name*</label><input type="text" class="form-control txtOnly" id="friend_name'+m+'" placeholder="marshal matthe" autocomplete="off" name="friend_name'+m+'" ></div></div><div class="col-md-6"><div class="form-group position-relative number_valid country-code-gift"><label>Mobile*</label><input type="number" class="form-control log-inn restrict_alphabits" id="friend_number'+m+'" placeholder="8959494988" name="friend_number'+m+'" > <p>+91</p> </div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label>Email*</label><input type="email" class="form-control " id="friend_email'+m+'" placeholder="marshal@gmail.com" autocomplete="off" name="friend_email'+m+'" ></div></div></div></div></div></div></div>';    m++;n++;
    gift_count++;
    //alert(gift_count)
      $(wrapper).append(fieldHTML); 
      $("input").on("keypress", function(e) {
        if (e.which === 32 && !this.value.length)
        e.preventDefault();
      });
      //$('#addfrnd').validate(); 
    if(x==2){
      $('.add_button').hide();
    }
  }
});

$(wrapper).on('click', '.remove_button', function(e){
  $('.inputfieldcount').val(x-1);
  e.preventDefault();
  $(this).closest('.card_hidden').find('.card').remove(); 
  x--; 
  gift_count--;
  n--;
  // alert(m+''+n)
  // alert(gift_count)
  var  k=1;
    $(".field_wrapper span").each(function (e) {
      if(k==1){
      var l=k;
      }else if(k==2){
        l=k;
        }else{
        var l=k-1;
      }
      $(this).html((l)+". Who are we delivering to?");
      k++;
      });  
    //}

  //$("#labelHead"+m).html(n+". Who are we delivering to?");
  if(x<2)
    $('.add_button').show();
});


// $(".onclick_accordian").click(function(){
//   if($('.name_accordian').hasClass('has-success') && $('.num_accordian').hasClass('has-success') && $('.email_accordian').hasClass('has-success')){
//    $('#requested').modal('show');
//    $("#ddpeople").modal("hide");
//   }
//  });



$(".onclick_accordian").click(function(){
  var form = $("#addfrnd");
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
        friend_name1: {
            required: true,
        },
        sub: {
          required: true,
      },
   
        friend_number1: {
            required:true,
            minlength:10,
            maxlength:10,
            digits:true
        },  
        friend_email1: {
            required: true,
            //noSpace: true,
            email: true
        }, 
        
        friend_name2: {
            required: true,
        },
        friend_number2: {
            required:true,
            minlength:10,
            maxlength:10,
            digits:true
        },  
        friend_email2: {
            required: true,
           // noSpace: true,
            email: true
        }, 

        friend_name3: {
            required: true,
        },
        
        friend_number3: {
            required:true,
            minlength:10,
            maxlength:10,
            digits:true
        },  
        friend_email3: {
            required: true,
          //  noSpace: true,
            email: true
        }, 

    },
    messages: {
        friend_name1 : {
            required: "Please enter name",
        },
   
        sub: {
          required: "Please enter email",
      },
        friend_number1 : {
            required: "Please enter mobile number",
            minlength: "Enter 10 digit number",
            maxlength: "Enter 10 digit number",
            digits: "Only numbers are allowed in this field"
        },
        friend_email1:{
            required: "Please enter email ID",
            email: "Please enter valid email ID",
        },

        friend_name2 : {
            required: "Please enter name",
        },
        friend_number2 : {
            required: "Please enter mobile number",
            minlength: "Enter 10 digit number",
            maxlength: "Enter 10 digit number",
            digits: "Only numbers are allowed in this field"
        },
        friend_email2:{
            required: "Email is required",
            email: "Enter valid email",
        },

        friend_name3 : {
            required: "Please enter name",
        },
        friend_number3 : {
            required: "Please enter mobile number",
            minlength: "Enter 10 digit number",
            maxlength: "Enter 10 digit number",
            digits: "Only numbers are allowed in this field"
        },
        friend_email3:{
            required: "Email is required",
            email: "Enter valid email",
        }
    }
  });
});



$(".onclick_accordian_footer").click(function(){
  var form = $("#addfrnd_footer");
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
       
        sub: {
          required: true,
      },
        

    },
    messages: {
        sub: {
          required: "Please enter email",
      }
      
    }
  });
});



// document.querySelector("html").classList.add('js');
// var fileInput  = document.querySelector( ".input-file" ),  
//     button     = document.querySelector( ".input-file-trigger" ),
//     the_return = document.querySelector(".file-return");
      
// button.addEventListener( "keydown", function( event ) {  
//     if ( event.keyCode == 13 || event.keyCode == 32 ) {  
//         fileInput.focus();  
//     }  
// });
// button.addEventListener( "click", function( event ) {
//    fileInput.focus();
//    return false;
// });  
// fileInput.addEventListener( "change", function( event ) {  
//     the_return.innerHTML = this.value;  
// });  




$(".sent__request").click(function(){
  var form = $("#myform");
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
        describe: {
          required: true,
      },
        number: {
            required:true,
            minlength:10,
            maxlength:10,
            digits:true
        },  
        email: {
            required: true,
           // noSpace: true,
            email: true
        }

    },
    messages: {
        name : {
            required: "Please enter name",
        },
        describe: {
          required: "Please enter ",
      },
        number : {
            required: "Please enter mobile number",
            minlength: "Enter 10 digit number",
            maxlength: "Enter 10 digit number",
            digits: "Only numbers are allowed in this field"
        },
        email:{
            required: "Please enter email ID",
            email: "Please enter valid email ID",
        }

    
    }
  });
});


/* Proceed popup datepicker */
$('#customRadio22').click(function () {
  $('.selectdate').datepicker({
      
  });
  $('.selectdate').focus();
});

$('.selectdate').change(function(){
  $(".days-month").last().text();
});
$('.selectdate').click(function () {
  $('#customRadio22').prop('checked', true);
});
$(".selectdate").datepicker({
  minDate: 0,
  dateFormat: 'dd-mm-yy',
  autoclose: true
});
/* Proceed popup datepicker */

/* Proceed popup datepicker */
$('#today3').click(function () {
  $('.selectdate1').datepicker({
      
  });
  $('.selectdate1').focus();
});

$('.selectdate1').change(function(){
  $(".days-month").last().text();
});

$('.selectdate1').click(function () {
  $('#today3').prop('checked', true);
});

$(".selectdate1").datepicker({
  minDate: 0,
  dateFormat: 'dd-mm-yy',
  autoclose: true
});
/* Proceed popup datepicker */

/* Reset dropdown values for Guest SignIn */
$("#tomorrow_time4").change(function(){
  if ($(this).is(':checked')){
    $(".time-need10").select2('val', 'All');
    $(".time-need9").select2('val', 'All');
  }
});

$("#tomorrow_time5").change(function(){
  if ($(this).is(':checked')){
    $(".time-need10").select2('val', 'All');
    $(".time-need8").select2('val', 'All');
  }
});

$("#tomorrow_time6").change(function(){
  if ($(this).is(':checked')){ 
    $(".time-need8").select2('val', 'All');
    $(".time-need9").select2('val', 'All');
  }
});

$(".selectdate1").click(function(){
  // if ($(this).is(':checked')){ 
    $(".time-need8").select2('val', 'All');
    $(".time-need9").select2('val', 'All');
    $(".time-need10").select2('val', 'All');
    $("#selct-time7").select2('val', 'All');
  //}
});

$("#today2").click(function(){
  if ($(this).is(':checked')){ 
    $(".time-need11").select2('val', 'All');
    $(".time-need41").select2('val', 'All');
    $(".time-need12").select2('val', 'All');
    $("#selct-time7").select2('val', 'All');
    $('.selectdate1').datepicker('setDate', null);
  }
});

$("#today1").click(function(){
  if ($(this).is(':checked')){ 
    $(".time-need11").select2('val', 'All');
    $(".time-need41").select2('val', 'All');
    $(".time-need12").select2('val', 'All');

    $(".time-need8").select2('val', 'All');
    $(".time-need9").select2('val', 'All');
    $(".time-need10").select2('val', 'All');

    $('.selectdate1').datepicker('setDate', null);
  }
});

$("#guestcalender_time4").change(function(){
  if ($(this).is(':checked')){ 
    $(".time-need41").select2('val', 'All');
    $(".time-need12").select2('val', 'All');
  }
});
$("#guestcalender_time5").change(function(){
  if ($(this).is(':checked')){ 
    $(".time-need11").select2('val', 'All');
    $(".time-need12").select2('val', 'All');
  }
});
$("#guestcalender_time6").change(function(){
  if ($(this).is(':checked')){ 
    $(".time-need41").select2('val', 'All');
    $(".time-need11").select2('val', 'All');
  }
});

/* Proceed popup datepicker */


$("#tomorrow_time1").change(function(){
  if ($(this).is(':checked')){
    $(".time-need2").select2('val', 'All');
    $(".time-need3").select2('val', 'All');
  }
});

$("#tomorrow_time2").change(function(){
  if ($(this).is(':checked')){
    $(".time-need1").select2('val', 'All');
    $(".time-need3").select2('val', 'All');
  }
});

$("#tomorrow_time3").change(function(){
  if ($(this).is(':checked')){
    $(".time-need2").select2('val', 'All');
    $(".time-need1").select2('val', 'All');
  }
});

$("#calender_time").change(function(){
  if ($(this).is(':checked')){
    $(".time-need6").select2('val', 'All');
    $(".time-need7").select2('val', 'All');
  }
});

$("#calender_time1").change(function(){
  if ($(this).is(':checked')){
    $(".time-need4").select2('val', 'All');
    $(".time-need7").select2('val', 'All');
  }
});

$("#calender_time2").change(function(){
  if ($(this).is(':checked')){
    $(".time-need4").select2('val', 'All');
    $(".time-need6").select2('val', 'All');
  }
});

$(".selectdate").click(function(){
  // if ($(this).is(':checked')){ 
    $(".time-need1").select2('val', 'All');
    $(".time-need2").select2('val', 'All');
    $(".time-need3").select2('val', 'All');
    $(".selct-time").select2('val', 'All');
  //}
});

$("#customRadio21").click(function(){
  if ($(this).is(':checked')){ 
    $(".time-need4").select2('val', 'All');
    $(".time-need6").select2('val', 'All');
    $(".time-need7").select2('val', 'All');
    $(".selct-time").select2('val', 'All');
    $('.selectdate').datepicker('setDate', null);
  }
});

$("#customRadio11").click(function(){
  if ($(this).is(':checked')){ 
    $(".time-need1").select2('val', 'All');
    $(".time-need2").select2('val', 'All');
    $(".time-need3").select2('val', 'All');

    $(".time-need4").select2('val', 'All');
    $(".time-need6").select2('val', 'All');
    $(".time-need7").select2('val', 'All');

    $('.selectdate').datepicker('setDate', null);
  }
});




/* party-time-pizza Proceed popup datepicker */
$('#today5').click(function () {
  $('.selectdate5').datepicker({
  });
  $('.selectdate5').focus();
});

$('.selectdate5').change(function(){
  $(".days-month").last().text();
});
$('.selectdate5').click(function () {
  $('#today5').prop('checked', true);
});
$(".selectdate5").datepicker({
  minDate: 0,
  dateFormat: 'dd-mm-yy'
});
/*party-time-pizza Proceed popup datepicker */
/* Proceed popup datepicker */
$('#party1').click(function () {
  $('.selectdate3').datepicker({
      
  });
  $('.selectdate3').focus();
});

$('.selectdate3').change(function(){
  $(".days-month").last().text();
});
$('.selectdate3').click(function () {
  $('#party1').prop('checked', true);
  $('#today_tomorrow-error').hide();
  $('#collapse02 .form-group').removeClass('has-error');  
  
});
$(".selectdate3").datepicker({
  minDate: 0,
  dateFormat: 'dd-mm-yy'
});
/* Proceed popup datepicker */

// var input = document.getElementById( 'my-file' );
// var infoArea = document.getElementById( 'file-upload-filename' );
// input.addEventListener( 'change', showFileName );
// function showFileName( event ) {
//   var input = event.srcElement;
//   var fileName = input.files[0].name;
//   infoArea.textContent = '' + fileName;
// }

// var input = document.getElementById( 'my-file1' );
// var infoArea = document.getElementById( 'file-upload-filename1' );
// input.addEventListener( 'change', showFileName );
// function showFileName( event ) {
//   var input = event.srcElement;
//   var fileName = input.files[0].name;
//   infoArea.textContent = '' + fileName;
// }



/* Arrjun Reddy 24/12/2021 */

function myFunction() {
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(copyText.value);
  
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copied";
}

function outFunc() {
  var tooltip = document.getElementById("myTooltip");
  tooltip.innerHTML = "Copy url";
}


$('.form_validation').bootstrapValidator({
  message: 'This value is not valid',
  fields: {
    describe: {
      message: 'The username is not valid',
      validators: {
        notEmpty: {
          message: 'Please enter description'
        }
      }
    },
  }
});
let rating_no='';
$("input[name=rateRadio]").change(function(){          
  if ($(this).val() == "sad") {
    rating_no=$(this).attr('data-value');
    $('.emojis_val').val(rating_no);
    $(".sad_emoji").fadeIn()
  } else {
    $(".sad_emoji").fadeOut();
  }  
  //emojisfunction(rating_no);                                                        

});

$("input[name=rateRadio]").change(function(){          
  if ($(this).val() == "satisfy") {
    rating_no=$(this).attr('data-value');
    $('.emojis_val').val(rating_no);

    $(".satisfy_emoji").fadeIn()
  } else {
    $(".satisfy_emoji").fadeOut();
  } 
//  emojisfunction(rating_no);                                                                                                                   
});
  // $(this).attr('data-value');
  $(".happy_emoji").fadeIn()

$("input[name=rateRadio]").change(function(){          
  if ($(this).val() == "happy") {
    rating_no=$(this).attr('data-value');
    $('.emojis_val').val(rating_no);

    $(".happy_emoji").fadeIn()
  } else {
    $(".happy_emoji").fadeOut();
  } 
});

/* Arrjun Reddy 24/12/2021 */


/*otp*/
$('#otpmodal').on("shown.bs.modal", function() {
  $("#number11").focus();
});

// $(document).ready(function () {
//   $("#number11").focus();
// });

// $("#number11").focus();
/*otp*/


$(".resetdate").change(function() {
  if ($(this).is(':checked')){
    $('.selectdate').datepicker('setDate', null);
  }
});


$(".time_slot_msg_overlay").click(function(){
  $('#time_slot_msg').modal('hide')
});


//   

// $(".select_from_time .select2-container").click(function(){
//   $('.select_from_time #from_time-error').hide();
//   //$('.select_from_time.form-group ').removeClass('has-error');
// });

// $(".select_to_time .select2-container").click(function(){
//   $('.select_to_time #to_time-error').hide();
//   //$('.select_to_time.form-group ').removeClass('has-error');
// });


gsap.registerPlugin(ScrollTrigger);

gsap.to(".truck_footer", {
  scrollTrigger: {
    yoyo: true,
    trigger: ".move",
    start: "100% 100%",
    //end: "bottom bottom",
    //markers: true,
    //toggleActions: "restart none none reverse"
  },
  x:'897',
  xPercent: 1.5,
  duration: 2
});

// var _window = window,Splitting = _window.Splitting,ScrollOut = _window.ScrollOut;
// Splitting();
// ScrollOut({
//   targets: '.word',
//   scrollingElement: '.page' });

// gsap.to(".trigger-overflow", {
//   scrollTrigger: {
//     trigger: ".move",
//     start: "100% 100%",
//     //end: "bottom bottom",
//     //markers: true,
//     toggleActions: "restart none none reverse"
//   },
//   x:'740',
//   ease: "power5.out",
//   xPercent: 1.5,
//   duration: 2
// });

gsap.from('.text-block', {
  x: -520,
 
  duration: 2,
  ease: "power5.out",
  scrollTrigger: {
    trigger: ".move",
    start: "100% 100%",
    //markers: true,
    //toggleActions: "restart none none reverse"
  }
});



// $("input[name='payment_radio']").click(function() {
//   if($(this).is(":checked")){
//          alert()
//   }
//   });
$('form').on('focus', 'input[type=number]', function (e) {
  $(this).on('wheel.disableScroll', function (e) {
    e.preventDefault()
  })
})
$('form').on('blur', 'input[type=number]', function (e) {
  $(this).off('wheel.disableScroll')
})