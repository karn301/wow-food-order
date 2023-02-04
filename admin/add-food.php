<?php include('partials/menu.php');
// echo 'addfood';
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>
<?php 
if(isset($_SESSION['upload'])){
    echo $_SESSION['upload'];
    unset($_SESSION['upload']);
}
?>
        <form action="" method="POST" enctype='multipart/form-data'>
            <table class='tbl-30'>
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">

                    </td>
                    
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea type="description" name='description' cols="30" rows='5' placeholder="Description of the Food."></textarea>

                    </td>

                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image" >
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php
                            //php code to display categories from db
                            //sql to get all categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn,$sql);
                            //count rows
                            $count = mysqli_num_rows($res);
                            if($count>0){
                                //have category
                                while($row= mysqli_fetch_assoc($res)){
                                    //get the details of category
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id; ?>"><?php echo $title;?></option>
                                    <?php
                                }
                            }
                            else{
                                //dont have category
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                            //display on dropdown 
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name='featured' value='Yes'>Yes
                        <input type="radio" name='featured' value='No'>No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name='active' value='Yes'>Yes
                        <input type="radio" name='active' value='No'>No
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input type="submit" value="Add Food" name='submit' class='btn-secondary'>
                    </td>
                </tr>
            </table>
        </form>
        <?php
        //check whether the button is clicked or not
        if(isset($_POST['submit'])){
            // echo 'clicked';
            //get the data from form
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            //check radio button selected or not
            if(isset($_POST['featured'])){
                $featured= $_POST['featured'];
            } 
            else{
                $featured = "No";
            }
            if(isset($_POST['active'])){
                $active= $_POST['active'];
            } 
            else{
                $active = "No";
            }
            //upload the image if seleted

            //check whether select image is clicked or not upload only is selected
            if(isset($_FILES['image']['name'])){
                //get the details of images selected
                $image_name = $_FILES['image']['name'];

                //check whether image is selected or not and only upload if selected
                if($image_name!=''){
                    //image is selected
                    //rename the image
                    //get the extension
                    $ext = end(explode('.',$image_name));
                    //create new name for image
                    $image_name = "Food-Name-".rand(0000,9999).'.'.$ext;

                    //upload the image
                    //get the source and dest path
                    $src=  $_FILES['image']['tmp_name'];
                    $dst = "../images/food/".$image_name;

                    //finally upload
                    $upload = move_uploaded_file($src,$dst);
                    if($upload == false){
                        //failed to uplaod image
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        die();
                    }
                }
                
            }
            else{
                $image_name = "";
            }

            //insert into database
            //sql query to save data
            $sql2 = "INSERT INTO tbl_food SET title='$title',description='$description', price = $price
            ,image_name = '$image_name',category_id='$category', featured='$featured', active='$active'";
            //redirect 
            //execute
            $res2 = mysqli_query($conn,$sql2);
            if($res2==true){
                //data inserted successfully
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            else{
                //failed to insert data
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>