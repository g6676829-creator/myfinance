<?php
	require 'conn.php';
	$art_id=$_POST['art_id'];
	$comment=$conn->real_escape_string($_POST['comment']);
	//fetch user data
	if (!empty($_COOKIE['_enter_u_'])) {
		$email=base64_decode($_COOKIE['_enter_u_']);
		$sql=$conn->query("SELECT id FROM users WHERE email='$email';");
		$aa=$sql->fetch_assoc();
		$u_id=$aa['id'];
	}
	else {
		die("Please Login !");
	}
	//create table for comments
	$table=$conn->query("CREATE TABLE IF NOT EXISTS comments(
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		artid INT(11) NOT NULL,
		u_id INT(11) NOT NULL,
		comtext VARCHAR(500)
	);");

	if ($table) {
		$insert=$conn->query("INSERT INTO comments(artid,u_id,comtext) VALUES('$art_id','$u_id','$comment');");
		if ($insert) {
			echo "success";
		}
		else {
			echo "failed".$conn->error;
		}
	}
	else {
		echo "table not found !".$conn->error;
	}
?>