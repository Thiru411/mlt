<?php if (!defined('BASEPATH'))exit('No direct script access allowed');

class ApiModel extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("session");
		$this->load->library('form_validation');
		//$this->load->library("Exceptions");
	}
	
	
	/*******************Aahara***********************/
	
		/********************SAVE***********************/
		function common_data(){
				$query=$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
			}
			
			function Save($data,$table)
			{
				$this->db->insert($table,$data);
				//$this->Exceptions->checkForError();
				return $this->db->insert_id();
			}

			function insert_batch($data, $table)
			{

				$this->db->insert_batch($table, $data);
				
			}

			
			/********************UPDATE***********************/
			function Update($data,$table,$cond,$value)
			{
				$this->db->where($cond,$value);
				$this->db->update($table,$data);
				return $this->db->affected_rows();
			}
			
			/* function Update1($data,$table,$cond,$value)
			{
				$this->db->where($cond,$value);
				$this->db->update($table,$data);
				return $this->db->affected_rows();
			} */
			
			function deleteCartItem($item,$restaurantId,$userID)
			{
        $sql=" delete  from mst_cart where Citem_id =$item and Crestuarants_id = $restaurantId and Cuser_id =$userID ";
        $binds = array();
        $query = $this->db->query($sql,$binds);
        
        
      }
	  /*******update******/
	  function updateRecords($data,$where,$table) 
	  {
				$this->db->where($where);
				$this->db->update($table,$data);
				if($this->db->affected_rows()>0) {
					return true;
				}
				else {
					return false;
				}
		}
			
			function updateMore($data,$table,$cond1,$value1,$cond2,$value2) {
				$this->db->where($cond1,$value1);
				$this->db->where($cond2,$value2);
				$this->db->update($table,$data);
				return $this->db->affected_rows();
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
			/**********************single column******************/
			function data_exits1($value,$column,$table_name) {
				$sql = "select * from $table_name where $column=? ";
				$binds = array($value);
				$query = $this->db->query($sql, $binds);
				if ($query->num_rows() > 0) {
					return $query->result();
				}
				else {
					return false;
				}
			}
			/******************getcart*************************/
			function GetCart($userid)
			{
				$sql = "SELECT mst_cart.*,mst_items.*,mst_restaurants.Delivery_Charges,mst_restaurants.tax_amount,(IF(new_price IS NULL or new_price = '', (actual_price*cart_count),(new_price*cart_count)))amount FROM mst_cart LEFT join mst_items ON mst_cart.Citem_id= mst_items.sk_items_id LEFT JOIN mst_restaurants on  mst_restaurants.sk_restaurant_id =mst_cart.Crestuarants_id  where Cuser_id = ? and cart_count > 0 and cart_status='active'";
					$binds = array($userid);
					$result1 = $this->db->query($sql, $binds);
					if ($result1->num_rows() > 0) {
					return $result1->result();
					} else {
					return false;
			}
		}
			/****************in updated api  */
			function GetCartByID($userid, $cart_id)
			{
				$sql = "SELECT mst_cart.*,mst_items.*,mst_restaurants.Delivery_Charges,mst_restaurants.tax_amount,(IF(new_price IS NULL or new_price = '', (actual_price*cart_count),(new_price*cart_count)))amount FROM mst_cart LEFT join mst_items ON mst_cart.Citem_id= mst_items.sk_items_id LEFT JOIN mst_restaurants on  mst_restaurants.sk_restaurant_id =mst_cart.Crestuarants_id  where Cuser_id = ?  and sk_cart_id=? and cart_count > 0 and cart_status='active'";
					$binds = array($userid, $cart_id);
					$result1 = $this->db->query($sql, $binds);
					if ($result1->num_rows() > 0) {
					return $result1->result();
					} else {
					return false;
			}
    
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
			function deleteContent($table,$data) {
				$this->db->delete($table, $data);
			}

			function delete($table,$column,$value,$column1,$value1) {
				$this->db->where($column,$value);
				$this->db->where($column1,$value1);
				$this->db->delete($table);
			}
	
	    function getCountry(){
	    	$sql=" select * from mst_country_states";
	    	$binds = array();
	    	$query = $this->db->query($sql,$binds);
	    	if ($query->num_rows() > 0) {
	    		return $query->result();
	    	} else {
	    		return false;
	    	}
	    }
	    function getState(){
	    	$sql=" select * from  mst_state";
	    	$binds = array();
	    	$query = $this->db->query($sql,$binds);
	    	if ($query->num_rows() > 0) {
	    		return $query->result();
	    	} else {
	    		return false;
	    	}
	    }
		function stateDetailsbyCountry($cname) {
			$sql = "SELECT state_name from mst_country_states where country_name ='$cname'";
			$query = $this->db->query($sql);
			 
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
	
		}
		function getcityDetails($sname) {
			$sql = "SELECT * from mst_states_cities where state_id ='$sname'";
			$query = $this->db->query($sql);
		
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
		
		}
		public function showCategoryById($data)
		{
			$this->db->select('*');
			$this->db->from('mst_category');
			$this->db->where('sk_category_id', $data);
			$query = $this->db->get();
			$result = $query->result();
			return $result;
		}
		
		function data_exits($value,$column,$value1,$column1,$table_name) {
			$sql = "select * from $table_name where $column=? and $column1=? ";
			$binds = array($value,$value1);
			$query = $this->db->query($sql, $binds);
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
		}
		function data_exits_update($value,$column,$value1,$column1,$table_name) {
			$sql = "select * from $table_name where $column=? and $column1!=? ";
			$binds = array($value,$value1);
			$query = $this->db->query($sql, $binds);
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
		}
		/****************delete restuarants  in cart */
	function deleterestuarants($restuarants_id,$item_id)
    {
    	$sql = "delete from mst_cart where   Crestuarants_id=? and Citem_id=?";
    	$binds = array($restuarants_id,$item_id);
		$result1 = $this->db->query($sql, $binds);
		return $result1;
    	/*if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}*/
    
	}
	function deletecart($count)
    {
    	$sql = "delete from mst_cart where cart_count=?";
    	$binds = array($count);
		$result1 = $this->db->query($sql, $binds);
		return $result1;
    	/*if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}*/
    
	}

		
		function getData($table_name) {
			$sql = "select * from $table_name  ";
			$binds = array();
			$query = $this->db->query($sql, $binds);
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
		}
		
		public function getAllCategory()
		{
			$sql = "select mst_category.*,mst_section.section_name from mst_category left join mst_section on mst_section.sk_section_id= mst_category.section_id ";
			//$sql = "select mst_states_cities.*,mst_state.state_name from mst_city left join mst_state on mst_state.sk_state_id= mst_states_cities.state_id ";
			$binds = array();
			$query = $this->db->query($sql, $binds);
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
		}
		/******************add city********************/
		public function getAllCity()
		{
			$sql = "select mst_states_cities.*,mst_state.state_name from mst_states_cities left join mst_state on mst_state.sk_state_id= mst_states_cities.state_id ";
			
			$binds = array();
			$query = $this->db->query($sql, $binds);
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
		}
		public function getCategoryBySection($section_id,$category_name,$category_id)
		{
			$sql = "select mst_category.* from mst_category where section_id= '$section_id' and category_name='$category_name' and sk_category_id != $category_id ";
			$binds = array();
			$query = $this->db->query($sql, $binds);
			if ($query->num_rows() > 0) {
				return $query->result();
			}
			else {
				return false;
			}
		}
		
/************Check email and mobile number************/

    public function checkEmailMobile($mobile,$email) {
        $sql = "SELECT (CASE
        WHEN (mobile_count > 0 && email_count > 0)THEN 'Email and Mobile Number Exits'
        WHEN email_count > 0 THEN '1'
        WHEN mobile_count >0 THEN '2'
        ELSE '0'
        END)email_mobile

        FROM(SELECT COUNT(*) as email_count FROM `mst_restaurants` WHERE email ='$email')res1
        JOIN
        (SELECT COUNT(*) as mobile_count FROM `mst_restaurants` WHERE mobile='$mobile')res2";
        $binds = array();
        $query = $this->db->query($sql, $binds);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    /*****************Check email and mobile for update*****************/

    public function checkEmailMobileUpdate($mobile,$email,$restaurantId) {
        $sql = "SELECT (CASE
        WHEN (mobile_count > 0 && email_count > 0)THEN 'Email and Mobile Number Exits'
        WHEN email_count > 0 THEN 'Email already exits'
        WHEN mobile_count >0 THEN 'Mobile already exits'
        ELSE 'valid'
        END)email_mobile

        FROM(SELECT COUNT(*) as email_count FROM `mst_restaurants` WHERE email ='$email' and sk_restaurant_id !=$restaurantId)res1
        JOIN
        (SELECT COUNT(*) as mobile_count FROM `mst_restaurants` WHERE mobile='$mobile' and sk_restaurant_id !=$restaurantId)res2";
        $binds = array();
        $query = $this->db->query($sql, $binds);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
/***********************restrant_login****************/
    function Login($email_id,$password)
    {
    	$sql = "SELECT * FROM mst_restaurants WHERE (email=?) and password=? and restaurant_status='1'";
    	$binds = array($email_id,$password);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    }	
	/***************iteams for category******************/
    function getIteams(){
    	$sql=" select * from mst_category";
    	$binds = array();
    	$query = $this->db->query($sql,$binds);
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}
    }
    function getRestuarant(){
    	$sql=" select * from mst_restaurants";
    	$binds = array();
    	$query = $this->db->query($sql,$binds);
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}
    }
    /*************** section**********/
    function getRestuarantofsection(){
    	$sql=" select * from mst_section";
    	$binds = array();
    	$query = $this->db->query($sql,$binds);
    	if ($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}
    }
    /**************get restuarant******/

	  /*****************maxitems***************************/
    function getcity($cityid)
    {
    	$sql = "SELECT distinct(section_id),section_name ,restaurant_name,store_type,rating,logo FROM `mst_restaurants`,mst_section WHERE city='$cityid' and sk_section_id=section_id";
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    }
	/******* delete one_row****/
	function delete_one($table,$column,$value) {
				$this->db->where($column,$value);
				
				$this->db->delete($table);
			}
    function getsection($section_id)
    {
    	$sql = "SELECT * FROM mst_section WHERE sk_section_id='?'";
    	$binds = array($section_id);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    }
   /*  function getMax($table,$id) {
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
    }   */ 
    
    function GetRestaurantDetails($cityid)
    {
    	$sql = "SELECT mst_restaurants.*,mst_section.section_name FROM `mst_restaurants` LEFT JOIN mst_section ON mst_restaurants.section_id=mst_section.sk_section_id where city = ? and restaurant_status = 1 GROUP by section_id";
    	$binds = array($cityid);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    }
    
    /**************RestaurantInDetails**********************/
    function GetRestaurantOfIteamDetails($restuarants_id)
    {
    	$sql = "SELECT mst_items.*, mst_category.Items_categoryname FROM `mst_items` LEFT JOIN mst_category ON mst_items.categoryitem_id=mst_category.sk_category_id where restuarants_id=? group by categoryitem_id";
    	$binds = array($restuarants_id);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    }
    
   /*  function GetRestaurantOfIteamDetails($restuarants_id)
    {
    	$sql = "SELECT mst_items.*, mst_categoryitems.Items_categoryname FROM `mst_items` LEFT JOIN mst_categoryitems ON mst_items.categoryitem_id=mst_categoryitems.sk_categoryItems_id where restuarants_id=? group by categoryitem_id";
    	$binds = array($restuarants_id);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    } */
    
    /************************************cart********************************/
    function GetRestaurantOfCartIDetails($userid)
    {
    	$sql = "select mst_items.*, mst_cart.Citem_id, mst_cart.sk_cart_id,mst_cart.cart_count from mst_items left join mst_cart on mst_cart.Citem_id =mst_items.sk_items_id where mst_cart.Cuser_id=?";
    	$binds = array($userid);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    }
	
	function getcountByItem($userid,$itemID,$restID){

		$sql = "SELECT cart_count ,sk_cart_id FROM `mst_cart` WHERE `Citem_id`= $itemID AND `Crestuarants_id` = $restID AND`Cuser_id` = $userid";
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
		if ($result1->num_rows() > 0) 
		{
    		return $result1->result();
		} else 
		{
    		return false;
    	}

	}

	public function cartCount($item_id,$user_id,$status) {
		if($item_id!="") {
			$sql = "select * from mst_cart where Citem_id=? and Cuser_id=? and cart_status!=? ";
			 $binds = array($item_id,$user_id,$status);
		}
		else {
			$sql = "select * from mst_cart where Cuser_id=? and cart_status!=?";
			 $binds = array($user_id,$status);
		}
		 $query = $this->db->query($sql, $binds);
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 }
		 else {
			 return false;
		 }
	 }

	 function getcartDetailsByUser($user_id){
		 $sql="SELECT SUM(cprice)totalOrderPrice,mst_restaurants.*,mst_cart.* FROM mst_cart LEFT JOIN mst_restaurants ON mst_cart.Crestuarants_id =mst_restaurants.sk_restaurant_id where Cuser_id = $user_id and cart_status = 'active'";
		 $query = $this->db->query($sql);
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 }
		 else {
			 return false;
		 }
	 }

	 

	 function getItemPrice($itemId,$itemCount){
		 //$sql="SELECT (mst_items.new_price * $itemCount )as cprice FROM mst_items WHERE mst_items.sk_items_id = $itemId";
	 	$sql="SELECT  (IF(new_price IS NULL or new_price = '', (actual_price*$itemCount),(new_price*$itemCount)))cprice  FROM mst_items WHERE mst_items.sk_items_id = $itemId";
		 $query = $this->db->query($sql);
		 if ($query->num_rows() > 0) {
			 return $query->result();
		 }
		 else {
			 return false;
		 }
	 }





	 /***************************june 2nd insert cart and history ******************************************/
	 function deleteone($table,$column,$value) 
	 {
				$this->db->where($column,$value);
				$this->db->delete($table);
	 }

	 function getUserData($mobile){
		$sql = "SELECT * FROM mst_user LEFT JOIN mst_states_cities ON mst_user.last_login_city =mst_states_cities.city_id WHERE mobile = '$mobile'";
		$binds = array();
		$query = $this->db->query($sql, $binds);
		if ($query->num_rows() > 0) {
			return $query->result();
		}
		else {
			return false;
		}

	}
	 /*=================================order_history======================================================*/
	
	function GetOrderdetails($user_id)
    {
		$sql = "SELECT mst_restaurants.*,mst_order.*,mst_order.created_date as orderCreated_date,mst_states_cities.city_name,mst_coupon.sk_coupon_id,mst_coupon.discount FROM mst_order left JOIN mst_restaurants ON mst_order.restuarant_id =mst_restaurants.sk_restaurant_id left join mst_states_cities on mst_states_cities.city_id = mst_restaurants.city LEFT JOIN mst_coupon ON mst_coupon.sk_coupon_id= mst_order.coupon_id
		 where mst_order.user_id= ? order by sk_order_id  desc ";
		//$sql="SELECT * FROM mst_order left JOIN mst_order_details INNER JOIN mst_restaurants on mst_order_details.restuarant_id=mst_restaurants.sk_restaurant_id on mst_order_details.order_id=mst_order.sk_order_id where mst_order.user_id=?";
    	$binds = array($user_id);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}
	/*=================================order_history=======================================================*/
	function Orderdetails($order_id)
    {
    	$sql = "SELECT * FROM mst_order_details  LEFT JOIN mst_items ON mst_order_details.item_id =mst_items.sk_items_id WHERE mst_order_details.order_id= ? and cart_count > 0";
    	$binds = array($order_id);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
	}
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

			/*
			function getcity($stateName) {
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
			
			*/

			function delete1($userid)
	  {
	  	$sql = 'DELETE FROM mst_cart WHERE Cuser_id=? ';
	  	$binds = array($userid);
	  	$query = $this->db->query($sql, $binds);
	  
	  }

	  /***************************ordersummary********** */
	  function GetOrderdetailsbyId($user_id,$order_id)
    {
		$sql = "SELECT mst_restaurants.*,mst_order.*,mst_order.created_date as orderCreated_date,mst_states_cities.city_name as city_name,mst_coupon.sk_coupon_id,mst_coupon.discount  FROM mst_order left JOIN mst_restaurants ON mst_order.restuarant_id =mst_restaurants.sk_restaurant_id  left join mst_states_cities on  mst_states_cities.city_id = mst_restaurants.city LEFT JOIN mst_coupon ON mst_coupon.sk_coupon_id= mst_order.coupon_id
		where mst_order.user_id= ? and sk_order_id =? order by sk_order_id  desc ";
		//$sql="SELECT * FROM mst_order left JOIN mst_order_details INNER JOIN mst_restaurants on mst_order_details.restuarant_id=mst_restaurants.sk_restaurant_id on mst_order_details.order_id=mst_order.sk_order_id where mst_order.user_id=?";
    	$binds = array($user_id,$order_id);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}
	/*******************************merging ordertable and address table */
	function getorderinfo($user_id,$order_id)
    {
		$sql = "SELECT mst_order.*, mst_useraddress.* from mst_order left join mst_useraddress on mst_useraddress.sk_address_id=mst_order.user_address where mst_order.user_id=? and mst_order.sk_order_id=?";
		//$sql="SELECT * FROM mst_order left JOIN mst_order_details INNER JOIN mst_restaurants on mst_order_details.restuarant_id=mst_restaurants.sk_restaurant_id on mst_order_details.order_id=mst_order.sk_order_id where mst_order.user_id=?";
    	$binds = array($user_id,$order_id);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}

	function getUserAddress($userId)
    {
		$sql = "SELECT mst_useraddress.* from mst_useraddress where address_userId =$userId order by sk_address_id desc limit 5";
		
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}

	/*function getDeliveryDetails($userId)
    {
		$sql = "SELECT mst_order.*,mst_order_details.*,mst_items.*,mst_useraddress.*,mst_restaurants.restaurant_name,mst_order.created_time as order_date FROM `mst_order` LEFT JOIN mst_order_details ON mst_order.sk_order_id =mst_order_details.order_id LEFT JOIN mst_items ON mst_items.sk_items_id=mst_order_details.item_id LEFT JOIN mst_useraddress ON mst_order.user_address =mst_useraddress.sk_address_id LEFT JOIN mst_restaurants ON mst_order.restuarant_id = mst_restaurants.sk_restaurant_id  WHERE mst_order.deliveryboy_id ='$userId'";
		
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}*/

	function getDeliveryDetails($userId)
    {
		$sql = "SELECT mst_restaurants.*,mst_order.*,mst_order.created_time as orderCreated_date,mst_states_cities.city_name,mst_useraddress.*,mst_user.mobile AS user_mobile,mst_user.sk_user_id FROM mst_order left JOIN mst_restaurants ON mst_order.restuarant_id =mst_restaurants.sk_restaurant_id left join mst_states_cities on mst_states_cities.city_id = mst_restaurants.city LEFT JOIN mst_order_details ON mst_order.sk_order_id =mst_order_details.order_id LEFT JOIN mst_useraddress ON mst_order.user_address =mst_useraddress.sk_address_id LEFT JOIN mst_user ON mst_order.user_id =mst_user.sk_user_id
		 where mst_order.deliveryboy_id= ? and (order_status ='OutForDelivery' || order_status ='placed' ) GROUP BY sk_order_id order by sk_order_id  desc ";
		
    	$binds = array($userId);
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}

	//pending order by restaurant

	function getPendingList($restuarantId)
    {
		$sql = "select *,mst_user.mobile as user_number,mst_order.created_time as order_date FROM `mst_restaurants` LEFT JOIN mst_order ON mst_order.restuarant_id =mst_restaurants.sk_restaurant_id LEFT JOIN mst_user ON mst_user.sk_user_id=mst_order.user_id LEFT JOIN mst_useraddress ON mst_useraddress.sk_address_id=mst_order.user_address WHERE mst_order.order_status='placed' and restuarant_id ='$restuarantId' GROUP BY sk_order_id ORDER BY sk_order_id DESC";
		
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}

	function deliveredOrders($from_date,$to_date,$restuarant_id)
    {
		$sql = "SELECT * FROM `mst_restaurants` LEFT JOIN mst_order ON mst_order.restuarant_id =mst_restaurants.sk_restaurant_id LEFT JOIN mst_user ON mst_order.user_id = mst_user.sk_user_id LEFT JOIN mst_useraddress ON mst_order.user_address =mst_useraddress.sk_address_id

		WHERE mst_order.order_status='delivered' and
				 restuarant_id ='$restuarant_id' and mst_order.created_date between '$from_date' and '$to_date'  GROUP BY sk_order_id ORDER BY sk_order_id DESC";
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}

	

	function getOrderCompleteDetails($id){

        /*$this->db->select('o.*,od.* ,i.*,u.*,r.*')
                ->from('mst_order as o')
                ->join('mst_order_details as od', 'o.sk_order_id = od.order_id')
                ->join('mst_items as i', 'od.item_id=i.sk_items_id')
                ->join('mst_user as u', 'od.user_id=u.sk_user_id')
                ->join('mst_restaurants as r', 'od.restuarant_id=r.sk_restaurant_id')
                ->where("od.order_id=".$id);
        return $this->db->get()->result_array();*/

        

        $sql = "SELECT *,mst_user.email as user_email,mst_user.mobile as user_mobile FROM mst_order_details LEFT JOIN mst_order ON mst_order.sk_order_id =mst_order_details.order_id LEFT JOIN mst_items ON mst_items.sk_items_id = mst_order_details.item_id LEFT JOIN mst_user ON mst_user.sk_user_id =mst_order_details.user_id LEFT JOIN mst_restaurants ON mst_restaurants.sk_restaurant_id=mst_order_details.restuarant_id WHERE mst_order_details.order_id = $id";
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
	}
	
	


	function getRestuarantStore($section_id,$city_id)
    {
		$sql = "SELECT mst_restaurants.*,mst_store_type.store_type as store_type FROM mst_restaurants left JOIN mst_store_type ON mst_restaurants.store_type =mst_store_type.sk_store_type_id WHERE section_id='$section_id' and city='$city_id' AND restaurant_status ='1'";
    	$binds = array();
    	$result1 = $this->db->query($sql, $binds);
    	if ($result1->num_rows() > 0) {
    		return $result1->result();
    	} else {
    		return false;
    	}
    
    
	}

	// delivered list

function getOrdersByDeliveryboy($userId)
{
	$sql = "SELECT mst_restaurants.*,mst_order.*,mst_order.created_time as orderCreated_date,mst_states_cities.city_name,mst_useraddress.*,mst_user.mobile AS user_mobile,mst_user.sk_user_id FROM mst_order left JOIN mst_restaurants ON mst_order.restuarant_id =mst_restaurants.sk_restaurant_id left join mst_states_cities on mst_states_cities.city_id = mst_restaurants.city LEFT JOIN mst_order_details ON mst_order.sk_order_id =mst_order_details.order_id LEFT JOIN mst_useraddress ON mst_order.user_address =mst_useraddress.sk_address_id LEFT JOIN mst_user ON mst_order.user_id =mst_user.sk_user_id
	 where mst_order.deliveryboy_id= ? and order_status ='delivered'  GROUP BY sk_order_id order by sk_order_id  desc ";
	
	$binds = array($userId);
	$result1 = $this->db->query($sql, $binds);
	if ($result1->num_rows() > 0) {
		return $result1->result();
	} else {
		return false;
	}


}

			function getdevicetoken($orderid)
				{
						$query = $this->db->query("SELECT mst_user.*,(mst_deliveryboy.name)as deliveryboy_name,mst_order.* FROM mst_order LEFT JOIN mst_user on mst_order.user_id = mst_user.sk_user_id  LEFT JOIN mst_deliveryboy ON mst_order.deliveryboy_id =mst_deliveryboy.sk_deliveryboy_id WHERE 
							sk_order_id = '$orderid'");
						$result = $query->result();
						return $result;
				}


				/************ coupon verify ***************/
			
	function checkCoupon($couponCode)
	{
		
		$sql = "SELECT * FROM `mst_coupon` WHERE coupon_code =? AND (start_date <= CURRENT_DATE AND end_date >= CURRENT_DATE) AND coupon_status ='1' ";
		$binds = array($couponCode);
		$result1 = $this->db->query($sql, $binds);
		if ($result1->num_rows() > 0) {
			return $result1->result();
		} else {
			return false;
		}
	}
	/************ coupon verify ***************/

/******* getStatusOfRestaurant**** */
				

				function getStatusOfRestaurant($day,$restaurantId)
				{
					$sql = "SELECT * FROM `mst_timing` WHERE day='$day' AND rest_id='$restaurantId' AND timing_status='1'";
					$binds = array();
					$result1 = $this->db->query($sql, $binds);
					if ($result1->num_rows() > 0) {
						return $result1->result();
					} else {
						return false;
					}
				}


				/******* getStatusOfRestaurant**** */


				/******* check coupon is user or not**** */
				

				function getCouponStatus($coupon_id,$userId)
				{
					$sql = "SELECT * FROM mst_user_coupon WHERE  coupon_id =? AND user_id=? ";
					$binds = array($coupon_id,$userId);
					$result1 = $this->db->query($sql, $binds);
					if ($result1->num_rows() > 0) {
						return $result1->result();
					} else {
						return false;
					}
				}


				/******* check coupon is user or not**** */

				/******* getDiscount **** */
				function getDiscount($userId)
				{
					$sql = "SELECT mst_user_coupon.*,mst_coupon.coupon_code FROM mst_user_coupon LEFT JOIN mst_coupon ON mst_coupon.sk_coupon_id=mst_user_coupon.coupon_id WHERE user_id=? and user_coupon_status='1' ";
					$binds = array($userId);
					$result1 = $this->db->query($sql, $binds);
					if ($result1->num_rows() > 0) {
						return $result1->result();
					} else {
						return false;
					}
				}
				/******* getCoupon **** */

		function getCoupon(){
			$sql = "SELECT * FROM `mst_coupon` WHERE (start_date <= CURRENT_DATE AND end_date >= CURRENT_DATE) AND coupon_status ='1'";
			$binds = array();
			$result1 = $this->db->query($sql, $binds);
			if ($result1->num_rows() > 0) {
				return $result1->result();
			} else {
				return false;
			}
		}

		function checkCouponforUser($userId,$restuarants_id)
		{
					$sql = "SELECT * FROM mst_user_coupon WHERE  restaurant_id =? AND user_id=? ";
					$binds = array($restuarants_id,$userId);
					$result1 = $this->db->query($sql, $binds);
					if ($result1->num_rows() > 0) {
						return $result1->result();
					} else {
						return false;
					}
				}

	/** class close */
			

}

