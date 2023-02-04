<?php 
    //authorization -acess control
    //check whether the user is logged in or not
    if(!isset($_SESSION['user']))  { //if the user session is not set
        //user is not logged in 
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access panel</div>";
        header('location:'.SITEURL.'admin/login.php');
    }
?>