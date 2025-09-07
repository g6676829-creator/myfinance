<?php
	require 'conn.php';
	$name=$conn->real_escape_string($_POST['name']);
	$phone=$conn->real_escape_string($_POST['phone']);
	$email=$conn->real_escape_string($_POST['email']);
	$password=$conn->real_escape_string($_POST['password']);
	$pass=password_hash($password,PASSWORD_DEFAULT);
	//create table if not available
	$table=$conn->query("CREATE TABLE IF NOT EXISTS users(
		id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(100) NOT NULL,
		phone VARCHAR(13) NOT NULL,
		email VARCHAR(255) NOT NULL,
		pass VARCHAR(255) NOT NULL,
		listed DATE DEFAULT CURRENT_DATE
	);");
	if ($table) {
		$check_sql=$conn->query("SELECT * FROM users WHERE email='$email';");
		if ($check_sql->num_rows!=0) {
			die("User Exist ! : Please try with another email");
		}
		else {
			$insert=$conn->query("INSERT INTO users(name,phone,email,pass)VALUES('$name','$phone','$email','$pass');");
			if ($insert) {
				echo "success";
			}
			else {
				echo "failed";
			}
		}
	}
	else {
		echo "table can not found !".$conn->error;
	}
?>