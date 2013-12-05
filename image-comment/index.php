<?php
require_once("../config.php") ; 
require_login();
$username = $USER->firstname;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Image</title>
	<link href="style.css" rel="stylesheet" />
	<link rel="stylesheet" href="layout.css">
	<script src="jquery.js"></script>
	<script src="jquery.imagecomm.js"></script>
	<script src="aux.js"></script>
	<script>
		$(function(){

			$("img").imageComment({
				save: save,
				load: load,
				username: '<?php echo $username ?>'
			});

		});
	</script>
</head>
<body>

<h1>Moodle - Photography Community</h1>

<div id="menu">Home | Courses | Instructors | Grades | Other class-related things</div>

<div id="forum">
<h2>Forum > Photo of Tempe Town lake</h2>

  <div class="post">
		<h3>Ringo Estrella says:</h3>

		<p>What do you guys think? Took this using a shoebox, a couple of lenses and an arduíno</p>

	  <img src="img.jpg" width="600" class="imageComment" />
	  <img src="img2.png" width="600" class="imageComment" />
	  <img src="img3.jpg" width="600" class="imageComment" />

		<label>
		<input type="submit" name="Vote" value="Vote">
		</label>
		<label>
		<input type="submit" name="Compare" value="Compare">
		</label>
	</div>

	<div class="post">
		<h3>Raymond says:</h3>

		<p>I don't like this part...</p>
	</div>

	<div class="post">
		<h3>Matt Smith says:</h3>

		<p>What part? Please, keep comments on the photo only!</p>

	</div>

</div>

</body>
</html>