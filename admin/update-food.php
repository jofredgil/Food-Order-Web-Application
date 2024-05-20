<?php include('partials/menu.php'); ?>

<?php

    //Check whether the id is set or not 
    if(isset($_GET['id']))
    {
        //Get the ID and all other details
        //echo "Getting the Data";
        $id = $_GET['id'];

        //Create SQL Query to get all other details
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);
                
        //Count the Rows to check whether the id is valid or not
        $row2 = mysqli_fetch_assoc($res2);

        //Get all the data
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];
    }
    else
    {
        //redirect to manage category with session message
        $_SESSION['no-category-found'] = "<div class='error'>Category not Found.</div>"; 
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Description: </td>
                <td>
                    <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Price: </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image != "")

                            {
                                //Display the Image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {
                                //Display Message
                                echo "<div class='error'>Image Not Added.</div>";
                            }
                        
                        ?>    
                    </td>
            </tr>

            <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

            <tr>
                <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php

                                //Create PHP Code to display categories from Database
                                //1. Create SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                                //Executing query
                                $res = mysqli_query($conn, $sql);

                                //Count Rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //IF count is greater than zero, we have categories else we donot have categories 
                                if($count>0)
                                {

                                    //WE have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories
                                        $category_id = $row['id'];
                                        $category_title = $row['title'];

                                        ?>

                                            <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                                        <?php
                                    }

                                }
                                else
                                {
                                    ?>
                                    <option value="0">No Category Available</option>
                                    <?php
                                }

                            
                            ?>


                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                        <input <?php ob_start(); if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php ob_start(); echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>

        </table>

        </form>

    <?php
        
        if(isset($_POST['submit']))
        {
            //1. Get all the values from our form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = mysqli_real_escape_string($conn, $_POST['description']);
            $price = $_POST['price'];
            $current_image = $_POST['current_image'];
            $category = $_POST['category'];

            $featured = $_POST['featured'];
            $active = $_POST['active'];

            //2. Updating New Image if selected
                //Check whether the image is selected or not 
                if(isset($_FILES['image']['name']))
                {
                    //Get the Image Details 
                    $image_name = $_FILES['image']['name'];

                    //Check whether the image is available or not 
                    if($image_name!="")
                    {
                        //Image Available

                        //auto rename
                        $ext = end(explode('.', $image_name));

                        //rename the image
                        $image_name = "Food-Name-".rand(000, 9999).'.'.$ext;

                        $src_path = $_FILES['image']['tmp_name'];

                        $dest_path = "../images/food/".$image_name;

                        //Finally Upload the Image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded then we will stop the process and redirect with error message 
                        if($upload==false)
                        {
                            //SEt message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image. </div>";
                            //Redirect to Add Category Page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }

                        //B. Remove the Current Image
                        if($current_image!="")
                        {
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //check whether the image is removed or not
                            //If failed to remove then display message and stop the processs 
                            if($remove==false)
                            {
                                //Failed to remove image 
                                $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current Image.</div>"; 
                                header('location:'.SITEURL.'admin/manage-food.php'); 
                                die();//Stop the Process
                            }
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                { 
                    $image_name = $current_image;
                }

                //3. Update the Database
                $sql3 = "UPDATE tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    category_id = '$category',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";

                //Execute the Query
                $res3 = mysqli_query($conn, $sql3);

                //4. Redirect to Manage Category with Message
                //Check whether executed or not
                if($res3==true)
                {
                    //Category Updated
                    $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>"; 
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //failed to update category
                    $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

        }
    ?>

    </div>
</div>


<?php include('partials/footer.php'); ?>