<?php
require "inc/adminHead.inc";
require "inc/dbconnection.inc";
require "inc/functions.inc";
head("Admin");

if (isset($_GET['edit'])) {
	switch ($_GET['edit']) {
		case 'home_page_content':
			adminDisplay($dbc, 'home_page_content');
			break;
		case 'products':
			adminDisplay($dbc, 'products');
			break;
		case 'orders':
			adminDisplay($dbc, 'orders');
			break;
		case 'news':
			adminDisplay($dbc, 'news');
			break;
		case 'social':
			adminDisplay($dbc, 'social');
			break;
		case 'mailing_list':
			adminDisplay($dbc, 'mailing_list');
			break;
		default:
			echo "<h1 class=\"newsHead adminWelcome\">Welcome to the ADMIN page!<br><br>Please select a category from the menu.</h1>";
			break;
	}
}
else{
	echo "<h1 class=\"newsHead adminWelcome\">Welcome to the ADMIN page!<br><br>Please select a category from the menu.</h1>";
}

require "inc/foot.inc";
?>