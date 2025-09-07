<?php
require 'conn.php';
$id=$_POST['hidden_id'];
$new_category=$_POST['category_name'];
$new_cat_url=strtolower($new_category);
$new_cat_url=str_replace(' ','-',$new_cat_url);
$update_sql=$conn->query("UPDATE categories SET cat_name='$new_category', cat_url='$new_cat_url' WHERE id='$id';");
if ($update_sql) {
	echo "success";
}
else {
	echo "failed".$conn->error;
}
?>