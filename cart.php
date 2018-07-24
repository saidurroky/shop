<?php include 'inc/header.php';?>
<?php
	if(isset($_GET['delpro'])){

        $id = $_GET['delpro'];
        $delproduct = $ct ->delProductByCart($id);
   	 }
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $cartId = $_POST['cartId'];
        $quantity = $_POST['quantity'];

        $updateCart = $ct -> updateCartQuentity($cartId,$quantity);

        if($quantity <= 0){
        	$delproduct = $ct ->delProductByCart($cartId);
        }
    }
?>
<?php
	if(!isset($_GET['id'])){
		echo "<meta http-equiv='refresh' content='0;URL=?id=roky'/>";
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>
			    		<?php
							if(isset($updateCart)){
								echo $updateCart;
							}
						?>
						<table class="tblone">
							<tr>
								<th width="5%">SL</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="20%">Quantity</th>
								<th width="15%">Total Price</th>
								<th width="10%">Action</th>
							</tr>
							<?php
								$getpro = $ct ->getCartProduct();
								if($getpro){
									$i = 0;
									$sum = 0;
  								while ($result = $getpro ->fetch_assoc()) {
  									$i++;
							?>
							<tr>
								<td><?php echo $i ;?></td>
								<td><?php echo $result['productName'];?></td>
								<td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
								<td>TK  <?php echo $result['price'];?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId'];?>"/>
										<input type="number" name="quantity" value="<?php echo $result['quantity'];?>"/>
										<input type="submit" name="submit" value="Update"/>
									</form>
								</td>
								<td>
									<?php 
										$total = $result['price'] * $result['quantity'];
										echo "TK  ".$total ;
									?>
								</td>
								<td><a onclick="return confirm('Are you sure to delete')" href="?delpro=<?php echo $result['cartId'];?>">X</a></td>
							</tr>
						<?php
							$sum = $sum + $total ;
						?>	
						<?php } } ?>
							
						</table>
						<table style="float:right;text-align:left;" width="40%">
							<?php
								$getdata = $ct ->chkCartTable();
								if($getdata){
							?>
							<tr>
								<th>Sub Total : </th>
								<td>TK.<?php echo $sum ;?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>
									<?php
										$vat = $sum * 0.1 ;
										$gtotal = $sum + $vat;
										session::set("gtotal", $gtotal);

										echo "TK  ".$gtotal;
									?>
								</td>
							</tr>
							<?php }else{
									header("location:index.php");
								}
							?>
					   </table>
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php';?>
