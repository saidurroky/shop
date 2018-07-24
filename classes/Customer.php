<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');
?>
<?php
	class Customer{
		private $db;
		private $fm;
		public function __construct(){
			$this ->db = new Database();
			$this ->fm = new Format();
		}

		public function customerRegistration($data){
			$name   = $this ->fm -> validation($data['name']);
			$city   = $this ->fm -> validation($data['city']);
			$zip   = $this ->fm -> validation($data['zip']);
			$email   = $this ->fm -> validation($data['email']);
			$address   = $this ->fm -> validation($data['address']);
			$country   = $this ->fm -> validation($data['country']);
			$phone   = $this ->fm -> validation($data['phone']);
			$pass   = $this ->fm -> validation(md5($data['pass']));

			if($name == "" || $city == "" || $zip == "" || $email =="" || $address == "" || $country == "" || $phone == "" || $pass == ""){
		    	$msg = "<span class='error'>fields must not be empty</span>";
				return $msg;
		    }

		    $mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' limit 1";

		    $mailchk = $this ->db ->select($mailquery);

		    if($mailchk !=false){
		    	$msg = "<span class='error'>Email already exists</span>";
				return $msg;
		    }else{
		    	$query = "INSERT INTO tbl_customer(name,city,zip,email,address,country,phone,pass) 
		    	VALUES('$name', '$city', '$zip', '$email', '$address', '$country', '$phone', '$pass')";
		   		$inserted_row = $this ->db ->insert($query);

				if($inserted_row){

					$msg = "<span class='success'>Customer data inserted successfully</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>customer data not inserted</span>";
					return $msg;
				}
		    }
		}

		public function customerLogin($data){
			$email   = $this ->fm -> validation($data['email']);
			$pass   = $this ->fm -> validation(md5($data['pass']));

			$query = "SELECT * FROM tbl_customer WHERE email = '$email' AND pass = '$pass'";
			$result = $this ->db ->select($query);
			if($result != false){
				$value = $result ->fetch_assoc();
				Session::set('customerlogin', true);
				Session::set('customerId', $value['id']);
				Session::set('customerName', $value['name']);
				header("location:cart.php");

			}else{
				$msg = "<span class='error'>fields must not be empty</span>";
				return $msg;
			}
		}

		public function getCustomerData($id){
			$query = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$result = $this ->db ->select($query);
			return $result;
		}

		public function customerProfileEdit($data,$id){
			$name   = $this ->fm -> validation($data['name']);
			$city   = $this ->fm -> validation($data['city']);
			$zip   = $this ->fm -> validation($data['zip']);
			$email   = $this ->fm -> validation($data['email']);
			$address   = $this ->fm -> validation($data['address']);
			$country   = $this ->fm -> validation($data['country']);
			$phone   = $this ->fm -> validation($data['phone']);
			

			if($name == "" || $city == "" || $zip == "" || $email =="" || $address == "" || $country == "" || $phone == ""){
		    	$msg = "<span class='error'>fields must not be empty</span>";
				return $msg;
		    }else{
		    	
		    	$query = "UPDATE tbl_customer 
		    		SET 
		    		name = '$name',
		    		city = '$city',
		    		zip = '$zip',
		    		email = '$email',
		    		address = '$address',
		    		country = '$country',
		    		phone = '$phone'
		    		WHERE id = '$id'";

				$updatedrow = $this ->db ->update($query);

				if($updatedrow){

					$msg = "<span class='success'>Profile updated successfully</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>Profile not updated</span>";
					return $msg;
				}
		    }
		}
	}
?>