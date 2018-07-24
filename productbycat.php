<?php include 'inc/header.php';?>
<?php
    if(!isset($_GET['catid']) || $_GET['catid'] == NULL){
        echo "<script>window.location = 'catlist.php';</script>";
    }else{
        $id = $_GET['catid'];
    }
?>
 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Latest from Category</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
	      	<?php
	      		$productByCat = $pd ->productByCat($id);

	      		if($productByCat){
	      			while ($result = $productByCat ->fetch_assoc()) {
	      	?>
				<div class="grid_1_of_4 images_1_of_4">
					 <a href="preview.php?proid=<?php echo $result['productId'] ;?>"><img src="admin/<?php echo $result['image'] ;?>" alt="" /></a>
					 <h2><?php echo $result['productName'] ;?></h2>
					 <p><?php echo $fm ->textshorten($result['body'],60);?></p>
					 <p><span class="price">TK  <?php echo $result['price'] ;?></span></p>
				     <div class="button"><span><a href="preview.php?proid=<?php echo $result['productId'] ;?>" class="details">Details</a></span></div>
				</div>

			<?php } }else{
				echo "<span style='color:green;font-size:18px'>Product of this category is not availabe right now...</span>";
			} ?>
			</div>

	
	
    </div>
 </div>
</div>
<?php include 'inc/footer.php';?>
 