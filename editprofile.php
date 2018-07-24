<?php include 'inc/header.php';?>
 <?php
 	$login = Session::get('customerlogin');
 	if($login == false){
 		header("location:login.php");
 	}
 ?>

<?php
   	$id = Session::get("customerId");
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editprofile'])){
        $customerProfile = $cmr -> customerProfileEdit($_POST,$id);
    }
?>

<style>
.tblone{width: 550px;margin: 0 auto; border: 2px solid #ddd}
.tblone tr td{text-align: justify;}
.tblone input[type="text"]{width: 400px;padding: 5px;font-size: 15px} 
</style>

 <div class="main">
    <div class="content">
    	<div class="section group">
    		<?php
    			$id = Session::get("customerId");
    			$getdata = $cmr -> getCustomerData($id);

    			if($getdata){
    				while ($result = $getdata ->fetch_assoc()) {
    		?>
  		<form action="" method="post">
			<table class="tblone">
					<?php
						if(isset($customerProfile)){
							echo "<tr><td colspan='2' style='text-align:center'><h2>".$customerProfile."</h2></td></tr>";
						}
					?>

				<tr>
					<td colspan="2" style="text-align:center"><h2>Update Profile Details</h2></td>
					
				</tr>
				<tr>
					<td width="20%">Name</td>
					
					<td><input type="text" name="name" value="<?php echo $result['name'];?>"></td>
				</tr>
				<tr>
					<td width="20%">Email</td>
					
					<td><input type="text" name="email" value="<?php echo $result['email'];?>"></td>
				</tr>
				<tr>
					<td width="20%">Phone</td>
					
					<td><input type="text" name="phone" value="<?php echo $result['phone'];?>"></td>
				</tr>
				<tr>
					<td width="20%">Address</td>
					
					<td><input type="text" name="address" value="<?php echo $result['address'];?>"></td>
				</tr>
				<tr>
					<td width="20%">City</td>
				
					<td><input type="text" name="city" value="<?php echo $result['city'];?>"></td>
				</tr>
				<tr>
					<td width="20%">Zip-code</td>
					
					<td><input type="text" name="zip" value="<?php echo $result['zip'];?>"></td>
				</tr>
				<tr>
					<td width="20%">Country</td>
					
					<td><input type="text" name="country" value="<?php echo $result['country'];?>"></td>
				</tr>
				<tr>
					<td width="20%"></td>
					
					<td><input type="submit" name="editprofile" value="Update"></td>
				</tr>

			</table>
		</form>
		<?php } } ?>
 		</div>
 	</div>
	</div>
<?php include 'inc/footer.php';?>
   