<?php
require 'conn.php';
$id=$_POST['id'];
$delsql=$conn->query("DELETE FROM categories WHERE id='$id'");
if ($delsql) {
	echo "success";
}
else {
	echo "failed".$conn->error;
}
?>