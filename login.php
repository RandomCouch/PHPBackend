<?php
	$error = "";
	if(!empty($_POST)){
		$username = $_POST['username'];
		$password = $_POST['password'];
		//Normally would query the username from the database along with the password (which would be hashed)
		//Then hash the inputed password and check it against the db password hash
		//But for the purpose of this task I will simply use preset variables
		$users = array();
		$e_user = array();
		$u_user = array();
		
		$e_user["username"] = "Editor";
		$e_user["password"] = "E1234";
		$e_user["type"] = "editor";
		
		$u_user["username"] = "User";
		$u_user["password"] = "U1234";
		$u_user["type"] = "user";
		
		$users[] = $e_user;
		$users[] = $u_user;
		
		$loggedUser = array();
		foreach($users as $user){
			if($username == $user["username"]){
				//Check password
				if($password == $user["password"]){
					$loggedUser["username"] = $username;
					$loggedUser["type"] = $user["type"];
				}
			}
		}
		if(empty($loggedUser)){
			$error = "Invalid login";
		}else{
			$_SESSION["user"] = $loggedUser;
			?>
				<script>
					window.location.replace("/index");
				</script>
			<?php
		}
	}
	//Redirect user to index if already logged in
	if($_SESSION['user'] != null){
		?>
			<script>
				window.location.replace("/index");
			</script>
		<?php
	}
?>

<div class="container text-center loginPage" style="padding:50px 0">
	<h3 class="logo">Welcome to my server</h3>
	<p>Demo accounts:</p>
	<table class='table borderless'>
		<tr>
			<th>Username</th>
			<th>Password</th>
		</tr>
		<tr>
			<td>Editor</td>
			<td>E1234</td>
		</tr>
		<tr>
			<td>User</td>
			<td>U1234</td>
		</tr>
	</table>
	<div class="logo">Login</div>
	<div class="login-form-container">
		<?php if($error != ""): ?>
			<div class="error"><?php echo $error; ?></div>
		<?php endif; ?>
		<form id="login-form" class="text-left" method="post">
			<div class="main-login-form">
				<div class="login-group">
					<div class="form-group">
						<label for="username" class="sr-only">Username</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Username" required="true">
					</div>
					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" class="form-control" id="password" name="password" placeholder="Password" required="true">
					</div>
				</div>
				<button type="submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
			</div>
		</form>
	</div>
</div>
<script>
(function($) {
	$("#login-form").validate({
  	rules: {
      username: "required",
  	  password: "required",
    },
  	errorClass: "form-invalid"
  });
})
</script>