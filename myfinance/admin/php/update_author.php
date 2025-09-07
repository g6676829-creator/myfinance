<?php
	require 'conn.php';
	$id=$conn->real_escape_string($_POST['id']);
	$img_file=$_FILES['profile_picture'];
	$img_name=$img_file['name'];
	$img_location=$img_file['tmp_name'];
	$name=$conn->real_escape_string($_POST['author_name']);
	$bio=$conn->real_escape_string($_POST['author_bio']);
	$lba=$conn->real_escape_string($_POST['about_author']);
	if ($img_name=="") {
		$update_sql=$conn->query("UPDATE authors SET name='$name',bio='$bio',lba='$lba' WHERE id='$id'");
		if ($update_sql) {
			echo "success";
		}
		else {
			echo "failed".$conn->error;
		}
	}
	else {
		$pre_img_sql=$conn->query("SELECT `img_name` FROM `authors` WHERE `id` = '$id';");
		$row = $pre_img_sql->fetch_assoc();
		$pre_img_name=$row['img_name'];
		$img_folder="../../images/author_image/";
		$delete_previous_image= unlink($img_folder.$pre_img_name);
		if ($delete_previous_image) {
			$upload_new_image=move_uploaded_file($img_location, $img_folder.$img_name);
			if ($upload_new_image) {
				$update_sql=$conn->query("UPDATE authors SET name='$name',bio='$bio',lba='$lba',img_name='$img_name' WHERE id='$id'");
				if ($update_sql) {
					echo "success";
				}
				else {
					echo "failed".$conn->error;
				}
			}
			else {
				echo "new image can not uploaded !".$conn->error;
			}
		}
		else {
			echo "old image can not deleted !".$conn->error;
		}
	}
?>