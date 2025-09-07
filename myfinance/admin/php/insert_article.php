<?php
	require('conn.php');
	$cat=$_POST['cat'];
	$title=$_POST['post_title'];
	$urlslug=$_POST['url'];
	$meta_desc=$_POST['meta_desc'];
	$summary=$_POST['highlight'];
	$content=$_POST['postContent'];
	$status=$_POST['status'];
	$auth_id=$_POST['author'];
		
	//image file recieve
	$imgfile=$_FILES['banner'];
	$imgname=$imgfile['name'];
	$imglocation=$imgfile['tmp_name'];
	$path='../../images/banners/'.$imgname;

	//upload the images first
	$post_table=$conn->query("CREATE TABLE IF NOT EXISTS posts(
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		cat VARCHAR(100),
		title VARCHAR(512),
		url VARCHAR(255),
		meta_desc VARCHAR(160),
		banner VARCHAR(100),
		summary VARCHAR(1000),
		content TEXT,
		status VARCHAR(100),
		auth_id INT(2),
		like_count INT(11) DEFAULT 0,
		created_at DATE DEFAULT CURRENT_DATE 
	)");
	if ($post_table) {
		$upload_banner=move_uploaded_file($imglocation, $path);
		if ($upload_banner) {
			$insert_data=$conn->query("INSERT INTO posts(cat,title,url,meta_desc,banner,summary,content,status,auth_id)VALUES('$cat','$title','$urlslug','$meta_desc','$imgname','$summary','$content','$status','$auth_id')");
			if ($insert_data) {
				echo "success";
			}
			else {
				echo "failed";
			}
		}
		else {
			echo "banner can not uploaded";
		}
	}
?>