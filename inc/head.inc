<?php 
function head($title){ ?>
	<!DOCTYPE html>
	<html lang="en">
	<div class="copy">&copy; Copyright 2016</div>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/final_project.css">
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Krona+One' rel='stylesheet' type='text/css'>
		<title><?php echo $title; ?></title>
	</head>
	<body>

		<nav>
			<ul>
				<li><a href="home.php">Home</a></li>
				<li><a href="products.php">Products</a></li>
				<li><a href="order.php">Order</a></li>
				<li><a href="news.php">News</a></li>
				<li><a href="social.php">Social</a></li>
			</ul>
		</nav>
<?php
}
?>