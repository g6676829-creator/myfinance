<?php
require("php/conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup : Finance Routine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

	<style>
        @import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap');
        body{
            background-image: url("images/background.png");
        }
    	*{
    		margin: 0;
    		padding: 0;
    		box-sizing: border-box;
    		font-family: "Josefin Sans", sans-serif;
    	}
        .inner_row{
            box-shadow:0px 0px 7px black;
            background: rgba(59, 130, 246, 0.6);
            text-shadow: 0px 0px 5px blue;
        }
        .reg_frm input{
            box-shadow: none !important;
        }
        label{
            font-size: 20px;
        }
        .container{
            position: relative !important;
        }
        .msg{
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body>
    <?php require("components/nav.php"); ?>
    <div class="container p-3 d-flex justify-content-center">
        <div class="msg d-flex justify-content-center align-items-center d-none"></div>
        <div class="inner_row p-3 text-light rounded w-50">
            <h1 class="fs-2 text-center" style="border-bottom: 1px solid white;">Register With Us</h1>
            <form class="reg_frm">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group mt-3">
                    <label for="phone">Phone</label>
                    <input type="number" class="form-control" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group mt-3">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Create your password" required>
                </div>
                <button type="submit" class="btn btn-dark mt-3 register_btn">Register Now</button> 
            </form>
        </div>
    </div>

    

   <script>
       $(document).ready(function () {
           $('.reg_frm').submit(function (ev) {
               ev.preventDefault();
               //ajax call for signup
               $.ajax({
                    type:"POST",
                    url:"php/signup.php",
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    beforeSend:function () {
                        $('.register_btn').attr("disabled","disabled");
                        $('.register_btn').html("Please Wait...");
                    },
                    success:function (response) {
                        $('.register_btn').removeAttr("disabled");
                        $('.register_btn').html("Register Now");
                        if (response.trim()==="success") {
                            const massage = '<span class="alert alert-success fs-5">User Signed Up Successfully <i class="fa-solid fa-check-double"></i></span>';
                            $('.msg').toggleClass('d-none');
                            $('.msg').html(massage);
                            setTimeout(function () {
                                $('.msg').toggleClass('d-none');
                                $('.msg').html("");
                                window.location.href="http://localhost:8080/myfinance/login.php";
                            },2500);
                        }
                        else {
                            const massage = '<span class="alert alert-danger fs-5">'+response+' <i class="fa-solid fa-square-xmark"></i></span>';
                            $('.msg').toggleClass('d-none');
                            $('.msg').html(massage);
                            setTimeout(function () {
                                $('.msg').toggleClass('d-none');
                                $('.msg').html("");
                            },2500);
                        }
                    }
               })
           })
       })
   </script>
</body>
</html>