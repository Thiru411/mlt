<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php $this->load->view('website/inc/scripts-top');?>
    <title>Order Scheduled Success State</title>
</head>
<body>
    <div class="wrapper">
    <?php $this->load->view('website/inc/header');?>
        <section class="empty-state">
            <div class="container">
                <div class="text-center">
                    <div class="img-fluid mb-4 pb-3"><img src="<?=$admin_url?>assets/images/fav truck.png" ></div>
                    <p class="emptystate-title fs-20 fw-600 mb-2">Your order is scheduled for </p>
                    <p class="emptystate-header fs-20 fw-600 mb-4">tomorrow, 6:00 PM.</p>
                    <div class="header-line">

                    </div>
                    <p class="emptystate-text fw-500 mt-4 pb-0">Hurray!</p>
                    <p class="emptystate-text fw-500 "> You can Track your order when we start preparing the dough.</p>
                    <div class="emptystate-line ">

                    </div>
                
                    <div class="text-center" >
                        <button type="button" class="explore_btn fw-600">Order Details</button>
                        <button type="button" class="gift_btn fw-600">Refer/Gift A Cart</button>
                    </div>
                </div>
                
            </div>
        </section>
        <?php $this->load->view('website/inc/footer');?>
    </div>
    <?php $this->load->view('website/inc/scripts-bottom');?>
</body>
</html>