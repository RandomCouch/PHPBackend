<?php
	if(!empty($_POST) && $_SESSION['user']['type'] == "editor"){
		$picToRemove = $_POST['picture'];
		unlink(__DIR__ . $picToRemove);
	}
?>