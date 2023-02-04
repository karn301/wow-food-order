<?php include('../config/constants.php');?>
<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
        <div class="login" class='text-center'>
            <h1 class='text-center'>Login</h1> <br><br>
            <?php 
            if(isset($_SESSION['login'])){
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message'])){
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
            ?>
            <br><br>
    <!-- Login Form Starts here -->
        <form action="" method="POST" class='text-center'>
            Username: <br>
            <input type="text" name="username" placeholder="Enter Username"> <br> <br>
            Password: <br>
            <input type="password" name="password" placeholder="Enter Password"> <br> <br>
            <input type="submit" value="Login" name='submit' class='btn-primary'>
            <br><br>
        </form>

    <!-- Login Form Ends here -->
            <p class='text-center'>Created By - <a href="">Karn Shinde</a></p>
        </div>
    </body>
</html>

<?php
    //check submit is clicked or not
    if(isset($_POST['submit'])){
        //process for login
        // get the data from login form
        // $username = $_POST['username'];
        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = md5($_POST['password']);
        // $raw_pass = md5($_POST['password']);
        // $password = mysqli_real_escape_string($conn,$raw_pass);
        //sql to check user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";
        //execute the query
        $res = mysqli_query($conn,$sql);

        //count rows to check user exists or not
        $count = mysqli_num_rows($res);
        if($count==1){
            //user is there
            $_SESSION['login'] = "<div class='success'>Login Successfull.</div>";
            $_SESSION['user'] = $username; //to check whether user is logged in or not
            header('location:'.SITEURL.'admin/');
        }
        else{
            //no user
            $_SESSION['login'] = "<div class='error text-center'>Username or Password Did not match.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }
    
?>