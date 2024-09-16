<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Website extends CI_Controller { 

    var $data = array();
    
    public $CI = NULL; 
    public function __construct(){
        parent::__construct();
        $this->load->model('CommonModel','cm',TRUE);
        $this->load->model('AdminModel','am',TRUE);
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('common');

        $this->CI = & get_instance();
        
    }
    /* ====================Common Data==================== */
    public function common_data()
    {
        $data["admin_url"] = base_url();
         $admin_url=base_url();
       $data['menu_active']='';
        date_default_timezone_set('Asia/Kolkata');
        $post_date = date('Y-m-d');
        $timestamp = date("Y-m-d H:i:s");
        
        $time = date("H:i:s");
        $data["post_date"] = $post_date;
        $data["timestamp"] = $timestamp;
        $data["time"] = $time;
        $data['user_id']='';
        $data['order_id']='';
        $data['fullname']='';
        $data['mobile']='';
        $data['email']='';
        $data['temporary_session_id']='';
        $data['cart_count']=0;
        $data['city']='';
        $data['town']='';
        $data['pincode']='';
        $data['longitude']='';
        $data['latitude']='';
        $data['referal_code']='';
        // $data['city']=$this->session->set_userdata('city','Gurgaon');
      

       if($this->session->userdata('city')!=''){
         $data['city']=$this->session->userdata('city');
        $data['town']=$this->session->userdata('town');
        $data['pincode']=$this->session->userdata('pincode');
        $data['latitude']=$this->session->userdata('latitude');
        $data['longitude']=$this->session->userdata('longitude');


         }else{
          $data['city']=$this->session->set_userdata('city','Gurgaon');
          $data['town']=$this->session->set_userdata('town','Gurgaon');
          $data['pincode']=$this->session->set_userdata('pincode','110038');
          $data['latitude']=$this->session->set_userdata('latitude','15.1540004');
          $data['longitude']=$this->session->set_userdata('longitude','76.9087961');
          $data['city']=$this->session->userdata('city');
          $data['town']=$this->session->userdata('town');
          $data['pincode']=$this->session->userdata('pincode');
          $data['latitude']=$this->session->userdata('latitude');
          $data['longitude']=$this->session->userdata('longitude');
  

        }
        $data['user_id']=$this->session->userdata('user_id');
        $data['order_id']=$this->session->userdata('order_id');

        $data['referal_code']=$this->session->userdata('referal_code'); 

         $data['temporary_session_id']=$this->session->userdata('temporary_session_id'); 
        $data['fullname']=$this->session->userdata('fullname');
       $data['mobile']=$this->session->userdata('mobile');
       $data['email']=$this->session->userdata('email');
          $data['cart_count']=$this->session->userdata('cart_count');
        return $data;
    }
    function createTempSession() {
        $randomString = mt_rand(1000000,9999000);
        return $randomString;
    }

    public function e(){
      $data=$this->common_data();
      $id = $this->uri->segment(2);
       $user_id_split= explode('referafriend',$id);
      $user_id = $user_id_split['1'];

          $data['referal_code']=$this->session->set_userdata('referal_code',$user_id);
      
      redirect('/'); 
    }

	public function index(){
        $data=$this->common_data();
         $data['referal_code'];
         $data['rating']=10;
        if($data['user_id']!=''){
        $where=array();
        $rating='';
        $ratings=$this->cm->getRecords(array('user_id'=>$data['user_id'],'rating_order_id'=>''),'mlt_rating');
        if($ratings!=false){
          foreach($ratings as $info){
             $rating=$info->rating;
          }
        }
      $data['rating']=$rating;
        $data['categoryimage']=$this->cm->getRecords($where,'mst_categoryitems');
        
        $this->load->view('website/index',$data);
       }else{
        $where=array();
        $data['categoryimage']=$this->cm->getRecords($where,'mst_categoryitems');
     
        $this->load->view('website/index',$data);  
       }
	//}
}

    /*****************************************signin************************/
    public function signin(){
        $data=$this->common_data();
      $otp=false;
      $response=false;

         $mobile=$this->input->post('mobile');
        //if($mobile!=''){
            //$mobile='+91'.$mobile;
            $where=array('mobile'=>$mobile,'user_status'=>1);
            $userDetails=$this->cm->getRecords($where,'mst_user');
            if($userDetails!=false){
                foreach($userDetails as $info){
                    $userId=$info->sk_user_id;
                    $fullName=$info->full_name;
                }
                $otp = mt_rand(1000,9999);
                $update_data=array(
                    "otp"=>$otp);
                    $where=array('sk_user_id'=>$userId);
                    $this->cm->updateRecords($update_data,$where,'mst_user');
                foreach($userDetails as $info){
                    $user_id=$info->sk_user_id;
                   $fullname=$info->full_name;
                   $mobile=$info->mobile;
                   $email=$info->email;
               }
               $response=$this->sendsms($mobile,$otp,$fullname);
               $decodejson=json_decode($response);
                if($decodejson->status=="success"){
                   echo json_encode(array('otp'=>true));
                }
                }
                else{
                    echo json_encode(array('otp'=>false));

                }
    }
    /*****************************************signin************************/

    public function sendsms($number,$otp,$name){
		
      // Account details
      $apiKey = urlencode('ZTUxYWEzMTBhNmI3NzI5NTVlYmFjNTg0YzBkODM5MjQ=');
      
      // Message details
      $numbers = array($number);
      $sender = urlencode('MYLVTG');
        
      $message = rawurlencode('Welcome back  '.$name.'! your OTP for signing in is '.$otp.'. Have a great day! Team MLT');
     
      $numbers = implode(',', $numbers);
     
      // Prepare data for POST request
      $data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
     
      // Send the POST request with cURL
      $ch = curl_init('https://api.textlocal.in/send/');
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($ch);
      curl_close($ch);
      
      // Process your response here
      return $response;
      }
    /******************************signup****************************************/
    public function signup(){
        $data=$this->common_data();
         $name=$this->input->post('name');
         $email=$this->input->post('email');
         $mobile=$this->input->post('mobile');
         $mobile1=$this->input->post('mobile1');
         $otp=false;
         $where=array('mobile'=>$mobile1,'user_status'=>0);
         $existingUser=$this->cm->getRecords($where,'mst_user');
        if($existingUser!=false){
            $otp = mt_rand(1000,9999);
            $update_data=array(
                'full_name'=>$name,
                'email'=>$email,
                'mobile'=>$mobile,
                'otp'=>$otp,
                'signup_date'=>$data['post_date'],
                'user_status'=>0
            );
            $where=array('mobile'=>$mobile1);
            $this->cm->updateRecords($update_data,$where,'mst_user');
            echo json_encode(array('otp'=>$otp));;
        }else{
         $otp = mt_rand(1000,9999);
         if($name!='' && $email!='' && $mobile!='' && $otp!=''){
             $where=array('mobile'=>$mobile,'user_status'=>1);
             $existingUser=$this->cm->getRecords($where,'mst_user');
             if($existingUser==false){
             $data_array=array(
                 'full_name'=>$name,
                 'email'=>$email,
                 'mobile'=>$mobile,
                 'otp'=>$otp,
                 'signup_date'=>$data['post_date'],
                 'user_status'=>0
             );
             $user_id=$this->cm->save($data_array,'mst_user');
             if($user_id){
              $response=$this->sendsms($mobile,$otp,$name);
              $decodejson=json_decode($response);
               if($decodejson->status=="success"){
                 echo json_encode(array('otp'=>true));;
             }
            }
           }
           else{
            echo json_encode(array('otp'=>false));;
        }
         }
        }

    }
    /******************************signup****************************************/
/****************************otp verification**************************************/
    public function otp_verification(){
        $data=$this->common_data();
        $otp=$this->input->post('otp');
        $mobile=$this->input->post('mobile');
        $where=array('mobile'=>$mobile,'otp'=>$otp);
        $otp_verification=$this->cm->getRecords($where,'mst_user');
        if($otp_verification!=false){
            $where=array('mobile'=>$mobile);
            $data_array=array('user_status'=>1);
            $this->cm->updateRecords($data_array,$where,'mst_user');
            
            foreach($otp_verification as $info){
                 $user_id=$info->sk_user_id;
                $fullname=$info->full_name;
                $mobile=$info->mobile;
                $email=$info->email;

            }
           
            $this->session->set_userdata('user_id',$user_id);
            $this->session->set_userdata('fullname',$fullname);
            $this->session->set_userdata('mobile',$mobile);
            $this->session->set_userdata('email',$email);
            $data['user_id']=$this->session->userdata('user_id'); 
            $data['fullname']=$this->session->userdata('fullname');
           $data['mobile']=$this->session->userdata('mobile');
           $data['email']=$this->session->userdata('email');
          $where=array('cuser_id'=>$data['temporary_session_id']);
          $data=array('cuser_id'=>$data['user_id']);
          $this->cm->updateRecords($data,$where,'mlt_cart');
          $this->session->set_userdata('temporary_session_id','');
          $data['temporary_session_id']=$this->session->userdata('temporary_session_id');
          $where=array('cuser_id'=>$user_id,'party_time'=>0);
          $cart_details=$this->cm->getRecords($where,'mlt_cart');        
          $cart_data=array();
          $cart_price=$i=0;

          if($cart_details!=false){
              foreach($cart_details as $info){
                  $cart_price=$cart_price+$info->price;
                  $i++;
              }  
          }   
           $this->session->set_userdata('cart_count',$i);
          $data['cart_count']=$this->session->userdata('cart_count'); 

            echo json_encode(array('output'=>'true'));
        }
        else{
            echo json_encode(array('output'=>'false'));
        }
    }
/****************************otp verification**************************************/
/*****************************************resend otp*************************/
    public function resendotp(){
        $data=$this->common_data();
        $mobile=$this->input->post('mobile');
        $otp = mt_rand(1000,9999);
                $update_data=array(
                    "otp"=>$otp);
                    $where=array('mobile'=>$mobile);
                $this->cm->updateRecords($update_data,$where,'mst_user');
                $details=$this->cm->getRecords($where,'mst_user');
                if($details!=false){
                  foreach($details as $info){
                    $mobile=$info->mobile;
                    $otp=$info->otp;
                    $fullname=$info->full_name;
                  }
                $response=$this->sendsms($mobile,$otp,$fullname);
                //var_dump($response);exit();
                $decodejson=json_decode($response);
                 if($decodejson->status=="success"){
                echo json_encode(array('otp'=>true));
                 }
                }else{
                  echo json_encode(array('otp'=>false));
                 }
    }
/*****************************************resend otp*************************/

    public function logout(){
        $data=$this->common_data();

        //echo "fgfdfdfd"; exit;
        
        session_destroy();
       $this->session->userdata('name');
        // var_dump($_SERVER['HTTP_COOKIE']);exit();
        // unset cookies
      //  var_dump($_SERVER['HTTP_COOKIE']);

        if (isset($_SERVER['HTTP_COOKIE'])) {
          $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
          foreach($cookies as $cookie) {
              $parts = explode('=', $cookie);
              $name = trim($parts[0]);
              //unset($name);
             // setcookie($name, '', time()-1000);
              setcookie($name, '', time()-1000, '/');
          }
        }

        //$this->load->view('/',$data);
        redirect('/');
    }


    public function menu() {
        $data=$this->common_data();
        
        $slug='';
            if(isset($_GET['p'])){
          $slug=$_GET['p'];
            }
        $categoryDetails=$categoryIdDetails=$categoryid='';$items['price']='';
        $where=array('Items_categorystatus'=>1);
        $category_details1=$this->cm->getRecords($where,'mst_categoryitems');
        if($slug==''){
        $slug=$category_details1[0]->category_slug;
        }
        if($data['user_id']!=''){
          $user_id=$data['user_id'];
      }else{
          $user_id=$data['temporary_session_id'];
      }
        $where1=array('cuser_id'=>$user_id,'party_time'=>0);
        $cart_details=$this->cm->getRecords($where1,'mlt_cart');        
        $cart_data=array();
        $cart_price=$i=0;
        $quantity='';
        if($cart_details){
            foreach($cart_details as $info){
                $quantity=$info->quantity;
                $cart_price=$cart_price+$info->price;
                $i++;
            }  
        } 
        $data['quantity']  =$quantity;
        $data['cart_price']=$cart_price;   
        $data['items']=$i;
        if($category_details1){
           // $categoryTypeInfo=array();

            foreach($category_details1 as $info)
    {
                $categoryTypeInfo=array();
                $categoryTypeInfo['category_id']=$info->sk_categoryItems_id;
                $category_id=$categoryTypeInfo['category_id'];
                $categoryTypeInfo['slug']=$info->category_slug;
                $categoryTypeInfo['image']=$info->category_image;
                $categoryTypeInfo['captions']=$info->caption;
                $categoryTypeInfo['category_type']=$info->Items_categoryname;
                $categoryTypeInfo['item_details']='';

        $sql="SELECT mst_categoryitems.Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems.category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type,mlt_items_onboarding.slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id WHERE category_id=$category_id and item_onboarding_status=1";
        $binds="";
        $category_details=$this->cm->getRecordsQuery($sql, $binds);
        if ($category_details!=false) {
            $temp2=array();
            $temp=array();
            foreach ($category_details as $info) {

                $items=array();
                $quantity=0;
                $items['item_name']=$info->item_name;
                $items['item_id']=$info->sk_id;
                $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                
                $price_details=$this->cm->getRecords($where,'mlt_price');
                $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                $where=array('citem_id'=>$info->sk_id,'cuser_id'=>$data['user_id'],'party_time'=>0);
                $cart_details=$this->cm->getRecords($where,'mlt_cart');
                $where=array('item_id'=>$info->sk_id,'user_id'=>$data['user_id']);
                $items['favorites']=$this->cm->getRecords($where,'mst_favourite');
                $items['cart_details']=$cart_details;
                if($price_details){
                    foreach($price_details as $row3){
                         $price=$price_details[0]->item_cost;
                         $item_size=$price_details[0]->item_size;
                    }
                }
                
                 $items['price']=$price;
                 $items['size']=$item_size;
                 if($data['user_id']!=''){
                   $user_id=$data['user_id'];
                 }else{
                  $user_id=$data['temporary_session_id'];

                 }
                 $where10=array('citem_id'=>$info->sk_id,'party_time'=>0,'item_size'=>$item_size,'cuser_id'=>$user_id);
                 $cart_details=$this->cm->getRecords($where10,'mlt_cart');
                 if($cart_details!=false){
                  $quantity=$cart_details[0]->quantity;
                 }
                 $items['quantity']=$quantity;
                $items['base_drop']=$base_details;
                $items['price_drop']=$price_details;
                $items['image']=$info->image;
                $items['display_name']=$info->display_name;
                $items['item_status']=$info->item_onboarding_status;
                $items['description']=$info->description;
                $items['short_description']=$info->short_description;
                $items['slug1']=$info->slug;
                $items['type']=$info->type;
                $items['seo_description']=$info->seo_description;
                $items['seo_title']=$info->seo_title;
                $items['short_description']=$info->description;
                $items['type']=$info->type;
                $items['section_name']=$info->section_name;
                $temp[]=$items;
            }
            $categoryTypeInfo['item_details']=$temp;

        }
        $temp5[]=$categoryTypeInfo;
        $data['menu_active']=$slug;
        $data['category_details']=$temp5;
    }


}

      $data['topping_head_details']="";
      $where=array('toping_status'=>1);
      $data['topping_head_details']=$this->cm->getRecords($where,'mlt_topings'); 
              $this->load->view('website/listing', $data);
          }
    function toppingDetails($item_id,$toppingid)
    {
       // $item_id=20;$toppingid=1;
        $topping_item_details="";
        $where=array('item_id'=>$item_id,"topping_id"=>$toppingid);
        $topping_item_details=$this->cm->getRecords($where,'mlt_item_toppings'); 
        return $topping_item_details;
    }

    public function getToppingModal()
    {
      $cust_img=base_url()."assets/images/cust.png";

        $output="";
        $cancel_img=$uparr_img=$mgrimg="";
        $cancel_img=base_url()."assets/images/cancel.png";
        $mgrimg=base_url()."assets/images/mgrimg.png";
        $uparr_img=base_url()."assets/images/uparr.png";
        $item_id=$this->input->post('item_id');
        $item_name=$this->input->post('item_name');
        
        $selected_val=$this->input->post('selected_val');
        $type=$this->input->post('type');
        $selected_val1=$this->input->post('selected_val1');
        $where=array('sk_id'=>$item_id);
        $item_onboard_details=$this->cm->getRecords($where,'mlt_items_onboarding');
        if($item_onboard_details!=false){
            foreach($item_onboard_details as $info9){
                $item_display_name=$info9->display_name;
                $type1=$info9->type;

            }
        }
        if($type1!='veg'){
          $img='<img src='.base_url().'/assets/images/red-dot.png class="img-fluid lia-img">';

        }else{
          $img='<img src='.base_url().'/assets/images/dot.png class="img-fluid lia-img">';
        }
        $topping_size_details="";
    $where=array('item_id'=>$item_id,'item_status'=>1);
    $topping_size_details=$this->cm->getRecords($where,'mlt_price');
    $size_details="";$output6='';
    if($topping_size_details)
    {
        $k=1;
        foreach($topping_size_details as $size_info)
        {
          
            if($selected_val==$size_info->sk_id){
              $selected="checked";
              $output6=$size_info->item_size.'₹'.$size_info->item_cost;
            }else{
              $selected="";
            }
            $size_details=$size_details."<div class='col-md-6'>
            <div class='custom-control custom-radio  mb-3'>
                      <input type='radio' data-price='$size_info->item_cost' id='size$k' name='sizes' value='$size_info->item_size#$item_id' class='custom-control-input csize' $selected>
                      <label class='custom-control-label ml-2' for='size$k'>$size_info->item_size 
                        ₹$size_info->item_cost</label> 
                        </div></div>";
                        $k++;
        }
    }
    
    /* $topping_head_details="";
    $where=array('toping_status'=>1);
    $topping_head_details=$this->cm->getRecords($where,'mlt_topings'); */

$sql="SELECT DISTINCT(mlt_item_toppings.topping_id) as toping_id,mlt_topings.toping_head FROM mlt_item_toppings,mlt_topings WHERE mlt_item_toppings.item_id=$item_id and mlt_item_toppings.topping_id=mlt_topings.toping_id and mlt_topings.toping_status=1";
$binds="";
$topping_head_details=$this->cm->getRecordsQuery($sql, $binds);

$toppingHead="";

  $i=1;if($topping_head_details){foreach($topping_head_details as $tinfo){ 
    if($i==1){$menu_active='active';}else{$menu_active='';} 
    $menuClass="topping".$i;    
    $toppingHead=$toppingHead."<li><a class='list-group-item list-group-item-action $menu_active $menuClass'   href='#topping$i' onclick='getToppingId($tinfo->toping_id)'>$tinfo->toping_head</a></li>";
      $i++;}}  
      $menuSizeClass="topping".($i);
      $menuClick=" onclick='getToppingId($i)'";
      $toppingDetails="";$toppingDetails1="";
    $j=1;if($topping_head_details){foreach($topping_head_details as $tp_info){  
        $where=array('item_id'=>$item_id,"topping_id"=>$tp_info->toping_id);
        $topping_item_details=$this->cm->getRecords($where,'mlt_item_toppings'); 
        if($topping_item_details){

$item_details="";$p=1;
$selected10='';
              foreach($topping_item_details as $tpitem){ $toppingItem=rtrim($tpitem->items,',');  
                $empty_cart_id = '';                  
                $tmp=explode(',',$toppingItem);                                   
                for($k=0;$k<sizeof($tmp);$k++){
                 if($tmp[$k]!='') {
                     if($tpitem->topping_id!=4) {
                      if($type=='veg' && $tpitem->topping_id==2){
                         $selected10='disabled';
                      }
                $item_details=$item_details."<div class='col-md-6'>
                <div class='custom-control custom-checkbox mb-3'>
                <input type='hidden' value='$item_id' class='item-id'>
                  <input type='checkbox' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='$tp_info->toping_head custom-control-input id-$tpitem->topping_id-select sjhd' id='customCheck$tp_info->toping_id$p' $selected10>
                  <label class='custom-control-label pl-2' for='customCheck$tp_info->toping_id$p' $selected>$tmp[$k]</label>
                </div>
                </div>";
                     }
                     else{
                        if($selected_val1==$tmp[$k]){$selected="checked";}else{$selected="";}
                        $item_details=$item_details."<div class='col-md-6'>
                        <div class='custom-control custom-radio  mb-3'>
                                  <input type='radio' id='cbase$p' name='cbase' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='custom-control-input cbase'$selected>
                                  <label class='custom-control-label pl-2' for='cbase$p'>$tmp[$k]</label> 
                                    </div></div>";
                     }
                 }
                  $p++;}}   
$output='';

                  if($tp_info->toping_head!='Base'){
                    $output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head (0/3)</div>
                    <div class='vegcontent'>You can choose upto 3 options</div>";
                    } else{$output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head</div>
                      <div class='vegcontent'>You can choose only 1 option</div>";
                    }
      $toppingDetails=$toppingDetails."<div class='card mb-4' id='topping$j'>
        <div class='card-header' id='heading$j'>
          <h2 class='mb-0'>
            <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
              data-target='#collapse$j' aria-expanded='true' aria-controls='collapse$j'>
              <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
              </div>
              $output
            </button>
          </h2>
        </div>
        <div id='collapse$j' class='collapse show' aria-labelledby='heading$j'
          data-parent='#accordionExample'>
          <div class='card-body row topping-list'>    
            $item_details 
          </div>
        </div>
      </div>"; 
      }$j++;}} 
 

      $toppingDetails1=$toppingDetails1."<div class='card mb-4' id='size'>
        <div class='card-header' id='headingOne'>
          <h2 class='mb-0'>
            <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
              data-target='#collapse5' aria-expanded='true' aria-controls='collapse5'>
              <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
              </div>
              <div class='vegtext'>Size</div> 
            </button>
          </h2>
        </div>
        <div id='collapse5' class='collapse show' aria-labelledby='heading5'
          data-parent='#accordionExample'>
          <div class='card-body row topping-list'> $size_details 
          </div>
        </div>
      </div>"; 
      

    
      $output6=$selected_val1.' ,'.$output6;

     
      $output="<div class='modal-body'>
      <button type='button' class='close ' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'><div><img class='img-fluid ' src='$cancel_img' alt=''></div></span>
      </button>
      <div class=' d-flex mgr-path ss'>
        <div>$img</div>
        <h1 class='pizza-header mb-4 pl-2'><span class='pizzaheader-mgr'>$item_display_name - $item_name</span>
        </h1>
       
      </div>
      <div class='mgr-line'></div>
      <div class='Customization-text mt-4' >Customization <div class='customize_err_message' style='display:none'> <div class='d-flex'>
      <img class='' src='$cust_img'>
      <p class='ml-md-2 align-self-center'><span class='fw-500'>OOPS!</span>You’ve chosen maximum of 3 options</p>
  </div></div></div>
      
      <div id='navbar-example2'>
        <div class='tabs-scroll'>
        <ul id='list-example' class=' customize-list d-flex mt-3'>
          $toppingHead
            <li><a class='list-group-item list-group-item-action $menuSizeClass' href='#size' $menuClick>Size</a></li> 
        </ul>
      </div>
      </div>
      <div class='customize-scroll accordion scrolling-bar custom-scrollbar' id='accordionExample' data-spy='scroll'
        data-target='#navbar-example2' data-offset='0'>
        $toppingDetails 
        $toppingDetails1
      </div>
    </div>
    
    <div class=' add-card'>
      <div class='d-flex addcard'>
        <div class='mx-222 mt-3'>
                <div class='customize coustamize_selected'>$output6</div>

          <div class='card-amount mb-1' id='card-amount'>₹$size_info->item_cost</div>
          <div class='card-cust'>CUSTOMIZED</div>
        </div>
        <input type='hidden' id='ccart_id'/>
        <input type='hidden' id='cart_size'/>
        <div class='ml-auto align-self-center'>
        <div class='count-cust '></div>
        <button class='addcard-item ml-auto ' onclick=getValue1(this,$item_id,$size_info->item_cost,-1,'update')>Add to Cart</button></div>
      </div>
    </div>";

    echo $output;
    }


    public function getToppingModalcoupon()
    {
      
        $data=$this->common_data();
        if($data['user_id']!=''){
            $user_id=$data['user_id'];
        }else{
            $user_id=$data['temporary_session_id'];
        }
        $output="";$output20=$output21=array();
        $cancel_img=$uparr_img=$mgrimg="";
        $cancel_img=base_url()."assets/images/cancel.png";
        $mgrimg=base_url()."assets/images/mgrimg.png";
        $uparr_img=base_url()."assets/images/uparr.png";
       $cust_img=base_url()."assets/images/cust.png";

       // $image=$admin_url."assets/images/cust.png";
$output13='';
        $item_id=$this->input->post('item_id');
        $item_name=$this->input->post('item_name');
          $selected_val=$this->input->post('selected_val');
        $selected_val1=$this->input->post('selected_val1');
        $where=array('cuser_id'=>$user_id,'citem_id'=>$item_id,'item_size'=>$selected_val,'party_time'=>0);
        $cart_details=$this->cm->getRecords($where,'mlt_cart');
        if($cart_details!=false){
            foreach($cart_details as $info){
                $output50=$info->customization;
                $cart_id=$info->sk_cart_id;

                $custom=json_decode($info->customization);
                
                $output6=',';$output14='';
                $output9=array();
                if($custom->veg){
                    foreach($custom->veg as $info4){
                       $output9[]=$info4;
                    }
                }
                if($custom->nonveg){
                    foreach($custom->nonveg as $info4){
                       $output9[]=$info4;
                    }
                }if($custom->flavor){
                    foreach($custom->flavor as $info4){
                        $output9[]=$info4;
                    }
                }if($custom->base){
                    foreach($custom->base as $info4){
                        $output9[]=$info4;
                    }
                }if($custom->size){
                    foreach($custom->size as $info4){
                        $output9[]=$info4;
                    }
                }
                $custom=json_decode($info->customization);
                        $output6=array();
                        if($custom->size){
                          foreach($custom->size as $info4){
                              $output6[]=$info4;
                          }
                      }
                      if($custom->base){
                        foreach($custom->base as $info4){
                            $output6[]=$info4;
                        }
                    }
                        if($custom->veg){
                            foreach($custom->veg as $info4){
                               $output6[]=$info4;
                            }
                        }
                        if($custom->nonveg){
                            foreach($custom->nonveg as $info4){
                                $output6[]=$info4;
                            }
                        }if($custom->flavor){
                            foreach($custom->flavor as $info4){
                                $output6[]=$info4;
                            }
                        }
                        $ccc=count($output6);

                        $output7='';
                        $output6=implode(',',$output6);
                        
            if($custom->veg){
                $k=0;
                foreach($custom->veg as $info4){
                    $output10[$k]=$info4;
                    $output20[]=$output10[$k];
                   $k=$k+1;
                }
            }
            if($custom->nonveg){
                $k=0;
                foreach($custom->nonveg as $info4){
                    $output11[$k]=$info4;
                    $output21[]=$output11[$k];
                   $k=$k+1;

                }
            }if($custom->flavor){
                $k=0;
                foreach($custom->flavor as $info4){
                    $output12[$k]=$info4;
                    $output22[]=$output12[$k];
                    $k=$k+1;

                }
            }if($custom->base){
                foreach($custom->base as $info4){
                    $output13=$info4;
                }
            }
            if($custom->size){
                foreach($custom->size as $info4){
                    $output14=$info4;
                }
            }

        }
        }
        $where=array('sk_id'=>$item_id);
        $item_onboard_details=$this->cm->getRecords($where,'mlt_items_onboarding');
        if($item_onboard_details){
            foreach($item_onboard_details as $info9){
                $item_display_name=$info9->display_name;
                 $item_type=$info9->type;

            }
        }
        if($item_type!='veg'){
          $img='<img src='.base_url().'/assets/images/red-dot.png class="img-fluid lia-img">';

        }else{
          $img='<img src='.base_url().'/assets/images/dot.png class="img-fluid lia-img">';
        }
        $topping_size_details="";
    $where=array('item_id'=>$item_id,'item_status'=>1);
    $topping_size_details=$this->cm->getRecords($where,'mlt_price');
    $size_details="";
    
    if($topping_size_details)
    {
        $k=1;
        foreach($topping_size_details as $size_info)
        {
            if($output14!=''){
            if($output14==$size_info->item_size){$selected="checked";}else{$selected="";}
            $size_details=$size_details."<div class='col-md-6'>
            <div class='custom-control custom-radio  mb-3'>
                      <input type='radio' id='size$k' data-price='$size_info->item_cost' name='sizes' value='$size_info->item_size#$item_id' class='custom-control-input csize' $selected>
                      <label class='custom-control-label ml-2' for='size$k'>$size_info->item_size 
                        ₹$size_info->item_cost</label> 
                        </div></div>";
                        $k++;
        }
        }
    }
    
    /* $topping_head_details="";
    $where=array('toping_status'=>1);
    $topping_head_details=$this->cm->getRecords($where,'mlt_topings'); */

$sql="SELECT DISTINCT(mlt_item_toppings.topping_id) as toping_id,mlt_topings.toping_head FROM mlt_item_toppings,mlt_topings WHERE mlt_item_toppings.item_id=$item_id and mlt_item_toppings.topping_id=mlt_topings.toping_id and mlt_topings.toping_status=1";
$binds="";
$topping_head_details=$this->cm->getRecordsQuery($sql, $binds);

$toppingHead="";

  $i=1;if($topping_head_details){foreach($topping_head_details as $tinfo){ 
    if($i==1){$menu_active='active';}else{$menu_active='';} 
    $menuClass="topping".$i;    
    $toppingHead=$toppingHead."<li><a class='list-group-item list-group-item-action $menu_active $menuClass'   href='#topping$i' onclick='getToppingId($tinfo->toping_id)'>$tinfo->toping_head</a></li>";
      $i++;}}  
      $menuSizeClass="topping".($i);
      $menuClick=" onclick='getToppingId($i)'";
      $toppingDetails="";$toppingDetails1="";

    $j=1;if($topping_head_details){foreach($topping_head_details as $tp_info){  
        $where=array('item_id'=>$item_id,"topping_id"=>$tp_info->toping_id);
        $topping_item_details=$this->cm->getRecords($where,'mlt_item_toppings'); 
        if($topping_item_details){
            $total_veg_non_veg_count=0;$veg_count1=$nonveg_count1=0;
            if($output20){$veg_count1=sizeof($output20);}
            if(!empty($output21)){ $nonveg_count1=sizeof($output21); }
             $total_veg_non_veg_count=$veg_count1+$nonveg_count1;
            $item_details="";$p=1;
            foreach($topping_item_details as $tpitem){ $toppingItem=rtrim($tpitem->items,',');  
                $empty_cart_id = ''; 
                $tmp=explode(',',$toppingItem);    
                for($k=0;$k<sizeof($tmp);$k++){
                  $select=$select1='';
                 if($tmp[$k]!='') {
                    $input='';

                    if($tpitem->topping_id==1){
                      if(!empty($output20)){  
                          //for($l=0;$l<sizeof($output20);$l++){
                              if(in_array($tmp[$k],$output20)){
                                $select='checked';
                              }
                              else{
                                $select='';
                                if($total_veg_non_veg_count==3){$select1='disabled';}
                              }
                      }
                      else{
                        $select='';
                        if($total_veg_non_veg_count==3){$select1='disabled';}
                      }
                    }
                    if($tpitem->topping_id==2){
                //  $item_type=$info9->type;
                        if($item_type=='non-veg'){
                    if(!empty($output21)){  
                      if(in_array($tmp[$k],$output21)){
                        $select='checked';
                      }
                      else{
                        if($total_veg_non_veg_count==3){ $select1='disabled';}
                        else{
                          $select1='disabled';
                        }
                      }
                     
                    }
                    
                    else{
                      if($total_veg_non_veg_count==3){ $select1='disabled';}
                                       
                  }
                  }
                  else{
                     $select1='disabled';

                  }
                }
                  if($tpitem->topping_id==3){ 
                    if(!empty($output22)){  
                      if(in_array($tmp[$k],$output22)){
                        $select='checked';
                      }
                      else{
                        $select='';
                      } 
                      if(sizeof($output22)==3){
                        $select1='disabled';
                      }
                    }
                  }
              if($select!='checked'){
                //if($total_veg_non_veg_count==3){$select1='disabled';}
                // $select23="disabled";
               $tpingid=$tpitem->topping_id;
               $class1='id-'.$tpingid."-select";
              //  $disableclass="disabled";
               $idclass="customCheck$tp_info->toping_id$p";
               $valClass="$tmp[$k]#$tpitem->topping_id#$item_id";
                $input=$input."<input type='checkbox'     value='$valClass' class='custom-control-input $class1' id='$idclass' $select1 >";
              }
              else{
                $select1='';
                
                $input=$input."<input type='checkbox' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='custom-control-input id-$tpitem->topping_id-select' id='customCheck$tp_info->toping_id$p' $select $select1 >";
              }
            }
 
                     if($tpitem->topping_id!=4) { 
                $item_details=$item_details."<div class='col-md-6'>
                <div class='custom-control custom-checkbox mb-3'>
                $input    
              <label class='custom-control-label pl-21' for='customCheck$tp_info->toping_id$p'>$tmp[$k]</label>
                </div>
                </div>";
                     }
                     else{
                      if($tmp[$k]==$output13){


                        $item_details=$item_details."<div class='col-md-6'>
                        <div class='custom-control custom-radio  mb-3'>
                                  <input type='radio' id='cbase$p' name='cbase' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='custom-control-input cbase'checked>
                                  <label class='custom-control-label pl-2' for='cbase$p'>$tmp[$k]</label> 
                                    </div></div>";
                     }
                   else{
                      
                      $item_details=$item_details."<div class='col-md-6'>
                      <div class='custom-control custom-radio  mb-3'>
                                <input type='radio' id='cbase$p' name='cbase' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='custom-control-input cbase'>
                                <label class='custom-control-label pl-2' for='cbase$p'>$tmp[$k]</label> 
                                  </div></div>";
                    }
                  }
                  $p++;
                }}   
                $output='';
                  if($tp_info->toping_head!='Base'){
                    $count20=0;
                      if($tp_info->toping_head=='Veg Topping'){
                          if(!empty($output20)){
                            $count20=sizeof($output20);
                          }else{
                            $count20=0;
                          }
                      }else if($tp_info->toping_head=='Non-veg Topping'){
                        if(!empty($output21)){
                        $count20=sizeof($output21);
                    }else{
                        $count20=0;
                      }
                      }else{
                        if(!empty($output22)){
                        $count20=sizeof($output22);
                    }else{
                        $count20=0;
                      }
                      }
                    $output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head ($count20/3)</div>
                    <div class='vegcontent'>You can choose upto 3 options</div>";
                    } else{$output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head</div>
                      <div class='vegcontent'>You can choose only 1 option</div>";
                    }
      $toppingDetails=$toppingDetails."<div class='card mb-4' id='topping$j'>
        <div class='card-header' id='heading$j'>
          <h2 class='mb-0'>
            <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
              data-target='#collapse$j' aria-expanded='true' aria-controls='collapse$j'>
              <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
              </div>
              $output
            </button>
          </h2>
        </div>
        <div id='collapse$j' class='collapse show' aria-labelledby='heading$j'
          data-parent='#accordionExample'>
          <div class='card-body row topping-list'>    
            $item_details 
          </div>
        </div>
      </div>"; 
      }$j++;}} 
 

      $toppingDetails1=$toppingDetails1."<div class='card mb-4' id='size'>
        <div class='card-header' id='headingOne'>
          <h2 class='mb-0'>
            <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
              data-target='#collapse5' aria-expanded='true' aria-controls='collapse5'>
              <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
              </div>
              <div class='vegtext'>Size</div> 
            </button>
          </h2>
        </div>
        <div id='collapse5' class='collapse show' aria-labelledby='heading5'
          data-parent='#accordionExample'>
          <div class='card-body row topping-list'> $size_details 
          </div>
        </div>
      </div>"; 
      

    

     
      $output="<div class='modal-body'>
      <button type='button' class='close ' data-dismiss='modal' aria-label='Close'>
      <input type='hidden' value='$item_type' class='type$item_id'>
        <span aria-hidden='true'><div><img class='img-fluid ' src='$cancel_img' alt=''></div></span>
      </button>
      <input type='hidden' value='$item_id' class='item-id'>

      <div class=' d-flex mgr-path ss'>
      
        <div>$img</div>
        <h1 class='pizza-header mb-4 pl-2'><span class='pizzaheader-mgr'>$item_display_name - $item_name</span>
        </h1>
        
       
      </div>
      
      <div class='mgr-line'></div>
      <div class='Customization-text mt-4'>Customization  <div class='customize_err_message' style='display:none'> <div class='d-flex'>
      <img class='' src='$cust_img'>
      <p class='ml-md-2 align-self-center'><span class='fw-500'>OOPS!</span>You’ve chosen maximum of 3 options</p>
  </div></div></div>
     
      <div id='navbar-example2'>
        <div class='tabs-scroll'>
        <ul id='list-example' class=' customize-list d-flex mt-3'>
          $toppingHead
            <li><a class='list-group-item list-group-item-action $menuSizeClass' href='#size' $menuClick>Size</a></li> 
        </ul>
      </div>
      </div>
      <div class='customize-scroll accordion scrolling-bar custom-scrollbar' id='accordionExample' data-spy='scroll'
        data-target='#navbar-example2' data-offset='0'>
        $toppingDetails 
        $toppingDetails1
      </div>
    </div>
    <div class=' add-card'>
      <div class='d-flex addcard'>
        <div class='mx-222'>
                <div class='customize coustamize_selected'>$output6</div>
                <input type='hidden' class='customize coustamize_selected' value='$output6'>
          <div class='card-amount mb-1' id='card-amount'>₹$size_info->item_cost</div>
          <div class='card-cust'>CUSTOMIZED</div>
        </div>
       
        <input type='hidden' id='ccart_id'/>
        <input type='hidden' id='cart_size'/>
        <div class='ml-auto'>
        <div class='count-cust '>+$ccc add on</div>
        <button class='addcard-item ml-auto' onclick=getValue1(this,$item_id,$size_info->item_cost,$cart_id,'update')>Add to Cart</button></div>
      </div>
    </div>";

    echo $output;
    }
   
    public function my_account() {
        $data=$this->common_data();
        $admin_url=base_url();
        $coupon_user=false;
            if($data['user_id']!=''){
              $where=array('coupon_status'=>1,'user_id'=>$data['user_id']);
              $coupon_user=$this->cm->getrecords($where,'mst_coupons');
              
            }
            $coupon='';

           // var_dump($coupon_user);exit();
            if($coupon_user!=false){
              foreach($coupon_user as $row){
                $coupon=$coupon."<div class='custom-control custom-radio mb-3 coupon-msg coupon-err$row->sk_coupon_id'>
                            <input type='radio' id='abc$row->sk_coupon_id' name='couponradio ' class='custom-control-input '>
                            <label class='custom-control-label coupon28  d-flex coupon25$row->sk_coupon_id ' for='abc$row->sk_coupon_id'> <div>
                                <div><input type='hidden' value='$row->sk_coupon_id' id='coupon_id'>
                                <p class='exl-text fs-20 coupon_code$row->sk_coupon_id fw-500'> $row->coupon_code</p>
                                <p class='discount fw-400'>Get  $row->coupon_price off on your first order</p></div>
                                <input type='hidden' id='coupon_price$row->sk_coupon_id' value=' $row->coupon_price'>
                            </div>
                        </div>
                        <div class='d-flex err-full-msg error-msg$row->sk_coupon_id' style='display:none'>
                            <div class='oops-img img-fluid  mr-2'> <img class='oops-img image22 img10$row->sk_coupon_id d-none' src='$admin_url/assets/images/oops.png'></div>
                            <p class='oops-bug fw-400'><span class='oops fw-500 mr-1 error1$row->sk_coupon_id'></span></p>
                        </div>";
              }
            }
        $where=array('coupon_status'=>1,'user_id'=>'');
        $data['coupons_user']=$coupon;
        $data['coupon_details']=$this->cm->getrecords($where,'mst_coupons');
        
        $this->load->view('website/my-account',$data);
    }
    
    public function favourite(){
        $data=$this->common_data();
        if($data['user_id']!='' && $data['user_id']!=null){
        $userid=$this->input->post('user_id');
        $itemid=$this->input->post('item_id');
        $slug=$this->input->post('val');
        $operation=$this->input->post('operation');
        if($operation=='add'){
            $data=array('user_id'=>$userid,'item_id'=>$itemid, 'date'=>$data["post_date"], 'time'=>$data["time"], 'status'=>1, 'slug'=>$slug); 
            $this->cm->save($data,'mst_favourite');
        }else{
            $where=array('user_id'=>$userid,'item_id'=>$itemid);
            $this->cm->deleteRecords($where,'mst_favourite');
        }
      }else{
        redirect('/');
      }
    }
    public function my_favourites(){
         $data=$this->common_data(); 
         if($data['user_id']!=''){ 
             $where=array('user_id'=>$data['user_id']);
        $favorites=$this->cm->getRecords($where,'mst_favourite');
        $where=array('cuser_id'=>$data['user_id'],'party_time'=>0);
        $cart_details=$this->cm->getRecords($where,'mlt_cart');        
        $cart_data=array();
        $cart_price=$i=0;
        if($cart_details){
            foreach($cart_details as $info){
                $cart_price=$cart_price+$info->price;
                $i++;
            }  
        }         
        $data['cart_price']=$cart_price;   
        $data['items']=$i;
        
        if($favorites){
            foreach($favorites as $info1){
                $favor['sk_favourite_id']=$info1->sk_favourite_id;
                $favor['item_id']=$info1->item_id;
                $items['slug']=$info1->slug;
                $where=array('sk_id'=>$favor['item_id']);
                $item_details=$this->cm->getRecords($where,'mlt_items_onboarding');
                $categoryTypeInfo['item_details']='';$temp1=array();
                if($item_details){
                    foreach($item_details as $info){
                        $items['item_name']=$info->item_name;
                        $items['item_id']=$info->sk_id;
                        $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                        $price_details=$this->cm->getRecords($where,'mlt_price');
                        $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                        $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                        
                        $where=array('item_id'=>$info->sk_id,'user_id'=>$data['user_id']);
                        $items['favorites']=$this->cm->getRecords($where,'mst_favourite');
                        $items['cart_details']=$cart_details;
                        $price=$item_size='';

                        if($price_details){

                            foreach($price_details as $row3){
                                 $price=$price_details[0]->item_cost;
                                 $item_size=$price_details[0]->item_size;
                            }
                        }
                        
                         $items['price']=$price;
                         $items['size']=$item_size;
        
                        $items['base_drop']=$base_details;
                        $items['price_drop']=$price_details;
                        $items['price']=$price_details[0]->item_cost;
                        $items['image']=$info->image;
                        $items['display_name']=$info->display_name;
                        $items['item_status']=$info->item_onboarding_status;
                        
                        $items['short_description']=$info->description;
                        $items['description']=$info->description;
                        
                        $items['slug1']=$info->slug;
                        $items['seo_description']=$info->seo_description;
                        $items['seo_title']=$info->seo_title;
                       //$items['short_description']=$info->description;
                        $items['type']=$info->type;
                        $items['section_name']=$info->section_name;
                        $temp[]=$items;
                    }
                    $categoryTypeInfo['item_details']=$temp;
                }
                $temp1[]=$categoryTypeInfo;
                }
                $data['categoryTypeInfo']=$temp1;
            }
            else{
                $data['categoryTypeInfo']=false;
            }
            $this->load->view('website/favourite',$data);
    }else{
        redirect('/');
    }

    }
 
    public function toppings(){
        $data=$this->common_data();  
        $item_id=$this->input->post('item_id');
        $where=array('toping_status'=>1);
        $toppings=$this->cm->getRecords($where,'mlt_topings');
        if($toppings){
            $temp2=array();

            foreach($toppings as $info){
                $temp1=array();
                $topping['topping_head']=$info->toping_head;
                $topping['toping_description']=$info->toping_description;
                $topping['toping_type']=$info->toping_type;
                $topping['sk_topping_id']=$info->toping_id;	
                $where=array('item_id'=>$item_id,'topping_id'=>$topping['sk_topping_id']);
                 $item_toppings=$this->cm->getRecords($where,'mlt_item_toppings');
                 if($item_toppings){
                    $temp=array();

                    foreach($item_toppings as $info1){
                        $item_top=array();
                        $item_top['item_id1']=$info1->item_id;
                        $item_top['topping_id']=$info1->topping_id;
                        $item_top['items']=$info1->items;
                        $temp[]=$item_top;
                    }
                    $topping['topping_item_details']=$temp;
                }
                $temp1[]=$topping;
                $temp2['topping_details']=$temp1;
                $temp4[]=$temp2;

            }
                $temp5['topping_details_of_toppings']=$temp4;
        }
        
        echo json_encode($temp5);

    }


    public function addtocart(){
        $data=$this->common_data();
        $where1=array();
        $item_id=$this->input->post('item_id');
        $price=$this->input->post('price');
        $num=$this->input->post('num');
        $base=$this->input->post('base');
          $size=$this->input->post('size');
          $party_time=0;
          if($this->input->post('party_time')!=0){
            $party_time=$this->input->post('party_time');
          }
         $item_price=$this->input->post('item_price');
          $customization=$this->input->post('customization');
         $user_id='';
         $custom=json_decode($customization);
         $output6=array();
         if($custom->veg){
           foreach($custom->veg as $info4){
              $output6[]=$info4;
           }
       }
       if($custom->nonveg){
         foreach($custom->nonveg as $info4){
             $output6[]=$info4;
         }
     }

     if($custom->flavor){
       foreach($custom->flavor as $info4){
           $output6[]=$info4;
       }
   }

   if($custom->base){
     foreach($custom->base as $info4){
         $output6[]=$info4;
     }
 }
 $size1=1;
         if($custom->size){
           foreach($custom->size as $info4){
               $output6[]=$info4;
                $size1=$info4;
           }
       }
      
         if($size1==$size){
           $size=$size1;
         }
         $output7='';
         $output6=implode(', ',$output6);
         
         $temporary_session_id='';
        if($data['user_id']==''){
			if($this->session->userdata("temporary_session_id")==null || $this->session->userdata("temporary_session_id")==""){

				$user_id = $this->createTempSession();
                   $user_id = (int)$user_id;
				$this->session->set_userdata("temporary_session_id", $user_id);
          $where1=array('cuser_id'=>$user_id,'citem_id'=>$item_id,'item_size'=>$size,'party_time'=>$party_time);
        
			}else{
			
				 $user_id = $this->session->userdata("temporary_session_id");
        
    $where1=array('cuser_id'=>$user_id,'citem_id'=>$item_id,'item_size'=>$size,'party_time'=>$party_time);
  

			}
     	}
         else{
             $user_id=$data['user_id'];
            
        $where1=array('cuser_id'=>$user_id,'citem_id'=>$item_id,'item_size'=>$size,'party_time'=>$party_time);
         }
        $cartdetails=$this->cm->getRecords($where1,'mlt_cart');
        if($cartdetails==false){
          if($size!=1){
                $data_array=array(
                  "cuser_id"=>$user_id,
                  "citem_id"=>$item_id,
                  "quantity"=>$num,
                  "price"=>$price,
                  'base'=>$base,
                  "party_time"=>$party_time,
                  "item_size"=>$size,
                  "item_price"=>$item_price,
                  "customization"=>$customization,
                  "cstatus"=>1
              );

              }else{
                $tmp3['veg']=$tmp3['nonveg']=$tmp3['base']=$tmp3['size']=$tmp3['flavor']=array();
                $tmp10=json_encode($tmp3);
                $data_array=array(
                  "cuser_id"=>$user_id,
                  "citem_id"=>$item_id,
                  "quantity"=>$num,
                  "price"=>$price,
                  "base"=>$base,
                  "party_time"=>$party_time,
                  "item_size"=>$size,
                  "item_price"=>$item_price,
                  "customization"=>$tmp10,
                  "cstatus"=>1
              );
              }
        $cart=$this->cm->save($data_array,'mlt_cart');
        $where=array('cuser_id'=>$user_id,'party_time'=>0);
        $cart_details=$this->cm->getRecords($where,'mlt_cart');
        $cart_price=$i=0;
        if($cart_details){
        $cart_data=array();
        foreach($cart_details as $info){
            $cart_price=$cart_price+$info->price;
            $i++;
        }
        // $customization=json_decode($customization);
        $cart_data=array(
            'items'=>$i,
            'price'=>$cart_price,
          "customization"=>$output6

        ); 
 
    }
    }
    else{
      if($size!=1){
       

        $arr=json_decode($customization);
        if($arr->veg==false && $arr->nonveg==false && $arr->flavor==false && $arr->size==false && $arr->base==false){
            $data_array=array(
              "cuser_id"=>$user_id,
              "citem_id"=>$item_id,
              "quantity"=>$num,
              "price"=>$price,
              "party_time"=>$party_time,
              'base'=>$base,
              "item_size"=>$size,
              "item_price"=>$item_price,
              // "customization"=>$customization,
              "cstatus"=>1
          );
        }else{
        $data_array=array(
          "cuser_id"=>$user_id,
          "citem_id"=>$item_id,
          "quantity"=>$num,
          "price"=>$price,
          "party_time"=>$party_time,
          'base'=>$base,
          "item_size"=>$size,
          "item_price"=>$item_price,
          "customization"=>$customization,
          "cstatus"=>1
      );
    }
          }else{
            $tmp3['veg']=$tmp3['nonveg']=$tmp3['base']=$tmp3['size']=$tmp3['flavor']=array();
            $tmp10=json_encode($tmp3);
            $data_array=array(
              "cuser_id"=>$user_id,
              "citem_id"=>$item_id,
              "quantity"=>$num,
              "price"=>$price,
              "party_time"=>$party_time,
              "base"=>$base,
              "item_size"=>$size,
              "item_price"=>$item_price,
              "customization"=>$tmp10,
              "cstatus"=>1
          );
          }
      }

        $cart=$this->cm->updateRecords($data_array,$where1,'mlt_cart');
        $where=array('cuser_id'=>$user_id,'party_time'=>0);
        $cart_details=$this->cm->getRecords($where,'mlt_cart');        
        $cart_data=array();
        $cart_price=$i=0;

        if($cart_details){
            foreach($cart_details as $info){
                $cart_price=$cart_price+$info->price;
                $i++;
            }
          //  $customization=json_decode($customization);

            $cart_data=array(
                'items'=>$i,
                'price'=>$cart_price,
                "customization"=>$output6
            );  
        }
      // var_dump($customization);exit();
     $this->session->set_userdata('cart_count',$i);
    echo json_encode($cart_data);   

    }


    public function deletecart(){
        $data=$this->common_data();  
        $item_id=$this->input->post('item_id');
        $size=$this->input->post('size');
        $party_time=0;
        if($this->input->post('party_time')!=0){
          $party_time=$this->input->post('party_time');
        }
        $user_id='';
       
        $temporary_session_id='';
       if($data['user_id']==''){
     if($this->session->userdata("temporary_session_id")==null || $this->session->userdata("temporary_session_id")==""){

       $user_id = $this->createTempSession();
                  $user_id = (int)$user_id;
       $this->session->set_userdata("temporary_session_id", $user_id);
               $where1=array('cuser_id'=>$user_id,'citem_id'=>$item_id,'item_size'=>$size,'party_time'=>$party_time);


     }else{
     
        $user_id = $this->session->userdata("temporary_session_id");
        $where1=array('cuser_id'=>$user_id,'citem_id'=>$item_id,'item_size'=>$size,'party_time'=>$party_time);

     }
      }
        else{
            $user_id=$data['user_id'];
               $where1=array('cuser_id'=>$user_id,'citem_id'=>$item_id,'item_size'=>$size,'party_time'=>$party_time);

        }
      
        
        $this->cm->deleteRecords($where1,'mlt_cart');
    $where=array('cuser_id'=>$user_id,'party_time'=>0);
    $cart_details=$this->cm->getRecords($where,'mlt_cart');
    $cart_data='';

    if($cart_details!=false){
        $cart_price=$i=0;
        foreach($cart_details as $info){
            $cart_price=$cart_price+$info->price;
            $i++;
        }
        $cart_data=array(
            'items'=>$i,
            'price'=>$cart_price,
        ); 
       
 
    }
    else{
        $i=$cart_price=0;
    
    $cart_data=array(
        'items'=>$i,
        'price'=>$cart_price,
    ); 
    }
    $this->session->set_userdata('cart_count',$i);
    echo json_encode($cart_data);   
}
    public function fetchdetails(){
        $data=$this->common_data();  
        $userid=$this->input->post('user_id');
        $where=array('sk_user_id'=>$userid);
        $user_details=$this->cm->getRecords($where,'mst_user'); 
        foreach($user_details as $info) {
            $name=$info->full_name;
            $useremail=$info->email;
            $mobileno=$info->mobile;

        } 

        echo $name.'&&'.$useremail.'&&'.$mobileno;

       
    }
    public function updateuserdetails(){
      
      $user_id=$this->input->post('user_id');
        $name=$this->input->post('name');
        $email=$this->input->post('email');
        $mobile=$this->input->post('mobile');
        $datasave1=array('full_name '=>$name, 'email'=>$email, 'mobile'=>$mobile);
        //var_dump($datasave1); exit;
        $where=array('sk_user_id'=>$user_id);
        $this->cm->updateRecords($datasave1,$where,'mst_user');
        $this->session->set_userdata('user_id',$user_id);
            $this->session->set_userdata('fullname',$name);
            $this->session->set_userdata('mobile',$mobile);
            $this->session->set_userdata('email',$email);
           // $this->session->set_userdata('cart_price',$cart_price);
            //$this->session->set_userdata('items',$i);

            $data['user_id']=$this->session->userdata('user_id'); 
            $data['fullname']=$this->session->userdata('fullname');
           $data['mobile']=$this->session->userdata('mobile');
           $data['email']=$this->session->userdata('email');
        

       
       
    }
    public function toppingById(){
        $data=$this->common_data();  $catetopings='';$getviewitems='';$getviewitems1='';$gett='';
        $id=$this->input->post('id');  
        $where=array('item_id'=>$id);
        $details=$this->cm->getRecords($where,'mst_favourite'); 
        //json
    }

    

    public function cart(){
        $data=$this->common_data();
        $user_id='';
        $admin_url=base_url();
         $temporary_session_id='';
         $where=array();
        if($data['user_id']==''){
			if($this->session->userdata("temporary_session_id")==null || $this->session->userdata("temporary_session_id")==""){
				$user_id = $this->createTempSession();

				$this->session->set_userdata("temporary_session_id", $user_id);

			}else{
			
				$user_id = $this->session->userdata("temporary_session_id");
                $where=array('cuser_id'=>$user_id,'party_time'=>0);
			}
     	}
         else{
             $user_id=$data['user_id'];
            $where=array('cuser_id'=>$user_id,'party_time'=>0);

      } 
        $cart_details=$this->cm->getrecords($where,'mlt_cart');
        $cart_price=$i=0;
        $output='';
        $output6='';
        $count=0;
        $count1=0;
        $price=0;
        $item_size1=array();
        $item_size=array();

        if($cart_details!=false){

            foreach($cart_details as $info){
                $citem_id =$info->citem_id;
                $where=array('sk_id'=>$citem_id);
                                $item_details=$this->cm->getrecords($where,'mlt_items_onboarding');
                                if($item_details!=false){
                                        $where=array('sk_categoryItems_id'=>$item_details[0]->category_id,'category_slug'=>'pizzas');
                                        $category_details=$this->cm->getrecords($where,'mst_categoryitems');
                                        if($category_details!=false){
                                            $price=$price+$info->price;
                                            if($info->item_size=='9 inches (small)'){
                                                $item_size[]=$info->item_size;
                                            }else{
                                                $item_size1[]=$info->item_size; 
                                            }
                                        }
                                    }
                                
                    
                    $count=count($item_size);
                 $count1=count($item_size1);
                  
                $where=array('sk_id'=>$citem_id,'item_onboarding_status'=>1);
                $item_details=$this->cm->getrecords($where,'mlt_items_onboarding');
                $cart_price=$cart_price+$info->price;
                $i++;

                if($item_details){
                    foreach($item_details as $info1){
                        $customizationButton = "";
                        $item_name = '"'. $info1->item_name. '"';
                        $custom=json_decode($info->customization);
                        $output6=array();
                        if($custom->veg){
                          foreach($custom->veg as $info4){
                             $output6[]=$info4;
                          }
                      }
                      if($custom->nonveg){
                        foreach($custom->nonveg as $info4){
                            $output6[]=$info4;
                        }
                    }

                    if($custom->flavor){
                      foreach($custom->flavor as $info4){
                          $output6[]=$info4;
                      }
                  }

                  if($custom->base){
                    foreach($custom->base as $info4){
                        $output6[]=$info4;
                    }
                }
                        if($custom->size){
                          foreach($custom->size as $info4){
                              $output6[]=$info4;
                          }
                      }
                     
                        
                        
                        $output7='';
                        $output6=implode(', ',$output6);
                        if($output6!=''){
                        $output7=$output7."<p class='card-text cart-max$info->sk_cart_id'>$output6</p>";
                         }else{
                          $output7=$output7."<p class='card-text cart-max$info->sk_cart_id'>$output6</p>";
                         }
                        if($info1->type=='veg'){
                           $img='<img src='.base_url().'/assets/images/dot.png class="img-fluid lia-img">';
                        }else{
                          $img='<img src='.base_url().'/assets/images/red-dot.png class="img-fluid lia-img">';
                        }
                        if($info1->category_id==1) $customizationButton = "<button type='button' class='customize_coupon' data-toggle='modal' data-target='#customizeModal' onclick='getToppingdetails($info1->sk_id,$item_name,$info->sk_cart_id)'> Customize </button>";
                            $output=$output.'<div class="card">
                                        <div class="row">
                                        
                                        <div class="col-md-3 ">
                                            <div class="d-flex">
                                                <input type="hidden" value='.$info1->type.' class="type'.$info1->sk_id.'">
                                                <div><img src='.admin_img_url."items/".$info1->image.' class="img-fluid cardpiza"></div>
                                                <div class="d-md-none d-block">
                                                    <div class="d-flex mb-2 ml-3">
                                                       <div>'.$img.'</div>
                                                        <div class="lia fw-600">'.$info1->display_name.'<span class="italia">  - '.$info1->item_name.'</span></div>
                                                    </div>
                                                </div>
                                                <div class="d-md-none d-block ">
                                                    <div class="inc-number" id="price-id'.$info->sk_cart_id.'">
                                                        ₹'.$info->item_price.'
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9 customize-card">
                                            <div class="d-none d-md-block">
                                                <div class="d-flex mb-2 ">
                                                   <div>'.$img.'</div>
                                                   <div class="lia fw-600" style="margin-top:2px">'.$info1->display_name.'<span class="italia">  -  '.$info1->item_name.'</span></div>
                                                   </div>
                                            </div>
                                            <input type="hidden" id="price_item'.$info->sk_cart_id.'" value='.$info->item_price.'>
                                            <input type="hidden" id="item_size'.$info->sk_cart_id.'" value="'.$info->item_size.'">
                                            <input type="hidden" id="item-size-cart'.$info1->sk_id.'" value='.$info->item_size.'>
                                            <input type="hidden" id="item_id". value='.$info1->sk_id.'>
                                            <div class="d-flex mb-2">'
                                                .$output7.'
                                            
                                                <!--increment and decrement-->
                                                <div class="d-none d-md-block align-self-center">
                                                    <div id="field1" class="field1 d-flex ml-4">
                                                        <button type="button" onclick=getValue1(this,'.$info1->sk_id.','.$info->price.','.$info->sk_cart_id.',"sub"); id="sub" class="sub">
                                                        <img src='.base_url().'assets/images/minus.png ></button>
                                                        <input type="number" id="1" class="num num1'.$info->sk_cart_id.'" value='.$info->quantity.' min="1" readonly
                                                            max="10000">
                                                        <button type="button" id="add" class="add" onclick=getValue1(this,'.$info1->sk_id.','.$info->price.','.$info->sk_cart_id.',"add");><img
                                                                src='.base_url().'assets/images/plus.png></button>
                                                    </div>
                                                </div>
                                                <!--increment and decrement-->

                                                <div class=" d-none d-md-block ml-auto align-self-center" id="price-id1'.$info->sk_cart_id.'">₹'.$info->item_price.'</div>
                                            </div>
                                            
                                            <div class="d-flex">'.$customizationButton.'
                                                <div class="d-md-none d-block ml-auto">
                                                    <div id="field1" class="field1 d-flex ml-4 ml-auto">
                                                        <button type="button" onclick=getValue1(this,'.$info1->sk_id.','.$info->price.','.$info->sk_cart_id.',"sub"); id="sub" class="sub">
                                                        <img src='.base_url().'assets/images/minus.png ></button>
                                                        <input type="number" id="1" class="num num1'.$info->sk_cart_id.'" value='.$info->quantity.' min="1"
                                                            max="10000"readonly>
                                                        <button type="button" id="add" class="add" onclick=getValue1(this,'.$info1->sk_id.','.$info->price.','.$info->sk_cart_id.',"add");><img
                                                                src='.base_url().'assets/images/plus.png></button>
                                                    </div>
                                                </div>
                                            </div>
                                       
                                            </div>
                                    </div>
                                    <div class="line-divider">

                                    </div></div>
                                    ';
                    }
                }
            }
            $data['item_details']=$output;
            //var_dump($data['user_id']);exit;
            $coupon_user=false;
            if($data['user_id']!=''){
              $where=array('coupon_status'=>1,'user_id'=>$user_id);
              $coupon_user=$this->cm->getrecords($where,'mst_coupons');
              
            }
            $coupon='';

           // var_dump($coupon_user);exit();
            if($coupon_user!=false){
              foreach($coupon_user as $row){
                $coupon=$coupon."<div class='custom-control custom-radio mb-3 coupon-msg coupon-err$row->sk_coupon_id'>
                            <input type='radio' id='abc$row->sk_coupon_id' name='couponradio ' class='custom-control-input '>
                            <label class='custom-control-label coupon28  d-flex coupon25$row->sk_coupon_id ' for='abc$row->sk_coupon_id'> <div>
                                <div><input type='hidden' value='$row->sk_coupon_id' id='coupon_id'>
                                <p class='exl-text fs-20 coupon_code$row->sk_coupon_id fw-500'> $row->coupon_code</p>
                                <p class='discount fw-400'>Get  $row->coupon_price off on your first order</p></div>
                                <input type='hidden' id='coupon_price$row->sk_coupon_id' value=' $row->coupon_price'>
                            </div>
                            <p class=' applycoupons10$row->sk_coupon_id apply-discount text-center ml-auto mb-3'onClick='applycoupon($row->sk_coupon_id)'>Apply</p></label>
                        </div>
                        <div class='d-flex err-full-msg error-msg$row->sk_coupon_id' style='display:none'>
                            <div class='oops-img img-fluid  mr-2'> <img class='oops-img image22 img10$row->sk_coupon_id d-none' src='$admin_url/assets/images/oops.png'></div>
                            <p class='oops-bug fw-400'><span class='oops fw-500 mr-1 error1$row->sk_coupon_id'></span></p>
                        </div>";
              }
            }
        $where=array('coupon_status'=>1,'user_id'=>'');
        $data['coupons_user']=$coupon;
        $data['coupon_details']=$this->cm->getrecords($where,'mst_coupons');
        
        $data['cart_price']=$cart_price;   
        $data['items']=$i;

        $data['cart_details']=$cart_details;
        $data['cart_count']=$count;
        $data['cart_count1']=$count1;

        $this->load->view('website/coupon',$data);
 
        }
        else{
            redirect('no-order-emptystate');
        }
       
    }


    public function checkcoupon(){
        $data=$this->common_data();
        $coupon_id=$this->input->post('coupon_id');
        $coupon_code=$this->input->post('coupon_code');
        $party_time=$this->input->post('party_time');

        $user_id=0;
        if($data['user_id']!=''){
            $user_id=$data['user_id'];
        }
        else{
            $user_id=$data['temporary_session_id'];
        }
        if($coupon_code==''){
          $where=array('user_id'=>$user_id,'txn_coupon_status'=>0);

          $getcoupondetails=$this->cm->getRecords($where,'txn_coupons');
          if($getcoupondetails==false){

          
        $data=array('coupon_id'=>$coupon_id,'user_id'=>$user_id,'txn_coupon_status'=>0);
        $coupon=$this->cm->save($data,'txn_coupons');
        $where=array('sk_coupon_id'=>$coupon_id);
        $coupon_details=$this->cm->getrecords($where,'mst_coupons');
        $coupon_save_cost=0;
        if($coupon_details!=false){
            foreach($coupon_details as $info){
                $coupon_save_cost=$info->coupon_price;
            }
        }
      }else{
        $data=array('coupon_id'=>$coupon_id,'user_id'=>$user_id,'txn_coupon_status'=>0);
        $coupon=$this->cm->updateRecords($data,$where,'txn_coupons');
        $where=array('sk_coupon_id'=>$coupon_id);
        $coupon_details=$this->cm->getrecords($where,'mst_coupons');
        $coupon_save_cost=0;
        if($coupon_details!=false){
            foreach($coupon_details as $info){
                $coupon_save_cost=$info->coupon_price;
            }
        }
      }
    }else{
        $where22=array('coupon_code'=>$coupon_code);
        $getdeatailscoupons= $this->cm->getRecords($where22,'mst_coupons');
        if($getdeatailscoupons!=false){
        $coupon_id='';
            foreach($getdeatailscoupons as $row){
              $coupon_id=$row->sk_coupon_id;
            }
            $data=array('coupon_id'=>$coupon_id,'user_id'=>$user_id,'txn_coupon_status'=>1);
            $coupon=$this->cm->save($data,'txn_coupons');
            $where=array('sk_coupon_id'=>$coupon_id);
            $coupon_details=$this->cm->getrecords($where,'mst_coupons');
            $coupon_save_cost=0;
            if($coupon_details){
                foreach($coupon_details as $info){
                    $coupon_save_cost=$info->coupon_price;
                }
            }

      }else{
          $coupon_save_cost=false;  
      }
    }

        if($party_time=='no'){
          $where=array('cuser_id'=>$user_id,'party_time'=>0);
          $cart_details=$this->cm->getRecords($where,'mlt_cart');
          if($cart_details!=false){
          $cart_price=$i=0;
          foreach($cart_details as $info){
              $cart_price=$cart_price+$info->price;
              $i++;
          }
          $cart_price=$cart_price-$coupon_save_cost;
          $cart_data=array(
              'price'=>$cart_price,
              'coupon_save_cost'=>$coupon_save_cost,
              
          ); 
        }
    }
        else{
          $cart_price=$this->input->post('cart_price');
          $cart_price=$cart_price-$coupon_save_cost;
         $cart_data=array(
          'price'=>$cart_price,
          'coupon_save_cost'=>$coupon_save_cost,
        );
        }
        echo json_encode($cart_data);
}
    


                
    public function toppingItems(){
        $data=$this->common_data();$categorysWith='';
        $toppingid=$this->input->post('toping_id');
        $id=$this->input->post('id');
        $where=array('topping_id'=>$toppingid,'item_id'=>$id);
        // var_dump($where); exit;
         $itemdetails=$this->cm->getRecords($where,'mlt_item_toppings');
         //var_dump($itemdetails);
         foreach($itemdetails as $getinfo){
             $items=$getinfo->items;
            //var_dump($items); 
            $item_topping=explode(",",$items);
            //var_dump($item_topping);
            foreach($item_topping as $rinfo){
              //  var_dump($rinfo); exit;
            $categorysWith="<div class='custom-control custom-checkbox mb-3'>
            <input type='checkbox' class='custom-control-input veg-select' id='customCheck1'>
            <label class='custom-control-label pl-2' for='customCheck1'>$rinfo</label>
          </div>";
          echo $categorysWith;
            }

         }
    }


    public function checksignin(){
        $data=$this->common_data();
        $where=array('sk_user_id'=>$data['user_id'],'user_status'=>1);
        $loginDetails=$this->cm->getrecords($where,'mst_user');
        $name=$user_id='';
        if($loginDetails!=false){
            foreach($loginDetails as $info){
                $name=$info->full_name;
                $user_id=$info->sk_user_id;
                $where=array('user_id'=>$user_id,'address_status'=>1);
                $addressdetails=$this->cm->getrecords($where,'mlt_address');
                $temp=array();
                $output='';

                if($addressdetails){
                    foreach($addressdetails as $info1){
                        $sk_address_id=$info1->sk_address_id;
                        $area=$info1->area;
                        $city=$info1->city;
                        $state=$info1->state;
                        $country=$info1->country;
                        $pincode=$info1->pincode;
                        $street=$info1->street;
                        $latitude=$info1->latitude;
                        $longitude=$info1->longitude;
                        $country_code=$info1->country_code;
                        $state_code=$info1->state_code;
                        $address_type=$info1->address_type;
                        $full_address=$info1->full_address;
                        $house_no=$info1->house_no;

                        $output=$output."<div class='custom-control custom-radio home--brder mt-3 '>
                                    <input type='radio' class='custom-control-input adress-type' onclick='gettime($sk_address_id,$latitude,$longitude)' value=$sk_address_id name='customRadio-adddress' id='customRadio$sk_address_id'>
                                    <label class='custom-control-label' for='customRadio$sk_address_id'><p class='fw-600 homiie'>$address_type</p>
                                        <p class='p-sec fw-400 grand-viw address-full'>$house_no $full_address</p>
                                    </label><input type='hidden' class='latitude$sk_address_id' value='$latitude'><input type='hidden' class='longitude$sk_address_id' value='$longitude'>
                                </div>";
                    }
                }
            }
            echo json_encode(array("name"=>$name,"user_id"=>$user_id,"addressdetails"=>$output));
        }
        else{
            echo json_encode(array("name"=>$name,"user_id"=>$user_id));
        }
 
    }
/******************for location***************/
    

/************************end of current location**************/
public function order(){
    $data=$this->common_data();
    $output='';
    $user_name=$data['fullname'];
    $user_name1=$data['fullname'];
    $mobile=$data['mobile'];
    $email=$data['email'];
    $email_to=$data['email'];
    $rrr=$email;
    $email='"'.$rrr.'"';
    $rrr=$user_name;
    $user_name='"'.$rrr.'"';
    $rrr=$mobile;
    $mobile='"'.$rrr.'"';
    $delivery_date=$this->input->post('delivery_date');
    $delivery_time=$this->input->post('delivery_time');
    
    $address_id=$this->input->post('address_id');
    $payment_mode=$this->input->post('payment_mode');
    $order_type=$this->input->post('order_type');
    $total_price=$this->input->post('total_price');
    $party_time=$this->input->post('party_time');
    $coupon_id=$this->input->post('coupon_id');
    $total_order_quantity=$this->input->post('total_item');
    $discount_amount=$this->input->post('discount_amt');
    $razor_payment_id=$this->input->post('razor_payment_id');
    $real_time_details='';$slotId=$inputLevel="";$asap=false;
     $datetime = $delivery_date.' '.$delivery_time;
    $event_date=date('Y-m-d H:i:s', strtotime($datetime));
     $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
     if($coupon_id!=''){
      $where399 = array(
        'coupon_id'=>$coupon_id, 
        'user_id'=>$data['user_id'],
        'txn_coupon_status'=>'0'    
    );
    $lat=$lon='';
    $data_array29=array('txn_coupon_status'=>'1');
    $this->cm->updateRecords($data_array29,$where399,'txn_coupons');
     }
     $id_dup=0;
     if($address_id!=''){
       $where=array('sk_address_id'=>$address_id);
       $address_details20=$this->cm->getRecords($where,'mlt_address');
       if($address_details20!=false){
         foreach($address_details20 as $info66){
     $data_array=array(
      "user_id"=>$data['user_id'],
      "address_type"=>$info66->address_type,
      "area"=>$info66->area,
      "city"=>$info66->city,
      "state"=>$info66->state,
      "country"=>$info66->country,
      "pincode"=>$info66->pincode,
      "street"=>$info66->street,
      "latitude"=>$info66->latitude,
      "longitude"=>$info66->longitude,
      "full_address"=>$info66->full_address,
      "address_status"=>$info66->address_status,
      "house_no"=>$info66->house_no
  );
}
  $id_dup=$this->cm->save($data_array,'mlt_address_dup');
}}
$address_id=$id_dup;


             $datetime1='"'.$datetime.'"';
    $data_array=array(
        "user_id"=>$data['user_id'],
        "user_address"=>$address_id,
        "ordered_date"=>date('y-m-d'),
        "ordered_time"=>date("H:i:s"),
        "total_order_quantity"=>$total_order_quantity,
        "total_order_value"=>$total_price,
        "order_type"=>$order_type,
        "coupon_id"=>$coupon_id,
        "party_time"=>$party_time,
        "discount_amount"=>$discount_amount,
        "payment_mode"=>$payment_mode,
        "order_status"=>"CREATED",
        "order_delivery_date"=>$delivery_date,
        "order_delivery_time"=>$delivery_time,
        "razor_payment_id"=>$razor_payment_id
    );
    $order_id=$this->cm->save($data_array,'mlt_order');
   //$order_id1= "." ' "$order_id"." ' "";
   $order_id1='"CBE'.$order_id.'"';
   $notification=array(
     "user_id"=>$data['user_id'],
    "notifiaction_label"=>"Order Placed",
    "notification_msg"=>"As per Your request,Order is placed",
    "notification_date"=>date('Y-m-d')
);
$this->cm->save($notification,'txn_notifications');
    $where=array('sk_address_id'=>$address_id);
    $address=$this->cm->getRecords($where,'mlt_address_dup');
    $output1='';
    if($address){
        foreach($address as $info1){
            $address['sk_address_id']=$info1->sk_address_id;
                    $address['area']=$info1->area;
                    $address['city']=$info1->city;
                    $address['state']=$info1->state;
                    $address['country']=$info1->country;
                    $address['pincode']=$info1->pincode;
                    $address['street']=$info1->street;
                    $address['country_code']=$info1->country_code;
                    $address['state_code']=$info1->state_code;
                    $address['address_type']=$info1->address_type;
                    $address['address_type']=$info1->address_type;
                    $address['house_no']=$info1->house_no;
                    $address['full_address']=$info1->full_address;

                    $lat=$info1->latitude;
                    $lon=$info1->longitude;
        }
        $output1=$address['house_no'].' '.$address['street'].' '.$address['full_address'];
    }

    $rrr=$output1;
    $output1='"'.$rrr.'"';
    $lat_lon='"'.$lat.','.$lon.'"';
    if($delivery_date!=date("Y-m-d")){
      $real_time_details=$this->realtime_feasabilty_check_for_tomorow($datetime,$lat,$lon);
      $json_time=json_decode($real_time_details);
      if($json_time!=''){
              $slotId= $json_time->slot_id;
              $inputLevel=$json_time->levele_id;
      }
    }  
   
    $total_price='"'.$total_price.'"';

    $output2 = array();
    if($party_time=='no'){
    $where=array('cuser_id'=>$data['user_id'],'party_time'=>0);
    }else{
      $where=array('cuser_id'=>$data['user_id'],'party_time'=>1);
    }
    $cart_orders=$this->cm->getrecords($where,'mlt_cart');
    if($cart_orders){$i=1;
        foreach($cart_orders as $info){
          $output6=array();

    if($info->customization){
          $custom=json_decode($info->customization);
          if(!empty($custom->veg)){
            foreach($custom->veg as $info4){
               $output6[]=$info4;
            }
        }
        if(!empty($custom->nonveg)){
          foreach($custom->nonveg as $info4){
              $output6[]=$info4;
          }
      }

      if(!empty($custom->flavor)){
        foreach($custom->flavor as $info4){
            $output6[]=$info4;
        }
    }

    if(!empty($custom->base)){
      foreach($custom->base as $info4){
          $output6[]=$info4;
      }
  }
          if(!empty($custom->size)){
            foreach($custom->size as $info4){
                $output6[]=$info4;
            }
        }
          if(!empty($output6)!=null){
          $output7=implode(',',$output6);
          }else{
            $output7='';
          }
      } 
            $data_array=array(
                'order_id'=>$order_id,
                'item_id'=>$info->citem_id,
                'cart_count'=>$info->quantity,
                'user_id'=>$info->cuser_id,
                'cprice'=>$info->price,
                'customization'=>$info->customization,
                'item_size'=>$info->item_size,
                'item_price'=>$info->item_price,
                'created_date'=>date('y-m-d')
            );
            $order_details_id=$this->cm->save($data_array,'mst_order_details');
            $where=array('sk_id'=>$info->citem_id);
            $items=$this->cm->getRecords($where,'mlt_items_onboarding');
            $item_name='';
            if($items){
                foreach($items as $iinfo){
                    $item_name=$iinfo->item_name;
                }
            }
            $innerData = array();
            $temp=$temp1=$temp2=array();
            $temp["key"] = "productName";
            $temp["value"] = $item_name;
            $innerData[]=$temp;
            $temp1["key"] = "quantity";
            $temp1["value"] = $info->quantity;
            $innerData[]=$temp1;
            $temp2["key"] = "price";
            $temp2["value"] = $info->price;
            $innerData[]=$temp2;
            $temp3["key"] = "customisation";
            $temp3["value"] = $output7;
            $innerData[]=$temp3;
            $field['sequence']=$i++;;
            $field['fields']=$innerData;
            $output2[]=$field;

        
    }
    if($payment_mode=='Cash'){
      $output299='{
        "key":"modeOfPayment",
        "value":"COD"
      },';
    }else{
      $output299='{
        "key":"modeOfPayment",
        "value":"Prepaid"
      },';
    }
    $input=json_encode($output2);

    $slotAndLevel = '';
    if($slotId!='' && $inputLevel!=''){
      $slotAndLevel = '{
        "key": "slotId",
        "value": '."$slotId".'
      },
      {
        "key": "level",
        "value": '."$inputLevel".'
      },';

      $where=array('msg'=>$slotAndLevel);
    }
   
    // echo $slotAndLevel;exit();
    $output='{"templateId": "6422919068516352",
        "fields": [
          {
            "key": "jobCode",
            "value":'."$order_id1".'
          },
          {
            "key": "description",
            "value": '."$total_price".'
          },
          {
            "key": "expectedTime",
            "value": '.$datetime1.'
          },
          {
            "key": "totalAmount",
            "value": '."$total_price".'
          }, 
          {
            "key": "source",
            "value": "ECOMMERCE"
          },
          {
            "key": "collectableAmount",
            "value": '."$total_price".'
          },
          {
            "key": "customerName",
            "value": '."$user_name".'
          },
          {
            "key": "customerMobileNo",
            "value": '."$mobile".'
          },
          {
            "key": "dropAddress",
            "value": '."$output1".'
          },
          {
            "key": "dropLocation",
            "value": '."$lat_lon".'
          },
          {
            "key": "customerId",
            "value": '."$email".'          },
          {
            "key": "notes",
            "value": "EXtra cheese"
          },
          {
            "key": "jobType",
            "value": "DROP"
          },
          {
            "key": "validator",
            "value": "com.dista.bulkupload.interfieldvalidator.FTVJobValidator"
          },
          '.$slotAndLevel.'
          {
            "key": "demand",
            "value": "1"
          },
          {
            "key": "priority",
            "value": "5"
          },
          '.$output299.'
          {
            "key": "productSection",
            "repeatingSection": '.$input.'
          }
        ]}';
   // echo json_encode(array('output'=>$output));exit;
    $out = $output;
    if($party_time!='yes'){

      $login_access_token_header = array('Content-Type:application/json','CLIENT_ID:4540555161763840');
      $makecall = $this->common->callAPI('POST', "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/baseApi/v1/job/createJobFromEcom", $output, $login_access_token_header);
   $result=json_decode($makecall);
              
             $status=$result->status; 
             $jobId =$level=$templateId=$updatedAt=$createdAt=$jobstatusid=$jobstatusname=$message=$customerJobType=$jobCode='';
             if($status=='success'){
                if($result->data!=''){
                    //foreach($result->data as $info5){
                        $jobId=$result->data->jobId;
                        $level=$result->data->level;
                        $templateId=$result->data->templateId;
                        $updatedAt=$result->data->updatedAt;
                        $createdAt=$result->data->createdAt;
                        if($result->data->jobStatus){
                            //foreach($result->data->jobStatus as $info6){
                                $jobStatusid=$result->data->jobStatus->id;
                                $jobStatusname=$result->data->jobStatus->name;
                            //}
                        }
                        $message=$result->data->message;
                        $customerJobType=$result->data->customerJobType;
                        $jobCode=$result->data->jobCode;
                   // }
                }
                $update_data=array(
                    "jobId"=>$jobId,
                    "level"=>$level,
                    "templateId"=>$templateId,
                    "updatedAt"=>$updatedAt,
                    "createdAt"=>$createdAt,
                    "jobStatusid"=>$jobStatusid,
                    "jobStatusname"=>$jobStatusname,
                    "message"=>$message,
                    "customerJobType"=>$customerJobType,
                    "jobCode"=>$jobCode
                );
                $where=array('sk_order_id'=>$order_id);
                $this->cm->updateRecords($update_data,$where,'mlt_order');
              } 
            }     
    if($order_id!=''){
      if($party_time=='no'){
       $where=array('cuser_id'=>$data['user_id'],'party_time'=>0);
       $this->cm->deleteRecords($where,'mlt_cart');
       $this->session->set_userdata('cart_count',0);
       $data_order=array('order_id'=>$order_id);
       $where=array('sk_address_id'=>$address_id);
       $this->cm->updateRecords($data_order,$where,'mlt_address_dup');

      }else{
        $where=array('cuser_id'=>$data['user_id'],'party_time'=>1);
        $this->cm->deleteRecords($where,'mlt_cart');
        $where=array('user_id'=>$data['user_id'],'temp_package_status'=>0);
        $data_update=array('temp_package_status'=>1,'order_id'=>$order_id);
        $this->cm->updateRecords($data_update,$where,'mlt_user_packages');
        $data_order=array('order_id'=>$order_id);
        $where=array('sk_address_id'=>$address_id);
        $this->cm->updateRecords($data_order,$where,'mlt_address_dup');
      }
      

    }
    if($order_id!=''){
      if($data['referal_code']!=''){
        $where=array('user_id'=>$data['referal_code'],'friend_id'=>$data['user_id']);
        $coupon_user_details=$this->cm->getRecords($where,'mst_coupons');
        $coupon_price=0;
        if($coupon_user_details!=false){
          foreach($coupon_user_details as $info90){
                  $coupon_price=$info90->coupon_price;
          } 
        }
        $coupon_price=$coupon_price+100;
         $coupon_code='REFER';
       $coupon_code=$coupon_code.$coupon_price;
       $data_save=array('user_id'=>$data['referal_code'],'friend_id'=>$data['user_id']);
       $this->cm->save($data_save,'mst_refer_friends');

      $data_save=array('coupon_code'=>$coupon_code,'description'=>'refering friend','coupon_type'=>'Fixed Item Discount','coupon_price'=>$coupon_price,'expiry_date'=>'2021-12-23','limit_per_coupon'=>'10','limit_per_user'=>'20','user_id'=>$data['referal_code'],'friend_id'=>$data['user_id']);
      $this->cm->save($data_save,'mst_coupons');
        }
    }

    //  $date6=gmdate(DATE_ATOM,strtotime(date("Y-m-dH:i:s")));
    $data['order_id']=$this->session->set_userdata('order_id',$order_id);
    // if($delivery_date==date("Y-m-d")){
      if($party_time!="yes"){
        $order_id2=base64_encode($order_id);
        $verifyEmail_link=base_url().'order-track?id='.$order_id2;
        $output='<p>Hello '.$user_name1.',</p>';
        $output.='<p>Thank you for Order</p>';
        $output.='<p>Please click the below link to track order.</p><form
                <p><a href='.$verifyEmail_link.'>'.$verifyEmail_link.'</a></p>';
        $output.='<p>Cheers,</p>';
        $output.='<p>The MLT Team</p>';
        $body = $output;
        $subject = "Thank You";
$emailInfo=$this->sendEmailOne($email_to,$subject,$body);
    echo json_encode(array("redirect_url"=>base_url().'order-confirmed','order_id'=>$order_id));
      }else{
      
        echo json_encode(array("redirect_url"=>base_url().'party-time-confirmed','order_id'=>$order_id));
      }
    }else{
      $this->cm->deleteRecords(array('sk_order_id'=>$order_id),'mlt_order');
      echo json_encode(array("redirect_url"=>false));
    }
    // }else{
    //   echo json_encode(array("redirect_url"=>base_url().'order-scheduled','order_id'=>$order_id,'output'=>$out));
    // }
  }

    public function order_confirmed(){
        $data=$this->common_data();
        $this->load->view('website/order-confirmed',$data);
    }

    public function order_scheduled(){
      $data=$this->common_data();
      $this->load->view('website/order-scheduled',$data);
  }

public function getToppingModalMyFav()
    {
      $cust_img=base_url()."assets/images/cust.png";

      $output="";
      $cancel_img=$uparr_img=$mgrimg="";
      $cancel_img=base_url()."assets/images/cancel.png";
      $mgrimg=base_url()."assets/images/mgrimg.png";
      $uparr_img=base_url()."assets/images/uparr.png";
      $item_id=$this->input->post('item_id');
      $item_name=$this->input->post('item_name');
      
      $selected_val=$this->input->post('selected_val');
      $type=$this->input->post('type');
      $selected_val1=$this->input->post('selected_val1');
      $where=array('sk_id'=>$item_id);
      $item_onboard_details=$this->cm->getRecords($where,'mlt_items_onboarding');
      if($item_onboard_details){
          foreach($item_onboard_details as $info9){
              $item_display_name=$info9->display_name;
              $type1=$info9->type;

          }
      }
      $topping_size_details="";
  $where=array('item_id'=>$item_id,'item_status'=>1);
  $topping_size_details=$this->cm->getRecords($where,'mlt_price');
  $size_details="";$output6='';
  if($topping_size_details)
  {
      $k=1;
      foreach($topping_size_details as $size_info)
      {
        
          if($selected_val==$size_info->sk_id){
            $selected="checked";
            $output6=$size_info->item_size.'₹'.$size_info->item_cost;
          }else{
            $selected="";
          }
          $size_details=$size_details."<div class='col-md-6'>
          <div class='custom-control custom-radio  mb-3'>
                    <input type='radio' id='size$k' name='sizes' value='$size_info->item_size#$item_id' class='custom-control-input csize' $selected>
                    <label class='custom-control-label ml-2' for='size$k'>$size_info->item_size 
                      ₹$size_info->item_cost</label> 
                      </div></div>";
                      $k++;
      }
  }
  
  /* $topping_head_details="";
  $where=array('toping_status'=>1);
  $topping_head_details=$this->cm->getRecords($where,'mlt_topings'); */

$sql="SELECT DISTINCT(mlt_item_toppings.topping_id) as toping_id,mlt_topings.toping_head FROM mlt_item_toppings,mlt_topings WHERE mlt_item_toppings.item_id=$item_id and mlt_item_toppings.topping_id=mlt_topings.toping_id and mlt_topings.toping_status=1";
$binds="";
$topping_head_details=$this->cm->getRecordsQuery($sql, $binds);

$toppingHead="";

$i=1;if($topping_head_details){foreach($topping_head_details as $tinfo){ 
  if($i==1){$menu_active='active';}else{$menu_active='';} 
  $menuClass="topping".$i;    
  $toppingHead=$toppingHead."<li><a class='list-group-item list-group-item-action $menu_active $menuClass'   href='#topping$i' onclick='getToppingId($tinfo->toping_id)'>$tinfo->toping_head</a></li>";
    $i++;}}  
    $menuSizeClass="topping".($i);
    $menuClick=" onclick='getToppingId($i)'";
    $toppingDetails="";$toppingDetails1="";
  $j=1;if($topping_head_details){foreach($topping_head_details as $tp_info){  
      $where=array('item_id'=>$item_id,"topping_id"=>$tp_info->toping_id);
      $topping_item_details=$this->cm->getRecords($where,'mlt_item_toppings'); 
      if($topping_item_details){

$item_details="";$p=1;
$selected10='';
            foreach($topping_item_details as $tpitem){ $toppingItem=rtrim($tpitem->items,',');  
              $empty_cart_id = '';                  
              $tmp=explode(',',$toppingItem);                                   
              for($k=0;$k<sizeof($tmp);$k++){
               if($tmp[$k]!='') {
                   if($tpitem->topping_id!=4) {
                    if($type=='veg' && $tpitem->topping_id==2){
                       $selected10='disabled';
                    }
              $item_details=$item_details."<div class='col-md-6'>
              <div class='custom-control custom-checkbox mb-3'>
              <input type='hidden' value='$item_id' class='item-id'>
                <input type='checkbox' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='$tp_info->toping_head custom-control-input id-$tpitem->topping_id-select sjhd' id='customCheck$tp_info->toping_id$p' $selected10>
                <label class='custom-control-label pl-2' for='customCheck$tp_info->toping_id$p' $selected>$tmp[$k]</label>
              </div>
              </div>";
                   }
                   else{
                      if($selected_val1==$tmp[$k]){$selected="checked";}else{$selected="";}
                      $item_details=$item_details."<div class='col-md-6'>
                      <div class='custom-control custom-radio  mb-3'>
                                <input type='radio' id='cbase$p' name='cbase' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='custom-control-input cbase'$selected>
                                <label class='custom-control-label pl-2' for='cbase$p'>$tmp[$k]</label> 
                                  </div></div>";
                   }
               }
                $p++;}}   
$output='';

                if($tp_info->toping_head!='Base'){
                  $output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head (0/3)</div>
                  <div class='vegcontent'>You can choose upto 3 options</div>";
                  } else{$output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head</div>
                    <div class='vegcontent'>You can choose only 1 option</div>";
                  }
    $toppingDetails=$toppingDetails."<div class='card mb-4' id='topping$j'>
      <div class='card-header' id='heading$j'>
        <h2 class='mb-0'>
          <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
            data-target='#collapse$j' aria-expanded='true' aria-controls='collapse$j'>
            <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
            </div>
            $output
          </button>
        </h2>
      </div>
      <div id='collapse$j' class='collapse show' aria-labelledby='heading$j'
        data-parent='#accordionExample'>
        <div class='card-body row topping-list'>    
          $item_details 
        </div>
      </div>
    </div>"; 
    }$j++;}} 


     
      $output="<div class='modal-body'>
      <button type='button' class='close ' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'><div><img class='img-fluid ' src='$cancel_img' alt=''></div></span>
      </button>
      <div class=' d-flex mgr-path ss'>
        <div><img src='$mgrimg' class='img-fluid '></div>
        <h1 class='pizza-header mb-4 pl-2'>FMG <span class='pizzaheader-mgr'>$item_display_name-$item_name</span>
        </h1>
      </div>
      <div class='mgr-line'></div>
      <div class='Customization-text mt-4'>Customization <div class='customize_err_message' style='display:none'> <div class='d-flex'>
      <img class='' src='$cust_img'>
      <p class='ml-md-2 align-self-center'><span class='fw-500'>OOPS!</span>You’ve chosen maximum of 3 options</p>
  </div></div></div>
      <div id='navbar-example2'>
        <div class='tabs-scroll'>
        <ul id='list-example' class=' customize-list d-flex mt-3'>
          $toppingHead
            <li><a class='list-group-item list-group-item-action' href='#size'>Size</a></li> 
        </ul>
      </div>";
    $toppingDetails1=$toppingDetails1."<div class='card mb-4' id='size'>
      <div class='card-header' id='headingOne'>
        <h2 class='mb-0'>
          <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
            data-target='#collapse5' aria-expanded='true' aria-controls='collapse5'>
            <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
            </div>
            <div class='vegtext'>Size</div> 
          </button>
        </h2>
      </div>
      <div id='collapse5' class='collapse show' aria-labelledby='heading5'
        data-parent='#accordionExample'>
        <div class='card-body row topping-list'> $size_details 
        </div>
      </div>
    </div>"; 
    

  
    $output6=$selected_val1.' ,'.$output6;

   
    $output="<div class='modal-body'>
    <button type='button' class='close ' data-dismiss='modal' aria-label='Close'>
      <span aria-hidden='true'><div><img class='img-fluid ' src='$cancel_img' alt=''></div></span>
    </button>
    <div class=' d-flex mgr-path ss'>
      <div><img src='$mgrimg' class='img-fluid '></div>
      <h1 class='pizza-header mb-4 pl-2'><span class='pizzaheader-mgr'>$item_display_name-$item_name</span>
      </h1>
     
    </div>
    <div class='mgr-line'></div>
    <div class='Customization-text mt-4' >Customization  <div class='d-flex customize_err_message' style='display:none'>
    <img class='' src='$cust_img'>
    <p class='ml-md-2 align-self-center'><span class='fw-500'>OOPS!</span>You’ve chosen maximum of 3 options</p>
</div></div></div>
    
    <div id='navbar-example2'>
      <div class='tabs-scroll'>
      <ul id='list-example' class=' customize-list d-flex mt-3'>
        $toppingHead
          <li><a class='list-group-item list-group-item-action $menuSizeClass' href='#size' $menuClick>Size</a></li> 
      </ul>
    </div>
    </div>
    <div class='customize-scroll accordion scrolling-bar custom-scrollbar' id='accordionExample' data-spy='scroll'
      data-target='#navbar-example2' data-offset='0'>
      $toppingDetails 
      $toppingDetails1
    </div>
  </div>
  
  <div class=' add-card'>
    <div class='d-flex addcard'>
      <div class='mx-222 mt-3'>
              <div class='customize coustamize_selected'>$output6</div>

        <div class='card-amount mb-1' id='card-amount'>₹$size_info->item_cost</div>
        <div class='card-cust'>CUSTOMIZED</div>
      </div>
      <input type='hidden' id='ccart_id'/>
      <input type='hidden' id='cart_size'/>
      <div class='ml-auto align-self-center'>
      <div class='count-cust '></div>
      <button class='addcard-item ml-auto ' onclick=getValue1(this,$item_id,$size_info->item_cost,-1,'update')>Add to Cart</button></div>
    </div>
  </div>";

  echo $output;
    }

public function saved_address(){
    $data=$this->common_data();  
   if($data['user_id']!=''){
    $where=array('user_id'=>$data['user_id']);
   $data['getdetail']=$this->cm->getRecords($where,'mlt_address'); 
    $this->load->view('website/saved-address',$data);
   }else{
     redirect('/');
   }
}




public function addadress1(){
  $data=$this->common_data();
  $url= $data['admin_url'];
  $city=$this->input->post('city');
   $address_id=$this->input->post('address_id');
  $la=$this->input->post('la');
  $pincode=$this->input->post('pincode');
  $lo=$this->input->post('lo');
  $stateName=$this->input->post('stateName');
  $countryName=$this->input->post('countryName');
  $locality=$this->input->post('locality');
  $address_deatils=$this->input->post('address_deatils');
  $address_type=$this->input->post('address_type');
  $house=$this->input->post('house');
  $land=$this->input->post('land');
  $loginDetails='';
  if($address_id==0){
              $data_array=array(
      "user_id"=>$data['user_id'],
      "address_type"=>$address_type,
      "area"=>$city,
      "city"=>$locality,
      "state"=>$stateName,
      "country"=>$countryName,
      "pincode"=>$pincode,
      "street"=>$land,
      "latitude"=>$la,
      "longitude"=>$lo,
      "full_address"=>$address_deatils,
      "address_status"=>1,
      "house_no"=>$house
  );
  $id=$this->cm->save($data_array,'mlt_address');
  $where=array('sk_user_id'=>$data['user_id'],'user_status'=>1);
      $loginDetails=$this->cm->getrecords($where,'mst_user');
  }else{
      $data_array=array(
          "user_id"=>$data['user_id'],
          "address_type"=>$address_type,
          "area"=>$city,
          "city"=>$locality,
          "state"=>$stateName,
          "country"=>$countryName,
          "pincode"=>$pincode,
          "street"=>$land,
          "latitude"=>$la,
          "longitude"=>$lo,
          "full_address"=>$address_deatils,
          "address_status"=>1,
          "house_no"=>$house
      );
      $where=array('sk_address_id'=>$address_id);
      $id=$this->cm->updateRecords($data_array,$where,'mlt_address');
      $where=array('sk_user_id'=>$data['user_id'],'user_status'=>1);
          $loginDetails=$this->cm->getrecords($where,'mst_user');
  }
      $name=$user_id='';
      if($loginDetails!=false){
          foreach($loginDetails as $info){
              $name=$info->full_name;
              $user_id=$info->sk_user_id;
              $where=array('user_id'=>$user_id,'address_status'=>1);
              $addressdetails=$this->cm->getrecords($where,'mlt_address');
              $temp=array();
              $output='';

              if($addressdetails!=false){
                  foreach($addressdetails as $info1){
                      $address['sk_address_id']=$info1->sk_address_id;
                      $address['area']=$info1->area;
                      $address['city']=$info1->city;
                      $address['state']=$info1->state;
                      $address['country']=$info1->country;
                      $address['pincode']=$info1->pincode;
                      $address['street']=$info1->street;
                      $address['full_address']=$info1->full_address;

                      $address['country_code']=$info1->country_code;
                      $address['state_code']=$info1->state_code;
                      $address['address_type']=$info1->address_type;
                     // $address['address_type']=$info1->address_type;
                      $address['house_no']=$info1->house_no;

                       if($info1->address_type=='Work'){
                        $url1 =$url.'assets/images/work.png';
                         $img="<img  class='img-fluid homee '  src='$url1' alt=''>";
                       }
                      else if($info1->address_type=='Home'){
                        $url1 =$url.'assets/images/home1.png';

                      $img="<img  class='img-fluid homee '  src='$url1' alt=''>";

                    } else if($info1->address_type=='Other'){
                      $url1 =$url.'assets/images/other.png';

                     $img="<img  class='img-fluid homee '  src='$url1' alt=''>";

                   } 
                     $output=$output."<li class='line-save'>
                      <div class='d-flex  home-pic ml-15'>
                                     $img           
                          <p class='f-20 home-text fw-600'>$info1->address_type</p>
                      </div>
                      <input type='hidden' value='$info1->sk_address_id' name='address_id' id='address_id$info1->sk_address_id'>
                      <p class=' tower-a'>$info1->house_no $info1->full_address</p>
                      <div class=' tower-a'>
                              <!-- <a href='#' onclick='edit_add($info1->sk_address_id,'edit');'><p class='edit-delete fw-500 edit-add'>Edit</p></a>
                              <p class='edit-delete fw-500 ml-4 delete-add' >Delete</p>
                          </a> -->
                          <a class='d-flex  ' href='#'>
                              <p class='edit-delete fw-500' onclick=myFunction($info1->sk_address_id,'edit')>Edit</p>
                              <p class='edit-delete fw-500 ml-4' onclick=myFunction($info1->sk_address_id,'delete')>Delete</p>
                          </a>
                      </div>
                  </li>";





                      // $output=$output."<div class='custom-control custom-radio home--brder mt-3 '>
                      //             <input type='radio' class='custom-control-input adress-type' value=".$address['sk_address_id']." name='customRadio-adddress' id='customRadio".$address['sk_address_id']."'>
                      //             <label class='custom-control-label' for='customRadio".$address['sk_address_id']."'><p class='fw-600 homiie'>".$address['address_type']."</p>
                      //                 <p class='p-sec fw-400 grand-viw address-full'>".$address['house_no'].' '.$address['full_address'].'</p>
                      //             </label>
                      //         </div></div>';
                  }
              }

          }
         $url2= $url.'assets/images/plus1.png';
          $output=$output."<div class='bor-top'>
                        <button class='default-btn fw-500 add-addres' onclick='addAddress()'>ADD new Address <img class='img-fluid pluse1' src='$url2' alt=''> </button>
                    </div>";
          
          echo json_encode(array("name"=>$name,"user_id"=>$user_id,"addressdetails"=>$output));
      }
}








public function addadress(){
    $data=$this->common_data();
    $url= $data['admin_url'];
    $city=$this->input->post('city');
     $address_id=$this->input->post('address_id');
    $la=$this->input->post('la');
    $pincode=$this->input->post('pincode');
    $lo=$this->input->post('lo');
    $stateName=$this->input->post('stateName');
    $countryName=$this->input->post('countryName');
    $locality=$this->input->post('locality');
    $address_deatils=$this->input->post('address_deatils');
    $address_type=$this->input->post('address_type');
    $house=$this->input->post('house');
    $land=$this->input->post('land');
    $loginDetails='';
    if($address_id==0){
                $data_array=array(
        "user_id"=>$data['user_id'],
        "address_type"=>$address_type,
        "area"=>$city,
        "city"=>$locality,
        "state"=>$stateName,
        "country"=>$countryName,
        "pincode"=>$pincode,
        "street"=>$land,
        "latitude"=>$la,
        "longitude"=>$lo,
        "full_address"=>$address_deatils,
        "address_status"=>1,
        "house_no"=>$house
    );
    $id=$this->cm->save($data_array,'mlt_address');
    $where=array('sk_user_id'=>$data['user_id'],'user_status'=>1);
        $loginDetails=$this->cm->getrecords($where,'mst_user');
    }else{
        $data_array=array(
            "user_id"=>$data['user_id'],
            "address_type"=>$address_type,
            "area"=>$city,
            "city"=>$locality,
            "state"=>$stateName,
            "country"=>$countryName,
            "pincode"=>$pincode,
            "street"=>$land,
            "latitude"=>$la,
            "longitude"=>$lo,
            "full_address"=>$address_deatils,
            "address_status"=>1,
            "house_no"=>$house
        );
        $where=array('sk_address_id'=>$address_id);
        $id=$this->cm->updateRecords($data_array,$where,'mlt_address');
        $where=array('sk_user_id'=>$data['user_id'],'user_status'=>1);
            $loginDetails=$this->cm->getrecords($where,'mst_user');
    }
        $name=$user_id='';
        if($loginDetails!=false){
            foreach($loginDetails as $info){
                $name=$info->full_name;
                $user_id=$info->sk_user_id;
                $where=array('user_id'=>$user_id,'address_status'=>1);
                $addressdetails=$this->cm->getrecords($where,'mlt_address');
                $temp=array();
                $output='';

                if($addressdetails!=false){
                    foreach($addressdetails as $info1){
                        $address['sk_address_id']=$info1->sk_address_id;
                        $address['area']=$info1->area;
                        $address['city']=$info1->city;
                        $address['state']=$info1->state;
                        $address['country']=$info1->country;
                        $address['pincode']=$info1->pincode;
                        $address['street']=$info1->street;
                        $address['full_address']=$info1->full_address;

                        $address['country_code']=$info1->country_code;
                        $address['state_code']=$info1->state_code;
                        $address['address_type']=$info1->address_type;
                       // $address['address_type']=$info1->address_type;
                        $address['house_no']=$info1->house_no;

                    //      if($info1->address_type=='Work'){
                    //       $url1 =$url.'assets/images/work.png';
                    //        $img="<img  class='img-fluid homee '  src='$url1' alt=''>";
                    //      }
                    //     else if($info1->address_type=='Home'){
                    //       $url1 =$url.'assets/images/home1.png';

                    //     $img="<img  class='img-fluid homee '  src='$url1' alt=''>";

                    //   } else if($info1->address_type=='Other'){
                    //     $url1 =$url.'assets/images/other.png';

                    //    $img="<img  class='img-fluid homee '  src='$url1' alt=''>";

                    //  } 
                    //    $output=$output."<li class='line-save'>
                    //     <div class='d-flex  home-pic ml-15'>
                    //                    $img           
                    //         <p class='f-20 home-text fw-600'>$info1->address_type</p>
                    //     </div>
                    //     <input type='hidden' value='$info1->sk_address_id' name='address_id' id='address_id$info1->sk_address_id'>
                    //     <p class=' tower-a'>$info1->house_no $info1->full_address</p>
                    //     <div class=' tower-a'>
                    //             <!-- <a href='#' onclick='edit_add($info1->sk_address_id,'edit');'><p class='edit-delete fw-500 edit-add'>Edit</p></a>
                    //             <p class='edit-delete fw-500 ml-4 delete-add'>Delete</p>
                    //         </a> -->
                    //         <a class='d-flex  ' href='#'>
                    //             <p class='edit-delete fw-500' onclick='myFunction($info1->sk_address_id,'edit')' >Edit</p>
                    //             <p class='edit-delete fw-500 ml-4' onclick='myFunction($info1->sk_address_id,'delete')'>Delete</p>
                    //         </a>
                    //     </div>
                    // </li>";





                        $output=$output."<div class='custom-control custom-radio home--brder mt-3 '>
                                    <input type='radio' class='custom-control-input adress-type' value=".$address['sk_address_id']." name='customRadio-adddress' id='customRadio".$address['sk_address_id']."'>
                                    <label class='custom-control-label' for='customRadio".$address['sk_address_id']."'><p class='fw-600 homiie'>".$address['address_type']."</p>
                                        <p class='p-sec fw-400 grand-viw address-full'>".$address['house_no'].' '.$address['full_address'].'</p>
                                    </label>
                                </div></div>';
                    }
                }

            }
           
            
            echo json_encode(array("name"=>$name,"user_id"=>$user_id,"addressdetails"=>$output));
        }
}


public function about_us(){
    $data=$this->common_data(); 
    $this->load->view('website/about',$data);
}
public function order_history(){
    $data=$this->common_data(); 
    $getdetails=$this->am->orderDetails($data['user_id']);
     if($getdetails){   
        $data['getdetails']=$getdetails;
    $this->load->view('website/order-history',$data);
     }else{
        $this->load->view('website/no-order-emptystate',$data);

     }
}
public function vieworder(){
  $data=$this->common_data(); $getView='';$one='';$final='';$tot='';
   $id=$this->input->post('sk_order_id');
   $val=$this->input->post('val');
if($val=='user'){
  $getdetail=$this->am->viewOrderDetails($id);
  if($getdetail!=false){
   foreach($getdetail as $dinfo){
             $orderid=$dinfo->order_id;
              $orderdd=$dinfo->order_delivery_date;
              $date=date_create($orderdd);
              $getData=date_format($date,"d M");
               $type1=$dinfo->address_type; 
              $price=$dinfo->cprice;
              $cart=$dinfo->cart_count;
            $useraddress=$dinfo->full_address;
           $houseno=$dinfo->house_no;
           $street=$dinfo->street; 
          $rating='';
              //$type1=$dinfo->address_type;
              $itemprice=$dinfo->item_price;
              $itemsize=$dinfo->item_size;
              $skorderid=$dinfo->sk_order_id;
              $ordervalue=$dinfo->total_order_value;
              $displayname=$dinfo->display_name;
              $itemname=$dinfo->item_name;
              $quantity=$dinfo->total_order_quantity;
              $orderstatus=$dinfo->order_status;
              $orderdt=$dinfo->order_delivery_time;
              $sectionname=$dinfo->section_name;
              $desc=$dinfo->short_description;
              $descr=$dinfo->description;
              $user_pin_number=$dinfo->user_pin_number;
              $type=$dinfo->orderType;
              if($dinfo->rating!=null && $dinfo->rating!=''){
                $rating=$dinfo->rating;
              }

              $pic=$dinfo->image;
              $image_url=admin_img_url.'items/'.$pic; 
  $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $ordervalue);
  $num123 = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $price);

$one="<div class='order--no d-flex'>
<p class='fw-600 details-no mr-auto'>ORDER DETAILS</p>
<p class='fs-18 fw-500 cost-invoice'>₹$num</p>
</div>";

$getView.="<div class='media mt-3 on-amt'>
<img class='img-fluid' src='$image_url' alt='' style='width:70px;height:50px'>
  <div class='media-body ml-3 '>
      <div class='d-flex'>
          <p class='fw-600'>$displayname<span class='itali-invoice'> - $itemname</span> </p>
          <div class=''>    <img class='img-fluid detail-eclipse align-self-center pl-2 mr-auto ' src='".$data['admin_url']."/assets/images/dot.png' alt=''></div>
          <p class='fs-18 fw-500 rate-invoice ml-auto'>₹$num123</p>
      </div>
      <p class='p-sec extras-invoice mt-2'>$desc</p>
      <p class='fw-400 quntity'>Qty:$cart</p>
  </div>      
</div>
<div class='white-line'></div>";

$final="<a href='#' class='download-invoice mt-4 mb-4' >Download Invoice</a>";
 
 

            }   
}
$tot=$one.$getView.$final;
echo $orderid.'&&'.$getData.'&&'.$ordervalue.'&&'.$useraddress.'&&'.$type1.'&&'.$tot.'&&'.$itemname.'&&'.$quantity.'&&'.$ordervalue.'&&'.$orderstatus.'&&'.$orderdt.'&&'.$sectionname.'&&'.$itemname.'&&'.$displayname.'&&'.$desc.'&&'.$descr.'&&'.$pic.'&&'.$houseno.'&&'.$street.'&&'.$rating.'&&'.$user_pin_number;

  }
  
else{
    $getdetail=$this->am->viewOrderDetailsforguest($id);
  if($getdetail!=false){
   foreach($getdetail as $dinfo){
             $orderid=$dinfo->order_id;
              $orderdd=$dinfo->ordered_date;
              $date=date_create($orderdd);
              $getData=date_format($date,"d M");
               $type1=$dinfo->user_city; 
              $price=$dinfo->cprice;
              $cart=$dinfo->cart_count;
           $useraddress=$dinfo->landmark;
           $houseno=$dinfo->user_houseno;
           $street=$dinfo->user_address1; 
          $rating='';
          $user_pin_number=$dinfo->user_pin_number;
              //$type1=$dinfo->address_type;
              $itemprice=$dinfo->item_price;
              $itemsize=$dinfo->item_size;
              $skorderid=$dinfo->sk_order_id;
              $ordervalue=$dinfo->total_order_value;
              $displayname=$dinfo->display_name;
              $itemname=$dinfo->item_name;
              $quantity=$dinfo->total_order_quantity;
              $orderstatus=$dinfo->order_status;
              $orderdt=$dinfo->order_delivery_time;
              $sectionname=$dinfo->section_name;
              $desc=$dinfo->short_description;
              $descr=$dinfo->description;
              $type=$dinfo->orderType;
              if($dinfo->rating!=null && $dinfo->rating!=''){
                $rating=$dinfo->rating;
              }

              $pic=$dinfo->image;
              $image_url=admin_img_url.'items/'.$pic; 
              $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $ordervalue);

$one="<div class='order--no d-flex'>
<p class='fw-600 details-no mr-auto'>ORDER DETAILS</p>
<p class='fs-18 fw-500 cost-invoice'>₹$num</p>
</div>";

$getView.="<div class='media mt-3 on-amt'>
<img class='img-fluid' src='$image_url' alt='' style='width:70px;height:50px'>
  <div class='media-body ml-3 '>
      <div class='d-flex'>
          <p class='fw-600'>$displayname<span class='itali-invoice'> - $itemname</span> </p>
          <div class=''>    <img class='img-fluid  align-self-center pl-2 mr-auto ' src='".$data['admin_url']."/assets/images/dot.png' alt=''></div>
          <p class='fs-18 fw-500 rate-invoice ml-auto'>₹$price</p>
      </div>
      <p class='p-sec extras-invoice mt-2'>$desc</p>
      <p class='fw-400 quntity'>Qty:$cart</p>
  </div>      
</div>
<div class='white-line'></div>";

$final="<a href='#' class='download-invoice mt-4 mb-4' >Download Invoice</a>";
 
            }         
          }
          
$tot=$one.$getView.$final;
echo $orderid.'&&'.$getData.'&&'.$ordervalue.'&&'.$useraddress.'&&'.$type1.'&&'.$tot.'&&'.$itemname.'&&'.$quantity.'&&'.$ordervalue.'&&'.$orderstatus.'&&'.$orderdt.'&&'.$sectionname.'&&'.$itemname.'&&'.$displayname.'&&'.$desc.'&&'.$descr.'&&'.$pic.'&&'.$houseno.'&&'.$street.'&&'.$rating.'&&'.$user_pin_number;
        } 


 // $this->load->view('website/about',$data);

}


    public function edit_address(){
        $data=$this->common_data();
        $address_edit=false;
        $address_id=$this->input->post('id');
        $operation=$this->input->post('operation');
        $where=array('sk_address_id'=>$address_id);
        if($operation=='edit'){
        $address_edit=$this->cm->getRecords($where,'mlt_address');
        }else{
            $this->cm->deleteRecords($where,'mlt_address');

        }
        echo json_encode(array('address_edit'=>$address_edit));
    }
    public function addheadaddress(){
    $data=$this->common_data();
    $full_address=$this->input->post('full_address');
    $statedet=$this->input->post('state');
    $countrydet=$this->input->post('country');
    $complteaddress=$full_address.' '.$statedet.' '.$countrydet;
    $this->session->set_userdata('city',$complteaddress);
    $data['city']=$this->session->userdata('city'); 

    echo json_encode(array("complteaddress"=>$complteaddress));
    }   
    
public function editAddress(){
    $data=$this->common_data();
    $id=$this->input->post('id');
    $operations=$this->input->post('operations');

    $where=array('sk_address_id '=>$id);
    if($operations=='edit'){
    $getdetail=$this->cm->getRecords($where,'mlt_address');
    if($getdetail){
    foreach($getdetail as $row){
        $id=$row->sk_address_id;
        $latit=$row->latitude;
        $long=$row->longitude;
        $ufulladdress=$row->full_address;
        $uarea=$row->area;
        $houseno=$row->house_no;
        $landmark=$row->street;
        $typeaddress=$row->address_type;
        $city=$row->city;
        $state=$row->state;
        $country=$row->country;
        $pincode=$row->pincode;
      
    } 
    echo json_encode(array('address'=> $latit.'&&'.$long.'&&'.$ufulladdress.'&&'.$uarea.'&&'.$houseno.'&&'.$landmark.'&&'.$typeaddress.'&&'.$city.'&&'.$state.'&&'.$country.'&&'.$pincode.'&&'.$id));
    }
    }
    else{
        $getdetail=$this->cm->deleteRecords($where,'mlt_address'); 
        echo json_encode(array('false'=>'false'));
    }
    }
  



    public function getvaluesize(){
        $data=$this->common_data();
        $item_id=$this->input->post('item_id');
        $price=$this->input->post('price');
        $size=$this->input->post('size');
        $party_time=$this->input->post('party_time');
        if($party_time!=1){
        if($data['user_id']!=''){
          $where=array('item_size'=>$size,'cuser_id'=>$data['user_id'],'citem_id'=>$item_id,'party_time'=>0);
        }else{
          if($data['temporary_session_id']!=''){
            $where=array('item_size'=>$size,'cuser_id'=>$data['temporary_session_id'],'citem_id'=>$item_id,'party_time'=>0);
          }
          else{
            $where=array();
          }
        }
      }else{
        if($data['user_id']!=''){
          $where=array('item_size'=>$size,'cuser_id'=>$data['user_id'],'citem_id'=>$item_id,'party_time'=>1);
        }else{
          if($data['temporary_session_id']!=''){
            $where=array('item_size'=>$size,'cuser_id'=>$data['temporary_session_id'],'citem_id'=>$item_id,'party_time'=>1);
          }
          else{
            $where=array();
          }
        }
      }
        $getvalues=$this->cm->getRecords($where,'mlt_cart');
        if($getvalues){
            foreach($getvalues as $info){
                $cart_num=$info->quantity;
            }
            echo json_encode(array('quantity'=>$cart_num));
        }
        else{
            echo json_encode(array('quantity'=>false));

        }

    }

    function isMobileDevice() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
        |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
        , $_SERVER["HTTP_USER_AGENT"]);
        }
     
        



        public function guest_order(){
            $data=$this->common_data();
            $delivery_date=$this->input->post('delivery_date');
             $delivery_time=$this->input->post('delivery_time');
            $payment_mode=$this->input->post('payment_mode');
             $total_price1=$this->input->post('total_price');
             $coupon_id=$this->input->post('coupon_id');
            $total_order_quantity=$this->input->post('total_item');
            $party_time=$this->input->post('party_time');
            $lat=$this->input->post('lat');
            $lan=$this->input->post('lon');
            $output2 = array();

            $discount_amount=$this->input->post('discount_amt');
            $razor_payment_id=$this->input->post('razor_payment_id');
            $exampleInputemail=$this->input->post('exampleInputemail');
            $exampleInputname=$this->input->post('exampleInputname');
            $exampleInputmoblie=$this->input->post('exampleInputmoblie');
            $order_type=$this->input->post('order_type');
            $exampleInputaddress=$this->input->post('exampleInputaddress');
            $exampleInputcity=$this->input->post('exampleInputcity');
            $town=$this->input->post('town');

            $exampleInputnumber=$this->input->post('exampleInputnumber');
            $exampleInputhouseno=$this->input->post('exampleInputhouseno');
            if($coupon_id!=''){
              $where399 = array(
                'coupon_id'=>$sk_coupon_id, 
                'user_id'=>$data['temporary_session_id'],
                'txn_coupon_status'=>'0'    
            );
            $data_array29=array('txn_coupon_status'=>'1');
            $this->cm->updateRecords($data_array29,$where399,'txn_coupons');
            }
            $output1=$exampleInputhouseno.''.$exampleInputaddress.' '.$exampleInputcity.' '.$exampleInputnumber;   
            $rrr=$output1;
    $output1='"'.$rrr.'"';
    $lat_lon='"'.$lat.",".$lan.'"';
    $total_price='"'.$total_price1.'"';
    $user_name='"'.$exampleInputname.'"';
    $rrr=$exampleInputmoblie;
    $mobile='"'.$rrr.'"';
    $email_to=$exampleInputemail;
    $rrr=$exampleInputemail;
    $email='"'.$rrr.'"';
    date_default_timezone_set("Asia/Kolkata");     
    $datetime = $delivery_date.' '.$delivery_time;
    $event_date=date('Y-m-d H:i:s', strtotime($datetime));
      $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
      $datetime1='"'.$datetime.'"';
            $data_array=array(
                "user_id"=>$data['temporary_session_id'],
                "user_name"=>$exampleInputname,
                "user_email"=>$exampleInputemail,
                "user_moblie"=>$exampleInputmoblie,
                "user_houseno"=>$exampleInputhouseno,
                "user_address1"=>$town,
                "user_city"=>$exampleInputcity,
                "user_pin_number"=>$exampleInputnumber, 
                "order_type"=>$order_type, 
                "party_time"=>$party_time,
                "landmark"=>$exampleInputaddress,
                "ordered_date"=>date('y-m-d'),
                "ordered_time"=>date("H:i:s"),
                "total_order_quantity"=>$total_order_quantity,
                "total_order_value"=>$total_price1,
                "coupon_id"=>$coupon_id,
                "discount_amount"=>$discount_amount,
                "payment_mode"=>$payment_mode,
                "order_status"=>"CREATED",
                "order_delivery_date"=>$delivery_date,
                "order_delivery_time"=>$delivery_time,
                "razor_payment_id"=>$razor_payment_id
            );
            $order_id=$this->cm->save($data_array,'mlt_order');
            $order_id1='"CBE'.$order_id.'"';
            $notification=array(
              "notifiaction_label"=>"Order Placed",
              "notification_msg"=>"As per Your request,Order is placed",
              "notification_date"=>date('Y-m-d')
          );
          $this->cm->save($notification,'txn_notifications');
            if($party_time=='no'){
            $where=array('cuser_id'=>$data['temporary_session_id'],'party_time'=>0);
            }else{
              $where=array('cuser_id'=>$data['temporary_session_id'],'party_time'=>1);
            }
            $real_time_details='';$slotId=$inputLevel="";$asap=false;

            if($delivery_date!=date("Y-m-d")){
              $real_time_details=$this->realtime_feasabilty_check_for_tomorow($datetime,$lat,$lan);
              $json_time=json_decode($real_time_details);
        
              if($json_time!=''){
                      $slotId= $json_time->slot_id;
                      $inputLevel=$json_time->levele_id;
              }
            }  
            $cart_orders=$this->cm->getrecords($where,'mlt_cart');
            if($cart_orders){$i=1;
              foreach($cart_orders as $info){
$output6=array();
          if($info->customization){
                $custom=json_decode($info->customization);
                if(!empty($custom->veg)){
                  foreach($custom->veg as $info4){
                     $output6[]=$info4;
                  }
              }
              if(!empty($custom->nonveg)){
                foreach($custom->nonveg as $info4){
                    $output6[]=$info4;
                }
            }
      
            if(!empty($custom->flavor)){
              foreach($custom->flavor as $info4){
                  $output6[]=$info4;
              }
          }
      
          if(!empty($custom->base)){
            foreach($custom->base as $info4){
                $output6[]=$info4;
            }
        }
                if(!empty($custom->size)){
                  foreach($custom->size as $info4){
                      $output6[]=$info4;
                  }
              }
                if(!empty($output6)!=null){
                $output7=implode(',',$output6);
                }else{
                  $output7='';
                }
            }  
            $data_array=array(
                        'order_id'=>$order_id,
                        'item_id'=>$info->citem_id,
                        'cart_count'=>$info->quantity,
                        'user_id'=>$info->cuser_id,
                        'cprice'=>$info->price,
                        'customization'=>$info->customization,
                        'item_size'=>$info->item_size,
                        'item_price'=>$info->item_price,
                        'created_date'=>date('y-m-d')
                    );
                    $order_details_id=$this->cm->save($data_array,'mst_order_details');
                    $where=array('sk_id'=>$info->citem_id);
            $items=$this->cm->getRecords($where,'mlt_items_onboarding');
            $item_name='';
            if($items){
                foreach($items as $iinfo){
                    $item_name=$iinfo->item_name;
                }
            }
            $innerData = array();
            $temp=$temp1=$temp2=array();
            $temp["key"] = "productName";
            $temp["value"] = $item_name;
            $innerData[]=$temp;
            $temp1["key"] = "quantity";
            $temp1["value"] = $info->quantity;
            $innerData[]=$temp1;
            $temp2["key"] = "price";
            $temp2["value"] = $info->price;
            $innerData[]=$temp2;
            $temp3["key"] = "customization";
              $temp3["value"] = $output7;
            $innerData[]=$temp3;
            $field['sequence']=$i++;;

            $field['fields']=$innerData;
            $output2[]=$field;

        }

    }
    $output299='';
    if($payment_mode=='Cash'){
      $output299='{
        "key":"modeOfPayment",
        "value":"COD"
      },';
    }else{
      $output299='{
        "key":"modeOfPayment",
        "value":"Prepaid"
      },';
    }
    $input=json_encode($output2);

    $slotAndLevel = '';
    if($slotId!='' && $inputLevel!=''){
      $slotAndLevel = '{
        "key": "slotId",
        "value": '."$slotId".'
      },
      {
        "key": "level",
        "value": '."$inputLevel".'
      },';
    }
      
    
    $output='{"templateId": "6422919068516352",
        "fields": [
          {
            "key": "jobCode",
            "value":'."$order_id1".'
          },
          {
            "key": "description",
            "value": '."$total_price".'
          },
          {
            "key": "expectedTime",
            "value": '.$datetime1.'
          },
          {
            "key": "totalAmount",
            "value": '."$total_price".'
          }, 
          {
            "key": "source",
            "value": "ECOMMERCE"
          },
          {
            "key": "collectableAmount",
            "value": '."$total_price".'
          },
          {
            "key": "customerName",
            "value": '."$user_name".'
          },
          {
            "key": "customerMobileNo",
            "value": '."$mobile".'
          },
          {
            "key": "dropAddress",
            "value": '."$output1".'
          },
          {
            "key": "dropLocation",
            "value": '."$lat_lon".'
          },
          {
            "key": "customerId",
            "value": '."$email".'
          },
          {
            "key": "notes",
            "value": "EXtra cheese"
          },
          {
            "key": "jobType",
            "value": "DROP"
          },
          {
            "key": "validator",
            "value": "com.dista.bulkupload.interfieldvalidator.FTVJobValidator"
          },
          '.$slotAndLevel.'
          {
            "key": "demand",
            "value": "1"
          },
          {
            "key": "priority",
            "value": "5"
          },
          '.$output299.'

          {
            "key": "productSection",
            "repeatingSection": '.$input.'
          }
        ]}';
       
   // echo json_encode(array('output'=>$output));exit;
    $out = $output;
    $this->cm->save(array('msg'=>$output),'temp');
    $login_access_token_header = array('Content-Type:application/json','CLIENT_ID:4540555161763840');
    $makecall = $this->common->callAPI('POST', "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/baseApi/v1/job/createJobFromEcom", $output, $login_access_token_header);
$result=json_decode($makecall);
             $status=$result->status; 
             $jobId =$level=$templateId=$updatedAt=$createdAt=$jobstatusid=$jobstatusname=$message=$customerJobType=$jobCode='';
             if($status=='success'){
                if($result->data!=''){
                    //foreach($result->data as $info5){
                        $jobId=$result->data->jobId;
                        $level=$result->data->level;
                        $templateId=$result->data->templateId;
                        $updatedAt=$result->data->updatedAt;
                        $createdAt=$result->data->createdAt;
                        if($result->data->jobStatus){
                            //foreach($result->data->jobStatus as $info6){
                                $jobStatusid=$result->data->jobStatus->id;
                                $jobStatusname=$result->data->jobStatus->name;
                            //}
                        }
                        $message=$result->data->message;
                        $customerJobType=$result->data->customerJobType;
                        $jobCode=$result->data->jobCode;
                   // }
                }
                $update_data=array(
                    "jobId"=>$jobId,
                    "level"=>$level,
                    "templateId"=>$templateId,
                    "updatedAt"=>$updatedAt,
                    "createdAt"=>$createdAt,
                    "jobStatusid"=>$jobStatusid,
                    "jobStatusname"=>$jobStatusname,
                    "message"=>$message,
                    "customerJobType"=>$customerJobType,
                    "jobCode"=>$jobCode
                );
                $where=array('sk_order_id'=>$order_id);
                $this->cm->updateRecords($update_data,$where,'mlt_order');
          
            if($order_id!=''){
              if($party_time=='no'){
                $order_id2=base64_encode($order_id);
                $verifyEmail_link=base_url().'order-track?id='.$order_id2;
                $output='<p>Hello '.$exampleInputname.',</p>';
                $output.='<p>Thank you for Order</p>';
                $output.='<p>Please click the below link to track order.</p><form
                        <p><a href='.$verifyEmail_link.'>'.$verifyEmail_link.'</a></p>';
                $output.='<p>Cheers,</p>';
                $output.='<p>The MLT Team</p>';
                $body = $output;
                $subject = "Thank You";
              $emailInfo=$this->sendEmailOne($email_to,$subject,$body);
               $where=array('cuser_id'=>$data['temporary_session_id'],'party_time'=>0);
               $this->cm->deleteRecords($where,'mlt_cart');
               $this->session->set_userdata('cart_count',0);
              }else{
                $where=array('cuser_id'=>$data['temporary_session_id'],'party_time'=>1);
                $this->cm->deleteRecords($where,'mlt_cart');
                $where=array('user_id'=>$data['temporary_session_id'],'temp_package_status'=>0);
                $data_update=array('temp_package_status'=>1);
                $this->cm->updateRecords($data_update,$where,'mlt_user_packages');                
              }
            }
            $data['order_id']=$this->session->set_userdata('order_id',$order_id);

            //  $date6=gmdate(DATE_ATOM,strtotime(date("Y-m-dH:i:s")));
            echo json_encode(array("redirect_url"=>base_url().'order-confirmed','order_id'=>$order_id));
          }else{
            $this->cm->deleteRecords(array('sk_order_id'=>$order_id),'mlt_order');
            echo json_encode(array("redirect_url"=>false));
          
          }
        }

        // dista realtime feasability check
        public function realtime_feasabilty_check(){
            $tomorrow=$this->input->post('tomorrow');
            $lat=$this->input->post('lat');
            $lon=$this->input->post('lon');
            $endpoint = "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/jobsApi/v1/job/realTimeFeasabilityCheck";
            $coordinate = array('latitude'=>"$lat",'longitude'=>"$lon");
            $payload = '{
                "jobType": "DROP",
                "dropCoordinate": '.json_encode($coordinate).',
                "skillsets": ["Default"],
                "jobPriority": "1",
                "asapTrue": "true",
                "demand": "1",
                "entityName": "RealtimeSchedulingConfig",
                "templateId": "4786581961441280"
              }';
              $headers = array('Content-Type:application/json','CLIENT_ID:6181027215048704');


                $makecall = $this->common->callAPI('POST', $endpoint, $payload, $headers);
              
              $result = json_decode($makecall);
              if($result->status=='success'){
              if($result->data->jobFeasibility){
                  $dt = new DateTime($result->data->deliveryEndTime);
                  $tz = new DateTimeZone('Asia/Kolkata'); // or whatever zone you're after
                  $dt->setTimezone($tz);
                  $v = explode(" ",$dt->format('Y-m-d h:i-A'));
                  $temp = array('time'=>$v[1]);
                  echo json_encode($temp);
              }
              else{
                  $temp = array('time'=>1);
                  echo json_encode($temp);
              }
              }else{
                $temp = array('time'=>2);
                echo json_encode($temp);
              }
        }



        
        // webhook to receive the order status
        public function order_status(){
            $params = json_decode(@file_get_contents('php://input'),TRUE);
            if(isset($params['trackingUrl'])){
              $trackingUrl = $params['trackingUrl'];
              $riderPhone = $params['riderPhone'];
              $riderName = $params['riderName'];
              $orderId = $params['orderId'];
              $orderStatus = $params['orderStatus'];   

              $updateData = array('order_status'=>$orderStatus,'riderPhone'=>$riderPhone,'riderName'=>$riderName,'trackingUrl'=>$trackingUrl);     
              $this->cm->updateRecords($updateData,array('jobCode'=>$orderId),'mlt_order');      
              $notification=array(
                "notifiaction_label"=>"Order".$orderStatus,
                "notification_msg"=>"As per Your request,Order is " .$orderStatus,
                "notification_date"=>date('Y-m-d')
            );
            $this->cm->save($notification,'txn_notifications');

            }
            else if(isset($params['orderStatus'])){
              $orderId = $params['orderId'];
              $orderStatus = $params['orderStatus'];  
              $updateData = array('order_status'=>$orderStatus);     
              $this->cm->updateRecords($updateData,array('jobCode'=>$orderId),'mlt_order');  
              
              $notification=array(
                "notifiaction_label"=>"Order".$orderStatus,
                "notification_msg"=>"As per Your request,Order is ".$orderStatus,
                "notification_date"=>date('Y-m-d')
            );
            $this->cm->save($notification,'txn_notifications');

            }
           
           $data = array('msg'=>json_encode($params));
            
        }

        public function test(){
            date_default_timezone_set("Asia/Kolkata");
            $date = date('Y-m-d');
            $time = date('H:i:s');
             $datetime = $date.' '.$time;
            $event_date=date('Y-m-d H:i:s', strtotime($datetime));
            echo $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
           
             strtotime($date.$time);
            $datetime = $date.'\T'.$time.'.000';
            
           // echo date(DATE_ISO8601, strtotime('2017-01-25 14:40:46'));
            echo "<br>";
             $isoDate = date('Y-m-d\TH:i:s.000') . 'Z';
            echo "<br>";
            echo $isoDate = $datetime . 'Z';
        }
        public function corporate_tie_up(){
            $data=$this->common_data();
            $this->load->view('website/corporatetie',$data);
        

        }
        public function corporatetieupSave(){
            $data=$this->common_data();
            $fullname=$this->input->post('full_name'); 
            $organizationname=$this->input->post('organization_name');
            $mobileno=$this->input->post('mobile_no');
            $documentval=$this->input->post('documentval');
            $documentval2=$this->input->post('documentval2');

            $emailid=$this->input->post('email_id');
             $upload1=$this->input->post('filedata1');
             $upload2=$this->input->post('filedata2');
            $allowedExts=array("png,jpg,jpeg,pdf");
            if (!file_exists("uploads/corporate_tie/")) {
              mkdir("uploads/corporate_tie/", 0777, true);
          }           
           $upload_folder = "uploads/corporate_tie/";


            /*****for first documement**********/
            $image_parts = explode(";base64,", $upload1);
          $image_type_aux = explode("/", $image_parts[0]);
            $image_type = $image_type_aux[1];
          $image_base64 = base64_decode($image_parts[1]);
          $personal_id_doc=uniqid() .".".$image_type;
          $event_image_name_with_path = $upload_folder . $personal_id_doc;
          file_put_contents($event_image_name_with_path, $image_base64);
         

                  /*****for second  documement**********/

          $image_parts = explode(";base64,", $upload2);
          $image_type_aux = explode("/", $image_parts[0]);
            $image_type = $image_type_aux[1];
          $image_base64 = base64_decode($image_parts[1]);
          $official_address_proof=uniqid() .".".$image_type;
          $event_image_name_with_path = $upload_folder . $official_address_proof;
          file_put_contents($event_image_name_with_path, $image_base64);


            $datasave=array('full_name'=>$fullname,
            'organization_name'=>$organizationname,
            'mobile_num'=>$mobileno,
            'email_id'=>$emailid,
            'document_type1'=>$documentval,
            'document_type2'=>$documentval2,
            'personal_id_doc'=>$personal_id_doc,
            'official_address_proof'=>$official_address_proof,
        );
            $id=$this->cm->Save($datasave,'mlt_corporate_tie_up');
            if($id>0){
               echo json_encode(array('result'=>'true','id'=>$id));
            }else{
                echo json_encode(array('result'=>'false','id'=>$id));

            }
        }
        public function set_address(){
            $data=$this->common_data();
            $city=$this->input->post('city');
            $town=$this->input->post('town');
            $pincode=$this->input->post('pincode');
            $latitude=$this->input->post('latitude');
            $longitude=$this->input->post('longitude');

            $this->session->set_userdata('town',$town);
            $this->session->set_userdata('latitude',$latitude);
            $this->session->set_userdata('longitude',$longitude);
            $this->session->set_userdata('pincode',$pincode);
            $this->session->set_userdata('city',$city);
            $data['latitude']=$this->session->userdata('latitude'); 
            $data['latitude']=$this->session->userdata('latitude'); 
            $data['town']=$this->session->userdata('town'); 

            $data['pincode']=$this->session->userdata('pincode'); 
            $data['city']=$this->session->userdata('city'); 

            echo json_encode(array('city'=>$city,'town'=>$town));
        }


        public function no_order_emptystate(){
            $data=$this->common_data();
            if($this->session->userdata('cart_count')==0){
            $this->load->view('website/no-order-emptystate',$data);
            }else{
              redirect('cart');
            }
        }
        public function gift_a_cart(){
          $data=$this->common_data();
          //if($data['user_id']!='' && $data['user_id']!=null){
          $this->load->view('website/gift-a-cart',$data);
          //}else{
            //redirect('/');
          //}
        }
        public function party_time(){
          $data=$this->common_data();
          //if($data['user_id']!='' && $data['user_id']!=null){
            $this->load->view('website/party-time',$data);
          //}else{
            //redirect('/');
         // }
        }
        public function order_track(){
          $data=$this->common_data();
          $order_id=$_GET['id'];
          $order_id=base64_decode($order_id);
          $where=array('sk_order_id'=>$order_id);
         $orderdetils=$this->cm->getRecords($where,'mlt_order');
         $data['order_status']='';
         $data['trackingUrl']='';
         $data['order_id']=$order_id;

         if($orderdetils){
         foreach($orderdetils as $info12){
          $data['order_status']=$info12->order_status;
          $data['trackingUrl']=$info12->trackingUrl;
         }
        }
          $this->load->view('website/order-track',$data);
          
        } 

        public function order_track1(){
          $data=$this->common_data();
          $order_id1=$_GET['id'];
          $order_id=base64_decode($order_id1);
          $where=array('sk_order_id'=>$order_id);
         $orderdetils=$this->cm->getRecords($where,'mlt_order');
         $data['order_status']='';
         $order_status=$trackingUrl='';
         $data['trackingUrl']='';
         if($orderdetils){
         foreach($orderdetils as $info12){
          $order_status=$info12->order_status;
          $trackingUrl=$info12->trackingUrl;
         }
        }
            echo json_encode(array('order_status'=>$order_status,'trackingUrl'=>$trackingUrl));
        } 

        public function add_friends_gift(){
          $data=$this->common_data();
          $gift_cart=$this->input->post('gift_cart');
          $arr=array(); $arr1=array();$arr2=array();
          $user_id=$gift_cart['user_id'];

          $arr=$gift_cart['frnd_name'];
          $arr1=$gift_cart['friend_email'];
          $arr2=$gift_cart['friend_number'];
         $sk_gift_cart_id=0;
             for($i=0;$i<sizeof($gift_cart);$i++){
               if(isset($arr[$i]) && isset($arr1[$i]) && isset($arr2[$i])){
                $saveData = array(
                  'name'=>$arr[$i],
                  'mobile'=>$arr1[$i],
                  'email'=>$arr2[$i],
                  'user_id'=>$user_id,
                  'gift_cart_status'=>'1'
                   );
                   $sk_gift_cart_id = $this->cm->Save($saveData,'mlt_gift_a_cart'); 
               }
          }
          if($sk_gift_cart_id!=0){
          echo json_encode(array("value"=>"true"));
        }else{
          echo json_encode(array("value"=>"false"));
        }
        }




        public function party_time_steps(){
          $data=$this->common_data();
          if($data['user_id']!='' && $data['user_id']!=null){
          $this->load->view('website/party-time-steps',$data);
          }else{
            redirect('/');
          }
        }

        public function packages(){
          $data=$this->common_data();
          $where=array('package_status'=>1);
          $packages=$this->cm->getRecords($where,'mlt_package');
          $output=false;
          if($packages!=false){
            
            $i=1;foreach($packages as $info){

              $output=$output."<div class='custom-control custom-radio packageerr_remove'>
                                
                                        <input type='radio' id='$info->sk_package_id' name='payment_radio22' onclick='packages_selected()' value='$info->sk_package_id' class='custom-control-input '>
                                        <label class='custom-control-label w-100' for='$info->sk_package_id'>
                                            <div class='d-flex'>
                                                <div class='mr-auto pr-md-4'>
                                                    <p class='package_name'>$info->package_name</p>
                                                    <p class='package_items'>$info->display_package</p>
                                                </div>
                                                <h6 class='package_price'>₹$info->package_amount</h6>
                                            </div>
                                        </label>
                                    </div>";
        }
      }
      echo json_encode(array('packages'=>$output));
    }

  
    public function addtopackages(){
      $data=$this->common_data();
      $occation=$this->input->post('occation');
      $select_date=$this->input->post('select_date');
      $from_time=$this->input->post('from_time');
      $to_time=$this->input->post('to_time');
      $to_time=date('H:i',strtotime($to_time));
      $from_time=date('H:i',strtotime($from_time));

       $no_of_people=$this->input->post('no_of_people');
        $package_id=$this->input->post('package_id');
      if($data['user_id']!=''){
        $user_id=$data['user_id'];
        $where=array('temp_package_status'=>0,'user_id'=>$data['user_id']);
      }else	if($this->session->userdata("temporary_session_id")==null || $this->session->userdata("temporary_session_id")==""){

				$user_id = $this->createTempSession();
        $user_id = (int)$user_id;
				$this->session->set_userdata("temporary_session_id", $user_id);
        $where=array('temp_package_status'=>0,'user_id'=>$user_id);
        
			}else{
				 $user_id = $this->session->userdata("temporary_session_id");
         $where=array('temp_package_status'=>0,'user_id'=>$user_id);  

			}
      $where20=array('cuser_id'=>$user_id,'party_time'=>1);
            $cart_records=$this->cm->getRecords($where20,'mlt_cart');
            if($cart_records!=false){
                $this->cm->deleteRecords($where20,'mlt_cart');
            }
            $where29=array('sk_package_id'=>$package_id);
             $pack=$this->cm->getRecords($where29,'mlt_package');
            $total_package_amount=0;
            if($pack!=false){
              foreach($pack as $info29){
                $package_amount=$info29->package_amount;
              }
              $total_package_amount=$package_amount*$no_of_people;
            }
      $packagedetails=$this->cm->getRecords($where,'mlt_user_packages');
      $id=false;
      if($packagedetails!=false){
        $data_array=array("occation"=>$occation,
          "select_date"=>$select_date,
          "total_package_amount"=>$total_package_amount,
          "from_time"=>$from_time,
          "to_time"=>$to_time,
          "no_of_people"=>$no_of_people,
          "package_id"=>$package_id,
          "user_id"=>$user_id,
          "temp_package_status"=>0
        );
        $id=$this->cm->updateRecords($data_array,$where,'mlt_user_packages');
      }
      else{
       $data_array=array(
        "occation"=>$occation,
        "select_date"=>$select_date,
        "total_package_amount"=>$total_package_amount,
        "from_time"=>$from_time,
        "to_time"=>$to_time,
        "no_of_people"=>$no_of_people,
        "package_id"=>$package_id,
        "user_id"=>$user_id,
        "temp_package_status"=>0
      );
      //echo json_encode($data_array);
      $id=$this->cm->save($data_array,'mlt_user_packages'); 
      //echo 11;
    }
    echo json_encode(array('redirect_url'=>'party-time-extra'));
  }


    public function party_time_extra(){
      $data=$this->common_data();
      $url=$data['admin_url'];
      if($data['user_id']!=''){
        $user_id=$data['user_id'];
        $where=array('temp_package_status'=>0,'user_id'=>$data['user_id']);
      }else	if($this->session->userdata("temporary_session_id")==null || $this->session->userdata("temporary_session_id")==""){

				$user_id = $this->createTempSession();
        $user_id = (int)$user_id;
				$this->session->set_userdata("temporary_session_id", $user_id);
        $where=array('temp_package_status'=>0,'user_id'=>$user_id);
        
			}else{
				 $user_id = $this->session->userdata("temporary_session_id");
         $where=array('temp_package_status'=>0,'user_id'=>$user_id);  

			}      $package_details=$this->cm->getRecords($where,'mlt_user_packages');
      $output='';$package_name=$price= $item_size="";      $output1=$output2=$output9='';
      if($package_details!=false){
        foreach($package_details as $info){
          $where=array('sk_package_id'=>$info->package_id);
          $package_full=$this->cm->getRecords($where,'mlt_package');
          $count=count($package_full);
          $inValue = array();
          if($package_full!=false){
            foreach($package_full as $info2){
              $package_name=$info2->package_name;
              if($info2->pizza_id!=NULL){
                $inValue[] = $info2->pizza_id;
              }
              if($info2->sides_id!=NULL){
                $inValue[] = $info2->sides_id;
              }
              if($info2->salads_id!=NULL){
                $inValue[] = $info2->salads_id;
              }
              if($info2->drinks_id!=''){
                $inValue[] = $info2->drinks_id;
              }
              if($info2->desserts_id!=NULL){
                $inValue[] = $info2->desserts_id;
              }
              if($info2->dips_id!=NULL){
                $inValue[] = $info2->dips_id;
              }
            }
          }
          $url=$data['admin_url'];
         $from_time= date('h:i A',strtotime($info->from_time));
         $to_time= date('h:i A',strtotime($info->to_time));

          $inValueString = '';
          $inValueString = implode(",",$inValue);
          $output=$output."<div class='card'>
                <div class='card-header'>
                  <div class='d-flex'>
                    <p class='birthday-txt fw-600'>$info->occation</p>
                      <div class='d-flex ml-auto'>
                        <div><a href='party-time-steps'><img src='$url/assets/images/edits.png' class='img-fluid '></div>
                        <p class='fw-500 edit-txt'>Edit</p></a>
                      </div>
                  </div>
                </div>
                <div class='card-body'>
                  <div class='row'>
                    <div class='col-md-6 line'>
                      <div class='d-flex mb-3 pb-1'>
                        <p class=' birthday-list'>Party Date</p>
                        <p class='ml-auto fw-500 birthday-list'>$info->select_date</p>
                      </div>
                      <div class='d-flex '>
                        <p class=' birthday-list'>Time of party</p>
                        <p class='ml-auto fw-500 birthday-list'>$from_time-$to_time</p>
                      </div>
                    </div>
                   
                    <div class='col-md-6'>
                      <div class='d-flex mb-3 pb-1'>
                        <p class=' birthday-list'>Number of people</p>
                        <p class='ml-auto fw-500 birthday-list'>$info->no_of_people</p>
                      </div>
                      <div class='d-flex '>
                        <p class=' birthday-list'>Package Selected</p>
                        <p class='ml-auto fw-500 birthday-list-yellow '>$package_name</p>
                      </div>
                    </div>
                  </div>
                </div>
            </div>";
      
    
      $slug=$categoryDetails=$categoryIdDetails=$categoryid='';
      $items['price']='';
      $q='';
      if($inValueString!='')
        $q= "where sk_categoryItems_id in($inValueString)";
       $sql="SELECT * FROM mst_categoryitems $q";
     $binds="";
     $category_details1=$this->cm->getRecordsQuery($sql, $binds);
     $counts=count($category_details1);
        $output1=$output1."<input type='hidden' id='count' value='$counts'>";
      if($slug==''){
      $slug=$category_details1[0]->category_slug;
      }
      $where1=array('cuser_id'=>$user_id,'party_time'=>0);
      $cart_details=$this->cm->getRecords($where1,'mlt_cart');        
      $cart_data=array();
      $cart_price=$i=0;
      $quantity='';
      if($cart_details){
          foreach($cart_details as $info){
              $quantity=$info->quantity;
              $cart_price=$cart_price+$info->price;
              $i++;
          }  
      } 
      $data['quantity']  =$quantity;
      $data['cart_price']=$cart_price;   
      $data['items']=$i;
      if($category_details1){
         // $categoryTypeInfo=array();
$m=1;
          foreach($category_details1 as $info)
  {
              $categoryTypeInfo=array();
              $categoryTypeInfo['category_id']=$info->sk_categoryItems_id;
              $category_id=$categoryTypeInfo['category_id'];
              $categoryTypeInfo['slug']=$info->category_slug;
              $slug2=$info->category_slug;
              $categoryTypeInfo['image']=$info->category_image;
              $categoryTypeInfo['captions']=$info->caption;
              $categoryTypeInfo['category_type']=$info->Items_categoryname;
              $categoryTypeInfo['item_details']='';
              if($info2->pizza_id!=NULL && $info->sk_categoryItems_id==$info2->pizza_id){
                $output8="<input type='hidden' value='$info2->no_of_pizza' id='pizza_no_id'><p class='fs-20 exclusive mr-auto no_of_items'>SELECT $info2->no_of_pizza $info->category_slug<br class='d-block d-md-none'> <span id='no_of_pizza'>(0 of $info2->no_of_pizza)</span></p>";
              }
              if($info2->sides_id!=NULL && $info2->sides_id==$info->sk_categoryItems_id){
                $output8="<input type='hidden' value='$info2->no_of_sides' id='sides_no_id'><p class='fs-20 exclusive mr-auto no_of_items'>SELECT $info2->no_of_sides $info->category_slug<br class='d-block d-md-none'> <span id='no_of_sides'>(0 of $info2->no_of_sides)</span></p>";
              }
              if($info2->salads_id!=NULL && $info2->salads_id==$info->sk_categoryItems_id){
                $output8="<input type='hidden' value='$info2->no_of_salads' id='salads_no_id'><p class='fs-20 exclusive mr-auto no_of_items'>SELECT $info2->no_of_salads $info->category_slug<br class='d-block d-md-none'> <span id='no_of_salads'>(0 of $info2->no_of_salads)</span></p>";
              }
              if($info2->drinks_id!=''&& $info2->drinks_id==$info->sk_categoryItems_id){
                $output8="<input type='hidden' value='$info2->no_of_drinks' id='drinks_no_id'><p class='fs-20 exclusive mr-auto no_of_items'>SELECT $info2->no_of_drinks $info->category_slug<br class='d-block d-md-none'> <span id='no_of_drinks'>(0 of $info2->no_of_drinks)</span></p>";
              }
              if($info2->desserts_id!=NULL &&$info2->desserts_id==$info->sk_categoryItems_id){
                $output8="<input type='hidden' value='$info2->no_of_desserts' id='desserts_no_id'><p class='fs-20 exclusive mr-auto no_of_items'>SELECT $info2->no_of_desserts $info->category_slug<br class='d-block d-md-none'> <span id='no_of_desserts'>(0 of $info2->no_of_desserts)</span></p>";
              }
              if($info2->dips_id!=NULL && $info2->dips_id==$info->sk_categoryItems_id){
                $output8="<input type='hidden' value='$info2->no_of_dips' id='dips_no_id'><p class='fs-20 exclusive mr-auto no_of_items'>SELECT $info2->no_of_dips $info->category_slug<br class='d-block d-md-none'> <span id='no_of_dips'>(0 of $info2->no_of_dips)</span></p>";
              }
              
              $toggle1=$info->category_slug.'_nonveg';
              $toggle2=$info->category_slug.'_veg';
              $output1=$output1."<div class='party_time_$info->category_slug section$m'>
              <input type='hidden' value='$info->category_slug' class='slug$m'>
              <div class='exclusive-pizzas'>
              
                      <div class='container'>
                            <div class='pizza_top'>
                              <div class='d-flex exclusive--pizzas mb-40'>
                                 $output8
                                <div class='custom-control custom-switch green_switch'>
                                  <input type='checkbox' class='custom-control-input $toggle2' id='customSwitch2$info->category_slug'>
                                  <label class='custom-control-label' for='customSwitch2$info->category_slug'>Veg</label>
                                </div>

                                <div class='custom-control custom-switch yellow_switch pl-3'>
                                  <input type='checkbox' class='custom-control-input $toggle1' id='customSwitch1$info->category_slug'>
                                  <label class='custom-control-label' for='customSwitch1$info->category_slug'>Non Veg</label>
                                </div>
                              </div>
                            </div>";
  

      $sql="SELECT mst_categoryitems.Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems.category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type,mlt_items_onboarding.slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id WHERE category_id=$category_id and item_onboarding_status=1";
      $binds="";
      $base_details=$price_details=array();
      
      $category_details=$this->cm->getRecordsQuery($sql, $binds);
      if ($category_details) {
          $temp2=array();
          $temp=array();
          foreach ($category_details as $info) {
              
                   $where=array('citem_id'=>$info->sk_id,'cuser_id'=>$user_id,'party_time'=>0);
              $cart_details=$this->cm->getRecords($where,'mlt_cart');
              $where=array('item_id'=>$info->sk_id,'user_id'=>$user_id);
            

              $items['favorites']=$this->cm->getRecords($where,'mst_favourite');
              $items['cart_details']=$cart_details;
              $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                
                $price_details=$this->cm->getRecords($where,'mlt_price');
                $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
              if($price_details!=false){
                  foreach($price_details as $row3){
                       $price=$price_details[0]->item_cost;
                       $item_size=$price_details[0]->item_size;
                  }
              }
              
              
              $image=admin_img_url."items/".$info->image;
              if($info->type=='veg'){
                $img="<img src='$url/assets/images/dot.png' alt=''>";
              }else{
                $img="<img src='$url/assets/images/red-dot.png' alt=''>";
              }
              $read='';
              if(strlen($info->description)<=190){
                $read=$read."<p class='bright mt-md-3 mt-2 '>$info->description.</p>";
                 }else{
                  $text=substr($info->description,0,161);
                  $text1=substr($info->description,202,100000);
                  $read=$read."<p class='bright mt-md-3 mt-2'>
                    <span>$text<span>
                    <span class='bright mt-md-3 mt-2 display_none more_text'>$text1.</span>
                    <span class='read_more'>... Read More</span>
                    <span class='read_less'> Read Less</span>
                  </p>";
                  // <!-- <span class="bright mt-md-3 mt-2 ">substr($info->description,192,100000);.</span> -->
                 }
               
              $output1=$output1."<div class='media pizzaas-box position-relative $info->type-item'>
              <img class='pizza-banner img-fluid' src=$image alt=''>
              <div class='media-body pizza-details '>
                      <div class='d-flex  '>
                              <div class='mx-471'>
                                      <div class='green-dot'>$img</div>
                                      <h5 class='fmg-maggi '>$info->display_name - <span class='for-maggi align-self-center'>$info->item_name</span></h5>
                              </div>
                              
                      
                      </div>
                      $read
                      <div class='mx-500'>";
                      if($slug2=='pizzas'){
                             $output1=$output1."<div class='d-flex choose-it  mt-md-4 '>
                                      <div class='col-md-6 select-size'>
                                              <select class='selectpicker  size-selct size-base1' id='size_$info->sk_id' onchange=getValue(this,'$info->sk_id') >";
                                              if($price_details!=false){
                                                foreach($price_details as $row3){
                                               $output1=$output1."<option class='cost1$row3->sk_id' cost='$row3->item_cost' value='$row3->sk_id'>$row3->item_size</option>";
                                                }}
                                         
                                        $output1=$output1."</select>
                                      </div>
                                      <div class='col-md-6 select-size'>
                                              <select class='selectpicker size-base' id='base$info->sk_id'>";
                                          if($base_details!=false){
                                                foreach($base_details as $row3){
                                                         $item_topping=$row3->items;
                                                  $toppings=explode(',',$item_topping);
                                            
                                                if($toppings){
                                                  for($k=0;$k<count($toppings);$k++){
                                                $top=$toppings[0];
                                              $output1=$output1."<option class='cost2$k'value='$toppings[$k]'>$toppings[$k]</option>";
                                              }}}}
                                            
                                             $output1=$output1." </select>
                                      </div>
                              </div>";
                      }

                     
                            $output1=$output1."<div class='d-flex cost '>
                                      <input type='hidden'  id='price-id$info->sk_id' value='$price'>
                                      <input type='hidden' id='base-id2$info->sk_id' value='$top'>

                                      <input type='hidden'  id='item-id2$info->sk_id' value='$item_size'>
                                      <!-- <p class='taxes '>incl. taxes</p>-->
                                      <button class='default-btn fs-20 ml-auto add-cart cart$slug2 position-relative' onclick=getValue1(this,$info->sk_id,$price,$m,'') id='add-cart$info->sk_id'>Add <div><img src='$url/assets/images/plusss.png' class='img-fluid cart--pluse'></div></button>
                                      <div class='add-sub inc-dec ' id='dec$info->sk_id'>
                                              <div id='field1' class='field1 d-flex ml-4'>
                                                      <button type='button' onclick=getValue1(this,$info->sk_id,$price,$m,'sub') id='sub' class='sub'>
                                                      <img src='$url/assets/images/minus.png'></button>
                                                      <input type='number' id='minus16' class='num' value='1' min='1' max='10000' readonly=''>
                                                      <button type='button' id='add$info->sk_id' class='add' onclick=getValue1(this,$info->sk_id,$price,$m,'add')><img src='$url/assets/images/plus.png'></button>
                                              </div>
                                      </div>
                              </div>";
                              // if($slug2=='pizzas'){
                              // // $output1=$output1."<button type='button' class=' default-btn custooo-mize' data-toggle='modal' data-target='#customizeModal' onclick=getToppingdetails($info->sk_id,'$info->item_name')>Customize</button>
                              //         <!--<button class='default-btn custooo-mize'>Customize</button>-->";
                              // }
                              $output1=$output1."</div>
              </div>
      </div>";  
            }

      }
          $output1=$output1."<div class='fixed_bar' id='fixed_bar'>
                <input type='hidden' value='$slug2' class='slug'>
          <div class='total-bill d-flex'>
                  <a class='default-btn party_flow view_$slug2 view--cartt   fw-600 button_$m' onclick=slide($m) href='javascript:void(0)' id='button_$m'>Next </a>
          </div>
    </div>  </div>
    </div>
    </div>"; 
    $m++;
      
    }
      
    }
        }
      }
      else{
        redirect('/');
      }
      $data['topping_head_details']="";
      $where=array('toping_status'=>1);
      $data['topping_head_details']=$this->cm->getRecords($where,'mlt_topings'); 
      $data['output']=$output;
      $data['output1']=$output1;

      $this->load->view('website/party-time-extra',$data);
    }
   
    

  public function party_time_pizza(){
    $data=$this->common_data();
    $url=$data['admin_url'];
    $admin_url=base_url();

    if($data['user_id']!=''){
      $user_id=$data['user_id'];
      $where=array('temp_package_status'=>0,'user_id'=>$data['user_id']);
    }else	if($this->session->userdata("temporary_session_id")==null || $this->session->userdata("temporary_session_id")==""){

      $user_id = $this->createTempSession();
      $user_id = (int)$user_id;
      $this->session->set_userdata("temporary_session_id", $user_id);
      $where=array('temp_package_status'=>0,'user_id'=>$user_id);
      
    }else{
       $user_id = $this->session->userdata("temporary_session_id");
       $where=array('temp_package_status'=>0,'user_id'=>$user_id);  

    }      $package_details=$this->cm->getRecords($where,'mlt_user_packages');
      $output='';$package_name=$price= $item_size=$output10=$output9="";      $output1=$output2=$output8='';
      if($package_details!=false){
        foreach($package_details as $info){
          $no_of_people=$info->no_of_people;
          $from_time=$info->from_time;
          $to_time=$info->to_time;
          $package_amount=$info->total_package_amount;
          $where=array('sk_package_id'=>$info->package_id);
          $package_full=$this->cm->getRecords($where,'mlt_package');
          $count=count($package_full);
          $inValue = array();
          if($package_full!=false){
            foreach($package_full as $info2){
              $package_name=$info2->package_name;
              if($info2->pizza_id!=NULL){
                $inValue[] = $info2->pizza_id;
              }
              if($info2->sides_id!=NULL){
                $inValue[] = $info2->sides_id;
              }
              if($info2->salads_id!=NULL){
                $inValue[] = $info2->salads_id;
              }
              if($info2->drinks_id!=''){
                $inValue[] = $info2->drinks_id;
              }
              if($info2->desserts_id!=NULL){
                $inValue[] = $info2->desserts_id;
              }
              if($info2->dips_id!=NULL){
                $inValue[] = $info2->dips_id;
              }
            }
          }
          $from_time= date('h:i A',strtotime($info->from_time));
          $to_time= date('h:i A',strtotime($info->to_time));
          $inValueString = '';
          $inValueString = implode(",",$inValue);
          $output=$output."<div class='card'>
                <div class='card-header'>
                  <div class='d-flex'>
                    <p class='birthday-txt fw-600'>$info->occation</p>
                      <div class='d-flex ml-auto'>
                      <a href='party-time-steps ' class='d-flex align-self-center'>
                        <div><img src='$url/assets/images/edits.png' class='img-fluid ' style='margin-top: -4px;'></div>
                        <p class='fw-500 edit-txt'>Edit</p>
                      </a>
                      </div>
                  </div>
                </div>
                <div class='card-body'>
                  <div class='row'>
                    <div class='col-md-6 line'>
                      <div class='d-flex mb-3 pb-1'>
                        <p class=' birthday-list'>Party Date</p>
                        <p class='ml-auto fw-500 birthday-list date-party'>$info->select_date</p>
                      </div>
                      <div class='d-flex '>
                        <p class=' birthday-list'>Time of party</p>
                        <p class='ml-auto fw-500 birthday-list time-party'>$from_time-$to_time</p>
                      </div>
                    </div>
                   
                    <div class='col-md-6'>
                      <div class='d-flex mb-3 pb-1'>
                        <p class=' birthday-list'>Number of people</p>
                        <p class='ml-auto fw-500 birthday-list'>$no_of_people</p>
                      </div>
                      <div class='d-flex '>
                        <p class=' birthday-list'>Package Selected</p>
                        <p class='ml-auto fw-500 birthday-list-yellow '>$package_name</p>
                      </div>
                    </div>
                  </div>
                </div>
            </div>";
            $slug=$categoryDetails=$categoryIdDetails=$categoryid='';
      $items['price']='';
      $q='';             

      if($inValueString!='')
        $q= "where sk_categoryItems_id in($inValueString)";
       $sql="SELECT * FROM mst_categoryitems $q";
     $binds="";
     $category_details1=$this->cm->getRecordsQuery($sql, $binds);
      if($category_details1){
          foreach($category_details1 as $info)
            {
              $categoryTypeInfo=array();
              $categoryTypeInfo['category_id']=$info->sk_categoryItems_id;
              $category_id=$categoryTypeInfo['category_id'];
              $categoryTypeInfo['slug']=$info->category_slug;
              $slug2=$info->category_slug;
              $categoryTypeInfo['image']=$info->category_image;
              $categoryTypeInfo['captions']=$info->caption;
              $categoryTypeInfo['category_type']=$info->Items_categoryname;
              $categoryTypeInfo['item_details']='';
              $sql = "select count(category_id) as count from mlt_cart JOIN mlt_items_onboarding on sk_id=citem_id WHERE cuser_id=$user_id and party_time=1 and category_id=$info->sk_categoryItems_id";
              $binds="";
              $category_details=$this->cm->getRecordsQuery($sql, $binds);
              $num=$category_details[0]->count;
              if($info2->pizza_id!=NULL && $info->sk_categoryItems_id==$info2->pizza_id){
                $output8=$output8."<a class='nav-link active d-flex fw-500' id='nav-contact-tab' data-toggle='tab' href='#nav-$info->category_slug' role='tab' aria-controls='nav-contact' aria-selected='false'>$info->category_slug ($num)<div><img class='img-fluid ml-2' src='$url/assets/images/tabarr.png'></div></a>";
                $output9=$output9."<div class='tab-pane fade show active mt-4' id='nav-$info->category_slug' role='tabpanel' aria-labelledby='nav-home-tab'>";
              }
              if($info2->sides_id!=NULL && $info2->sides_id==$info->sk_categoryItems_id){
                $output8=$output8."<a class='nav-link d-flex fw-500' id='nav-contact-tab' data-toggle='tab' href='#nav-$info->category_slug' role='tab' aria-controls='nav-contact' aria-selected='false'>$info->category_slug ($num)<div><img class='img-fluid ml-2' src='$url/assets/images/tabarr.png'></div></a>";
                $output9=$output9."<div class='tab-pane fade show  mt-4' id='nav-$info->category_slug' role='tabpanel' aria-labelledby='nav-home-tab'>";
              }
              if($info2->salads_id!=NULL && $info2->salads_id==$info->sk_categoryItems_id){
                $output8=$output8."<a class='nav-link d-flex fw-500' id='nav-contact-tab' data-toggle='tab' href='#nav-$info->category_slug' role='tab' aria-controls='nav-contact' aria-selected='false'>$info->category_slug ($num)<div><img class='img-fluid ml-2' src='$url/assets/images/tabarr.png'></div></a>";
                $output9=$output9."<div class='tab-pane fade show  mt-4' id='nav-$info->category_slug' role='tabpanel' aria-labelledby='nav-home-tab'>";
              }
              if($info2->drinks_id!=null&& $info2->drinks_id==$info->sk_categoryItems_id){
                $output8=$output8."<a class='nav-link d-flex fw-500' id='nav-contact-tab' data-toggle='tab' href='#nav-$info->category_slug' role='tab' aria-controls='nav-contact' aria-selected='false'>$info->category_slug ($num)<div><img class='img-fluid ml-2' src='$url/assets/images/tabarr.png'></div></a>";
                $output9=$output9."<div class='tab-pane fade show  mt-4' id='nav-$info->category_slug' role='tabpanel' aria-labelledby='nav-home-tab'>";
              }
              if($info2->desserts_id!=NULL && $info2->desserts_id==$info->sk_categoryItems_id){
                $output8=$output8."<a class='nav-link d-flex fw-500' id='nav-contact-tab' data-toggle='tab' href='#nav-$info->category_slug' role='tab' aria-controls='nav-contact' aria-selected='false'>$info->category_slug ($num)<div><img class='img-fluid ml-2' src='$url/assets/images/tabarr.png'></div></a>";
                $output9=$output9."<div class='tab-pane fade show  mt-4' id='nav-$info->category_slug' role='tabpanel' aria-labelledby='nav-home-tab'>";
              }
              if($info2->dips_id!=NULL && $info2->dips_id==$info->sk_categoryItems_id){
                $output8=$output8."<a class='nav-link d-flex fw-500' id='nav-contact-tab' data-toggle='tab' href='#nav-$info->category_slug' role='tab' aria-controls='nav-contact' aria-selected='false'>$info->category_slug ($num)<div><img class='img-fluid ml-2' src='$url/assets/images/tabarr.png'></div></a>";
                $output9=$output9."<div class='tab-pane fade show  mt-4' id='nav-$info->category_slug' role='tabpanel' aria-labelledby='nav-home-tab'>";
              }
              $sql = "select * from mlt_cart JOIN mlt_items_onboarding on sk_id=citem_id WHERE cuser_id=$user_id and party_time=1 and category_id=$info->sk_categoryItems_id";
              $binds="";
              $category_details=$this->cm->getRecordsQuery($sql, $binds);
              if($category_details!=false){
                $output12='';
                foreach($category_details as $info10){
                  if($info10->category_id==$info->sk_categoryItems_id){
                    $custom=json_decode($info10->customization);
                    $output6=array();
                    if($custom->size){
                      foreach($custom->size as $info4){
                          $output6[]=$info4;
                      }
                  }
                  if($custom->base){
                    foreach($custom->base as $info4){
                        $output6[]=$info4;
                    }
                }
                    if($custom->veg){
                        foreach($custom->veg as $info4){
                           $output6[]=$info4;
                        }
                    }
                    if($custom->nonveg){
                        foreach($custom->nonveg as $info4){
                            $output6[]=$info4;
                        }
                    }if($custom->flavor){
                        foreach($custom->flavor as $info4){
                            $output6[]=$info4;
                        }
                    }

                    $output6=implode(', ',$output6);
                               $image=admin_img_url."items/".$info10->image;
                               if($info10->type=='veg'){
                                $img="<img src='$url/assets/images/dot.png' class='img-fluid lia-img'>";
                               }else{
                                $img="<img src='$url/assets/images/red-dot.png' class='img-fluid lia-img'>";

                               }
                  $output9=$output9."<div class='row card-bor mb-4 mx-0'>
                  <div class='col-md-3 mb-4 px-0'>
                      <div class='d-flex'>
                          <div><img src='$image' class='img-fluid cardpiza'></div>
                          <div class='d-md-none d-block'>
                              <div class='d-flex pb-2 ml-3'>
                                 <div>$img</div>
                                  <div class='lia fw-600'>$info10->display_name<span class='italia'> - $info10->item_name</span></div>
                              </div>
                          </div>
                          
                      </div>
                  </div>
                  <div class='col-md-9 customize-card mb-4 px-0'>
                        <div class='d-md-block d-none'>
                          <div class='d-flex pb-2 ml-3'>
                             <div> $img</div>
                              <div class='lia'>$info10->display_name<span class='italia'> - $info10->item_name</span></div>
                          </div>
                        </div>
                     
                      <div class='mb-2  ml-3'>
                          <p class='card-text'>$output6</p>
                      </div>     
                  </div>
            </div>";
                  }
                }
                
              }     
              $output9=$output9."</div>";

            }
          }
      
        }
      }
      else{
        redirect('/');
      }
      
      
      
      $data['output8']=$output8;      
          $coupon_user=false;
            if($data['user_id']!=''){
              $where=array('coupon_status'=>1,'user_id'=>$data['user_id']);
              $coupon_user=$this->cm->getrecords($where,'mst_coupons');  
            }
            $coupon='';
           // var_dump($coupon_user);exit();
           if($coupon_user!=false){
            foreach($coupon_user as $row){
              $coupon=$coupon."<div class='custom-control custom-radio mb-3'>
                          <input type='radio' id='abc$row->sk_coupon_id' name='couponradio ' class='custom-control-input '>
                          <label class='custom-control-label coupon28  d-flex coupon25$row->sk_coupon_id ' for='abc$row->sk_coupon_id'> <div>
                              <div><input type='hidden' value='$row->sk_coupon_id' id='coupon_id'>
                              <p class='exl-text fs-20 coupon_code$row->sk_coupon_id fw-500'> $row->coupon_code</p>
                              <p class='discount fw-400'>Get  $row->coupon_price off on your first order</p></div>
                              <input type='hidden' id='coupon_price$row->sk_coupon_id' value=' $row->coupon_price'>
                          </div>
                          <p class=' applycoupons10$row->sk_coupon_id apply-discount text-center ml-auto mb-3'onClick='applycoupon($row->sk_coupon_id)'>Apply</p></label>
                      </div>
                      <div class='d-flex err-full-msg error-msg$row->sk_coupon_id' style='display:none'>
                          <div class='oops-img img-fluid  mr-2'> <img class='oops-img image22 img10$row->sk_coupon_id d-none' src='$admin_url/assets/images/oops.png'></div>
                          <p class='oops-bug fw-400'><span class='oops fw-500 mr-1 error1$row->sk_coupon_id'></span></p>
                      </div>";
            }
          }
          $where=array('coupon_status'=>1,'user_id'=>'');
          $data['coupons_user']=$coupon;
      $data['coupon_details']=$this->cm->getrecords($where,'mst_coupons');
       $data['no_of_people']=$no_of_people;
    $data['output']=$output;
    $data['output8']=$output8;
    $data['output9']=$output9;


    $data['package_amount']=$package_amount;
    $data['package_name']=$package_name;
    $this->load->view('website/party-time-pizza',$data);
  }




  public function realtime_feasabilty_check_for_tomorow($date_tomorrow,$lat,$lon){
    $endpoint = "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/jobsApi/v1/job/realTimeFeasabilityCheck";
    $coordinate = array('latitude'=>"$lat",'longitude'=>"$lon");
    $payload = '{
        "jobType": "DROP",
        "dropCoordinate": '.json_encode($coordinate).',
        "skillsets": [
          "Default"
        ],
        "jobPriority": "1",
        "asapTrue": "false",
        "expectedTime" : "'."$date_tomorrow".'",
        "demand": "1",
        "entityName": "RealtimeSchedulingConfig",
        "templateId": "4786581961441280"
      }';
      $headers = array('Content-Type:application/json','CLIENT_ID:6181027215048704');
       $makecall = $this->common->callAPI('POST', $endpoint, $payload, $headers);
      $result = json_decode($makecall);
      // if($result->data->jobFeasibility==false){
        if(!empty($result->data->availableSlots)){
          $slot_id=$result->data->availableSlots[0]->slotId;
          $level_id=$result->data->level;
         
          return json_encode(array('slot_id'=>$slot_id,'levele_id'=>$level_id,'date_tomorrow'=>$date_tomorrow));
      }
  }


  
  public function realtime_feasabilty_check_for_tomorow_check(){
    $date=$this->input->post('date');
    $time=$this->input->post('time');
    $latitude=$this->input->post('latitude');
    $longitude=$this->input->post('longitude');
    $date_tomorrow=$this->utctime($date,$time);
    $endpoint = "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/jobsApi/v1/job/realTimeFeasabilityCheck";
    $coordinate = array('latitude'=>"$latitude",'longitude'=>"$longitude");
    $payload = '{
        "jobType": "DROP",
        "dropCoordinate": '.json_encode($coordinate).',
        "skillsets": [
          "Default"
        ],
        "jobPriority": "1",
        "asapTrue": "false",
        "expectedTime" : '.$date_tomorrow.',
        "demand": "1",
        "entityName": "RealtimeSchedulingConfig",
        "templateId": " 4786581961441280 "
      }';

      $headers = array('Content-Type:application/json','CLIENT_ID:6181027215048704');
       $makecall = $this->common->callAPI('POST', $endpoint, $payload, $headers);
      $result = json_decode($makecall);
      // if($result->data->jobFeasibility==false){
        if(!empty($result->data->availableSlots)){
          $slot_id=$result->data->availableSlots[0]->slotId;
          $start=$result->data->availableSlots[0]->start;
            $end=$result->data->availableSlots[0]->end;
          $level_id=$result->data->level;
         // echo '"'.$end.'"'."==".$date_tomorrow;
          
          if('"'.$start.'"'==$date_tomorrow){
            echo json_encode(array("result"=>1));
          }else{
            // $end=gmdate('Y-m-d H:i A',strtotime($end));
            $time = strtotime($end);
            $end = date("Y-m-d/h:i A", $time);
            $time = strtotime($start);
            $start = date("Y-m-d/h:i A", $time);
            echo json_encode(array("start"=>$start,"end"=>$end,"result"=>2));
          }
      }
      else{
      echo json_encode(array('timeslot'=>false,"result"=>3));
      }
  }




  
  public function getToppingModalpartytime()
  {

      $output="";
      $cancel_img=$uparr_img=$mgrimg="";
      $cancel_img=base_url()."assets/images/cancel.png";
      $mgrimg=base_url()."assets/images/mgrimg.png";
      $uparr_img=base_url()."assets/images/uparr.png";
      $item_id=$this->input->post('item_id');
      $item_name=$this->input->post('item_name');
      
      $selected_val=$this->input->post('selected_val');
      $slug=$this->input->post('slug');  
      $type=$this->input->post('type');
      $selected_val1=$this->input->post('selected_val1');
      $where=array('sk_id'=>$item_id);
      $item_onboard_details=$this->cm->getRecords($where,'mlt_items_onboarding');
      if($item_onboard_details){
          foreach($item_onboard_details as $info9){
              $item_display_name=$info9->display_name;
              $type1=$info9->type;

          }
      }
      $topping_size_details="";
  $where=array('item_id'=>$item_id,'item_status'=>1);
  $topping_size_details=$this->cm->getRecords($where,'mlt_price');
  $size_details="";$output6='';
  if($topping_size_details)
  {
      $k=1;
      foreach($topping_size_details as $size_info)
      {
        
          if($selected_val==$size_info->sk_id){
            $selected="checked";
            $output6=$size_info->item_size.'₹'.$size_info->item_cost;
          }else{
            $selected="";
          }
          $size_details=$size_details."<div class='col-md-6'>
          <div class='custom-control custom-radio  mb-3'>
                    <input type='radio' id='size$k' name='sizes' value='$size_info->item_size#$item_id' class='custom-control-input csize' $selected>
                    <label class='custom-control-label ml-2' for='size$k'>$size_info->item_size 
                      ₹$size_info->item_cost</label> 
                      </div></div>";
                      $k++;
      }
  }
  
  /* $topping_head_details="";
  $where=array('toping_status'=>1);
  $topping_head_details=$this->cm->getRecords($where,'mlt_topings'); */

$sql="SELECT DISTINCT(mlt_item_toppings.topping_id) as toping_id,mlt_topings.toping_head FROM mlt_item_toppings,mlt_topings WHERE mlt_item_toppings.item_id=$item_id and mlt_item_toppings.topping_id=mlt_topings.toping_id and mlt_topings.toping_status=1";
$binds="";
$topping_head_details=$this->cm->getRecordsQuery($sql, $binds);

$toppingHead="";

$i=1;if($topping_head_details){foreach($topping_head_details as $tinfo){ 
  if($i==1){$menu_active='active';}else{$menu_active='';} 
  $menuClass="topping".$i;    
  $toppingHead=$toppingHead."<li><a class='list-group-item list-group-item-action $menu_active $menuClass'   href='#topping$i' onclick='getToppingId($tinfo->toping_id)'>$tinfo->toping_head</a></li>";
    $i++;}}  
    $menuSizeClass="topping".($i);
    $menuClick=" onclick='getToppingId($i)'";
    $toppingDetails="";$toppingDetails1="";
  $j=1;if($topping_head_details){foreach($topping_head_details as $tp_info){  
      $where=array('item_id'=>$item_id,"topping_id"=>$tp_info->toping_id);
      $topping_item_details=$this->cm->getRecords($where,'mlt_item_toppings'); 
      if($topping_item_details){

$item_details="";$p=1;
$selected10='';
            foreach($topping_item_details as $tpitem){ $toppingItem=rtrim($tpitem->items,',');  
              $empty_cart_id = '';                  
              $tmp=explode(',',$toppingItem);                                   
              for($k=0;$k<sizeof($tmp);$k++){
               if($tmp[$k]!='') {
                   if($tpitem->topping_id!=4) {
                    if($type=='veg' && $tpitem->topping_id==2){
                       $selected10='disabled';
                    }
              $item_details=$item_details."<div class='col-md-6'>
              <div class='custom-control custom-checkbox mb-3'>
              <input type='hidden' value='$item_id' class='item-id'>
                <input type='checkbox' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='$tp_info->toping_head custom-control-input id-$tpitem->topping_id-select sjhd' id='customCheck$tp_info->toping_id$p' $selected10>
                <label class='custom-control-label pl-2' for='customCheck$tp_info->toping_id$p' $selected>$tmp[$k]</label>
              </div>
              </div>";
                   }
                   else{
                      if($selected_val1==$tmp[$k]){$selected="checked";}else{$selected="";}
                      $item_details=$item_details."<div class='col-md-6'>
                      <div class='custom-control custom-radio  mb-3'>
                                <input type='radio' id='cbase$p' name='cbase' value='$tmp[$k]#$tpitem->topping_id#$item_id' class='custom-control-input cbase'$selected>
                                <label class='custom-control-label pl-2' for='cbase$p'>$tmp[$k]</label> 
                                  </div></div>";
                   }
               }
                $p++;}}   
$output='';

                if($tp_info->toping_head!='Base'){
                  $output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head (0/3)</div>
                  <div class='vegcontent'>You can choose upto 3 options</div>";
                  } else{$output=$output."<div class='vegtext count$tp_info->toping_id'>$tp_info->toping_head</div>
                    <div class='vegcontent'>You can choose only 1 option</div>";
                  }
    $toppingDetails=$toppingDetails."<div class='card mb-4' id='topping$j'>
      <div class='card-header' id='heading$j'>
        <h2 class='mb-0'>
          <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
            data-target='#collapse$j' aria-expanded='true' aria-controls='collapse$j'>
            <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
            </div>
            $output
          </button>
        </h2>
      </div>
      <div id='collapse$j' class='collapse show' aria-labelledby='heading$j'
        data-parent='#accordionExample'>
        <div class='card-body row topping-list'>    
          $item_details 
        </div>
      </div>
    </div>"; 
    }$j++;}} 


    $toppingDetails1=$toppingDetails1."<div class='card mb-4' id='size'>
      <div class='card-header' id='headingOne'>
        <h2 class='mb-0'>
          <button class='btn btn-link btn-block text-left' type='button' data-toggle='collapse'
            data-target='#collapse5' aria-expanded='true' aria-controls='collapse5'>
            <div><img src='$uparr_img' class='img-fluid float-right up-arr'>
            </div>
            <div class='vegtext'>Size</div> 
          </button>
        </h2>
      </div>
      <div id='collapse5' class='collapse show' aria-labelledby='heading5'
        data-parent='#accordionExample'>
        <div class='card-body row topping-list'> $size_details 
        </div>
      </div>
    </div>"; 
    

  
    $output6=$selected_val1.' ,'.$output6;

   
    $output="<div class='modal-body'>
    <button type='button' class='close ' data-dismiss='modal' aria-label='Close'>
      <span aria-hidden='true'><div><img class='img-fluid ' src='$cancel_img' alt=''></div></span>
    </button>
    <div class=' d-flex mgr-path ss'>
      <div><img src='$mgrimg' class='img-fluid '></div>
      <input type='hidden' value='$slug' class='slug'>
      <h1 class='pizza-header mb-4 pl-2'><span class='pizzaheader-mgr'>$item_display_name-$item_name</span>
      </h1>
    </div>




    <div class='mgr-line'></div>
    <div class='Customization-text mt-4'>Customization</div>
    <div id='navbar-example2'>
      <div class='tabs-scroll'>
      <ul id='list-example' class=' customize-list d-flex mt-3'>
        $toppingHead
          <li><a class='list-group-item list-group-item-action $menuSizeClass' href='#size' $menuClick>Size</a></li> 
      </ul>
    </div>
    </div>
    <div class='customize-scroll accordion scrolling-bar custom-scrollbar' id='accordionExample' data-spy='scroll'
      data-target='#navbar-example2' data-offset='0'>
      $toppingDetails 
      $toppingDetails1
    </div>
  </div>
  
  <div class=' add-card'>
    <div class='d-flex addcard'>
      <div class='mx-222 mt-3'>
              <div class='customize coustamize_selected'>$output6</div>

        <div class='card-amount mb-1' id='card-amount'>₹$size_info->item_cost</div>
        <div class='card-cust'>CUSTOMIZED</div>
      </div>
      <input type='hidden' id='ccart_id'/>
      <input type='hidden' id='cart_size'/>
      <div class='ml-auto align-self-center'>
      <div class='count-cust '></div>
      <button class='addcard-item ml-auto ' onclick=getValue1(this,$item_id,$size_info->item_cost,-1,'update')>Add to Cart</button></div>
    </div>
  </div>";

  echo $output;
  }

function timing(){
  $output=''; 
  $data=$this->common_data();
  $post_date=$data['post_date'];
   $from=$this->input->post('from');
   $cur_given_time  = date("H:i", strtotime($from));
      $tomdate= date("Y-m-d", strtotime('tomorrow'));
    $end_time="12:00 AM";
    $t1 = strtotime("$post_date $from");
    $t2 = strtotime("$tomdate $end_time");
    $diff = $t2 - $t1;
    $no_hrs = $diff / ( 60 * 60 );
    $time_int=$no_hrs*2; 
    $time=30;
   $start_time=''; $rounded='8888';
   $output=$output."<option value=''>Select Time</option>";
   for($i=0;$i<$time_int;$i++){ 
    if(date('H:i',strtotime("today"))!=$rounded){
      $rounded=date('h:i A',ceil((strtotime('+'.$time.' minutes',strtotime(date($cur_given_time))))/1800)*1800);
    $output=$output."<option value='$rounded'>$rounded</option>";
    $rounded=date('h:i A',strtotime($rounded));
    $time=$time+30; 
    }
  }
    
  echo $output;
}

  public function rating(){
    $data=$this->common_data();
    $order_id=$this->input->post('order_id');
    $order_id=trim($order_id);
     $rating=$this->input->post('rating');
    $user_id='';
       
    $temporary_session_id='';
   if($data['user_id']==''){
 if($this->session->userdata("temporary_session_id")==null || $this->session->userdata("temporary_session_id")==""){

   $user_id = $this->createTempSession();
              $user_id = (int)$user_id;
   $this->session->set_userdata("temporary_session_id", $user_id);
     $where=array('user_id'=>$user_id);
 }else{
 
    $user_id = $this->session->userdata("temporary_session_id");
    $where=array('user_id'=>$user_id);
 }
  }
    else{
        $user_id=$data['user_id'];
       
   $where=array('rating_order_id'=>$order_id);
    }
    if($order_id==''){
      $order_id='';
    }
    $existingRatings=$this->cm->getRecords($where,'mlt_rating');
    if($existingRatings!=false){
      $save_data=array(
        'user_id'=>$user_id,
        'rating_order_id'=>$order_id,
        'rating'=>$rating,
        'created_date_time'=>date('Y-m-d H:i:s')
      );
      $rating_id=$this->cm->updateRecords($save_data,$where,'mlt_rating');
    }else{
    $save_data=array(
      'user_id'=>$user_id,
      'rating_order_id'=>$order_id,
      'rating'=>$rating,
      'created_date_time'=>date('Y-m-d H:i:s')
    );
    $rating_id=$this->cm->save($save_data,'mlt_rating');
  }
    if($rating_id!=false){
      echo json_encode(array('rating_id'=>$rating_id));
    }else{
      echo json_encode(array('rating_id'=>false));
    }
  }



  function win_user(){
    $data=$this->common_data();
    $user_id=$data['user_id'];
   $text_describe= $this->input->post('text_describe');
   $data_array=array('user_id'=>$user_id,'user_text'=>$text_describe,'win_status'=>1);
   $id=$this->cm->save($data_array,'mlt_win');
   if($id!=0){
     echo json_encode(array('boolean'=>true));
   }else{
    echo json_encode(array('boolean'=>false));
   }
  }






  function feed_back(){
    $data=$this->common_data();
    $user_id=$data['user_id'];
   $text_describe= $this->input->post('text_describe');
   $data_array=array('user_id'=>$user_id,'feedback_text'=>$text_describe,'feedback_status'=>1);
   $id=$this->cm->save($data_array,'mlt_feedback');
   if($id!=0){
     echo json_encode(array('boolean'=>true));
   }else{
    echo json_encode(array('boolean'=>false));
   }
  }
public function subscription(){
  $data=$this->common_data();
$email=$this->input->post('email');
$where=array('email_id'=>$email);
$existingSubscribe=$this->cm->getRecords($where,'mlt_subscription');
if($existingSubscribe==false){
$data_saved1=array('email_id'=>$email,'subscription_status'=>1);
$id=$this->cm->save($data_saved1,'mlt_subscription');
if($id!=0){
  echo json_encode(array('boolean'=>true));
}
}else{
  echo json_encode(array('boolean'=>false));
}
}



  public function privacy(){
    $data=$this->common_data();
    $this->load->view('website/privacy',$data);
  }

  public function refund_policy(){
    $data=$this->common_data();
    $this->load->view('website/refund-policy',$data);
  }

  public function terms_and_conditions(){
    $data=$this->common_data();
    $this->load->view('website/terms-and-condition',$data);
  }


  public function party_time_confirmed(){
    $data=$this->common_data();
        $data['from']='';
          $data['to']='';
          $data['select_date']='';
    if($data['user_id']!=''){
      $where=array('order_id'=>$data['order_id']);
      $package_details=$this->cm->getRecords($where,'mlt_user_packages');
      if($package_details!=false){
        foreach($package_details as $info){
          $data['from']=$info->from_time;
          $data['to']=$info->to_time;
          if($info->select_date!=''){
            $data['select_date']=date('M d', strtotime($info->select_date));
            }
        }
      }
    $this->load->view('website/order-scheduled',$data);
    }else{
      redirect('/');
    }
  }
  function utctime($date,$time){
    date_default_timezone_set("Asia/Kolkata");     
    $datetime = $date.' '.$time;
    $event_date=date('Y-m-d H:i:s', strtotime($datetime));
      $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
      $datetime1='"'.$datetime.'"';
      return $datetime1;
  }
  



  
public function sendEmailOne($tomail,$subject,$body){
	
	$config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_user'] = 'thirucshh411@gmail.com';
    $config['smtp_pass'] = 'utxrcxufgizwzhyx';
    $config['smtp_port'] = 465;
    $config['mailtype'] = 'html';
    $this->email->initialize($config);
 
    $this->email->set_newline("\r\n");
    $this->email->from('thirucshh411@gmail.com', 'MLT');
	$this->email->to($tomail);
	$this->email->subject($subject);
	$this->email->message($body);
	$result = $this->email->send();
	if($result){
		return $result;	
	}else{
	  return $this->email->print_debugger();
	}
	
}


public function validations_packages(){
  $data=$this->common_data();
   $this->input->post("select_date");
   $booked_party_times1=$this->cm->getRecords(array('select_date'=>$this->input->post("select_date"),'temp_package_status'=>'1'),'mlt_user_packages');
  $total_vehicles1=$this->cm->getRecords(array(),'mlt_vehicle');
  if($booked_party_times1!=false){
  $booked_party_times=0;
         $booked_party_times=count($booked_party_times1);
  
  $count_vehicles=0;
  if($total_vehicles1!=false){
    foreach($total_vehicles1 as $info){
            $count_vehicles=$info->vehicle_count;
    }
  }
  $balance_vechiles=0;
  if($booked_party_times!=0){
     $balance_vechiles= $count_vehicles-$booked_party_times;
  }
  if($balance_vechiles==0){
    
    $validate_time=$this->validate_time($this->input->post("select_date"),$this->input->post("from_time"),$this->input->post("to_time"));
// var_dump($validate_time);
    if($validate_time==false){
  echo json_encode(array('valid'=>false));

}else{
  echo json_encode(array('valid'=>true));

}
  }else{
    echo json_encode(array('valid'=>false));

  }
}else{
  $booked_party_times=0;
  
        // $booked_party_times=count($booked_party_times1);
  
  $count_vehicles=0;
  if($total_vehicles1!=false){
    foreach($total_vehicles1 as $info){
            $count_vehicles=$info->vehicle_count;
    }
  }
  $balance_vechiles=0;
  if($booked_party_times!=0){
     $balance_vechiles= $count_vehicles-$booked_party_times;
  }
  if($balance_vechiles==0){
    
    $validate_time=$this->validate_time($this->input->post("select_date"),$this->input->post("from_time"),$this->input->post("to_time"));
// var_dump($validate_time);
    if($validate_time==false){
  echo json_encode(array('valid'=>false));

}else{
  echo json_encode(array('valid'=>true));

}
  }else{
    echo json_encode(array('valid'=>false));

  }
}
}
 function validate_time($date,$from,$to){
   $from=date('H:i',strtotime($from));
   $to=date('H:i',strtotime($to));
    $sql="SELECT * FROM `mlt_user_packages` WHERE ('$from' BETWEEN from_time - INTERVAL 2 HOUR AND to_time - INTERVAL -2 HOUR) and ('$to' BETWEEN from_time - INTERVAL 2 HOUR AND to_time - INTERVAL -2 HOUR) and select_date='$date'";
$interval=$this->cm->getRecordsQuery($sql,'');
if($interval!=false){
  return true;
}else{
  return false;
}

 }

}
?>  
