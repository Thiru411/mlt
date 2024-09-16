<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
<?php $this->load->view('website/inc/scripts-top');?>
<title>Refund-policy</title>
</head>

<body>
<?php $this->load->view('website/inc/header');?>
    <section class="refund-policy">
        <div class="conatiner">
            <div class="max_width_privacy">
            <h1 class="text-center mb-4">Refund Policy</h1>
                <p class="mb-4">We have a 30-minute return policy, which means you have 30 minutes after receiving your item to request a return.</p>
                <p class="mb-4">To be eligible for a return, your item must be in the same condition that you received it, unworn or unused, with tags, and in its original packaging. You’ll also need the receipt or proof of purchase.</p>
                <p class="mb-4 personal_information ">To start a return, you can contact us at  <a href="">am@foodtechventures.in</a>. If your return is accepted, we’ll send you a return shipping label, as well as instructions on how and where to send your package. Items sent back to us without first requesting a return will not be accepted.</p>
                <p class="mb-5 pb-md-3 personal_information">You can always contact us for any return question at <a href="">am@foodtechventures.in</a>.</p>

                <h6 class="mb-2">Damages and issues</h6>
                <p class="mb-4">Please inspect your order upon reception and contact us immediately if the item is defective, damaged or if you receive the wrong item, so that we can evaluate the issue and make it right.</p>

                <h6 class="mb-2">Exceptions / non-returnable items</h6>
                <p class="mb-4">Certain types of items cannot be returned, like partially consumed goods. Unfortunately, we cannot accept returns on sale items or gift cards. </p>

                <h6 class="mb-2">Exchanges</h6>
                <p class="mb-4">The fastest way to ensure you get what you want is to return the item you have, and once the return is accepted, make a separate purchase for the new item.</p>

                <h6 class="mb-2">Refunds </h6>
                <p class="mb-4">We will notify you once we’ve received and inspected your return, and let you know if the refund was approved or not. If approved, you’ll be automatically refunded on your original payment method. Please remember it can take some time for your bank or credit card company to process and post the refund too.</p>
            </div>
        </div>
   </section>
    <?php $this->load->view('website/inc/footer');?>
    <?php $this->load->view('website/inc/scripts-bottom');?>

</body>

</html>