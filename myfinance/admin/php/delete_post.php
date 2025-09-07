<?php
require 'conn.php';
$id=$_POST['id'];
$delsql=$conn->query("SELECT * FROM posts WHERE id='$id'");
$data=$delsql->fetch_assoc();
$banner=$data['banner'];
$delbanner=unlink("../../images/banners/".$banner);
if ($delbanner) {
	$deldata=$conn->query("DELETE FROM posts WHERE id='$id'");
	if ($deldata) {
		echo "success";
	}
	else {
		echo "failed".$conn->error;
	}
}
else {
	echo "banner can not deleted !".$conn->error;
}
?>