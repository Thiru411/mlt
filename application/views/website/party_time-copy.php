<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />

<link rel="shortcut icon" href="<?=$admin_url?>/assets/images/logo.svg" />
<?php  $this->load->view('website/inc/scripts-top');?>
<title>Party-Time-Steps</title>

<style>
    
</style>
</head>

<body>
    <div class="wrapper ">
        <?php  $this->load->view('website/inc/header.php');?>
        <section class="birthday-event my-5 pb-md-3">
          <div class="container">
            <p class="order-summary fw-600 fs-18">Order Summary</p>
           <?= $output?>
          </div>
        </section>
              <?=$output1?>
        <?php  $this->load->view('website/inc/footer');?>
</div>
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


function elementReady(selector) {
return new Promise((resolve, reject) => {
const el = document.querySelector(selector);
if (el) { resolve(el); }
new MutationObserver((mutationRecords, observer) => {
// Query for elements matching the specified selector
Array.from(document.querySelectorAll(selector)).forEach((element) => {
resolve(element);
//Once we have resolved we don't need the observer anymore.
observer.disconnect();
});
})
.observe(document.documentElement, {
childList: true,
subtree: true
});
});
}
   
    function slide(next_count)
    {
      let full_count = $('#count').val();
      if(next_count<full_count){
      $('.section'+next_count).hide();
      let count_slides=next_count+1
      $('.section'+count_slides).show();
      }else{
        window.location.href='<?php echo $admin_url."party-time-pizza";?>';
      }
    }

   
//     $(".button_1").click(function(){
//       elementReady('#button_1').then(() => {
//  $('.section1').hide();
//         $('.section2').show();});
       
//      });
//      $(".button_2").click(function(){
       
//         $('.section2').hide();
//         $('.section3').show();
//      });

//      $(".button_3").click(function(){
//         $('.section3').hide();
//         $('.section4').show();
//      });
//      $(".button_4").click(function(){
//         $('.section4').hide();
//         $('.section5').show();
//      });
//      $(".button_5").click(function(){
//         $('.section5').hide();
//         $('.section6').show();
//      });
//      $(".button_6").click(function(){
//         $('.section6').hide();
//         $('.section7').show();
//      });

   
$('.pizza_nonveg').on('change', function(){
  if($(".pizza_nonveg:checked").length===1){
    $('.pizza_veg').prop('checked', false );
    $('.veg-item').fadeOut();
    $('.non-veg-item').fadeIn();
  } 
  if($(".pizza_nonveg:checked").length===0){
    $('.pizza_veg').prop('checked', false );
    $('.veg-item').fadeIn();
  }
  
});
$('.pizza_veg').on('change', function(){
  if($(".pizza_veg:checked").length===1){
    $('.pizza_nonveg').prop('checked', false );
    $('.non-veg-item').fadeOut();
    $('.veg-item').fadeIn();
  } 
  if($(".pizza_veg:checked").length===0){
    $('.pizza_nonveg').prop('checked', false );
    $('.non-veg-item').fadeIn();
    // $('.veg-item').fadeIn();
  }
});     

/* Sides Toogle Content */
$('.sides_nonveg').on('change', function(){
  if($(".sides_nonveg:checked").length===1){
    $('.sides_veg').prop('checked', false );
    $('.veg-item').fadeOut();
    $('.non-veg-item').fadeIn();
  } 
  if($(".sides_nonveg:checked").length===0){
    $('.sides_veg').prop('checked', false );
    $('.veg-item').fadeIn();
  }
  
});
$('.sides_veg').on('change', function(){
  if($(".sides_veg:checked").length===1){
    $('.sides_nonveg').prop('checked', false );
    $('.non-veg-item').fadeOut();
    $('.veg-item').fadeIn();
  } 
  if($(".sides_veg:checked").length===0){
    $('.sides_nonveg').prop('checked', false );
    $('.non-veg-item').fadeIn();
  }
});
/* Sides Toogle Content */

/* Salads Toogle Content */
$('.salads_nonveg').on('change', function(){
  if($(".salads_nonveg:checked").length===1){
    $('.salads_veg').prop('checked', false );
    $('.veg-item').fadeOut();
    $('.non-veg-item').fadeIn();
  } 
  if($(".salads_nonveg:checked").length===0){
    $('.salads_veg').prop('checked', false );
    $('.veg-item').fadeIn();
  }
  
});
$('.salads_veg').on('change', function(){
  if($(".salads_veg:checked").length===1){
    $('.salads_nonveg').prop('checked', false );
    $('.non-veg-item').fadeOut();
    $('.veg-item').fadeIn();
  } 
  if($(".salads_veg:checked").length===0){
    $('.salads_nonveg').prop('checked', false );
    $('.non-veg-item').fadeIn();
  }
});
/* Salads Toogle Content */

/* Dips Toogle Content */
$('.dips_nonveg').on('change', function(){
  if($(".dips_nonveg:checked").length===1){
    $('.dips_veg').prop('checked', false );
    $('.veg-item').fadeOut();
    $('.non-veg-item').fadeIn();
  } 
  if($(".dips_nonveg:checked").length===0){
    $('.dips_veg').prop('checked', false );
    $('.veg-item').fadeIn();
  }
  
});
$('.dips_veg').on('change', function(){
  if($(".dips_veg:checked").length===1){
    $('.dips_nonveg').prop('checked', false );
    $('.non-veg-item').fadeOut();
    $('.veg-item').fadeIn();
  } 
  if($(".dips_veg:checked").length===0){
    $('.dips_nonveg').prop('checked', false );
    $('.non-veg-item').fadeIn();
  }
});
/* Dips Toogle Content */

/* Deserts Toogle Content */
$('.deserts_nonveg').on('change', function(){
  if($(".deserts_nonveg:checked").length===1){
    $('.deserts_veg').prop('checked', false );
    $('.veg-item').fadeOut();
    $('.non-veg-item').fadeIn();
  } 
  if($(".deserts_nonveg:checked").length===0){
    $('.deserts_veg').prop('checked', false );
    $('.veg-item').fadeIn();
  }
  
});
$('.deserts_veg').on('change', function(){
  if($(".deserts_veg:checked").length===1){
    $('.deserts_nonveg').prop('checked', false );
    $('.non-veg-item').fadeOut();
    $('.veg-item').fadeIn();
  } 
  if($(".deserts_veg:checked").length===0){
    $('.deserts_nonveg').prop('checked', false );
    $('.non-veg-item').fadeIn();
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
        console.log(items);
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
      count_veg_non=count_veg_non+count_num1;
            $('.count-cust').text('+'+count+' add '+'on')
        $('.count'+p3).text('NON VEG TOPPING ('+non_veg_topping.length+'/3)');

        $('.customize').text(addons);

      }
      if(count_veg_non>=3){
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
            price:price, 
            size:size,
            party_time:1,
           },
           success: function (response)
           { 
            var resp = $.parseJSON(response);
            if(resp.quantity!=false){
              $('#price-id'+val).val(price);
              $('#item-id2'+val).val(size);
            //   $('#minus'+val).val(resp.quantity);
            //   document.getElementById('dec'+val).style.display='block';

               document.getElementById('add-cart'+val).style.display='none';
            }else{
              $('#price-id'+val).val(price);
              $('#item-id2'+val).val(size);
              // $('#minus'+val).val('1');
            //   document.getElementById('dec'+val).style.display='none';
            //   document.getElementById('add-cart'+val).style.display='block'; 
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
      var slug=$('.slug').val();
      selected_val1=$("#base"+item_id).val(); 
      $.ajax
           ({
           type: 'post',
           url:base_url+"getToppingModalpartytime",
           data: {slug:slug,item_id:item_id,item_name:item_name,selected_val:selected_val,selected_val1:selected_val1},
           success: function (response)
           {
            $('#customizeModal').modal('show');  
            $("#toppingContent").html(response); 
            $("#card-amount").html($("#price-id"+item_id).html());
           }
        });
        
  }
  let pizza_count=0;
  let salads_count=0;
  let sides_count=0;
  let dips_count=0;
  let desserts_count=0;
  let drinks_count=0;
  function getValue1(all,val,price1,m,fun) {
    var slug=$('.slug'+m).val();
    if(slug===undefined){
      slug=$('.slug').val();
    }
    if(slug=='pizzas'){
      let count_pizza=$('#pizza_no_id').val();
        if(fun=='add'){
          if(pizza_count<parseInt(count_pizza)){
          pizza_count=pizza_count+1;
          let pizzas=$('#no_of_pizza').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_pizza').text(symbol[0]+pizza_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(pizza_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}
    }else{
        return;
    }
    
        }else if(fun=='sub'){
          $('.cart'+slug).prop("disabled", false);
          if(pizza_count<=parseInt(count_pizza)){

          pizza_count=pizza_count-1;
          let pizzas=$('#no_of_pizza').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_pizza').text(symbol[0]+pizza_count+' '+pizza_list[1]+' '+pizza_list[2]);
      }

    }
        else{
          if(pizza_count<parseInt(count_pizza)){
          pizza_count=pizza_count+1;
          let pizzas=$('#no_of_pizza').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_pizza').text(symbol[0]+pizza_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(pizza_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}  
    }else{
        return;
    }
    }
    }   
      
    else if($('.slug'+m).val()=='salads'){
      let count_salads=$('#salads_no_id').val();
      if(fun=='add'){
        if(salads_count<parseInt(count_salads)){
          salads_count=salads_count+1;
      let salads=$('#no_of_salads').text();
      let pizza_list=salads.split(' ');
       let symbol=pizza_list[0].split('');
       $('#no_of_salads').text(symbol[0]+salads_count+' '+pizza_list[1]+' '+pizza_list[2]);
       if(salads_count==parseInt(count_salads)){
      $('.cart'+slug).attr("disabled", true)      
}  
      }else{
      return;
    }
      }else if(fun=='sub'){
        $('.cart'+slug).prop("disabled", false);

        if(salads_count<=parseInt(count_salads)){
          salads_count=salads_count-1;
      let salads=$('#no_of_salads').text();
      let pizza_list=salads.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_salads').text(symbol[0]+salads_count+' '+pizza_list[1]+' '+pizza_list[2]);
    }else{
      return;
    }
      }else{
        if(salads_count<parseInt(count_salads)){
          salads_count=salads_count+1;
      let salads=$('#no_of_salads').text();
      let pizza_list=salads.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_salads').text(symbol[0]+salads_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(salads_count==parseInt(count_salads)){
      $('.cart'+slug).attr("disabled", true)      
}  
    }else{
      return;
    }
      }
     
    }
    else if($('.slug'+m).val()=='sides'){
      let count_pizza=$('#sides_no_id').val();
     if(fun=='add'){
      if(sides_count<parseInt(count_pizza)){
        sides_count=sides_count+1;
      let pizzas=$('#no_of_sides').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_sides').text(symbol[0]+sides_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(sides_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}    
    }else{
        return;
      }
     }else if(fun=='sub'){
      $('.cart'+slug).prop("disabled", false);

      if(parseInt(sides_count)<=parseInt(count_pizza)){
        sides_count=sides_count-1;
      let pizzas=$('#no_of_sides').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_sides').text(symbol[0]+sides_count+' '+pizza_list[1]+' '+pizza_list[2]);
      }else{
        return;
      }
     }else{
      if(parseInt(sides_count)<=parseInt(count_pizza)){
        sides_count=sides_count+1;
      let pizzas=$('#no_of_sides').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_sides').text(symbol[0]+sides_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(sides_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}     
    }else{
        return;
      }
     }
      
    }
    else if($('.slug'+m).val()=='dips'){
      
      let count_pizza=$('#dips_no_id').val();
      if(fun=='add'){
        if(dips_count<parseInt(count_pizza)){
          dips_count=dips_count+1;
      let pizzas=$('#no_of_dips').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_dips').text(symbol[0]+dips_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(dips_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}    
    }else{
      return;
    }
      }else if(fun=='sub'){
        $('.cart'+slug).prop("disabled", false);

        if(dips_count<=parseInt(count_pizza)){
          dips_count=dips_count-1;
      let pizzas=$('#no_of_dips').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_dips').text(symbol[0]+dips_count+' '+pizza_list[1]+' '+pizza_list[2]);
    }else{
      return;
    }
      }else{
        if(dips_count<=parseInt(count_pizza)){
          dips_count=dips_count+1;
      let pizzas=$('#no_of_dips').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_dips').text(symbol[0]+dips_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(dips_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}    
    }else{
      return;
    }
      }
     
    }

    else if($('.slug'+m).val()=='desserts'){
      let count_pizza=$('#desserts_no_id').val();
      if(fun=='add'){
        if(desserts_count<parseInt(count_pizza)){
          desserts_count=desserts_count+1;

      let pizzas=$('#no_of_desserts').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_desserts').text(symbol[0]+desserts_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(desserts_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}    
    }else{
        return;
    }
      }else if(fun=='sub'){
        $('.cart'+slug).prop("disabled", false);

        if(desserts_count<=parseInt(count_pizza)){
          desserts_count=desserts_count-1;

      let pizzas=$('#no_of_desserts').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_desserts').text(symbol[0]+desserts_count+' '+pizza_list[1]+' '+pizza_list[2]);
    }else{
        return;
    }
      }else{
        if(desserts_count<=parseInt(count_pizza)){
          desserts_count=desserts_count+1;

      let pizzas=$('#no_of_desserts').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_desserts').text(symbol[0]+desserts_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(desserts_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}    
    }else{
        return;
    }
      }
     
    }
    else{
      let count_pizza=$('#drinks_no_id').val();
      if(fun=='add'){
        if(drinks_count<parseInt(count_pizza)){
          drinks_count=drinks_count+1;

      let pizzas=$('#no_of_drinks').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_drinks').text(symbol[0]+drinks_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(drinks_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}    
    }else{
return;
    }
      }else if(fun=='sub'){
        $('.cart'+slug).prop("disabled", false);
        if(drinks_count<=parseInt(count_pizza)){
          drinks_count=drinks_count-1;
      let pizzas=$('#no_of_drinks').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_drinks').text(symbol[0]+drinks_count+' '+pizza_list[1]+' '+pizza_list[2]);
    }else{
return;
    }
      }else{
        if(drinks_count<=parseInt(count_pizza)){
          drinks_count=drinks_count+1;
      let pizzas=$('#no_of_drinks').text();
      let pizza_list=pizzas.split(' ');
       let symbol=pizza_list[0].split('');
      $('#no_of_drinks').text(symbol[0]+drinks_count+' '+pizza_list[1]+' '+pizza_list[2]);
      if(drinks_count==parseInt(count_pizza)){
      $('.cart'+slug).attr("disabled", true)      
}    
    }else{
return;
    }
      }
      
    }
    var price=$('#price-id'+val).val();
    var price2=price;
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
      // console.log(cbase)
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

     }  $('.count-cust').text('+'+count+' add '+'on')
      $('.customize').text(addons);
    let temp = {"item_id":val,"veg":veg_topping,"nonveg":non_veg_topping,"flavor":flavor,"base":cbase,"size":sizeA};
    let temp1 = JSON.stringify(temp);
      topping.push(temp);
    if(num!=0){
    $.ajax
           ({
           type: 'post',
           url:"<?php echo base_url('website/addtocart')?>",
           data: {
            item_id:val,
            price:price, 
            item_price:price2,
            base:base,
            num:num,
            party_time:1,
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

            // document.getElementById('items-list').innerHTML=items+' ITEMS IN CART';
            // document.getElementById('cart-count').innerHTML=items;
            // document.getElementById('cart-price').innerHTML='₹'+cart_price;
            // document.getElementById('fixed_bar').style.display='block';
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
            party_time:1,
           },
           success: function (response)
           {

            if(response!=''){
             var resp = $.parseJSON(response);
             var items=resp.items;
             var cart_price=resp.price;
             if(cart_price!='' && items!=''){
            // document.getElementById('items-list').innerHTML=items+' ITEMS IN CART';
            // document.getElementById('cart-price').innerHTML='₹'+cart_price;
            //  document.getElementById('fixed_bar').style.display='block';
            //  document.getElementById('cart-count').innerHTML=items;

             document.getElementById('add-cart'+val).style.display='block';
             document.getElementById('dec'+val).style.display='none';
            }
            else{
              // document.getElementById('fixed_bar').style.display='none';
                            document.getElementById('add-cart'+val).style.display='block';

              document.getElementById('dec'+val).style.display='none';
              // document.getElementById('cart-count').innerHTML=items;

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