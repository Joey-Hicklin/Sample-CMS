<?php
require "inc/head.inc";
require "inc/dbconnection.inc";
require "inc/functions.inc";
head("Products");
 
$content = "SELECT * FROM products";
$result = mysqli_query($dbc, $content);
?>
<div class="products"> <?php
while ($row = mysqli_fetch_array($result)) { ?>
	<div class="product">
		<p><?php echo $row['name']; ?></p>
		<div class="price"><?php echo "$".$row['price']; ?></div>
		<img src="<?php echo $row['image']; ?>">
	</div> <!-- END OF PRODUCT DIV -->
<?php 
} // END OF WHILE
echo "</div>"; // END OF PRODUCTS DIV
require "inc/foot.inc";
?>