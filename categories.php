<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
            
                //Query to Get all Categories from Database 
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //Execute Query
                $res = mysqli_query($conn, $sql);

                 //Count RoWS
                 $count = mysqli_num_rows($res);

                 //check whether we have data in database or not
                 if($count>0)
                 {
                    //we have data
                    while($row=mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title=$row['title'];
                        $image_name = $row['image_name'];

                        ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php
                                        if($image_name=="")
                                        {
                                            //display the message
                                            echo "<div class='error'>Image Not Available. </div>";
                                        }
                                        else
                                        {
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    

                                    <h3 class="title"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php
                    }
                 }
                 else
                 {
                    //display the message
                    echo "<div class='error'>Image Not Added. </div>";
                 }

            ?>

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>