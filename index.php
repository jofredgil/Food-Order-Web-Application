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

    <?php
            if(isset($_SESSION['order']))
            {
                echo $_SESSION['order'];
                unset($_SESSION['order']);
            }

    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //Query to Get all Categories from Database 
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

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



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
                 //Query to Get all Food from Database 
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

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

        <p class="text-center">
            <a href="<?php echo SITEURL; ?>foods.php?food_id=<?php echo $id; ?>">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

    
<?php include('partials-front/footer.php'); ?>