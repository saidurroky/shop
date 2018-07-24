<?php include 'inc/header.php';?>
 <?php
 	$login = Session::get('customerlogin');
 	if($login == false){
 		header("location:login.php");
 	}
 ?> 
<style>
.tblone{width: 550px;margin: 0 auto; border: 2px solid #ddd}
.tblone tr td{text-align: justify;}
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
  
			<table class="tblone">
				<tr>
					<td colspan="3" style="text-align:center"><h2>Your Profile Details</h2></td>
					
				</tr>
				<tr>
					<td width="20%">Name</td>
					<td width="5%">:</td>
					<td><?php echo $result['name'];?></td>
				</tr>
				<tr>
					<td width="20%">Email</td>
					<td width="5%">:</td>
					<td><?php echo $result['email'];?></td>
				</tr>
				<tr>
					<td width="20%">Phone</td>
					<td width="5%">:</td>
					<td><?php echo $result['phone'];?></td>
				</tr>
				<tr>
					<td width="20%">Address</td>
					<td width="5%">:</td>
					<td><?php echo $result['address'];?></td>
				</tr>
				<tr>
					<td width="20%">City</td>
					<td width="5%">:</td>
					<td><?php echo $result['city'];?></td>
				</tr>
				<tr>
					<td width="20%">Zip-code</td>
					<td width="5%">:</td>
					<td><?php echo $result['zip'];?></td>
				</tr>
				<tr>
					<td width="20%">Country</td>
					<td width="5%">:</td>
					<td><?php echo $result['country'];?></td>
				</tr>
				<tr>
					<td width="20%"></td>
					<td width="5%"></td>
					<td><a href="editprofile.php">Update Profile</a></td>
				</tr>

			</table>
		<?php } } ?>
 		</div>
 	</div>
	</div>
<?php include 'inc/footer.php';?>
   