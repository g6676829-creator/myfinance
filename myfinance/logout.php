<?php
	setcookie("_enter_u_","",time()-(60*60*24),'/');
	header('location:http://localhost:8080/myfinance/login.php');
?>