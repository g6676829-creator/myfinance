<?php
	require 'conn.php';
	$id=$_POST['id'];
	$sql=$conn->query("SELECT `img_name` FROM `authors` WHERE `id` = '$id';");
	$row = $sql->fetch_assoc();
	$img_name=$row['img_name'];
	$path="../../images/author_image/";
	$delete = unlink($path.$img_name);
	
	if ($delete) {
		$delsql=$conn->query("DELETE FROM authors WHERE id='$id';");
		if ($delsql) {
			echo "success";
		}
		else {
			echo "failed !".$conn->error;
		}
	}
?>