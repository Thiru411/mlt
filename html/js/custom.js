 /*************Header shrink *****************/ 
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


$(function(){
  var shrinkHeader = 100;
    $(window).scroll(function() {
     var scroll = getCurrentScroll();
        if ( scroll >= shrinkHeader ) 
            {
             $('header').addClass('shrink');
            }
        else
           {
             $('header').removeClass('shrink');
           }
   });
       function getCurrentScroll() {
           return window.pageYOffset || document.documentElement.scrollTop;
           }
});

//  /^([\w-.]+@(?!gmail\.com)(?!yahoo\.com)(?!hotmail\.com)(?!mail\.ru)(?!yandex\.ru)(?!mail\.com)([\w-]+.)+[\w-]{2,4})?$/

$('.formvalidation').bootstrapValidator({
  fields: {
    email: {
      validators: {
          notEmpty: {
              //message: 'Please enter your email ID'
          },
          regexp: {
            regexp: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,
            message: 'Please enter a vaild email IDddddd'
          }
      }
    },
    mobile: {
      validators: {
          notEmpty: {
            required: true,
              message: 'Please enter phone number'
          },
          stringLength: {
            max: 10,
            message: 'Phone number must be atleast 10 digits'
          }
      }
    },  
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

// $('.formvalidationsign').bootstrapValidator({}

//   ).on('success.form.bv', function(e) {
  
//           e.preventDefault();
//           var $form = $(e.target);
//           fv = $form.data('formValidation');
//           if ($form.attr('action') != undefined) {
//               $form.unbind('submit');
//               $form.submit();
//           }
//       }
  
//   );

/* Restrict Text */
$('.restrict_alphabits').keydown(function (e) {
  var key = e.charCode || e.keyCode || 0;
  $text = $(this); 
  if (key !== 8 && key !== 9) {
     //  if ($text.val().length === 3) {
     //      $text.val($text.val() + '-');
     //  }
     //  if ($text.val().length === 7) {
     //      $text.val($text.val() + '-');
     //  }
  }
  return (key == 8 || key == 9 || key == 46 || key == 37 || key == 39 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));
})


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

// $(".address_info").click(function () {
//     $('.location-card').show(); 
// });
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



$(".proceed").click(function () {
  if ($(".number_valid.form-group").hasClass("has-success")) {
    $('#otpmodal').modal('show'); 
    $('#loginmodal').modal('hide'); 
  }
});

$(".SignUp").click(function () {
  if ($(".name_field.form-group").hasClass("has-success") && $(".email_field.form-group").hasClass("has-success") && $(".num_field.form-group").hasClass("has-success")) {
    $('#otpmodal').modal('show'); 
    $('#signupmodal').modal('hide'); 
    
  }
});

$(".opensignupmodal").click(function () {
  $('#signupmodal').modal('show');
  $('#loginmodal').modal('hide');
});

$(".openloginmodal").click(function () {
  $('#signupmodal').modal('hide');
  $('#loginmodal').modal('show');
});

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
    placeholder: "Select a state"
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
 

/*increment and decrement*/
$('.add').click(function () {
  if ($(this).prev().val() < 1000) {
      $(this).prev().val(+$(this).prev().val() + 1);
  }
});
$('.sub').click(function () {
  if ($(this).next().val() > 1) {
      if ($(this).next().val() > 1) $(this).next().val(+$(this).next().val() - 1);
  }
});
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

/*add address map pin script ^*/
var check = $("#customRadio11").prop("checked");
if(check){
  $("#first").addClass("activeTab");
}

//click on yes
$(".today-tomaro").on("click", function(){
  check = $(this).prop("checked");
              $(".today-data").show();
              $(".tomorrow-data").hide();
  // $("#second").removeClass("activeTab");
  // $("#first").addClass("activeTab");
  
});
//click on No
$(".tomaro-today").on("click", function(){
  check = $(this).prop("checked");
              $(".today-data").hide();
              $(".tomorrow-data").show();
  // $("#first").removeClass("activeTab");
  // $("#second").addClass("activeTab");
  console.log(check);
});


    
$(".listing_tabs .pic-blurrr").click(function() {
  $('html, body').animate({ 
    scrollTop: $('.wrapper').offset().top }, 1500);
});



//trigger the scroll

// $(window).scroll();
// $(document).ready(function() {
//   var topOfDivScroll = $(".stop-bar").offset().top - $(window).height();

//   $(window).scroll(function() {
//     if ($(window).scrollTop() > topOfDivScroll) {
//       $(".fixed_bar").addClass('stop_fixed');
//     } else $(".fixed_bar").removeClass('stop_fixed');
//   });
// });

    /*limited select options */

    $('.veg-select').click(function() { 
        var limitReached = $('.veg-select:checked').length >= 3;   
        $('.veg-select').not(':checked').attr('disabled', limitReached);
      }
    );
  
    $('.non-veg--select')
    .click(
      function() {
        var limitReached = $('.non-veg--select:checked').length >= 2;   
        $('.non-veg--select').not(':checked').attr('disabled', limitReached);
      }
    );
  
    $('.booster-select')
    .click(
      function() {
        var limitReached = $('.booster-select:checked').length >= 2;   
        $('.booster-select').not(':checked').attr('disabled', limitReached);
      }
    );

     /*limited select options */
  
  
 /* NEW JS */

$(".js-example-placeholder-single").select2({
  placeholder: "Personal Id",
  allowClear: true
});
$(".js-example-placeholder-single-add").select2({
  placeholder: "Official Address proof",
  allowClear: true
});

$(".select_time").select2({
  placeholder: "Select Time"
});

$(".select_date").select2({
  placeholder: "Select Date"
});

// $(".select_time").select2({
//   placeholder: "Select Time"
// });

 



let s=2;
var maxField  = 2; 
var addButton = $('.add_button'); 
var wrapper   = $('.field_wrapper'); 
var x = 0; 

$(addButton).click(function(){
  if(x < maxField){ 
    x++; 
    if(x<=2)
    var fieldHTML = '<div class="card_hidden"><div class="card mb-4"><div class="card-header" id="headingOne'+s+'"><h2 class="mb-0"><button class="btn btn-link btn-block text-left fw-500" type="button" data-toggle="collapse" data-target="#collapseOne'+s+'" aria-expanded="false" aria-controls="collapseOne'+s+'">'+s+'. Who are we delivering to? <img src="../html/images/referarr.png" class="img-fluid float-right yellow-arr-img"></button><img src="../html/images/cross1.png" class="img-fluid float-right remove_button cross1-img"></h2></div><div id="collapseOne'+s+'" class="collapse" aria-labelledby="headingOne'+s+'" data-parent="#addpeople_accordion"><div class="card-body"><div class="row"><div class="col-md-6"><div class="form-group"><label>Name*</label><input type="text" class="form-control" id="friend_name'+s+'" placeholder="marshal matthe" name="friend_name'+s+'" ></div></div><div class="col-md-6"><div class="form-group"><label>Mobile*</label><input type="number" class="form-control" id="friend_number'+s+'" placeholder="+91 8959494988" name="friend_number'+s+'"></div></div></div><div class="row"><div class="col-md-6"><div class="form-group"><label>Email*</label><input type="email" class="form-control " id="friend_email'+s+'" placeholder="marshal@gmail.com" name="friend_email'+s+'" ></div></div></div></div></div></div></div>';
    s++;
      $(wrapper).append(fieldHTML); 
      $('#addfrnd').validate(); 
      // $(wrapper).append('<script>$(".formvalidation").bootstrapValidator({fields: {email: {validators: {notEmpty: {},regexp: {regexp: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/,message: "Please enter a vaild email IDddddd"}}},mobile: {validators: {notEmpty: {required: true,message: "Please enter phone number"},stringLength: {max: 10,message: "Phone number must be atleast 10 digits"}}},  }}).on("success.form.bv", function (e) {e.preventDefault();var $form = $(e.target);fv = $form.data("formValidation");if ($form.attr("action") != undefined) {$form.unbind("submit");$form.submit();}});</script><script src="js/bootstrapValidator.min.js"></script>')
    if(x==2)
      $('.add_button').hide();
  }
 
});

$(wrapper).on('click', '.remove_button', function(e){
  e.preventDefault();
  $(this).closest('.card_hidden').find('.card').remove(); 
  x--; 
  if(x<2)
    $('.add_button').show();
});



document.querySelector("html").classList.add('js');
var fileInput  = document.querySelector( ".input-file" ),  
    button     = document.querySelector( ".input-file-trigger" ),
    the_return = document.querySelector(".file-return");
      
button.addEventListener( "keydown", function( event ) {  
    if ( event.keyCode == 13 || event.keyCode == 32 ) {  
        fileInput.focus();  
    }  
});
button.addEventListener( "click", function( event ) {
   fileInput.focus();
   return false;
});  
fileInput.addEventListener( "change", function( event ) {  
    the_return.innerHTML = this.value;  
}); 