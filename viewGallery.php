<?php
	$galleryName = $_GET['name'];
	function GetPictures($name){
		$dir = __DIR__ . "/galleries/$name";
		if(file_exists($dir)){
			$files = array_diff(scandir($dir), array('..','.'));
		
			$pictures = array();
			foreach($files as $file){
				$pictures[] =  [$file, "/galleries/$name/" . $file];
			}
			return $pictures;
		}
	}

	if(!empty($_FILES)){
		print_r($_FILES);
	}
?>

<div class="container app">
	<h2>Welcome <?php echo $_SESSION['user']['username']; ?></h2>
	<a href='/logout'>Logout</a>
	<div class="top-bar">
		<a href="/index" style='float:left;'>Back</a>
		<h4>Gallery: <?php echo $galleryName; ?></h4>
	</div>
	<?php if($_SESSION['user']['type'] == "editor"): ?>
	<div class="col-md-3 editorMenu">
		<form id='addPicture' action="uploadImages" method='post' enctype="multipart/form-data">
		<p> Add an image by entering the image url </p>
		<div class="input-group">
			<label class="input-group-btn">
				<span class="btn btn-default">
					Browse <input type="file" accept="image/*" style="display:none;" name='image' >
				</span>
			</label>
			<input type="hidden" name="gallery" value="<?php echo $galleryName; ?>"/>
			<input type="text" class="form-control" name='url' readonly>
		</div>
		<button type='submit' class='btn btn-primary' style='width:100%;' name='submit'>Add</button>
		</form>
	</div>
	<div class="col-md-9 galleries">
	<?php else: ?>
	<div class="col-md-12 galleries">
	<?php endif; ?>
		<?php
			if($galleryName != ""){
				$pictures = GetPictures($galleryName);
				if(empty($pictures)){
					$emptyMsg = "";
					if( $_SESSION['user']['type'] == "editor"){
						$emptyMsg = "<p> There are no current pictures, you should add one! </p>";
					}else{
						$emptyMsg = "<p> There are no current pictures, wait for an editor to add one </p>";
					}
					echo $emptyMsg;
				}else{
					echo "<ul class='galleryList'>";
					foreach($pictures as $picture){
						//I would usually add a confirmation modal on delete, but for the sake of time I am leaving this as is right now
						$removeBtn = "<button type='button' class='btn btn-delete removePicture' id='$picture[1]' ><span class='glyphicon glyphicon-remove'></span></button>";
						if($_SESSION['user']['type'] != "editor"){
							echo "<li class='pic' id='$picture[1]'><a href='$picture[1]'><img src='$picture[1]'/></a></li>";
						}else{
							echo "<li class='pic' id='$picture[1]'><div style='display:inline-block; width:80%'><img src='$picture[1]'/>$picture[0]</div><div style='display:inline-block'>$removeBtn</div></li>";
						}
						
					}
					echo "</ul>";
				}
			}
		?>
	</div>
</div>

<script>
  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });
$(".removePicture").click(function(){
	var id = $(this).attr("id");
	$.ajax({
		url: "/removePicture",
		type: "POST",
		data: {picture: id},
		success: function(){
			window.location.reload();
		}
	});
});
  
  // We can watch for our custom `fileselect` event like this
  $(document).ready( function() {
	  var files;
	  var safeUpload = true;
	  var errorMessage = $("<div class='error'></div>");
	  
      $(':file').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
</script>