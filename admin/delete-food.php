<?php 
include('../config/constants.php');
// echo 'deleted';
if(isset($_GET['id']) && isset($_GET['image_name'])){
    //process to delete
    // echo 'process to delete';
    //get id and image name
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    //remove the image if available
    //check whether the image is available or not and delere only if availablr
    if($image_name != ''){
        //it has image
        //get image path
        $path = '../images/food/'.$image_name;
        //remove file from folder
        $remove = unlink($path);
        //check whether the image is removed or not
        if($remove==false){
            //failed to remove
            $_SESSION['upload '] = "<div class='error'>Failed to Remove Image.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            die();
        } 
    }
    //delete food from db
    //redirect to manage food with session message 
    //sql to delete
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    //execute
    $res = mysqli_query($conn,$sql);
    if($res == true){
        $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else{
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
}
else{
    //redirect
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}



?>