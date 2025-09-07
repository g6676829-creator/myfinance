<?php
	require('conn.php');
	//recieve all data
	$img_file=$_FILES['media_files'];
	$img_name=$img_file['name'];
	$img_location=$img_file['tmp_name'];
	$title_tag=$_POST['file_title'];
	$alt_tag=$_POST['file_alt'];
	//upload the images first
	$media_table=$conn->query("CREATE TABLE IF NOT EXISTS media(
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		img_name VARCHAR(255),
		title_tag VARCHAR(255),
		alt_tag VARCHAR(255)
	)");
	if ($media_table) {
		$check=$conn->query("SELECT * FROM media WHERE img_name='$img_name'");
		if ($check->num_rows!=0) {
			echo "this file is allready exist !";
		}
		else {
			$destination="../../images/media/";
			$upload=move_uploaded_file($img_location, $destination.$img_name);
			if ($upload) {
				$insert=$conn->query("INSERT INTO media(img_name,title_tag,alt_tag)VALUES('$img_name','$title_tag','$alt_tag')");
				if ($insert) {
					echo "success";
				}
				else {
					echo "data can not inserted !";
				}
			}
			else {
				echo "media can not uploaded !";
			}
		}
	}
	else {
		echo "table not find !";
	}
?>