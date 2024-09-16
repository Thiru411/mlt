<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class AdminModel extends CI_Model{
   
    public function __construct() 
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library('form_validation');	
	}
	
	public function getRecords($where,$table) {
		$this->db->select("*"); 
		$query = $this->db->get_where($table, $where);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	
	public function delete($table,$col_name,$val){
		$this -> db -> where($col_name, $val);
		$this -> db -> delete($table);
	}
	function getMax($table,$id) {
        $maxID=0;
        $sql = "SELECT max($id) as $id FROM $table ";
        $binds = array();
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
          $max=$query->result();
          foreach ($max as $info){
            $maxID=$info->$id;
          }
          return ++$maxID;
        } else {
          return false;
        }
	  }
	  function isExist($table,$cond,$value) {
        $sql = "SELECT * from  $table where $cond=?";
        $binds = array($value);
        $query = $this->db->query($sql,$binds);
        if ($query->num_rows() > 0) {
          return $query->result();
        } else {
          return false;
        }
      }
/* =========================Country , State Details==================== */
function getSectionData($id)
	{
		if($id!="All"){
			$query=$this->db->query("select * from mst_section where sk_section_id='$id'");
			$result = $query->result();
			
		}
		else if($id=="All"){
			$query=$this->db->query("select * from mst_section");
			$result = $query->result();
			
		}
		return $result;
	}
	function getStoreDetails($id)
	{
		if($id!="All"){
			$query=$this->db->query("select * from mst_category where sk_category_id='$id'");
			$result = $query->result();
			
		}
		else if($id=="All"){
			$query=$this->db->query("select * from mst_category");
			$result = $query->result();
			
		}
		return $result;
	}
	function getStoreType($id)
	{
		if($id!="All"){
			$query=$this->db->query("select * from mst_store_type where sk_store_type_id='$id'");
			$result = $query->result();
			
		}
		else if($id=="All"){
			$query=$this->db->query("select * from mst_store_type");
			$result = $query->result();
			
		}
		return $result;
	}
function getStateDetails($country_id)
{
	$sql = "select * from mst_state  where country_id=? and state_status=1 order by state_name asc";
	$binds = array($country_id);
	$query = $this->db->query($sql, $binds);
	if ($query->num_rows() > 0) {
		return $query->result();
	  }
	  else {
		return false;
	  }
}
function getCityDetails($country_id,$state_id)
{
	$sql = "select * from mst_states_cities  where state_id=? and country_id=? and city_status=1 order by city_name asc";
	$binds = array($state_id,$country_id);
	$query = $this->db->query($sql, $binds);
	if ($query->num_rows() > 0) {
		return $query->result();
	  }
	  else {
		return false;
	  }
}
function getDetails($table_name,$col_name,$val,$col_name1,$val1)
{
if($val1=="All" && $val=="All"){
	$sql = "select *  from $table_name order by $col_name1 asc";
	$query = $this->db->query($sql);
  }
  else if($val1=="All" && $val!="All"){
	$sql = "select * from $table_name where $col_name=? order by $col_name asc";
	$binds = array($val);
	$query = $this->db->query($sql, $binds);
  }
  else if($val1!="All" && $val=="All"){
	$sql = "select * from $table_name where $col_name1=? order by $col_name asc";
	$binds = array($val1);
	$query = $this->db->query($sql, $binds);
  }
  else if($val1!="All" && $val!="All"){
	$sql = "select * from $table_name where  $col_name1=?  and $col_name=? order by $col_name asc";
	$binds = array($val1,$val);
	$query = $this->db->query($sql, $binds);
  }
  if ($query->num_rows() > 0) {
	return $query->result();
  }
  else {
	return false;
  }

   
	}

 function getTimingDetails($sk_restaurant_id,$day)
 {
	 
		$sql = "select * from mst_timing where rest_id=? and Day=?";
		$binds = array($sk_restaurant_id,$day);
		$query = $this->db->query($sql, $binds); 
	  if ($query->num_rows() > 0) {
		return $query->result();
	  }
	  else {
		return false;
	  }
 }
/* =========================State Details==================== */
	function encrypt($pure_string) {
		
		/*$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
	    $pure_string, MCRYPT_MODE_CBC, $iv);
	    $ciphertext = $iv . $ciphertext;
		$ciphertext_base64 =rtrim(strtr(base64_encode($ciphertext), '+/', '-_'), '=');// base64_encode($ciphertext);*/ 
		$ciphertext_base64=base64_encode($pure_string);
	    return $ciphertext_base64;
	}
	
	function decrypt($encrypted_string) {
		
		/*$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $ciphertext_dec =base64_decode(str_pad(strtr($encrypted_string, '-_', '+/'), strlen($encrypted_string) % 4, '=', STR_PAD_RIGHT));  // base64_decode($encrypted_string);
	    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
	    $ciphertext_dec = substr($ciphertext_dec, $iv_size);
	    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
		$ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);*/
		$plaintext_dec=base64_decode($encrypted_string);
	    return $plaintext_dec;
	}

	function signin($email, $password)
	{
	    $query=$this->db->query("select * from mst_restaurants where email='$email' and password='$password' and restaurant_status=1");
	    
	    if($query -> num_rows() == 1)
	    {
	        return $query->result();
	    }
	    else
	    {
	        return false;
	    }
	}
	/********************SAVE***********************/
	function Save($data,$table)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	} 
	/********************SAVE***********************/
	
	/********************UPDATE***********************/
    function Update($table,$cond,$email,$data)
	{
		$this->db->where($cond,$email);
		$this->db->update($table,$data);
	} 
	/********************UPDATE***********************/

	/********************Section***********************/
	function getTableData($table,$status)
	{
		if($status!="All")
		{
			$query=$this->db->query("select * from $table where section_status='1'");
			$result = $query->result();
			return $result;
		}
		else
		{
			$query=$this->db->query("select * from $table");
			$result = $query->result();
			return $result;
		}
	}
	function getSectionDataById($table,$id)
	{
		$query=$this->db->query("select * from $table where sk_section_id='$id'");
		$result = $query->result();
		return $result;
	}
	
	/********************Section***********************/

	/********************Category***********************/
	function getCategoryData($table,$status)
	{
		if($status!="All")
		{
			$query=$this->db->query("select * from $table where category_status='1'");
			$result = $query->result();
			return $result;
		}
		else
		{
			$query=$this->db->query("select * from $table");
			$result = $query->result();
			return $result;
		}
	}
	function getCategoryDataById($table,$id)
	{
		$query=$this->db->query("select * from $table where sk_category_id='$id'");
		$result = $query->result();
		return $result;
	}
	function getDeliveryboyById($table,$id)
	{
		$query=$this->db->query("select * from $table where sk_deliveryboy_id='$id'");
		$result = $query->result();
		return $result;
	}
	/********************Category***********************/

	/********************item Type***********************/
	function getItemTypeDataById($table,$id)
	{
		$query=$this->db->query("select * from $table where sk_type_id='$id'");
		$result = $query->result();
		return $result;
	}
	/********************item Type***********************/
	/***** settings ******/
	function get_settings($type)
	{
	    $sql = "SELECT * from settings where setting_type=? and setting_status=? ";
	    $binds = array($type,1);
	    $query = $this->db->query($sql, $binds);
	    if ($query->num_rows() > 0) {
	        return $query->result();
	    }
	    else {
	        return false;
	    }
	}

	/***** state ******/
	function getStates($state_id = '',$state_status = '') {
		$this->db->select('*');
		$this->db->from('mst_state s');
		$this->db->join('mst_country c', 's.country_id = c.sk_country_id','INNER');
		if($state_status != 'all') {
			$array = array('s.state_status' =>$state_status);
			$this->db->where($array);
		}
		if($state_id!='all') {
			$this->db->where('s.sk_state_id',$state_id);
		}
		$this->db->order_by('s.country_id','desc');
		$this->db->order_by('s.state_name','asc');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	/***** City ******/
	function getCities($city_id = '',$city_status = '') {
		$this->db->select('*');
		$this->db->from('mst_states_cities ct');
		$this->db->join('mst_state s', 'ct.state_id = s.sk_state_id','INNER');
		$this->db->join('mst_country c', 'ct.country_id = c.sk_country_id','INNER');
		if($city_status != 'all') {
			$array = array('ct.city_status' =>$city_status);
			$this->db->where($array);
		}
		if($city_id!='all') {
			$this->db->where('ct.city_id',$city_id);
		}
		$this->db->order_by('ct.country_id','desc');
		$this->db->order_by('ct.state_id','desc');
		$this->db->order_by('ct.city_name','asc');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}

	function getOrderHistory($from_date,$to_date,$sk_restaurant_id,$order_status)
	{
		$query=$this->db->query("select * from mst_order,mst_restaurants,mst_user where ordered_date between '$from_date'and'$to_date' group by sk_order_id");
		return $query->result();

			}
	
	
	function getOrderDetails($order_id)
	{
		
		$sql="SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id WHERE mst_order_details.order_id=?";	   
		 $binds = array($order_id);
	    $query = $this->db->query($sql, $binds);
	    if ($query->num_rows() > 0) {
	        return $query->result();
	    }
	    else {
	        return false;
	    }
	}
	 function GetOrder($order_id)
	 {
		$query=$this->db->query("SELECT mst_order.*,mst_user.full_name,mst_user.mobile,mst_useraddress.address_name,mst_useraddress.landmark FROM mst_order as mst_order,mst_user as mst_user,mst_useraddress as mst_useraddress WHERE mst_order.user_id=mst_user.sk_user_id and mst_order.user_address=mst_useraddress.sk_address_id and mst_order.sk_order_id='$order_id'");
		$result = $query->result();

		return $result;
	 }
	function getOrderCount($user_type,$order_status,$rest_id,$date)
	{
		$q="";
		if($user_type=='admin'){
			//$q=" and restuarant_id='$rest_id'";
		}
		$sql = "SELECT count(sk_order_id) as order_count FROM mst_order WHERE order_status=? and ordered_date = ?";
	    $binds = array($order_status,$date);
	    $query = $this->db->query($sql, $binds);
	    if ($query->num_rows() > 0) {
	        return $query->result();
	    }
	    else {
	        return false;
	    }
	}
	function getRestcount(){
		$query=$this->db->query("SELECT count(sk_restaurant_id) as rest_count FROM mst_restaurants WHERE restaurant_status='1'");
		$query=$query->result();
		return $query;
	}
	function getdeliveredcount(){
		$query=$this->db->query("SELECT count(sk_order_id) as order_count FROM mst_order");
		$query=$query->result();
		return $query;
	}
	function getusercount(){
		$query=$this->db->query("SELECT count(sk_user_id) as user_count FROM mst_user");
		$query=$query->result();
		return $query;
	}

	function getOrderValue($user_type,$rest_id,$date)
	{
		
		
		$query=$this->db->query("select * from mst_order where payment_status='Success' and order_status='success' and ordered_date='$date' and restuarant_id='$rest_id'");
		$query=$query->result();
		return $query;
	}


	function getUsers($table,$status)
	{
		if($status!="All")
		{
			$query=$this->db->query("select * from $table where user_status='1'");
			$result = $query->result();
			return $result;
		}
		else
		{
			$query=$this->db->query("select * from $table");
			$result = $query->result();
			return $result;
		}
	}

	/***************************june 2nd insert cart and history ******************************************/
	 function deleteone($table,$column,$value) 
	 {
				$this->db->where($column,$value);
				$this->db->delete($table);
	 }
	 /*=================================order_history======================================================*/
	
	
	/*=================================order_history=======================================================*/
	
	
	/*=================================cancel_order=========================================================*/
	 function data_exits3($value,$column,$value1,$column1,$value2,$column2,$table_name)
	 {
		$sql = "select * from $table_name where $column=? and $column1 = ? and $column2 = ?";
		$binds = array($value,$value1,$value2);
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	/*===============================order_repeat===========================================================*/
	function data_exits2($value,$column,$value1,$column1,$table_name) {
				$sql = "select * from $table_name where $column=? and $column1 = ? ";
				$binds = array($value,$value1);
				$query = $this->db->query($sql, $binds);
				if ($query->num_rows() > 0) {
					return $query->result();
				}
				else {
					return false;
				}
			}
			public function GetAddress($user_address)
			{
				$query=$this->db->query("select * from mst_address where sk_address_id='$user_address'");
				$result = $query->result();
				return $result;
			}
			
			public function GetDeliveryBoyName($id)
			{
				$query=$this->db->query("select * from mst_deliveryboy where sk_deliveryboy_id='$id'");
				$result = $query->result();
				return $result;
			}

			function getOrdersTobeDelivered($ses_del_admin_key)
			{
				$query = $this->db->query("SELECT mst_order.*,mst_user.full_name,mst_restaurants.restaurant_name FROM mst_order as mst_order,mst_user as mst_user,mst_restaurants as mst_restaurants WHERE mst_order.user_id=mst_user.sk_user_id and mst_order.restuarant_id=mst_restaurants.sk_restaurant_id and deliveryboy_id='$ses_del_admin_key' and order_status='Outfordelivery'");
				$result = $query->result();
				return $result;
				
			}
			function getRestaurants()
			{
				$query = $this->db->query("SELECT * FROM mst_restaurants");
				$result = $query->result();
				return $result;
				
			}
			function getNewOrderCount($sk_restaurant_id,$order_status,$cur_date)
			{
			
					$query = $this->db->query("SELECT * FROM mst_order where restuarant_id='$sk_restaurant_id' and ordered_date='$cur_date' and order_status='$order_status'");
					$result = $query->result();
					return $result;
			}
			function getPlacedOrderCount($sk_restaurant_id,$order_status)
			{	
					$query = $this->db->query("SELECT * FROM mst_order where restuarant_id='$sk_restaurant_id' and order_status='$order_status'");
					$result = $query->result();
					return $result;	
			}

function getdevicetoken($orderid)
				{
						$query = $this->db->query("SELECT mst_user.*,(mst_deliveryboy.name)as deliveryboy_name,mst_order.* FROM mst_order LEFT JOIN mst_user on mst_order.user_id = mst_user.sk_user_id  LEFT JOIN mst_deliveryboy ON mst_order.deliveryboy_id =mst_deliveryboy.sk_deliveryboy_id WHERE 
							sk_order_id = '$orderid'");
						$result = $query->result();
						return $result;
				}

function getDeliveryBoydevicetoken($orderid)
				{
						$query = $this->db->query("SELECT mst_deliveryboy.*,mst_order.*,mst_restaurants.restaurant_name FROM mst_order LEFT JOIN mst_restaurants on mst_order.restuarant_id = mst_restaurants.sk_restaurant_id  LEFT JOIN mst_deliveryboy ON mst_order.deliveryboy_id = mst_deliveryboy.sk_deliveryboy_id WHERE sk_order_id ='$orderid'");
						$result = $query->result();
						return $result;
				}
				
function getOrderSum($resid)
				{
					$this->db->select_sum('total_order_value');
					$this->db->where('restuarant_id',$resid);
					$result = $this->db->get('mst_order')->row();
					return $result->total_order_value;
				}
function getShippingSum($resid)
				{
					$this->db->select_sum('shipping_charge');
					$this->db->where('restuarant_id',$resid);
					$result = $this->db->get('mst_order')->row();
					return $result->shipping_charge;
				}
function getdebitSum($resid)
				{
					$this->db->select_sum('debit_amount');
					$this->db->where('restaurant_id',$resid);
					$result = $this->db->get('txn_transaction')->row();
					return $result->debit_amount;
				}
function getDeliveryBoyLog($deliveryboy_id,$to_date)
				{
					$query=$this->db->query("SELECT * from mst_deliveryboy_log where created_date='$to_date' and deliveryboy_id='$deliveryboy_id'");
					$result = $query->result();
					return $result;
				}
	
function getZonesData($table)
				{
					$query=$this->db->query("SELECT * from $table");
					$result = $query->result();
					return $result;
				}
	function getZonesDataById($table,$zones_id)
	{
			$query=$this->db->query("SELECT * from $table where sk_zone_id='$zones_id' and zone_status='1'");
			$result = $query->result();
			return $result;
	}
	function getneworders($date){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order.order_status='pending' and mst_order.ordered_date='$date'");
			$result = $query->result();
			return $result;
	}
	function getdeliveredorders($date){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order.order_status='success' and mst_order.ordered_date='$date'");
			$result = $query->result();
			return $result;
	}
	function getcancelorders($date){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order.order_status='cancelled' and mst_order.ordered_date='$date'");
			$result = $query->result();
			return $result;
	}
	function gettotalordervalues($date){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order.payment_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order.order_status='success' and mst_order.payment_status='success' and mst_order.ordered_date='$date'");
			$result = $query->result();
			return $result;
	}
	function getOrderHistoryday($date)
	{
		$query=$this->db->query("select * from mst_order,mst_restaurants,mst_user where mst_order.ordered_date='$date' and order_status='pending'group by sk_order_id");
		return $query->result();

	}
	function getOrderHistorydaysuccess($date)
	{
		$query=$this->db->query("select * from mst_order,mst_restaurants,mst_user where mst_order.ordered_date='$date' and order_status='success'group by sk_order_id");
		return $query->result();

	}
	function getOrderHistorydaycancel($date)
	{
		$query=$this->db->query("select * from mst_order,mst_restaurants,mst_user where mst_order.ordered_date='$date' and order_status='cancelled'group by sk_order_id");
		return $query->result();

	}
	function getOrderHistorydaybyval($date)
	{
		$query=$this->db->query("select * from mst_order,mst_restaurants,mst_user where mst_order.ordered_date='$date' and order_status='pending'group by sk_order_id");
		return $query->result();

	}
	
public function fetchfavourites($id) {
	$query=$this->db->query("SELECT * FROM mst_favourite JOIN mlt_items_onboarding on mst_favourite.item_id=mlt_items_onboarding.sk_id JOIN mlt_price on mst_favourite.item_id=mlt_price.item_id JOIN mlt_item_toppings on mst_favourite.item_id=mlt_item_toppings.item_id where mst_favourite.user_id='$id'");
	$result = $query->result();
		return $result;
}
public function fetchOrderHistoryDetails($sk_id){
	$query=$this->db->query("select * from mst_order_details left join mlt_order on mst_order_details.order_id=mlt_order.sk_order_id left join mlt_items_onboarding on mst_order_details.item_id=mlt_items_onboarding.sk_id left join mst_user on mst_order_details.user_id=mst_user.sk_user_id where order_id='$sk_id'");
	$result = $query->result();
	return $result;

}
public function orderDetails($id){
	$query=$this->db->query("select * from mlt_order left join mst_user on mlt_order.user_id=mst_user.sk_user_id where sk_user_id='$id'");
	$result = $query->result();
	return $result;
}
public function viewOrderDetails($id) {
	$query=$this->db->query("select * from mst_order_details left join mlt_order on mst_order_details.order_id=mlt_order.sk_order_id left join mlt_items_onboarding on mst_order_details.item_id=mlt_items_onboarding.sk_id left join mst_user on mst_order_details.user_id=mst_user.sk_user_id left join mlt_address_dup on mlt_order.user_address=mlt_address_dup.sk_address_id left join mlt_rating as ratings on mst_order_details.order_id=ratings.rating_order_id where sk_order_id='$id'");
	$result = $query->result();
	return $result;
}


public function viewOrderDetailsforguest($id) {
	$query=$this->db->query("select * from mst_order_details left join mlt_order on mst_order_details.order_id=mlt_order.sk_order_id left join mlt_items_onboarding on mst_order_details.item_id=mlt_items_onboarding.sk_id left join mst_user on mst_order_details.user_id=mst_user.sk_user_id  left join mlt_rating as ratings on mst_order_details.order_id=ratings.rating_order_id where sk_order_id='$id'");
	$result = $query->result();
	return $result;
}
}




