<?php 
function head($title){ ?>
	<!DOCTYPE html>
	<html lang="en">
	<div class="copy">&copy;Copyright 2016</div>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="css/final_project.css">
		<title><?php echo $title; ?></title>
	</head>
	<body>

		<nav>
			<ul>
				<li><a href="?edit=home_page_content">Home</a></li>
				<li><a href="?edit=products">Products</a></li>
				<li><a href="?edit=orders">Orders</a></li>
				<li><a href="?edit=news">News</a></li>
				<li><a href="?edit=social">Social</a></li>
				<li><a href="?edit=mailing_list">Mailing List</a></li>
			</ul>
		</nav>
<?php
}
?>