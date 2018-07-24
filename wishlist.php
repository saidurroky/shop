<?php include 'inc/header.php';?>
<style>
table.tblone img {height: 50px;width: 60px;}
.cartpage h2 {
	width: 200px;
}
</style>
 <?php
 	$login = Session::get('customerlogin');
 	if($login == false){
 		header("location:login.php");
 	}
 ?>
<?php
	if(isset($_GET['delproid'])){
		$productId = $_GET['delproid'];
		$delwlist = $pd -> delWishlistData($cmrId, $productId);
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Wishlist</h2>
			    		
						<table class="tblone">
							<tr>
								<th>SL</th>
								<th>Product Name</th>
								<th>Price</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
							<?php
								$cmrId  = Session::get("customerId");
								$getpd = $pd ->getWishlistData($cmrId);
								if($getpd){
									$i = 0;
  								while ($result = $getpd ->fetch_assoc()) {
  									$i++;
							?>
							<tr>
								<td><?php echo $i ;?></td>
								<td><?php echo $result['productName'];?></td>
								<td>TK  <?php echo $result['price'];?></td>
								<td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
								<td>
									<a  href="preview.php?proid=<?php echo $result['productId'] ;?>">Buy now</a>
									|| <a  href="?delproid=<?php echo $result['productId'] ;?>">Remove</a>
								</td>
							</tr>
						
						<?php } } ?>
							
						</table>
						
					</div>
					<div class="shopping">
						<div class="shopleft" style="width:100%; text-align:center">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php';?>
