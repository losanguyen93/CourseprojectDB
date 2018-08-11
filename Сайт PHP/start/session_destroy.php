<?php

	session_start(); 

	$_SESSION['status'] = 'user1';
	If(!isset($user_name)){ 
		header("Location: ../start/index.php"); 
		exit; 
	} 
	session_destroy();
	header("Refresh:0");

?> 
<html> 
	<body> 
	</body> 
</html> 
