<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');
?>
<?php
	class Product{
		private $db;
		private $fm;
		public function __construct(){
			$this ->db = new Database();
			$this ->fm = new Format();
		}
		public function productInsert($data, $file){
			$productName   = $this ->fm -> validation($data['productName']);
			$catId         = $this ->fm -> validation($data['catId']);
			$brandId       = $this ->fm -> validation($data['brandId']);
			$body          = $this ->fm -> validation($data['body']);
			$price         = $this ->fm -> validation($data['price']);
			$type          = $this ->fm -> validation($data['type']);

			$productName  = mysqli_real_escape_string($this ->db ->link, $productName);
			$catId        = mysqli_real_escape_string($this ->db ->link, $catId);
			$brandId      = mysqli_real_escape_string($this ->db ->link, $brandId);
			$body      = mysqli_real_escape_string($this ->db ->link, $body);
			$price        = mysqli_real_escape_string($this ->db ->link, $price);
			$type         = mysqli_real_escape_string($this ->db ->link, $type);

			$permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "uploads/".$unique_image;

		    if($productName == "" || $catId == "" || $brandId == "" || $body =="" || $price == "" || $type == ""){
		    	$msg = "<span class='error'>fields must not be empty</span>";
				return $msg;
		    }elseif ($file_size >1048567) {
		   	    echo "<span class='error'>Image Size should be less then 1MB!
		     </span>";
		    } elseif (in_array($file_ext, $permited) === false) {
		   	   echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
		    }else{
		    	move_uploaded_file($file_temp, $uploaded_image);

			 	$query = "INSERT INTO tbl_product(productName,catId,brandId,body,price,image,type) VALUES('$productName', '$catId', '$brandId', '$body', '$price', '$uploaded_image', '$type')";
		   		$inserted_row = $this ->db ->insert($query);

				if($inserted_row){

					$msg = "<span class='success'>Product inserted successfully</span>";
					return $msg;
				}else{
					$msg = "<span class='error'>Product not inserted</span>";
					return $msg;
				}
		    }
		}

		public function getAllProduct(){
			$query = "SELECT p.*, c.catName, b.brandName 
			FROM tbl_product as p, tbl_category as c, tbl_brand as b 
			Where p.catId = c.catId AND p.brandId = b.brandId
			ORDER BY p.productId ASC" ; 

			$result = $this ->db ->select($query);
			return $result;
		}

		public function getProById($id){
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function productUpdate($data, $file,$id){
			$productName   = $this ->fm -> validation($data['productName']);
			$catId         = $this ->fm -> validation($data['catId']);
			$brandId       = $this ->fm -> validation($data['brandId']);
			$body          = $this ->fm -> validation($data['body']);
			$price         = $this ->fm -> validation($data['price']);
			$type          = $this ->fm -> validation($data['type']);

			$productName  = mysqli_real_escape_string($this ->db ->link, $productName);
			$catId        = mysqli_real_escape_string($this ->db ->link, $catId);
			$brandId      = mysqli_real_escape_string($this ->db ->link, $brandId);
			$body      = mysqli_real_escape_string($this ->db ->link, $body);
			$price        = mysqli_real_escape_string($this ->db ->link, $price);
			$type         = mysqli_real_escape_string($this ->db ->link, $type);
			$id = mysqli_real_escape_string($this ->db ->link, $id);

			$permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

		    $div = explode('.', $file_name);
		    $file_ext = strtolower(end($div));
		    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		    $uploaded_image = "uploads/".$unique_image;

		    if($productName == "" || $catId == "" || $brandId == "" || $body =="" || $price == "" || $type == ""){
		    	$msg = "<span class='error'>fields must not be empty</span>";
				return $msg;
		    }else{
		    	if(!empty($file_name)){
				    if ($file_size >1048567) {
				   	    echo "<span class='error'>Image Size should be less then 1MB!
				     </span>";
				    } elseif (in_array($file_ext, $permited) === false) {
				   	   echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
				    }else{
				    	move_uploaded_file($file_temp, $uploaded_image);

						$query = "UPDATE tbl_product
							 SET productName = '$productName',
							 	 catId       = '$catId',
							 	 brandId     = '$brandId',
							 	 body        = '$body',
							 	 price       = '$price',
							 	 image       = '$uploaded_image',
							 	 type        = '$type'
							 	 WHERE productId = '$id'";

						$updatedrow = $this ->db ->update($query);

						if($updatedrow){

							$msg = "<span class='success'>Product updated successfully</span>";
							return $msg;
						}else{
							$msg = "<span class='error'>Product not updated</span>";
							return $msg;
						}
					}
				}else{
					$query = "UPDATE tbl_product
							 SET productName = '$productName',
							 	 catId       = '$catId',
							 	 brandId     = '$brandId',
							 	 body        = '$body',
							 	 price       = '$price',
							 	 type        = '$type'
							 	 WHERE productId = '$id'";

						$updatedrow = $this ->db ->update($query);

						if($updatedrow){

							$msg = "<span class='success'>Product updated successfully</span>";
							return $msg;
						}else{
							$msg = "<span class='error'>Product not updated</span>";
							return $msg;
						}
				}
			}
		}

		public function productDelete($id){
			$id = mysqli_real_escape_string($this ->db ->link, $id);

			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";

			$getdata = $this ->db ->select($query);

			if($getdata){
				 while ($imgdel = $getdata->fetch_assoc()) {
				    $delimg = $imgdel['image'];
				    unlink($delimg);
			    }
			}

			$delquery = "DELETE FROM tbl_product WHERE productId = '$id'";
			$deletedrow = $this ->db ->delete($delquery);

			if($deletedrow){

				$msg = "<span class='success'>Product deleted successfully</span>";
				return $msg;
			}else{
				$msg = "<span class='error'>Product not deleted</span>";
				return $msg;
			}
		}

		public function getFeaturedProduct(){
			$query = "SELECT * FROM tbl_product WHERE type = '0' ORDER BY productId LIMIT 4";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function getNewProduct(){
			$query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function getSingleProduct($id){
			$query = "SELECT p.*, c.catName, b.brandName 
			FROM tbl_product as p, tbl_category as c, tbl_brand as b 
			Where p.catId = c.catId AND p.brandId = b.brandId AND p.productId = '$id'"; 

			$result = $this ->db ->select($query);
			return $result;
		}

		public function getgetIphoneFromPd(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '1' ORDER BY productId LIMIT 1";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function getgetSamsungFromPd(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '2' ORDER BY productId LIMIT 1";

			$result = $this ->db ->select($query);
			return $result;
		}
		public function getgetAcerFromPd(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '3' ORDER BY productId LIMIT 1";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function getgetCanonFromPd(){
			$query = "SELECT * FROM tbl_product WHERE brandId = '4' ORDER BY productId LIMIT 1";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function productByCat($id){
			$id = mysqli_real_escape_string($this ->db ->link, $id);

			$query = "SELECT * FROM tbl_product WHERE catId = '$id'";

			$result = $this ->db ->select($query);
			return $result;
		}

		public function insertCompareData($productId, $cmrId){
			$productId = mysqli_real_escape_string($this ->db ->link, $productId);
			$cmrId = mysqli_real_escape_string($this ->db ->link, $cmrId);

			$cquery = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' AND productId = '$productId'";
			$check = $this ->db ->select($cquery);
			if($check){
				$msg = "<span class='error'>Already added</span>";
				return $msg;
			}
			$query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
			$result = $this ->db ->select($query) ->fetch_assoc();
			if($result){
					$productId = $result['productId'];
					$productName = $result['productName'];
					$price = $result['price'];
					$image = $result['image'];

					$query = "INSERT INTO tbl_compare(cmrId,productId,productName,price,image)
					 VALUES('$cmrId', '$productId', '$productName', '$price', '$image')";
	   				$inserted_row = $this ->db ->insert($query);

	   				if($inserted_row){
	   					$msg = "<span class='success'>Added | go compare page to compare</span>";
						return $msg;
					}else{
						$msg = "<span class='error'>something wrong</span>";
						return $msg;
					}
				}
		}

		public function getCompareProduct($cmrId){
			$cmrId = mysqli_real_escape_string($this ->db ->link, $cmrId);
			$query = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' ORDER BY id asc";
			$result = $this ->db ->select($query);
			return $result;
		}

		public function delCompareData($cmrId){
			$cmrId = mysqli_real_escape_string($this ->db ->link, $cmrId);
			$query = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId'";
			$deletedrow = $this ->db ->delete($query);
		}

		public function insertWishlist($id, $cmrId){
			$cquery = "SELECT * FROM tbl_wishlist WHERE cmrId = '$cmrId' AND productId = '$id'";
			$check = $this ->db ->select($cquery);
			if($check){
				$msg = "<span class='error'>Already added</span>";
				return $msg;
			}
			$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
			$result = $this ->db ->select($query) ->fetch_assoc();
			if($result){
					$productId = $result['productId'];
					$productName = $result['productName'];
					$price = $result['price'];
					$image = $result['image'];

					$query = "INSERT INTO tbl_wishlist(cmrId,productId,productName,price,image)
					 VALUES('$cmrId', '$productId', '$productName', '$price', '$image')";
	   				$inserted_row = $this ->db ->insert($query);

	   				if($inserted_row){
	   					$msg = "<span class='success'>Added | go wishlist page</span>";
						return $msg;
					}else{
						$msg = "<span class='error'>something wrong</span>";
						return $msg;
					}
				}
		}

		public function getWishlistData($cmrId){
			$cmrId = mysqli_real_escape_string($this ->db ->link, $cmrId);
			$query = "SELECT * FROM tbl_wishlist WHERE cmrId = '$cmrId' ORDER BY id asc";
			$result = $this ->db ->select($query);
			return $result;
		}
		public function delWishlistData($cmrId, $productId){
			$cmrId = mysqli_real_escape_string($this ->db ->link, $cmrId);
			$query = "DELETE FROM tbl_wishlist WHERE cmrId = '$cmrId' AND productId = '$productId'";
			$result = $this ->db ->delete($query);
			return $result;
		}
	}
?>