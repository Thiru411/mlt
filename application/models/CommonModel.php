<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class CommonModel extends CI_Model{
	
    public function __construct() 
	{
		parent::__construct();
		$this->load->library("session");

		$this->load->library('form_validation');	
	}
	
	
	/**
	 * Returns an encrypted & utf8-encoded
	 */
	public function encryption($payload) {
		return $encryptedId = JWT::encode(2,pkey);
	}
	public function decryption($cipher) {
		return $encryptedId = JWT::decode($cipher,pkey);
	} 	
 	function encrypt($pure_string) {
		 $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
		 
	   $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
	    
	    # creates a cipher text compatible with AES (Rijndael block size = 128)
	    # to keep the text confidential 
	    # only suitable for encoded input that never ends with value 00h
	    # (because of default zero padding)
	    $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
	                                 $pure_string, MCRYPT_MODE_CBC, $iv);
	    # prepend the IV for it to be available for decryption
	    $ciphertext = $iv . $ciphertext;
	    
	    # encode the resulting cipher text so it can be represented by a string
	   // $ciphertext_base64 = base64_encode($ciphertext);
	    $ciphertext_base64 =rtrim(strtr(base64_encode($ciphertext), '+/', '-_'), '=');// base64_encode($ciphertext);
	    return $ciphertext_base64;
	}
	
	/**
	 * Returns decrypted original string
	 */
	function decrypt($encrypted_string) {
		
		
		
		 $key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
		 
		  $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
	    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		 
	   // $ciphertext_dec = base64_decode($encrypted_string);
	    $ciphertext_dec =base64_decode(str_pad(strtr($encrypted_string, '-_', '+/'), strlen($encrypted_string) % 4, '=', STR_PAD_RIGHT));  // base64_decode($encrypted_string);
	    
	    # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
	    $iv_dec = substr($ciphertext_dec, 0, $iv_size);
	    
	    # retrieves the cipher text (everything except the $iv_size in the front)
	    $ciphertext_dec = substr($ciphertext_dec, $iv_size);
	
	    # may remove 00h valued characters from end of plain text
	    $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
	                                    $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
 	    return $plaintext_dec;
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
	public function getRecords20($where,$table) {
		$this->db->select("*");
		$this->db->order_by('sk_cart_id','desc');
		$query = $this->db->get_where($table, $where);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}
	}
	function save($data,$table) 
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}

	
	
	function updateRecords($data,$where,$table) {
		$this->db->where($where);
		$this->db->update($table,$data);
		if($this->db->affected_rows()>0) {
			return true;
		}
		else {
			return false;
		}
	}
	function getRecordsQuery($sql,$binds){
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}	
	  
	function deleteRecords($where,$table){
		$this->db->where($where);
		$this->db->delete($table);
	}
	
	

	
}



