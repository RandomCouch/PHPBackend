<?php
	if(!empty($_POST) && $_SESSION['user']['type'] == "editor" ){
		$galleryName = $_POST['name'];
		mkdir(__DIR__ . "/galleries/" . $galleryName);
	}
?>