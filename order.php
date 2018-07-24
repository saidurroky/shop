<?php include 'inc/header.php';?>
 <?php
 	$login = Session::get('customerlogin');
 	if($login == false){
 		header("location:login.php");
 	}
 ?>
<?php
	if(isset($_GET['confirmid'])){
		$id = $_GET['confirmid'];
		$time = $_GET['time'];
		$price = $_GET['price'];
		$confirmed = $ct ->productConfirm($id, $price, $time);
	}
?>
 <style>
.tblone tr td{text-align:left;font-size: 18px}
 </style>

 <div class="main">
    <div class="content">
    	  <div class="section group">
    	  		<div class="order">
    	  			<h2>order details</h>
    	  			<table class="tblone">
							<tr>
								<th >SL</th>
								<th >Product Name</th>
								<th>Image</th>
								<th >Quantity</th>
								<th >Price</th>
								<th >Date</th>
								<th >Status</th>
								<th >Action</th>
							</tr>
							<?php
								 $cmrId = Session::get('customerId');
								$getorder = $ct ->getOrderedProduct($cmrId);
								if($getorder){
									$i = 0;
									$sum = 0;
  								while ($result = $getorder ->fetch_assoc()) {
  									$i++;
							?>
							<tr>
								<td><?php echo $i ;?></td>
								<td><?php echo $result['productName'];?></td>
								<td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
								<td><?php echo $result['quantity'];?></td>
								<td>
									<?php 
										$total = $result['price'] * $result['quantity'];
										echo "TK ".$total ;
									?>
								</td>
								<td><?php echo $fm->formatDate($result['date']);?></td>
								<td>
									<?php
										 if($result['status'] == '1'){
										 	echo "panding";
										 }elseif($result['status'] == '2'){
										 	echo "Shifted";
										}else{
										 	echo "Ok";
										 }
									?>
								</td>
								<?php
									if($result['status'] == '1'){ ?>
										<td>N/A</td>

								<?php }elseif($result['status'] == '2'){ ?>
									<td><a href="?confirmid=<?php echo $cmrId ;?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Confirm</a></td>
								<?php }else{ ?>

									<td>OK</td>

								<?php } ?>
							</tr>
						<?php } } ?>
							
						</table>
    	  		</div>
    	  </div>	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php';?>
