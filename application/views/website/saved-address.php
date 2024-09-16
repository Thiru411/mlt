<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
<?php $this->load->view('website/inc/scripts-top');?>
<title>Saved address</title>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1Z3e-xBgzeKw10ou7QQ6NaNfcI3UZ4KM&libraries=places"></script> -->
<style>
     #map1{width: 100%;height: 149px;}
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
</head>
<body>
    <div class="wrapper">

    <?php $this->load->view('website/inc/header');?>

        <section class="save-addres">
            <div class="container">
            <div class=" saved--mesaages address-saved-message  mb-5">
                <div class="d-flex">
                    <div><img class="img-fluid mr-2" src="<?=$admin_url?>assets/images/saves.png" alt=""></div>
                    <p><span class="fw-500 mr-1">SAVED!</span>Your new address has been added</p>
                </div>
            </div>
            <div class="d-flex d_md_none pt-3">
                        <div class="ml-3">
                            <a href="<?=base_url()?>my-account" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                       
                         <p class="fs-18 fw-600 sav-add mb-4 align-self-center text-center w-100">Saved Addresses</p>
                 </div>
               

                <p class="fs-18 fw-600 sav-add mb-4 d_sm_none">Saved Addresses</p>
                <?php if($getdetail!=false){$i=0; ?>
                <ul class="addres-details">

                    <?php foreach($getdetail as $info){ ?>
                    <li class="line-save">
                        <div class="d-flex  home-pic ml-15">
                            <?php if($info->address_type=='Work'){?><img  class="img-fluid homee "  src="<?=$admin_url?>assets/images/work.png" alt=""><?php }
                                else if($info->address_type=='Home'){?>
                                <img  class="img-fluid homee "  src="<?=$admin_url?>assets/images/home1.png" alt="">
                            <?php  } elseif($info->address_type=='Other'){?>
                                <img  class="img-fluid homee "  src="<?=$admin_url?>assets/images/other.png" alt="">
                            <?php } ?>                        
                            <p class="f-20 home-text fw-600"><?=$info->address_type?></p>
                        </div>
                        <input type="hidden" value="<?=$info->sk_address_id?>" name="address_id" id="address_id<?=$info->sk_address_id?>">
                        <p class=" tower-a"><?=$info->house_no?> <?=$info->full_address?></p>
                        <div class=" tower-a">
                                <!-- <a href="#" onclick="edit_add(<?=$info->sk_address_id?>,'edit');"><p class="edit-delete fw-500 edit-add">Edit</p></a>
                                <p class="edit-delete fw-500 ml-4 delete-add">Delete</p>
                            </a> -->
                            <a class="d-flex  " href="#">
                                <p class="edit-delete fw-500" onclick="myFunction(<?=$info->sk_address_id?>,'edit')" >Edit</p>
                                <p class="edit-delete fw-500 ml-4" onclick="myFunction(<?=$info->sk_address_id?>,'delete')">Delete</p>
                            </a>
                        </div>
                    </li>

                    <?php  }?>
                    <div class="bor-top">
                        <button class="default-btn fw-500 jsdf add-addres">ADD new Address <img class="img-fluid pluse1" src="<?=$admin_url?>assets/images/plus1.png" alt=""> </button>
                    </div>
                    <?php  }else{?>
                    <button class="default-btn fw-500 add-addres mt-4">ADD new Address <img class="img-fluid pluse1" src="<?=$admin_url?>assets/images/plus1.png" alt=""> </button>
                </ul>
                <?php }?>
            </div>
        </section>

        <div class="modal fade locat-place" id="address" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex d_md_none w-100">
                        <div class="ml-3">
                            <a href="<?=base_url()?>cart" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="add-adres fw-600 align-self-center text-center w-100">Add Address</p>
                    </div>
                <h4 class="modal-title d_sm_none" id="exampleModalLabel">Add Address</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><div><img class="img-fluid mb-md-1 mr-md-4" src="<?=$admin_url?>assets/images/cancel.png" alt=""></div></span>
                </button>
                </div>
                <div class="modal-body searchh-locate ">
                    <form class="custom-form mt-3 location-search" action="">
                        <div class="form-group">
                            <!-- <input type="text" class="form-control location_search" placeholder="Enter delivering location"> -->
                            <input type="text" id="project1" value="" class="form-control location_search ui-autocomplete-input" placeholder="Enter delivering location" autocomplete="off">
                            <small class="err" style="color:red"></small>

                            <input type="hidden" id="project-id1">
                            <input type="hidden" id="city2">
                            <input type="hidden" id="latitude1">
                            <input type="hidden" id="longitude1">
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
                        <div class=" pop-up-pad  iframe-address-scroll custom-scrollbar pr_40">
                            <div class="text-center">
      
                            <div id="map"></div>
                            
                            </div>
                            <div class="address">
                                    <div class="d-flex mt-2">
                                          <div>
                                                 <img src="<?=$admin_url?>assets/images/modal-address.png" class="img-fluid">
                                          </div>
                                          <div>
                                              <h6 class="address-text" id="address-text1">
                                              </h6>
                                          </div>
                                          <div class="ml-auto">
                                                  <img src="<?=$admin_url?>assets/images/modal-cross.png" class="img-fluid">
                                          </div>
                                    </div>
                                    <div>
                                          <p class="address-details" id="address-details1">
                                          </p>
                                    </div>
                             </div>
                            <div class="confirm-modal pl-0 pr-0 text-right">
                                <button class="default-btn confirm  fw-600" id="confirm" >Confirm </button>
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
                <div class="modal-body ">
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
                              
                            </div>
                             <div class="address">
                                    <div class="d-flex mt-2">
                                        
                                          <div>
                                                 <img src="<?=$admin_url?>assets/images/modal-address.png" class="img-fluid">
                                          </div>
                                          <div>
                                              <h6 class="address-text area">
                                                  
                                              </h6>
                                              
                                          </div>
                                          <div>
                                          <button type="button" class=" change align-self-center ml-auto" >
                                    <span class="d-block ml-2" aria-hidden="true" onclick="myfunctionchange()">Add Address</span>
                            </button>
                                          </div>
                                          <input type="hidden" id="addressid" name="id">
                                          <!-- <div class="ml-auto">
                                                  <img src="<?=$admin_url?>assets/images/modal-cross.png" class="img-fluid">
                                          </div> -->
                                    </div>
                                    <div>
                                          <p class="address-details" id="address-details">
                                          </p>
                                          </p>
                                    </div>
                             </div>
                            
                        <form class="formvalidation">
                             <div class="modal-inputs manual-addres">
                                 <div class="mb-40 form-group">
                                          <!-- <div class="holder">House/Flat No. <span class="red"> *</span></div> -->
                                          <input id="input" size="18" type="text" name="house" class="form-control houseno" placeholder="House/Flat No.*"  data-bv-notempty-message="Please Enter house/flat no." required>
                                 </div>
                          
                                      <div class="mb-16 form-group">
                                          <!-- <div class="holder">Lankmark <span class="red"> *</span></div> -->
                                          <input id="input" size="18" type="text" name="land" class="form-control landmark" placeholder="Lankmark"  >
                                      </div>

                                    
                             </div>

                              <h6 class="loc-text">What type of location is this?</h6>

                              <div class="form-group home_work ">
                                            <div class="d-flex flex-wrap">
                                                <div class="radio-example mx-400">
                                                        <div class="custom-control custom-radio custom-control-inline location_delivery">
                                                            <input type="radio" name="options"  id="option101"  value="Home"  class="custom-control-input option101" data-bv-field="city">
                                                            <label class="custom-control-label" for="option101">
                                                                <img class="img-fluid mr-2" src="<?=$admin_url?>assets/images/om.svg" alt="">
                                                                 Home</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline location_delivery">
                                                            <input type="radio"  name="options" id="option102" value="Work"  class="custom-control-input option201" data-bv-field="city">
                                                            <label class="custom-control-label" for="option102">
                                                            <img class="img-fluid mr-2" src="<?=$admin_url?>assets/images/work-iframe.png" alt="" >Work</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline location_delivery">
                                                            <input type="radio"  name="options" id="option103" value="Other"  class="custom-control-input option301" data-bv-field="city" data-bv-notempty-message="Please select" required>
                                                            <label class="custom-control-label" for="option103">
                                                            <img class="img-fluid mr-2" src="<?=$admin_url?>assets/images/other-iframe.png" alt="">Other</label>
                                                        </div>
                                                </div>
                                            </div>
                                </div>

                              <div class="confirm-modal pt-16 pl-0 pr-0 text-right">
                                  <input type="hidden" id="add-id" value="0">
                                  <button type="submit" class="default-btn confirm  fw-600" id="confirm_save" >Confirm & Save Address</button>
                              </div>
                      </form>
                 </div>
                </div>
               
            </div>
                 
      
        </div>
    </div>

    
    
  <!-- Modal -->
<div class="modal fade time_slot_msg" id="time_slot_msg" tabindex="-1" aria-labelledby="time_slot_msgLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    
   
      <div class="modal-body">
      <button type="button" class="close close_timeslot ml-auto" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        We're currently not serving the area selected by you. Please select another area and try again     
     </div>
     
    </div>
  </div>
</div>
        <?php $this->load->view('website/inc/footer');?>
    </div>
    <?php $this->load->view('website/inc/scripts-bottom');?>
<script>
   
    function addAddress()
    {
        $('#project1').val('');
        $('#address').modal('show');
        $('#proceed').modal('hide');
    }





    $('.add-addres').click(function(){
        $('#address').modal('show');
        $('#proceed').modal('hide');
    });
    </script>

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
                 document.getElementById('latitude1').value = place.geometry.location.lat();
                 document.getElementById('longitude1').value = place.geometry.location.lng();
                 var latlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
                 geocoder = new google.maps.Geocoder();
                 geocoder.geocode({'latLng': latlng}, function(results, status) {
                     if (status == google.maps.GeocoderStatus.OK) {
                         if (results[0]) {
                             for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 }if (results[0].address_components[j].types[0] == 'country'){
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
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;

                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                 }
                             }
                       }
                       var input2 = document.getElementById('project1').value;
                       $('#address-details1').text(input2);
                       
                         } else {
                         alert("Geocoder failed due to: " + status);
                     }
                     var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                            $('.proceed-locate').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                           
                        
                            $('.proceed-locate').attr('disabled',false);
                            initMap();

                        }
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

<script type="text/javascript">
            var latitude = Number(document.getElementById("latitude1").value);
            var longitude = Number(document.getElementById("longitude1").value);
            var map;
            var marker;
            var myLatlng = new google.maps.LatLng(latitude,longitude);
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
		       
                map = new google.maps.Map(document.getElementById("map"), mapOptions);
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
                            
                            $('#latitude1').val(marker.getPosition().lat());
                            $('#longitude1').val(marker.getPosition().lng());
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
                                $('#latitude1').val(marker.getPosition().lat());
                                $('#longitude1').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                            }
                        }
                    });
                });
                var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                            $('.proceed-locate').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                           
                        
                            $('.proceed-locate').attr('disabled',false);
                            initMap();

                        }
                    }
                });
            
            }
            
            //google.maps.event.addDomListener(window, 'load', initialize);
        </script> 
      
      <script>
        
 let faddress='';
        
        
        function initMap() {
            var latitude = Number(document.getElementById("latitude1").value);
            var longitude = Number(document.getElementById("longitude1").value);
            // var uluru = {
            //     lat: latitude,
            //     lng: longitude
            // };
            var myLatlng = new google.maps.LatLng(latitude,longitude);
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
          map = new google.maps.Map(document.getElementById("map"), mapOptions);
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
                            $('#latitude1').val(marker.getPosition().lat());
                            $('#longitude1').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                               
                google.maps.event.addListener(marker, 'dragend', function() {

                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                            for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 }if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                   if (results[0].address_components[j].types[0] == 'political'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;

                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                 }
                             }
                                $('#address-text').text(" "+results[0].address_components[2].long_name);
                                $('#address-details').text(results[0].formatted_address);
                                faddress = results[0].formatted_address;
                                $('#address-details1').text(faddress);
                                $('#latitude1').val(marker.getPosition().lat());
                                $('#longitude1').val(marker.getPosition().lng());
                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                                var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                            $('.proceed-locate').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                           
                        
                            $('.proceed-locate').attr('disabled',false);
                            initMap();

                        }
                    }
                });
                            }
                        }
                    });
                });
        }
        


        /******* iframe map and address  ********/ 
       
        function initMap1() {
            var latitude = Number(document.getElementById("latitude1").value);
            var longitude = Number(document.getElementById("longitude1").value);
            // var uluru = {
            //     lat: latitude,
            //     lng: longitude
            // };
            var myLatlng = new google.maps.LatLng(latitude,longitude);
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
          map = new google.maps.Map(document.getElementById("map1"), mapOptions);
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
                            $('#latitude1').val(marker.getPosition().lat());
                            $('#longitude1').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                        }
                    }
                });

                               
  

                google.maps.event.addListener(marker, 'dragend', function() {
                    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            if (results[0]) {
                            for (j = 0; j < results[0].address_components.length; j++) {
                               // console.log(results[0].address_components[j].types[0]);
                                 if (results[0].address_components[j].types[0] == 'postal_code'){
                                     
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('pincode-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                 document.getElementById('postalCode').value = results[0].address_components[j].short_name;
                                 }if (results[0].address_components[j].types[0] == 'country'){
                                   document.getElementById('countryName').value = results[0].address_components[j].long_name;
                                   /* document.getElementById('countryShortName').value = results[0].address_components[j].short_name; */
                                 }
                                 if (results[0].address_components[j].types[0] == 'administrative_area_level_1'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('stateName').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'political'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('area-fill').value = results[0].address_components[j].short_name;

                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                 }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                    if($('#guest-add-address').val()=='guest'){
                                    document.getElementById('town-fill').value = results[0].address_components[j].short_name;
 
                                 }
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                 }
                                
                             }
                             $('#address-details').text(results[0].formatted_address);
                                $('#address-text1').text(" "+results[0].address_components[2].long_name);
                                faddress = results[0].formatted_address;
                                $('#address-details1').text(faddress);

                                $('#latitude1').val(marker.getPosition().lat());
                                $('#longitude1').val(marker.getPosition().lng());

                                infowindow.setContent(results[0].formatted_address);
                                infowindow.open(map, marker);
                                
                var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                            $('#confirm_save').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                         
                            // $(".noon-time6").html(time);
                            // $(".noon-time5").val(time);
                            $('#confirm_save').attr('disabled',false);
                        }
                    }
                });
                                
                   
                            }
                        }
                    });
                });
        }
       
        $('.proceed1').click(function(){
            if($('#project1').val()!=''){
    $('#iframemap').modal('show');
    $('#address').modal('hide');
    }else{
        $('.err').html('Please Select address');
    }
});

$('#confirm').click(function(){
   let address_head=$('#address-details1').text();
   let address_head1=$('#address-text1').text();
   $('#address-details').text(" "+address_head);
   $('.area').text(address_head1);
   $('#iframemap').modal('hide');
       initMap1();   
       $('#iframe_address').modal('show');
      // $( "#confirm_save" ).attr('disabled',true);

});


$('#confirm_save').click(function(){
    var address_id=$('#add-id').val();
    if(address_id==0){
        address_id=0;
    }
    var city=$('#city2').val();
    var la=$('#latitude1').val();
    var lo=$('#longitude1').val();
    var pincode=$('#postal_code').val();
    var countryName=$('#countryName').val();            
    var stateName=$('#stateName').val();           
    var locality=$('#locality').val();                          
    var address_deatils=$('#address-details').text();
    if($('input[name="options"]:checked').val()!=undefined){

    var address_type=$('input[name="options"]:checked').val();
    if($('input[name="house"]').val()!=''){
        house=$('input[name="house"]').val();
    }var land='';
    if($('input[name="land"]').val()!=''){
        land=$('input[name="land"]').val();
    }
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/addadress1')?>",
           data: {
            city:city,
            la:la,
            lo:lo,
            pincode:pincode,
            stateName:stateName,
            countryName:countryName,
            locality:locality,
            address_id:address_id,
            address_deatils:address_deatils,
            address_type:address_type,
            house:house,
            land:land,
           },
           success:function (response)
           {
            var resp = $.parseJSON(response);
            $('#iframe_address').modal('hide');
           
            $('.addres-details').html(resp.addressdetails);
            $('.address-saved-message').fadeIn();
            //$('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.address-saved-message ').fadeOut(6000);
            }, 6000); 
          //  window.location.reload();
           }

    });
    }
});


function getlocation1(){
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
            $('#latitude1').val(resp.result.latitude);
            $('#longitude1').val(resp.result.longitude);
            $('#postalCode').val(resp.result.zip_code);
            $('#locality').val(resp.result.city);
            $('#latitude1').val(resp.result.latitude);
            $('.address-text').text(resp.result.city);
            $('#city2').val(resp.result.city);
            $('#address-details').text(resp.result.city+' '+resp.result.region_name+' '+resp.result.country_name+' '+resp.result.zip_code);
            initMap();
            }
        });
    }


    function edit_add(id,operation){
        $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/edit_address')?>",
           data: {id:id,
                  operation:operation,
                },
           success:function (response)
           {
              // alert(response)
            var resp = $.parseJSON(response);
           // alert(response)
           $('#confirm_save').attr('disabled',false);
                $('#iframe_address').modal('show');
                initMap();
            

           }

           })

        }
         function myFunction(id,operations){
         
            $.ajax
            ({
            type: 'post',
            url:"<?php echo base_url()?>website/editAddress",
            data: {
             id:id,
              operations:operations 
           },
           success: function (response)
           {
               //alert(response)
          var resp =$.parseJSON(response)
           if(resp.false!='false'){
            var temp=resp.address.split('&&');
                var slug1=temp[0];  
           // alert(slug1)
           var slug2=temp[1];
           //alert(slug2)
           var slug3=temp[2];
           //alert(slug3)
           var slug4=temp[3];
           var slug5=temp[4];
           var slug6=temp[5];
           var slug7=temp[6];
           var slug8=temp[7];
           var slug9=temp[8];
           var slug10=temp[9];
           var slug11=temp[10];
           var slug12=temp[11];
          //alert(slug9)
          
          $('#addressid').val(slug8);
         
           $('#latitude1').val(slug1);
           $('#longitude').val(slug2);
           $('.area').html(slug4);
           //alert(slug4)
           $('.address-details').html(slug3);
           $('#add-id').val(id);
           $('.houseno').val(slug5)
           $('.landmark').val(slug6)
           if(slug7=='Home'){
            $('.option101').val(slug7)
            $('.option101').prop('checked',true)
            $(".home1").addClass("active");
            $(".work1").removeClass("active");
            $(".other1").removeClass("active");
            }else if(slug7=='Work'){
            $('.option201').val(slug7)
            $('.option201').prop('checked',true)

            $(".home1").removeClass("active");
            $(".other1").removeClass("active");
            $(".work1").addClass("active");
            }else{
                $('.option301').prop('checked',true)

            $('.option301').val(slug7)
            $(".home1").removeClass("active");
            $(".work1").removeClass("active");
            $(".other1").addClass("active");
            }
            $('#locality').val(slug9);
            $('#stateName').val(slug10); 
            $('#countryName').val(slug11);      
            $('#postal_code').val(slug12);
                     
           // $('#stateName').val();           
                                   
           
           $('#iframemap').modal('hide');
        initMap1();   
        $('#iframe_address').modal('show');        
        }
        
            else {
        window.location.reload();
    }
    
}
    });


}
function myfunctionchange(){
    $('#iframe_address').modal('hide');   
    $('#address').modal('show');
}



function getlocation(){
	if ("geolocation" in navigator){
		navigator.geolocation.getCurrentPosition(function(position){ 
			var currentLatitude = position.coords.latitude;
			var currentLongitude = position.coords.longitude;
      var myLatlng = new google.maps.LatLng(currentLatitude,currentLongitude);
      geocoder = new google.maps.Geocoder();

                geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                              
                                $('#project1').val(results[0].formatted_address);
                                for (j = 0; j < results[0].address_components.length; j++) {
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
                                  if (results[0].address_components[j].types[0] == 'political'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('political').value = results[0].address_components[j].long_name;
                                    city=results[0].address_components[j].long_name
                            }
                                 if (results[0].address_components[j].types[0] == 'locality'){
                                   /* document.getElementById('stateShortName').value = results[0].address_components[j].short_name; */
                                   document.getElementById('locality').value = results[0].address_components[j].long_name;
                                   $('#address-text1').text(" "+results[0].address_components[2].long_name);
                                $('#address-details').text(results[0].formatted_address);
                                faddress = results[0].formatted_address;
                                $('#address-details1').text(faddress);
                                $('#latitude1').val(currentLatitude);
                                $('#longitude1').val(currentLongitude);
                                var lat=$('#latitude1').val();
                    var lon=$('#longitude1').val();  
                    let tomorrow='0';
                     $.ajax({
                    type: 'post',
                    url:"<?php echo base_url('realtime_feasabilty_check')?>",
                    data:{tomorrow:tomorrow,lat:lat,lon:lon},
                    success: function (response){
                        var resp = $.parseJSON(response);
                        if(resp.time==2){
                            $('.proceed-locate').attr('disabled',true);
                            $('#time_slot_msg').modal('show');

                        }
                        else{
                                                                                           
                        
                            $('.proceed-locate').attr('disabled',false);
                            initMap();

                        }
                    }
                });
                                 }
                             }

                                   
                        }
                    }
                });

                               
               
                });	
	}

}

  </script>  


</body>

</html>