<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
  <script src="<?=$admin_url?>assets/js/jquery-3.6.0.min.js"></script>
  <script src="<?=$admin_url?>assets/js/bootstrap.bundle.min.js"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.7/jquery.lazyload.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazyload/1.9.1/jquery.lazyload.min.js"></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.6.6/lottie.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.4/gsap.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.4/ScrollTrigger.min.js'></script>
  <script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/ScrollLottie.js'></script>
  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js" ></script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script>
  <script src="<?=$admin_url?>assets/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
  
  <script src="<?=$admin_url?>assets/js/custom.js"></script>


  <script>let base_url="<?=base_url()?>";</script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1Z3e-xBgzeKw10ou7QQ6NaNfcI3UZ4KM&libraries=places"></script>

<script async>


  ScrollLottie({
    target: '#pizza',
    path: 'assets/gif/pizza.json',
    duration: 10,
    speed: 'slow' 
  });
  ScrollLottie({
    target: '#pizza_mobile',
    path: 'assets/gif/pizza_mobile.json',
    duration: 10,
    speed: 'slow' 
  });
    
  ScrollLottie({
    target: '#cooking',
    path: 'assets/gif/cooking-new.json',
    duration: 10,
    speed: 'slow' 
  });
  ScrollLottie({
    target: '#cooking_mobile',
    path: 'assets/gif/cooking_mobile.json',
    duration: 10,
    speed: 'slow' 
  });

  // ScrollLottie({
  //   target: '#footer_gif',
  //   path: 'assets/gif/footer.json', 
  //   duration: 4, 
  //   speed: 'slow'
  // })
    
  $(function() {
    $(".lazy").lazyload({
      effect : "fadeIn"
    });
  });

$("#sigin-proceed").click(function () {
  if ($(".number_valid.form-group").hasClass("has-success")) {
    timerOn=false;

    var mobile=$('#mobile').val();
    if(mobile!="0000000000"){
      $.ajax({  
        url:"<?php echo $admin_url?>website/signin",  
        data: {mobile:mobile},  
        type: "POST",  
        success:function(data){ 
          var resp = $.parseJSON(data);
          if(resp.otp!=false){
            $(".error").html(''); 

  $('.wrong-otp').text('');
  $('#resend-otp').text('');
  $('#timer').html('');

            $('#otpmodal').modal('show'); 
             $('#loginmodal').modal('hide');
             $(".otpnumber").html(mobile);
            
            document.getElementById("typemodel").value = 'signin';
          }else{
            $('#loginmodal').modal('show');
           $(".error").html('Please Signup First'); 
           $('#mobile').val(''); 
          }
        }
       }); 
      }else{
        $('#loginmodal').modal('show');
           $(".error").html('Please Enter Valid Number');  
      } 
  }
});

$('#mobile').keypress(function (e) {
    validationForSpecialchar(e); 		        
});

function validationForSpecialchar(e){
    var regex = new RegExp("^[a-zA-Z0-9-]+$"); 
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
}

$('#mobile1').keypress(function (e) {
    validationForSpecialchar(e); 		        
});

function validationForSpecialchar(e){
    var regex = new RegExp("^[a-zA-Z0-9-]+$"); 
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    e.preventDefault();
    return false;
}
/* Restrict Special Charecter */
$('#name').bind('input', function() {
  var c = this.selectionStart,
      r = /[^a-z0-9 .]/gi,
      v = $(this).val();
  if(r.test(v)) {
    $(this).val(v.replace(r, ''));
    c--;
  }
  this.setSelectionRange(c, c);
});
    
$(".SignUp").click(function () {
  $('.wrong-otp').text('');
  $('#resend-otp').text('');
  $('#timer').html('');
  if ($(".name_field.form-group").hasClass("has-success") && $(".email_field.form-group").hasClass("has-success") && $(".num_field.form-group").hasClass("has-success")) {
    timerOn=false;
    var mobile2=$('.otpnumber').text();
    let s2 = mobile2.split(' ');
      let mobile1=s2[1];
    var mobile=$('#mobile1').val();
      var email=$('#email').val();
      var name=$('#name').val();
      if(mobile!="0000000000"){
      $.ajax({  
        url:"<?php echo  $admin_url?>website/signup",  
        data: {mobile1:mobile1,mobile:mobile,email:email,name:name},  
        type: "POST",  
        success:function(data){   
          var resp = $.parseJSON(data); 
          if(resp.otp!=false){
            $('#otpmodal').modal('show'); 
             $('#signupmodal').modal('hide');
             $(".otpnumber").html(mobile);
             $(".error").html(''); 
              $('.wrong-otp').text('');
              $('#timer').text('');
             document.getElementById("typemodel").value = 'signup';
          }else{
            $('#signupmodal').modal('show'); 
           $(".error").html('User already Existed'); 
           $('#mobile1').val('');
      $('#email').val('');
      $('#name').val(''); 
          }
 
        }  
       });
      }else{
        $('#signupmodal').modal('show'); 
           $(".error").html('Please Enter Valid Number');  
      }
    
  }
});


$('#proceed-otp').click(function () { 

var mobile=$('.otpnumber').html();



var number1=$('#number11').val();

var number2=$('#number21').val();

var number3=$('#number31').val();

var number4=$('#number41').val();

var otp=number1+number2+number3+number4;

$.ajax({  

  url:"<?php echo $admin_url?>website/otp_verification",  

  data: {mobile:mobile,otp:otp},  

  type: "POST",  

  success:function(data){
    var resp = $.parseJSON(data);

  if(resp.output!="false"){

  $("#otpmodal").modal("hide");
var redirct=$('#redirect').val();
  //  window.location.reload();
  if(redirct=='order-confirmed' || redirct=='order-track'){
   window.location.href ="<?php echo base_url('/')?>";

  }else{
    window.location.reload();

  }
  }
  else{

     $(".wrong-otp").html('Please enter correct otp');

     $("#otpmodal").modal("show");

  }

  }  

 });  

});
    $('#logout').click(function () {
      $.ajax({  
        url:"<?php echo $admin_url?>logout",  
        data: {},  
        type: "POST",  
        success:function(data){  
          window.location.reload();
        }  
       });   
    });

    
    $('.resend--otp').click(function () 
    {
      $('.wrong-otp').text('');
  $('#resend-otp').text('');
  $('#timer').html('');
      var mobile=$('.otpnumber').text();
      $.ajax({  
        url:"<?php echo $admin_url?>website/resendotp",  
        data: {mobile:mobile},  
        type: "POST",  
        success:function(data){
          console.log(data);
          $('#number11').val('');
      $('#number21').val('');
     $('#number31').val('');
     $('#number41').val('');

     document.getElementById('resend-otp').style.display='block';
     document.getElementById('timer').style.display='block';

          document.getElementById('resend-otp').innerHTML ='OTP has been sent again!';
          document.getElementById('resend--otp').style.display='none';

          timerOn = true;
        
        timer(135);
        
          

      
                }  
              }); 
            });   
            let timerOn;
            function timer(remaining) {
          var m = Math.floor(remaining / 60);
          var s = remaining % 60;
          
          m = m < 10 ? '0' + m : m;
          s = s < 10 ? '0' + s : s;
          document.getElementById('timer').innerHTML ='Resend OTP <span class="otp-color">in '+ m + ':' + s+'</span>';
          remaining -= 1;
          
          if(remaining >= 0 && timerOn) {
            setTimeout(function() {
                timer(remaining);
            }, 1000);
          }else{
          document.getElementById('resend-otp').style.display='none';
          document.getElementById('timer').style.display='none';
          document.getElementById('resend--otp').style.display='block';
        }

          if(!timerOn) {
            // Do validate stuff here
          }
          
          // Do timeout stuff here
         // alert('Timeout for otp');
        }

  $("#edit").click(function () {
    timerOn=false;
      var typemodel=$('#typemodel').val();
  var mobile1=$('.otpnumber').text();
  let s2 = mobile1.split(' ');
       mobile1=s2[1];
  if(typemodel=='signup'){  
    $(".error").html(''); 
    $("#signup").prop('disabled', false);

   $('#number11').val('');
     $('#number21').val('');
   $('#number31').val('');
  $('#number41').val('');
  $(".error").html(''); 
  clearTimeout(timer());

  $('.wrong-otp').text('');
    $('#otpmodal').modal('hide'); 
    $('#signupmodal').modal('show'); 
  }
  else{
    $("#sigin-proceed").prop('disabled', false);

  $('#number11').val('');
$('#number21').val('');
      $('#number31').val('');
      $('#number41').val('');
      $(".error").html(''); 
  $('.wrong-otp').text('');
    $('#otpmodal').modal('hide'); 
    $('#loginmodal').modal('show'); 
    clearTimeout(timer());

  }
});

  </script>
  <style>
#map1{width: 100%;height: 149px;border-radius: 16px;}
        @media only screen and (max-width: 426px) {  
            /* .modal-backdrop.show {opacity: 1;background: transparent;display: none;}   */
            .close{display: none;}
            #ui-id-2 .ui-menu-item-wrapper p {  font-size: 12px;  line-height: 18px;}
            #ui-id-2 { width: 100% !important;  padding: 4px 23px 0 0;}
            #ui-id-2 .ui-menu-item-wrapper span {    font-size: 12px;    line-height: 18px;}
        }

        /* Rajesh */
        .pac-container {background-color: #FFF;z-index: 20000;position: fixed;display: inline-block;float: left;}
        .gm-style-iw-t{display:none;}
</style>
<script>
        var IsplaceChange = false;
        let city='';
        function initialize() { 
          var input = document.getElementById('project13');
		  var options = {
        types: ['establishment', 'geocode'],
			  componentRestrictions: {country: "IN"}
			 };
          var autocomplete = new google.maps.places.Autocomplete(input);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
             var place = autocomplete.getPlace();
                 IsplaceChange = true;
                 document.getElementById('city').value = place.name;
                 document.getElementById('latitude').value = place.geometry.location.lat();
                 document.getElementById('longitude').value = place.geometry.location.lng();
               
                 
                 var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                 geocoder = new google.maps.Geocoder();
                 geocoder.geocode({'latLng': latlng}, function(results, status) {
                  let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:place.geometry.location.lat(),lon:place.geometry.location.lng()},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){

                            $('#anotherlocationModal').modal('show')


                        }else{

                        
                        
                    
      
                     if (status == google.maps.GeocoderStatus.OK) {
                         if (results[0]) {
                             for (j = 0; j < results[0].address_components.length; j++) {
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                  if (results[0].address_components[j].types[0] == 'political'){
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                    city=results[0].address_components[j].long_name
                            }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                 }
                             }
                             set_address();
                       }
                         } else {
                         alert("Geocoder failed due to: " + status);
                     }
                        }
                        $('#location-card').fadeOut()

                    }
                     });
             });
             });
             
             $("#area-search").keydown(function () {
                IsplaceChange = false;
             });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <script>

function set_address() {
  var city=$('#city').val(); 
$.ajax({  
        url:"<?php echo $admin_url?>website/set_address",  
        data: {city:city},  
        type: "POST",  
        success:function(response){ 
          var resp = $.parseJSON(response);
          $('#fill-add').text(resp.city);
          $('#location-card').fadeOut()
        }
      });
}


function viewAddress(sk_address_id) {
  var full_address1=$('#full-add'+sk_address_id) .text(); 
  var split_address=full_address1.split(',');
 // alert(split_address[2])
  var split_state=split_address[2]
  var split_country=split_address[3]
var full_address=$('#savedAddress'+sk_address_id) .val(); 
$.ajax({  
        url:"<?php echo $admin_url?>website/addheadaddress",  
        data: {full_address:full_address, state:split_state, country:split_country},  
        type: "POST",  
        success:function(data){ 
          var resp = $.parseJSON(data);
          $('#fill-add').text(resp.complteaddress);
          $('#location-card').fadeOut()
        }
      });
}
        </script>
   
  
<script type="text/javascript">
var map;


function getLocation(){
	if ("geolocation" in navigator){
		navigator.geolocation.getCurrentPosition(function(position){ 
			var currentLatitude = position.coords.latitude;
			var currentLongitude = position.coords.longitude;//alert(currentLatitude+"   "+currentLongitude);
      var myLatlng = new google.maps.LatLng(currentLatitude,currentLongitude);
      let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:currentLatitude,lon:currentLongitude},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                         
                            $('#anotherlocationModal').modal('show')
                            

                        }else{

                        
                        
                    
                
                    
      $('#currentLatitude').val(currentLatitude);
      $('#currentLongitude').val(currentLongitude);

      geocoder = new google.maps.Geocoder();

                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                  var pincode='';
var town='';
var city='';  
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                              
                                $('#project13').val(results[0].formatted_address);
                                for (j = 0; j < results[0].address_components.length; j++) {
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 pincode= results[0].address_components[j].short_name;
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
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                   town=results[0].address_components[j].long_name;
                            }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                  city= results[0].address_components[j].long_name;
                                 }
                               
                                 }
                                 $.ajax({  
                                url:"<?php echo $admin_url?>website/set_address",  
                                data: {city:city,
                                  pincode:pincode,
                                town:town,
                                latitude:currentLatitude,
                                longitude:currentLongitude},  
                                type: "POST", 
                                success:function(response){ 
                                 var resp = $.parseJSON(response);
                                 $('#fill-add').html(resp.city);
                                // document.getElementById('fill-add').value = resp.city;
                                $('#location-card').fadeOut()
                                }
                                });
                             }

                                   
                        
                    }
                });

                        }
                    }
                     });              
               
                });	
	}
}

//  function emojisfunction(rate){
//    var order_id='';
//   $.ajax
//            ({
//               type: 'post',
//               url:"<?php echo base_url('website/rating')?>",
//               data: {
//                  rating:rate,
//                  order_id:order_id,
//               },
//            success: function (response)
//            {
           
//            }
//           });
//         }
function emojis(){
  var rate=$('.emojis_val').val();
  var order_id='';
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
            var resp = $.parseJSON(response);
              if(resp.rating_id==true){
                $('#rate').modal('hide');
              }
           } 
          }); 
}
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

  if($("#myform").valid()){
    win(event);
}

});

// $('.win').click(function(e){
  function win(e){
    e.preventDefault();
    var text_describe=$('#describe').val();
    if(text_describe!=''){
  $.ajax
           ({
              type: 'post',
              url:"<?php echo base_url('website/win_user')?>",
              data: {
                text_describe:text_describe
              },
           success: function (response)
           {
                     var resp = $.parseJSON(response);

                     if(resp.boolean!=false){
                        $('#WinAMedal').modal('hide');
                      $('#describe').val('');

                     }

           }
          });
        }
      }
//});
        function myFunction() {
  var copyText = document.getElementById("myInput1");
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
$('.subscription').click(function(e){
  e.preventDefault();
  var email=$('.deliver_srch').val();
  $.ajax({  
        url:"<?php echo $admin_url?>website/subscription",  
        data: {email:email},  
        type: "POST",  
        success:function(data){ 
          var resp = $.parseJSON(data);
          if(resp.boolean!=false){
            e.preventDefault();
           $('.deliver_srch').val('');
          }else{
            $('.sub-err').addClass('d-block');
          }
        }
      });
        
});


</script>
<div class="zoho_chat">
<script type="text/javascript" id="zsiqchat">var $zoho=$zoho || {};$zoho.salesiq = $zoho.salesiq || {widgetcode: "a7d96324e5322fcf345f7de5e869f7754ddf32c60af6b2c4e99b0d4d8bfd9f9a009e5a27ab219d76f0903dbaf42d478a", values:{},ready:function(){}};var d=document;s=d.createElement("script");s.type="text/javascript";s.id="zsiqscript";s.defer=true;s.src="https://salesiq.zoho.in/widget";t=d.getElementsByTagName("script")[0];t.parentNode.insertBefore(s,t);</script>
</div>