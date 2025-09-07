<?php
	require 'conn.php';
	$id=$_POST['id'];
	$sql=$conn->query("SELECT * FROM media WHERE id='$id'");
	$data=$sql->fetch_assoc();
	$img_name=$data['img_name'];
	//unlink image
	$path='../../images/media/';
	$file_path=$path.$img_name;
	$del_image=unlink($file_path);
	if ($del_image) {
		$del_data=$conn->query("DELETE FROM media WHERE id='$id'");
		if ($del_data) {
			echo "success";
		}
		else {
			echo "failed";
		}
	}
	else {
		echo "image can not deleted !";
	}
?>