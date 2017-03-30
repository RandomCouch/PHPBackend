<?php
	$_SESSION['user'] = null;
	session_destroy();
?>
<script>
	window.location.replace("/index");
</script>