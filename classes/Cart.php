<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');
?>
<?php
	class Cart{
		private $db;
		private $fm;
		public function __construct(){
			$this ->db = new Database();
			$this ->fm = new Format();
		}

		public function  addToCart($quantity,$id){
			$quantity = $this ->fm -> validation($quantity);
			$quantity = mysqli_real_escape_string($this ->db ->link, $quantity);
			$productId = mysqli_real_escape_string($this ->db ->link, $id);
			$sId = session_id();

			$query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
			$result = $this ->db ->select($query) ->fetch_assoc();

			$productName  = $result['productName'];
			$price  = $result['price'];
			$image  = $result['image'];

			$chquery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId = '$sId'";
			$getpro = $this ->db ->select($chquery);
			if($getpro){
				$msg = "Product Already Added";
				return $msg;
			}else{

				$query = "INSERT INTO tbl_cart(sId,productId,productName,price,quantity,image) VALUES('$sId', '$productId', '$productName', '$price', '$quantity', '$image')";
		   		$inserted_row = $this ->db ->insert($query);

				if($inserted_row){
					header("location:cart.php") ;
				}else{
					header("location:404.php") ;
				}
			}

		}

		public function getCartProduct(){
			$sId = session_id();
			$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function updateCartQuentity($cartId,$quantity){
			$cartId = mysqli_real_escape_string($this ->db ->link, $cartId);
			$quantity = mysqli_real_escape_string($this ->db ->link, $quantity);

			$query = "UPDATE tbl_cart SET quantity = '$quantity' WHERE cartId = '$cartId'";
				$updatedrow = $this ->db ->update($query);

				if($updatedrow){

					$msg = "<span class='success'>Quentity updated successfully</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>Quentity not updated</span>";
					return $msg;
				}
			}

			public function delProductByCart($id){
				$id = mysqli_real_escape_string($this ->db ->link, $id);

				$query = "DELETE FROM tbl_cart WHERE cartId = '$id'";
				$deletedrow = $this ->db ->delete($query);

					if($deletedrow){
						header("location:cart.php");
					}else{
						header("location:404.php");
					}
			}

			public function chkCartTable(){
				$sId = session_id();
				$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";

				$result = $this ->db ->select($query);
				return $result;
			}

			public function delCustomerCart(){
				$sId = session_id();
				$query = "DELETE FROM tbl_cart WHERE sId = '$sId'";

				$result = $this ->db ->delete($query);
			}

			public function orderproduct($cmrId){
				$sId = session_id();
				$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";

				$getpro = $this ->db ->select($query);
				if($getpro){
					while ($result = $getpro ->fetch_assoc()) {
						$productId = $result['productId'];
						$productName = $result['productName'];
						$quantity = $result['quantity'];
						$price = $result['price'] * $quantity ;
						$image = $result['image'];

						$query = "INSERT INTO tbl_order(cmrId,productId,productName,quantity,price,image)
						 VALUES('$cmrId', '$productId', '$productName', '$quantity', '$price', '$image')";
		   				$inserted_row = $this ->db ->insert($query);
					}
				}
			}
			public function payableAmount($cmrId){
				$query = "SELECT price FROM tbl_order WHERE cmrId = '$cmrId' AND date = now() ";

				$result = $this ->db ->select($query);
				return $result;
			}

			public function getOrderedProduct($cmrId){
				$query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId' ORDER BY date desc ";

				$result = $this ->db ->select($query);
				return $result;
			}

			public function chkOrder($cmrId){
				$query = "SELECT * FROM tbl_order WHERE cmrId = '$cmrId'";

				$result = $this ->db ->select($query);
				return $result;
			}

			public function getAllOrderProduct(){
				$query = "SELECT * FROM tbl_order ORDER BY date";

				$result = $this ->db ->select($query);
				return $result;
			}

			public function productShifted($id, $price, $time){
				$id = mysqli_real_escape_string($this ->db ->link, $id);
				$price = mysqli_real_escape_string($this ->db ->link, $price);
				$time = mysqli_real_escape_string($this ->db ->link, $time);

				$rquery = "UPDATE tbl_order SET status = '2' WHERE cmrId = '$id' AND price = '$price' AND date = '$time' ";
				$updatedrow = $this ->db ->update($rquery);

				if($updatedrow){

					$msg = "<span class='success'>updated successfully</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>not updated</span>";
					return $msg;
				}
			}

			public function delProductShifted($id, $price, $time){
				$id = mysqli_real_escape_string($this ->db ->link, $id);
				$price = mysqli_real_escape_string($this ->db ->link, $price);
				$time = mysqli_real_escape_string($this ->db ->link, $time);

				$query = "DELETE FROM tbl_order WHERE cmrId = '$id' AND price = '$price' AND date = '$time' ";

				$deleteddrow = $this ->db ->delete($query);
				if($deleteddrow){

					$msg = "<span class='success'>updated successfully</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>not updated</span>";
					return $msg;
				}
			}

			public function productConfirm($id, $price, $time){
				$id = mysqli_real_escape_string($this ->db ->link, $id);
				$price = mysqli_real_escape_string($this ->db ->link, $price);
				$time = mysqli_real_escape_string($this ->db ->link, $time);
				$rquery = "UPDATE tbl_order SET status = '3' WHERE cmrId = '$id' AND price = '$price' AND date = '$time' ";
				$updatedrow = $this ->db ->update($rquery);

				if($updatedrow){

					$msg = "<span class='success'>updated successfully</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>not updated</span>";
					return $msg;
				}
			}
	}
?>