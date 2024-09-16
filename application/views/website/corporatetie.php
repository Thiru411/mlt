<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php  $this->load->view('website/inc/scripts-top');?>
    

    <title>Corporate Tie-Ups</title>
<style>
    .select2-search--dropdown{padding: 0 !important;}

</style>
</head>

<body>
    <div class="wrapper">
      
    <?php $this->load->view('website/inc/header');?>

        <section class="bg-corporate">
            <div class="container">
                <h5 class="fw-600 fs-18 mt-5">Corporate Tie UP</h5>
                <div class="bg-workspace position-relative ">
                    <div class="overlay-img position-relative"><img src="<?=$admin_url?>assets/images/workspace.png"
                            class="img-fluid"></div>
                    <p class="fw-500">What’s true for home is also true for your second home.
                        <span class="green-txt">your workplace.</span>
                    </p>
                </div>
            </div>
        </section>

        <section class="cor-page text-center">
            <div class="container">
                <h5 class="fw-600  mb-3">Get Freshly Baked pizza</h5>
                <p class="fs-18">We complete your Trade Shows, Client meetings, Team-Building Events, Product Launch
                    Events, any anything fun.</p>
            </div>
        </section>
        <section class="card-benefits">
            <div class="container">
                <h5 class="fw-600 text-center">Benefits</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="text-center">
                                <div><img src="<?=$admin_url?>assets/images/clocks.png" class="img-fluid"></div>
                                <p class="fs-18">Pay end of the month</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-pad">
                            <div class="text-center">
                                <div><img src="<?=$admin_url?>assets/images/pizzaa.png" class="img-fluid"></div>
                                <p class="fs-18"> Get X orders for Y deliveries</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-pad">
                            <div class="text-center">
                                <div><img src="<?=$admin_url?>assets/images/Coins.png" class="img-fluid"></div>
                                <p class="fs-18"> Get wallet coins for every order</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center fixxed-book">
                    <button type="button" class="btn sign-up-now fw-600 " data-toggle="modal"
                        data-target="#sign_up_now">Sign Up Now</button>
                </div>
            </div>
        </section>
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">
            Successfull state
          </button> -->

        
    </div>
    <?php $this->load->view('website/inc/footer');?>



    <!-- Modal -->
    <div class="modal fade signup-modal" id="sign_up_now" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="padd-40">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h6 class="fw-600 p-sec mb-3 d-md-block d-none">Corporate Tie UP</h6>
                        <div class="d-flex d_md_none w-100 mb-4">
                        <div class="ml-3">
                            <a href="#" class="back_btn" data-dismiss="modal" aria-label="Close"><img class="mr-2 pr-1 " src="<?=$admin_url?>assets/images/back.png">Back</a>
                        </div>
                        <p class="add-adres fw-600   p-sec align-self-center text-center w-100">Corporate Tie UP</p>
                    </div>
                   
                    </div>
                    <div class="h-500 custom-scrollbar">
                        <div class="padd-40 ">
                        <h5 class="fw-500 mb-2">We know your colleagues & coworkers can’t be topped</h5>
                        <p>So why not treat them to the toppings of their choice?</p>
                        <p class="mb-4 half-text"> Our corporate plans have been specially  <a href="#" class="see-more see-fulltext">See more</a> </p>
                            <p class="mb-4 d-none fulltext"> Our corporate plans have been specially designed and created keeping in mind the
                            busy schedules of today’s jobs. ... <a href="#" class="see-more see-halftext">See less</a> </p>
                        <h4 class="fw-500 mb-4">create corporate account</h4>
                        <form class="tieup_form mb-30" id="tieup_form" enctype="multipart/form-data"  method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3 pb-2">
                                        <label for="exampleFormControlInput1" class="mb-3 fw-500">Full Name</label>
                                        <input type="text" id="name" class="form-control  full_name" placeholder="Aditi Sharma" autocomplete="off" name="name" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group postion-relative">
                                        <label for="exampleFormControlInput2" class="mb-3 fw-500">Organization Name</label>
                                        <input type="text" class="form-control  organizationname" id="orgname" placeholder="Sharma Associates" autocomplete="off"  name="orgname" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3 cor_mob pb-2">
                                        <label for="exampleFormControlInput3" class="mb-3 fw-500">Official Mobile No.</label>
                                        <input type="number" class="form-control  log-inn restrict_alphabits  mobileno" id="number" placeholder=" 8959494988" maxlength="10" minlength="10"  autocomplete="off"  name="number" >
                                        <span class="validity"></span>
                                                        <p>+91 </p>
                                    </div>   
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput4" class="mb-3 fw-500">Official Email Id</label>
                                        <input type="email" class="form-control  emailid" id="email" placeholder="office@gmail.com" autocomplete="off" name="email" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <p class="doc-txt fw-500 mb-3">Select Document</p></div>
                                <div class="col-md-6 position-relative form-group custom_error id_select">
                                    <select class="js-example-placeholder-single js-states form-control upload1" name="select1" id="documentval"  >
                                        <option value=""></option>
                                        <option value="Gst Document">GST</option>
                                        <option value="Pan Card Document">PAN CARD</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 pb-1 file_upload custom_error position-relative form-group ">
                                        <!-- <div class="input-file-container position-relative">  
                                        <input class="input-file file1234" id="my-file" type="file" name="upload1" >
                                        <label tabindex="0" for="my-file" class="input-file-trigger">Upload</label>
                                        <div><img src="<?=$admin_url?>assets/images/upload.png" class="img-fluid upload-img"></div>
                                        </div> -->
                                        <div class="d-flex">
                                            <label for="my-file" class="d-flex input-file-trigger file12">Upload
                                                <div class="ml-md-2"><img src="<?=$admin_url?>assets/images/upload.png" class="img-fluid upload_img"></div>
                                            </label>
                                            <img src="<?=base_url()?>assets/images/vector.png"class="tick1" style="display:none">

                                            <p class="file-return align-self-center ml-2"></p>
                                            <input id="my-file" class="input-file file1234" type="file" name="upload1"  accept="application/pdf,image/*">
                                        </div>
                                        <!-- <div id="file-upload-filename"></div> -->
                                        
                                </div>
                                <div class="col-md-6 position-relative form-group custom_error address_select">
                                    <select class="js-example-placeholder-single-add js-states form-control upload2" name="select2" id="documentval2"  >
                                        <option value=""></option>
                                        <option value="Utility Bill">UTILITY BILL</option>  

                                       
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 mb-md-5 pb-1 file_upload custom_error position-relative form-group">
                                
                                        <!-- <div class="input-file-container position-relative">  
                                        <input class="input-file file12345" id="my-file" type="file" name="upload2" >
                                        <label tabindex="0" for="my-file" class="input-file-trigger">Upload</label>
                                        <div><img src="<?=$admin_url?>assets/images/upload.png" class="img-fluid upload-img"></div>
                                        </div> -->
                                        <div class="d-flex">
                                            <label for="my-file1" class="d-flex input-file-trigger  file11">Upload
                                                <div class="ml-md-2"><img src="<?=$admin_url?>assets/images/upload.png" class="img-fluid upload_img "></div>

                                            </label>
                                            <img src="<?=base_url()?>assets/images/vector.png" class="tick2" style="display:none">

                                            <p class="file-return1 align-self-center ml-2"></p>
                                            <input id="my-file1" class="input-file file12345 " type="file" name="upload2" accept="application/pdf,image/*" style=""/>
                                        </div>
                                        
                                </div>  
                            </div>
                            <div class="footer-signup ">
                                <button type="submit" class="btn sign-up-btn tieup_btn sent__request"  >Sign Up Now</button>
                                <!-- <button type="button" class="btn sign-up-btn sent__request" >Sign Up Now</button> -->
                            </div>
                        </form>
                     </div>        
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade corporate-success" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModal1Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
       
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="text-center">
                <div><img src="<?=$admin_url?>assets/images/ticks.png" class="img-fluid mb-3"></div>
                <h6 class="fs-20 mb-3">Your request for corporate tie up has been received!</h6>
                <p class="fs-18">You will hear from us shortly</p>
            </div>
        </div>
      
      </div>
    </div>
  </div>

  <?php $this->load->view('website/inc/scripts-bottom');?>
   
  <script>
      
$(".tieup_btn").click(function(){
  var form = $("#tieup_form");
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
        orgname: {
            required: true,
        },
        email: {
            required: true,
            // noSpace: true,
            email: true
        },
        number: {
            required: true,
            minlength:10,
            maxlength:10,
            digits:true
        },
        select1: {
            required: true,
        },
        select2: {
            required: true,
        },
        upload1: {
            required: true,
        },
        upload2: {
            required: true,
        }   
    },
    messages: {
        name : {
            required: "Please enter your name",
        },
        orgname : {
            required: "Please enter organization name",
        },
        email : {
            required: "Please enter email ID",
            email: "Please enter valid email ID",
        },
        number : {
            required: "Please enter mobile number",
            minlength: "Enter 10 digit number",
            maxlength: "Enter 10 digit number",
            digits: "Only numbers are allowed in this field"
        },
        select1 : {
            required: "Please select personal Id",
        },
        select2 : {
            required: "Please select official address proof",
        },
        select2 : {
            required: "Please select official address proof",
        },
        upload1 : {
            required: "Please upload file",
        },
        upload2 : {
            required: "Please upload file",
        }
    }
  });
  if($("#tieup_form").valid()){
      corporatetie(event);
  }
});

$(".id_select .select2-container .select2-selection--single").click(function () {
  $('#documentval-error').hide();
  $('.id_select').removeClass('has-error');
});
$(".address_select .select2-container .select2-selection--single").click(function () {
  $('#documentval2-error').hide();
  $('.address_select').removeClass('has-error');
});


let filedata1;
let filename1;
$( ".file1234" ).change(function() {
var files = $('.file1234').get(0).files;
//console.log(files[0]);
let reader = new FileReader();
reader.readAsDataURL(files[0]);
reader.addEventListener('load', event => {
filedata1=event.target.result;
filename1=files[0].name;
var filename=filename1.split('.');
filename1='DOC.'+filename[1];
$('.file12').text(filename1);
$('.tick1').css('display:block');

})
});

let filedata2;
let filename2;
$( ".file12345" ).change(function() {
var files = $('.file12345').get(0).files;
//console.log(files[0]);
let reader = new FileReader();
reader.readAsDataURL(files[0]);
reader.addEventListener('load', event => {
filedata2=event.target.result;
filename2=files[0].name;
var filename=filename2.split('.');
filename2='DOC.'+filename[1]
$('.file11').text(filename2);
$('.tick2').css('display:block');

})
});

    // function toSave(e){ 
        // $( ".sent__request" ).on( "click", function( event ) {   
     function  corporatetie(e){
        e.preventDefault();   
      var full_name=$('.full_name').val();
      var organization_name=$('.organizationname').val();
      var mobile_no=$('.mobileno').val();
      var email_id=$('.emailid').val();
      var documentval=$('#documentval').val();
      var documentval2=$('#documentval2').val();
      $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/corporatetieupSave')?>",
           data: {
            full_name:full_name ,
            organization_name:organization_name,
            mobile_no:mobile_no,
            email_id:email_id,
            documentval:documentval,
            documentval2:documentval2,
            filedata2:filedata2,
            filedata1:filedata1,
           },
           success: function (response)
           {
               
            e.preventDefault();

            var resp = $.parseJSON(response);
            if(resp.result!='false'){
               $('.full_name').val('');
               $('.organizationname').val('');
               $('.mobileno').val('');
               $('.emailid').val('');
               $('#documentval').val('');
               $('#documentval2').val('');
                $('#sign_up_now').modal('hide');
                $('#exampleModal1').modal('show');
            }
           }
           });
        // });
     }
  //} 

     $('.see-fulltext').click(function(){
        $('.half-text').addClass('d-none');
        $('.fulltext').removeClass('d-none');
     });

     $('.see-halftext').click(function(){
        $('.half-text').removeClass('d-none');
        $('.fulltext').addClass('d-none');
     });
</script> 




</body>

</html>