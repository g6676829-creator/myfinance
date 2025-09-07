<?php 
	require('conn.php');
	$id=$conn->real_escape_string($_POST['id']);
	$cat=$conn->real_escape_string($_POST['cat']);
	$title=$conn->real_escape_string($_POST['post_title']);
	$meta_desc=$conn->real_escape_string($_POST['meta_desc']);
	$summary=$conn->real_escape_string($_POST['highlight']);
	$content=$conn->real_escape_string($_POST['postContent']);
	$auth_id=$conn->real_escape_string($_POST['author']);
	$status=$conn->real_escape_string($_POST['status']);
		
	//image file recieve
	$imgfile=$_FILES['banner'];
	$imgname=$imgfile['name'];
	$imglocation=$imgfile['tmp_name'];
	$path='../../images/banners/';

	if ($imgname) {
		//delete the old image first
		$fetch_old_img_sql=$conn->query("SELECT banner FROM posts WHERE id='$id';");
		$old_img_data=$fetch_old_img_sql->fetch_assoc();
		$old_img_name=$old_img_data['banner'];

		$delete=unlink($path.$old_img_name);
		if ($delete) {
			$upload_new_banner=move_uploaded_file($imglocation, $path.$imgname);
			if ($upload_new_banner) {
				$update_sql=$conn->query("UPDATE posts SET cat='$cat',title='$title',meta_desc='$meta_desc',banner='$imgname',summary='$summary',content='$content',status='$status',auth_id='$auth_id' WHERE id='$id';");
				if ($update_sql) {
					echo "updated";
				}
				else {
					echo "update failed".$conn->error;
				}
			}
			else {
				echo "new banner can not uploaded !".$conn->error;
			}
		}
		else {
			echo "old banner can not deleted !".$conn->error;
		}
	}
	else {
		$update_sql=$conn->query("UPDATE posts SET cat='$cat',title='$title',meta_desc='$meta_desc',summary='$summary',content='$content',status='$status',auth_id='$auth_id' WHERE id='$id';");
		if ($update_sql) {
			echo "updated";
		}
		else {
			echo "update failed".$conn->error;
		}
	}
?>