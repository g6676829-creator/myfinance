<?php
	require 'conn.php';
	$title=$_POST['postTitle'];
	$content=$_POST['postContent'];
	$meta=$_POST['metaDescription'];

	$table=$conn->query("CREATE TABLE IF NOT EXISTS test(
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		title VARCHAR(255),
		content TEXT,
		meta VARCHAR(500) 
	)");
	if ($table) {
		$insert=$conn->query("INSERT INTO test(title,content,meta)VALUES('$title','$content','$meta')");
		if ($insert) {
			echo "success";
		}
		else {
			echo "failed";
		}
	}
	else {
		echo "table not found !";
	}
?>