<?php
	require 'conn.php';
	$post_id=$_POST['id'];

	if (!empty($_COOKIE['_enter_u_'])) {
		$user=base64_decode($_COOKIE['_enter_u_']);
		$like_table=$conn->query("CREATE TABLE IF NOT EXISTS likes(
			id INT(11) AUTO_INCREMENT PRIMARY KEY,
			post_id INT(11) NOT NULL,
			user VARCHAR(512),
			liked_at DATE DEFAULT CURRENT_DATE
		);");
		if ($like_table) {
			$check_like=$conn->query("SELECT id FROM likes WHERE post_id='$post_id' AND user='$user';");
			if ($check_like->num_rows>0) {
				$delete_like=$conn->query("DELETE FROM likes WHERE post_id='$post_id' AND user='$user';");
				if ($delete_like) {
					$decrease_count=$conn->query("UPDATE posts SET like_count = like_count-1 WHERE id = '$post_id';");
					if ($decrease_count) {
						echo "success";
					}
					else {
						echo "failed".$conn->error;
					}
				}
				else {
					echo "like table can not updated !".$conn->error;
				}
			}
			else {
				$insert_like=$conn->query("INSERT INTO likes(post_id,user) VALUES('$post_id','$user');");
				if ($insert_like) {
					$increase_count=$conn->query("UPDATE posts SET like_count = like_count+1 WHERE id = '$post_id';");
					if ($increase_count) {
						echo "success";
					}
					else {
						echo "failed".$conn->error;
					}
				}
				else {
					echo "like table can not updated !".$conn->error;
				}
			}
		}
		else {
			echo "likes table can not found !".$conn->error;
		}
	}
	else {
		echo "Please Login !".$conn->error;
	}
?>