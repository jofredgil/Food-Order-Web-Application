<?php

    include('../config/constants.php');

    //1. get the ID of admin to be deleted
    $id = $_GET['id'];

    //2. create sql query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //excute the query
    $res = mysqli_query($conn, $sql);

    if($res==true)
    {
        //echo "Admin Deleted";
        $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        //echo "Failed to Delete Admin";
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Try Again Later</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');

    }

    //3. redirect to manage admin page with a message (success/error)


?>