<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php $this->load->view('website/inc/scripts-top.php');?>
    <title>Order Scheduled Success State</title>
    <!-- <style>
    .empty-state{padding:50px 0;}
    .emptystate-title{text-transform: uppercase;color: #FFFFFA;letter-spacing: 1px;line-height: 1.5;}
    .emptystate-header{text-transform: uppercase;color: #5FC2AE;letter-spacing: 1px;line-height: 1.5; }
    .emptystate-text{line-height: 1.5;color: #FFFFFF;padding-bottom: 80px;width: 100%;max-width: 514px;margin: 0 auto;}
    .header-line{border-bottom: 1px solid rgba(255, 255, 250, 0.1);width: 100;max-width: 480px;margin: 0 auto;}
    .emptystate-line{border: 1px solid #E0AF02;transform: rotate(90deg);width: 100%;max-width: 80px;margin: 0 auto;}
    .explore_btn{color: #000000;font-size: 16px;line-height: 1.25;background: #5FC2AE;border-radius: 8px;opacity: 0.8;padding: 14px 32px;margin-top:80px;border: 0;}
    .gift_btn{color: #E0AF02;font-size: 16px;line-height: 1.25;background: rgba(255, 255, 250, 0.1);border-radius: 8px;padding: 14px 32px;margin-top:80px;border: 0;margin-left: 30px;}
    
    </style> -->
</head>
<body>
    <div class="wrapper">
    <?php $this->load->view('website/inc/header.php')?>
        <section class="empty-state">
            <div class="container">
                <div class="text-center">
                    <div class="img-fluid mb-4 pb-3"><img src="<?=$admin_url?>assets/images/fav truck.png" ></div>
                    <p class="emptystate-title fs-20 fw-600 mb-2">Your Party Time order is scheduled for </p>
                    <?php $from=date('h:i A',strtotime($from));
                          $to=date('h:i A',strtotime($to));
                    ?>
                    <p class="emptystate-header fs-20 fw-600 mb-4"><?=$select_date?>, <?=$from?> to <?=$to?>.</p>
                    <div class="header-line">

                    </div>
                    <p class="emptystate-text fw-500 mt-4 pb-0">Hurray!</p>
                    <p class="emptystate-text fw-500 ">You can Track your order’s status from the order details page later on the delivery day.</p>
                    <div class="emptystate-line ">

                    </div>
                
                    <div class="text-center" >
                    <a type="button" class="explore_btn fw-600 dialpad" href="tel:9292925353">Speak To Our Co ordinator-929292 5353</a>
                    </div>
                </div>
                
            </div>
        </section>

        
        <?php $this->load->view('website/inc/footer');?>
    </div>
    <?php $this->load->view('website/inc/scripts-bottom');?>
</body>

</html>