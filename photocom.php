<?php

if ($_SERVER['REQUEST_METHOD'] == "GET"){
	// Read data
	$con=mysqli_connect("localhost","root","root","moodle");
	// Check connection
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	} else {
  		// Creating SQL
  		$url = $_GET["url"];
  		$sql = "SELECT * FROM mdl_photo_comm WHERE url='$url'";
  		// retrieving results
  		$result = mysqli_query($con, $sql);
  		if (!$result){
  			// Error! :()
			die('Error: ' . mysqli_error($con));
		} else {
			// Success!
			// Setting response type to JSON
			header('Content-Type: application/json');
			$rArray = array();
			while ($db_field = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			// 	// echo $db_field['url'];
			// 	// echo $db_field['name'];
			// 	// echo $db_field['comment'];
			// 	// echo $db_field['x'];
			// 	// echo $db_field['y'];
			// 	// echo $db_field['width'];
			// 	// echo $db_field['height'];
				$rArray[] = $db_field;
			}
			echo json_encode($rArray, JSON_NUMERIC_CHECK);

		}
		mysqli_close($con);
	}
} else {
	// Write data
	$con=mysqli_connect("localhost","root","root","moodle");
	// Check connection
	if (mysqli_connect_errno()) {
  		echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	} else {
  		// Setting up variables
  		$url = $_POST["url"];
  		$name = $_POST["name"];
  		$comment = $_POST["comment"];
  		$x = $_POST["x"];
  		$y = $_POST["y"];
  		$width = $_POST["width"];
  		$height = $_POST["height"];

  		// Creating SQL
  		$sql = "INSERT INTO mdl_photo_comm (url, name, comment, x, y, width, height) VALUES ('$url', '$name', '$comment', $x, $y, $width, $height)";

  		if (!mysqli_query($con,$sql)){
  			// Error! :()
			die('Error: ' . mysqli_error($con));
		} else {
			// Success!
			echo "Comment added";
		}
		mysqli_close($con);
	}
}

?>