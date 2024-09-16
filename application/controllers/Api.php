<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    var $data = array();
    
    public function __construct(){
        parent::__construct();
        $this->load->model('CommonModel','cm',TRUE);
        $this->load->library('session');
        $this->load->library('common');
        $this->load->helper('url');
    }
    
    /* ====================Common Data==================== */
    public function index() {
        echo "Hi version 1 in index method";
        }
        
        public function encryption($payload) {
            return $encryptedId = JWT::encode(2,pkey);
        }
        public function decryption($cipher) {
            return $encryptedId = JWT::decode($cipher,pkey);
        } 
    
        public function common_data() {
            date_default_timezone_set('Asia/Kolkata');
            $data["date"]=date('Y-m-d');
            $data["time"]=date("h:i:sa");
            $data['date_india']=date('d-m-y');
            
            return $data;
        }
        

        function createTempSession() {
            $randomString = mt_rand(1000000,9999000);
            return $randomString;
        }
        
        public function access_control() {
            header("access-control-allow-credentials:true");
            header("access-control-allow-headers:Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token");
            header("access-control-allow-methods:POST, GET, OPTIONS");
            //header("access-control-allow-origin:".$_SERVER['HTTP_ORIGIN']);
            header("access-control-expose-headers:AMP-Redirect-To,AMP-Access-Control-Allow-Source-Origin");
            // header("amp-access-control-allow-source-origin:".$_SERVER['HTTP_ORIGIN']);
            header("Content-Type: application/json");
            header("AMP-Same-Origin: true");
        
            header("Access-Control-Max-Age: 600");    // cache for 10 minutes
        
            if(isset($_SERVER["HTTP_ORIGIN"]))
            {
                // You can decide if the origin in $_SERVER['HTTP_ORIGIN'] is something you want to allow, or as we do here, just allow all
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            }
            else
            {
                //No HTTP_ORIGIN set, so we allow any. You can disallow if needed here
                header("Access-Control-Allow-Origin: *");
            }
        
            if($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
                if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
                    header("access-control-allow-methods:POST, GET, OPTIONS"); //Make sure you remove those you do not want to support
        
                if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        
                //Just exit with 200 OK with the above headers for OPTIONS method
                exit(0);
            }
        }
        /* =======================Common Methods====================== */
    
/*******************Signup*************************/
	public function signup() {

		$this->access_control();
		$commonData=$this->common_data();
		$created_time=$created_date="";		
		$created_date = $commonData['date'];
		$created_time = $commonData['time'];

		$access_token = false;

		$row=$this->input->request_headers();
		if(isset($row['accesstoken'])) {$access_token = $row['accesstoken']; }
		$data=array();$ret=array();$first_name = $last_name = $email = "";
		if($access_token){

			try {
				if($access_token==globalAccessToken) {
					$params = array();
					$email = $name = $password  = $mobile = $media_type=$auth_token=$google_auth_token=$facebook_auth_token=$insta_auth_token=$signup_stage=null;
					$params = json_decode(@file_get_contents('php://input'),TRUE);
					if(isset($params)) {						
						if(isset($params['name'])) {  $name = $params['name'];} 
						if(isset($params['email'])) { $email = $params['email'];} 
						if(isset($params['mobile'])) { $mobile = $params['mobile'];}
                        if($name!='' && $email!='' && $mobile!=''){
						try { 
							$where=array('mobile'=>$mobile,'user_status'=>1);	 
							$userExists = $this->cm->getRecords($where,'mst_user');
							if($userExists==false) {
                                $where=array('mobile'=>$mobile,'user_status'=>0);	 
                                $userExists1 = $this->cm->getRecords($where,'mst_user');
                                if($userExists1!=false){
                                    $otp = mt_rand(1000,9999);
                                    $update_data=array(
                                        'full_name'=>$name,
                                        'email'=>$email,
                                        'mobile'=>$mobile,
                                        'otp'=>"$otp",
                                        'signup_date'=>date('y:m:d'),
                                        'user_status'=>0
                                    );
                                    $where=array('mobile'=>$mobile);
                                    $this->cm->updateRecords($update_data,$where,'mst_user');
                                    $response = array(

                                        'otp'=>"$otp",
										'Accesstoken'=>JWT::encode($userExists1[0]->sk_user_id,pkey)
									);
                                    $response1=$this->sendsms($mobile,$otp,$name);

                                    $ret=$this->common->response(200,true,'User Registration Successfull',$response);
                                }
                                else{
								$save_data = array();
                                $otp = mt_rand(1000,9999);
								$save_data = array(
                                'full_name'=>$name,
                                'email'=>$email,
                                'mobile'=>$mobile,
                                'otp'=>"$otp",
                                'signup_date'=>date('y:m:d'),
                                'user_status'=>0);
								$userid = $this->cm->save($save_data,'mst_user');
                                if($userid!=false){
        						$response = array(
                                    'otp'=>"$otp",
									'Accesstoken'=>JWT::encode($userid,pkey)
									);
                                    $response1=$this->sendsms($mobile,$otp,$name);
									$ret=$this->common->response(200,true,'User Registration Successfull',$response);
							}
                            else{
                                $response = array(
                                    'otp'=>"",
									'Accesstoken'=>""
									);
                                $ret=$this->common->response(200,false,'User Already Existed',$response);
    
                            }
                        }
                        }
                            else{
                                $response = array(
                                    'otp'=>"",
									'Accesstoken'=>""
									);
                                $ret=$this->common->response(200,false,'User Already Existed',$response);

                            }
						}
						catch(Exception $e) {
							// var_dump($e);
							$msg = "";
							$eMessage = $e->getMessage();
							$eMessage = explode('/',$eMessage);
							$eMessage = explode(':',$eMessage[0]);
							if($eMessage[1]==1062) {
								$msg = "Duplicate Entry";
							}
							else if($eMessage[1]==1452) {
								$msg = "Foreign key constraint fails";
							}
							else {
								$msg = "Database error";
							}
	
							
							$ret=$this->common->response(400,false,$msg,new stdClass());
						}
                    }
					else {
						
						$ret=$this->common->response(400,false,'please check the input',new stdClass());
					}
						
				}
            }
				else {
					
					$ret=$this->common->response(400,false,'invalid Access Token',new stdClass());
				}
			}
			catch (Exception $e) {
				
				$ret=$this->common->response(400,false,'invalid Access Token',new stdClass());
			}
		}
    
		else {
			
			$ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value',new stdClass());
        }
		echo json_encode($ret);
	}





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
     

    public function signin() 
    {
	
		$this->access_control();
		
		$commonData=$this->common_data();
		$today = $commonData['date'];
		$access_token = false; $response = array();$temp_session_id='';
		$row=$this->input->request_headers();
		if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }

		$data=array();$ret=array();
		if($access_token){
			try {
				if($access_token==globalAccessToken) {

					$params = array();
					$email = null;
					$password = null;$user_type="";
					$name=$mobile=$email=$userid="";
					$params = json_decode(@file_get_contents('php://input'),TRUE);
					if(isset($params)) {
						if(isset($params['mobile'])) { $mobile = $params['mobile'];}
						if($mobile!=null) {
							try {
                                $where=array('mobile'=>$mobile,'user_status'=>1);
								$isExits = $this->cm->getRecords($where,'mst_user');
								if($isExits!=false) {
                                    $otp_val = mt_rand(1000,9999);
									$otp=array('otp'=>$otp_val);
									$updatedDeviceId=$this->cm->updateRecords($otp,$where,'mst_user');
									foreach($isExits as $inf)
									{
										$name=$inf->full_name;
										$mobile=$inf->mobile;
										$email=$inf->email;
                                        $otp=$otp_val;
										$userid=$inf->sk_user_id;
									}
									$response = array(
											'name'=>$name,
											'mobile'=>$mobile,
											'email'=>$email,
                                            'otp'=>"$otp",
											'userid'=>$userid,
											'Accesstoken'=>JWT::encode($userid,pkey)
									);

                                    $response1=$this->sendsms($mobile,$otp,$name);

                                    $ret=$this->common->response(200,true,'Success',$response);

                                }
								else{
                                    $response = array(
                                        'name'=>"",
                                        'mobile'=>"",
                                        'email'=>"",
                                        'otp'=>"",
                                        'userid'=>"",
                                        'Accesstoken'=>""
                                );

									$ret=$this->common->response(200,false,'You Must Sign Up first',$response);
								}
                            }	
                            catch(Exception $e) {
	
								$msg = "";
								$eMessage = $e->getMessage();
								$eMessage = explode('/',$eMessage);
								$eMessage = explode(':',$eMessage[0]);
								if($eMessage[1]==1062) {
									$msg = "Duplicate Entry";
								}
								else if($eMessage[1]==1452) {
									$msg = "Foreign key constraint fails";
								}
								else  {
									$msg = "Database error";
								}
	
								$ret=$this->common->response(400,false,$msg,new stdClass());
							}
                        }
								else {
									
									$ret=$this->common->response(400,false,'Inavlid Mobile Number',new stdClass());
								}
							}
					else {
						
						$ret=$this->common->response(400,false,'please check the input ',new stdClass());
					}
				}
				else {
					
					$ret=$this->common->response(400,false,'Invalid Access Token',new stdClass());
				}
		}
        catch (Exception $e) {
				
            $ret=$this->common->response(400,false,'Invalid Access Token',new stdClass());
        }
    }else{	
			$ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
	}
	echo json_encode($ret);
}
	
/***********************************************************otp verification ***********************/

public function otp_verify() 
{
    $this->access_control();
    $commonData=$this->common_data();
    $today = $commonData['date'];
    $access_token = false;
    $temp_session_id='';
    $row=$this->input->request_headers();
    if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
    if(isset($row['temp_session_id'])) { $temp_session_id = $row['temp_session_id']; }

    $data=array();$ret=array();
    if($access_token){
        try {
            if($access_token==globalAccessToken) {

                $params = array();
                $email = null;
                $password = null;$user_type="";
                $name=$mobile=$otp=$userid="";
                $params = json_decode(@file_get_contents('php://input'),TRUE);
                if(isset($params)) {
                    if(isset($params['mobile'])) {  $mobile = $params['mobile'];}
                    if(isset($params['otp'])) {  $otp = $params['otp'];}
                    if($mobile!=null && $otp!=null) {
                        try {
                            $where=array('mobile'=>$mobile,'otp'=>$otp);
                            $isExits = $this->cm->getRecords($where,'mst_user');
                            if($isExits!=false) {
                                $user_status=array('user_status'=>1);
                                $updatedotp=$this->cm->updateRecords($user_status,$where,'mst_user');
                                foreach($isExits as $inf)
                                {
                                    $name=$inf->full_name;
                                    $mobile=$inf->mobile;
                                    $email=$inf->email;
                                    $userid=$inf->sk_user_id;
                                }
                                if($temp_session_id!=''){
                                $temp_session_id=JWT::decode($temp_session_id,pkey);
                                $cart_details= $this->cm->getrecords(array('cuser_id'=>$temp_session_id),'mlt_cart');
                               if($cart_details!=false){
                                $this->cm->updateRecords(array('cuser_id'=>$userid),array('cuser_id'=>$temp_session_id),'mlt_cart');
                               }
                            }
                                $response = array(
                                        'name'=>$name,
                                        'mobile'=>$mobile,
                                        'email'=>$email,
                                        'userid'=>$userid,
                                        'Accesstoken'=>JWT::encode($userid,pkey)
                                );
                                $ret=$this->common->response(200,true,'OTP Verified Successfully',$response);
                            }
                            else{
                                $ret=$this->common->response(200,false,'You enter wrong OTP',new stdClass());
                            }
                        }	
                        catch(Exception $e) {

                            $msg = "";
                            $eMessage = $e->getMessage();
                            $eMessage = explode('/',$eMessage);
                            $eMessage = explode(':',$eMessage[0]);
                            if($eMessage[1]==1062) {
                                $msg = "Duplicate Entry";
                            }
                            else if($eMessage[1]==1452) {
                                $msg = "Foreign key constraint fails";
                            }
                            else  {
                                $msg = "Database error";
                            }

                            $ret=$this->common->response(400,false,$msg,new stdClass());
                        }
                    }
                            else {
                                
                                $ret=$this->common->response(400,false,'Inavlid Otp',new stdClass());
                            }
                        }
                else {
                    
                    $ret=$this->common->response(400,false,'please check the input ',new stdClass());
                }
            }
            else {
                
                $ret=$this->common->response(400,false,'Invalid Access Token',new stdClass());
            }
    }
    catch (Exception $e) {
            
        $ret=$this->common->response(400,false,'Invalid Access Token',new stdClass());
        }
    }else{	
        $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
    }
    echo json_encode($ret);
}


public function resend_otp() 
{
    $this->access_control();
    $commonData=$this->common_data();
    $today = $commonData['date'];
    $access_token = false;
    $row=$this->input->request_headers();
    if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
    $data=array();$ret=array();
    if($access_token){
        try {
            if($access_token==globalAccessToken) {

                $params = array();
                $email = null;
                $password = null;$user_type="";
                $name=$mobile=$otp=$userid="";
                $params = json_decode(@file_get_contents('php://input'),TRUE);
                if(isset($params)) {
                    if(isset($params['mobile'])) {  $mobile = $params['mobile'];}
                    if($mobile!=null) {
                        try {
                            $where=array('mobile'=>$mobile);
                            $isExits = $this->cm->getRecords($where,'mst_user');
                            if($isExits!=false) {
                                 $otp1 = mt_rand(1000,9999);
                                $otp=array('otp'=>$otp1);                               
                                $updatedDeviceId=$this->cm->updateRecords($otp,$where,'mst_user');
                                $where=array('mobile'=>$mobile);
                                $isExits1 = $this->cm->getRecords($where,'mst_user');
                                foreach($isExits1 as $inf)
                                {
                                    $name=$inf->full_name;
                                    $mobile=$inf->mobile;
                                    $email=$inf->email;
                                    $otp=$inf->otp;
                                    $userid=$inf->sk_user_id;
                                }
                                $response = array(
                                   'otp'=>"$otp1",
                                   'Accesstoken'=>JWT::encode($userid,pkey)
                                );
                                $response1=$this->sendsms($mobile,$otp,$name);

                                $ret=$this->common->response(200,true,'Otp will arise in 2 minutes',$response);

                            }
                            else{
                                $ret=$this->common->response(400,true,'User Doesnt Exist',new stdClass());
                            }
                        }	
                        catch(Exception $e) {

                            $msg = "";
                            $eMessage = $e->getMessage();
                            $eMessage = explode('/',$eMessage);
                            $eMessage = explode(':',$eMessage[0]);
                            if($eMessage[1]==1062) {
                                $msg = "Duplicate Entry";
                            }
                            else if($eMessage[1]==1452) {
                                $msg = "Foreign key constraint fails";
                            }
                            else  {
                                $msg = "Database error";
                            }

                            $ret=$this->common->response(400,false,$msg,new stdClass());
                        }
                    }
                            else {
                                
                                $ret=$this->common->response(400,false,'Invalid mobile number',array());
                            }
                        }
                else {
                    
                    $ret=$this->common->response(400,false,'please check the input ',new stdClass());
                }
            }
            else {
                
                $ret=$this->common->response(400,false,'Invalid Access Token',new stdClass());
            }
    }
    catch (Exception $e) {
            
        $ret=$this->common->response(400,false,'Invalid Access Token',new stdClass());
        }
    }else{	
        $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
    }
    echo json_encode($ret);
}

/********************************************resend otp******************/


/****************************************category and items**************/
public function category_item_details() {
	$this->access_control();
	$commonData=$this->common_data();
	$access_token = false;    
    $category_id=$category_status=$view_type=$temp_id='';
	$row=$this->input->request_headers();
	if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
    if(isset($row['category_id']))
    {
        if($row['category_id']=="All"){$category_id ="All";}
        else{$category_id = $row['category_id'];}
    }
    if(isset($row['category_status']))
    {
        if($row['category_status']=="All"){$category_status ="All";}
        else{$category_status = $row['category_status'];}
    }
    if(isset($row['view_type']))
    {
        if($row['view_type']=="All"){$view_type ="All";}
        else{$view_type = $row['view_type'];}
    }
    if(isset($row['temp_id']))
    {
        if($row['temp_id']==""){$temp_id ="";}
        else{$temp_id = $row['temp_id'];}
    }
    if ($category_id!='' && $category_status!='' && $view_type!='') {
        $data=array();
        $ret=array();
        if ($access_token!=globalAccessToken) {
            try {
                $plain_userid=JWT::decode($access_token, pkey);
                $where=array('sk_user_id'=>$plain_userid);
                $userExists=$this->cm->getRecords($where, 'mst_user');
                if ($userExists!=false) {
                    if ($this->input->server('REQUEST_METHOD') === 'GET') {
                        if ($view_type=="Category") {
                            if ($category_id=="All") {
                                if ($category_status=="All") {
                                    $where=array();
                                } else {
                                    $where=array("Items_categorystatus"=>$category_status);
                                }
                            } else {
                                if ($category_status=="All") {
                                    $where=array('sk_categoryItems_id'=>$category_id);
                                } else {
                                       $where=array('sk_categoryItems_id'=>$category_id,"Items_categorystatus"=>$category_status);
                                }
                            }


                            $category_details=$this->cm->getRecords($where, 'mst_categoryitems');
                            if ($category_details) {
                                $count_notifications=0;
                                $where=array('user_id'=>$plain_userid,'notification_status'=>'Unread');
                                    $notifications=$this->cm->getRecords($where,'txn_notifications');
                                    if($notifications!=false){
                                    $count_notifications=count($notifications);
                                    }
                                $category=array();
                                foreach ($category_details as $info) {
                                    $category['category_id']=$info->sk_categoryItems_id;
                                    $category['Items_categoryname']=$info->Items_categoryname;
                                    $category['category_slug']=$info->category_slug;
                                    $category['caption']=$info->caption;
                                    $category['category_image']=admin_img_url.'category/'.$info->category_image;
                                    $category['Items_categorystatus']=$info->Items_categorystatus;
                                    $temp[]=$category;
                                }
                                $categories['count_notifications']=$count_notifications;
                                $categories['categories']=$temp;
                                $ret=$this->common->response(200, true, 'Category Details', $categories);
                            } else {
                                $ret=$this->common->response(200, false, 'No Data Available', array());
                            }
                        } 

                        elseif ($view_type=="Items") {
                            if ($category_id=="All") {
                                if ($category_status=="All") {
                                    $where=array();
                                } else {
                                    $where=array("Items_categorystatus"=>$category_status);
                                }
                            } else {
                                if ($category_status=="All") {
                                    $where=array('sk_categoryItems_id'=>$category_id);
                                } else {
                                    $where=array('sk_categoryItems_id'=>$category_id,"Items_categorystatus"=>$category_status);
                                }
                            }

                            $sql="SELECT mst_categoryitems.Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems.category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type,mst_categoryitems.category_slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id WHERE category_id=$category_id and item_onboarding_status=1";
            
                                $binds="";
                                $category_details=$this->cm->getRecordsQuery($sql, $binds);
                                if ($category_details) {
                                    $temp2=array();
                                    $temp=array();
                                    
                                    foreach ($category_details as $info) {
                                        $temp20=array();
                                       $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                       $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']="";
                                       $items['description']=$items['type']=$items['section_name']="";
                                        $items=array();
                                        $items['9_inces']='0';
                                        $items['cart_button']='0';
                                        $items['12_inces']='0';
                                        $items['base_drop']=$items['price_drop']=array();
                                        $items['item_name']=$info->item_name;
                                        $items['item_id']=$info->sk_id;
                                        $items['slug1']=$info->category_slug;

                                        $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                                        $price_details=$this->cm->getRecords($where,'mlt_price');
                                        $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                                        $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                                        if($base_details!=false){
                                            foreach($base_details as $info10){
                                                $base=explode(',',$info10->items);
                                                if(!empty($base)){
                                                    for($k=0;$k<sizeof($base);$k++){
                                                        $base1['base_string']=$base[$k];
                                                        $temp20[]=$base1;
                                                    }
                                                }
                                                $items['base_drop']=$temp20;
                                            }

                                        }
                                        if($price_details!=false && $items['slug1']=='pizzas'){
                                            $items['price_drop']=$price_details;

                                        }
                                        $price="";
                                        if($price_details!=false){
                                                  $price=$price_details[0]->item_cost;
                                            
                                        }
                                        $where=array('citem_id'=>$info->sk_id,'cuser_id'=>$plain_userid);
                                       // var_dump($where);
                                        $cart_details=$this->cm->getRecords($where,'mlt_cart');
                                        if($cart_details!=false){
                                             $items['cart_button']='1';
                                            foreach($cart_details as $info200){
                                                if($info200->customization){
                                                    $customization=json_decode($info200->customization);
                                                    if($customization->size){

                                                        foreach($customization->size as $info15){
                                                            if($info15=='9 inches (small)'){
                                                                $items['9_inces']=$info200->quantity;
                                                                $items['12_inces']='0';

                                                            }else {
                                                                $items['9_inces']='0';
                                                                $items['12_inces']=$info200->quantity;
                                                            }
                                                        }
                                                    }else{
                                                                 $items['9_inces']=$info200->quantity;
                                                                $items['12_inces']='0';
                                                            }
                                                        }
                                                    }
                                                }
                                            
                                        
                                        $where=array('item_id'=>$info->sk_id,'user_id'=>$plain_userid);
                                        $favorites=$this->cm->getRecords($where,'mst_favourite');
                                        if($favorites!=false){
                                            $items['favour']=true;
                                        }else{
                                            $items['favour']=false;
                                        }
                                         $items['price']=$price;
                                        $items['image']=admin_img_url.'items/'.$info->image;
                                        $items['display_name']=$info->display_name;
                                        $items['item_status']=$info->item_onboarding_status;
                                        $items['description']=$info->short_description;
                                        // $items['seo_description']=$info->seo_description;
                                        // $items['seo_title']=$info->seo_title;
                                        $items['short_description']=$info->description;
                                        $items['type']=$info->type;
                                        $items['section_name']=$info->section_name;

                                        $temp[]=$items;
                                    }
                                    $categoryTypeInfo['item_details']=$temp;

                                $ret=$this->common->response(200, true, 'Item Details', $categoryTypeInfo);
                            } else {
                                $ret=$this->common->response(400, false, 'No Data Available', array());
                            }
                    } 
                    elseif ($view_type=="ItemsId") {
                        if ($category_id=="All") {
                            if ($category_status=="All") {
                                $where=array();
                            } else {
                                $where=array("item_onboarding_status"=>$category_status);
                            }
                        } else {
                            if ($category_status=="All") {
                                $where=array('sk_id'=>$category_id);
                            } else {
                                $where=array('sk_id'=>$category_id,"item_onboarding_status"=>$category_status);
                            }
                        }               
                           $category_details=$this->cm->getRecords($where,'mlt_items_onboarding');
                            if ($category_details) {
                                $cart_count_details=array();
                                $where=array('cuser_id'=>$plain_userid,'party_time'=>0);
                                $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                                $cart_price=$i=0;$cart=array();
                                $items['cart_count']=$items['cart_price']=0;
                                if($cart_count_details){
                                    foreach($cart_count_details as $info10){
                                        $cart_price=$cart_price+$info10->price;
                                        $i++;
                                    }
                                }
                                $where=array('cuser_id'=>$plain_userid,'party_time'=>0);
                                $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 

                                $items['cart_price']=$cart_price;
                                 $items['cart_count']=$i;
                                $temp2=array();
                                $temp=array();
                                foreach ($category_details as $info) {
                                     $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                   $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']="";
                                   $items['description']=$items['type']=$items['section_name']="";
                                    $items['item_name']=$info->item_name;
                                    $items['item_id']=$info->sk_id;
                                    $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                                    $price_details=$this->cm->getRecords($where,'mlt_price');
                                    $where=array('item_id'=>$info->sk_id);
                                    $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                                    $price=0;
                                    if($price_details){
                                             $price=$price_details[0]->item_cost;
                                              $size=$price_details[0]->item_size;
                    
                                    }
                                    $items['toppings']=array();
                                    if($base_details!=false){
                                        foreach($base_details as $info8){
                                            $top['topping_id']=$info8->topping_id;
                                            $where=array('toping_id'=>$info8->topping_id);
                                            $topings=$this->cm->getRecords($where,'mlt_topings');
                                            $top['toping_head']=$topings[0]->toping_head;
                                            $top['item_id']=$info8->item_id;
                                            $top['items']=$info8->items;
                                            $temp9[]=$top;
                                        }
                                        $items['toppings']=$temp9;

                                    }
                                    if($price_details){
                                        $items['size_deatils']=$price_details;

                                    }
                                    $where=array('item_id'=>$info->sk_id,'user_id'=>$plain_userid);
                                    $favorites=$this->cm->getRecords($where,'mst_favourite');
                                    if($favorites!=false){
                                        $items['favour']=true;
                                    }else{
                                        $items['favour']=false;
                                    }
                                     $items['price']=$price;                                        
                                     $items['image']=admin_img_url.'items/'.$info->image;
                                    $items['display_name']=$info->display_name;
                                    $items['item_status']=$info->item_onboarding_status;
                                    $items['description']=$info->short_description;
                                    $items['slug1']=$info->slug;
                                    $items['short_description']=$info->description;
                                    $items['type']=$info->type;
                                    $items['section_name']=$info->section_name;

                                    $temp[]=$items;
                                }
                                $categoryTypeInfo['items_detailed']=$temp;
                            $ret=$this->common->response(200, true, 'Item Details', $categoryTypeInfo);
                        } else {
                            $ret=$this->common->response(400, false, 'No Data Available', array());
                        }
                } 
                    else {
                        $ret=$this->common->response(400, false, 'Wrong Method', array());
                    }
                } else {
                    $ret=$this->common->response(400, false, 'Invalid Access Token1', array());
                }
            } else{
                $ret=$this->common->response(400, false, 'user not Registered', array());

            }
        }catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token',array());
            }
        } elseif ($access_token==globalAccessToken) {
            try {
                    if ($this->input->server('REQUEST_METHOD') === 'GET') {
                        if ($view_type=="Category") {
                            if ($category_id=="All") {
                                if ($category_status=="All") {
                                    $where=array();
                                } else {
                                    $where=array("Items_categorystatus"=>$category_status);
                                }
                            } else {
                                if ($category_status=="All") {
                                    $where=array('sk_categoryItems_id'=>$category_id);
                                } else {
                                    $where=array('sk_categoryItems_id'=>$category_id,"Items_categorystatus"=>$category_status);
                                }
                            }


                            $category_details=$this->cm->getRecords($where, 'mst_categoryitems');
                            if ($category_details) {
                                $count_notifications=0;
                                if($temp_id!=''){
                                $where=array('user_id'=>$temp_id,'notification_status'=>'Unread');
                                    $notifications=$this->cm->getRecords($where,'txn_notifications');
                                    if($notifications!=false){
                                        $count_notifications=count($notifications);
                                    }
                                }
                                $category=array();
                                foreach ($category_details as $info) {
                                    $category['category_id']=$info->sk_categoryItems_id;
                                    $category['Items_categoryname']=$info->Items_categoryname;
                                    $category['category_slug']=$info->category_slug;
                                    $category['caption']=$info->caption;
                                    $category['category_image']=admin_img_url.'category/'.$info->category_image;
                                    $category['Items_categorystatus']=$info->Items_categorystatus;
                                    $temp[]=$category;
                                }
                                $categories['count_notifications']=$count_notifications;
                                $categories['categories']=$temp;
                                $ret=$this->common->response(200, true, 'Category Details', $categories);
                            } else {
                                $ret=$this->common->response(200, false, 'No Data Available', array());
                            }
                        } 

                        elseif ($view_type=="Items") {
                            if ($category_id=="All") {
                                if ($category_status=="All") {
                                    $where=array();
                                } else {
                                    $where=array("Items_categorystatus"=>$category_status);
                                }
                            } else {
                                if ($category_status=="All") {
                                    $where=array('sk_categoryItems_id'=>$category_id);
                                } else {
                                    $where=array('sk_categoryItems_id'=>$category_id,"Items_categorystatus"=>$category_status);
                                }
                            }

                            $sql="SELECT mst_categoryitems.Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems.category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type,mst_categoryitems.category_slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id WHERE category_id=$category_id and item_onboarding_status=1";
                                               
                                $binds="";
                                $category_details=$this->cm->getRecordsQuery($sql, $binds);
                                if ($category_details) {
                                    $temp2=array();
                                    $temp=array();
                                    foreach ($category_details as $info) {
                                        $temp20=array();

                                         $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                       $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']="";
                                       $items['description']=$items['type']=$items['section_name']="";
                                        $items=array();
                                        $items['9_inces']='0';
                                        $items['cart_button']='0';
                                        $items['12_inces']='0';
                                        $items['base_drop']=$items['price_drop']=array();
                                        $items['item_name']=$info->item_name;
                                        $items['slug1']=$info->category_slug;
                                        $items['item_id']=$info->sk_id;
                                        $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                                        $price_details=$this->cm->getRecords($where,'mlt_price');
                                        $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                                        $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                                        
                                        
                                        $price="";
                                        if($base_details!=false){
                                            foreach($base_details as $info10){
                                                $base=explode(',',$info10->items);
                                                if(!empty($base)){
                                                    for($k=0;$k<sizeof($base);$k++){
                                                        $base1['base_string']=$base[$k];
                                                        $temp20[]=$base1;
                                                    }
                                                }
                                                $items['base_drop']=$temp20;
                                            }

                                        }
                                        if($price_details!=false && $items['slug1']=='pizzas'){
                                        
                                            $items['price_drop']=$price_details;

                                        }
                                        $price="";
                                        if($price_details!=false){
                                                  $price=$price_details[0]->item_cost;
                        
                                        
                                        }
                                       
                                        $items['favour']=false;

                                         $items['price']=$price;                                        
                                         $items['image']=admin_img_url.'items/'.$info->image;
                                        $items['display_name']=$info->display_name;
                                        $items['item_status']=$info->item_onboarding_status;
                                        $items['description']=$info->short_description;
                                        // $items['seo_description']=$info->seo_description;
                                        // $items['seo_title']=$info->seo_title;
                                        $items['short_description']=$info->description;
                                        $items['type']=$info->type;
                                        $items['section_name']=$info->section_name;

                                        $temp[]=$items;
                                    }
                                    $categoryTypeInfo['item_details']=$temp;

                                $ret=$this->common->response(200, true, 'Item Details', $categoryTypeInfo);
                            } else {
                                $ret=$this->common->response(400, false, 'No Data Available', array());
                            }
                    } 
                    elseif ($view_type=="ItemsId") {
                        if ($category_id=="All") {
                            if ($category_status=="All") {
                                $where=array();
                            } else {
                                $where=array("item_onboarding_status"=>$category_status);
                            }
                        } else {
                            if ($category_status=="All") {
                                $where=array('sk_id'=>$category_id);
                            } else {
                                $where=array('sk_id'=>$category_id,"item_onboarding_status"=>$category_status);
                            }
                        }
                        if($temp_id!=''){
                        $temp_id=JWT::decode($temp_id,pkey);
                        }
                        $category_details=$this->cm->getRecords($where,'mlt_items_onboarding');
                            if ($category_details) {
                                $cart_count_details=array();
                                $where=array('cuser_id'=>$temp_id,'party_time'=>0);
                                $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 

                                $cart_price=$i=0;$cart=array();
                                $items['cart_count']=$items['cart_price']=0;
                                if($cart_count_details!=false){
                                    foreach($cart_count_details as $info10){
                                        $cart_price=$cart_price+$info10->price;
                                        $i++;
                                    }
                                }
                                $items['cart_price']=$cart_price;
                                 $items['cart_count']=$i;
                                
                                $temp2=array();
                                $temp=array();
                                foreach ($category_details as $info) {
                                     $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                   $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']="";
                                   $items['description']=$items['type']=$items['section_name']="";
                                    $items['item_name']=$info->item_name;
                                    $items['item_id']=$info->sk_id;
                                    $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                                    $price_details=$this->cm->getRecords($where,'mlt_price');
                                    $where=array('item_id'=>$info->sk_id);
                                    $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                                    $price=0;
                                    if($price_details){
                                             $price=$price_details[0]->item_cost;
                                              $size=$price_details[0]->item_size;
                    
                                        
                                    }
                                    $items['toppings']=array();
                                    if($base_details!=false){
                                        foreach($base_details as $info8){
                                            $top['topping_id']=$info8->topping_id;
                                            $where=array('toping_id'=>$info8->topping_id);
                                            $topings=$this->cm->getRecords($where,'mlt_topings');
                                            $top['toping_head']=$topings[0]->toping_head;
                                            $top['item_id']=$info8->item_id;
                                            $top['items']=$info8->items;
                                            $temp9[]=$top;
                                        }
                                        $items['toppings']=$temp9;

                                    }
                                    if($price_details){
                                        $items['size_deatils']=$price_details;

                                    }
                                    $items['favour']=false;

                                     $items['price']=$price;                                        
                                     $items['image']=admin_img_url.'items/'.$info->image;
                                    $items['display_name']=$info->display_name;
                                    $items['item_status']=$info->item_onboarding_status;
                                    $items['description']=$info->short_description;
                                    $items['slug1']=$info->slug;
                                    $items['short_description']=$info->description;
                                    $items['type']=$info->type;
                                    $items['section_name']=$info->section_name;

                                    $temp[]=$items;
                                }
                                $categoryTypeInfo['items_detailed']=$temp;

                            $ret=$this->common->response(200, true, 'Item Details', $categoryTypeInfo);
                        } else {
                            $ret=$this->common->response(400, false, 'No Data Available', array());
                        }
                } 
                 
                    
                    else {
                        $ret=$this->common->response(400, false, 'Wrong Method', array());
                    }
                } else {
                    $ret=$this->common->response(400, false, 'Invalid Access Token1', array());
                }
        }catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }
    }
}
	echo json_encode($ret);
}








/*******************api on address*************/
    public function address(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        $data=array();$ret=array();$address=array();
        if($access_token!=globalAccessToken)
        {
            try{
                $id=JWT::decode($access_token,pkey);
                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists){
                    if ($this->input->server('REQUEST_METHOD') === 'GET')
                    {
                        $address_status=$address_id='';
                        if(isset($row['sk_address_id']))
                        {
                            if($row['sk_address_id']=="All")
                            {
                                $address_id ="All";
                            }
                            else{
                                $address_id = $row['sk_address_id'];
                            }
                        }
                        if(isset($row['address_status']))
                        {
                            if($row['address_status']=="All")
                            {
                                $address_status ="All";
                            }
                            else
                            {
                                $address_status = $row['address_status'];
                            }
                        }
                        if($address_id=="All")
                        {
                            if($address_status=="All")
                            {
                                $where=array('user_id'=>$id);
                            }
                            else
                            {
                                $where=array('address_status'=>$address_status,'user_id'=>$id);
                            }
    
                        }
                        else
                        {
                            if($address_status=="All"){$where=array('sk_address_id'=>$address_id,'user_id'=>$id);}
                            else{$where=array('sk_address_id'=>$address_id,'address_status'=>$address_status,'user_id'=>$id);}
                        }
                        $address_details=$this->cm->getRecords($where,'mlt_address'); 
                        $address['user_id']= $address['area']=$address['house_no']=$address['city']=$address['state']=$address['country']=$address['pincode']=$address['street']=$address['latitude']=$address['longitude']=$address['full_address']=$address['address_type']=$address['land_mark']="";
                        if($address_details!=false)
                        {
                           
                            foreach($address_details as $info1)
                            {  
                               
                                $address['sk_address_id']=$info1->sk_address_id;
                                $address['user_id']=$info1->user_id;
                                if($info1->area!=null){
                                    $address['area']=$info1->area;
                                }
                                $address['house_no']=$info1->house_no;
                                $address['city']=$info1->city;
                                $address['state']=$info1->state;
                                 $address['country']=$info1->country;
                                 if($info1->pincode!=""){$address['pincode']=$info1->pincode;}
                                 else
                                 {$address['pincode']="";}
                                 $address['street']=$info1->street;
                                 $address['latitude']=$info1->latitude;
                                 $address['longitude']=$info1->longitude;
                                 $address['full_address']=$info1->full_address;
                                 $address['address_type']=$info1->address_type;
                                 if($info1->land_mark!=null){
                                 $address['land_mark']=$info1->land_mark;
                                 }
                                $address['address_status']=$info1->address_status;
                                $temp[]=$address;
                            }
                            $address1['address_details']=$temp;
                            $ret=$this->common->response(200,true,'Address Details',$address1);
                    }
                    else{
                        $temp=array();
                        $address1['address_details']=$temp;
                        $ret=$this->common->response(200,false,'No Data Available',$address1);
                    }
                }
                else if($this->input->server('REQUEST_METHOD') === 'POST'){
                    $params = array();
                    $area=$house_no=$city=$state=$country=$pincode=$street=$latitude=$longitude=$full_address=$address_type=$land_mark=$address_status="";
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params)) { 
                        if(isset($params['area'])) { $area = $params['area'];} 
                        if(isset($params['house_no'])) { $house_no = $params['house_no'];} 
                        if(isset($params['city'])) { $city = $params['city'];} 
                        if(isset($params['state'])) {  $state = $params['state'];} 
                        if(isset($params['country'])) {  $country = $params['country'];} 
                        if(isset($params['pincode'])) {  $pincode = $params['pincode'];} 
                        if(isset($params['street'])) {  $street = $params['street'];} 
                        if(isset($params['latitude'])) {  $latitude = $params['latitude'];} 
                        if(isset($params['longitude'])) {  $longitude = $params['longitude'];} 
                        if(isset($params['full_address'])) {  $full_address = $params['full_address'];} 
                        if(isset($params['address_type'])) {  $address_type = $params['address_type'];} 
                        if(isset($params['land_mark'])) {  $land_mark = $params['land_mark'];} 
                       $address_type= trim($address_type);
                        $saveData = array(
                            'user_id'=>$id,
                            'area'=>$area,
                            'house_no'=>$house_no,
                            'city'=>$city,
                            'state'=>$state,
                            'country'=>$country,
                            'pincode'=>$pincode,
                            'street'=>$street,
                            'latitude'=>$latitude,
                            'longitude'=>$longitude,
                            'full_address'=>$full_address,
                            'address_type'=>$address_type,
                            'land_mark'=>$land_mark,
                            'address_status'=>'1'
                             
                    );
                    try {
                        $address_id = $this->cm->save($saveData,'mlt_address'); 
                        if($address_id!=0) {
                            $ret=$this->common->response(200,true,'Address Save Success',$address_id);
                        }
                        else {
                            $ret=$this->common->response(400,false,'Address Save Failure',array());
                        }
                    }
                    catch(Exception $e) {

                        $msg = "";
                        $eMessage = $e->getMessage();
                        $eMessage = explode('/',$eMessage);
                        $eMessage = explode(':',$eMessage[0]);
                        if($eMessage[1]==1062) {
                            $msg = "Duplicate Entry";
                        }
                        else if($eMessage[1]==1452) {
                            $msg = "Foreign key constraint fails";
                        }
                        else  {
                            $msg = "Database error";
                        }
                        $ret=$this->common->response(400,false,$msg,array());
                    }
               
            }
            else {
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }
                

                }
                elseif ($this->input->server('REQUEST_METHOD') == 'PUT')
                {
                    $params = array();
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    $address_id=$area=$house_no=$city=$state=$country=$pincode=$street=$latitude=$longitude=$full_address=$address_type=$update_type="";    
                    if(isset($params))
                {
                    if(isset($params['sk_address_id'])) {  $address_id = $params['sk_address_id'];} 
                    //if(isset($params['user_id'])) { $user_id = $params['user_id'];} 
                    if(isset($params['area'])) { $area = $params['area'];}
                    if(isset($params['house_no'])) { $house_no = $params['house_no'];} 
                    if(isset($params['city'])) { $city = $params['city'];} 
                    if(isset($params['state'])) { $state = $params['state'];} 
                    if(isset($params['country'])) { $country = $params['country'];} 
                    if(isset($params['pincode'])) { $pincode = $params['pincode'];} 
                    if(isset($params['street'])) { $street = $params['street'];} 
                    if(isset($params['latitude'])) { $latitude = $params['latitude'];} 
                    if(isset($params['longitude'])) { $longitude = $params['longitude'];} 
                    if(isset($params['full_address'])) { $full_address = $params['full_address'];} 
                    if(isset($params['address_type'])) { $address_type = $params['address_type'];} 
                    if(isset($params['land_mark'])) { $land_mark = $params['land_mark'];} 
                    if(isset($params['update_type'])) {   $update_type = $params['update_type'];} 
                    try {
                        $updateData=array();
                        if($address_id!="" &&  $update_type!=""){
                            if($update_type=="Edit"){
                                $updateData = array(
                                'area'=>$area,
                                'house_no'=>$house_no,
                                'city'=>$city,
                                'state'=>$state,
                                'country'=>$country,
                                'pincode'=>$pincode,
                                'street'=>$street,
                                'latitude'=>$latitude,
                                'longitude'=>$longitude,
                                'full_address'=>$full_address,
                                'address_type'=>$address_type,
                                'land_mark'=>$land_mark,
                                'address_status'=>'1'
                                );
                                if($updateData){
                                    $where=array('sk_address_id'=>$address_id);
                                    $response = $this->cm->updateRecords($updateData,$where,'mlt_address');
                                    $ret=$this->common->response(200,true,'Address Details Updated Successfully',$response);
                            }
                        }
                        else{
                            $where=array('sk_address_id'=>$address_id);  
                            $response = $this->cm->deleteRecords($where,'mlt_address');
                            $ret=$this->common->response(200,true,'Address Details Deleted Successfully',array());

                        }
                       
                        }
                   else{
                        $ret=$this->common->response(400,true,'Please Check Json1 Input or Value1',array());
                    } 




                }
                catch(Exception $e){
                    $msg = "";
                    $eMessage = $e->getMessage();
                    $eMessage = explode('/',$eMessage);
                    $eMessage = explode(':',$eMessage[0]);
                    if($eMessage[1]==1062) {
                        $msg = "Duplicate Entry";
                    }
                    else if($eMessage[1]==1452) {
                        $msg = "Foreign key constraint fails";
                    }
                    else  {
                        $msg = "Database error";
                    }
                    $ret=$this->common->response(400,true,$msg,array());
                }
            }
                else
                {
                    $ret=$this->common->response(400,false,'Please check the input',$data);
                }
            }
        
                else {
                    $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value',$data);
                }
            }
                }
            catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }
            
        }
        else{
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
        }
        echo json_encode($ret);
    
    }
    /*****************end of api on address *****************/
    /***********api on favourites***********/
    public function favourites(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        $data=array();$ret=array();$favourite=array();$cart_details=array();
        if($access_token!=globalAccessToken)
        {
            try{
                $id=JWT::decode($access_token,pkey);
            //    echo $id;				 
                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists){
                    if ($this->input->server('REQUEST_METHOD') === 'GET')
                    {
                        $favourite_status=$favourite_id='';
                        if(isset($row['sk_favourite_id']))
                        {
                            if($row['sk_favourite_id']=="All")
                            {
                                $favourite_id ="All";
                            }
                            else{
                                $favourite_id = $row['sk_favourite_id'];
                            }
                        }
                        if(isset($row['status']))
                        {
                            if($row['status']=="All")
                            {
                                $favourite_status ="All";
                            }
                            else
                            {
                                $favourite_status = $row['status'];
                                }
                            }
                            if($favourite_id=="All")
                            {
                            if($favourite_status=="All")
                            {
                                $where=array();
                            }
                            else
                            {
                                $where=array('status'=>$favourite_status,'user_id'=>$id);
                            }
    
                            }
                            else
                            {
                                if($favourite_status=="All"){$where=array('sk_favourite_id'=>$favourite_id,'user_id'=>$id);}
                                else{$where=array('sk_favourite_id'=>$favourite_id,'status'=>$favourite_status,'user_id'=>$id);}
                            }
                            $favourite=$this->cm->getRecords($where,'mst_favourite'); 
                            $favor['count']=$favor['total_price']=0;
                            if($favourite!=false){     
                            foreach($favourite as $info1){
                                $favor['sk_favourite_id']=$info1->sk_favourite_id;
                                 $sql = "SELECT * from mlt_items_onboarding JOIN mst_categoryitems on mlt_items_onboarding.category_id=mst_categoryitems.sk_categoryItems_id WHERE sk_id='$info1->item_id'";
                                $binds='';
                                $items_details=$this->cm->getRecordsQuery($sql,$sql);
                                if($items_details!=false){
                                   
                                        $temp2=array();
                                        $temp=array();
                                        foreach ($items_details as $info) {
                                            $temp20=array();
                                            $items['cart_count']='0';
                                            $items['item_price_cart']=$items['item_size_cart']=$items['item_name']= $items['item_id']=$items['price']=$items['image']="";
                                            $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']="";
                                            $items['description']=$items['type']=$items['section_name']=$items['short_description']="";
                                            $items['base_drop']=$items['price_drop']=array();
                                            $items['item_name']=$info->item_name;
                                            $items['item_id']=$info->sk_id;
                                            $where=array('citem_id'=>$info->sk_id,"cuser_id"=>$id,"party_time"=>0);
                                            $cart_details=$this->cm->getRecords($where,'mlt_cart');
                                            if($cart_details!=false){
                                                foreach($cart_details as $info89){
                                                     $items['cart_count']=$info89->quantity;
                                                     $favor['count']=$items['cart_count']+$favor['count'];
                                                     $items['total_price']=$info89->price;
                                                     $favor['total_price']=$items['total_price']+$favor['total_price'];
                                                    if($info89->item_size!=1){
                                                    $items['item_size_cart']=$info89->item_size;
                                                    }
                                                    $items['item_price_cart']=$info89->item_price;
                                                }
                                            }
                                            $items['slug1']=$info->category_slug;
                                            $items['image']=admin_img_url.'/items/'.$info->image;
                                            $items['display_name']=$info->display_name;
                                            $items['description']=$info->short_description;
                                            $items['short_description']=$info->description;
                                             $items['type']=$info->type;
                                            $items['section_name']=$info->section_name;
                                            $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                                            $price_details=$this->cm->getRecords($where,'mlt_price');
                                            $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                                            $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                                            if($base_details!=false){
                                                foreach($base_details as $info10){
                                                    $base=explode(',',$info10->items);
                                                    if(!empty($base)){
                                                        for($k=0;$k<sizeof($base);$k++){
                                                            $base1['base_string']=$base[$k];
                                                            $temp20[]=$base1;
                                                        }
                                                    }
                                                    $items['base_drop']=$temp20;
                                                }
                                            }
                                            if($price_details!=false && $items['slug1']=='pizzas'){
                                                $items['price_drop']=$price_details;
                                            }
                                            $price="";
                                            if($price_details!=false){
                                                foreach($price_details as $row3){
                                                      $price=$row3->item_cost;
                                                }
                                            }
                                            $items['price']=$price;
                                        }
                                        $categoryTypeInfo[]=$items;
                                }
                                $favor['favourites']=$categoryTypeInfo;
                            }
                             $ret=$this->common->response(200, true, 'Item Details', $favor);
                        }

                        else{
                            $categoryTypeInfo=array();
                            $favor['favourites']=$categoryTypeInfo;

                            $ret=$this->common->response(200,false,'No Data Available',$favor);
                        }
                    }else if($this->input->server('REQUEST_METHOD') === 'POST'){
                        $params = array();
                        $favourite_id=$user_id=$item_id=$slug=$favourite_status="";
                        $params = json_decode(@file_get_contents('php://input'),TRUE);
                        if(isset($params)) { 
                        if(isset($params['item_id'])) { $item_id = $params['item_id'];} 
                        if($item_id!=''){
                            $where=array('item_id'=>$item_id,'user_id'=>$id);
                            $existingFavour=$this->cm->getRecords($where,'mst_favourite');
                            if($existingFavour!=false){
                                $where=array('item_id'=>$item_id,'user_id'=>$id);
                                $updated=$this->cm->deleteRecords($where,'mst_favourite');
                                    $ret=$this->common->response(200,true,'Favourite Deleted Successfully',1);
                            }
                            else{
                        $saveData = array(
                            'user_id'=>$id,
                            'item_id'=>$item_id,
                            'slug'=>$slug,
                            'date'=>date('Y-m-d'),
                            'time'=>date('h:i:s'),
                            'status'=>'1'
                             );
                            $favourite_id = $this->cm->save($saveData,'mst_favourite'); 
                                if($favourite_id!=0) {
                            $ret=$this->common->response(200,true,'Favourite Save Success',1);
                            }
                            else{
                                $ret=$this->common->response(400,false,'Favourite Save failure',0);
                            }
                        }
                            
                    
                }else{
                    $ret=$this->common->response(400,false,'Please check the input',$data);
 
                }
                    }
             else {
                    $ret=$this->common->response(400,false,'Please check the input',$data);
                }                       
             }      
            }  else{
                $ret=$this->common->response(400,false,'Usere is not existed',$data);

            }
        }    
            catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }
        }        
        else{
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
        }
        echo json_encode($ret);
    }
 
        /**************************end of favourite***********************/
         
        

        public function cart(){
            $this->access_control();
            $commonData=$this->common_data();
            $access_token = false;
            $row=$this->input->request_headers();
            $temp_user_id =$party_time="";
            if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
            if(isset($row['temp_user_id'])) { $temp_user_id = $row['temp_user_id']; }
            if(isset($row['party_time'])) { $party_time = $row['party_time']; }
            $data=array();$ret=array();$cart=array();
            if($access_token!=globalAccessToken)
            {   
                      $id=JWT::decode($access_token,pkey);			 
                    $where=array('sk_user_id'=>$id,'user_status'=>1);
                    $userExists=$this->cm->getRecords($where,'mst_user');
                    if($userExists){
                        if ($this->input->server('REQUEST_METHOD') === 'GET')
                        {
                            $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                            $cart_details=$this->cm->getRecords20($where,'mlt_cart');
                            $price=0;
                            $item_size=$item_size1=array();
                            if($cart_details){
                                foreach($cart_details as $info){ 
                                        $item_id=$info->citem_id;
                                        $where=array('sk_id'=>$item_id);
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
                                        }
                            }
                            $count=count($item_size);
                            $count1=count($item_size1);
                                $where=array('cstatus'=>1,'cuser_id'=>$id,'party_time'=>$party_time);
                                $cart_details=$this->cm->getRecords($where,'mlt_cart'); 
                                if($cart_details)
                                {
                                    $cart_price=$i=0;
                                    foreach($cart_details as $info1)
                                    {  
                                        $cart['cuser_id']= $cart['item_id']=$cart['quantity']=$cart['price']=$cart['item_size']=$cart['base']=$cart['item_price']=NULL;
                                        $cart['veg']='';
                                        $cart['non_veg']='';
                                        $cart['flavour']='';
                                        $cart['base1']=''; 
                                        $cart['size']='';
                                        $cart['sk_cart_id']=$info1->sk_cart_id;
                                        $cart['cuser_id']=$info1->cuser_id;
                                        $cart['item_id']=$info1->citem_id;
                                        $custom=json_decode($info1->customization);
                                        $output4=array();$output7=$output8=$output9=$output10=$output98=array();
                                        if($custom->veg){
                                            foreach($custom->veg as $info11){
                                               $output4[]=$info11;
                                               $output98[]=$info11;
                                            }
                                        }
                                        if($custom->nonveg){
                                            foreach($custom->nonveg as $info12){
                                                $output7[]=$info12;
                                                $output98[]=$info12;
                                            }
                                        }if($custom->flavor){
                                            foreach($custom->flavor as $info13){
                                                $output8[]=$info13;
                                            }
                                        }if($custom->base){
                                            foreach($custom->base as $info14){
                                                $output9[]=$info14;
                                            }
                                        }if($custom->size){
                                            foreach($custom->size as $info15){
                                                $output10[]=$info15;
                                            }
                                        }
                                        $output30='';
                                        $output25=implode(',',$output4);
                                        $output30=implode(',',$output98);
                                        $output26=implode(',',$output7);
                                        $output27=implode(',',$output8);
                                        $output28=implode(',',$output9);
                                        $output29=implode(',',$output10);
                                       $cart['veg']=trim($output25,', ');
                                       $cart['selected_total']='';
                                       $cart['selected_total']=$output30;
                                       $cart['non_veg']=trim($output26,', ');
                                       $cart['flavour']=trim($output27,', ');
                                       $cart['base1']=trim($output28,', '); 
                                       $cart['size']=trim($output29,', '); 

                                       $custom=json_decode($info1->customization);
                                       $output6=array();
                                       
                                       if(!empty($custom->veg)){
                                        foreach($custom->veg as $info4){
                                           $output6[]=$info4;
                                        }
                                    }
                                    if(!empty($custom->nonveg)){
                                        foreach($custom->nonveg as $info4){
                                            $output6[]=$info4;
                                        }
                                    }if(!empty($custom->flavor)){
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
                                     if(!empty($output6)){
                                    $output7=implode(',',$output6);
                                     }else{
                                         $output7='';
                                     }
                                     $output7=trim($output7,', ');
                                    $cart['customization']='';
                                    $cart['customization']=$output7;
                                    
                                        $cart['quantity']=(int)$info1->quantity;
                                        $cart['price']=$info1->price;
                                        //$cart['item_size']=$info1->item_size;
                                        $cart['item_price']='';
                                        $cart['item_price']=$info1->item_price;
                                        $cart['item_size']='';
                                        if($info1->item_size!=1){
                                            $cart['item_size']=$info1->item_size;
                                        }
                                        $cart['base']=$info1->base;
                                        $cart_price=$cart_price+$info1->price;
                                        $i++;
                                        $where=array('sk_id'=>$cart['item_id'],'item_onboarding_status'=>1);
                                        $item_details=$this->cm->getrecords($where,'mlt_items_onboarding');
                                        if($item_details!=false){
                                            foreach($item_details as $info){
                                                $temp6=array();
                                            $cart['section_name']=$cart['category_id']=$cart['type']=$cart['item_name']=$cart['display_name']=$cart['short_description']=$cart['description']=$cart['seo_title']=$cart['seo_description']=$cart['image']='NULL';
                                                $cart['section_name']=$info->section_name;
                                                $cart['category_id']=$info->category_id;
                                                $cart['type']=$info->type;

                                                $cart['item_name']=$info->item_name;
                                                $cart['display_name']=$info->display_name;
                                                $cart['description']=$info->short_description;
                                                $cart['short_description']=$info->description;
                                                $cart['image']=admin_img_url.'/items/'.$info->image;
                                                $cart['item_onboarding_status']=$info->item_onboarding_status;
                                               
                                            } 
                                        }
                                        $temp[]=$cart;
                                    }
                                    if($count==6 || $count1== 4||$cart_price>=6000){
                                    $cart1['order_type']='bigorder';  
                                    }else{
                                        $cart1['order_type']='normal';  

                                    }
                                    $cart1['total_amt']=$cart_price;
                                    $cart1['no_of_items']=$i;;
                                    $cart1['cart_details']=$temp;
                                    $ret=$this->common->response(200,true,'Cart Details',$cart1);
                                }else{
                                $ret=$this->common->response(400,false,'No Data Available',array());
                                }
                        }else if($this->input->server('REQUEST_METHOD') === 'POST'){
                            $params = array();
                            $price=$cart_id=$user_id=$item_id=$quantity=$price=$customization=$base=$item_price=$cstatus="";
                            $item_size='';
                            $params = json_decode(@file_get_contents('php://input'),TRUE);
                            if(isset($params)) { 
                                if(isset($params['item_id'])) { $item_id = $params['item_id'];} 
                                if(isset($params['quantity'])) { $quantity = $params['quantity'];} 
                                if(isset($params['customization'])) {  $customization = $params['customization'];} 
                                if(isset($params['item_size'])) {  $item_size = $params['item_size'];}
                                if(isset($params['party_time'])) {  $party_time = $params['party_time'];} 
                                if(isset($params['base'])) {  $base = $params['base'];} 
                                //var_dump($base);exit;
                               
                                $base1='';
                                if(isset($params['item_price'])) {  $item_price = $params['item_price'];} 
                                if($customization!=''){
                                    if(isset($customization['veg'])) { $veg = $customization['veg'];} 
                                    if(isset($customization['nonveg'])) {     $nonveg = $customization['nonveg'];} 
                                    if(isset($customization['flavor'])) {   $flavor = $customization['flavor'];} 
                                    if(isset($customization['base1'])) {   $base1 = $customization['base1'];} 
                                    if(isset($customization['size'])) {    $size1 = $customization['size'];} 
                                }
                                
                                $price=(int)$item_price*(int)$quantity;
                                $tmp2=array();
                                 $tmp3['item_id'] =$item_id;
                                 $tmp3['veg']=$tmp3['nonveg']=$tmp3['base']=$tmp3['size']=$tmp3['flavor']=array();
                                if($veg!=''){
                                    $tmp=explode(",",$veg);
                                    if(!empty($tmp)){
                                        for($i=0;$i<sizeof($tmp);$i++){
                                            $tmp21[]=trim($tmp[$i]);
                                        }
                                        $tmp3['veg']=$tmp21;
                                    }
                                }
                                    if($nonveg!=''){
                                        $tmp=explode(",",$nonveg);
                                        if(!empty($tmp)){
                                            for($i=0;$i<sizeof($tmp);$i++){
                                                $tmp22[]=trim($tmp[$i]);
                                            }
                                             $tmp3['nonveg']=$tmp22;
                                        }
                                    }
                                    
                                    if($flavor!=''){
                                        $tmp=explode(",",$flavor);
                                        if(!empty($tmp)){
                                            for($i=0;$i<sizeof($tmp);$i++){
                                                $tmp23[]=trim($tmp[$i]);
                                            } 
                                            $tmp3['flavor']=$tmp23;
                                        }
                                    }
                                    if($base1!=''){
                                        $tmp24[]=trim($base1);
                                            $tmp3['base']=$tmp24;
                                        }

                                    if($size1!=''){
                                        $tmp25[]=trim($size1);
                                            $tmp3['size']=$tmp25;
                                        }
                                        $tmp10=json_encode($tmp3);
                                        if($item_size==''){
                                            $item_size=1;
                                        }  
                                
                                $where=array('cuser_id'=>$id,'citem_id'=>$item_id,'item_size'=>$item_size,'party_time'=>$party_time);

                                $cart_details=$this->cm->getRecords($where,'mlt_cart');
                                    if($cart_details!=false){

                                
                                    if($veg==false && $nonveg==false && $flavor==false && $size1==false && $base==false){
                                        $saveData = array(
                                            'citem_id'=>$item_id,
                                            'cuser_id'=>$id,
                                            'quantity'=>$quantity,
                                            'price'=>$price,
                                            'party_time'=>$party_time,
                                            //'customization'=>$tmp10,
                                            'item_size'=>$item_size,
                                            'base'=>$base,
                                            'item_price'=>$item_price, 
                                            'cstatus'=>'1'         
                                    );
                                }else{
                                   $size=trim($size1);
                                    $saveData = array(
                                        'quantity'=>$quantity,
                                        'cuser_id'=>$id,

                                        'price'=>$price,
                                        'party_time'=>$party_time,
                                        'customization'=>$tmp10,
                                        'item_size'=>$size,
                                        'base'=>$base,
                                        'item_price'=>$item_price, 
                                        'cstatus'=>1         
                                );
                            }

                                $where=array('cuser_id'=>$id,'citem_id'=>$item_id,'item_size'=>$item_size,'party_time'=>$party_time);
                                    $cart_id = $this->cm->updateRecords($saveData,$where,'mlt_cart'); 
                                    $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                                    $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                                    $cart_price=$i=0;

                                    if($cart_count_details!=false){
                                        foreach($cart_count_details as $info10){
                                            $cart_price=$cart_price+$info10->price;
                                            $i++;
                                        }
                                    }
                                        $cart_data=array(
                                            'items'=>$i,
                                            'price'=>$cart_price,
                                            'accesstoken'=>JWT::encode($id,pkey)
                                        );  
                            
                                    $ret=$this->common->response(200,true,'Cart Updated Success',$cart_data);

                                }else{
                                        $saveData = array(
                                            'citem_id'=>$item_id,
                                            'cuser_id'=>$id,
                                            'quantity'=>$quantity,
                                            'price'=>$price,
                                            'party_time'=>$party_time,
                                            'customization'=>$tmp10,
                                            'item_size'=>$item_size,
                                            'base'=>$base,
                                            'item_price'=>$item_price, 
                                            'cstatus'=>'1'         
                                    );
                                 $cart_id = $this->cm->save($saveData,'mlt_cart');
                                $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                                    $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                                    if($cart_count_details!=false){
                                        foreach($cart_count_details as $info10){
                                            if($quantity!=$info10->quantity){
                                                $where=array('quantity'=>$info10->quantity,'cuser_id'=>$id,'citem_id'=>$item_id,'item_size'=>$item_size,'party_time'=>$party_time);
                                                $this->cm->deleteRecords($where,'mlt_cart');
                                            }
                                        }
                                    }
                                    $cart_price=$i=0;

                                    if($cart_count_details){
                                        foreach($cart_count_details as $info10){
                                            $cart_price=$cart_price+$info10->price;
                                            $i++;
                                        }
                                     } 
                                     $cart_data=array(
                                        'items'=>$i,
                                        'price'=>$cart_price,
                                        'accesstoken'=>JWT::encode($id,pkey)
                                    );
                                    $ret=$this->common->response(200,true,'Cart insert Successfull',$cart_data);                                                  
                            }
                            
                            }
                            else {
                                $ret=$this->common->response(200,false,'Please check the input',$data);
                            }
                        
        
                    }elseif ($this->input->server('REQUEST_METHOD') == 'PUT')
                        {
                        $params = array();
                        $params = json_decode(@file_get_contents('php://input'),TRUE);
                        if(isset($params))
                        if(isset($params['sk_cart_id'])) {  $cart_id = $params['sk_cart_id'];} 
                        if(isset($params['party_time'])) {  $party_time = $params['party_time'];} 
                        $cart_price=$i=0;
                        $cart_data=array(
                            'items'=>$i,
                            'price'=>$cart_price,
                            'accesstoken'=>JWT::encode($id,pkey)
                        );
                        try {
                            $where=array('sk_cart_id'=>$cart_id,'party_time'=>$party_time);  
                            $response = $this->cm->deleteRecords($where,'mlt_cart');
                            $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                            $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                            $cart_price=$i=0;
                            $cart_data=array(
                                'items'=>$i,
                                'price'=>$cart_price,
                                'accesstoken'=>JWT::encode($id,pkey)
                            );

                            if($cart_count_details!=false){
                                foreach($cart_count_details as $info10){
                                    $cart_price=$cart_price+$info10->price;
                                    $i++;
                                }
                             } 
                             $cart_data=array(
                                'items'=>$i,
                                'price'=>$cart_price,
                                'accesstoken'=>JWT::encode($id,pkey)
                            );
                       
                            $ret=$this->common->response(200,true,'Your Cart Details Deleted Successfully',$cart_data);
                        }

                        catch(Exception $e){
                            $msg = "";
                            $eMessage = $e->getMessage();
                            $eMessage = explode('/',$eMessage);
                            $eMessage = explode(':',$eMessage[0]);
                            if($eMessage[1]==1062) {
                                $msg = "Duplicate Entry";
                            }
                            else if($eMessage[1]==1452) {
                                $msg = "Foreign key constraint fails";
                            }
                            else  {
                                $msg = "Database error";
                            }
                            $ret=$this->common->response(400,true,$msg,array());
                        }
                    }
                else
                {
                    $ret=$this->common->response(400,false,'Please check the input',$data);
                }
            }else{
                $ret=$this->common->response(400,false,'User Not Existed',$data);

            }
        
             
            }else if($access_token==globalAccessToken){
                   
                        if ($this->input->server('REQUEST_METHOD') === 'GET')
                        {
                            if($temp_user_id==''){
                                $cart1['total_amt']=0;
                                    $cart1['no_of_items']=0;
                                    $cart1['cart_details']=array();
                            $ret=$this->common->response(200,true,'Here is empty cart',$cart1);
                        }else{
                            $id=JWT::decode($temp_user_id,pkey);


                            $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                            $cart_details=$this->cm->getRecords20($where,'mlt_cart');
                            $price=0;
                            $item_size=$item_size1=array();
                            if($cart_details){
                                foreach($cart_details as $info){ 
                                        $item_id=$info->citem_id;
                                        $where=array('sk_id'=>$item_id);
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
                                        }
                            }
                            $count=count($item_size);
                         $count1=count($item_size1);
                          




                            
                            $where=array('cstatus'=>1,'cuser_id'=>$id,'party_time'=>$party_time);
                                $cart_details=$this->cm->getRecords($where,'mlt_cart'); 
                                if($cart_details)
                                {
                                    $cart_price=$i=0;
                                    foreach($cart_details as $info1)
                                    
                                    {  
                                        $cart['cuser_id']= $cart['item_id']=$cart['quantity']=$cart['price']=$cart['item_size']=$cart['base']=$cart['item_price']=NULL;
                                        $cart['veg']='';
                                       $cart['non_veg']='';
                                       $cart['flavour']='';
                                       $cart['base1']=''; 
                                       $cart['size']=''; 
                                        $cart['sk_cart_id']=$info1->sk_cart_id;
                                        $cart['cuser_id']=$info1->cuser_id;
                                        $cart['item_id']=$info1->citem_id;
                                        $custom=json_decode($info1->customization);
                                        $output4=array();$output7=$output8=$output9=$output10=$output98=array();
                                        if($custom->veg){
                                            foreach($custom->veg as $info11){
                                               $output4[]=$info11;
                                               $output98[]=$info11;
                                            }
                                        }
                                        if($custom->nonveg){
                                            foreach($custom->nonveg as $info12){
                                                $output7[]=$info12;
                                                $output98[]=$info12;
                                            }
                                        }if($custom->flavor){
                                            foreach($custom->flavor as $info13){
                                                $output8[]=$info13;
                                            }
                                        }if($custom->base){
                                            foreach($custom->base as $info14){
                                                $output9[]=$info14;
                                            }
                                        }if($custom->size){
                                            foreach($custom->size as $info15){
                                                $output10[]=$info15;
                                            }
                                        }
                                        $output30='';
                                        $output25=implode(',',$output4);
                                        $output30=implode(',',$output98);
                                        $output26=implode(',',$output7);
                                        $output27=implode(',',$output8);
                                        $output28=implode(',',$output9);
                                        $output29=implode(',',$output10);
                                       $cart['veg']=trim($output25,', ');
                                       $cart['selected_total']='';
                                       $cart['selected_total']=$output30;
                                       $cart['non_veg']=trim($output26,', ');
                                       $cart['flavour']=trim($output27,', ');
                                       $cart['base1']=trim($output28,', '); 
                                       $cart['size']=trim($output29,', '); 

                                       $custom=json_decode($info1->customization);
                                       $output6=array();
                                       
                                       if(!empty($custom->veg)){
                                        foreach($custom->veg as $info4){
                                           $output6[]=$info4;
                                        }
                                    }
                                    if(!empty($custom->nonveg)){
                                        foreach($custom->nonveg as $info4){
                                            $output6[]=$info4;
                                        }
                                    }if(!empty($custom->flavor)){
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
                                     if(!empty($output6)){
                                    $output7=implode(',',$output6);
                                     }else{
                                         $output7='';
                                     }
                                     $output7=trim($output7,', ');
                                    $cart['customization']='';
                                    $cart['customization']=$output7;
                                    
                                       $cart['quantity']=(int)$info1->quantity;
                                       $cart['price']=$info1->price;
                                       $cart['item_size']='';
                                       if($info1->item_size!=1){
                                        $cart['item_size']=$info1->item_size;
                                       }
                                        $cart['base']=$info1->base;
                                        $cart['item_price']=$info1->item_price;
                                        $cart_price=$cart_price+$info1->price;
                                        $i++;
                                        $where=array('sk_id'=>$cart['item_id'],'item_onboarding_status'=>1);
                                        $item_details=$this->cm->getrecords($where,'mlt_items_onboarding');
                                        if($item_details!=false){
                                            foreach($item_details as $info){
                                                $cart['section_name']=$cart['category_id']=$cart['type']=$cart['item_name']=$cart['display_name']=$cart['short_description']=$cart['description']=$cart['seo_title']=$cart['seo_description']=$cart['image']='NULL';
                                                $cart['section_name']=$info->section_name;
                                                $cart['category_id']=$info->category_id;
                                                $cart['type']=$info->type;
                                                $cart['item_name']=$info->item_name;
                                                $cart['display_name']=$info->display_name;
                                                $cart['description']=$info->short_description;
                                                $cart['short_description']=$info->description;
                                                $cart['image']=admin_img_url.'/items/'.$info->image;
                                                $cart['item_onboarding_status']=$info->item_onboarding_status;
                                            } 
                                        }
                                        $temp[]=$cart;
                                    }
                                    if($count==6 || $count1== 4||$cart_price>=6000){
                                        $cart1['order_type']='bigorder';  
                                        }else{
                                            $cart1['order_type']='normal';  
    
                                        }
                                                                           $cart1['total_amt']=$cart_price;
                                    $cart1['no_of_items']=$i;;
                                    $cart1['cart_details']=$temp;
                                    $ret=$this->common->response(200,true,'Cart Details',$cart1);
                                }else{
                                $ret=$this->common->response(400,false,'No Data Available',array());
                                }
                            }
                        }else if($this->input->server('REQUEST_METHOD') === 'POST'){
                            $params = array();
                            $price=$user_temp_id=$cart_id=$user_id=$item_id=$quantity=$price=$customization=$item_size=$base=$item_price=$cstatus="";
                            $params = json_decode(@file_get_contents('php://input'),TRUE);
                            if(isset($params)) {
                                if(isset($params['item_id'])) { $item_id = $params['item_id'];} 
                                if(isset($params['quantity'])) {  $quantity = $params['quantity'];} 
                                if(isset($params['party_time'])) { $party_time = $params['party_time'];} 
                                if(isset($params['customization'])) {  $customization = $params['customization'];} 
                                if(isset($params['item_size'])) {  $item_size = $params['item_size'];} 
                                if(isset($params['base'])) {  $base = $params['base'];} 
                                if(isset($params['item_price'])) {  $item_price = $params['item_price'];} 
                                $price=(int)$item_price*(int)$quantity;
                                if($temp_user_id==''){
                                     $user_temp_id=$this->createTempSession();
                                }
                                else{
                                    $user_temp_id=JWT::decode($temp_user_id,pkey);
                                }
                                $base1=$size1='';
                               
                                // if(isset($params['item_price'])) {  $item_price = $params['item_price'];} 
                                if($customization!=''){
                                    if(isset($customization['veg'])) { $veg = $customization['veg'];} 
                                    if(isset($customization['nonveg'])) {     $nonveg = $customization['nonveg'];} 
                                    if(isset($customization['flavor'])) {   $flavor = $customization['flavor'];} 
                                    if(isset($customization['base1'])) {   $base1 = $customization['base1'];} 
                                    if(isset($customization['size'])) {    $size1 = $customization['size'];} 
                                }
                                
                                
                                $tmp2=array();
                                $price=(int)$item_price*(int)$quantity;
                                $tmp2=array();
                                 $tmp3['item_id'] =$item_id;
                                 $tmp3['veg']=$tmp3['nonveg']=$tmp3['base']=$tmp3['size']=$tmp3['flavor']=array();
                                if($veg!=''){
                                    $tmp=explode(",",$veg);
                                    if(!empty($tmp)){
                                        for($i=0;$i<sizeof($tmp);$i++){
                                            $tmp21[]=trim($tmp[$i]);
                                        }
                                        $tmp3['veg']=$tmp21;
                                    }
                                }
                                    if($nonveg!=''){
                                        $tmp=explode(",",$nonveg);
                                        if(!empty($tmp)){
                                            for($i=0;$i<sizeof($tmp);$i++){
                                                $tmp22[]=trim($tmp[$i]);
                                            }
                                             $tmp3['nonveg']=$tmp22;
                                        }
                                    }
                                    
                                    if($flavor!=''){
                                        $tmp=explode(",",$flavor);
                                        if(!empty($tmp)){
                                            for($i=0;$i<sizeof($tmp);$i++){
                                                $tmp23[]=trim($tmp[$i]);
                                            } 
                                            $tmp3['flavor']=$tmp23;
                                        }
                                    }
                                    if($base1!=''){
                                        $tmp24[]=trim($base1);
                                            $tmp3['base']=$tmp24;
                                        }

                                    if($size1!=''){
                                        $tmp25[]=trim($size1);
                                            $tmp3['size']=$tmp25;
                                        }
                                        $tmp10=json_encode($tmp3);
                                        if($item_size==''){
                                            $item_size=1;
                                        }   
                                      
                                $where=array('cuser_id'=>$user_temp_id,'citem_id'=>$item_id,'item_size'=>$item_size,'party_time'=>$party_time);

                                $cart_details=$this->cm->getRecords($where,'mlt_cart');
                               // var_dump($where);
                              
                               if($quantity!=0){
                                if($cart_details!=false){

                                
                                    if($veg==false && $nonveg==false && $flavor==false && $size1==false && $base==false){
                                        $saveData = array(
                                            'citem_id'=>$item_id,
                                            'cuser_id'=>$user_temp_id,
                                            'quantity'=>$quantity,
                                            'price'=>$price,
                                            'party_time'=>$party_time,
                                            //'customization'=>$tmp10,
                                            'item_size'=>$item_size,
                                            'base'=>$base,
                                            'item_price'=>$item_price, 
                                            'cstatus'=>'1'         
                                    );
                                }else{
                                   $size=trim($size1);
                                    $saveData = array(
                                        'quantity'=>$quantity,
                                        'cuser_id'=>$user_temp_id,

                                        'price'=>$price,
                                        'party_time'=>$party_time,
                                        'customization'=>$tmp10,
                                        'item_size'=>$size,
                                        'base'=>$base,
                                        'item_price'=>$item_price, 
                                        'cstatus'=>1         
                                );
                            }

                                $where=array('cuser_id'=>$user_temp_id,'citem_id'=>$item_id,'item_size'=>$item_size,'party_time'=>$party_time);
                                    $cart_id = $this->cm->updateRecords($saveData,$where,'mlt_cart'); 
                                    $where=array('cuser_id'=>$user_temp_id,'party_time'=>$party_time);
                                    $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                                    $cart_price=$i=0;

                                    if($cart_count_details!=false){
                                        foreach($cart_count_details as $info10){
                                            $cart_price=$cart_price+$info10->price;
                                            $i++;
                                        }
                                    }
                                        $cart_data=array(
                                            'items'=>$i,
                                            'price'=>$cart_price,
                                            'accesstoken'=>JWT::encode($user_temp_id,pkey)
                                        );  
                            
                                    $ret=$this->common->response(200,true,'Cart Updated Success',$cart_data);

                                }else{
                                        $saveData = array(
                                            'citem_id'=>$item_id,
                                            'cuser_id'=>$user_temp_id,
                                            'quantity'=>$quantity,
                                            'price'=>$price,
                                            'party_time'=>$party_time,
                                            'customization'=>$tmp10,
                                            'item_size'=>$item_size,
                                            'base'=>$base,
                                            'item_price'=>$item_price, 
                                            'cstatus'=>'1'         
                                    );
                                 $cart_id = $this->cm->save($saveData,'mlt_cart');
                                $where=array('cuser_id'=>$user_temp_id,'party_time'=>$party_time);
                                    $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                                    if($cart_count_details!=false){
                                        foreach($cart_count_details as $info10){
                                            if($quantity!=$info10->quantity){
                                                $where=array('quantity'=>$info10->quantity,'cuser_id'=>$user_temp_id,'citem_id'=>$item_id,'item_size'=>$item_size,'party_time'=>$party_time);
                                                $this->cm->deleteRecords($where,'mlt_cart');
                                            }
                                        }
                                    }
                                    $cart_price=$i=0;

                                    if($cart_count_details){
                                        foreach($cart_count_details as $info10){
                                            $cart_price=$cart_price+$info10->price;
                                            $i++;
                                        }
                                     } 
                                     $cart_data=array(
                                        'items'=>$i,
                                        'price'=>$cart_price,
                                        'accesstoken'=>JWT::encode($user_temp_id,pkey)
                                    );
                                    $ret=$this->common->response(200,true,'Cart insert Successfull',$cart_data);                                                  
                            }

                            }
                            else {
                                $ret=$this->common->response(400,false,'Please check the input',$data);
                            }
                            }
        
                    }elseif ($this->input->server('REQUEST_METHOD') == 'PUT')
                        {
                            $id=JWT::decode($temp_user_id,pkey);

                        $params = array();
                        $params = json_decode(@file_get_contents('php://input'),TRUE);
                        if(isset($params))
                        if(isset($params['sk_cart_id'])) {  $cart_id = $params['sk_cart_id'];} 
                        if(isset($params['party_time'])) {  $party_time = $params['party_time'];} 
                        $cart_price=$i=0;
                        $cart_data=array(
                            'items'=>$i,
                            'price'=>$cart_price,
                            'accesstoken'=>JWT::encode($id,pkey)
                        );
                        try {
                            $where=array('sk_cart_id'=>$cart_id);  
                            $response = $this->cm->deleteRecords($where,'mlt_cart');
                            $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                            $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                            if($cart_count_details){
                                foreach($cart_count_details as $info10){
                                    $cart_price=$cart_price+$info10->price;
                                    $i++;
                                }
                             } 
                             
                       
                            
                            $ret=$this->common->response(200,true,'Your Cart Details Deleted Successfully',$cart_data);
                        }

                        catch(Exception $e){
                            $msg = "";
                            $eMessage = $e->getMessage();
                            $eMessage = explode('/',$eMessage);
                            $eMessage = explode(':',$eMessage[0]);
                            if($eMessage[1]==1062) {
                                $msg = "Duplicate Entry";
                            }
                            else if($eMessage[1]==1452) {
                                $msg = "Foreign key constraint fails";
                            }
                            else  {
                                $msg = "Database error";
                            }
                            $ret=$this->common->response(400,true,$msg,array());
                        }
              
                }
                else
                {
                    $ret=$this->common->response(400,false,'Please check the input',$data);
                }   
            }else{
                $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
        }
    
        echo json_encode($ret);
    
    }

/*****************end on cart***********/
/*****************api on coupon*****************/
public function coupons(){
    $this->access_control();
    $commonData=$this->common_data();
    $access_token = false;
    $row=$this->input->request_headers();
    if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
    $data=array();$ret=array();$coupon=array();
    if($access_token)
    {
        try{ 
                if ($this->input->server('REQUEST_METHOD') === 'GET')
                {

                    $coupon_status=$coupon_id='';
                    if(isset($row['sk_coupon_id']))
                    {
                        
                        if($row['sk_coupon_id']=="All")
                        {
                            $coupon_id ="All";
                        }
                        else{
                            $coupon_id = $row['sk_coupon_id'];
                        }
                    }
                    if(isset($row['coupon_status']))
                    {
                        if($row['coupon_status']=="All")
                        {
                            $coupon_status ="All";
                        }
                        else
                        {
                            $coupon_status = $row['coupon_status'];
                        }
                    }
                    if($coupon_id=="All")
                    {
                        if($coupon_status=="All")
                        {
                            $where=array();
                        }
                        else
                        {
                            $where=array('coupon_status'=>$coupon_status,'user_id'=>'');
                        }

                    }
                    else
                    {
                        if($coupon_status=="All"){$where=array('sk_coupon_id'=>$coupon_id);}
                        else{$where=array('sk_coupon_id'=>$coupon_id,'coupon_status'=>$coupon_status);}
                    }
                    if($access_token!=globalAccessToken){
                    $id=JWT::decode($access_token,pkey);
                    $where1=array('sk_user_id'=>$id);
                    $user_details=$this->cm->getRecords($where1,'mst_user');
                    if($user_details!=false){
                        $id=$user_details[0]->sk_user_id;
                    }
                }else{

                    $id='';
                }
                    $coupon_details=$this->cm->getRecords($where,'mst_coupons'); 
                    if($coupon_details!=false)
                    {

                        foreach($coupon_details as $row)
                        {  
                            $coupon['coupon_code']=$coupon['description']=$coupon['coupon_type']=$coupon['coupon_price']=$coupon['expiry_date']=$coupon['limit_per_coupon']=$coupon['limit_per_user']='NULL';
                            $coupon_id=$row->sk_coupon_id;

                            $where=array('coupon_id'=>$coupon_id,'user_id'=>$id);
                            $applied_coupons=$this->cm->getRecords($where,'txn_coupons');
                             $coupon['apply_status']=false;
                            if($applied_coupons!=false){
                                $coupon['apply_status']=true;
 
                            }
                            $coupon['sk_coupon_id']=$row->sk_coupon_id;
                            $coupon['coupon_code']=$row->coupon_code;
                            $coupon['description']=$row->description;
                            $coupon['coupon_type']=$row->coupon_type;
                            $coupon['coupon_price']=$row->coupon_price;
                            $coupon['expiry_date']=$row->expiry_date;
                            $coupon['limit_per_coupon']=$row->limit_per_coupon;
                            $coupon['limit_per_user']=$row->limit_per_user;
                            $temp[]=$coupon;
                        }

                        $where=array('coupon_status'=>1,'user_id'=>$id);
                        $coupon_details=$this->cm->getRecords($where,'mst_coupons'); 
                        if($coupon_details!=false)
                        {
                            foreach($coupon_details as $row)
                            {  
                                $coupon['coupon_code']=$coupon['description']=$coupon['coupon_type']=$coupon['coupon_price']=$coupon['expiry_date']=$coupon['limit_per_coupon']=$coupon['limit_per_user']='NULL';
                                $coupon_id=$row->sk_coupon_id;
    
                                $where=array('coupon_id'=>$coupon_id,'user_id'=>$id);
                                $applied_coupons=$this->cm->getRecords($where,'txn_coupons');
                                 $coupon['apply_status']=false;
                                if($applied_coupons!=false){
                                    $coupon['apply_status']=true;
     
                                }
                                $coupon['sk_coupon_id']=$row->sk_coupon_id;
                                $coupon['coupon_code']=$row->coupon_code;
                                $coupon['description']=$row->description;
                                $coupon['coupon_type']=$row->coupon_type;
                                $coupon['coupon_price']=$row->coupon_price;
                                $coupon['expiry_date']=$row->expiry_date;
                                $coupon['limit_per_coupon']=$row->limit_per_coupon;
                                $coupon['limit_per_user']=$row->limit_per_user;
                                $temp[]=$coupon;
                            }       
                        }                
                            
                            $coupon1['coupon_details']=$temp;
                        $ret=$this->common->response(200,true,'Coupon Details',$coupon1);
                }
                else{
                    $ret=$this->common->response(200,false,'No Data Available',array());
                }
            }else if($this->input->server('REQUEST_METHOD') === 'POST'){
                $params = array();
                $id=JWT::decode($access_token,pkey);
                $coupon_id=$start_date=$end_date=$coupon_code=$discount=$coupon_status=$sub_total="";
                $params = json_decode(@file_get_contents('php://input'),TRUE);
                if(isset($params)) { 
                    if(isset($params['coupon_id'])) { $coupon_id = $params['coupon_id'];} 
                    if(isset($params['sub_total'])) { $sub_total = $params['sub_total'];} 
                    if(isset($params['coupon_code'])) { $coupon_code = $params['coupon_code'];} 
                   if($coupon_code!=''){
                    $where=array('coupon_code'=>$coupon_code);
                    $getcoupondetailscode=$this->cm->getRecords($where,'mst_coupons');
                    if($getcoupondetailscode!=false){
                        foreach($getcoupondetailscode as $row){
                            $coupon_code=$coupon['description']=$coupon['coupon_type']=$coupon['coupon_price']=$coupon['expiry_date']=$coupon['limit_per_coupon']=$coupon['limit_per_user']='NULL';
                            $sk_coupon_id=$row->sk_coupon_id;
                            $coupon['coupon_code']=$row->coupon_code;
                            $coupon['description']=$row->description;
                            $coupon['coupon_type']=$row->coupon_type;
                            $coupon['coupon_price']=$row->coupon_price;
                            $coupon['expiry_date']=$row->expiry_date;
                            $coupon['limit_per_coupon']=$row->limit_per_coupon;
                            $coupon['limit_per_user']=$row->limit_per_user;
                        }
                        $saveData = array(
                            'coupon_id'=>$sk_coupon_id, 
                            'user_id'=>$id,
                            'txn_coupon_status'=>'0'    
                        );
                        $id=$this->cm->save($saveData,'txn_coupons'); 
                        if($id!=0){
                        $where=array('sk_coupon_id'=>$sk_coupon_id);
                    $coupons_details=$this->cm->getRecords($where,'mst_coupons');
                    if($coupons_details!=false){
                        foreach($coupons_details as $info){
                            $coupon['sk_coupon_id']=$info->sk_coupon_id;
                            $coupon['coupon_code']=$info->coupon_code;
                            $coupon['description']=$info->description;
                            $coupon['coupon_type'] = $info->coupon_type;
                            $coupon['coupon_price']=$info->coupon_price;
                            $coupon['shipping_status']=$info->shipping_status;
                            $coupon['expiry_date']=$info->expiry_date;
                            $coupon['limit_per_coupon']=$info->limit_per_coupon;
                            $coupon['limit_per_user']=$info->limit_per_user;
                        }
                        $coupons[]=$coupon;
                    }
                    if($sub_total<$coupon['coupon_price']){
                        $ret=$this->common->response(200,false,'OOPs! This Coupon is only applicable on orders above Rs.'.$coupon['coupon_price'],array()); 
                    }else{
                    $ret=$this->common->response(200,true,'Coupon Saved Successfully',$coupons);
                    }
                }                   
                    }
                    else{
                        $ret=$this->common->response(200,false,"OOps This coupon code doesn't exist. Apply Other Coupon ",array());
     
                    }
                   }else if($coupon_id!=''){
                   $where=array('user_id'=>$id,'txn_coupon_status'=>'0');

                   $getcoupondetails=$this->cm->getRecords($where,'txn_coupons');
                   if($getcoupondetails==false){
                    $saveData = array(
                        'coupon_id'=>$coupon_id, 
                        'user_id'=>$id,
                        'txn_coupon_status'=>'0'    
                    );

                   $this->cm->save($saveData,'txn_coupons'); 
                    
                }else{
                    $saveData = array(
                        'coupon_id'=>$coupon_id, 
                        'user_id'=>$id,
                        'txn_coupon_status'=>'0'    
                    );
                    $where=array('user_id'=>$id);
                   $this->cm->updateRecords($saveData,$where,'txn_coupons'); 
                }
            
                $where=array('sk_coupon_id'=>$coupon_id);
                $coupons_details=$this->cm->getRecords($where,'mst_coupons');
                if($coupons_details!=false){
                    foreach($coupons_details as $info){
                        $coupon['sk_coupon_id']=$info->sk_coupon_id;
                        $coupon['coupon_code']=$info->coupon_code;
                        $coupon['description']=$info->description;
                        $coupon['coupon_type'] = $info->coupon_type;
                        $coupon['coupon_price']=$info->coupon_price;
                        $coupon['shipping_status']=$info->shipping_status;
                        $coupon['expiry_date']=$info->expiry_date;
                        $coupon['limit_per_coupon']=$info->limit_per_coupon;
                        $coupon['limit_per_user']=$info->limit_per_user;
                    }                   
                    $coupons[]=$coupon;
                    
                }
                if($sub_total<$coupon['coupon_price']){
                    $where=array('user_id'=>$id,'txn_coupon_status'=>'0');
                    $this->cm->deleteRecords($where,'txn_coupons');
                    $ret=$this->common->response(200,false,'OOPs! This Coupon is only applicable on orders above Rs.'.$coupon['coupon_price'],array()); 
                }else{
                $ret=$this->common->response(200,true,'Coupon Saved Successfully',$coupons);
                }
                }  
            }    
            else {
            $ret=$this->common->response(200,false,'Please check the input',$data);
            }
        }            
        else{
                    $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value',$data);
            }
    }
    catch (Exception $e) {
        $ret=$this->common->response(400, false, 'Invalid Access Token1', array());
    }
                
 }
    else{
        $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
    }
    echo json_encode($ret);
    }
    /*********************Api for Place Order******************************/
    public function place_order(){
        $user_name=$user_email=$user_moblie=$user_houseno=$user_address1=$user_city=$longitude=$latitude=$user_pin_number=$user_address=$total_order_quantity=$total_order_value=$coupon_id=$order_type=$payment_mode=$razor_payment_id=$order_delivery_date=$order_delivery_time='';
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        $params = array();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['temp_session_id'])) { $temp_session_id = $row['temp_session_id']; }
        if(isset($row['party_time'])) { $party_time = $row['party_time']; }
        if($party_time!=1){
            $party_time='no';
        }else{
            $party_time='yes';
        }
        $data=array();$ret=array();$order=array();$count=$count1=0;
        if($access_token!=globalAccessToken)
        {
                $userid=JWT::decode($access_token,pkey);				 
                $where=array('sk_user_id'=>$userid);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists){
                    $user_name1=$userExists[0]->full_name;
                    $mobile=$userExists[0]->mobile;
                    $email=$userExists[0]->email;
                    $rrr=$email;
                    $email='"'.$rrr.'"';
                    $rrr=$user_name;
                    $user_name='"'.$rrr.'"';
                    $rrr=$mobile;
                    $mobile='"'.$rrr.'"';
                    $rrr=$user_name1;
                    $user_name1='"'.$rrr.'"';

                    if($this->input->server('REQUEST_METHOD') === 'POST'){
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params)) { 
                        if(isset($params['guest_name'])) { $user_name = $params['guest_name'];} 
                        if(isset($params['guest_email'])) { $user_email = $params['guest_email'];} 
                        if(isset($params['guest_moblie'])) { $user_moblie = $params['guest_moblie'];} 
                        if(isset($params['guest_houseno'])) { $user_houseno = $params['guest_houseno'];} 
                        if(isset($params['guest_address'])) { $user_address1 = $params['guest_address'];}  
                        if(isset($params['guest_city'])) { $user_city = $params['guest_city'];} 
                        if(isset($params['longitude'])) { $longitude = $params['longitude'];} 
                        if(isset($params['latitude'])) { $latitude = $params['latitude'];} 
                        if(isset($params['guest_pin_number'])) { $user_pin_number = $params['guest_pin_number'];} 
                        if(isset($params['user_address_id'])) { $user_address = $params['user_address_id'];} 
                        if(isset($params['total_order_quantity'])) {  $total_order_quantity = $params['total_order_quantity'];} 
                        if(isset($params['total_order_value'])) {  $total_order_value = $params['total_order_value'];} 
                        if(isset($params['coupon_id'])) {  $coupon_id = $params['coupon_id'];} 
                        if(isset($params['order_type'])) {   $order_type = $params['order_type'];} 
                        if(isset($params['payment_mode'])) {  $payment_mode = $params['payment_mode'];} 
                        if(isset($params['razor_payment_id'])) {  $razor_payment_id = $params['razor_payment_id'];} 
                        if(isset($params['order_delivery_date'])) {  $order_delivery_date = $params['order_delivery_date'];}
                        if(isset($params['order_delivery_time'])) {  $order_delivery_time = $params['order_delivery_time'];} 
                        $order_delivery_time=explode('-',$order_delivery_time);
                        $order_delivery_time=$order_delivery_time[0];

                        date_default_timezone_set("Asia/Kolkata");
                        $discount_amount='';
           if($coupon_id!=''){
               $where=array('sk_coupon_id'=>$coupon_id);
              $coupons_details =$this->cm->getRecords($where,'mst_coupons');
              if($coupons_details!=false){
                  $discount_amount=$coupons_details[0]->coupon_price;
              }
              $where399 = array(
                'coupon_id'=>$coupon_id, 
                'user_id'=>$userid,
                'txn_coupon_status'=>'0'    
            );
            $data_array29=array('txn_coupon_status'=>'1');
            $this->cm->updateRecords($data_array29,$where399,'txn_coupons');
           }
           $id_dup='';
           if($user_address!=''){
            $where=array('sk_address_id'=>$user_address);
            $address_details20=$this->cm->getRecords($where,'mlt_address');
            if($address_details20!=false){
              foreach($address_details20 as $info66){
          $data_array=array(
           "user_id"=>$userid,
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
     $user_address=$id_dup;
     
           $real_time_details='';$slotId=$inputLevel="";$asap=false;
            $datetime = $order_delivery_date.' '.$order_delivery_time;
            $event_date=date('Y-m-d h:i:s', strtotime($datetime));
             $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
             $datetime1='"'.$datetime.'"';
             if($order_type==''){
                        $saveData = array(
                            'user_id'=>$userid,
                            'user_address'=>$user_address,
                            'ordered_date'=>date('Y-m-d'),
                            'ordered_time'=>date('h:i:s'),
                            'total_order_quantity'=>$total_order_quantity,
                            'total_order_value'=>$total_order_value,
                            'coupon_id'=>$coupon_id,
                            'party_time'=>$party_time,
                            'discount_amount'=>$discount_amount,
                            'payment_mode'=>$payment_mode,
                            'razor_payment_id'=>$razor_payment_id,
                            'order_delivery_date'=>$order_delivery_date,
                            'order_delivery_time'=>$order_delivery_time,
                            'order_status'=>'CREATED'
                             );
                    }else{
                        $saveData = array(
                            'user_id'=>$userid,
                            'user_address'=>$user_address,
                            'ordered_date'=>date('Y-m-d'),
                            'ordered_time'=>date('h-i-s'),
                            'total_order_quantity'=>$total_order_quantity,
                            'total_order_value'=>$total_order_value,
                            'coupon_id'=>$coupon_id,
                            'order_type'=>$order_type,
                            'party_time'=>$party_time,
                            'discount_amount'=>$discount_amount,
                            'payment_mode'=>$payment_mode,
                            'razor_payment_id'=>$razor_payment_id,
                            'order_delivery_date'=>$order_delivery_date,
                            'order_delivery_time'=>$order_delivery_time,
                            'order_status'=>'CREATED'
                             );
                    }

                    try {
                       $order_id = $this->cm->save($saveData,'mlt_order'); 
                       if($party_time=='yes'){
                        $order_date=array('order_id'=>$order_id,'temp_package_status'=>1);
                        $where34=array('user_id'=>$userid,'temp_package_status'=>0);
                        $this->cm->updateRecords($order_date,$where34,'mlt_user_packages');
                       

                       }
                        $notification=array(
                            "user_id"=>$userid,
                            "notifiaction_label"=>"Order Placed",
                            "notification_msg"=>"As per Your request,Order is placed",
                            "notification_date"=>date('Y-m-d')
                        );
                        $this->cm->save($notification,'txn_notifications');
                        if($order_id!="") 
                        {
                            $order_id1='"CBE'.$order_id.'"';

    $where=array('sk_address_id'=>$user_address);
    $address=$this->cm->getRecords($where,'mlt_address_dup');
    $output1=$lat=$lon='';
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
                     $lat=$info1->latitude;
                    $lon=$info1->longitude;
        }
         $output1=$address['house_no'].' '.$address['street'].' '.$address['area'].' '.$address['city'].' '.$address['state'].' '.$address['country'].' '.$address['pincode'];   

    }    

    if($order_delivery_date!=date("Y-m-d")){
        $real_time_details=$this->realtime_feasabilty_check_for_tomorow($datetime,$lat,$lon);
        $json_time=json_decode($real_time_details);  
        if($json_time!=''){
                $slotId= $json_time->slot_id;
                $inputLevel=$json_time->levele_id;
        }
      }  
    $rrr=$output1;
     $output1='"'.$rrr.'"';
    $lat_lon='"'.$lat.','.$lon.'"';
    
    $total_price='"'.$total_order_value.'"';
    $output2 = array();
    $where=array('cuser_id'=>$userid);
    $cart_orders=$this->cm->getrecords($where,'mlt_cart');
    if($cart_orders){
        $i=1;
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
            $temp10=$temp1=$temp2=array();
             $temp10["key"] = "productName";
            $temp10["value"] = $item_name;
            $innerData[]=$temp10;
            $temp1["key"] = "quantity";
            $temp1["value"] = $info->quantity;
            $innerData[]=$temp1;
            $temp2["key"] = "price";
            $temp2["value"] = $info->price;
            $innerData[]=$temp2;
            $field['sequence']=$i++;
            $temp3["key"] = "customisation";
            $temp3["value"] = $output7;
            $innerData[]=$temp3;
            $field['fields']=$innerData;
            $output2[]=$field;

        }
    }


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
    $input=json_encode($output2);
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
            "value": "309"
          },
          {
            "key": "customerName",
            "value": '."$user_name1".'
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
          {
            "key": "productSection",
            "repeatingSection": '.$input.'
          }
        ]}';
            
    $out = $output;
    $this->cm->save(array('msg'=>$output),'temp');
    if($party_time!='yes'){
        $login_access_token_header = array('Content-Type:application/json','CLIENT_ID:4540555161763840');
        $makecall = $this->common->callAPI('POST', "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/baseApi/v1/job/createJobFromEcom", $output, $login_access_token_header);
            
             $this->cm->save(array('msg'=>$makecall),'temp');
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
    
                        $where=array('cuser_id'=>$userid);

                        $cart_orders=$this->cm->getrecords($where,'mlt_cart');
          
                        if($party_time=='yes'){
                            $party_time1=1;

                        }else{
                       $party_time1=0;

                        }
                    $where=array('cuser_id'=>$userid,'party_time'=>$party_time1);
                    $this->cm->deleteRecords($where,'mlt_cart');
                    $data_order=array('order_id'=>$order_id);
                    $where=array('sk_address_id'=>$user_address);
                    $this->cm->updateRecords($data_order,$where,'mlt_address_dup');
                   $temp['order_id']=$order_id;
                   $temp['delivery_date_time']='';
                   if($party_time=='yes'){
                    $where299=array('order_id'=>$order_id,'temp_package_status'=>1);
                    $packages_details=$this->cm->getRecords($where299,'mlt_user_packages');
                    if($packages_details!=false){
                        foreach($packages_details as $info299){
                            $temp['delivery_date_time']=date('M d ', strtotime($info299->select_date)).date('H:i A',strtotime($info299->from_time)).' to '.date('H:i A',strtotime($info299->to_time));

                        }
                    }

                   }
                    $ret=$this->common->response(200,true,'Order Saved Successfully',$temp);
                    }
                        else {
                            $ret=$this->common->response(200,false,'Order Save Failure',array('order_id'=>0,'delivery_date_time'=>''));
                        }
                    }
                    catch(Exception $e) {

                        $msg = "";
                        $eMessage = $e->getMessage();
                        $eMessage = explode('/',$eMessage);
                        $eMessage = explode(':',$eMessage[0]);
                        if($eMessage[1]==1062) {
                            $msg = "Duplicate Entry";
                        }
                        else if($eMessage[1]==1452) {
                            $msg = "Foreign key constraint fails";
                        }
                        else  {
                            $msg = "Database error";
                        }
                        $ret=$this->common->response(400,false,$msg,array());
                    }
               
            }
            else {
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }
        }
        }else{
                $ret=$this->common->response(400,false,'There is no user existed',array());
        }
    }
        else if($access_token==globalAccessToken){
            if($temp_session_id!=''){
                $temp_session_id=JWT::decode($temp_session_id,pkey);
                $where=array('cuser_id'=>$temp_session_id);$count=$count1=0;
                $cart_details=$this->cm->getRecords($where,'mlt_cart');
                $price=0; $item_size1= $item_size=array();
                if($cart_details){
                    foreach($cart_details as $info){            
                         $item_id=$info->citem_id;
                        $where=array('sk_id'=>$item_id);
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
                        }
            }
            $count=count($item_size);
         $count1=count($item_size1);
          
                
                $params = json_decode(@file_get_contents('php://input'),TRUE);
                if(isset($params)) { 
                    if(isset($params['guest_name'])) { $user_name1 = $params['guest_name'];} 
                        if(isset($params['guest_email'])) { $user_email = $params['guest_email'];} 
                        if(isset($params['guest_moblie'])) { $user_moblie = $params['guest_moblie'];} 
                        if(isset($params['guest_houseno'])) { $user_houseno = $params['guest_houseno'];} 
                        if(isset($params['guest_address'])) { $user_address1 = $params['guest_address'];}  
                        if(isset($params['guest_city'])) { $user_city = $params['guest_city'];} 
                        if(isset($params['longitude'])) { $longitude = $params['longitude'];} 
                        if(isset($params['latitude'])) { $latitude = $params['latitude'];} 
                        if(isset($params['guest_pin_number'])) { $user_pin_number = $params['guest_pin_number'];} 
                        if(isset($params['user_address_id'])) { $user_address = $params['user_address_id'];} 
                        if(isset($params['total_order_quantity'])) {  $total_order_quantity = $params['total_order_quantity'];} 
                        if(isset($params['total_order_value'])) {  $total_order_value1 = $params['total_order_value'];} 
                        if(isset($params['coupon_id'])) {  $coupon_id = $params['coupon_id'];} 
                        if(isset($params['order_type'])) {   $order_type = $params['order_type'];} 
                        if(isset($params['payment_mode'])) {  $payment_mode = $params['payment_mode'];} 
                        if(isset($params['razor_payment_id'])) {  $razor_payment_id = $params['razor_payment_id'];} 
                        if(isset($params['order_delivery_date'])) {  $order_delivery_date = $params['order_delivery_date'];}
                        if(isset($params['order_delivery_time'])) {  $order_delivery_time = $params['order_delivery_time'];} 
                        $output1=$user_houseno.''.$user_address1.' '.$user_city.' '.$user_pin_number;   
                        $order_delivery_time=explode('-',$order_delivery_time);
                        $order_delivery_time=$order_delivery_time[0];
                        $this->cm->save(array('msg'=>$order_delivery_time),"temp");
                $rrr=$output1;
        $output1='"'.$rrr.'"';
        $lat_lon='"'.$latitude.','.$longitude.'"';
        $total_order_value='"'.$total_order_value1.'"';
        $user_name='"'.$user_name1.'"';
        $rrr=$user_moblie;
        $mobile='"'.$rrr.'"';
        $rrr=$user_email;
        $email='"'.$rrr.'"';
        date_default_timezone_set("Asia/Kolkata");
        $discount_amount='';
        if($coupon_id!=''){
            $where=array('sk_coupon_id'=>$coupon_id);
           $coupons_details =$this->cm->getRecords($where,'mst_coupons');
           if($coupons_details!=false){
               $discount_amount=$coupons_details[0]->coupon_price;
           }
           $where399 = array(
            'coupon_id'=>$coupon_id, 
            'user_id'=>$temp_session_id,
            'txn_coupon_status'=>'0'    
        );
        $data_array29=array('txn_coupon_status'=>'1');
        $this->cm->updateRecords($data_array29,$where399,'txn_coupons');
        }
        $datetime = $order_delivery_date.' '.$order_delivery_time;
        $event_date=date('Y-m-d h:i:s', strtotime($datetime));
         $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
         $datetime1='"'.$datetime.'"';
        
                  if($order_type=='normal'){              
                $saveData = array(
                    'user_id'=>$temp_session_id,
                    'user_name'=>$user_name1    ,
                    'user_email'=>$user_email,
                    'user_moblie'=>$user_moblie,
                    'user_houseno'=>$user_houseno,
                    'user_address1'=>$user_address1,
                    'user_city'=>$user_city,
                    'party_time'=>$party_time,
                    'user_pin_number'=>$user_pin_number,                    
                    'ordered_date'=>date('Y-m-d'),
                    'ordered_time'=>date('H:i:s A'),
                    'total_order_quantity'=>$total_order_quantity,
                    'total_order_value'=>$total_order_value1,
                    'coupon_id'=>$coupon_id,
                    'discount_amount'=>$discount_amount,
                    'payment_mode'=>$payment_mode,
                    'razor_payment_id'=>$razor_payment_id,
                    'order_delivery_date'=>$order_delivery_date,
                    'order_delivery_time'=>$order_delivery_time,
                    'order_status'=>'CREATED'
                     );
                }else{
                    $saveData = array(
                        'user_id'=>$temp_session_id,
                        'user_name'=>$user_name1,
                        'user_email'=>$user_email,
                        'user_moblie'=>$user_moblie,
                        'user_houseno'=>$user_houseno,
                        'user_address1'=>$user_address1,
                        'party_time'=>$party_time,
                        'user_city'=>$user_city,
                        'user_pin_number'=>$user_pin_number,                    
                        'ordered_date'=>date('Y-m-d'),
                        'ordered_time'=>date('H:i:s A'),
                        'total_order_quantity'=>$total_order_quantity,
                        'total_order_value'=>$total_order_value1,
                        'coupon_id'=>$coupon_id,
                        'order_type'=>$order_type,
                        'discount_amount'=>$discount_amount,
                        'payment_mode'=>$payment_mode,
                        'razor_payment_id'=>$razor_payment_id,
                        'order_delivery_date'=>$order_delivery_date,
                        'order_delivery_time'=>$order_delivery_time,
                        'order_status'=>'CREATED'
                         );    
                }
            try {
               $order_id = $this->cm->save($saveData,'mlt_order'); 
               $order_id1='"CBE'.$order_id.'"';
               $notification=array(
                   "user_d"=>$temp_session_id,
                "notifiaction_label"=>"Order Placed",
                "notification_msg"=>"As per Your request,Order is placed",
                "notification_date"=>date('Y-m-d')
            );
            $this->cm->save($notification,'txn_notifications');
                if($order_id!="") 
              {
                $where=array('cuser_id'=>$temp_session_id);

                $cart_orders=$this->cm->getrecords($where,'mlt_cart');
$slotId=$inputLevel='';
    if($order_delivery_date!=date("Y-m-d")){
        $real_time_details=$this->realtime_feasabilty_check_for_tomorow($datetime,$latitude,$longitude);
        $json_time=json_decode($real_time_details);
  
        if($json_time!=''){
                $slotId= $json_time->slot_id;
                $inputLevel=$json_time->levele_id;
        }
      }  
                $output2=array();      
    if($cart_orders!=false){$i=1;
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
    $temp10=$temp1=$temp2=array();
    $temp10["key"] = "productName";
    $temp10["value"] = $item_name;
    $innerData[]=$temp10;
    $temp1["key"] = "quantity";
    $temp1["value"] = $info->quantity;
    $innerData[]=$temp1;
    $temp2["key"] = "price";
    $temp2["value"] = $info->price;
    $innerData[]=$temp2;
    $field['sequence']=$i++;
    $temp3["key"] = "customisation";
    $temp3["value"] = $output7;
    
    $field['fields']=$innerData;
    $output2[]=$field;

}
}
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
$input=json_encode($output2);
$output='{"templateId": "6422919068516352",
"fields": [
  {
    "key": "jobCode",
    "value":'."$order_id1".'
  },
  {
    "key": "description",
    "value": '."$total_order_value".'
  },
  {
    "key": "expectedTime",
    "value": '.$datetime1.'
  },
  {
    "key": "totalAmount",
    "value": '."$total_order_value".'
  }, 
  {
    "key": "source",
    "value": "ECOMMERCE"
  },
  {
    "key": "collectableAmount",
    "value": "309"
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
  {
    "key": "productSection",
    "repeatingSection": '.$input.'
  }
]}';
    
// echo json_encode(array('output'=>$output));exit;
$out = $output;
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
            $where=array('cuser_id'=>$temp_session_id);
            $this->cm->deleteRecords($where,'mlt_cart');
            $temp['order_id']=$order_id;
            $temp['delivery_date_time']='';

            $ret=$this->common->response(200,true,'Order Saved Successfully',$temp);

        }
                else {
                    $ret=$this->common->response(200,false,'Order Save Failure',array('order_id'=>0,'delivery_date_time'=>''));
                }
            }
            catch(Exception $e) {

                $msg = "";
                $eMessage = $e->getMessage();
                $eMessage = explode('/',$eMessage);
                $eMessage = explode(':',$eMessage[0]);
                if($eMessage[1]==1062) {
                    $msg = "Duplicate Entry";
                }
                else if($eMessage[1]==1452) {
                    $msg = "Foreign key constraint fails";
                }
                else  {
                    $msg = "Database error";
                }
                $ret=$this->common->response(400,false,$msg,array());
            }
        }else{
            $ret=$this->common->response(400,false,'please check input',$data);

        }
    }
    else {
        $ret=$this->common->response(400,false,'no user existed',$data);
    }
        

    }else {
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value',$data);
    }
        echo json_encode($ret);    
    }
    /***************End Of Place Order*************/
    /*******************Api of Order History************/
    public function order_history(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['temp_acesstoken'])) { $temp_acesstoken = $row['temp_acesstoken']; }
        $data=array();$ret=array();$orders=array();
        if($access_token!=globalAccessToken)
        {
            try{
                $id=JWT::decode($access_token,pkey);			 
                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
               
                if($userExists!=false){
                    
                            $order_status=$order_id='';
                            if(isset($row['sk_order_id']))
                                {
                                    if($row['sk_order_id']=="All")
                                        {
                                            $order_id ="All";
                                        }
                                    else{
                                            $order_id = $row['sk_order_id'];
                                        }
                                }
                            if(isset($row['order_status']))
                            {
                                if($row['order_status']=="All")
                                {
                                    $order_status ="All";
                                }
                                else
                                {
                                    $order_status = $row['order_status'];
                                }
                            }
                            if($order_id=="All")
                            {
                                if($order_status=="All")
                                {
                                    $where=array('user_id'=>$id);
                                }
                                else
                                {
                                    $where=array('user_id'=>$id);
                                }
                            }
                            else
                            {
                                if($order_status=="All"){$where=array('sk_order_id'=>$order_id,'user_id'=>$id);}
                                else{$where=array('sk_order_id'=>$order_id,'user_id'=>$id);}
                            }

                            $orders_details=$this->cm->getRecords($where,'mlt_order'); 
                            if($orders_details)
                            {
                                // $orders['orders_details']=array();
                                foreach($orders_details as $rows)
                                {  
                                    $orders=array();
                                    $orders['rating']=$orders['package_amount']=$orders['sk_package_id']=$orders['no_of_people']= $orders['no_of_people']=$orders['from_time']=$orders['select_date']=$orders['other_text']=$orders['party_time']=$orders['user_id']= $orders['user_address']=$orders['ordered_date']=$orders['ordered_time']=$orders['total_order_quantity']=$orders['total_order_value']=$orders['coupon_id']=$orders['discount_amount']=$orders['payment_mode']=$orders['razor_payment_id']=$orders['order_delivery_date']=$orders['order_delivery_time']='';
                                    $orders['sk_order_id']=$rows->sk_order_id;
                                    $where=array('rating_order_id'=>$rows->sk_order_id);

                                    $rating=$this->cm->getRecords($where,'mlt_rating');
                                    if($rating!=false){
                                        foreach($rating as $info55){
                                            $orders['rating']=$info55->rating;
                                        }
                                    }
                                    $where=array('order_id'=>$rows->sk_order_id);
                                   
                                    if($rows->party_time!=null){
                                    $orders['party_time']=$rows->party_time;
                                    }
                                    $packages=$this->cm->getRecords($where,'mlt_user_packages');
                                    if($packages!=false){
                                        foreach($packages as $row1){
                                            $orders['user_packages']=$row1->occation;                                            
                                            $user_packages=$row1->occation;
                                            $orders['other_text']=$row1->other_text;
                                            $orders['select_date']=$row1->select_date;
                                            $orders['from_time']=date('H:i A',strtotime($row1->from_time));
                                            $orders['to_time']=date('H:i A',strtotime($row1->to_time));
                                            $orders['no_of_people']=$row1->no_of_people;
                                            $where=array('sk_package_id'=>$row1->package_id);
                                            $package_details=$this->cm->getRecords($where,'mlt_package');
                                            if($package_details!=false){
                                                foreach($package_details as $rows3){
                                                    $orders['package_name']=$rows3->package_name;
                                                    $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $rows3->package_amount);
                                                    $orders['package_amount']=$num;
                                                }
                                            }
                                        }
                                    }
                                    $orders['user_id']=$rows->user_id;
                                    if($rows->user_address){
                                        $area=$house_no=$city=$state=$country=$pincode=$street=$latitude=$longitude=$full_address=$address_type=$land_mark=$address_type="";
                                        $where=array('sk_address_id'=>$rows->user_address);
                                        $getaddress=$this->cm->getRecords($where,'mlt_address_dup');
                                        if($getaddress!=false){

                                            foreach($getaddress as $info99){
                                                $area=$info99->area;
                                                $house_no=$info99->house_no;
                                                $city=$info99->city;
                                                $state=$info99->state;
                                                 $country=$info99->country;
                                                 if($info99->pincode!=""){$pincode=$info99->pincode;}
                                                 else
                                                 {$pincode="";}
                                                 $street=$info99->street;
                                                 $latitude=$info99->latitude;
                                                 $longitude=$info99->longitude;
                                                 $full_address=$info99->full_address;
                                                 $address_type=$info99->address_type;
                                                 $land_mark=$info99->land_mark;
                                            }
                                        }
                                    }
                                    $orders['address_type']=$address_type;
                                    $orders['user_address']=$full_address;
                                    $orders['ordered_date']=$rows->ordered_date;
                                    $orders['ordered_time']=date('h:i A',strtotime($rows->ordered_time));
                                    //=$rows->ordered_time;

                                    $orders['total_order_quantity']=$rows->total_order_quantity;
                                    $total_order_value = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $rows->total_order_value);

                                     $orders['total_order_value']=$total_order_value;
                                     $orders['coupon_id']=$rows->coupon_id;
                                     $orders['discount_amount']=$rows->discount_amount;
                                     $orders['payment_mode']=$rows->payment_mode;
                                     $orders['razor_payment_id']=$rows->razor_payment_id;
                                    //  $orders['order_delivery_date']=$rows->order_delivery_date;
                                    // $date=date_create($rows->order_delivery_date);
                                    //  $getData=date_format($date,"d M Y");
                                    // $orders['order_delivery_date']=$getData;
                                    $orders['order_delivery_date']=date('d M Y', strtotime($rows->order_delivery_date));

                                     $orders['order_delivery_time']=date('h:i A',strtotime($rows->order_delivery_time));

                                     //$orders['order_delivery_time']=$rows->order_delivery_time;
                                    $orders['order_status']=$rows->order_status;
                                    $where=array('order_id'=>$orders['sk_order_id']);
                                    $orders_details_items=$this->cm->getRecords($where,'mst_order_details'); 
                                    if($orders_details_items){
                                        $temp2=array();
                                          foreach($orders_details_items as $info1){
                                            $order_details['item_id']='';
                                                $order_details['item_id']=$info1->item_id;
                                                $where=array('sk_id'=>$info1->item_id,'item_onboarding_status'=>1);
                                                $items=$this->cm->getRecords($where,'mlt_items_onboarding');
                                                if($items!=false){
                                                    foreach($items as $info2){
                                                        $order_details['item_price']=$order_details['item_size']=''; $order_details['cart_count']=$order_details['cprice']=$order_details['customization']=$order_details['section_name']=$order_details['category_id']=$order_details['type']=$order_details['item_name']=$order_details['display_name']=$order_details['short_description']=$order_details['description']=$order_details['seo_title']=$order_details['seo_description']=$order_details['image']='';
                                                        $order_details['section_name']=$info2->section_name;
                                                        $order_details['category_id']=$info2->category_id;
                                                        $order_details['type']=$info2->type;
                                                        $order_details['item_name']=$info2->item_name;
                                                        $order_details['display_name']=$info2->display_name;
                                                        $order_details['description']=$info2->short_description;
                                                        $order_details['short_description']=$info2->description;
                                                        $order_details['image']=$info2->image;
                                                            
                                                            $order_details['item_onboarding_status']=$info2->item_onboarding_status;
                                                    }
                                                    $item_size='';
                                                    $order_details['item_price']=$info1->item_price;
                                                    if($info1->item_size==1){
                                                        $item_size='';
                                                    }else{
                                                        $item_size=$info1->item_size;

                                                    }
                                                            $order_details['item_size']=$item_size;
                                                    $custom=json_decode($info1->customization);
                                                        $output6=array();
                                                            if($custom->veg){
                                                            foreach($custom->veg as $info4){
                                                                $output6[]=$info4;
                                                                }
                                                            }if($custom->nonveg){
                                                                foreach($custom->nonveg as $info4){
                                                                    $output6[]=$info4;
                                                                }
                                                            }if($custom->flavor){
                                                                foreach($custom->flavor as $info4){
                                                                    $output6[]=$info4;
                                                                }
                                                            }if($custom->base){
                                                                foreach($custom->base as $info4){
                                                                    $output6[]=$info4;
                                                                }
                                                            }if($custom->size){
                                                                foreach($custom->size as $info4){
                                                                    $output6[]=$info4;
                                                                }
                                                            }
                                                            $order_details['customization']=$output6;
                                                        
                                                    $order_details['cart_count']=$info1->cart_count;
                                                        $order_details['cprice']=$info1->cprice;
                                                }
                                                $temp2[]=$order_details;
                                            } 
                                            $orders['history']=$temp2;
                                    }
                                    $temp1[]=$orders;    
                                }
                                $orders1['orders_details']=$temp1;
                                $ret=$this->common->response(200,true,'Order Details',$orders1);
                                }
                                else{
                                    $temp1=array();
                                    $orders1['orders_details']=$temp1;
                                    $ret=$this->common->response(200,false,'No Data Available',$orders1);
                                }
                     } else{
                            $ret=$this->common->response(400,false,'No existing user',array());
                        }
                    }
            catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }
        
        } else if($access_token==globalAccessToken){
            
            $id=JWT::decode($temp_acesstoken,pkey);
                    
            $order_status=$order_id='';
            if(isset($row['sk_order_id']))
                {
                    if($row['sk_order_id']=="All")
                        {
                            $order_id ="All";
                        }
                    else{
                            $order_id = $row['sk_order_id'];
                        }
                }
            if(isset($row['order_status']))
            {
                if($row['order_status']=="All")
                {
                    $order_status ="All";
                }
                else
                {
                    $order_status = $row['order_status'];
                }
            }
            if($order_id=="All")
            {
                if($order_status=="All")
                {
                    $where=array('user_id'=>$id);
                }
                else
                {
                    $where=array('user_id'=>$id);
                }
            }
            else
            {
                if($order_status=="All"){$where=array('sk_order_id'=>$order_id,'user_id'=>$id);}
                else{$where=array('sk_order_id'=>$order_id,'user_id'=>$id);}
            }

            $orders_details=$this->cm->getRecords($where,'mlt_order'); 
            if($orders_details)
            {
                // $orders['orders_details']=array();
                foreach($orders_details as $rows)
                {  
                    $orders=array();
                    $orders['rating']=$orders['package_amount']=$orders['sk_package_id']=$orders['no_of_people']= $orders['no_of_people']=$orders['from_time']=$orders['select_date']=$orders['other_text']=$orders['party_time']=$orders['user_id']= $orders['user_address']=$orders['ordered_date']=$orders['ordered_time']=$orders['total_order_quantity']=$orders['total_order_value']=$orders['coupon_id']=$orders['discount_amount']=$orders['payment_mode']=$orders['razor_payment_id']=$orders['order_delivery_date']=$orders['order_delivery_time']='';
                    $orders['sk_order_id']=$rows->sk_order_id;
                    $where=array('rating_order_id'=>$rows->sk_order_id);

                    $rating=$this->cm->getRecords($where,'mlt_rating');
                    if($rating!=false){
                        foreach($rating as $info55){
                            $orders['rating']=$info55->rating;
                        }
                    }
                    $where=array('order_id'=>$rows->sk_order_id);
                   
                    if($rows->party_time!=null){
                    $orders['party_time']=$rows->party_time;
                    }
                   
                    $orders['address_type']= $orders['user_address']= $orders['user_name']=$orders['user_email']=$orders['user_moblie']=$orders['user_houseno']=$orders['user_address1']=$orders['user_city']= $orders['landmark']=$orders['user_pin_number']=$orders['ordered_date']=$orders['ordered_time']='';
                                $orders['user_name']=$rows->user_name;
                                $orders['user_email']=$rows->user_email;
                                $orders['user_moblie']=$rows->user_moblie;
                                $orders['user_houseno']=$rows->user_houseno;
                                $orders['user_address1']=$rows->user_address1;
                                $orders['user_city']=$rows->user_city;
                                if($rows->landmark!=''){
                                $orders['landmark']=$rows->landmark;
                                }
                                $orders['user_pin_number']=$rows->user_pin_number;
                                $orders['ordered_date']=$rows->ordered_date;
                                $orders['ordered_time']=date('h:i A',strtotime($rows->ordered_time));
                                $orders['user_address']=$orders['user_houseno'].' '.$orders['user_address1'].' '.$orders['user_city'].' '. $orders['user_pin_number'];

                                $orders['ordered_date']=$rows->ordered_date;
                                $orders['ordered_time']=date('h:i A',strtotime($rows->ordered_time));
                                //=$rows->ordered_time;

                                $orders['total_order_quantity']=$rows->total_order_quantity;
                                $total_order_value = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $rows->total_order_value);

                                 $orders['total_order_value']=$total_order_value;
                                 $orders['coupon_id']=$rows->coupon_id;
                                 $orders['discount_amount']=$rows->discount_amount;
                                 $orders['payment_mode']=$rows->payment_mode;
                                 $orders['razor_payment_id']=$rows->razor_payment_id;
                                // $orders['order_delivery_date']=$rows->order_delivery_date;
                                $orders['order_delivery_date']=date('d M Y', strtotime($rows->order_delivery_date));

                                 $orders['order_delivery_time']=date('h:i A',strtotime($rows->order_delivery_time));
                     //$orders['order_delivery_time']=$rows->order_delivery_time;
                    $orders['order_status']=$rows->order_status;
                    $where=array('order_id'=>$orders['sk_order_id']);
                    $orders_details_items=$this->cm->getRecords($where,'mst_order_details'); 
                    if($orders_details_items){
                        $temp2=array();
                          foreach($orders_details_items as $info1){
                            $order_details['item_id']='';
                                $order_details['item_id']=$info1->item_id;
                                $where=array('sk_id'=>$info1->item_id,'item_onboarding_status'=>1);
                                $items=$this->cm->getRecords($where,'mlt_items_onboarding');
                                if($items!=false){
                                    foreach($items as $info2){
                                        $order_details['item_price']=$order_details['item_size']=''; $order_details['cart_count']=$order_details['cprice']=$order_details['customization']=$order_details['section_name']=$order_details['category_id']=$order_details['type']=$order_details['item_name']=$order_details['display_name']=$order_details['short_description']=$order_details['description']=$order_details['seo_title']=$order_details['seo_description']=$order_details['image']='';
                                        $order_details['section_name']=$info2->section_name;
                                        $order_details['category_id']=$info2->category_id;
                                        $order_details['type']=$info2->type;
                                        $order_details['item_name']=$info2->item_name;
                                        $order_details['display_name']=$info2->display_name;
                                        $order_details['description']=$info2->short_description;
                                        $order_details['short_description']=$info2->description;
                                        $order_details['image']=$info2->image;
                                            
                                            $order_details['item_onboarding_status']=$info2->item_onboarding_status;
                                    }
                                    $item_size='';
                                    $order_details['item_price']=$info1->item_price;
                                    if($info1->item_size==1){
                                        $item_size='';
                                    }else{
                                        $item_size=$info1->item_size;

                                    }
                                            $order_details['item_size']=$item_size;
                                    $custom=json_decode($info1->customization);
                                        $output6=array();
                                            if($custom->veg){
                                            foreach($custom->veg as $info4){
                                                $output6[]=$info4;
                                                }
                                            }if($custom->nonveg){
                                                foreach($custom->nonveg as $info4){
                                                    $output6[]=$info4;
                                                }
                                            }if($custom->flavor){
                                                foreach($custom->flavor as $info4){
                                                    $output6[]=$info4;
                                                }
                                            }if($custom->base){
                                                foreach($custom->base as $info4){
                                                    $output6[]=$info4;
                                                }
                                            }if($custom->size){
                                                foreach($custom->size as $info4){
                                                    $output6[]=$info4;
                                                }
                                            }
                                            $order_details['customization']=$output6;
                                        
                                    $order_details['cart_count']=$info1->cart_count;
                                        $order_details['cprice']=$info1->cprice;
                                }
                                $temp2[]=$order_details;
                            } 
                            $orders['history']=$temp2;
                    }
                    $temp1[]=$orders;    
                }
                $orders1['orders_details']=$temp1;
                $ret=$this->common->response(200,true,'Order Details',$orders1);
                }
                else{
                    $temp1=array();
                    $orders1['orders_details']=$temp1;
                    $ret=$this->common->response(200,false,'No Data Available',$orders1);
                }

        }
        else{
                $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
            }
            echo json_encode($ret);
    }
    public function my_account(){
		$this->access_control();
		$commonData=$this->common_data();
		$access_token = false;
		$row=$this->input->request_headers();   
		if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
		$data=array();$ret=array();
		if($access_token){
				
					if ($this->input->server('REQUEST_METHOD') === 'GET')
					{
						$params = array();$userExists='';
						$params = json_decode(@file_get_contents('php://input'),TRUE);
                        $plain_userid=JWT::decode($access_token,pkey);				 
                        $where=array('sk_user_id'=>$plain_userid);
                        $userExists=$this->cm->getRecords($where,'mst_user');
                        if($userExists){
                            //if($userExists[0]->facebook_auth_token ||$userExists[0]->twitter_auth_token){
                            foreach($userExists as $info){
								$user['sk_user_id']=$info->sk_user_id;
                                $user['full_name']=$info->full_name;
								$user['mobile']=$info->mobile;
								$user['email']=$info->email;
								
								}
                                $ret=$this->common->response(200,true,'Profile Details Are',$user);
                            }
								else {
									$ret=$this->common->response(400,false,'No Data Available',array());
								}
                            }
					elseif ($this->input->server('REQUEST_METHOD') == 'PUT')
					{
						$params = array();
                        $plain_userid=JWT::decode($access_token,pkey);				 

						$params = json_decode(@file_get_contents('php://input'),TRUE);
					    $sk_user_id=$full_name=$mobile=$email='';
						if(isset($params)) 
						{
                            if(isset($params['full_name'])) { $full_name = $params['full_name'];} 
							if(isset($params['mobile'])) { $mobile = $params['mobile'];} 
							if(isset($params['email'])) {   $email = $params['email'];} 
								$updateData=array();
								if($plain_userid!=""){
                                    $otp = mt_rand(1000,9999);

                                        $updateData=array(
                                            'user_id'=>$plain_userid,
                                            'full_name'=>$full_name,
                                            'mobile'=>$mobile,
                                            'email'=>$email,
                                           'otp'=>$otp
                                        );
										$response = $this->cm->Save($updateData,'mlt_temp_user');
                                        $updatedata=array('otp'=>$otp);
                                        $where=array('mobile'=>$mobile);
                                        $this->cm->updateRecords($updatedata,$where,'mst_user');
                                        $response=array(
                                           'otp'=>$otp,
                                           'temp_user_id'=>$response,
                                           'accesstoken'=>JWT::encode($sk_user_id,pkey)				 
                                        );
                                        $response1=$this->sendsms($mobile,$otp,$full_name);
                                        $ret=$this->common->response(200,true,'OTP Sent successfully',$response);
									}
								else{
									$ret=$this->common->response(400,true,'Please Check Json Input or Value',array());
								}
							}
						
						}
						else {
							$ret=$this->common->response(400,false,'Please check the input',$data);
						}
                    }
                
			
        
		else {
			$ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value',$data);
		}
		echo json_encode($ret);
	}
    public function corporate_tie_up(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        $data=array();$ret=array();
        if($access_token)
        {
              //  $userid=JWT::decode($access_token,pkey);				 
               // $where=array('sk_user_id'=>$userid);
              //  $userExists=$this->cm->getRecords($where,'mst_user');
                    if($this->input->server('REQUEST_METHOD') === 'POST'){
                    $params = array();
                    $tie_up_id=$full_name=$organization_name=$mobile_num=$email_id=$personal_id_doc=$official_address_proof=$status="";
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params)) { 
                        if(isset($params['full_name'])) { $full_name = $params['full_name'];} 
                        //var_dump($full_name);
                        if(isset($params['organization_name'])) { $organization_name = $params['organization_name'];} 
                        if(isset($params['mobile_num'])) { $mobile_num = $params['mobile_num'];} 
                        if(isset($params['document_type1'])) { $document_type1 = $params['document_type1'];} 
                        if(isset($params['document_type2'])) { $document_type2 = $params['document_type2'];} 
                        if(isset($params['email_id'])) {  $email_id = $params['email_id'];} 
                        if(isset($params['personal_id_doc'])) {  $personal_id_doc = $params['personal_id_doc'];} 
                        if(isset($params['official_address_proof'])) {  $official_address_proof = $params['official_address_proof'];} 
                        $allowedExts=array("png,jpg,jpeg,pdf");
                        if (!file_exists("uploads/corporate_tie/")) {
                            mkdir("uploads/corporate_tie/", 0777, true);
                        }
                                    $upload_folder = "uploads/corporate_tie/";
                                                

                                    /*****for first documement**********/
                                    $image_parts = explode(";base64,", $personal_id_doc);
                                $image_type_aux = explode("/", $image_parts[0]);
                                    $image_type = $image_type_aux[1];
                                   // var_dump($image_type);

                                $image_base64 = base64_decode($image_parts[1]);
                                $personal_id_doc=uniqid() .".".$image_type;
                                $event_image_name_with_path = $upload_folder . $personal_id_doc;
                                file_put_contents($event_image_name_with_path, $image_base64);
                                

                                        /*****for second  documement**********/

                                $image_parts = explode(";base64,", $official_address_proof);
                                $image_type_aux = explode("/", $image_parts[0]);
//var_dump($official_address_proof);
                                    $image_type = $image_type_aux[1];
                                $image_base64 = base64_decode($image_parts[1]);
                                $official_address_proof=uniqid() .".".$image_type;
                                $event_image_name_with_path = $upload_folder . $official_address_proof;
                                file_put_contents($event_image_name_with_path, $image_base64);

                        $saveData = array(
                            'full_name'=>$full_name,
                            'organization_name'=>$organization_name,
                            'mobile_num'=>$mobile_num,
                            'document_type1'=>$document_type1,
                            'document_type2'=>$document_type2,
                            
                            'email_id'=>$email_id,
                            'personal_id_doc'=>$personal_id_doc,
                            'official_address_proof'=>$official_address_proof,
                            //'order_status'=>'1'
                             );

                             try {
                                $tie_up_id = $this->cm->Save($saveData,'mlt_corporate_tie_up'); 
                                //var_dump($tie_up_id);
                                if($tie_up_id!=0) {
                                    $ret=$this->common->response(200,true,'Corporate Tie Up Saved Success',array("$tie_up_id"=>$tie_up_id));
                                }
                                else {
                                    $ret=$this->common->response(200,false,'Corporate Tie Up Save Failure',array("$tie_up_id"=>""));
                                }
                            }
                    catch(Exception $e) {

                        $msg = "";
                        $eMessage = $e->getMessage();
                        $eMessage = explode('/',$eMessage);
                        $eMessage = explode(':',$eMessage[0]);
                        if($eMessage[1]==1062) {
                            $msg = "Duplicate Entry";
                        }
                        else if($eMessage[1]==1452) {
                            $msg = "Foreign key constraint fails";
                        }
                        else  {
                            $msg = "Database error";
                        }
                        $ret=$this->common->response(400,false,$msg,array());
                    }
               
            }
            else {
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }
                

            }else {
                    $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value',$data);
            }
            
        }
        else{
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
        }
        echo json_encode($ret);
    }



    public function realtime_feasabilty_check(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $temp['time']=$langitude=$latitude=$date=$time_full='';
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) {  $access_token = $row['accesstoken']; }
        if(isset($row['latitude'])) { $latitude = $row['latitude']; }
        if(isset($row['date'])) { $date = $row['date']; }
        if(isset($row['time'])) { $time_full = $row['time']; }
        if(isset($row['longitude'])) { $langitude = $row['longitude']; }
        if(isset($row['flag'])) { $flag = $row['flag']; }
       
        $data=array();$ret=array();
        if($access_token!='' && $latitude!='' && $langitude!=''&& $flag!=''){
            if($flag!='1'){
                $endpoint = "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/jobsApi/v1/job/realTimeFeasabilityCheck";
                $coordinate = array('latitude'=>$latitude,'longitude'=>$langitude);
                $payload = '{
                    "jobType": "DROP",
                    "dropCoordinate": '.json_encode($coordinate).',
                    "skillsets": [
                      "Default"
                    ],
                    "jobPriority": "1",
                    "asapTrue": "true",
                    "demand": "1",
                    "entityName": "RealtimeSchedulingConfig",
                    "templateId": "5505822050222080"
                  }';

                  $headers = array('Content-Type:application/json','CLIENT_ID:6181027215048704');
                  $makecall = $this->common->callAPI('POST', $endpoint, $payload, $headers);
                 $result = json_decode($makecall);
                 if($result->data->jobFeasibility){
                     $dt = new DateTime($result->data->deliveryEndTime);
                     $tz = new DateTimeZone('Asia/Kolkata'); // or whatever zone you're after
     
                     $dt->setTimezone($tz);
                     $v = explode(" ",$dt->format('Y-m-d h:i A'));
                    $full_time= $v[1].' '.$v[2];
                     $temp = array('time'=>$full_time);
                     $ret=$this->common->response(200,true,'Time success',$temp);
                 }
                 else{
                     $temp = array('time'=>'false');
                     $ret=$this->common->response(200,false,'Time failure',$temp);
                 }
                
                }
                  else{
                    $time=explode('-',$time_full);
                    $time=$time[1];
                    $date_tomorrow=$this->utctime($date,$time);
                    $endpoint = "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/jobsApi/v1/job/realTimeFeasabilityCheck";
                    $coordinate = array('latitude'=>$latitude,'longitude'=>$langitude);
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
                        "templateId": "5505822050222080"
                      }';
                      $temp['time']='';
                      $headers = array('Content-Type:application/json','CLIENT_ID:6181027215048704');
                      $makecall = $this->common->callAPI('POST', $endpoint, $payload, $headers);
                     $result = json_decode($makecall);
                     if(!empty($result->data->availableSlots)){
                        $slot_id=$result->data->availableSlots[0]->slotId;
                        $start=$result->data->availableSlots[0]->start;
                         $end=$result->data->availableSlots[0]->end;
                        $level_id=$result->data->level;
                        if($end==$date_tomorrow){
                            $temp['time']=$time_full;
                        }else{
                          $time = strtotime($end);
                          $end = date("Y-m-d/h:i A", $time);
                          $end=explode('/',$end);
                          $time = strtotime($start);
                          $start = date("Y-m-d/h:i A", $time);
                          $start=explode('/',$start);
                          $temp['time']=$start[1].' - '.$end[1];
                        }
                        $ret=$this->common->response(200,true,'TIME SLOT AVAILABLE',$temp);

                    }
                     else{
                         $ret=$this->common->response(200,false,'TIME SLOT NOT AVAILABLE',$temp);
                        }
                      
                  }
                 
        }
    
    else{
        $ret=$this->common->response(200,true,'Please give correct input',array());
    }

        echo json_encode($ret);

    }




    public function otp_verify_edit() 
{
    $this->access_control();
    $commonData=$this->common_data();
    $today = $commonData['date'];
    $access_token = false;
    $row=$this->input->request_headers();
    if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
    $data=array();$ret=array();
    if($access_token){
        try {
                $params = array();
                $email = null;
                $password = null;$user_type="";
                $responsed['user_details']=array();

                $name=$mobile=$otp=$userid="";
                $params = json_decode(@file_get_contents('php://input'),TRUE);
                if(isset($params)) {
                    if(isset($params['temp_user_id'])) { $temp_user_id = $params['temp_user_id'];}
                    if(isset($params['otp'])) {   $otp = $params['otp'];}
                    if($temp_user_id!=null && $otp!=null) {
                        try {
                            $where=array('sk_user_temp_id'=>$temp_user_id);
                            $isExits1 = $this->cm->getRecords($where,'mlt_temp_user');
                            $mobile='';
                            if($isExits1!=false)
                            {
                                foreach($isExits1 as $inf)
                                {
                                    $mobile=$inf->mobile;
                                }  
                            }
                            $where=array('mobile'=>$mobile,'otp'=>$otp);
                            $isExits = $this->cm->getRecords($where,'mst_user');
                            if($isExits!=false) {
                                
                                foreach($isExits1 as $inf)
                                {
                                    $name=$inf->full_name;
                                    $mobile=$inf->mobile;
                                    $email=$inf->email;
                                     $userid=$inf->user_id;
                                }
                                $update_data=array(
                                    'full_name'=>$name,
                                    'email'=>$email,
                                    'mobile'=>$mobile,
                                    'otp'=>$otp
                                );
                                $where=array('mobile'=>$mobile);
                                $updatedotp=$this->cm->updateRecords($update_data,$where,'mst_user');
                                $where=array('sk_user_temp_id'=>$temp_user_id);
                                $updatedotp=$this->cm->deleteRecords($where,'mlt_temp_user');
                                        $response['name']=$name;
                                        $response['mobile']=$mobile;
                                        $response['email']=$email;
                                        $response['userid']=$userid;
                                        $response['Accesstoken']=JWT::encode($userid,pkey);
                                        $temp[]=$response;
                                
                                $ret=$this->common->response(200,true,'OTP Verified Successfully',$temp);

                            }
                            else{
                                $ret=$this->common->response(200,false,'Invalid OTP',array());
                            }
                        }	
                        catch(Exception $e) {

                            $msg = "";
                            $eMessage = $e->getMessage();
                            $eMessage = explode('/',$eMessage);
                            $eMessage = explode(':',$eMessage[0]);
                            if($eMessage[1]==1062) {
                                $msg = "Duplicate Entry";
                            }
                            else if($eMessage[1]==1452) {
                                $msg = "Foreign key constraint fails";
                            }
                            else  {
                                $msg = "Database error";
                            }

                            $ret=$this->common->response(400,false,$msg,new stdClass());
                        }
                    }
                            else {
                                
                                $ret=$this->common->response(400,false,'Inavlid Otp',new stdClass());
                            }
                        }
                else {
                    
                    $ret=$this->common->response(400,false,'please check the input ',new stdClass());
                }
            
    }
    catch (Exception $e) {
            
        $ret=$this->common->response(400,false,'Invalid Access Token',new stdClass());
        }
    }else{	
        $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
    }
    echo json_encode($ret);
}
public function gift_a_cart(){
    $this->access_control();
    $commonData=$this->common_data();
    $access_token = false;
    $row=$this->input->request_headers();
    if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
    $data=array();$ret=array();
    if($access_token!=globalAccessToken)
    {
        try{
            $id=JWT::decode($access_token,pkey);
        //    echo $id;				 
            $where=array('sk_user_id'=>$id);
            $userExists=$this->cm->getRecords($where,'mst_user');
            if($userExists){
                if($this->input->server('REQUEST_METHOD') === 'POST'){
                    $params = array();
                    $sk_gift_cart_id =$name=$mobile=$email=$gift_cart_status=$giftcart=$friend=$name="";
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params)) { 
                        if(isset($params['giftcart'])) { $giftcart = $params['giftcart'];} 
                        if(!empty($giftcart)){
                            for($i=0; $i<count($giftcart);$i++){
                                if(isset($giftcart['friend1'])) {  $friend1 = $giftcart['friend1'];}
                                     
                                if(isset($giftcart['friend2'])) {   $friend2 = $giftcart['friend2'];
                                    
                                if(isset($giftcart['friend3'])) {   $friend3 = $giftcart['friend3'];}
                               
                            }
                        }
                    }
                        if(!empty($friend1)){

                                if(isset($friend1['name'])) {   $name= $friend1['name'];}
                                if(isset($friend1['mobile'])) { $mobile = $friend1['mobile'];} 
                                if(isset($friend1['email'])) { $email = $friend1['email'];} 
                       
                                $saveData = array(
                                    'name'=>$name,
                                    'user_id'=>$id,
                                    'mobile'=>$mobile,
                                    'email'=>$email,
                                    'gift_cart_status'=>'1'
                                     );                           
                                     $sk_gift_cart_id = $this->cm->Save($saveData,'mlt_gift_a_cart'); 

                         }
                        
                        if(!empty($friend2)){
                               if(isset($friend2['name'])) {  $name  = $friend2['name'];}
                                if(isset($friend2['mobile'])) { $mobile = $friend2['mobile'];} 
                                if(isset($friend2['email'])) { $email = $friend2['email'];} 
                       
                                $saveData = array(
                                    'name'=>$name,
                                    'user_id'=>$id,
                                    'mobile'=>$mobile,
                                    'email'=>$email,
                                    'gift_cart_status'=>'1'
                                     );
                                     $sk_gift_cart_id = $this->cm->Save($saveData,'mlt_gift_a_cart'); 

                            }
                        
                        
                        

                        if(!empty($friend3)){
                                if(isset($friend3['name'])) {   $name= $friend3['name'];}
                                if(isset($friend3['mobile'])) { $mobile= $friend3['mobile'];} 
                                if(isset($friend3['email'])) { $email = $friend3['email'];} 
                                $saveData = array(
                                    'name'=>$name,
                                    'user_id'=>$id,

                                    'mobile'=>$mobile,
                                    'email'=>$email,
                                    'gift_cart_status'=>'1'
                                     );
                                     $sk_gift_cart_id = $this->cm->Save($saveData,'mlt_gift_a_cart'); 

                            }
                            if($sk_gift_cart_id>0) {
                        $ret=$this->common->response(200,true,'Gift A Cart Save Success',1);
                        }
                        else{
                            $ret=$this->common->response(400,false,'Gift A Cart Save failure',0);
                        }
                    }
                        
                
            }else{
                $ret=$this->common->response(400,false,'Please check the input',$data);

            }
                
         
        }  else{
            $ret=$this->common->response(400,false,'User is not existed',$data);

        }
    }    
        catch (Exception $e) {
            $ret=$this->common->response(400, false, 'Invalid Access Token', array());
        }
    }        
    else{
        $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
    }
    echo json_encode($ret);
}
public function todisplayTime(){
    $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) {  $access_token = $row['accesstoken']; }
        $data=array();$ret=array();
        if($access_token)
        {
            try{
               
                    // if($userExists){
                        if ($this->input->server('REQUEST_METHOD') === 'GET')
                        {
                           $time=array();
                           $time_deatils=array();
                           $time['key']='12_to_4';
                           $time['label']="12 PM - 4 PM";

                           $time_deatils[]='12:00 PM - 12:30 PM';
                           $time_deatils[]='12:30 PM - 01:00 PM';
                           $time_deatils[]='01:00 PM - 01:30 PM';
                           $time_deatils[]='01:30 PM - 02:00 PM';
                           $time_deatils[]='02:00 PM - 02:30 PM';
                           $time_deatils[]='02:30 PM - 03:00 PM';
                           $time_deatils[]='03:00 PM - 03:30 PM';
                           $time_deatils[]='03:30 PM - 04:00 PM';

                           $time['values']=$time_deatils;

                           $time['key2']='4_to_8';
                           $time['label2']="04 PM - 8 PM";
                           $time_deatils1[]='04:00 PM - 04:30 PM';
                           $time_deatils1[]='04:30 PM - 05:00 PM';
                           $time_deatils1[]='05:00 PM - 05:30 PM';
                           $time_deatils1[]='05:30 PM - 06:00 PM';
                           $time_deatils1[]='06:00 PM - 06:30 PM';
                           $time_deatils1[]='06:30 PM - 07:00 PM';
                           $time_deatils1[]='07:00 PM - 07:30 PM';
                           $time_deatils1[]='07:30 PM - 08:00 PM';
                           $time['values2']=$time_deatils1;

                           $time['key3']='8_to_12';
                           $time['label3']="8 PM - 12 PM";

                           $time_deatils2[]='08:00 PM - 08:30 PM';
                           $time_deatils2[]='08:30 PM - 09:00 PM';
                           $time_deatils2[]='09:00 PM - 09:30 PM';
                           $time_deatils2[]='09:30 PM - 10:00 PM';
                           $time_deatils2[]='10:00 PM - 10:30 PM';
                           $time_deatils2[]='10:30 PM - 11:00 PM';
                           $time_deatils2[]='11:00 PM - 11:30 PM';
                           $time_deatils2[]='11:30 PM - 12:00 PM';
                           $time['values3']=$time_deatils2;

                            $time_deatils3=array();
                           $time['key4']='today';
                           $time['label4']="12:00 PM - 12:00 AM";

                           $time_deatils3[]='12:00 PM - 12:30 PM';
                           $time_deatils3[]='12:30 PM - 01:00 PM';
                           $time_deatils3[]='01:00 PM - 01:30 PM';
                           $time_deatils3[]='01:30 PM - 02:00 PM';
                           $time_deatils3[]='02:00 PM - 02:30 PM';
                           $time_deatils3[]='02:30 PM - 03:00 PM';
                           $time_deatils3[]='03:00 PM - 03:30 PM';
                           $time_deatils3[]='03:30 PM - 04:00 PM';
                           $time_deatils3[]='04:00 PM - 04:30 PM';
                           $time_deatils3[]='04:30 PM - 05:00 PM';
                           $time_deatils3[]='05:00 PM - 05:30 PM';
                           $time_deatils3[]='05:30 PM - 06:00 PM';
                           $time_deatils3[]='06:00 PM - 06:30 PM';
                           $time_deatils3[]='06:30 PM - 07:00 PM';
                           $time_deatils3[]='07:00 PM - 07:30 PM';
                           $time_deatils3[]='07:30 PM - 08:00 PM';
                           $time_deatils3[]='08:00 PM - 08:30 PM';
                           $time_deatils3[]='08:30 PM - 09:00 PM';
                           $time_deatils3[]='09:00 PM - 09:30 PM';
                           $time_deatils3[]='09:30 PM - 10:00 PM';
                           $time_deatils3[]='10:00 PM - 10:30 PM';
                           $time_deatils3[]='10:30 PM - 11:00 PM';
                           $time_deatils3[]='11:00 PM - 11:30 PM';
                           $time_deatils3[]='11:30 PM - 12:00 AM';
                        // $output=array();

                        //  $time = strtotime(date('H:i'));
                        //                 $time1=date('H:i');
                        //                 if((strtotime(date('Y-m-d H:i')))<=(strtotime(date('Y-m-d 12:00')))){
                        //                       $time = strtotime(date('12:00'));
                        //                      $time1=date('12:00');

                        //                 }
                        //                 $round = 30*60;
                        //                 $rounded = round($time / $round) * $round;
                        //                 $cur_given_time= date("H:i", $rounded);
                        //                 $tomdate= date("Y-m-d", strtotime('tomorrow'));
                        //                 $end_time="12:00 AM";
                        //                 $t1 = strtotime(date('y-m-d').$time1);
                        //                  $t2 = strtotime("$tomdate $end_time");
                        //                 $diff = $t2 - $t1;
                        //                 $no_hrs = $diff / ( 60 * 60 );
                        //                 $time_int=$no_hrs*2;
                        //                 $time=0;
                        //                 $rounded1='';
                        //                  $start_time=''; $rounded='8888';
                        //                 for($i=0;$i<$time_int;$i++){ 
                        //                     if(date('H:i',strtotime("today"))!=$rounded){
                        //                        $rounded=date('h:i A',ceil((strtotime('+'.$time.' minutes',strtotime(date($cur_given_time))))/1800)*1800);
                        //                      $rounded1=date('H:i',strtotime($rounded));
                        //                      $rounded1=date('h:i A',ceil((strtotime('+30 minutes',strtotime(date($rounded1))))/1800)*1800);
                        //                      $time_deatils3[]=$rounded;
                        //                     $rounded=date('h:i A',strtotime($rounded));
                        //                     $rounded1=date('h:i A',strtotime($rounded1));
                        //                     $time=$time+30; 
                        //                     }
                        //                 }
                                        
                           $time['values4']=$time_deatils3;
                        $ret=$this->common->response(200,true,'Timing Slots',$time);
                        }
                    }
            catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }
        
        } else{
                $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
            }
            echo json_encode($ret);
        }
        public function packages(){
            $this->access_control();
            $access_token = false;
            $row=$this->input->request_headers();
            if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
            $data=array();$ret=array();$packages=array();
            if($access_token!=globalAccessToken)
            {
                try{
    
                        $package_status1=$package_id1="";
                        if(isset($row['sk_package_id']))
                        {
                            if($row['sk_package_id']=="All")
                            {
                                $package_id1 ="All";
                            }
                            else{
                                $package_id1 = $row['sk_package_id '];
                            }
                        }
                        if(isset($row['package_status']))
                        {
                            if($row['package_status']=="All")
                            {
                                $package_status1 ="All";
                            }
                            else
                            {
                                $package_status1 = $row['package_status'];
                            }
                        }
                        if($package_id1=="All")
                        {
                            if($package_status1=="All")
                            {
                                $where=array();
                            }
                            else
                            {
                                $where=array('package_status'=>$package_status1);
                            }
    
                        }
                        else{
                            if($package_status1=="All"){$where=array('sk_package_id'=>$package_id1);}
                            else{$where=array('sk_package_id'=>$package_id1,'package_status'=>$package_status1);}
                        }
                        $packagedetails=$this->cm->getRecords($where,'mlt_package'); 
                        if($packagedetails)
                        {
                            foreach($packagedetails as $inf){
                                $pack['package_id']=$pack['package_name']=$pack['no_of_pizza']=$pack['no_of_sides']=$pack['no_of_salads']=$pack['no_of_dips']=$pack['no_of_desserts']=$pack['no_of_drinks']=$pack['display_package']=$pack['package_amount']="";
                                $pack['package_id']=$inf->sk_package_id;
                                $pack['package_name']=$inf->package_name;
                                $pack['no_of_pizza']=$inf->no_of_pizza;
                                $pack['no_of_sides']=$inf->no_of_sides;
                                $pack['no_of_salads']=$inf->no_of_salads;
                                $pack['no_of_dips']=$inf->no_of_dips;
                                $pack['no_of_desserts']=$inf->no_of_desserts;
                                $pack['no_of_drinks']=$inf->no_of_drinks;
                                $pack['display_package']=$inf->display_package;
                                $pack['package_amount']=$inf->package_amount;
                                $temp1[]=$pack;
                                
                            }
                            $pack1['packagedetails']=$temp1;
                            $ret=$this->common->response(200,true,'Package Details are',$pack1);
    
                            
    
                        }else{
                            $ret=$this->common->response(400,false,'No Data Available in Packages',array());
                        }
                    
                }catch(Exception $e){
    
                }
    
            }else{
                $ret=$this->common->reponse(400,false,'Invalid Access Token - please check access both key and value1',new stdClass());
            }echo json_encode($ret);
        }
      
public function party_time(){
$this->access_control();
$access_token = $temp_session_id=false;
$row=$this->input->request_headers();
if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
if(isset($row['temp_session_id'])) { $temp_session_id = $row['temp_session_id']; }
$data=array();$ret=array();$party_time=array();
if($access_token!=globalAccessToken)
    {
        try{
            $id=JWT::decode($access_token,pkey);
            //    echo $id;				 
                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists!=false){
                    if($this->input->server('REQUEST_METHOD') === 'GET'){
                        $package_status1=$package_id1="";
                        if(isset($row['sk_user_package_id']))
                        {
                            if($row['sk_user_package_id']=="All")
                            {
                                $sk_user_package_id ="All";
                            }
                            else{
                                $sk_user_package_id = $row['sk_user_package_id'];
                            }
                        }
                        if(isset($row['user_package_status']))
                        {
                            if($row['user_package_status']=="All")
                            {
                                $user_package_status ="All";
                            }
                            else
                            {
                                 $user_package_status = $row['user_package_status'];
                            }
                        }
                        if($sk_user_package_id=="All")
                        {
                            if($user_package_status=="All")
                            {
                                $where=array();
                            }
                            else
                            {
                                $where=array('temp_package_status'=>$user_package_status);
                            }
    
                        }
                        else{
                            if($user_package_status=="All"){$where=array('sk_package_id'=>$sk_user_package_id);}
                            else{$where=array('sk_user_package_id'=>$sk_user_package_id,'temp_package_status'=>$user_package_status);}
                        }
                        $packagedetails=$this->cm->getRecords($where,'mlt_user_packages'); 
                        if($packagedetails!=false)
                        {
                            foreach($packagedetails as $inf){
                                $pack['select_date']= $pack['sk_user_package_id']=$pack['from_time']=$pack['to_time']=$pack['no _of_people']='';
                                $pack['occation']=$inf->occation;
                                    $pack['select_date']=$inf->select_date;
                                  
                                    $pack['time']=date('H:i A',strtotime($info->from_time));
                                    $pack['to_time']=date('H:i A',strtotime($info->to_time));
                                    $pack['people']=$inf->no_of_people;
                                   // $pack['package_name']=$package_name;
                                    $pack['user_package_id']=$inf->sk_user_package_id;   
                                $temp1[]=$pack;
                                
                            }
                            $pack1['packagedetails']=$temp1;
                            $ret=$this->common->response(200,true,'Package Details are',$pack1);
                        }else{
                            $ret=$this->common->response(200,false,'No Data Available in Packages',array());
                        }

                    }else
                    if($this->input->server('REQUEST_METHOD') === 'POST'){
                        $params = array();
                        $occation=$birthday=$anniversary=$other_text=$select_date=$from_time=$to_time=$no_of_people=$package_id=$temp_package_status="";
                        $params = json_decode(@file_get_contents('php://input'),TRUE);
                        if(isset($params)) { 
                            if(isset($params['occation'])) {  $occation = $params['occation'];}
                            if(isset($params['other_text'])) { $other_text = $params['other_text'];} 
                            if(isset($params['select_date'])) { $select_date = $params['select_date'];} 
                            if(isset($params['from_time'])) {  $from_time = $params['from_time'];} 
                            if(isset($params['to_time'])) {  $to_time = $params['to_time'];} 
                            if(isset($params['no_of_people'])) {   $no_of_people = $params['no_of_people'];} 
                            if(isset($params['package_id'])) {   $package_id = $params['package_id'];} 
                            

                            if($occation!='' && $select_date!='' && $from_time!='' && $to_time!='' && $no_of_people!='' && $package_id!=''){
                                $where=array('user_id'=>$id,'temp_package_status'=>0);
                                $details=$this->cm->getRecords($where,'mlt_user_packages');
                                $where=array('cuser_id'=>$id,'party_time'=>1);
                                $cart_records=$this->cm->getRecords($where,'mlt_cart');
                                if($cart_records!=false){
                                    $this->cm->deleteRecords($where,'mlt_cart');
                                }
                                $where19=array('sk_package_id'=>$package_id);
                                $pack=$this->cm->getRecords($where19,'mlt_package');
                                $total_package_amount=$package_amount=0;
                                if($pack!=false){
                                foreach($pack as $info29){
                                    $package_amount=$info29->package_amount;
                                }
                                $total_package_amount=$package_amount*$no_of_people;
                                }
                                if($details!=false){
                                $saveData = array(
                                    'occation'=>$occation,
                                    'other_text'=>$other_text,
                                    'total_package_amount'=>$total_package_amount,
                                    'select_date'=>$select_date,
                                    'from_time'=>$from_time,
                                    'to_time'=>$to_time,
                                    'no_of_people'=>$no_of_people,
                                    'package_id'=>$package_id,
                                    'user_id'=>$id,
                                    'temp_package_status'=>'0'
                                     
                            );
                            $where=array('user_id'=>$id,'temp_package_status'=>0);
                            $user_package_id = $this->cm->updateRecords($saveData,$where,'mlt_user_packages'); 
                            $ret=$this->common->response(200,true,'Packages Saved Successfully',array());
                               
                            }else{
                                $saveData = array(
                                    'occation'=>$occation,
                                    'other_text'=>$other_text,
                                    'total_package_amount'=>$total_package_amount,
                                    'select_date'=>$select_date,
                                    'from_time'=>$from_time,
                                    'to_time'=>$to_time,
                                    'no_of_people'=>$no_of_people,
                                    'package_id'=>$package_id,
                                    'user_id'=>$id,
                                    'temp_package_status'=>'0'
                                     
                            );
                            $user_package_id = $this->cm->save($saveData,'mlt_user_packages'); 
                        if($user_package_id!=0) {
                            
                                    $ret=$this->common->response(200,true,'Packages Saved Successfully',array());
                                }
                             
                            }
        
                        }              
                    else{
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }
        }
        }else if($this->input->server('REQUEST_METHOD') === 'PUT'){
            $params = array();
            $operation=$occation=$birthday=$anniversary=$other_text=$select_date=$from_time=$to_time=$no_of_people=$package_id=$temp_package_status="";
            $params = json_decode(@file_get_contents('php://input'),TRUE);
            if(isset($params)) { 
                if(isset($params['occation'])) { $occation = $params['occation'];}
                if(isset($params['sk_user_package_id'])) { $sk_user_package_id = $params['sk_user_package_id'];}
                if(isset($params['other_text'])) { $other_text = $params['other_text'];} 
                if(isset($params['select_date'])) { $select_date = $params['select_date'];} 
                if(isset($params['from_time'])) {  $from_time = $params['from_time'];} 
                if(isset($params['to_time'])) {  $to_time = $params['to_time'];} 
                if(isset($params['no_of_people'])) {  $no_of_people = $params['no_of_people'];} 
                if(isset($params['package_id'])) {  $package_id = $params['package_id'];} 
                if(isset($params['operation'])) {  $operation = $params['operation'];} 
                if($sk_user_package_id!='' && $operation=='update'){
                $saveData = array(
                    'occation'=>$occation,
                    'other_text'=>$other_text,
                    'select_date'=>$select_date,
                    'from_time'=>$from_time,
                    'to_time'=>$to_time,
                    'no_of_people'=>$no_of_people,
                    'package_id'=>$package_id,
                    'user_id'=>$id,
                    'temp_package_status'=>'0'
            );
            $where=array('cuser_id'=>$id,'party_time'=>1);
            $cart_records=$this->cm->getRecords($where,'mlt_cart');
            if($cart_records!=false){
                $this->cm->deleteRecords($where,'mlt_cart');
            }
            $where=array('sk_user_package_id'=>$sk_user_package_id);
            $this->cm->updateRecords($saveData,$where,'mlt_user_packages'); 
                    $ret=$this->common->response(200,true,'Packages Updated Successfully',array());
                }else{
                    $ret=$this->common->response(200,false,'Please Check Input',array()); 
                }
    
                }else{
                    $ret=$this->common->response(400,false,'Please Check Input',array());
                }
            }
                else{
                    $ret=$this->common->response(400,false,'method is wrong',$data);
                }
            }else{
                $ret=$this->common->response(400,false,'User is not existed',$data);
    
            }
                    
        }catch(Exception $e){

        $ret=$this->common->response(400, false, 'Invalid Access Token', array());
        }
        }               
      
    else{

        $ret=$this->common->response(400,false,'Invalid Access Token - Please check access both key and value1',new stdClass());
    }echo json_encode($ret);


}



    public function party_time_items(){
        $this->access_control();
        $access_token = $temp_session_id=false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['temp_session_id'])) { $temp_session_id = $row['temp_session_id']; }
        $data=array();$ret=array();$party_time=array();
        if($access_token!=globalAccessToken)
            {
                try{
                    $id=JWT::decode($access_token,pkey);
                        $where=array('sk_user_id'=>$id,'user_status'=>1);
                        $userExists=$this->cm->getRecords($where,'mst_user');
                        if($userExists!=false){
                            if($this->input->server('REQUEST_METHOD') === 'GET'){
                                $where=array('temp_package_status'=>0,'user_id'=>$id);  
                                $package_details=$this->cm->getRecords($where,'mlt_user_packages');
                                $output='';$package_name=$price= $item_size="";      $output1=$output2=$output9='';
                                $sides_count=$pizza_count=$salads_count=$drinks_count=$desserts_count=$dips_count='0';
                                $sides_id=$pizza_id=$salads_id=$drinks_id=$desserts_id=$dips_id=null;
                                if($package_details!=false){
                                  foreach($package_details as $info){
                                    $where=array('sk_package_id'=>$info->package_id);
                                    $package_full=$this->cm->getRecords($where,'mlt_package');
                                    $count=count($package_full);
                                    $inValue = array();
                                    if($package_full!=false){
                                      foreach($package_full as $info2){
                                        $package_name=$info2->package_name;
                                     //   $package_amount=$info2->package_amount;

                                        if($info2->pizza_id!=NULL){
                                          $pizza_id = $info2->pizza_id;
                                          $inValue[] = $info2->pizza_id;

                                          $pizza_count = $info2->no_of_pizza;
                                        }
                                        if($info2->sides_id!=NULL){
                                          $sides_id = $info2->sides_id;
                                          $inValue[] = $info2->sides_id;

                                          $sides_count = $info2->no_of_sides;
                                        }
                                        if($info2->salads_id!=NULL){
                                          $salads_id = $info2->salads_id;
                                          $inValue[] = $info2->salads_id;

                                          $salads_count = $info2->no_of_salads;

                                        }
                                        if($info2->drinks_id!=''){
                                          $drinks_id = $info2->drinks_id;
                                          $inValue[] = $info2->drinks_id;

                                          $drinks_count = $info2->no_of_drinks;
                                        }
                                        if($info2->desserts_id!=NULL){
                                          $desserts_id= $info2->desserts_id;
                                          $inValue[] = $info2->desserts_id;

                                          $desserts_count = $info2->no_of_desserts;

                                        }
                                        if($info2->dips_id!=NULL){
                                          $dips_id = $info2->dips_id;
                                          $inValue[] = $info2->dips_id;

                                          $dips_count = $info2->no_of_dips;

                                        }
                                      }
                                    }
                                    $inValueString = '';
                                    $inValueString = implode(",",$inValue);
                                    $package['occation']=$info->occation;
                                    $package['other']='';
                                    if($info->other_text!=null){
                                        $package['other']=$info->other_text;
                                    }
                                    $package['select_date']=$info->select_date;
                                    $package['time']=date('H:i A',strtotime($info->from_time)).'-'.date('H:i A',strtotime($info->to_time));
                                    $package['people']=$info->no_of_people;
                                    $package['package_name']=$package_name;   
                                    $package['package_amount']=$info->total_package_amount;   
                                    $package['sk_user_package_id']=$info->sk_user_package_id;   
                                    $package['temp_package_status']=$info->temp_package_status;                     
                                $slug=$categoryDetails=$categoryIdDetails=$categoryid='';
                                $q='';
                                if($inValueString!='')
                                  //$q= "where sk_categoryItems_id in($inValueString)";
                                 $sql="SELECT * FROM mst_categoryitems";
                               $binds="";
                               $category_details1=$this->cm->getRecordsQuery($sql, $binds);
                                if($slug==''){
                                $slug=$category_details1[0]->category_slug;
                                }
                                $where1=array('cuser_id'=>$id,'party_time'=>0);
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
                                $package['quantity']  =$quantity;
                                $package['cart_price']=$cart_price;   
                                $package['items']=$i;

                                if($category_details1!=false){
                                   // $categoryTypeInfo=array();
                          $m=1;
                                    foreach($category_details1 as $info1)
                            {
                                $categoryTypeInfo['count']=0;
                                $temp=array();
                                $count=0;

                                        $categoryTypeInfo=array();

                                        $categoryTypeInfo['category_id']=$info1->sk_categoryItems_id;
                                        $categoryTypeInfo['total_count']="0";
                                        $category_id=$categoryTypeInfo['category_id'];
                                        $categoryTypeInfo['slug']=$info1->category_slug;
                                        $slug2=$info1->category_slug;
                                        if($pizza_id==$info1->sk_categoryItems_id){
                                             $categoryTypeInfo['total_count']=$pizza_count;
    
                                        }  if($dips_id==$info1->sk_categoryItems_id){
                                             $categoryTypeInfo['total_count']=$dips_count;
    
                                        } if($desserts_id==$info1->sk_categoryItems_id){
                                             $categoryTypeInfo['total_count']=$desserts_count;
    
                                        }  if($drinks_id==$info1->sk_categoryItems_id){
                                             $categoryTypeInfo['total_count']=$drinks_count;
    
                                        }  if($salads_id==$info1->sk_categoryItems_id){
                                             $categoryTypeInfo['total_count']=$salads_count;
    
                                        } if($sides_id==$info1->sk_categoryItems_id) {
                                             $categoryTypeInfo['total_count']=$sides_count;
                                        }
                                        
                                        $categoryTypeInfo['image']=$info1->category_image;
                                        $categoryTypeInfo['captions']=$info1->caption;
                                        $categoryTypeInfo['category_type']=$info1->Items_categoryname;
                                        $categoryTypeInfo['item_details']=array();
                                        $categoryTypeInfo['count']=0;
                                        
                          if(in_array($category_id,$inValue)){
                                $sql="SELECT mst_categoryitems.Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems.category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type,mlt_items_onboarding.slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id WHERE category_id=$category_id and item_onboarding_status=1";
                                $binds="";
                                $base_details=$price_details=array();
                                $category_details=$this->cm->getRecordsQuery($sql, $binds);
                                if ($category_details) {
                                    $temp20=array();
                                    foreach($category_details as $info){
                                        $temp20=array();
                                    $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                    $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']='';
                                    $items['no_of_count']=0;
                                    $items['description']=$items['type']=$items['section_name']="";
                                     $items['base_drop']=$items['price_drop']=array();
                                     $items['item_name']=$info->item_name;
                                     $items['item_id']=$info->sk_id;
                                     $items['slug1']=$info1->category_slug;
                                     $i=0;
                                     $where=array('citem_id'=>$info->sk_id,'cstatus'=>1,'party_time'=>1,'cuser_id'=>$id);
                                     $cart_details_by_id=$this->cm->getRecords($where,'mlt_cart');
                                     if($cart_details_by_id!=false){
                                         foreach($cart_details_by_id as $rows){
                                             $items['no_of_count']=(int)$rows->quantity;
                                         }
                                         $i++;
                                         $count=$i+$count;
                                     }
                                     
                                    
                                     $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                                     $price_details=$this->cm->getRecords($where,'mlt_price');
                                     $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                                     $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                                     if($base_details!=false){
                                         foreach($base_details as $info10){
                                             $base=explode(',',$info10->items);
                                             if(!empty($base)){
                                                 for($k=0;$k<sizeof($base);$k++){
                                                     $base1['base_string']=$base[$k];
                                                     $temp20[]=$base1;
                                                 }
                                             }
                                             $items['base_drop']=$temp20;
                                         }
                                     }
                                     if($price_details!=false && $items['slug1']=='pizzas'){
                                         $items['price_drop']=$price_details;

                                     }
                                     $price="";
                                     if($price_details!=false){
                                         foreach($price_details as $row3){
                                               $price=$row3->item_cost;
                     
                                         }
                                     }
                                     $where=array('item_id'=>$info->sk_id,'user_id'=>$id);
                                     $favorites=$this->cm->getRecords($where,'mst_favourite');
                                     if($favorites!=false){
                                         $items['favour']=true;
                                     }else{
                                         $items['favour']=false;
                                     }
                                      $items['price']=$price;
                                     $items['image']=admin_img_url.'/items/'.$info->image;
                                     $items['display_name']=$info->display_name;
                                     $items['item_status']=$info->item_onboarding_status;
                                     $items['description']=$info->short_description;
                                     // $items['seo_description']=$info->seo_description;
                                     // $items['seo_title']=$info->seo_title;
                                     $items['short_description']=$info->description;
                                     $items['type']=$info->type;
                                     $items['section_name']=$info->section_name;

                                     $temp[]=$items;
                                 }
                                 $categoryTypeInfo['item_details']=$temp;
                                 $categoryTypeInfo['count']=$count;

                           }
                        }
                        
                                $temp4[]=$categoryTypeInfo;
                        
                            }
                        }
                        $package['category_details']=$temp4;
                    }
                    $ret=$this->common->response(200,true,'packages',$package);
            }else{
                $ret=$this->common->response(400,false,'No data available',array());

            }
            }else{
                $ret=$this->common->response(400,false,'Method is Wrong',array());
            }
        }
        
                            else{
                                $ret=$this->common->response(400,false,'User is not existed',$data);
                            }
                }catch(Exception $e){
        
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
        }
        } else
            if($access_token==globalAccessToken)
            {
                
                try{
                    if($temp_session_id!=''){
                    $id=JWT::decode($temp_session_id,pkey);                        
                    if($this->input->server('REQUEST_METHOD') === 'GET'){
                        $where=array('temp_package_status'=>0,'user_id'=>$id);  
                        $package_details=$this->cm->getRecords($where,'mlt_user_packages');
                        $output='';$package_name=$price= $item_size="";      $output1=$output2=$output9='';
                        $sides_count=$pizza_count=$salads_count=$drinks_count=$desserts_count=$dips_count='0';
                        $sides_id=$pizza_id=$salads_id=$drinks_id=$desserts_id=$dips_id=null;
                        if($package_details!=false){
                          foreach($package_details as $info){
                            $where=array('sk_package_id'=>$info->package_id);
                            $package_full=$this->cm->getRecords($where,'mlt_package');
                            $count=count($package_full);
                            $inValue = array();
                            if($package_full!=false){
                              foreach($package_full as $info2){
                                $package_name=$info2->package_name;
                                $package_amount=$info2->package_amount;

                                if($info2->pizza_id!=NULL){
                                  $pizza_id = $info2->pizza_id;
                                  $inValue[] = $info2->pizza_id;

                                  $pizza_count = $info2->no_of_pizza;
                                }
                                if($info2->sides_id!=NULL){
                                  $sides_id = $info2->sides_id;
                                  $inValue[] = $info2->sides_id;

                                  $sides_count = $info2->no_of_sides;
                                }
                                if($info2->salads_id!=NULL){
                                  $salads_id = $info2->salads_id;
                                  $inValue[] = $info2->salads_id;

                                  $salads_count = $info2->no_of_salads;

                                }
                                if($info2->drinks_id!=''){
                                  $drinks_id = $info2->drinks_id;
                                  $inValue[] = $info2->drinks_id;

                                  $drinks_count = $info2->no_of_drinks;
                                }
                                if($info2->desserts_id!=NULL){
                                  $desserts_id= $info2->desserts_id;
                                  $inValue[] = $info2->desserts_id;

                                  $desserts_count = $info2->no_of_desserts;

                                }
                                if($info2->dips_id!=NULL){
                                  $dips_id = $info2->dips_id;
                                  $inValue[] = $info2->dips_id;

                                  $dips_count = $info2->no_of_dips;

                                }
                              }
                           }
                            $inValueString = '';
                            $inValueString = implode(",",$inValue);
                            $package['occation']=$info->occation;
                            $package['select_date']=$info->select_date;
                            $package['time']=date('H:i A',strtotime($info->from_time)).'-'.date('H:i A',strtotime($info->to_time));
                            $package['people']=$info->no_of_people;
                            $package['package_name']=$package_name;            
                                       
                        
                      
                        $slug=$categoryDetails=$categoryIdDetails=$categoryid='';
                        $q='';
                        if($inValueString!='')
                        //   $q= "where sk_categoryItems_id in($inValueString)";
                         $sql="SELECT * FROM mst_categoryitems $q";
                       $binds="";
                       $category_details1=$this->cm->getRecordsQuery($sql, $binds);
                       
                        if($slug==''){
                        $slug=$category_details1[0]->category_slug;
                        }
                        $where1=array('cuser_id'=>$id,'party_time'=>0);
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
                        $package['quantity']  =$quantity;
                        $package['cart_price']=$cart_price;   
                        $package['items']=$i;
                        if($category_details1){
                           // $categoryTypeInfo=array();
                  $m=1;
                            foreach($category_details1 as $info1)
                    {
                        $temp=array();
                                $categoryTypeInfo=array();
                                $categoryTypeInfo['category_id']=$info1->sk_categoryItems_id;
                                $category_id=$categoryTypeInfo['category_id'];
                                $categoryTypeInfo['slug']=$info1->category_slug;
                                $slug2=$info1->category_slug;
                                if($pizza_id==$info1->sk_categoryItems_id){
                                    $categoryTypeInfo['no_of_pizzas']=$pizza_count;

                                } else if($dips_id==$info1->sk_categoryItems_id){
                                    $categoryTypeInfo['no_of_dips']=$dips_count;

                                } else if($desserts_id==$info1->sk_categoryItems_id){
                                    $categoryTypeInfo['no_of_desserts']=$desserts_count;

                                } else if($drinks_id==$info1->sk_categoryItems_id){
                                    $categoryTypeInfo['no_of_drinks']=$drinks_count;

                                } else if($salads_id==$info1->sk_categoryItems_id){
                                    $categoryTypeInfo['no_of_salads']=$salads_count;

                                }else {
                                    $categoryTypeInfo['no_of_sides']=$sides_count;

                                }
                                $categoryTypeInfo['image']=$info1->category_image;
                                $categoryTypeInfo['captions']=$info1->caption;
                                $categoryTypeInfo['category_type']=$info1->Items_categoryname;
                                $categoryTypeInfo['item_details']=array();  
                                if(in_array($category_id,$inValue)){
          
                        $sql="SELECT mst_categoryitems.Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems.category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type,mlt_items_onboarding.slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id WHERE category_id=$category_id and item_onboarding_status=1";
                        $binds="";
                        $base_details=$price_details=array();
                        $category_details=$this->cm->getRecordsQuery($sql, $binds);
                        if ($category_details) {
                            $temp20=array();
                            foreach($category_details as $info){
                                $temp20=array();
                            $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                            $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']="";
                            $items['no_of_count']=0;
                            $items['description']=$items['type']=$items['section_name']="";
                             $items=array();
                             $items['base_drop']=$items['price_drop']=array();
                             $items['item_name']=$info->item_name;
                             $items['item_id']=$info->sk_id;
                             $items['slug1']=$info1->category_slug;
                             $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                             $price_details=$this->cm->getRecords($where,'mlt_price');
                             $where=array('citem_id'=>$info->sk_id,'cstatus'=>1,'party_time'=>1,'cuser_id'=>$id);
                             $cart_details_by_id=$this->cm->getRecords($where,'mlt_cart');
                             if($cart_details_by_id!=false){
                                foreach($cart_details_by_id as $rows){
                                    $items['no_of_count']=(int)$rows->quantity;
                                }
                            }                             $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                             $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                             if($base_details!=false){
                                 foreach($base_details as $info10){
                                     $base=explode(',',$info10->items);
                                     if(!empty($base)){
                                         for($k=0;$k<sizeof($base);$k++){
                                             $base1['base_string']=$base[$k];
                                             $temp20[]=$base1;
                                         }
                                     }
                                     $items['base_drop']=$temp20;
                                 }
                             }
                             if($price_details!=false && $items['slug1']=='pizzas'){
                                 $items['price_drop']=$price_details;
                             }
                             $price="";
                             if($price_details!=false){
                                 foreach($price_details as $row3){
                                       $price=$row3->item_cost;
                                 }
                             }
                             $where=array('item_id'=>$info->sk_id,'user_id'=>$id);
                             $favorites=$this->cm->getRecords($where,'mst_favourite');
                             if($favorites!=false){
                                 $items['favour']=true;
                             }else{
                                 $items['favour']=false;
                             }
                              $items['price']=$price;
                             $items['image']=admin_img_url.'/items/'.$info->image;
                             $items['display_name']=$info->display_name;
                             $items['item_status']=$info->item_onboarding_status;
                             $items['description']=$info->short_description;
                             // $items['seo_description']=$info->seo_description;
                             // $items['seo_title']=$info->seo_title;
                             $items['short_description']=$info->description;
                             $items['type']=$info->type;
                             $items['section_name']=$info->section_name;
                             $temp[]=$items;
                         }
                         $categoryTypeInfo['item_details']=$temp;
                         $categoryTypeInfo['count']=$count;

                   }
                }
                

                        $temp4[]=$categoryTypeInfo;
            }
        }   
                
                $package['category_details']=$temp4;
            }
            $ret=$this->common->response(200,true,'packages',$package);
    }else{
        $ret=$this->common->response(400,false,'No data available',array());
    }
    }else{
        $ret=$this->common->response(400,false,'Method is Wrong',array());
    } 
}               
}catch(Exception $e){
       $ret=$this->common->response(400, false, 'Invalid Access Token', array());
        }
        }
        else{
            $ret=$this->common->response(400,false,'Invalid Access Token - Please check access both key and value1',new stdClass());
        }echo json_encode($ret);   
    }






    public function party_time_cart(){

        $this->access_control();
        $access_token = $temp_session_id=false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['temp_session_id'])) { $temp_session_id = $row['temp_session_id']; }
        $data=array();$ret=array();$party_time=array();
        if($access_token!=globalAccessToken)
            {
                try{
                    $id=JWT::decode($access_token,pkey);
                        $where=array('sk_user_id'=>$id,'user_status'=>1);
                        $userExists=$this->cm->getRecords($where,'mst_user');
                        if($userExists!=false){
        
                            if($this->input->server('REQUEST_METHOD') === 'GET'){
                                $where=array('temp_package_status'=>0,'user_id'=>$id);  
                                $package_details=$this->cm->getRecords($where,'mlt_user_packages');
                                $output='';$package_name=$price= $item_size="";      $output1=$output2=$output9='';
                                $sides_count=$pizza_count=$salads_count=$drinks_count=$desserts_count=$dips_count='';
                                $sides_id=$pizza_id=$salads_id=$drinks_id=$desserts_id=$dips_id=null;
                                if($package_details!=false){
                                  foreach($package_details as $info){
                                    $where=array('sk_package_id'=>$info->package_id);
                                    $package_amount=$info->total_package_amount;
                                    $package_full=$this->cm->getRecords($where,'mlt_package');
                                    $count=count($package_full);
                                    $inValue = array();
                                    if($package_full!=false){
                                      foreach($package_full as $info2){
                                        $package_name=$info2->package_name;

                                        if($info2->pizza_id!=NULL){
                                          $pizza_id = $info2->pizza_id;
                                          $inValue[] = $info2->pizza_id;

                                          $pizza_count = $info2->no_of_pizza;
                                        }
                                        if($info2->sides_id!=NULL){
                                          $sides_id = $info2->sides_id;
                                          $inValue[] = $info2->sides_id;

                                          $sides_count = $info2->no_of_sides;
                                        }
                                        if($info2->salads_id!=NULL){
                                          $salads_id = $info2->salads_id;
                                          $inValue[] = $info2->salads_id;

                                          $salads_count = $info2->no_of_salads;

                                        }
                                        if($info2->drinks_id!=''){
                                          $drinks_id = $info2->drinks_id;
                                          $inValue[] = $info2->drinks_id;

                                          $drinks_count = $info2->no_of_drinks;
                                        }
                                        if($info2->desserts_id!=NULL){
                                          $desserts_id= $info2->desserts_id;
                                          $inValue[] = $info2->desserts_id;

                                          $desserts_count = $info2->no_of_desserts;

                                        }
                                        if($info2->dips_id!=NULL){
                                          $dips_id = $info2->dips_id;
                                          $inValue[] = $info2->dips_id;

                                          $dips_count = $info2->no_of_dips;

                                        }
                                      }
                                    }
                                    $inValueString = '';
                                    $inValueString = implode(",",$inValue);
                                    $package['occation']=$info->occation;
                                    $package['other']=$info->other_text;
                                    $package['temp_package_status']=$info->temp_package_status;
                                    $package['sk_user_package_id']=$info->sk_user_package_id;
                                    $package['package_amount']=$info->total_package_amount;   
                                    $package['select_date']=$info->select_date;
                                    $package['time']=date('H:i A',strtotime($info->from_time)).'-'.date('H:i A',strtotime($info->to_time));
                                    $package['people']=$info->no_of_people;
                                    $package['package_name']=$package_name;            
                                               
                                


                                    
                              
                                $slug=$categoryDetails=$categoryIdDetails=$categoryid='';
                                $q='';
                                if($inValueString!='')
                                //   $q= "where sk_categoryItems_id in($inValueString)";
                                 $sql="SELECT * FROM mst_categoryitems $q";
                               $binds="";
                               $category_details1=$this->cm->getRecordsQuery($sql, $binds);
                               
                                if($slug==''){
                                $slug=$category_details1[0]->category_slug;
                                }
                                $where1=array('cuser_id'=>$id,'party_time'=>0);
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
                                $package['quantity']  =$quantity;
                                $package['cart_price']=$cart_price;   
                                $package['items']=$i;

                                 if($category_details1!=false){
                                   // $categoryTypeInfo=array();
                                   
                          $m=1;
                                    foreach($category_details1 as $info1)
                            {
                                $temp=array();
                                        $categoryTypeInfo=array();
                                        $categoryTypeInfo['category_id']=$info1->sk_categoryItems_id;
                                        $category_id=$categoryTypeInfo['category_id'];
                                       
                                        $categoryTypeInfo['slug']=$info1->category_slug;
                                        $slug2=$info1->category_slug;
                                        
                                        $categoryTypeInfo['image']=$info1->category_image;
                                        $categoryTypeInfo['captions']=$info1->caption;
                                        $categoryTypeInfo['category_type']=$info1->Items_categoryname;
                                        $categoryTypeInfo['item_details']=array();
                                       
                                if(in_array($category_id,$inValue)){
                                $sql="SELECT mlt_cart.quantity,mlt_cart.customization,mlt_cart.price,mlt_cart.item_size,mlt_cart.citem_id, mst_categoryitems .Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems. category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type, mlt_items_onboarding.slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id JOIN mlt_cart on mlt_cart.citem_id=mlt_items_onboarding.sk_id WHERE category_id=$category_id and item_onboarding_status=1 and cuser_id=$id and party_time='1'";
                                $binds="";
                                
                                $base_details=$price_details=array();
                                $category_details=$this->cm->getRecordsQuery($sql, $binds);
                                if ($category_details) {
                                    
                                    if($pizza_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_pizzas']=count($category_details);

                                    } else if($dips_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_dips']=count($category_details);;

                                    } else if($desserts_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_desserts']=count($category_details);;

                                    } else if($drinks_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_drinks']=count($category_details);;

                                    } else if($salads_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_salads']=count($category_details);;

                                    }else {
                                        $categoryTypeInfo['no_of_sides']=count($category_details);;

                                    }
                                    $temp20=array();
                                    foreach($category_details as $info){
                                        $temp20=array();
                                    $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                    $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']='';
                                    $items['no_of_count']=0;
                                    $items['description']=$items['type']=$items['section_name']="";
                                     $items['base_drop']=$items['price_drop']=array();
                                      $items['item_name']=$info->item_name;
                                     $items['item_id']=$info->sk_id;
                                     $items['slug1']=$info1->category_slug;
                                     $where=array('citem_id'=>$info->sk_id,'cstatus'=>1,'party_time'=>1,'cuser_id'=>$id);
                                     $cart_details_by_id=$this->cm->getRecords($where,'mlt_cart');
                                     if($cart_details_by_id!=false){
                                         foreach($cart_details_by_id as $rows){
                                             $items['no_of_count']=(int)$rows->quantity;
                                         }
                                     }

                                     $custom=json_decode($info->customization);
                                     $output4=array();$output7=$output8=$output9=$output10=array();
                                     if($custom->veg){
                                         foreach($custom->veg as $info4){
                                            $output4[]=$info4;
                                         }
                                     }
                                     if($custom->nonveg){
                                         foreach($custom->nonveg as $info4){
                                             $output7[]=$info4;
                                         }
                                     }if($custom->flavor){
                                         foreach($custom->flavor as $info4){
                                             $output8[]=$info4;
                                         }
                                     }if($custom->base){
                                         foreach($custom->base as $info4){
                                             $output9[]=$info4;
                                         }
                                     }if($custom->size){
                                         foreach($custom->size as $info4){
                                             $output10[]=$info4;
                                         }
                                     }
                                     $output25=implode(',',$output4);
                                     $output26=implode(',',$output7);
                                     $output27=implode(',',$output8);
                                     $output28=implode(',',$output9);
                                     $output29=implode(',',$output10);

                                    $cart['veg']=$output25;
                                    $cart['non_veg']=$output26;
                                    $cart['flavour']=$output27;
                                    $cart['base1']=$output28; 
                                    $cart['size']=$output29; 

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
            
                                    $output6=implode(',',$output6);
                                    $items['customization']='';
                                    $items['customization']=$output6;
                                     $items['quantity']=(int)$info->quantity;
                                     //$cart['price']=$info->price;
                                     $items['item_size']=$info->item_size;
                                    // $cart['base']=$info->base;
                                    
                                     $where=array('item_id'=>$info->sk_id,'user_id'=>$id);
                                     $favorites=$this->cm->getRecords($where,'mst_favourite');
                                     if($favorites!=false){
                                         $items['favour']=true;
                                     }else{
                                         $items['favour']=false;
                                     }
                                     
                                      $items['price']=$price;
                                     $items['image']=admin_img_url.'/items/'.$info->image;
                                     $items['display_name']=$info->display_name;
                                     $items['item_status']=$info->item_onboarding_status;
                                     $items['description']=$info->short_description;
                                     // $items['seo_description']=$info->seo_description;
                                     // $items['seo_title']=$info->seo_title;
                                     $items['short_description']=$info->description;
                                     $items['type']=$info->type;
                                     $items['section_name']=$info->section_name;

                                     $temp[]=$items;
                                 }
                                 $categoryTypeInfo['item_details']=$temp;
                           }
                        }
                                
                                $temp4[]=$categoryTypeInfo;
                         
                        }
                    }
                        $package['category_details']=$temp4;
                    }
                    $ret=$this->common->response(200,true,'packages',$package);
            }else{
                $ret=$this->common->response(400,false,'No data available',array());

            }
            }else{
                $ret=$this->common->response(400,false,'Method is Wrong',array());
            }
        }
        
                            else{
                                $ret=$this->common->response(400,false,'User is not existed',$data);
                            }
                }catch(Exception $e){
        
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
        }
        } else
            if($access_token==globalAccessToken)
            {
                
                try{
                    if($temp_session_id!=''){
                    $id=JWT::decode($temp_session_id,pkey);    
                    
                    if($this->input->server('REQUEST_METHOD') === 'GET'){

                    $where=array('temp_package_status'=>0,'user_id'=>$id);  
                                $package_details=$this->cm->getRecords($where,'mlt_user_packages');
                                $output='';$package_name=$price= $item_size="";      $output1=$output2=$output9='';
                                $sides_count=$pizza_count=$salads_count=$drinks_count=$desserts_count=$dips_count='';
                                $sides_id=$pizza_id=$salads_id=$drinks_id=$desserts_id=$dips_id=null;
                                if($package_details!=false){
                                  foreach($package_details as $info){
                                    $where=array('sk_package_id'=>$info->package_id);
                                    $package_full=$this->cm->getRecords($where,'mlt_package');
                                    $count=count($package_full);
                                    $inValue = array();
                                    if($package_full!=false){
                                      foreach($package_full as $info2){
                                        $package_name=$info2->package_name;
                                        $package_amount=$info2->package_amount;

                                        if($info2->pizza_id!=NULL){
                                          $pizza_id = $info2->pizza_id;
                                          $inValue[] = $info2->pizza_id;

                                          $pizza_count = $info2->no_of_pizza;
                                        }
                                        if($info2->sides_id!=NULL){
                                          $sides_id = $info2->sides_id;
                                          $inValue[] = $info2->sides_id;

                                          $sides_count = $info2->no_of_sides;
                                        }
                                        if($info2->salads_id!=NULL){
                                          $salads_id = $info2->salads_id;
                                          $inValue[] = $info2->salads_id;

                                          $salads_count = $info2->no_of_salads;

                                        }
                                        if($info2->drinks_id!=''){
                                          $drinks_id = $info2->drinks_id;
                                          $inValue[] = $info2->drinks_id;

                                          $drinks_count = $info2->no_of_drinks;
                                        }
                                        if($info2->desserts_id!=NULL){
                                          $desserts_id= $info2->desserts_id;
                                          $inValue[] = $info2->desserts_id;

                                          $desserts_count = $info2->no_of_desserts;

                                        }
                                        if($info2->dips_id!=NULL){
                                          $dips_id = $info2->dips_id;
                                          $inValue[] = $info2->dips_id;

                                          $dips_count = $info2->no_of_dips;

                                        }
                                      }
                                    }
                                    $inValueString = '';
                                    $inValueString = implode(",",$inValue);
                                    $package['occation']=$info->occation;
                                    $package['package_amount']=$package_amount;

                                    $package['select_date']=$info->select_date;
                                    $package['time']=date('H:i A',strtotime($info->from_time)).'-'.date('H:i A',strtotime($info->to_time));
                                    $package['people']=$info->no_of_people;
                                    $package['package_name']=$package_name;            
                                               
                                    
                              
                                $slug=$categoryDetails=$categoryIdDetails=$categoryid='';
                                $q='';
                                if($inValueString!='')
                                //   $q= "where sk_categoryItems_id in($inValueString)";
                                 $sql="SELECT * FROM mst_categoryitems $q";
                               $binds="";
                               $category_details1=$this->cm->getRecordsQuery($sql, $binds);
                               
                                if($slug==''){
                                $slug=$category_details1[0]->category_slug;
                                }
                                $where1=array('cuser_id'=>$id,'party_time'=>0);
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
                                $package['quantity']  =$quantity;
                                $package['cart_price']=$cart_price;   
                                $package['items']=$i;
                                if($category_details1!=false){
                                   // $categoryTypeInfo=array();
                                   
                          $m=1;
                                    foreach($category_details1 as $info1)
                            {
                                $temp=array();
                                        $categoryTypeInfo=array();
                                        $categoryTypeInfo['category_id']=$info1->sk_categoryItems_id;
                                        $category_id=$categoryTypeInfo['category_id'];
                                       
                                        $categoryTypeInfo['slug']=$info1->category_slug;
                                        $slug2=$info1->category_slug;
                                        
                                        $categoryTypeInfo['image']=$info1->category_image;
                                        $categoryTypeInfo['captions']=$info1->caption;
                                        $categoryTypeInfo['category_type']=$info1->Items_categoryname;
                                        $categoryTypeInfo['item_details']=array();
                                        
                                if(in_array($category_id,$inValue)){
                                $sql="SELECT mst_categoryitems .Items_categoryname,mst_categoryitems.sk_categoryItems_id,mst_categoryitems. category_image,mlt_items_onboarding.sk_id,mlt_items_onboarding.section_name,mlt_items_onboarding.type, mlt_items_onboarding.slug,mlt_items_onboarding.item_name,mlt_items_onboarding.display_name,mlt_items_onboarding.short_description,mlt_items_onboarding.description,mlt_items_onboarding.seo_title,mlt_items_onboarding.seo_description,mlt_items_onboarding.date_time,mlt_items_onboarding.item_onboarding_status,mlt_items_onboarding.image FROM mlt_items_onboarding JOIN mst_categoryitems on mst_categoryitems.sk_categoryItems_id=mlt_items_onboarding.category_id JOIN mlt_cart on mlt_cart.citem_id=mlt_items_onboarding.sk_id WHERE category_id=$category_id and item_onboarding_status=1 and cuser_id=$id and party_time='1'";
                                $binds="";
                                
                                $base_details=$price_details=array();
                                $category_details=$this->cm->getRecordsQuery($sql, $binds);
                                if ($category_details) {
                                    
                                    if($pizza_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_pizzas']=count($category_details);

                                    } else if($dips_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_dips']=count($category_details);;

                                    } else if($desserts_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_desserts']=count($category_details);;

                                    } else if($drinks_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_drinks']=count($category_details);;

                                    } else if($salads_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_salads']=count($category_details);;

                                    }else {
                                        $categoryTypeInfo['no_of_sides']=count($category_details);;

                                    }
                                    $temp20=array();
                                    foreach($category_details as $info){
                                        $temp20=array();
                                    $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                    $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']='';
                                    $items['no_of_count']=0;
                                    $items['description']=$items['type']=$items['section_name']="";
                                     $items['base_drop']=$items['price_drop']=array();
                                      $items['item_name']=$info->item_name;
                                     $items['item_id']=$info->sk_id;
                                     $items['slug1']=$info1->category_slug;
                                     $where=array('citem_id'=>$info->sk_id,'cstatus'=>1,'party_time'=>1,'cuser_id'=>$id);
                                     $cart_details_by_id=$this->cm->getRecords($where,'mlt_cart');
                                     if($cart_details_by_id!=false){
                                         foreach($cart_details_by_id as $rows){
                                             $items['no_of_count']=(int)$rows->quantity;
                                         }
                                     }


                                     
                                     $where=array('item_id'=>$info->sk_id,'item_status'=>1);
                                     $price_details=$this->cm->getRecords($where,'mlt_price');
                                     $where=array('item_id'=>$info->sk_id,'topping_id'=>base1);
                                     $base_details=$this->cm->getRecords($where,'mlt_item_toppings');
                                     if($base_details!=false){
                                         foreach($base_details as $info10){
                                             $base=explode(',',$info10->items);
                                             if(!empty($base)){
                                                 for($k=0;$k<sizeof($base);$k++){
                                                     $base1['base_string']=$base[$k];
                                                     $temp20[]=$base1;
                                                 }
                                             }
                                             $items['base_drop']=$temp20;
                                         }
                                     }
                                     if($price_details!=false && $items['slug1']=='pizzas'){
                                         $items['price_drop']=$price_details;

                                     }
                                     $price="";
                                     if($price_details!=false){
                                         foreach($price_details as $row3){
                                               $price=$row3->item_cost;
                     
                                         }
                                     }
                                     $where=array('item_id'=>$info->sk_id,'user_id'=>$id);
                                     $favorites=$this->cm->getRecords($where,'mst_favourite');
                                     if($favorites!=false){
                                         $items['favour']=true;
                                     }else{
                                         $items['favour']=false;
                                     }
                                      $items['price']=$price;
                                     $items['image']=admin_img_url.'/items/'.$info->image;
                                     $items['display_name']=$info->display_name;
                                     $items['item_status']=$info->item_onboarding_status;
                                     $items['description']=$info->short_description;
                                     // $items['seo_description']=$info->seo_description;
                                     // $items['seo_title']=$info->seo_title;
                                     $items['short_description']=$info->description;
                                     $items['type']=$info->type;
                                     $items['section_name']=$info->section_name;

                                     $temp[]=$items;
                                 }
                                 $categoryTypeInfo['item_details']=$temp;
                           }
                        }
                                
                                $temp4[]=$categoryTypeInfo;
                         
                        }
                    }
                        $package['category_details']=$temp4;
                    }
                    $ret=$this->common->response(200,true,'packages',$package);
            }else{
                $ret=$this->common->response(400,false,'No data available',array());

            }
            }else{
                $ret=$this->common->response(400,false,'Method is Wrong',array());
            }
        }
}catch(Exception $e){
       $ret=$this->common->response(400, false, 'Invalid Access Token', array());
        }
        }
        else{
            $ret=$this->common->response(400,false,'Invalid Access Token - Please check access both key and value1',new stdClass());
        }echo json_encode($ret);  

    }

    public function tracking_order(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        $data=array();$ret=array();$address=array();
        if($access_token!=globalAccessToken)
        {
            
                    $order_id='';
                    if(isset($row['sk_order_id']))
                    {
                        if($row['sk_order_id']=="All")
                        {
                            $order_id  ="All";
                        }
                        else{
                            $order_id  = $row['sk_order_id'];
                        }
                    }
                    if($order_id=="All")
                    {
                        if($order_id=="All")
                        {
                            $where=array('sk_order_id'=>$order_id);
                        }
                    }
                    else
                    {
                        if($order_id=="All"){$where=array('sk_order_id'=>$order_id);}
                        else{$where=array('sk_order_id'=>$order_id);}
                    }
                    $tracking_details=$this->cm->getRecords($where,'mlt_order'); 
                    $tracking['riderPhone']= $tracking['trackingUrl']=$tracking['riderName']="";
                    if($tracking_details){
                        foreach($tracking_details as $tinfo){
                            $tracking['sk_order_id ']=$tinfo->sk_order_id;
                            if($tinfo->riderPhone!=null){
                            $tracking['riderPhone']=$tinfo->riderPhone;
                            }
                            if($tinfo->trackingUrl!=null){
                                $tracking['trackingUrl']="https://".$tinfo->trackingUrl;
                            }
                            if($tinfo->trackingUrl!=null){
                            $tracking['riderName']=$tinfo->riderName;
                            }
                             $track_order=$tinfo->order_status;
                                switch($track_order){
                                    case "CREATED":
                                        $tracking['order_status']=0;
                                        break;
                                    case "Accepted": 
                                        $tracking['order_status']=1;
                                        break;
                                    case "Preparation/Transit":
                                        $tracking['order_status']=2;
                                        break;
                                    case "Reached":
                                        $tracking['order_status']=3;
                                        break;
                                    case "Completed":
                                        $tracking['order_status']=4;
                                        break;
                                   
                                }
                            $temp[]=$tracking;
                        }
                        $tracking1['tracking_details']=$temp;
                        $ret=$this->common->response(200,true,'Tracking Details',$tracking1);
                }
                else{
                    $ret=$this->common->response(400,false,'No Data Available',new stdClass());
                }
            
            
        }
        else{
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
        }
        echo json_encode($ret);
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
        "templateId": "5505822050222080"
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
        public function notification(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;$temp_session_id='';
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['temp_session_id'])) { $temp_session_id = $row['temp_session_id']; }
        $data=array();$ret=array();$notification=array();
        if($access_token!=globalAccessToken)
        {
            try{
                $id=JWT::decode($access_token,pkey);
                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists!=false){

                $notification_id=$notification_status='';
                if(isset($row['sk_notification_id']))
                {
                    if($row['sk_notification_id']=="All")
                    {
                        $notification_id ="All";
                    }
                    else{
                        $notification_id = $row['sk_notification_id'];
                    }
                }
                if(isset($row['notification_status']))
                {
                    if($row['notification_status']=="All")
                    {
                        $notification_status ="All";
                    }
                    else
                    {
                        $notification_status = $row['notification_status'];
                    }
                }
                if($notification_id=="All")
                {
                    if($notification_status=="All")
                    {
                        $where=array('user_id'=>$id);
                    }
                    else
                    {
                        $where=array("notification_status"=>$notification_status,'user_id'=>$id);
                    }						
                }else
                {
                    if($notification_status=="All"){$where=array('sk_notification_id'=>$notification_id,'user_id'=>$id);}
                    else{$where=array('sk_notification_id'=>$notification_id,"notification_status"=>'Unread','user_id'=>$id);}
                }
                $notification_details=$this->cm->getRecords($where,'txn_notifications'); 
                // var_dump(($category_details));
                $temp=array();
                    $notification['notification_image']=$notification['notifiaction_label']= $notification['notification_msg']=$notification['notification_date']=$notification['user_id']="";
                if($notification_details!=false){
                   
                    foreach($notification_details as $info1)
                    {  
                        $notification['sk_notification_id']=$info1->sk_notification_id;
                        $notification['notifiaction_label']=$info1->notifiaction_label;
                        $notification['notification_msg']=$info1->notification_msg;
                        $notification_date=date('Y-m-d H:i',strtotime($info1->notification_date));
                        $notification['notification_date']=$notification_date;
                       $notification['user_id']=$info1->user_id;
                       $notification['notification_image']=admin_images_url.'brp.png';
                       $notification['notification_status']=$info1->notification_status;
                        $temp[]=$notification;
                    }
                    $notification12['notification_details']=$temp;
                    $ret=$this->common->response(200,true,'Notification of User Details',$notification12);
            }
            else{
                $notification12['notification_details']=$temp;
                $ret=$this->common->response(200,false,'No Data Available',$notification12);
            }
                }    
                else{         
                       $ret=$this->common->response(400,false,'user is not existed',array());
                }
                }catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }
        

        } else if($access_token==globalAccessToken){
            if($temp_session_id!=''){
                $id=JWT::decode($temp_session_id,pkey);
                
                    $notification_id=$notification_status='';
                    if(isset($row['sk_notification_id']))
                    {
                        if($row['sk_notification_id']=="All")
                        {
                            $notification_id ="All";
                        }
                        else{
                            $notification_id = $row['sk_notification_id'];
                        }
                    }
                    if(isset($row['notification_status']))
                    {
                        if($row['notification_status']=="All")
                        {
                            $notification_status ="All";
                        }
                        else
                        {
                            $notification_status = $row['notification_status'];
                        }
                    }
                    if($notification_id=="All")
                    {
                        if($notification_status=="All")
                        {
                            $where=array();
                        }
                        else
                        {
                            $where=array("notification_status"=>$notification_status,'user_id'=>$id);
                        }						
                    }else
                    {
                        if($notification_status=="All"){$where=array('sk_notification_id'=>$notification_id,'user_id'=>$id);}
                        else{$where=array('sk_notification_id'=>$notification_id,"notification_status"=>$notification_status,'user_id'=>$id);}
                    }
                    $notification_details=$this->cm->getRecords($where,'txn_notifications'); 
                    // var_dump(($category_details));
                    $notification['notification_image']=$notification['notifiaction_label']= $notification['notification_msg']=$notification['notification_date']=$notification['user_id']="";
                    if($notification_details!=false)
                    {                  
                        foreach($notification_details as $info1)
                        {  
                            $notification['sk_notification_id1']=$info1->sk_notification_id;
                            $notification['notifiaction_label']=$info1->notifiaction_label;
                            $notification['notification_msg']=$info1->notification_msg;
                            $notification_date=date('Y-m-d H:i',strtotime($info1->notification_date));
                            $notification['notification_date']=$notification_date;
                           $notification['user_id']=$info1->user_id;
                           $notification['notification_status']=$info1->notification_status;
                           $notification['notification_image']=admin_images_url.'brp.png';
                            $temp[]=$notification;
                        }
                        $notification12['notification_details1']=$temp;
                        $ret=$this->common->response(200,true,'Notification of User Details',$notification12);
                }
                else{
                    $ret=$this->common->response(400,false,'No Data Available',array());
                }
                }    
                else{            $ret=$this->common->response(400,false,'user is not existed',array());
                }
             }
        else{
                $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
            }
            echo json_encode($ret);
    }
    public function ratings(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        $data=array();$ret=array();$rating=array();
        if($access_token!=globalAccessToken)
        {
            try{
                $id=JWT::decode($access_token,pkey);
                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists){
                    $params = array();
                    $id=$order_id=$rating="";
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params)) { 
                        if(isset($params['user_id'])) { $id = $params['user_id'];} 
                        if(isset($params['order_id'])) { $order_id = $params['order_id'];} 
                        if(isset($params['rating'])) { $rating = $params['rating'];} 
                        $saveData = array(
                            'user_id'=>$id,
                            'rating_order_id'=>$order_id,
                            'rating'=>$rating,
                             
                    );
                    try {
                        $rating_id = $this->cm->save($saveData,'mlt_rating'); 
                        if($rating_id!=0) {
                            $ret=$this->common->response(200,true,'Rating Saved Success',$rating_id);
                        }
                        else {
                            $ret=$this->common->response(200,false,'Rating Save Failure',array());
                        }
                    }
                    catch(Exception $e) {

                        $msg = "";
                        $eMessage = $e->getMessage();
                        $eMessage = explode('/',$eMessage);
                        $eMessage = explode(':',$eMessage[0]);
                        if($eMessage[1]==1062) {
                            $msg = "Duplicate Entry";
                        }
                        else if($eMessage[1]==1452) {
                            $msg = "Foreign key constraint fails";
                        }
                        else  {
                            $msg = "Database error";
                        }
                        $ret=$this->common->response(400,false,$msg,array());
                    }
               
            }
            else {
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }
                

                


                }    
                else{         
                       $ret=$this->common->response(400,false,'user is not existed',array());
                }
            } catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }

        }else{
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
        }
        echo json_encode($ret);
    }



    public function party_time_orders(){

        $this->access_control();
        $access_token = $order_id=false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['order_id'])) { $order_id = $row['order_id']; }
        $data=array();$ret=array();$party_time=array();
        if($access_token)
            {
                try{
                    $id=JWT::decode($access_token,pkey);
                        $where=array('sk_user_id'=>$id,'user_status'=>1);
                        $userExists=$this->cm->getRecords($where,'mst_user');
                        if($userExists!=false){
        
                            if($this->input->server('REQUEST_METHOD') === 'GET'){
                                $where=array('temp_package_status'=>1,'order_id'=>$order_id);  
                                $package_details=$this->cm->getRecords($where,'mlt_user_packages');
                                $output='';$package_name=$price= $item_size="";      $output1=$output2=$output9='';
                                $sides_count=$pizza_count=$salads_count=$drinks_count=$desserts_count=$dips_count='';
                                $sides_id=$pizza_id=$salads_id=$drinks_id=$desserts_id=$dips_id=null;
                                
                                if($package_details!=false){
                                  foreach($package_details as $info){
                                    $where=array('sk_package_id'=>$info->package_id);
                                    $total_package_amount = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $info->total_package_amount);

                                     $package_amount=$total_package_amount;
                                    $package_full=$this->cm->getRecords($where,'mlt_package');
                                    $count=count($package_full);
                                    $inValue = array();
                                    if($package_full!=false){
                                      foreach($package_full as $info2){
                                        $package_name=$info2->package_name;

                                        if($info2->pizza_id!=NULL){
                                          $pizza_id = $info2->pizza_id;
                                          $inValue[] = $info2->pizza_id;

                                          $pizza_count = $info2->no_of_pizza;
                                        }
                                        if($info2->sides_id!=NULL){
                                          $sides_id = $info2->sides_id;
                                          $inValue[] = $info2->sides_id;

                                          $sides_count = $info2->no_of_sides;
                                        }
                                        if($info2->salads_id!=NULL){
                                          $salads_id = $info2->salads_id;
                                          $inValue[] = $info2->salads_id;

                                          $salads_count = $info2->no_of_salads;

                                        }
                                        if($info2->drinks_id!=''){
                                          $drinks_id = $info2->drinks_id;
                                          $inValue[] = $info2->drinks_id;

                                          $drinks_count = $info2->no_of_drinks;
                                        }
                                        if($info2->desserts_id!=NULL){
                                          $desserts_id= $info2->desserts_id;
                                          $inValue[] = $info2->desserts_id;

                                          $desserts_count = $info2->no_of_desserts;

                                        }
                                        if($info2->dips_id!=NULL){
                                          $dips_id = $info2->dips_id;
                                          $inValue[] = $info2->dips_id;

                                          $dips_count = $info2->no_of_dips;

                                        }
                                      }
                                    }
                                    $inValueString = '';
                                    $inValueString = implode(",",$inValue);
                                    $package['rating']=$package['package_amount']=$package['sk_package_id']=$package['no_of_people']= $package['no_of_people']=$package['from_time']=$package['select_date']=$package['other_text']=$package['party_time']=$package['user_id']= $orders['user_address']=$orders['ordered_date']=$orders['ordered_time']=$orders['total_order_quantity']=$orders['total_order_value']=$orders['coupon_id']=$orders['discount_amount']=$orders['payment_mode']=$package['razor_payment_id']=$package['order_delivery_date']=$package['order_delivery_time']='';
                                    $package['sk_order_id']=$order_id;
                                    $where=array('rating_order_id'=>$order_id);

                                    $rating=$this->cm->getRecords($where,'mlt_rating');
                                    if($rating!=false){
                                        foreach($rating as $info55){
                                            $package['rating']=$info55->rating;
                                        }
                                    }
                                    $where=array('sk_order_id'=>$order_id);
                                    $order_details=$this->cm->getRecords($where,'mlt_order');
                                    if($order_details!=false){
                                    $package['user_id']=$id;
                                    foreach($order_details as $rows){
                                    if($rows->user_address){
                                        $where=array('sk_address_id'=>$rows->user_address);
                                        $getaddress=$this->cm->getRecords($where,'mlt_address_dup');
                                        if($getaddress!=false){
                                            $area=$house_no=$city=$state=$country=$pincode=$street=$latitude=$longitude=$full_address=$address_type=$land_mark=$address_type="";

                                            foreach($getaddress as $info99){
                                                $area=$info99->area;
                                                $house_no=$info99->house_no;
                                                $city=$info99->city;
                                                $state=$info99->state;
                                                 $country=$info99->country;
                                                 if($info99->pincode!=""){$pincode=$info99->pincode;}
                                                 else
                                                 {$pincode="";}
                                                 $street=$info99->street;
                                                 $latitude=$info99->latitude;
                                                 $longitude=$info99->longitude;
                                                 $full_address=$info99->full_address;
                                                 $address_type=$info99->address_type;
                                                 $land_mark=$info99->land_mark;
                                            }
                                        }
                                    }
                                    $package['address_type']=$address_type;
                                    $package['user_address']=$full_address;
                                    $package['ordered_date']=$rows->ordered_date;
                                    
                                    $package['ordered_time']=date('h:i A',strtotime($rows->ordered_time));
                                    $package['total_order_quantity']=$rows->total_order_quantity;
                                     $total_package_amount = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $rows->total_order_value);
                                     $package['total_order_value']=$total_package_amount;

                                     $package['coupon_id']=$rows->coupon_id;
                                     $package['discount_amount']=$rows->discount_amount;
                                     $package['payment_mode']=$rows->payment_mode;
                                     $package['razor_payment_id']=$rows->razor_payment_id;
                                    //  $package['order_delivery_date']=$rows->order_delivery_date;
                                    $package['order_delivery_date']=date('d M Y', strtotime($rows->order_delivery_date));

                                     $package['order_delivery_time']=date('h:i A',strtotime($rows->order_delivery_time));
                                    $package['order_status']=$rows->order_status;
                                   
                                    $package['occation']=$info->occation;
                                    $package['other']=$info->other_text;
                                    $package['temp_package_status']=$info->temp_package_status;
                                    $package['sk_user_package_id']=$info->sk_user_package_id;
                                    $total_package_amount = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $info->total_package_amount);

                                    $package['package_amount']=$total_package_amount;   
                                    $package['select_date']=$info->select_date;
                                    $package['time']=date('H:i A',strtotime($info->from_time)).'-'.date('H:i A',strtotime($info->to_time));
                                    $package['people']=$info->no_of_people;
                                    $package['package_name']=$package_name;            
                                }              
                                
                                }
                                $slug=$categoryDetails=$categoryIdDetails=$categoryid='';
                                $q='';
                                if($inValueString!='')
                                //   $q= "where sk_categoryItems_id in($inValueString)";
                                 $sql="SELECT * FROM mst_categoryitems $q";
                               $binds="";
                               $category_details1=$this->cm->getRecordsQuery($sql, $binds);
                               
                                if($slug==''){
                                $slug=$category_details1[0]->category_slug;
                                }
                                $where1=array('cuser_id'=>$id,'party_time'=>0);
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
                                $package['quantity']  =$quantity;
                                $package['cart_price']=$cart_price;   
                                $package['items']=$i;

                                 if($category_details1!=false){
                                   // $categoryTypeInfo=array();
                                   
                          $m=1;
                                    foreach($category_details1 as $info1)
                            {
                                $temp=array();
                                        $categoryTypeInfo=array();
                                        $categoryTypeInfo['category_id']=$info1->sk_categoryItems_id;
                                        $category_id=$categoryTypeInfo['category_id'];
                                       
                                        $categoryTypeInfo['slug']=$info1->category_slug;
                                        $slug2=$info1->category_slug;
                                        
                                        $categoryTypeInfo['image']=$info1->category_image;
                                        $categoryTypeInfo['captions']=$info1->caption;
                                        $categoryTypeInfo['category_type']=$info1->Items_categoryname;
                                        $categoryTypeInfo['item_details']=array();
                                        $categoryTypeInfo['no_of_count']=0;
                                if(in_array($category_id,$inValue)){
                                    $sql="select * from mst_categoryitems,mlt_order left join mst_order_details on mlt_order.sk_order_id=mst_order_details.order_id left join mlt_items_onboarding on mst_order_details.item_id=mlt_items_onboarding.sk_id where sk_order_id=$order_id and  mst_categoryitems.sk_categoryItems_id=$category_id and category_id=$category_id";
                                $binds="";
                                $base_details=$price_details=array();
                                $category_details=$this->cm->getRecordsQuery($sql, $binds);
                                if ($category_details) {
                                    
                                    if($pizza_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_count']=count($category_details);

                                    } else if($dips_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_count']=count($category_details);;

                                    } else if($desserts_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_count']=count($category_details);;

                                    } else if($drinks_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_count']=count($category_details);;

                                    } else if($salads_id==$info1->sk_categoryItems_id){
                                        $categoryTypeInfo['no_of_count']=count($category_details);;

                                    }else {
                                        $categoryTypeInfo['no_of_count']=count($category_details);;

                                    }
                                    $temp20=array();
                                    foreach($category_details as $info){
                                        $temp20=array();
                                    $items['item_name']= $items['item_id']=$items['base_drop']=$items['price_drop']=$items['price']=$items['image']="";
                                    $items['display_name']=$items['slug1']=$items['seo_description']= $items['seo_title']='';
                                    $items['no_of_count']=0;
                                    $items['description']=$items['type']=$items['section_name']="";
                                     $items['base_drop']=$items['price_drop']=array();
                                      $items['item_name']=$info->item_name;
                                     $items['item_id']=$info->sk_id;
                                     $items['slug1']=$info1->category_slug;
                                     $where=array('citem_id'=>$info->sk_id,'cstatus'=>1,'party_time'=>1,'cuser_id'=>$id);
                                     $cart_details_by_id=$this->cm->getRecords($where,'mlt_cart');
                                     if($cart_details_by_id!=false){
                                         foreach($cart_details_by_id as $rows){
                                             $items['no_of_count']=(int)$rows->quantity;
                                         }
                                     }

                                     $custom=json_decode($info->customization);
                                     $output4=array();$output7=$output8=$output9=$output10=array();
                                     if($custom->veg){
                                         foreach($custom->veg as $info4){
                                            $output4[]=$info4;
                                         }
                                     }
                                     if($custom->nonveg){
                                         foreach($custom->nonveg as $info4){
                                             $output7[]=$info4;
                                         }
                                     }if($custom->flavor){
                                         foreach($custom->flavor as $info4){
                                             $output8[]=$info4;
                                         }
                                     }if($custom->base){
                                         foreach($custom->base as $info4){
                                             $output9[]=$info4;
                                         }
                                     }if($custom->size){
                                         foreach($custom->size as $info4){
                                             $output10[]=$info4;
                                         }
                                     }
                                     $output25=implode(',',$output4);
                                     $output26=implode(',',$output7);
                                     $output27=implode(',',$output8);
                                     $output28=implode(',',$output9);
                                     $output29=implode(',',$output10);

                                    $cart['veg']=$output25;
                                    $cart['non_veg']=$output26;
                                    $cart['flavour']=$output27;
                                    $cart['base1']=$output28; 
                                    $cart['size']=$output29; 

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
            
                                    $output6=implode(',',$output6);
                                    $items['customization']='';
                                    $items['customization']=$output6;
                                     $items['quantity']=(int)$info->cart_count;
                                     //$cart['price']=$info->price;
                                     $items['item_size']=$info->item_size;
                                    // $cart['base']=$info->base;
                                    
                                     $where=array('item_id'=>$info->sk_id,'user_id'=>$id);
                                     $favorites=$this->cm->getRecords($where,'mst_favourite');
                                     if($favorites!=false){
                                         $items['favour']=true;
                                     }else{
                                         $items['favour']=false;
                                     }
                                     
                                      $items['price']=$price;
                                     $items['image']=admin_img_url.'/items/'.$info->image;
                                     $items['display_name']=$info->display_name;
                                     $items['item_status']=$info->item_onboarding_status;
                                     $items['description']=$info->short_description;
                                     // $items['seo_description']=$info->seo_description;
                                     // $items['seo_title']=$info->seo_title;
                                     $items['short_description']=$info->description;
                                     $items['type']=$info->type;
                                     $items['section_name']=$info->section_name;

                                     $temp[]=$items;
                                 }
                                 $categoryTypeInfo['item_details']=$temp;
                           }
                        }
                                
                                $temp4[]=$categoryTypeInfo;
                         
                        }
                    }
                        $package['category_details']=$temp4;
                    }
                    $ret=$this->common->response(200,true,'packages',$package);
            }else{
                $ret=$this->common->response(200,false,'No data available',array());

            }
            }else{
                $ret=$this->common->response(400,false,'Method is Wrong',array());
            }
        }
        
                            else{
                                $ret=$this->common->response(400,false,'User is not existed',$data);
                            }
                }catch(Exception $e){
        
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
        }
        } 
        else{
            $ret=$this->common->response(400,false,'Invalid Access Token - Please check access both key and value1',new stdClass());
        }echo json_encode($ret);  

    }



    function utctime($date,$time){
        date_default_timezone_set("Asia/Kolkata");     
        $datetime = $date.' '.$time;
        $event_date=date('Y-m-d H:i:s', strtotime($datetime));
          $datetime = gmdate('Y-m-d\TH:i:s.000', strtotime($event_date)).'Z';
          $datetime1='"'.$datetime.'"';
          return $datetime1;
      }









      public function check_for_store(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $temp['time']=$langitude=$latitude=$date=$time_full='';
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) {  $access_token = $row['accesstoken']; }
        if(isset($row['latitude'])) { $latitude = $row['latitude']; }
        if(isset($row['longitude'])) { $langitude = $row['longitude']; }
       
        $data=array();$ret=array();
        if($access_token!='' && $latitude!='' && $langitude!=''){
            $endpoint = "https://ftv-dot-dista-ai-india2.appspot.com/_ah/api/jobsApi/v1/job/realTimeFeasabilityCheck";
            $coordinate = array('latitude'=>$latitude,'longitude'=>$langitude);
                $payload = '{
                    "jobType": "DROP",
                    "dropCoordinate": '.json_encode($coordinate).',
                    "skillsets": [
                      "Default"
                    ],
                    "jobPriority": "1",
                    "asapTrue": "true",
                    "demand": "1",
                    "entityName": "RealtimeSchedulingConfig",
                    "templateId": " 5505822050222080 "
                  }';

                  $headers = array('Content-Type:application/json','CLIENT_ID:6181027215048704');
                  $makecall = $this->common->callAPI('POST', $endpoint, $payload, $headers);
                 $result = json_decode($makecall);
                 if($result->status=='success'){
                     $ret=$this->common->response(200,true,'Service is Available',array());
                 }
                else{
                    $ret=$this->common->response(200,false,'Currently not service is available',array());
                }
                 
        }
    
    else{
        $ret=$this->common->response(200,true,'Please give correct input',array());
    }

        echo json_encode($ret);

    }


    public function notification_read(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;$temp_session_id='';
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['temp_session_id'])) { $temp_session_id = $row['temp_session_id']; }
        $data=array();$ret=array();$notification=array();
        if($access_token!=globalAccessToken)
        {
            try{
                $id=JWT::decode($access_token,pkey);
                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists!=false){
                $where=array('user_id'=>$id,'notification_status'=>'Unread');
                $notification_id=$notification_status='';
                $notification_details=$this->cm->updateRecords(array('notification_status'=>'read'),$where,'txn_notifications'); 
                // var_dump(($category_details));

                $temp=array();
                $where=array("notification_status"=>'Unread','user_id'=>$id);
                $notification_details=$this->cm->getRecords($where,'txn_notifications'); 
                    $notification['notification_count']=0;
                if($notification_details==false){
                   
                    $notification12['notification_count']=0;
                    $ret=$this->common->response(200,true,'Notification of User Details',$notification12);
            }
            else{
                $notification12['notification_count']=count($notification_details);
                $ret=$this->common->response(200,false,'No Data Available',$notification12);
            }
                }    
                else{         
                       $ret=$this->common->response(400,false,'user is not existed',array());
                }
                }catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }
        

        } else if($access_token==globalAccessToken){
            if($temp_session_id!=''){
                $id=JWT::decode($temp_session_id,pkey);
                
                    $notification_id=$notification_status='';
                    $where=array('user_id'=>$id,'notification_status'=>'Unread');
                    $notification_details=$this->cm->updateRecords(array('notification_status'=>'read'),$where,'txn_notifications'); 
                    // var_dump(($category_details));
    
                    $temp=array();
                    $where=array("notification_status"=>'Unread','user_id'=>$id);
                    $notification_details=$this->cm->getRecords($where,'txn_notifications'); 
                        $notification['notification_count']=0;
                    if($notification_details==false){
                       
                        $notification12['notification_count']=0;
                        $ret=$this->common->response(200,true,'Notification of User Details',$notification12);
                }
                else{
                    $notification12['notification_count']=count($notification_details);
                    $ret=$this->common->response(200,false,'No Data Available',$notification12);
                }
                }    
                else{            $ret=$this->common->response(400,false,'user is not existed',array());
                }
             }
        else{
                $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
            }
            echo json_encode($ret);
    }

    public function feedback(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        $data=array();$ret=array();$feedback=array();
        if($access_token!=globalAccessToken)
        {
            try{
                $id=JWT::decode($access_token,pkey);
               // $id=JWT::encode('128',pkey);
              //  echo $id;

                $where=array('sk_user_id'=>$id);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists){
                    $params = array();
                    $feedback_text="";
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params)) { 

                        if(isset($params['feedback_text'])) { $feedback_text = $params['feedback_text'];} 
                        $saveData = array(
                            'user_id'=>$id,
                            'feedback_text'=>$feedback_text
                             
                    );
                    try {
                        $feedback_id = $this->cm->save($saveData,'mlt_feedback'); 
                        if($feedback_id!=0) {
                            $ret=$this->common->response(200,true,'FeedBack Saved Success',$feedback_id);
                        }
                        else {
                            $ret=$this->common->response(200,false,'FeedBack Save Failure',array());
                        }
                    }
                    catch(Exception $e) {

                        $msg = "";
                        $eMessage = $e->getMessage();
                        $eMessage = explode('/',$eMessage);
                        $eMessage = explode(':',$eMessage[0]);
                        if($eMessage[1]==1062) {
                            $msg = "Duplicate Entry";
                        }
                        else if($eMessage[1]==1452) {
                            $msg = "Foreign key constraint fails";
                        }
                        else  {
                            $msg = "Database error";
                        }
                        $ret=$this->common->response(400,false,$msg,array());
                    }
               
            }
            else {
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }
                

                


                }    
                else{         
                       $ret=$this->common->response(400,false,'user is not existed',array());
                }
            } catch (Exception $e) {
                $ret=$this->common->response(400, false, 'Invalid Access Token', array());
            }

        }else{
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
        }
        echo json_encode($ret);
    }


      


    // public function party_time_calender(){
    //     $this->access_control();
    //     $commonData=$this->common_data();
    //     $access_token = false;
    //     if(isset($row['select_date'])) { $select_date = $row['select_date']; }
    //     $select_date=$from=$to='';
    //     $row=$this->input->request_headers();
    //     if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
    //     if(isset($row['select_date'])) { $select_date = $row['select_date']; }
    //     if(isset($row['from'])) { $from = $row['from']; }
    //     if(isset($row['to'])) { $from = $to['to']; }


    //     $data=array();$ret=array();$feedback=array();
    //     if($access_token!=globalAccessToken)
    //     {
    //         try{
    //             $id=JWT::decode($access_token,pkey);
    //            // $id=JWT::encode('128',pkey);
    //           //  echo $id;

    //             $where=array('sk_user_id'=>$id);
    //             $userExists=$this->cm->getRecords($where,'mst_user');
    //             if($userExists!=false){
                  
    //             }    
    //             else{         
    //                    $ret=$this->common->response(400,false,'user is not existed',array());
    //             }
    //         } catch (Exception $e) {
    //             $ret=$this->common->response(400, false, 'Invalid Access Token', array());
    //         }

    //     }else{
    //         $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
    //     }
    //     echo json_encode($ret);
    // }





    public function cartdelete(){
        $this->access_control();
        $commonData=$this->common_data();
        $access_token = false;
        $row=$this->input->request_headers();
        $temp_user_id =$party_time="";
        if(isset($row['accesstoken'])) { $access_token = $row['accesstoken']; }
        if(isset($row['temp_user_id'])) { $temp_user_id = $row['temp_user_id']; }
        if(isset($row['party_time'])) { $party_time = $row['party_time']; }
        $data=array();$ret=array();$cart=array();
        $citem_id=$item_size='';
        if($access_token!=globalAccessToken)
        {   
                  $id=JWT::decode($access_token,pkey);			 
                $where=array('sk_user_id'=>$id,'user_status'=>1);
                $userExists=$this->cm->getRecords($where,'mst_user');
                if($userExists){
                   if ($this->input->server('REQUEST_METHOD') == 'PUT')
                    {
                    $params = array();
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params))
                    if(isset($params['citem_id'])) {  $citem_id = $params['citem_id'];} 
                    if(isset($params['item_size'])) {  $item_size = $params['item_size'];} 

                    if(isset($params['party_time'])) {  $party_time = $params['party_time'];} 
                    $cart_price=$i=0;
                    $cart_data=array(
                        'items'=>$i,
                        'price'=>$cart_price,
                        'accesstoken'=>JWT::encode($id,pkey)
                    );
                    try {
                        if($item_size==''){

                            $item_size=1;

                        }
                        $where=array('citem_id'=>$citem_id,'item_size'=>$item_size,'party_time'=>$party_time,'cuser_id'=>$id);  
                        $response = $this->cm->deleteRecords($where,'mlt_cart');
                        $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                        $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                        $cart_price=$i=0;
                        $cart_data=array(
                            'items'=>$i,
                            'price'=>$cart_price,
                            'accesstoken'=>JWT::encode($id,pkey)
                        );

                        if($cart_count_details!=false){
                            foreach($cart_count_details as $info10){
                                $cart_price=$cart_price+$info10->price;
                                $i++;
                            }
                         } 
                         $cart_data=array(
                            'items'=>$i,
                            'price'=>$cart_price,
                            'accesstoken'=>JWT::encode($id,pkey)
                        );
                   
                        $ret=$this->common->response(200,true,'Your Cart Details Deleted Successfully',$cart_data);
                    }

                    catch(Exception $e){
                        $msg = "";
                        $eMessage = $e->getMessage();
                        $eMessage = explode('/',$eMessage);
                        $eMessage = explode(':',$eMessage[0]);
                        if($eMessage[1]==1062) {
                            $msg = "Duplicate Entry";
                        }
                        else if($eMessage[1]==1452) {
                            $msg = "Foreign key constraint fails";
                        }
                        else  {
                            $msg = "Database error";
                        }
                        $ret=$this->common->response(400,true,$msg,array());
                    }
                }
            else
            {
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }
        }else{
            $ret=$this->common->response(400,false,'User Not Existed',$data);

        }
    
         
        }else if($access_token==globalAccessToken){
               
                    
                    if ($this->input->server('REQUEST_METHOD') == 'PUT')
                    {
                        $id=JWT::decode($temp_user_id,pkey);

                    $params = array();
                    $params = json_decode(@file_get_contents('php://input'),TRUE);
                    if(isset($params))
                    if(isset($params['citem_id'])) {  $citem_id = $params['citem_id'];} 
                    if(isset($params['item_size'])) {  $item_size = $params['item_size'];} 
                    if(isset($params['party_time'])) {  $party_time = $params['party_time'];} 
                    $cart_price=$i=0;
                    $cart_data=array(
                        'items'=>$i,
                        'price'=>$cart_price,
                        'accesstoken'=>JWT::encode($id,pkey)
                    );
                    try {
                        if($item_size==''){

                            $item_size=1;

                        }
                        $where=array('citem_id'=>$citem_id,'item_size'=>$item_size,'cuser_id'=>$id);  
                        $response = $this->cm->deleteRecords($where,'mlt_cart');
                        $where=array('cuser_id'=>$id,'party_time'=>$party_time);
                        $cart_count_details = $this->cm->getRecords($where,'mlt_cart'); 
                        if($cart_count_details){
                            foreach($cart_count_details as $info10){
                                $cart_price=$cart_price+$info10->price;
                                $i++;
                            }
                         } 
                         
                   
                        
                        $ret=$this->common->response(200,true,'Your Cart Details Deleted Successfully',$cart_data);
                    }

                    catch(Exception $e){
                        $msg = "";
                        $eMessage = $e->getMessage();
                        $eMessage = explode('/',$eMessage);
                        $eMessage = explode(':',$eMessage[0]);
                        if($eMessage[1]==1062) {
                            $msg = "Duplicate Entry";
                        }
                        else if($eMessage[1]==1452) {
                            $msg = "Foreign key constraint fails";
                        }
                        else  {
                            $msg = "Database error";
                        }
                        $ret=$this->common->response(400,true,$msg,array());
                    }
          
            }
            else
            {
                $ret=$this->common->response(400,false,'Please check the input',$data);
            }   
        }else{
            $ret=$this->common->response(400,false,'Invalid Access Token - please check access token both key and value1',new stdClass());
    }

    echo json_encode($ret);

}

}
?>