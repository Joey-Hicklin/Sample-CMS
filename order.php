<?php
require "inc/head.inc";
require "inc/dbconnection.inc";
require "inc/functions.inc";
head("Order");
 ?>
<div class="formField order">
	<form action="" method="post">
		<fieldset><legend>Order Form</legend>
			<div class="formEntry"><p class="orderName">First Name</p>
			<input type="text" name="first_name" value="<?php stickyText('first_name') ?>"><?php formError("first_name") ?></div>
			<div class="formEntry"><p class="orderName">Last Name</p>
			<input type="text" name="last_name" value="<?php stickyText('last_name') ?>"><?php formError("last_name") ?></div>
			<div class="formEntry"><p class="orderName">Address</p>
			<input type="text" name="address" rows="3" value="<?php stickyText('address') ?>"><?php formError("address") ?></div>
			<div class="formEntry"><p class="orderName">City</p>
			<input type="text" name="city" value="<?php stickyText('city') ?>"><?php formError("city") ?></div>
			<div class="formEntry"><p class="orderName">State</p>
			<select name="state">
				<option value="">-Select A State-</option>
				<option value="Washington" <?php stickySelect("state", "Washington") ?>>Washington</option>
				<option value="Oregon" <?php stickySelect("state", "Oregon") ?>>Oregon</option>
				<option value="Florida" <?php stickySelect("state", "Florida") ?>>Florida</option>
				<option value="Michigan" <?php stickySelect("state", "Michigan") ?>>Michigan</option>
				<option value="Ohio" <?php stickySelect("state", "Ohio") ?>>Ohio</option>
			</select><?php formError('state'); ?></div>
			<div class="formEntry"><p class="orderName">ZIP</p>
			<input type="text" name="zip" value="<?php stickyText('zip') ?>"><?php formError("zip") ?></div>

			<?php 
			// GENERATE CHECKBOXES FROM PRODUCT DATABASE
				$query = mysqli_query($dbc,"SELECT * FROM products");
				foreach ($query as $row) {
					foreach ($row as $key => $value) {
						if ($key == 'name'){
							$label = str_ireplace(" ", "_", strtolower($value));
							echo "<input id=\"$label\" type=\"checkbox\" name=\"productOrderList[]\" value=\"$value\"";
							stickyCheck("productOrderList", $value);
							echo ">\n<label for=\"$label\">\n<div class=\"check\">\n<p class=\"checkName\">$value</p>\n";
						}
						elseif ($key == 'price') {
							echo "<p class=\"checkPrice\">$value</p>\n";
						}
						elseif ($key == 'image') {
							echo "<img src=\"$value\">";
						}
					}
					echo "\n</div>\n</label>\n";
				}
			formError('productOrderList');
			$success = False;
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['zip']) && !empty($_POST['state']) && !empty($_POST['productOrderList'])) {
						?>
						<style type="text/css">
							.order{ display: none;}
						</style>
						<?php
						$firstName = $_POST['first_name'];
						$lastName = $_POST['last_name'];
						$address = $_POST['address'];
						$city = $_POST['city'];
						$state = $_POST['state'];
						$zip = $_POST['zip'];
						$products = implode(", ", $_POST['productOrderList']);
						$insert = "INSERT INTO orders (first_name, last_name, address, city, state, zip, products) VALUES (\"$firstName\", \"$lastName\", \"$address\", \"$city\", \"$state\", \"$zip\", \"$products\")";
						$r = mysqli_query($dbc,$insert);
						if ($r){
							$success = True;
						}
						else{
							echo '<p>'.mysqli_error($dbc);
						}
					}
				}
			 ?>
			<input class="submit" type="submit" value="Order">
		</fieldset>
	</form>
</div>
<?php 
	if ($success == True) {
		echo "<div class=\"orderSuccess\"><p>Thank you $firstName $lastName for ordering with us! Your order will be shipped promptly to:</p><p>$address<br>$city, $state $zip</p>";
		echo "<p>We really hope you enjoy the following items:</p><ul>";
		foreach ($_POST['productOrderList'] as $product){
			$product = str_ireplace("_", " ", $product);
			echo "<li>" . ucwords($product) . "</li>";
		}
		echo "</ul>";
	}
 ?>

 <?php require "inc/foot.inc"; ?>