<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 
	$filepath = realpath(dirname(__FILE__));
	include_once $filepath.'/../classes/Cart.php';
	$ct = new Cart();
	$fm = new Format();
?>
<?php
	if(isset($_GET['shiftid'])){
		$id = $_GET['shiftid'];
		$time = $_GET['time'];
		$price = $_GET['price'];
		$shift = $ct ->productShifted($id, $price, $time);
	}
	if(isset($_GET['delid'])){
		$id = $_GET['delid'];
		$time = $_GET['time'];
		$price = $_GET['price'];
		$delordr = $ct ->delProductShifted($id, $price, $time);
	}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Inbox</h2>
                <?php
                	if(isset($shift)){
                		echo $shift ;
                	}
                	if(isset($delordr)){
                		echo $delordr ;
                	}
                ?>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>ID</th>
							<th>Order Time</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Customer id</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$getorder = $ct -> getAllOrderProduct();
							if($getorder){
								while ($result = $getorder ->fetch_assoc()) {
						?>
						<tr class="odd gradeX">
							<td><?php echo $result['id'];?></td>
							<td><?php echo $fm ->formatDate($result['date']);?></td>
							<td><?php echo $result['productName'];?></td>
							<td><?php echo $result['quantity'];?></td>
							<td><?php echo $result['price'];?></td>
							<td><?php echo $result['cmrId'];?></td>
							<td><a href="customer.php?cmrId=<?php echo $result['cmrId'];?>">View details</a></td>
							<?php
									if($result['status'] == '1'){ ?>
									<td><a href="?shiftid=<?php echo $result['cmrId'];?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Shifted</a></td>
							<?php }elseif($result['status'] == '2'){ ?>
									<td>pending</td>
							<?php }else{?>
									<td><a href="?delid=<?php echo $result['cmrId'];?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Remove</a></td>
							<?php } ?>
						</tr>
						<?php } } ?>
					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
