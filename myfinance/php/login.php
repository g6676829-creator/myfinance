<?php
require("conn.php");
//get data
$email = $conn->real_escape_string($_POST['email']);
$password = $conn->real_escape_string($_POST['password']);
//check user
$check_user = $conn->query("SELECT email, pass FROM users WHERE email='$email'");
if($check_user->num_rows != 0) {
	//find user data
    $user = $check_user->fetch_assoc();
    //verify password
    if(password_verify($password, $user['pass'])) {
    	//login success
        $c_email = base64_encode($email);
        $c_time = time()+(60*60*24*365);
        setcookie("_enter_u_", $c_email, $c_time, '/');
        echo "success";
    }
    else {
        echo "wrong password";
    }
}
else {
    echo "user not found, please register !";
}
?>