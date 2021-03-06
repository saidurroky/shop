<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../lib/Session.php');
	Session::checkLogin();
	include_once ($filepath.'/../helpers/Format.php');
?>

<?php
	/**
	* 
	*/
	class Adminlogin{
		private $db;
		private $fm;
		public function __construct(){
			$this ->db = new Database();
			$this ->fm = new Format();
		}


		public function adminLogin($adminUser, $adminPass){
			$adminUser = $this ->fm -> validation($adminUser);
			$adminPass = $this ->fm -> validation($adminPass);

			$adminUser = mysqli_real_escape_string($this ->db ->link, $adminUser);
			$adminPass = mysqli_real_escape_string($this ->db ->link, $adminPass);

			if(empty($adminUser) || empty($adminPass)){

				$loginmsg = "USERNAME AND PASSWORD must not be empty";
				return $loginmsg;
			}else{

				$query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' ";

				$result = $this ->db ->select($query);

				if($result != false){
						$value = $result -> fetch_assoc();
						
						Session::set("adminLogin", true);
						Session::set("adminId", $value['adminId']);
						Session::set("adminName", $value['adminName']);
						Session::set("adminUser", $value['adminUser']);
						
						header("location: index.php");

					}else{
						$loginmsg = "USERNAME AND PASSWORD don't match";
						return $loginmsg;
					}
			}
		}
	}

?>