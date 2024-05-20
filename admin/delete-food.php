<?php

include('../config/constants.php');

    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the Value and Delete 
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the physical image file is available 
        if($image_name != "")
        {
            //Image is Available. So remove it
            $path = "../images/food/".$image_name;
            //Remove the Image
            $remove = unlink($path);

            //IF failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //Set the SEssion Message
                $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";

                //Redirect to Manage Category page
                header('location:'.SITEURL.'admin/manage-food.php');

                //Stop the Process
                die();
            }
        }

        //Delete Data from Database
        //SQL Query to Delete Data from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the data is delete from database or not 
        if($res==true)
        {
             //Food Deleted
             $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully.</div>";
             //Redirect to Manage Food
             header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
             //Fail to Delete Food
             $_SESSION['delete'] = "<div class='error'>Failed to Delete Food.</div>";
             //Redirect to Manage Food
             header('location:'.SITEURL.'admin/manage-food.php');

        }

    }
    else
    {
        //SEt Fail Message and Redirecs
        $_SESSION['unauthorized'] = "<div class='error'>Unautorized Access.</div>";
        //Redirect to Manage Food
        header('location:'.SITEURL.'admin/manage-food.php');

    }

?>