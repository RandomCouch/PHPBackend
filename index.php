<?php
	function GetGalleries(){
		$dir = __DIR__ . "/galleries/";
		$files = array_diff(scandir($dir), array('..','.'));
		
		$galleries = array();
		foreach($files as $file){
			$galleries[] = $file;
		}
		return $galleries;
	}
?>

<div class="container app">
	<h2>Welcome <?php echo $_SESSION['user']['username']; ?></h2>
	<a href='/logout'>Logout</a>
	<div class="top-bar">
		<h4>Galleries</h4>
	</div>
	<?php if($_SESSION['user']['type'] == "editor"): ?>
	<div class="col-md-3 editorMenu">
		<ul>
			<li>
				<form id='addGallery'>
				<p>Alphanumeric only</p>
				<input type="text" pattern="^[a-zA-Z0-9-_]+$" title="Alphanumeric characters only" class="form-control menuInput" id='galleryName' placeholder="Add a gallery..."/><button type='submit' class='btn btn-primary'>Add</button>
				</form>
			</li>
			<li>
				
			</li>
		</ul> 
	</div>
	<div class="col-md-9 galleries">
	<?php else: ?>
	<div class="col-md-12 galleries">
	<?php endif; ?>
		<?php
			$galleries = GetGalleries();
			if(empty($galleries)){
				$emptyMsg = "";
				if( $_SESSION['user']['type'] == "editor"){
					$emptyMsg = "<p> There are no current galleries, you should add one! </p>";
				}else{
					$emptyMsg = "<p> There are no current galleries, wait for an editor to add one </p>";
				}
				echo $emptyMsg;
			}else{
				echo "<ul class='galleryList'>";
				foreach($galleries as $gallery){
					//I would usually add a confirmation modal on delete, but for the sake of time I am leaving this as is right now
					$removeBtn = "<button type='button' class='btn btn-delete removeGallery' id='$gallery' ><span class='glyphicon glyphicon-remove'></span></button>";
					if($_SESSION['user']['type'] != "editor"){
						$removeBtn = "";
					}
					echo "<li class='gallery' id='$gallery'><div style='display:inline-block; width:80%'>$gallery</div><div style='display:inline-block'>$removeBtn</div></li>";
				}
				echo "</ul>";
			}
		?>
	</div>
</div>

<script>
	$("#addGallery").submit(function(e){
		e.preventDefault();
		var galleryName = $("#galleryName").val();
		$.ajax({
			url: '/addGallery',
			type: 'POST',
			data: {name: galleryName},
			success:function(result){
				location.reload();
			}
		});
		//console.log("Submit gallery name: " + galleryName);
	});
	$("li.gallery").click(function(){
		var id = $(this).attr('id');
		window.location.replace("/viewGallery?name=" + id);
	});
	$(".removeGallery").click(function(){
		var id = $(this).attr("id");
		$.ajax({
			url: '/removeGallery',
			type: 'POST',
			data: {name: id},
			success: function(){
				location.reload();
			}
		});
	});
</script>