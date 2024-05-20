<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            $id=$_GET['id'];
            $sql="SELECT * FROM tbl_admin WHERE id=$id";
            $res=mysqli_query($conn, $sql);

            if($res==true)
            {
                $count = mysqli_num_rows($res);
                if($count==1)
                {
                    //echo "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $usernmae = $row['username'];
                }
                else
                {
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }
        
        ?>

        <form action="" method="POST">
                
                <table class="tbl-30">
                    <tr>
                        <td>Full Name: </td>
                        <td>
                            <input type="text" name="full_name" Value="<?php echo $full_name; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>Username: </td>
                        <td>
                            <input type="text" name="username" Value="<?php echo $usernmae; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>
    </div>
</div>

<?php
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        //get all the values from form to update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $usernmae = $_POST['username'];

        //create a sql query to update admin
        $sql = "UPDATE tbl_admin SET
        full_name = '$full_name',
        username = '$usernmae' 
        WHERE id='$id'
        ";

        //excute the query
        $res = mysqli_query($conn, $sql);

        //check whether the query excuted successfully or not
        if($res==true)
        {
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            $_SESSION['update'] = "<div class='error'>Failed to Delete Admin.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

?>



<?php include('partials/footer.php'); ?>