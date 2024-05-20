<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
                //Query to Get all Food from Database 
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes'";

                //Execute Query
                $res2 = mysqli_query($conn, $sql2);

                 //Count RoWS
                 $count2 = mysqli_num_rows($res2);

                 //check whether we have data in database or not
                 if($count2>0)
                 {
                    //we have data
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        $id = $row['id'];
                        $title=$row['title'];
                        $price=$row['price'];
                        $description=$row['description'];
                        $image_name = $row['image_name'];

                        ?>

                        <div class="food-menu-box">
                                <div class="food-menu-img">
                                <?php
                                        if($image_name=="")
                                        {
                                            //display the message
                                            echo "<div class='error'>Image Not Available. </div>";
                                        }
                                        else
                                        {
                                            ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicken Hawain Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                    
                                </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">₱<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                 }
                else
                {
                   //display the message
                   echo "<div class='error'>Food Not Available. </div>";
                }
            
            ?>


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>