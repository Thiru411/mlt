<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    
    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php $this->load->view('website/inc/scripts-top');?>
    <title>Order Created Success State</title>
    <style>
    
    </style>
</head>
<body>
    <div class="wrapper">
    <?php $this->load->view('website/inc/header');?>
        <section class="empty-state">
            <div class="container">
                <div class="text-center">
                    <div class="img-fluid mb-4 pb-3"><img src="<?=$admin_url?>assets/images/fav truck.png" ></div>
                    <p class="emptystate-header fs-20 fw-600 mb-4">Order Created!</p>
                    <p class="emptystate-text fw-500 ">Our Van is on your way to serve your fresh hot pizza</p>
                    <div class="emptystate-line ">
                    </div>
                    <a type="button" class="explore_btn fw-600 dialpad" href="tel:9292925353">Speak To Our Co-ordinator-9292925353</a>
                </div>
            </div>
        </section>
        <?php $this->load->view('website/inc/footer');?>
    </div>
    <?php $this->load->view('website/inc/scripts-bottom');?>
</body>
</html>