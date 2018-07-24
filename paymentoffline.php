<?php include 'inc/header.php';?>
 <?php
 	$login = Session::get('customerlogin');
 	if($login == false){
 		header("location:login.php");
 	}
 ?> 
 <?php
   
    if(isset($_GET['orderid']) && $_GET['orderid'] == 'order'){
        $cmrId = Session::get('customerId');
        $insertorder = $ct -> orderproduct($cmrId);
        $deldata = $ct -> delCustomerCart();
        header("location:success.php");
        
    }
?> 
 <style>
.division{width: 50%;float: left;}
.tblone{width: 500px;margin: 0 auto; border: 2px solid #ddd}
.tblone tr td{text-align: justify;}
.tbltwo{float: right;text-align: left;width: 60%;border: 2px solid #ddd;margin-right: 14px;margin-top: 12px;}
.tbltwo tr td{text-align: justify;padding: 5px 10px;}
.ordernow{padding-bottom: 30px}
.ordernow a{width: 200px;margin: 20px auto 0;text-align: center;padding: 5px;font-size: 30px;display: block;background: #ff0000;color: #fff;border-radius: 3px}
 </style>
 <div class="main">
    <div class="content">
    	  <div class="section group">
    	  		<div class="division">
    	  			<table class="tblone">
                            <tr>
                                <th>SL</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                            <?php
                                $getpro = $ct ->getCartProduct();
                                if($getpro){
                                    $i = 0;
                                    $sum = 0;
                                    $qty = 0;
                                while ($result = $getpro ->fetch_assoc()) {
                                    $i++;
                            ?>
                            <tr>
                                <td><?php echo $i ;?></td>
                                <td><?php echo $result['productName'];?></td>
                                <td>TK  <?php echo $result['price'];?></td>
                                <td><?php echo $result['quantity'];?></td>
                                <td>
                                    <?php 
                                        $total = $result['price'] * $result['quantity'];
                                        echo "TK  ".$total ;
                                    ?>
                                </td>
                            </tr>
                        <?php
                            $qty = $qty + $result['quantity'] ;
                            $sum = $sum + $total ;
                        ?>  
                       <?php } } ?> 
                            
                        </table>
                        <table class="tbltwo" width="40%">
                            <?php
                                $getdata = $ct ->chkCartTable();
                                if($getdata){
                            ?>
                            <tr>
                                <td>Quantity</td>
                                <td>:</td>
                                <td><?php echo $qty ;?></td>
                            </tr>
                         
                            <tr>
                                <td>Sub Total</td>
                                <td>:</td>
                                <td>TK.<?php echo $sum ;?></td>
                            </tr>
                            <tr>
                                <td>VAT</td>
                                <td>:</td>
                                <td>10% ( <?php echo $vat = $sum * 0.1 ;?> )</td>
                            </tr>
                            <tr>
                                <td>Grand Total</td>
                                <td>:</td>
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
    	  		<div class="division">
    	  	<?php
                $id = Session::get("customerId");
                $getdata = $cmr -> getCustomerData($id);

                if($getdata){
                    while ($result = $getdata ->fetch_assoc()) {
            ?>
  
            <table class="tblone">
                <tr>
                    <th colspan="3" style="text-align:center">Your Profile Details</th>
                    
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
       <div class="clear"></div>
       <div class="ordernow">
            <a href="?orderid=order">Order</a>
       </div>
    </div>
 </div>
<?php include 'inc/footer.php';?>
