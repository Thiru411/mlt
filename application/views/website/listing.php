<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  
  <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
  <?php  $this->load->view('website/inc/scripts-top');?>
  <title>Listing</title>

</head>

<body>
  <div class="wrapper pt-186">
  <?php  $this->load->view('website/inc/header');?>
    <section class="fixed-tabs">
      <div class="container">
        <div class="tabs-scroll">
          <ul class="nav nav-tabs row listing-page listing_tabs border-0" id="myTab" role="tablist">
        <?php  $image_url='';
        if($category_details){
          $slug='';

                foreach($category_details as $info) {
                 $image_url=admin_img_url.'category/'.$info['image'];
                ?>
                <input type="hidden" id="slug" value="<?= $info['slug']?>">
            <li class="nav-item col-md-2" role="presentation">
              <a class="nav-link border-0 pic-blurrr getslug <?php if($menu_active==$info['slug']){$slug=$menu_active?> active<?php }?>" id="<?=$info['slug']?>-tab" data-toggle="tab" href="#<?=$info['slug']?>" role="tab" aria-controls="pizza" aria-selected="true">
                <img class="items-food " src="<?=$image_url?>" alt="">
                <p class="food-items fs-20 mt-md-3 fw-400"><?=$info['category_type']?></p>
              </a>
            </li>
            <?php }}?>
           <!-- <li class="nav-item col-md-2" role="presentation">
              <a class="nav-link border-0 pic-blurrr" id="side-tab" data-toggle="tab" href="#side" role="tab" aria-controls="side" aria-selected="false">
                <img class="items-food  " src="<?=$admin_url?>assets/images/sides.png" alt="">
                <p class="food-items fs-20 mt-md-4 fw-400">sides</p>
              </a>
            </li>
            <li class="nav-item col-md-2" role="presentation">
              <a class="nav-link border-0 pic-blurrr" id="salads-tab" data-toggle="tab" href="#salads" role="tab" aria-controls="salads" aria-selected="false">
                <img class="items-food " src="<?=$admin_url?>assets/images/salads.png" alt="">
                <p class="food-items fs-20 mt-md-4 fw-400">salads</p>
              </a>
            </li>
            <li class="nav-item col-md-2" role="presentation">
              <a class="nav-link border-0 pic-blurrr" id="dips-tab" data-toggle="tab" href="#dips" role="tab" aria-controls="dips" aria-selected="false">
                <img class="items-food  " src="<?=$admin_url?>assets/images/dips.png" alt="">
                <p class="food-items fs-20 mt-md-4 fw-400">dips</p>
              </a>
            </li>
            <li class="nav-item col-md-2" role="presentation">
              <a class="nav-link border-0 pic-blurrr" id="deserts-tab" data-toggle="tab" href="#deserts" role="tab" aria-controls="deserts" aria-selected="false">
                <img class="items-food " src="<?=$admin_url?>assets/images/desserts.png" alt="">
                <p class="food-items fs-20 mt-md-4 fw-400">desserts</p>
              </a>
            </li>
            <li class="nav-item col-md-2" role="presentation">
              <a class="nav-link border-0 pic-blurrr" id="drinks-tab" data-toggle="tab" href="#drinks" role="tab" aria-controls="drinks" aria-selected="false">
                <img class="items-food " src="<?=$admin_url?>assets/images/drinks.png" alt="">
                <p class="food-items fs-20 mt-md-4 fw-400">drinks</p>
              </a>
            </li> -->
          </ul>
        </div>
      </div>
    </section>
    <div class="tab-content tab_background" id="myTabContent">
<?php $j=1;if($category_details){
    foreach ($category_details as $info) {
        if ($j==1) {
            $active='active';
        } else {
            $active='';
        } 
        $div_heading = '';
        $section='';
        $slug=$info['slug'];
        if($info['slug']!='drinks'){
        $div_heading = $info['captions'];
          $section='<div class="custom-control custom-switch yellow_switch ml-4">
                      <input type="checkbox" class="custom-control-input '."$slug".'_nonveg" id="customSwitch1'."$slug".'">
                      <label class="custom-control-label" for="customSwitch1'."$slug".'">Non Veg</label>
                    </div>
                    <div class="custom-control custom-switch green_switch">
                      <input type="checkbox" class="custom-control-input '."$slug".'_veg" id="customSwitch2'."$slug".'">
                      <label class="custom-control-label" for="customSwitch2'."$slug".'">Veg</label>
                    </div>';
        }else{
          $div_heading = $info['captions'];
        }
      
         if($menu_active==$info['slug']){
          $active='active';
         }else{
          $active='';

         }
       ?>  
      <div class="tab-pane fade show <?=$active?>" id="<?=$info['slug']; ?>" role="tabpanel" aria-labelledby="home-tab">
       <?php if($info['slug']=='pizzas'){?>
          <section class="exclusive-pizzas">
        <?php }else{?>
             <section class="exclusive-pizzas no-customize">
        <?php }?>      
        <div class="container">
            <div class="d-flex exclusive--pizzas mb-40">
              <p class="fs-20 exclusive mr-auto"><?=$div_heading?></p>
                <?=$section?>
              <!-- <div class="custom-control custom-switch toggle-left ">
                <input type="checkbox" class="custom-control-input" id="customSwitch1">
                <label class="custom-control-label fs-18 egg-only" for="customSwitch1">Egg Only</label>
              </div>
              <div class="custom-control custom-switch toggle-right ">
                <input type="checkbox" class="custom-control-input" id="customSwitch2">
                <label class="custom-control-label fs-18 veg-egg fw-500" for="customSwitch2">veg</label>
              </div> -->
              
              
     
              <!-- <p class="fs-18 exclusive">veg</p> -->
            </div>
            <?php $top='';if(!empty($info['item_details'])){ 

              //var_dump($info['item_details']); exit;
              foreach($info['item_details'] as $itemInfo){

                $item_id=$itemInfo['item_id'];
                $item_name=$itemInfo['item_name'];
              $image=admin_img_url.'items/'.$itemInfo['image'];?>
              <input type="hidden" value="<?=$itemInfo['type']?>" class="type<?=$itemInfo['item_id']?>">
            <div class="media pizzaas-box position-relative <?=$itemInfo['type']?>-item">
              <img class="pizza-banner img-fluid" src='<?=$image?>' alt="">               


              <div class="media-body pizza-details">

                <div class="d-flex">
                  <div class="mx-471">
                    <?php if($itemInfo['type']=='veg'){?>
                    <div class="green-dot"> <img src="<?=$admin_url?>assets/images/dot.png" alt=""></div>
                    <?php }else{?>
                      <div class="green-dot"> <img src="<?=$admin_url?>assets/images/red-dot.png" alt=""></div>
                    <?php }?>
                    <h5 class="fmg-maggi "><?=$itemInfo['display_name']?> -
                      <span class="for-maggi align-self-center"><?php echo $itemInfo['item_name']?></span>
                    </h5>
                  </div>
                  <div class="like-heart red_hearts-- ml-auto">
                    <?php if($user_id!=''){
                    if($itemInfo['favorites']==false){?>
                    <img class="  heart" src="<?=$admin_url?>assets/images/heart.png" alt="" onclick="myFunction(<?=$user_id?>,<?=$item_id?>,'<?=$info['slug']?>','add')" style='display:block'>
                    <img class=" red-heart click-heart" src="<?=$admin_url?>assets/images/red-heart.png" onclick="myFunction(<?=$user_id?>,<?=$item_id?>,'<?=$info['slug']?>','delete')" alt=""style='display:none'>
                    <?php } else{?>
                    <img class=" red-heart click-heart" src="<?=$admin_url?>assets/images/red-heart.png" onclick="myFunction(<?=$user_id?>,<?=$item_id?>,'<?=$info['slug']?>','delete')" alt=""style='display:block'>
                    <img class="   heart" src="<?=$admin_url?>assets/images/heart.png" alt="" onclick="myFunction(<?=$user_id?>,<?=$item_id?>,'<?=$info['slug']?>','add')" style='display:none'>
                    <?php }} else{?>
                      <button class="btn btn_signin ml-4 " type="button" data-toggle="modal" data-target="#loginmodal"><img class="  heart" src="<?=$admin_url?>assets/images/heart.png" alt=""></button>
                      <?php }?>
                  </div>
                  
                </div>
                <!-- <p class="bright mt-md-3 mt-2 limit_four_lines position-relative"><?=$itemInfo['description']?>. <span class="read_more">Read More</span></p> -->
                <?php if(strlen($itemInfo['description'])<=150){?>
                <p class="bright mt-md-3 mt-2 "><?=$itemInfo['description']?>.</p>
                <?php }else{?>
                  <p class="bright mt-md-3 mt-2 ">

                    <span><?php echo substr($itemInfo['description'],0,150);?><span>
                    <span class="bright mt-md-3 mt-2 display_none more_text"><?php echo substr($itemInfo['description'],151,100000);?>.</span>

                    <span class="read_more">... Read More</span>
                    <span class="read_less"> Read Less</span>
                  </p>
                  <!-- <span class="bright mt-md-3 mt-2 "><?php echo substr($itemInfo['description'],192,100000);?>.</span> -->
                <?php }?>
                <div class="mx-500">
                  
                  <?php  if($info['slug']=='pizzas'){$k=1;?>
                  <div class="d-flex choose-it  mt-md-4 ">
                    <div class="col-md-6 select-size">
                      <select class="selectpicker size-base size-selct size-base1" id="size_<?=$item_id?>"  onchange="getValue(this,<?=$item_id?>);" >
                        <?php if($itemInfo['price_drop']){
                            foreach($itemInfo['price_drop'] as $row3){?>
                            <option class='cost1<?=$row3->sk_id?>' cost='<?=$row3->item_cost?>' value='<?=$row3->sk_id?>'><?=$row3->item_size?></option>
                         <?php }}?>
                      </select>
                    </div>
                    <div class="col-md-6 select-size">
                      <select class="selectpicker size-base" id="base<?=$item_id?>" onchange="ggffdfdfd(this,<?=$item_id?>);">
                        <?php if($itemInfo['base_drop']){
                            foreach($itemInfo['base_drop'] as $row3){
                                     $item_topping=$row3->items;
                              $toppings=explode(',',$item_topping);
                            
                            if($toppings){
                              for($k=0;$k<count($toppings);$k++){
                            $top=$toppings[0];?>  
                          <option class='cost2<?=$k?>'value='<?=$toppings[$k]?>'><?=$toppings[$k]?></option>
                          <?php }}}}?>
                          </select>
                    </div>
                  </div>
                  <?php }?>
                  <input type="hidden" id="item-id1" value="<?=$item_id?>">
                  <input type="hidden" id="item-id2<?=$item_id?>" value="<?=$itemInfo['size']?>">
                  <input type="hidden" id="base-id2<?=$item_id?>" value="<?=$top?>">
                  <div class="d-flex cost ">
                    <div>
                      <h3 class="price" id="price-id<?=$item_id?>">₹<?=$itemInfo['price']?></h3>

                      <p class="taxes ">Inclusive of customization, packaging, delivering & taxes</p>
                    </div>
                    <!-- <p class="taxes ml-md-2 mt-3">incl. taxes</p> -->
                    
                      <?php if($itemInfo['quantity']==0){?>
                       <button class="default-btn fs-20 ml-auto add-cart position-relative" onclick="getValue1(this,<?=$item_id?>,<?=$itemInfo['price']?>,'')" id='add-cart<?=$item_id?>'>Add <div><img src="<?=$admin_url?>assets/images/plusss.svg" class="img-fluid cart--pluse"></div></button>
                       <div class="add-sub inc-dec " id="dec<?=$item_id?>">
                         <div id="field1" class="field1 d-flex ml-4">
                           <button type="button" onclick="getValue1(this,<?=$item_id?>,<?=$itemInfo['price']?>,'sub')" id="sub" class="sub"><img src="<?=$admin_url?>assets/images/minus.png"></button>
                           <input type="number" id="minus<?=$item_id?>" class="num" value="1" min="1" max="10000" readonly>
                           <button type="button" id="add" class="add" onclick="getValue1(this,<?=$item_id?>,<?=$itemInfo['price']?>,'add')" ><img src="<?=$admin_url?>assets/images/plus.png"></button>
                         </div>
                       </div>
                        <?php }else{  ?>  
                          <button class="default-btn fs-20 ml-auto add-cart position-relative" onclick="getValue1(this,<?=$item_id?>,<?=$itemInfo['price']?>,'')" id='add-cart<?=$item_id?>' style='display:none'>Add <div><img src="<?=$admin_url?>assets/images/plusss.svg" class="img-fluid cart--pluse"></div></button>

                       <div class="add-sub inc-dec " id="dec<?=$item_id?>" style="display:block">
                         <div id="field1" class="field1 d-flex ml-4">
                           <button type="button" onclick="getValue1(this,<?=$item_id?>,<?=$itemInfo['price']?>,'sub')" id="sub" class="sub"><img src="<?=$admin_url?>assets/images/minus.png"></button>
                           <input type="number" id="minus<?=$item_id?>" class="num" value="<?=$itemInfo['quantity']?>" min="1" max="10000" readonly>
                           <button type="button" id="add" class="add" onclick="getValue1(this,<?=$item_id?>,<?=$itemInfo['price']?>,'add')" ><img src="<?=$admin_url?>assets/images/plus.png"></button>
                         </div>
                       </div>   
                        <?php }?>
                  </div>

                  <?php if($info['slug']=='pizzas'){?>
                    <input type="hidden" class="priceId" value="<?=$item_id?>">
                  <button type="button" class=" default-btn custooo-mize" data-toggle="modal" data-target="#customizeModal" onclick="getToppingdetails(<?=$item_id?>,'<?=$item_name?>')">
                    Customize
                  </button>
                  <?php }?>
                  <!--<button class="default-btn custooo-mize">Customize</button>-->
                </div>
              </div>
            </div>
            <?php  }}?>
            
          </div>
        </section>
        
      </div>

      <?php  $j++;
    }
}?>
      
      <?php if($cart_price!=0){?>
      <div class="fixed_bar" id="fixed_bar"  style='display:block'>
        <div class="total-bill d-flex">
          <div>  
            <h5 class="total-cost fw-600" id="cart-price"><span class="fw-500">₹</span><?=$cart_price;?></h5>
            <p class="two-items " id="items-list"><?=$items;?> Items in cart</p>
          </div>
          <a class="default-btn  view--cartt fw-600" href="<?=$admin_url?>cart" >View Cart </a>
        </div>
      </div>
      <?php }
     else{?>
        <div class="fixed_bar" id="fixed_bar" style='display:none'>
        <div class="total-bill d-flex">
          <div>  
          <h5 class="total-cost fw-600" id="cart-price"><span class="fw-500">₹</span><?=$cart_price;?></h5>
          <p class="two-items " id="items-list"><?=$items;?> Items in cart</p>
          </div>
          <a class="default-btn  view--cartt fw-600"  href="<?=$admin_url?>cart" >View Cart </a>
        </div>
      </div>
      <?php }?>
    </div>
    <!-- <span class=" stop-bar">ddd</span> -->
      
    <?php  $this->load->view('website/inc/footer');?>
    
  </div>


  <!--customize-->
  <section class="customize-page">
    <div class="modal fade" id="customizeModal" data-keyboard="false" tabindex="-1"
      aria-labelledby="customizeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" id="toppingContent">
          
        </div>
      </div>
    </div>
  </section>


  
  <?php  $this->load->view('website/inc/scripts-bottom');?>

  <script>


$('.pizzas_nonveg').on('change', function(){
  if($(".pizzas_nonveg:checked").length===1){

    $('.pizzas_veg').prop('checked', false );
    $('#pizzas .veg-item').fadeOut();
    $('#pizzas .non-veg-item').fadeIn();
  } 
  if($(".pizzas_nonveg:checked").length===0){

    $('.pizzas_veg').prop('checked', false );
    $('#pizzas .veg-item').fadeIn();
  }
  
});
$('.pizzas_veg').on('change', function(){
  if($(".pizzas_veg:checked").length===1){ 
    
    $('.pizzas_nonveg').prop('checked', false );
    $('#pizzas .non-veg-item').fadeOut();
    $('#pizzas .veg-item').fadeIn();
  } 
  if($(".pizzas_veg:checked").length===0){

    $('.pizzas_nonveg').prop('checked', false );
    $('#pizzas .non-veg-item').fadeIn();
    // $('.veg-item').fadeIn();
  }
});     

/* Sides Toogle Content */
$('.sides_nonveg').on('change', function(){
  if($(".sides_nonveg:checked").length===1){
    $('.sides_veg').prop('checked', false );
    $('#sides .veg-item').fadeOut();
    $('#sides .non-veg-item').fadeIn();
  } 
  if($(".sides_nonveg:checked").length===0){
    $('.sides_veg').prop('checked', false );
    $('#sides .veg-item').fadeIn();
  }
  
});
$('.sides_veg').on('change', function(){
  if($(".sides_veg:checked").length===1){
    $('.sides_nonveg').prop('checked', false );
    $('#sides .non-veg-item').fadeOut();
    $('#sides .veg-item').fadeIn();
  } 
  if($(".sides_veg:checked").length===0){
    $('.sides_nonveg').prop('checked', false );
    $('#sides .non-veg-item').fadeIn();
  }
});
/* Sides Toogle Content */

/* Salads Toogle Content */
$('.salads_nonveg').on('change', function(){
  if($(".salads_nonveg:checked").length===1){
    $('.salads_veg').prop('checked', false );
    $('#salads .veg-item').fadeOut();
    $('#salads .non-veg-item').fadeIn();
  } 
  if($(".salads_nonveg:checked").length===0){
    $('.salads_veg').prop('checked', false );
    $('#salads .veg-item').fadeIn();
  }
  
});
$('.salads_veg').on('change', function(){
  if($(".salads_veg:checked").length===1){
    $('.salads_nonveg').prop('checked', false );
    $('#salads .non-veg-item').fadeOut();
    $('#salads .veg-item').fadeIn();
  } 
  if($(".salads_veg:checked").length===0){
    $('.salads_nonveg').prop('checked', false );
    $('#salads .non-veg-item').fadeIn();
  }
});
/* Salads Toogle Content */

/* Dips Toogle Content */
$('.dips_nonveg').on('change', function(){
  if($(".dips_nonveg:checked").length===1){
    $('.dips_veg').prop('checked', false );
    $('#dips .veg-item').fadeOut();
    $('#dips .non-veg-item').fadeIn();
  } 
  if($(".dips_nonveg:checked").length===0){
    $('.dips_veg').prop('checked', false );
    $('#dips .veg-item').fadeIn();
  }
  
});
$('.dips_veg').on('change', function(){
  if($(".dips_veg:checked").length===1){
    $('.dips_nonveg').prop('checked', false );
    $('#dips .non-veg-item').fadeOut();
    $('#dips .veg-item').fadeIn();
  } 
  if($(".dips_veg:checked").length===0){
    $('.dips_nonveg').prop('checked', false );
    $('.non-veg-item').fadeIn();
  }
});
/* Dips Toogle Content */

/* Deserts Toogle Content */
$('.desserts_nonveg').on('change', function(){
  if($(".desserts_nonveg:checked").length===1){
    $('.desserts_veg').prop('checked', false );
    $('#desserts .veg-item').fadeOut();
    $('#desserts .non-veg-item').fadeIn();
  } 
  if($(".desserts_nonveg:checked").length===0){
    $('.desserts_veg').prop('checked', false );
    $('#desserts .veg-item').fadeIn();
  }
  
});
$('.desserts_veg').on('change', function(){
  if($(".desserts_veg:checked").length===1){
    $('.desserts_nonveg').prop('checked', false );
    $('#desserts .non-veg-item').fadeOut();
    $('#desserts .veg-item').fadeIn();
  } 
  if($(".desserts_veg:checked").length===0){
    $('.desserts_nonveg').prop('checked', false );
    $('#desserts .non-veg-item').fadeIn();
  }
});
/* Deserts Toogle Content */




  $(".read_more").click(function() {  
      $(this).closest('.pizzaas-box').find(".more_text").fadeIn();
      $(this).closest('.pizzaas-box').find(".read_more").hide();
        $(this).closest('.pizzaas-box').find(".read_less").show();
      
      // setTimeout(function() { 
      //   $(this).closest('.pizzaas-box').find(".read_more").hide();
      //   $(this).closest('.pizzaas-box').find(".read_less").show();
      // }, 300);
  });
  $(".read_less").click(function() {  
      $(this).closest('.pizzaas-box').find(".more_text").fadeOut();
      $(this).closest('.pizzaas-box').find(".read_less").hide();
      $(this).closest('.pizzaas-box').find(".read_more").show();
  });

  let count_veg_non=0;
  var limitReached1='';


      /*limited select options */
      $(document).on("click", ".id-1-select", function(event){
        limitReached1 = $('.id-1-select:checked').length; 
        var item_id=$('.item-id').val(); 
        var type=$('.type'+item_id).val(); 
        let s1 = $(this).val();
        let s2 = s1.split('#');
        let i_id =  s2[2];
        let t_id = s2[1];

        if(!addons.includes(s2[0])){
          addons.push(s2[0]);
        }
        else{
          addons.splice(addons.indexOf(s2[0]), 1);
        }
        
        if(!veg_topping.includes(s2[0])){        //checking weather array contain the value
          //veg[i_id].push(s2[0]);               //adding to array because value doesnt exists
          veg_topping.push(s2[0]);
          let count_num1=1;
        count=count_num1+count;
        count_veg_non=count_veg_non+count_num1;

        $('.count-cust').text('+'+count+' add '+'on')
        addons1 = addons.toString();
        addons2 = addons1.replace(/,+/g,',');
          $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');
          $('.customize').text(addons2);

        }else{ 
          veg_topping.splice(veg_topping.indexOf(s2[0]), 1);
          let count_num1=1;
        count=count-count_num1;
        count_veg_non=count_veg_non-count_num1;

        $('.count-cust').text('+'+count+' add '+'on')
  // alert()
          $('.count'+t_id).text('VEG TOPPING ('+veg_topping.length+'/3)');
          addons1 = addons.toString();
        addons2 = addons1.replace(/,+/g,',');
          $('.customize').text(addons2);

            //deleting
        }
        // alert(addons2)
        if(count_veg_non<3){
      if(type=='veg'){
       // alert()
       
          $('.id-1-select').not(':checked').attr('disabled', false);
          $('.id-2-select').not(':checked').attr('disabled', true);
        }else if(type=='non-veg'){
          $('.id-1-select').not(':checked').attr('disabled', false);
          $('.id-2-select').not(':checked').attr('disabled', false);
        }
        else{
          $('.id-1-select').not(':checked').attr('disabled', false);
          $('.id-2-select').not(':checked').attr('disabled', false);
        }
      }else{
       // alert()
        
        // alert(count_veg_non)
        $('.id-1-select').not(':checked').attr('disabled', true);
        $('.id-2-select').not(':checked').attr('disabled', true);
        $('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.customize_err_message ').fadeOut(6000);
            }, 6000);  
      }
        // veg[i_id][t_id] = veg_topping[i_id];
        //$("#customization-value-"+i_id).val(veg[i_id]);
        //console.log(veg[i_id]);
        let p1 = $(".cbase").val();
        let p2 = p1.split('#');
        if(cbase!=''){
          cbase.pop();
          cbase.push(p2[0]);
        }else{
          cbase.pop();
          cbase.push(p2[0]);
        }
        p1 = $('input[name="sizes"]:checked').val();
        p2 = p1.split('#');
        if(sizeA!=''){
          sizeA.pop();
          sizeA.push(p2[0]);
          addons.push(sizeA[0]);
        }else{
          sizeA.pop();
          sizeA.push(p2[0]); 
        }
        let items=Array();
        
        items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
        // console.log(items);
        
          items1 = items.toString();
        items1 = items1.replace(/,+/g,',');
        items1 = items1.replace(/^,|,$/g,'');
        items1 = items1.split(",").join(", ");
        $('.customize').text(items1);
      });
      $(document).on("click", ".id-2-select", function(event){
        limitReached1= $('.id-2-select:checked').length ;  

        let p1 = $(this).val();
        let p2 = p1.split('#');
        let p3=p2[1];
        if(!addons.includes(p2[0])){
          addons.push(p2[0]);
        }
        else{
          addons.splice(addons.indexOf(p2[0]), 1);
        }
        if(!non_veg_topping.includes(p2[0])){          //checking weather array contain the value
          //veg[i_id].push(s2[0]);   
                      //adding to array because value doesnt exists
          non_veg_topping.push(p2[0]);
          let count_num1=1;
        count=count+count_num1;
        count_veg_non=count_veg_non+count_num1;

              $('.count-cust').text('+'+count+' add '+'on')
          $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

          $('.customize').text(addons);

      }else{ 
        non_veg_topping.splice(non_veg_topping.indexOf(p2[0]), 1);  //deleting
        let count_num1=1;
      count=count-count_num1;
      count_veg_non=count_veg_non-count_num1;
            $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

        $('.customize').text(addons);

      }
      if(count_veg_non>=3){
        $('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.customize_err_message ').fadeOut(6000);
            }, 6000); 
        $('.id-1-select').not(':checked').attr('disabled', true);
        $('.id-2-select').not(':checked').attr('disabled', true);
      }
      else{
       
        $('.id-1-select').not(':checked').attr('disabled', false);
        $('.id-2-select').not(':checked').attr('disabled', false);
       
      }
      //console.log(nveg);
      p1 = $(".cbase").val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      p1 = $('input[name="sizes"]:checked').val();
      p2 = p1.split('#');
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
      let items=Array();
      
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      // console.log(items);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
      $('.customize').text(items1);
    });
    $(document).on("click", ".id-3-select", function(event){
      var limitReached = $('.id-3-select:checked').length >= 3;   

      $('.id-3-select').not(':checked').attr('disabled', limitReached);
      if(limitReached==true){
        $('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.customize_err_message ').fadeOut(6000);
            }, 6000); 
      }
      let p1 = $(this).val();
      let p2 = p1.split('#');
      let p3=p2[1];

      if(!addons.includes(p2[0])){
        addons.push(p2[0]);
      }
      else{
        addons.splice(addons.indexOf(p2[0]), 1);
      }

      if(!flavor.includes(p2[0])){          //checking weather array contain the value
        flavor.push(p2[0]); 
       // $('.count-cust').text('+'+count+' add '+'on')
       let count_num1=1;
      count=count_num1+count;
      $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

       
        $('.customize').text(addons);
            //adding to array because value doesnt exists
      }else{
        let count_num1=1;
      count=count-count_num1;
      $('.count-cust').text('+'+count+' add '+'on')
        //$('.count-cust').text('+'+count+' add '+'on')
        flavor.splice(flavor.indexOf(p2[0]), 1);  
        $('.count'+p3).text('FLAVOUR BOOSTERS ('+flavor.length+'/3)');

        $('.customize').text(addons);
       
//deleting
      }
      p1 = $(".cbase").val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      p1 = $('input[name="sizes"]:checked').val();
      p2 = p1.split('#');
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
      let items=Array();
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      // console.log(items);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
      $('.customize').text(items1);
    });
    $(document).on("click", ".cbase", function(event){
      let p1 = $(this).val();
      let p2 = p1.split('#');
      if(cbase!=''){
        if(!addons.includes(cbase[0])){
          addons.push(cbase[0]);
        }
        else{
          addons.splice(addons.indexOf(cbase[0]), 1);
        }
        cbase.pop();
      cbase.push(p2[0]);

      }else{
        if(!addons.includes(cbase[0])){
          addons.push(cbase[0]);
        }
        else{
          addons.splice(addons.indexOf(cbase[0]), 1);
        }
        cbase.pop();
      cbase.push(p2[0]);
      addons.push(cbase[0]);
      count=count+1;

      }
      // if(!empty())
      // addons.push(cbase[0]);
      $('.count-cust').text('+'+count+' add '+'on');
      addons1 = addons.toString();
      addons2 = addons1.replace(/,+/g,',');
      $('.customize').text(addons2);
     
      p1 = $('input[name="sizes"]:checked').val();
      p2 = p1.split('#');
      if(sizeA!=''){
        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        sizeA.pop();
        sizeA.push(p2[0]); 
      }
      let items=Array();
      // console.log(items);
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
      $('.customize').text(items1);

    });
    
    $(document).on("click", ".csize", function(event){
      let p1 = $('input[name="sizes"]:checked').val();
      let size20 = $('input[name="sizes"]:checked').attr('data-price');
      $('#card-amount').html('₹'+size20)
      let p2 = p1.split('#');
      
      if(sizeA!=''){
        if(!addons.includes(sizeA[0])){
          addons.push(sizeA[0]);
        }
        else{
          addons.splice(addons.indexOf(sizeA[0]), 1);
        }

        sizeA.pop();
        sizeA.push(p2[0]);
        addons.push(sizeA[0]);
      }else{
        if(!addons.includes(sizeA[0])){
          addons.push(sizeA[0]);
        }
        else{
          addons.splice(addons.indexOf(sizeA[0]), 1);
        }

        sizeA.pop();
        sizeA.push(p2[0]);        
        addons.push(sizeA[0]);

        count=count+1;

      }
      $('.count-cust').text('+'+count+' add '+'on')
      $('.customize').text(addons);
      p1 =  $('input[name="cbase"]:checked').val();
      p2 = p1.split('#');
      if(cbase!=''){
        cbase.pop();
        cbase.push(p2[0]);
      }else{
        cbase.pop();
        cbase.push(p2[0]);
      }
      let items=Array();
      // console.log(items);
      items.push(veg_topping);items.push(non_veg_topping);items.push(flavor);items.push(cbase);items.push(sizeA);
      items1 = items.toString();
      items1 = items1.replace(/,+/g,',');
      items1 = items1.replace(/^,|,$/g,'');
      items1 = items1.split(",").join(", ");
      $('.customize').text(items1);
    });
   
   
    


function getValue(all,val) {
  var i=all.value;
  var price=$('.cost1'+i).attr('cost');
  var size=$('.cost1'+i).text();
  $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/getvaluesize')?>",
           data: {
            item_id:val,
            party_time:0,
            price:price, 
            size:size,
           },
           success: function (response)
           { 
            var resp = $.parseJSON(response);
            if(resp.quantity!=false){
              $('#price-id'+val).html('₹'+price);
              $('#item-id2'+val).val(size);
              $('#minus'+val).val(resp.quantity);
              document.getElementById('dec'+val).style.display='block';
               document.getElementById('add-cart'+val).style.display='none';
            }else{
              $('#price-id'+val).html('₹'+price);
              $('#item-id2'+val).val(size);
              document.getElementById('dec'+val).style.display='none';
              document.getElementById('add-cart'+val).style.display='block'; 
            }
      
        }
           });
  }


  let topping = [];
  let veg_topping = new Array();
    let non_veg_topping = new Array();
    let flavor = new Array();
    let cbase = new Array();
    let sizeA = new Array();
    let count=0;
    let addons=new Array();
    function getToppingdetails(item_id,item_name){ 
      veg_topping = new Array();
      non_veg_topping = new Array();
      flavor = new Array();
      cbase = new Array();
      sizeA = new Array();
      let selected_val=0;
      selected_val=$("#size_"+item_id).val(); 
      selected_val1=$("#base"+item_id).val(); 
     var type=($('.type'+item_id).val());
      $.ajax
           ({
           type: 'post',
           url:base_url+"getToppingModal",
           data: {item_id:item_id,item_name:item_name,selected_val:selected_val,selected_val1:selected_val1,type:type},
           success: function (response)
           {
             //console.log(response);
            $('#customizeModal').modal('show');  
            $("#toppingContent").html(response); 
            $("#card-amount").html($("#price-id"+item_id).html());
           }
        })
        
  }
  function getValue1(all,val,price1,fun) {
    if($('#card-amount').html()==undefined){
    var cost=$('#price-id'+val).text();
    var id1=cost.split('₹');
    var price=id1[1];
    var price2=parseInt(price);
    }else{
      var cost=$('#card-amount').html();
     // alert(cost)
      var id1=cost.split('₹');
    var price=id1[1];
    var price2=parseInt(price);
    }
    if(fun=='add'){
        let l=$(all).prev().val();
        var num=parseInt(l);
      num= num+1;
      var price=num*price2;
      var size=$('#item-id2'+val).val();
      var base=$('#base-id2'+val).val();

      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }
    $(all).prev().val(+$(all).prev().val() + 1);
    }else if(fun=='sub'){
     
      if ($(all).next().val() > 1){ 
        let l=$(all).next().val()
        var num=parseInt(l);
        num= num-1;
        var price=num*price2;
        var size=$('#item-id2'+val).val();
        var base=$('#base-id2'+val).val();

      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }

        $(all).next().val(+$(all).next().val() - 1);

      }
      else{
        var size=$('#item-id2'+val).val();
        var base=$('#base-id2'+val).val();

        var num=0;
        var size1=size;
    }
    }
    else{
      var num=1;
      var size=$('#item-id2'+val).val();
      var base=$('#base-id2'+val).val();
      if(size){
        var size1=size;
      }
      else{
        var size1=0;
      }

    }
    if(cbase.length==0){
      //  console.log(cbase)
        cbase.pop();
      cbase.push(base);
      count=count+1;
      addons.push(cbase);

      }
      if(sizeA.length==0){
       
        sizeA.pop();
        sizeA.push(size1);
     count=count+1;
     addons.push(sizeA);

     }
      $('.count-cust').text('+'+count+' add '+'on')
      $('.customize').text(addons);
    let temp = {"item_id":val,"veg":veg_topping,"nonveg":non_veg_topping,"flavor":flavor,"base":cbase,"size":sizeA};
    let temp1 = JSON.stringify(temp);
    // console.log(temp1)
      topping.push(temp);
      // console.log(temp)
    if(num!=0){
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/addtocart')?>",
           data: {
            item_id:val,
            price:price, 
            item_price:price2,
            party_time:0,
            base:base,
            num:num,
            size:size1,
            customization:temp1
           },
           success: function (response)
           { 
             veg_topping = new Array();
     non_veg_topping = new Array();
     flavor = new Array();
     cbase = new Array();
     sizeA = new Array();
     count_veg_non=0;
   limitReached1='';
             var resp = $.parseJSON(response);
             var items=resp.items;
             var cart_price=resp.price;
            document.getElementById('items-list').innerHTML=items+' ITEMS IN CART';

            // document.getElementById('cart-count').innerHTML=items;
            $('.cart-count1').html(items)
            document.getElementById('cart-price').innerHTML='₹'+cart_price;
             document.getElementById('fixed_bar').style.display='block';
           }
           });
    }
    else{
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/deletecart')?>",
           data: {
            item_id:val,
            price:price,
            size:size1, 
           },
           success: function (response)
           {

            if(response!=''){
              console.log(response)
             var resp = $.parseJSON(response);
             var items=resp.items;
             var cart_price=resp.price;
             if(cart_price!='' && items!=0){
            document.getElementById('items-list').innerHTML=items+' ITEMS IN CART';
            document.getElementById('cart-price').innerHTML='₹'+cart_price;
             document.getElementById('fixed_bar').style.display='block';
            // document.getElementById('cart-count').innerHTML=items;

             document.getElementById('add-cart'+val).style.display='block';
             document.getElementById('dec'+val).style.display='none';
            }
            else{
              document.getElementById('fixed_bar').style.display='none';
              document.getElementById('dec'+val).style.display='none';
              document.getElementById('add-cart'+val).style.display='block';

              $('.cart-count1').html(items);
            }
            }
            
           }
           
      });
     
      }
     
      $('#customizeModal').modal('hide');
      
  }

    $('.add-cart').click(function () {
      $(this).closest('.cost ').find(this).hide();
      $(this).closest('.cost ').find('.inc-dec').show();

    });

    $('.heart').click(function () {
      $(this).closest('.like-heart').find(this).hide();
      $(this).closest('.like-heart').find('.red-heart').show();
    });

    $('.red-heart').click(function () {
      $(this).closest('.like-heart').find(this).hide();
      $(this).closest('.like-heart').find('.heart').show();
    });

    function myFunction(user_id,item_id,val,operation){
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/favourite')?>",
           data: {
            user_id:user_id,
            item_id:item_id,
            val:val,
            operation:operation 
           },
           success: function (response)
           {
           }
           });
    }

function getcoupon(total_price,no_of_items){
      $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/cart1')?>",
           data: {
            total_price:total_price, 
            no_of_items:no_of_items,   
           },
           success: function (response)
           {
            if (response.status == "success"){
                window.location.href = "<?php echo base_url('website/cart')?>";
            }
           }
          });
    }    
     
    // var btnNames = {};
    // let veg = {};
    
 function ggffdfdfd(val,id){
  $('#base-id2'+id).val(val.value);
 }

 function getToppingId(id)
 {
   
  $(".list-group-item").removeClass("active");
  $(".topping"+id).addClass('active');
  /* 
   if(!$("#topping"+id))
   {

   }
  $(".list-group-item").removeClass("active");
  $("#topping"+id).addClass("active"); */
 }
 


  </script>

<script>     
var myhashvalue = window.location.hash;

//hash value like :  #access_token=463d3d40-bdbb-04f3-ddb2-c35e2bd9ffa8
//ajax call to send myhashvalue to server
</script> 
</body>
</html>