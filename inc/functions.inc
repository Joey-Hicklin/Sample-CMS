<?php 

function homeContent($dbc,$selection){
	$content = "SELECT content FROM home_page_content WHERE name = $selection";
	$result = mysqli_query($dbc,$content);
	
	// Iterate through the object returned from the database
	foreach ($result as $item) {

		// Transform the array into a string and echo the string
		echo implode("", $item);
	}
}

function stickyText($name){
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (!empty($_POST[$name])){
			echo $_POST[$name];
		}
	}
}

function stickyCheck($arrayName, $optionName){
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if(!empty($_POST[$arrayName])){
			if(in_array($optionName, $_POST[$arrayName])){
				echo "checked='checked'";
			}
		}
	}
}

function stickySelect($selectName, $optionName){
	if ($_SERVER['REQUEST_METHOD']=='POST') {
		if (isset($_POST[$selectName])){
			if ($_POST[$selectName]==$optionName) {
				echo 'selected="selected"';
			}
		}
	}
}

function formError($field){
	if($_SERVER['REQUEST_METHOD']=='POST'){
		if (!empty($_POST[$field])){
			// return used as redundant check for empty field when using POST data
			return $_POST[$field];
		}
		else{
			if ($field == 'productOrderList') {
				// custom error message if no products are selected on order page
				echo "<p class='formError productError'>Please select a product</p>";
			}
			else{
				$field = str_ireplace("_", " ", $field);
				echo "<p class='formError'>The " . ucwords($field) . " field is empty!</p>";
			}
		}
	}
}

function adminDisplay($dbc, $table){
// UPLOAD ERRORS
	$upload_errors = array(
		UPLOAD_ERR_OK       => "File successfully uploaded to the local folder",
		UPLOAD_ERR_INI_SIZE => "Larger than allowed by server",
		UPLOAD_ERR_FORM_SIZE => "Larger than allowed by form",
		UPLOAD_ERR_PARTIAL => "Partial file upload",
		UPLOAD_ERR_NO_FILE => "No file selected",
		UPLOAD_ERR_NO_TMP_DIR => "No temp directory found",
		UPLOAD_ERR_CANT_WRITE => "Can't write file to the server",
		UPLOAD_ERR_EXTENSION => "File upload of this type not allowed"
		);

// CREATE NEW ROW
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_GET['new'])){
		$keys = [];
		$values = [];
		foreach ($_POST as $key => $value) {
			if ($key != "MAX_FILE_SIZE") {
				array_push($keys, $key);
				array_push($values, "'$value'");
			}
		}
		// HANDLE UPLOADED IMAGES
		if (isset($_FILES['Image']) || isset($_FILES['Avatar'])) {
			if (isset($_FILES['Image'])){
				$file = "Image";
				$upload_dir = "img";
				array_push($keys, "image");
			}
			elseif (isset($_FILES['Avatar'])) {
				$file = "Avatar";
				$upload_dir = "img/social_avatars";
				array_push($keys, "avatar");
			}
			$tmp_file = $_FILES[$file]['tmp_name'];
			$target_file = basename($_FILES[$file]['name']);
			$upload_loc = $upload_dir . "/" . $target_file;
			array_push($values, "'$upload_loc'");
			if(move_uploaded_file($tmp_file, $upload_loc)){
				echo "<p class=\"newsHead\">Uploaded $target_file to the $upload_dir directory</p>";
			}
			else {
				$error = $_FILES[$file]['error'];
				echo $upload_errors[$error];
			}
		}
		$keys = implode(", ", $keys);
		$values = implode(", ", $values);
		if(mysqli_query($dbc, "INSERT INTO $table ($keys) VALUES ($values)")){
			echo "<h1 class=\"newsHead\">Row has been successfully created!</h1>\n";
		}
		else{
			echo "<p class=\"adminError formError\">Error description: " . mysqli_error($dbc) . "</p>";
		}
	}

// UPDATE ROW
	if($_SERVER['REQUEST_METHOD']=='POST' && !isset($_GET['new'])){
		$updateArray = [];
		foreach ($_POST as $key => $value) {
			if ($key != "MAX_FILE_SIZE") {
				if (strpos($key, 'ID')) {
					$ID = "$key = '$value'";
				}
				elseif ($key == "Avatar" && !empty($value)) {
					array_push($updateArray, "$key = 'img/social_avatars/$value'");
				}
				elseif ($key == "Image" && !empty($value)) {
					array_push($updateArray, "$key = 'img/$value'");
				}
				elseif ($key != "Image" && $key != "Avatar"){
					array_push($updateArray, "$key = '$value'");
				}
			}
		}
		$updateArray = implode(", ", $updateArray);
		$update = "UPDATE $table SET $updateArray WHERE $ID";
		if (mysqli_query($dbc, $update)) {
			echo "<h1 class=\"newsHead\">Database has been successfully updated!</h1>\n";
		}
		else{
			echo "<p class=\"adminError formError\">Error description: " . mysqli_error($dbc) . "</p>";
		}
	}

// DELETE ROW
	if (isset($_GET['del'])) {
		if(mysqli_query($dbc, "DELETE FROM " . $_GET['edit'] . " WHERE " . $_GET['ID'] . "=" . $_GET['del'])){
			echo "<h1 class=\"newsHead\">Item Successfully Deleted From The Database!</h1>\n";
		}
		else{
			echo "<h1 class=\"newsHead\">Something Went Wrong!</h1><p>" . mysqli_error($dbc) . "</p>";
		}
	}

// NEW ROW FORM
	$col = mysqli_query($dbc, "SHOW COLUMNS FROM " . $_GET['edit']);
	echo "<form class=\"adminForm\" action=\"admin.php?edit=" . $_GET['edit'] . "&new=1\" method=\"post\" enctype=\"multipart/form-data\">\n";
	foreach ($col as $field) {
		foreach ($field as $key => $value) {
			if ($key == 'Field'){
				if (!strpos($value, "ID")) {
					if ($value == "image" || $value == "avatar") {
						$value = ucwords(str_ireplace("_", " ", $value));
						echo "<p>$value</p>\n";
						echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000000\">\n<input type=\"file\" class=\"adminUpload\" name=\"$value\">\n";
					}
					else{
						$value = ucwords(str_ireplace("_", " ", $value));
						echo "<p>$value</p>\n";
						echo "<textarea rows= 3 class=\"adminContent\" name=\"$value\"></textarea>\n";
					}
				}
			}
		}
	}
	echo "<input type=\"submit\" class=\"adminNew\" value=\"CREATE NEW\">";
	echo "</form>\n";

// READ DATABASE ROWS
	$query = mysqli_query($dbc,"SELECT * FROM $table");
	foreach ($query as $row) {
		echo "<form class=\"adminForm\" action=\"admin.php?edit=" . $_GET['edit'] . "\" method=\"post\">\n";
		foreach ($row as $key => $value) {
			if (strpos($key, "ID")) {
				$delID = $key;
				$delValue = $value;
				echo "<p class=\"adminIDTitle\">$key:</p>\n";
				echo "<input type=\"text\" class=\"adminID\" name=\"$key\" value=\"$value\" readonly>\n";
			}
			elseif ($key == "image" || $key == "avatar") {
				$key = ucwords(str_ireplace("_", " ", $key));
				echo "<p>$key</p>\n";
				echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"100000000\">\n<input type=\"file\" class=\"adminUpload\" name=\"$key\">\n";
			}
			else{
				$key = ucwords(str_ireplace("_", " ", $key));
				echo "<p>$key</p>\n";
				echo "<textarea rows= 3 class=\"adminContent\" name=\"$key\">$value</textarea>\n";
			}
		}
		echo "<br>\n<a class=\"adminDelete\" href=\"?edit=" . $_GET['edit'] . "&ID=$delID&del=$delValue\">DELETE</a>\n";
		echo "<input class=\"submit\" type=\"submit\" value=\"UPDATE\">\n</form>";
	}
}
?>