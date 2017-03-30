<?php
function recursiveRemoveDirectory($directory)
{
    foreach(glob("{$directory}/*") as $file)
    {
        if(is_dir($file)) { 
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}
if(!empty($_POST) && $_SESSION['user']['type'] == "editor" ){
	$name = $_POST['name'];
	recursiveRemoveDirectory(__DIR__ . "/galleries/$name");
}
?>