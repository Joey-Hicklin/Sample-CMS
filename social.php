<?php
require "inc/head.inc";
require "inc/dbconnection.inc";
require "inc/functions.inc";
head("Social");
$content = "SELECT name, avatar, date, post FROM social ORDER BY date DESC";
$result = mysqli_query($dbc, $content);
 ?>
 <h1 class="newsHead">
	Social
</h1>
<div class="socialPosts">
<?php
foreach ($result as $object => $attribute) {
	echo "<div class=\"socialPost\">\n";
	foreach ($attribute as $array => $item) {
		switch ($array) {
			case 'name':
				echo "<div class=\"postInfo\"><p class=\"socialName\">$item</p>\n";
				break;
			case 'avatar':
				echo "<img src= \"$item\">\n";
				break;
			case 'date':
				echo "<p class=\"socialDate\">Posted on:<br><span>$item</span></p>\n</div> <!-- END OF postInfo DIV -->\n";
				break;
			case 'post':
				echo "<p class=\"socialText\">$item</p>\n";
				break;
			
		}
	}
	echo "</div>\n"; // END OF socialPost DIV
}
?>
</div> <!-- END OF socialPosts DIV -->
<?php require "inc/foot.inc"; ?>