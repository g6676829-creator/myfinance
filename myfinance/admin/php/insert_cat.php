<?php
	require 'conn.php';
	$cat_name=$_POST['cat_name'];
	$cat_url=strtolower($cat_name);
	$cat_url=str_replace(' ', '-', $cat_url);
	//ceate table if not exist
	$create_table="CREATE TABLE IF NOT EXISTS categories(
		id INT AUTO_INCREMENT PRIMARY KEY,
		cat_name VARCHAR(100) NOT NULL,
		cat_url VARCHAR(100) NOT NULL,
		UNIQUE KEY (cat_name),
    	UNIQUE KEY (cat_url)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
	if($conn->query($create_table) === true) {
		$check=$conn->query("SELECT * FROM categories WHERE cat_name='$cat_name'");
		if ($check->num_rows>0) {
			die("Error : category allready exist ".$conn->error);
		}
		else {
			$insert=$conn->query("INSERT INTO categories(cat_name,cat_url) VALUES('$cat_name','$cat_url')");
			if ($insert === true) {
				echo "success";
			}
			else {
				echo "failed";
			}
		}
	}
	else {
		echo "table not created !";
	}
	$conn->close();
?>