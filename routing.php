<?php
	session_start();
	//echo "REQUEST URI: " . $_SERVER['REQUEST_URI'];
	$urlArray = explode("?", $_SERVER['REQUEST_URI']);
	$url = $urlArray[0];
	if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $url)) {
		return false;
		//include __DIR__ . $url;
	}else{
		if(preg_match('/\.(?:php)$/', $url)){
			$newUrl = rtrim($url, '.php');
			header("Location: http://" . $_SERVER['HTTP_HOST'] .  $newUrl);
		}if(preg_match('/\.(?:css)$/', $url)){
			include __DIR__ . $url;
		}else {
			if($url == "/"){
				header("Location: http://" . $_SERVER['HTTP_HOST'] . "/index");
			}else{
				$PAGE_TITLE = ltrim($url, "/");
				//Check if user is logged in, if not redirect to login page
				if(empty($_SESSION['user']) && $url != "/login"){
					header("Location: http://" . $_SERVER['HTTP_HOST'] . "/login");
				}else{
					include __DIR__ . "/header.php";
					include __DIR__ . $url . ".php";
					include __DIR__ . "/footer.php";
				}
			}
		}
	}
?>