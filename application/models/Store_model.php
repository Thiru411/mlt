<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Store_model extends CI_Model{
   
    public function __construct() 
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library('form_validation');	
	}
	
	/********************Item***********************/
	function getCategoryBySection($section)
	{
		$query=$this->db->query("select * from mst_category where section_id='$section'");
		$result = $query->result();
		return $result;
	}
	
	function getitemtypenames($type_id){
		
		$query=$this->db->query("select item_type from mst_item_type where sk_type_id='$type_id'");
		$result = $query->result();
		return $result;
	}
	function getItemTypeBySection($section)
	{
		$query=$this->db->query("select * from mst_item_type where section_id='$section'");
		$result = $query->result();
		return $result;
	}

	function getCategoryName($category)
	{
		$query=$this->db->query("select * from mst_category where sk_category_id='$category'");
		$result = $query->result();
		return $result;
	}

	function getitemTypeName($itemtype)
	{
		$query=$this->db->query("select * from mst_item_type where sk_type_id ='$itemtype'");
		$result = $query->result();
		return $result;
	}
	function getsectionName($section)
	{
		$query=$this->db->query("select * from mst_section where sk_section_id ='$section'");
		$result = $query->result();
		return $result;
	}
	function getzonenamerById($zone)
	{
		$query=$this->db->query("select * from mst_zones where sk_zone_id ='$zone'");
		$result = $query->result();
		return $result;
	}

	function getItemDetails($table,$status)
	{
		if($status!="All")
		{
			$query=$this->db->query("select * from $table where item_status='1'");
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
	function GetRestaurentDetails($table,$id)
	{
		if($id!=" ")
		{
			$query=$this->db->query("select * from $table where sk_restaurant_id='$id'");
			$result = $query->result();
			return $result;
		}
		else
		{
			$query=$this->db->query("sselect * from $table");
			$result = $query->result();
			return $result;
		}
	}
	function getItemsDataById($table,$id)
	{
		$query=$this->db->query("select * from $table where sk_items_id='$id'");
		$result = $query->result();
		return $result;
	}
	function getcategoryById($section){
		$query=$this->db->query("select * from mst_category where section_id='$section'");
		$result = $query->result();
		return $result;
	}
	function getitemtypebyId($section){
		$query=$this->db->query("select * from mst_item_type where section_id='$section'");
		$result = $query->result();
		return $result;
	}
	
	/********************Manage Item***********************/
	
	function getPassword($ses_store_admin_key)
	{
		$query=$this->db->query("select password from mst_restaurants where sk_restaurant_id='$ses_store_admin_key'");
		$result = $query->result();
		return $result;
	}


	function getItemDetailsById($table,$column,$val)
	{
		if($val!="All")
		{
			$query=$this->db->query("select * from $table where $column=$val");
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
function getAllItemDetailsById($restuarants_id)
{			
			$query=$this->db->query("select * from mst_items where restuarants_id='$restuarants_id'");
			$result = $query->result();
			return $result; 
}

function getData($table,$type,$id)
{
	if($type=="city")
	{
		$query=$this->db->query("SELECT * from $table where sk_city_id='$id'");
		$result = $query->result();
		return $result; 
	}
	else if($type=="campus")
	{
		$query=$this->db->query("SELECT * from $table where sk_campus_id='$id'");
		$result = $query->result();
		return $result; 
	}
	else if($type=="menu")
	{
		$query=$this->db->query("SELECT * from $table where sk_menu_id='$id'");
		$result = $query->result();
		return $result; 
	}
	else if($type=="walkthrough")
	{
		$query=$this->db->query("SELECT * from $table where sk_walkthrough_id='$id'");
		$result = $query->result();
		return $result; 
	}
	else
	{
			$query=$this->db->query("SELECT * from $table");
			$result = $query->result();
			return $result; 
	}
}
	function getCampus($cityid)
	{
		$query=$this->db->query("SELECT * from mst_campus where city_id='$cityid'");
		$result = $query->result();
		return $result; 
	}
	function retrieve_data($item_id,$res_id,$section_id,$zone_id){
		$query=$this->db->query("select * from mst_item_addons where item_id='$item_id' AND restuarants_id='$res_id' AND section_id='$section_id' and zones_id='$zone_id'");
		$result = $query->result();
		return $result; 
	}
	function retrieve_data1($item_id,$res_id,$section_id,$zone_id){
		$query=$this->db->query("select * from mst_item_addons where item_id='$item_id' AND restuarants_id='$res_id' AND section_id='$section_id' and zones_id='$zone_id'");
		$result = $query->result();
		return $result; 
	}
	function insertAddon($data){
		$this->db->insert('mst_item_addons',$data);
		return $this->db->insert_id();
	}
	function addon_edit($id){
		$query=$this->db->query("select * from mst_item_addons where sk_addon_id='$id'");
		$result = $query->result();
		return $result; 
	}
	function addonUpdate($data,$table,$id)
	{
		$this->db->where('sk_addon_id',$id);
		$this->db->update($table,$data);
	} 

	function encrypt($pure_string) {
		

		/*$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
	    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
	    $pure_string, MCRYPT_MODE_CBC, $iv);
	    $ciphertext = $iv . $ciphertext;
		$ciphertext_base64 =rtrim(strtr(base64_encode($ciphertext), '+/', '-_'), '=');// base64_encode($ciphertext);
		*/
		$ciphertext_base64=base64_encode($pure_string);
	    return $ciphertext_base64;
	}
	
	function decrypt($encrypted_string) {
		/*
		$key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
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
	function UpdateAddonStatus($addon_id,$data)
	{
		//echo $addon_id;
		$query=$this->db->query("UPDATE mst_item_addons SET addon_status='$data' WHERE sk_addon_id='$addon_id'");
		return $query;

	} 

	function gettableData(){
		$query=$this->db->query("select * from mst_tables");
		$result = $query->result();
		return $result; 
	}
	function gettableData1($res_id){
		$query=$this->db->query("select *from mst_tables where restuarant_id='$res_id'");
		$result = $query->result();
		return $result; 
	}
	function updatetable($qr,$table_id){
		$query=$this->db->query("UPDATE mst_tables SET qr_code='$qr' WHERE sk_table_id ='$table_id'");
		return $query;
	}

	function getTables($table,$res_id){
		$query=$this->db->query("select * from $table where restuarant_id='$res_id'");
		$result = $query->result();
		return $result; 
	}
	function getSectionsData($table,$res_id){
		$query=$this->db->query("select * from $table where restaurants_id='$res_id'");
		$result = $query->result();
		return $result; 
	}
	function getItemTypeData($table,$res_id){
		$query=$this->db->query("SELECT * FROM $table WHERE restaurants_id='$res_id'");
		$result = $query->result();
		return $result; 
	}
	function getCategoryData($table,$res_id){
		$query=$this->db->query("select * from $table where restuarant_id='$res_id'");
		$result = $query->result();
		return $result; 
	}
	function getZoneData(){
		$query=$this->db->query("select * from mst_zones");
			$result = $query->result();
			return $result;
	}
	function getzonename(){
		$query=$this->db->query("select * from mst_zones");
		$result = $query->result();
		return $result;
	}
	function getshowsections($table,$id){
		$query=$this->db->query("select * from $table where zones_id='$id'");
		$result = $query->result();
		return $result;
	}
	function getSectionByzone($zone,$res_id)
	{
		$query=$this->db->query("select * from mst_section where zones_id='$zone' and restaurants_id='$res_id'");
		$result = $query->result();
		return $result;
	}
	function getZoneNamedata($table){
		$query=$this->db->query("select * from $table");
		$result = $query->result();
		return $result;
	}
	function getSectionDataById($table,$res_id){
		
		$query=$this->db->query("select * from $table where restaurants_id='$res_id'");
		$result = $query->result();
		return $result;
	}
	function updateItems($table,$dataBaseid,$id,$data){
		$this->db->where($dataBaseid,$id);
		$this->db->update($table,$data);
	}
	function getOrderHistory($from_date,$to_date,$sk_restaurant_id){
		$sql=$this->db->query("SELECT mst_order.*,mst_user.full_name,mst_restaurants.restaurant_name FROM mst_order LEFT JOIN mst_user ON mst_order.user_id =mst_user.sk_user_id LEFT JOIN mst_restaurants ON mst_order.restuarant_id = mst_restaurants.sk_restaurant_id where mst_order.restuarant_id='$sk_restaurant_id' and mst_order.ordered_date BETWEEN '$from_date' AND '$to_date'");
		return $sql->result();
	}
	function getSectionDataByIdedit($table,$res_id){
		
		$query=$this->db->query("select * from $table where sk_section_id='$res_id'");
		$result = $query->result();
		return $result;
	}
	public function getsectiondatabyedit($table,$section_id){
		
		$query=$this->db->query("select * from $table where sk_section_id='$section_id'");
		$result = $query->result();
		return $result;
	}
	
	public function categoryNamebyId($table,$category_id){
		
		$query=$this->db->query("select items_categoryname from $table where sk_category_id='$category_id'");
		$result = $query->result();
		return $result;
	}
	
	function getOrderCount($user_type,$order_status,$rest_id,$date)
	{
		$q="";
		if($user_type=='store'){
			$q=" and restuarant_id='$rest_id'";
		}
		$sql = "SELECT count(sk_order_id) as order_count FROM mst_order WHERE order_status=? and ordered_date = ?".$q;
	    $binds = array($order_status,$date);
	    $query = $this->db->query($sql, $binds);
	    if ($query->num_rows() > 0) {
	        return $query->result();
	    }
	    else {
	        return false;
	    }
		
	}
	function getRestaurants($res_id)
			{
				$query = $this->db->query("SELECT * FROM mst_restaurants where sk_restaurant_id ='$res_id'");
				$result = $query->result();
				return $result;
				
			}
	function getOrderHistoryday($date,$res_id,$orderType)
	{
			$query=$this->db->query("SELECT *, mst_restaurants.restaurant_name,mst_user.full_name FROM mst_order join mst_restaurants on mst_order.restuarant_id=mst_restaurants.sk_restaurant_id JOIN mst_user ON mst_order.user_id=mst_user.sk_user_id WHERE ordered_date='$date' and restuarant_id='$res_id' and order_status='pending' and orderType='$orderType'");
				return $query->result();
		
	}
	function Update($table,$cond,$email,$data)
	{
		$this->db->where($cond,$email);
		$this->db->update($table,$data);
	} 
	function getneworders($id){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order_details.order_id='$id'");
			$result = $query->result();
			return $result;
	}
	function getdeliveredorders($id){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order_details.order_id='$id'");
			$result = $query->result();
			return $result;
	}
	function getOrderHistorydaysuccess($date,$res_id)
	{
		$query=$this->db->query("SELECT *, mst_restaurants.restaurant_name,mst_user.full_name FROM mst_order join mst_restaurants on mst_order.restuarant_id=mst_restaurants.sk_restaurant_id JOIN mst_user ON mst_order.user_id=mst_user.sk_user_id WHERE ordered_date='$date' and restuarant_id='$res_id' and order_status='success' and payment_status='Success'");
		return $query->result();

	}
	function getOrderHistorydaycancel($date,$res_id)
	{
		$query=$this->db->query("SELECT *, mst_restaurants.restaurant_name,mst_user.full_name FROM mst_order join mst_restaurants on mst_order.restuarant_id=mst_restaurants.sk_restaurant_id JOIN mst_user ON mst_order.user_id=mst_user.sk_user_id WHERE ordered_date='$date' and restuarant_id='$res_id' and order_status='cancelled'");
		return $query->result();

	}
	function getcancelorders($id){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order_details.order_id='$id'");
			$result = $query->result();
			return $result;
	}
	function gettotalordervalues($date,$res_id){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order.payment_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order.order_status='success' and mst_order.payment_status='success' and mst_order.ordered_date='$date' and mst_order.restuarant_id='$res_id'");
			$result = $query->result();
			return $result;
	}
	function getOrderHistorydaybyval($date,$res_id)
	{
		$query=$this->db->query("SELECT *, mst_restaurants.restaurant_name,mst_user.full_name FROM mst_order join mst_restaurants on mst_order.restuarant_id=mst_restaurants.sk_restaurant_id JOIN mst_user ON mst_order.user_id=mst_user.sk_user_id WHERE ordered_date='$date' and restuarant_id='$res_id' and order_status='success' and payment_status='success'");
		return $query->result();

	}
	function gettotalordervalues1($id){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order_details.order_id='$id'");
		$result = $query->result();
		return $result;
	}
	function getCoupon($table,$status)
	{
		$query=$this->db->query("select * from $table where restaurants_id ='$status'");
		$result = $query->result();
		return $result;
	}
	function getCustomerDetails($order_id){
		$query=$this->db->query("SELECT mst_order.table_no,mst_order.user_id,mst_order.restuarant_id,mst_order.ordered_date,mst_order.ordered_time,mst_order.total_order_quantity,mst_order.payment_mode,mst_order.total_order_value,mst_order.payment_status,mst_user.full_name,mst_user.mobile as user_mobile,mst_user.email as user_email,mst_user.postal_Address,mst_order_details.item_id,mst_order_details.addon_id,mst_order_details.order_data,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name,mst_restaurants.email,mst_restaurants.mobile,mst_restaurants.address,mst_restaurants.city,mst_restaurants.state,mst_restaurants.country,mst_items.item_name,mst_items.actual_price,mst_item_addons.addon_name FROM mst_order JOIN mst_user on mst_order.user_id=mst_user.sk_user_id JOIN mst_restaurants on mst_order.restuarant_id=mst_restaurants.sk_restaurant_id join mst_order_details on mst_order.sk_order_id=mst_order_details.order_id JOIN mst_items on mst_order_details.item_id=mst_items.sk_items_id join mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id WHERE mst_order.sk_order_id='$order_id' and mst_order.order_status='success'");
		$result = $query->result();
		return $result;
	}
	function getSMTP($table,$settingType){
		$query=$this->db->query("select * from $table where setting_type ='$settingType'");
		$result = $query->result();
		return $result;
	}
	function getPayment($table,$res_id){
		$query=$this->db->query("select * from $table where sk_restaurant_id ='$res_id'");
		$result = $query->result();
		return $result;
	}
	function update_Payment($table,$res_id,$data){
		
		$this->db->where('sk_restaurant_id',$res_id);
		$this->db->update($table,$data);
	}
	function getaddons($table,$id){
		$query=$this->db->query("select * from $table where sk_addon_id ='$id'");
		$result = $query->result();
		return $result;
	}
	function getitems($table,$id){
		$query=$this->db->query("select * from $table where sk_items_id ='$id'");
		$result = $query->result();
		return $result;
	}
	function getrestuarantName($res_id){
		$query=$this->db->query("select restaurant_name from mst_restaurants where sk_restaurant_id='$res_id'");
		$result = $query->result();
		return $result;
	}
	function getneworder_full($order_id){
		$query=$this->db->query("SELECT mst_order.total_order_value,mst_order.userNotes,mst_order.table_no,mst_order.orderType,mst_order.discount_amount,mst_items.item_name,mst_items.actual_price,mst_order.payment_mode,mst_item_addons.addon_name,mst_item_addons.addon_price,mst_order_details.order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name,mst_restaurants.email as res_email,mst_restaurants.mobile as res_mobile,mst_restaurants.phone_number,mst_restaurants.country,mst_restaurants.state,mst_restaurants.city,mst_restaurants.address,mst_user.full_name,mst_user.mobile as user_mobile,mst_user.email as user_email,mst_user.postal_Address,mst_order.ordered_date,mst_order.ordered_time FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id LEFT JOIN mst_user on mst_order.user_id=mst_user.sk_user_id where mst_order_details.order_id='$order_id'");
		$result = $query->result();
		return $result;
	}
	function getitemsbyId($table,$id){
		$query=$this->db->query("select * from $table where sk_items_id ='$id'");
		$result = $query->result();
		return $result;
	}
	function getorderhistoryofall($id){
		$query=$this->db->query("SELECT mst_items.item_name,mst_item_addons.addon_name,mst_order.sk_order_id,mst_order.order_status,mst_order_details.cart_count,mst_order_details.cprice,mst_restaurants.restaurant_name FROM `mst_order_details` LEFT JOIN mst_item_addons on mst_order_details.addon_id=mst_item_addons.sk_addon_id LEFT JOIN mst_items ON mst_order_details.item_id=mst_items.sk_items_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id LEFT JOIN mst_order on mst_order.sk_order_id=mst_order_details.order_id where mst_order_details.order_id='$id'");
		$result = $query->result();
		return $result;
	}
	function getOrderValue($rest_id,$date)
	{
		//echo $date;
		$query=$this->db->query("select * from mst_order where payment_status='Success' and order_status='success' and ordered_date='$date' and restuarant_id='$rest_id'");
		$query=$query->result();
		return $query;
	}
}
?>