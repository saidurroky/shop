<?php include 'inc/header.php';?>
 <?php
 	$login = Session::get('customerlogin');
 	if($login == false){
 		header("location:login.php");
 	}
 ?>  
 
 <style>
.psuccess{width: 500px;min-height: 200px;text-align: center;border: 1px solid #ddd;margin: 0 auto;padding: 50px;}
.psuccess h2{border-bottom: 1px solid #ddd;margin-bottom: 20px;padding-bottom: 10px;}
.psuccess p{color: #000;font-size: 15px;text-align: left;}
.back a{width: 160px;margin: 5px auto 0;padding: 7px 0;text-align: center;display: block;background: #555;border: 1px solid #333;color: #fff;border-radius: 3px;font-size: 25px}
 </style>
 <div class="main">
    <div class="content">
    	  <div class="section group">
    	  		<div class="psuccess">
    	  			<h2>success</h2>
                    <?php 
                         $cmrId = Session::get('customerId');
                         $amount = $ct -> payableAmount($cmrId);

                         if($amount){
                            $sum = 0;
                            while ($result = $amount -> fetch_assoc()) {
                                $price = $result['price'];
                                $sum = $sum + $price ;
                        
                    ?>
    	  			<p>total payable amount is TK 

                        <?php
                            $vat = $sum * 0.1 ;
                            $total = $sum + $vat;
                            echo $total ;

                        } }
                        ?>

                    </p>
                    <p>thanks for purchase .you will receive your order as soon as possible.here is your order details <a href="order.php">visit here</a></p>
    	  		</div>
    	  		<div class="back">
    	  			<a href="cart.php">Previous</a>
    	  		</div>
    	  </div>	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php';?>
