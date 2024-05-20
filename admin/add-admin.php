<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Admin</h1>

            <br><br>

                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                
                ?>

            <form action="" method="POST">
                
                <table class="tbl-30">
                    <tr>
                        <td>Full Name: </td>
                        <td>
                            <input type="text" name="full_name" placeholder="Enter Your Name">
                        </td>
                    </tr>

                    <tr>
                        <td>Username: </td>
                        <td>
                            <input type="text" name="username" placeholder="Your Username">
                        </td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td>
                            <input type="password" name="password" placeholder="Your Password">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>

        </div>
    </div>


<?php include('partials/footer.php'); ?>

<?php
        //Process the Value from Form and Save it in Database
        //Check whether the submit button is clicked or not
        if(isset($_POST['submit']))
        {
            // Button clicked
            //echo "Button clicked";
            //1. Get the Data from form
            $full_name = $_POST['full_name'];
            $username = $_POST['username'];
            $password = md5($_POST['password']); //password encrypted with MD5

            //2. SQL Query to Save the data into database
            $sql = "INSERT INTO tbl_admin SET
                full_name='$full_name',
                username='$username',
                password='$password'
            ";

            //3. Excuting Query and Saving Data into Database
            $res = mysqli_query($conn, $sql) or die(mysqli_error());

            //4. Check whether the (Queryis Excuted) data is inserted or not and display appropriate message
            if($res==TRUE)
            {
                //data inserted
                //echo "Data Inserted";
                //Create a Session Variable to Display message
                $_SESSION['add'] = "<div class='success'>Admin Added Successfully</div>";
                //Redirect page to manage admin
                header("location:".SITEURL.'admin/manage-admin.php');

            }
            else
            {
                //failed to insert data
                //echo "Failed to Insert Data";
                //Create a Session Variable to Display message
                $_SESSION['add'] = "Failed to Add Admin";
                //Redirect page to add admin
                header("location:".SITEURL.'admin/add-admin.php');
            }

            
        }
?>
    