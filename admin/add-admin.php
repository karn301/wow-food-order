<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br>
        <br>
        <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; //displaying session message
                    unset($_SESSION['add']); //removing session message
                }

                ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>     
                </tr>
                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" class='btn-secondary' name="submit" value="Add Admin">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>



<?php include('partials/footer.php');?>
<?php
    //Process the value from Form and save it in database
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
        //button clicked
        //1. Get the data from form

        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //password encrytion with md5
        
        
        //2. SQL query to save the data into the database
        $sql = "INSERT INTO tbl_admin SET 
        full_name='$full_name',
        username='$username',
        password='$password'
        ";    
        
        //3. execute the query ans save data in database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn)); 
        //4. check whether the query is executed or not and display appropriate message
        if($res==TRUE){
            // echo 'Data Inserted';
            //create a session variable to display message
            $_SESSION['add'] = "<div class='success'>Admin Added Sucessfully</div>";
            //redirect page to manage admin
            header('location:'.SITEURL.'admin/manage-admin.php');

        }
        else{
            // echo 'Failed to insert data';

            //create a session variable to display message
            $_SESSION['add'] = "<div class='error'>Failed to Add Admin</div>";
            //redirect page to manage admin
            header('location:'.SITEURL.'admin/add-admin.php');
        }
    } 
    
?>