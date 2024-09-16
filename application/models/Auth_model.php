<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class Auth_model extends CI_Model{
   
    public function __construct() 
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library('form_validation');	
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

	/* function signin($email, $password)
	{
		$query=$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
	    $password=md5($password);
	    $query=$this->db->query("select * from mst_restaurants where email='$email' and password='$password' and restaurant_status=1");
	    
	    if($query -> num_rows() == 1)
	    {
	        return $query->result();
	    }
	    else
	    {
	        return false;
	    }
	} */
	
	function signin($email, $password)
	{
		$query=$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
		$password=md5($password);
		
		$query=$this->db->query("SELECT CASE WHEN (admin_count >0 || rest_count >0) THEN 'success' else 'Faliure' END AS result,res1.*,res2.* FROM
				(SELECT COUNT(*)as admin_count,mst_admin.* FROM `mst_admin` WHERE email ='$email' AND password ='$password' AND admin_status ='1')res1 JOIN
				(SELECT COUNT(*)as rest_count,mst_restaurants.* FROM `mst_restaurants` WHERE email='$email' AND password ='$password' AND restaurant_status=1)res2");
				if($query -> num_rows() == 1)
				{
				return $query->result();
	}
				else
				{
				return false;
	};
	}
	
	function storeSignin($res_id)
	{
	    
	    $query=$this->db->query("select * from mst_restaurants where sk_restaurant_id='$res_id'");
	    
	    if($query -> num_rows() == 1)
	    {
	        return $query->result();
	    }
	    else
	    {
	        return false;
	    }
	}

	function Deliverysignin($email, $password)
	{
		$query=$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
	    $password=md5($password);
	    $query=$this->db->query("select * from mst_deliveryboy where email='$email' and password='$password' and deliveryboy_status=1");
	    
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
	/********************Category***********************/
}




