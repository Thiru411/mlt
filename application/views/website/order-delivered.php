<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php $this->load->view('website/inc/scripts-top');?>
    <title>Order Delivered Success State</title>
</head>
<body>
    <div class="wrapper">
    <?php $this->load->view('website/inc/header');?>
        <section class="empty-state">
            <div class="container">
                <div class="text-center">
                    <div class="img-fluid mb-4 pb-3"><img src="<?=$admin_url?>assets/images/fav truck.png" ></div>
                    <p class="emptystate-content fs-20 fw-600 mb-4">Your Order has been Delivered on 26th Aug at 4:30 PM </p>
                    
                    <div class="emptystate-line ">

                    </div>
                    <p class="emptystate-rate fs-20 fw-400 ">Rate us now</p>
                    <div class="d-flex justify-content-center mb-5 mx-auto mt-auto" id="rateYo"></div>
                    <button type="button" class="done_btn fw-600">Order Details</button>
                       
                </div>
                
            </div>
        </section>
        <?php $this->load->view('website/inc/footer');?>
    </div>
    <?php $this->load->view('website/inc/scripts-bottom');?>
    <script>
          
        $("#rateYo").rateYo({
        ratedFill: "#5FC2AE",
        starWidth: "41px",
        
            });

    </script>
</body>

</html>