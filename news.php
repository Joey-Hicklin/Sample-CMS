<?php
require "inc/head.inc";
require "inc/dbconnection.inc";
require "inc/functions.inc";
head("News");
$content = "SELECT date, story FROM news ORDER BY date";
$result = mysqli_query($dbc, $content);
?>
<h1 class="newsHead">
	News
</h1>
<?php
foreach ($result as $object => $attribute) {
	foreach ($attribute as $array => $item) {
		if($array == 'date'){
			echo "<p class=\"newsDate\">$item</p>\n";
		}
		elseif($array == 'story'){
			echo "<p class=\"newsStory\">$item</p>\n";
		}
	}
}
require "inc/foot.inc"; ?>