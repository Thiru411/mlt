<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
    <?php  $this->load->view('website/inc/scripts-top');?>
    <title>Favorities State</title>
    <style>
    .empty-state{padding:50px 0;}
    .emptystate-header{text-transform: uppercase;color: #5FC2AE;letter-spacing: 1px;line-height: 1.5;}
    .emptystate-text{line-height: 1.5;color: #FFFFFF;padding-bottom: 80px;}
    .emptystate-line{border: 1px solid #E0AF02;transform: rotate(90deg);width: 100%;max-width: 80px;margin: 0 auto;}
    .explore_btn{color: #000000;font-size: 16px;line-height: 1.25;background: #5FC2AE;border-radius: 8px;opacity: 0.8;padding: 14px 32px;margin-top:80px;border: 0;}
    
    </style>
</head>
<body>
    <div class="wrapper">
    <?php  $this->load->view('website/inc/header');?>
    <?php if($categoryTypeInfo!=false){ ?>
        <section class="mt-5">
            <div class="container">
            <?php
            foreach($categoryTypeInfo as $rows){
              if($rows['item_details']){
                $top='';
                foreach($rows['item_details'] as $info){  
                   $typed=$info['type'];
                  if($typed!='veg'){
                    $img='<img src="'.$admin_url.'assets/images/red-dot.png" alt="">';
                  }else{
                     $img='<img src="'.$admin_url.'assets/images/dot.png" alt="">';
                  }
                  //var_dump($info);  
                $slug=$info['slug']; 
                 $item_id=$info['item_id']; 
                $image_url=admin_img_url.'items/'.$info['image']; ?>
<input type="hidden" value="<?=$info['type']?>" class="type<?=$info['item_id']?>">
                <div class="media pizzaas-box position-relative">
                    <img class="pizza-banner img-fluid" src="<?=$image_url?>" alt="">
                    <div class="media-body pizza-details ">
                      <div class="d-flex ">
                        <div class="green-dot align-self-center pt-0"> <?=$img?></div>
                        <h5 class="fmg-maggi align-self-center"><?=$info['type']?> -
                          <span class="for-maggi align-self-center"><?=$info['item_name']?></span>
                        </h5>
          
                        <div class="like-heart ml-auto">
                  <?php if($user_id!=''){
                    if($info['favorites']==false){?>
                    <img class=" img-fluid  heart" src="<?=$admin_url?>assets/images/heart.png" alt="" onclick="myFunction(<?=$user_id?>,<?=$item_id?>,'<?=$info['slug']?>','add')" style='display:block'>
                    <?php } else{?>
                    <img class="img-fluid red-heart click-heart" src="<?=$admin_url?>assets/images/red-heart.png" onclick="myFunction(<?=$user_id?>,<?=$item_id?>,'<?=$info['slug']?>','delete')" alt=""style='display:block'>
                    <?php }} else{?>
                      <button class="btn btn_signin ml-4 " type="button" data-toggle="modal" data-target="#loginmodal"><img class=" img-fluid  heart" src="<?=$admin_url?>assets/images/heart.png" alt=""></button>
                      <?php }?>
                  </div>
                    </div>
                    <?php if(strlen($info['description'])<=190){?>
                <p class="bright mt-md-3 mt-2 "><?=$info['description']?>.</p>
                <?php }else{?>
                  <p class="bright mt-md-3 mt-2 ">
                    <span><?php echo substr($info['description'],0,161);?><span>
                    <span class="bright mt-md-3 mt-2 display_none more_text"><?php echo substr($info['description'],202,100000);?>.</span>
                    <span class="read_more">... Read More</span>
                    <span class="read_less"> Read Less</span>
                  </p>
                  <!-- <span class="bright mt-md-3 mt-2 "><?php echo substr($info['description'],192,100000);?>.</span> -->
                <?php }?>
                      <div class="mx-500">
                          <?php  if($slug=="pizzas"){?>
                        <div class="d-flex choose-it mt-md-4 ">
                          <div class="col-md-6 select-size">
                          <select class="selectpicker size-base size-selct size-base1" id="size_<?=$item_id?>"  onchange="getValue(this,<?=$item_id?>);" >
                        <?php if($info['price_drop']){
                            foreach($info['price_drop'] as $row3){?>
                            <option class='cost1<?=$row3->sk_id?>' cost='<?=$row3->item_cost?>' value='<?=$row3->sk_id?>'><?=$row3->item_size?></option>
                           <?php }}?>
                      </select>
                          </div>
                          <?php //var_dump($base_details); exit;?>
                          <div class="col-md-6 select-size">
                          <select class="selectpicker size-base size-base1" id="base_<?=$item_id?>"  onchange="ggffdfdfd(this,<?=$item_id?>);" >
                            <?php 
                            if($info['base_drop']){
                            foreach($info['base_drop'] as $row3){
                                     $item_topping=$row3->items;
                              $toppings=explode(',',$item_topping);
                            
                            if($toppings){
                              for($k=0;$k<count($toppings);$k++){ 
                              $top=$toppings[0];?>
                          <option class='cost1<?=$k?>'value='<?=$toppings[$k]?>'><?=$toppings[$k]?></option>
                          <?php }}}}?>
                            </select>
                          </div>

                        </div>
                          <?php }?>
                          <input type="hidden" id="item-id1" value="<?=$item_id?>">
                          <input type="hidden" id="base-id2<?=$item_id?>" value="<?=$top?>">

                          <input type="hidden" id="item-id2<?=$item_id?>" value="<?=$info['size']?>">
                  <div class="d-flex cost ">
                    <div>
                       
                       <h3 class="price" id="price-id<?=$item_id?>">₹<?=$info['price']?></h3>
                       <p class="taxes  ">Inclusive of customization, packaging, delivering & taxes</p>
                    </div>
                    <!-- <p class="taxes ml-md-2 mt-3">incl. taxes</p> -->
                      
                       <button class="default-btn fs-20 ml-auto add-cart position-relative" onclick="getValue1(this,<?=$item_id?>,<?=$info['price']?>,'')" id='add-cart<?=$item_id?>'>Add <div><img src="<?=$admin_url?>assets/images/plusss.png" class="img-fluid cart--pluse"></div></button>
                       <div class="add-sub inc-dec " id="dec<?=$item_id?>">
                         <div id="field1" class="field1 d-flex ml-4">
                           <button type="button" onclick="getValue1(this,<?=$item_id?>,<?=$info['price']?>,'sub')" id="sub" class="sub"><img src="<?=$admin_url?>assets/images/minus.png"></button>
                           <input type="number" id="minus<?=$item_id?>" class="num" value="1" min="1" max="10000" readonly>
                           <button type="button" id="add" class="add" onclick="getValue1(this,<?=$item_id?>,<?=$info['price']?>,'add')" ><img src="<?=$admin_url?>assets/images/plus.png"></button>
                         </div>
                       </div>
    
    
                  </div>
                       <?php if( $slug=='pizzas'){ ?>
                        <input type="hidden" class="priceId" value="<?=$item_id?>">
                        <button type="button" class=" default-btn custooo-mize" data-toggle="modal" data-target="#customizeModal" onclick="getToppingdetails(<?=$item_id?>,'<?=$info['item_name']?>')">
                    Customize
                  </button>
                        <?php } ?>
                     
                      </div>
                    </div>
                  </div>
                <?php }}} ?>

            </div>
        </section>
        <?php if($cart_price!=0){?>
      <div class="fixed_bar" id="fixed_bar"  style='display:block'>
        <div class="total-bill d-flex">
          <div>  
            <h5 class="total-cost fw-500" id="cart-price">₹<?=$cart_price;?></h5>
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
          <h5 class="total-cost fw-500" id="cart-price">₹<?=$cart_price;?></h5>
          <p class="two-items " id="items-list"><?=$items;?> Items in cart</p>
          </div>
          <a class="default-btn  view--cartt fw-600"  href="<?=$admin_url?>cart" >View Cart </a>
        </div>
      </div>
      <?php }?>
      
        <?php }else{ ?>
        <section class="empty-state">
            <div class="container">
                <div class="text-center">
                    <div class="img-fluid mb-4 pb-3"><img src="<?=$admin_url?>assets/images/fav truck.png" ></div>
                    <p class="emptystate-header fs-20 fw-600 mb-4">It’s Quite deserted here!</p>
                    <p class="emptystate-text fw-500 ">
                        You haven’t added any favourites yet.
                    </p>
                    <div class="emptystate-line ">

                    </div>
                    <a class="explore_btn fw-600" href="<?php base_url()?>menu">Explore Menu</a>
                </div>
            </div>
        </section>
        <?php }?>
        <span class=" stop-bar"></span>
        <section class="customize-page">
    <div class="modal fade" id="customizeModal" data-keyboard="false" tabindex="-1"
      aria-labelledby="customizeModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" id="toppingContent">
          
        </div>
      </div>
    </div>
  </section>

        <?php  $this->load->view('website/inc/footer');?>
   
    </div>
   

    <?php  $this->load->view('website/inc/scripts-bottom');?>
    <script>




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
        $('.customize_err_message').fadeIn()
        setTimeout(function(){
            $('.customize_err_message ').fadeOut(6000);
            }, 6000);  
        // alert(count_veg_non)
        $('.id-1-select').not(':checked').attr('disabled', true);
        $('.id-2-select').not(':checked').attr('disabled', true);

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
      $('.customize').text(items1);
    });
    $(document).on("click", ".id-3-select", function(event){
      var limitReached = $('.id-3-select:checked').length >= 3;   
      $('.id-3-select').not(':checked').attr('disabled', limitReached);
      if(limitReached){
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
      $('.customize').text(items1);

    });
    
    $(document).on("click", ".csize", function(event){
      let p1 = $('input[name="sizes"]:checked').val();
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
      $('.customize').text(items1);
    });
    
    let count=0;
    let addons=new Array();



function getValue(all,val) {
  var i=all.value;
  var price=$('.cost1'+i).attr('cost');
  var size=$('.cost1'+i).text();
  $('#price-id'+val).html('₹'+price);
  $('#item-id2'+val).val(size);
  $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/getvaluesize')?>",
           data: {
            item_id:val,
            price:price, 
            size:size,
            party_time:0,
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
  
  function getValue1(all,val,price1,fun) {
    var cost=$('#price-id'+val).text();
    var id1=cost.split('₹');
    var price=id1[1];
    var price2=parseInt(price);
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
             if(cart_price!='' && items!=''){
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
              document.getElementById('cart-count').innerHTML=items;

              document.getElementById('add-cart'+val).style.display='block';
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
            window.location.reload();
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
    let topping = [];
    let veg_topping = new Array();
    let non_veg_topping = new Array();
    let flavor = new Array();
    let cbase = new Array();
    let sizeA = new Array();
   
   //let count=0;
  
  //   function getToppingdetails(item_id,item_name){ 
  //     veg_topping = new Array();
  //     non_veg_topping = new Array();
  //     flavor = new Array();
  //     cbase = new Array();
  //     sizeA = new Array();
      
  //     let selected_val=0;
  //     selected_val=$("#size_"+item_id).val(); 
  //     $.ajax
  //          ({
  //          type: 'post',
  //          url:base_url+"getToppingModal",
  //          data: {item_id:item_id,item_name:item_name,selected_val:selected_val},
  //          success: function (response)
  //          {
            
  //           $('#customizeModal').modal('show');  
  //           $("#toppingContent").html(response); 
  //           $("#card-amount").html($("#price-id"+item_id).html());
  //          }
  //       })
        
  // }


  // function getToppingdetails(item_id,item_name){ 
  //     veg_topping = new Array();
  //     non_veg_topping = new Array();
  //     flavor = new Array();
  //     cbase = new Array();
  //     sizeA = new Array();
  //     let selected_val=0;
  //     selected_val=$("#size_"+item_id).val(); 
  //     let selected_val1=$("#base_"+item_id).val(); 
  //    var type=($('.type'+item_id).val());
  //     $.ajax
  //          ({
  //          type: 'post',
  //          url:base_url+"getToppingModal",
  //          data: {item_id:item_id,item_name:item_name,selected_val:selected_val,selected_val1:selected_val1,type:type},
  //          success: function (response)
  //          {
  //            //console.log(response);
  //           $('#customizeModal').modal('show');  
  //           $("#toppingContent").html(response); 
  //           $("#card-amount").html($("#price-id"+item_id).html());
  //          }
  //       })
        
  // }
  function addtocart(item_id){
    var toping_id=$('input[name="toping_name"]').val();
    //   $.ajax
    //        ({
    //        type: 'post',
    //        url:"<?php echo base_url('website/addcart')?>",
    //        data: {
    //         item_id:item_id, 
   
    //        },
    //        success: function (response)
    //        {
    //         alert(response);
    //         }
           
    //       });
    }    
 
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

</body>
</html>