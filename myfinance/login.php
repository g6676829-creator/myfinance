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
        .login_frm input{
            box-shadow: none !important;
        }
        label{
            font-size: 20px;
        }
        .container{
            position: relative !important;
            height: 80vh;
        }
        .red_border{
            border: 1px solid red;
            color: red;
        }
    </style>
</head>
<body>
    <?php require("components/nav.php"); ?>
    <div class="container p-3 d-flex justify-content-center align-items-center">
        <div class="inner_row p-3 text-light rounded w-50">
            <h1 class="fs-2 text-center" style="border-bottom: 1px solid white;">Login</h1>
            <form class="login_frm">
                <div class="form-group mt-3">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group mt-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control pass_input" name="password" placeholder="Create your password" required>
                </div>
                <button type="submit" class="btn btn-dark mt-3 login_btn">Login Now</button> 
            </form>
        </div>
    </div>

    

   <script>
       $(document).ready(function () {
           $('.login_frm').submit(function (ev) {
               ev.preventDefault();
               $.ajax({
                    type:"POST",
                    url:"php/login.php",
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    beforeSend:function (argument) {
                        $('.login_btn').attr("disabled","disabled");
                        $('.login_btn').html("Please Wait...");
                    },
                    success:function (response) {
                        $('.login_btn').removeAttr("disabled");
                        $('.login_btn').html("Login Now");
                        if (response.trim()==="success") {
                            window.location.href = "http://localhost:8080/myfinance/";
                        }
                        else if (response.trim()==="wrong password") {
                            $('.pass_input').toggleClass('red_border');
                            $('.pass_input').click(function () {
                                $('.pass_input').toggleClass('red_border');
                            });
                        }
                        else {
                            window.location.href = "http://localhost:8080/myfinance/signup.php";
                        }
                    }
               })
           })
       })
   </script>
</body>
</html>