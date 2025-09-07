<?php
	require('conn.php');
	$img_file=$_FILES['profile_picture'];
	$img_name=$img_file['name'];
	$img_location=$img_file['tmp_name'];
	$name=$_POST['author_name'];
	$bio=$_POST['author_bio'];
	$lba=$_POST['about_author'];
	//upload the image
	$img_folder="../../images/author_image/";
	$upload=move_uploaded_file($img_location, $img_folder.$img_name);
	if ($upload) {
		//insert details in database
		$table=$conn->query("CREATE TABLE IF NOT EXISTS authors(
			id INT(2) AUTO_INCREMENT PRIMARY KEY,
			name VARCHAR(100) NOT NULL,
			bio VARCHAR(100) NOT NULL,
			lba TEXT NOT NULL,
			img_name VARCHAR(100) NOT NULL,
			listed_at DATE DEFAULT CURRENT_DATE
		);");
		if ($table) {
			$insert=$conn->query("INSERT INTO authors(name,bio,lba,img_name)VALUES('$name','$bio','$lba','$img_name');");
			if ($insert) {
				echo "inserted";
			}
			else {
				echo "not inserted";
			}
		}
		else {
			echo "table can not created !";
		}
	}
	else {
		echo "image can not uploaded !";
	}
?>