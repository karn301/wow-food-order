<?php 
//include constants.php
include('../config/constants.php');
//get the ID of admin to be deleted
$id = $_GET['id'];

//sql query to delete admin
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//execute the query
$res = mysqli_query($conn,$sql);

//check query executed or not
if($res==TRUE){
    //admin delete
    // echo 'admin deleted';
    // create session variable to display message
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
    header('location:'.SITEURL.'admin/manage-admin.php'); 

}
else{
    //failed to delete admin
    $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}

//redirect to manage admin page  with message(success)

?>