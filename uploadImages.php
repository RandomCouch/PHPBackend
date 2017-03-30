<?php 
	$gallery = $_POST['gallery'];
	if(!empty($_POST) && $_SESSION['user']['type'] == "editor"){
		$file = $_FILES['image'];
		if(explode("/", $file['type'])[0] == "image"){
			$target_dir = __DIR__ . "/galleries/$gallery/";
			$target_file = $target_dir . basename($file['name']);
			move_uploaded_file($file['tmp_name'], $target_file);
		}
	}
?>
<script>
	window.location.replace("/viewGallery?name=<?php echo $gallery; ?>");
</script>