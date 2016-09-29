<?php
require "inc/head.inc";
require "inc/dbconnection.inc";
require "inc/functions.inc";
head("Home");
?>
<div class="hero">
	<div class="splashText1">SUSTAINABLE</div>
	<div class="splashText2">SUSTENANCE</div>
<script type="text/javascript">
$(document).ready(function() {
$('.splashText1').delay(700).animate({opacity: 1},1000);
$('.splashText2').delay(1300).animate({opacity: 1},1000);
});
</script>
<style type="text/css">
.hero{background-image: url(<?php homeContent($dbc,"'heroImg'") ?>);}
 </style>
</div>
<div class="info1">
	<?php
		echo "<p>";
		homeContent($dbc,"'para1'");
		echo "</p><p>";
		homeContent($dbc,"'para2'");
		echo "</p>";
	 ?>
</div>
<div class="formField">
 <form action="" method="post">
 	<fieldset><legend>Mailing List</legend>
		<div class="formName formLabel">Name:</div>
		<input type="text" name="name" value="<?php stickyText('name'); ?>" > <?php formError("name"); ?>
		<div class="formEmail formLabel">Email:</div>
		<input type="text" name="email" value="<?php stickyText('email'); ?>" > <?php formError("email"); ?>
		 <?php 
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (!empty($_POST['name']) && !empty($_POST['email'])){
			$name = formError("name");
			$email = formError("email");
			$insert = "INSERT INTO mailing_list (name, email) VALUES (\"$name\", \"$email\")";
			$r = mysqli_query($dbc,$insert);
			if ($r){
				echo "<p class='formThanks'>Thanks for signing up!</p>";
			}
			else{
				echo '<p>'.mysqli_error($dbc);
			}
		}
	}
 ?>
		<input class="submit" type="submit" value="Sign Up">
 	</fieldset>
 </form>
</div><!-- END OF FORM DIV  -->
<div class="info2">
	<img src="<?php homeContent($dbc, "'img1'"); ?>">
	<p><?php homeContent($dbc, "'para3'"); ?></p>
</div>
 <?php require "inc/foot.inc"; ?>