<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        <?php 
        if(isset($_SESSION['add'])){
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }
        if(isset($_SESSION['upload'])){
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>
        <br><br>
        <!-- Add Category Form Starts  -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class='tbl-30'>
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name='title' placeholder="Category Title">
                    </td>
                </tr>
                <tr>
        <td>
            Select Image:
        </td>
        <td>
            <input type="file" name="image">
        </td>

                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name='featured' value = "Yes"> Yes
                        <input type="radio" name='featured' value = "No"> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name='active' value = "Yes"> Yes
                        <input type="radio" name='active' value = "No"> No
                    </td>
                </tr>
                <tr>
                    <td colspan='2'>
                        <input type="submit" name="submit" class = "btn-secondary" value="Add Category">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category Form Ends  -->
        <?php 
        //check submit button is clicked or not
        if(isset($_POST['submit'])){
            // echo 'done';
            //get the value from form
            $title = $_POST['title'];
            //for radio button we need to check whether the button is selected or not
            if(isset($_POST['featured'])){
                //get the value from form
                $featured = $_POST['featured'];
            }
            else{
                //set the default
                $featured = "No";
            }
            if(isset($_POST['active'])){
                //get the value from form
                $active = $_POST['active'];
            }
            else{
                //set the default
                $active = "No";
            }
            //check whether the imafe is selected or notand set he value for image name according
            // print_r($_FILES['image']); //print_r is used to print array
            // die(); //breal the ode here
            if(isset($_FILES['image']['name'])){
                //upload the image
                // to upload image we need image name, source path and destination path
                $image_name = $_FILES['image']['name'];
                //upload image only if image is uploaded
                if($image_name!=''){
                //auto rename
                //get the extension
                $ext = end(explode('.',$image_name));

                //rename the image
                $image_name = "Food_Category_".rand(000,999).'.'.$ext;
                
                
                $source_path = $_FILES['image']['tmp_name'];
                $destination_path = "../images/category/".$image_name;
                //finally upload
                $upload = move_uploaded_file($source_path,$destination_path);
                //check whether the image is uploaded or not
                //ad if the image h=the image is not uploaded then we will stop the process
                if($upload==false){
                    //Set mesage
                    $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                    header('location:'.SITEURL.'admin/add-category.php');  
                    //stop the process
                    die();
                }
            }
            }
            else{
                //dont upload image and set the image_value as blank
                $image_name = "";
            }
            //sql query to insert category in db
            $sql = "INSERT INTO tbl_category SET title='$title' ,image_name='$image_name', featured='$featured', active='$active'"; 

            //execute
            $res = mysqli_query($conn,$sql);
            //check query executed or not
            if($res==true){
                //query executed and category added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                 header('location:'.SITEURL.'admin/manage-category.php');
            }
            else{
                //failed to add categry
                $_SESSION['add'] = "<div class='error'>Failed to Add Category..</div>";
                 header('location:'.SITEURL.'admin/add-category.php');
            }
        }

        ?>
    </div>
</div>

<?php include('partials/footer.php');?>