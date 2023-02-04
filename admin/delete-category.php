<?php include('../config/constants.php');
// echo 'delete category';
//check whether the id and image_name is set or not
if(isset($_GET['id'])AND isset(($_GET['image_name']))){
    // echo 'get the value and dlete';
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];
    //remove the physical image file 
    if($image_name!=''){
        //image is available remove it
        $path = "../images/category/".$image_name;
        //remove the image
        $remove = unlink($path);
        //if failed to remove error
        if($remove==false){
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
            die();
        }
    }
    //delete data from databse
    $sql = "DELETE FROM tbl_category WHERE id = $id";
    //execute the query
    $res = mysqli_query($conn,$sql);
    if($res==true){
        $_SESSION['delete'] = "<div class='success'>Category Delete Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');

    } 
    else{
        //redirect to manage-category page with message
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }

}
else{
    //redirect to manage-category page
header('location:'.SITEURL.'admin/manage-category.php');
}
?>