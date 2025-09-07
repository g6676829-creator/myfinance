<?php
require 'conn.php';
$id=$_POST['id'];
$sql=$conn->query("SELECT * FROM authors WHERE id='$id'");
$data=$sql->fetch_assoc();
print_r(json_encode($data));
?>