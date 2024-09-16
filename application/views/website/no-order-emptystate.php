<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php $this->load->view('website/inc/scripts-top');?>
    <title>Order Confirmed Empty  State</title> 
    <style>
    .empty-state{padding:50px 0;}
    .emptystate-header{text-transform: uppercase;color: #5FC2AE;letter-spacing: 1px;line-height: 1.5;}
    .emptystate-text{line-height: 1.5;color: #FFFFFF;padding-bottom: 80px;}
    .emptystate-line{border: 1px solid #E0AF02;transform: rotate(90deg);width: 100%;max-width: 80px;margin: 0 auto;}
    .order_btn{color: #000000;font-size: 16px;line-height: 1.25;background: #5FC2AE;border-radius: 8px;opacity: 0.8;padding: 16px 32px;margin-top:80px;border:0;}
    </style>
</head>
<body>
    <div class="wrapper">
        <?php $this->load->view('website/inc/header.php');?>
        <section class="empty-state">
            <div class="container">
                <div class="text-center">
                    <div class="img-fluid mb-4 pb-3"><img src="<?=base_url()?>assets/images/fav truck.png" ></div>
                    <p class="emptystate-header fs-20 fw-600 mb-4">haven’t ordered from us before?</p>
                    <p class="emptystate-text fw-500 ">We can fix that :)</p>
                    <div class="emptystate-line ">

                    </div>
                    <button type="button" class="order_btn fw-600"><a href="<?php echo base_url('/menu')?>">Order Now</a></button>
                </div>
            </div>
        </section>
        <?php $this->load->view('website/inc/footer');?>
    </div>
    <?php $this->load->view('website/inc/scripts-bottom');?>
</body>
</html>