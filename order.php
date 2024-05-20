<?php include('partials-front/menu.php'); ?>

<?php

    //Check whether food id is set or not 
    if(isset($_GET['order_id']))
    {

        //Get the Food id and details of the selected food
        $order_id = $_GET['order_id'];
        
        //Get the Details of the Selected Food
        $sql3 = "SELECT * FROM tbl_order WHERE id=$order_id";
        
        //Execute the Query
        $res3 = mysqli_query($conn, $sql3);
        
        //Count the rows
        $count2 = mysqli_num_rows($res3);
        
        //Check whether the data is available or not 
        if($count2==1)
        {
            //WE Have Data
            $row2=mysqli_fetch_assoc($res3);

            $payment = $row2['payment'];
        }
    }

?>

<?php

    //Check whether food id is set or not 
    if(isset($_GET['food_id']))
    {

        //Get the Food id and details of the selected food
        $food_id = $_GET['food_id'];
        
        //Get the Details of the Selected Food
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        
        //Execute the Query
        $res = mysqli_query($conn, $sql);
        
        //Count the rows
        $count = mysqli_num_rows($res);
        
        //Check whether the data is available or not 
        if($count==1)
        {
            //WE Have Data
            $row=mysqli_fetch_assoc($res);

            $title=$row['title'];
            $price=$row['price'];   
            $image_name = $row['image_name'];
        }
        else
        {
            //Redirect to homepage 
            header('location:'.SITEURL);
        }
    }
    else
    {
        
        //Redirect to homepage 
        header('location:'.SITEURL);
    }

?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-yellow">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order text-yellow">
                <fieldset>
                    <legend>Selected Food</legend>

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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">₱<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Jofred Gil" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. +63984xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. jofredgil@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <div>Mode of Payment</div>
                        <input type="radio" name="payment" value="gcash"> GCASH</input>
                        <input type="radio" name="payment" value="cod"> Cash on Delivery
                        <input type="radio" name="payment" value="credit_card"> Credit Card
                        <br><br>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
            
                if(isset($_POST['submit']))
                {
                    $payment_method = $_POST['payment'];
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];

                    $total = $price * $qty; // total price x qty

                    $order_date = date("Y-m-d h:i:sa"); //Order DAte

                    $status = "ordered"; // Ordered, On Delivery, Delivered, Cancelled

                    $customer_name = $_POST['full-name'];
                    $customer_contact = $_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];
                    $payment_details= $_POST['payment'];

                    //Save the order in Databaase

                    //Create SQL to save the data
                    $sql2 = "INSERT INTO tbl_order SET
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address',
                    payment = '$payment_details'
                    ";

                    if ($payment_method === "gcash") {
                        // Handle GCASH payment
                        $payment_details = "GCASH";
                    } elseif ($payment_method === "cod") {
                        // Handle Cash on Delivery payment
                        $payment_details = "Cash on Delivery";
                    } elseif ($payment_method === "credit_card") {
                        // Handle Credit Card payment
                        $payment_details = "Credit Card";
                    } else {
                        // Handle if no payment method selected
                        $payment_details = "Not Selected";
                    }

                    //Execute the Query
                    $res2 = mysqli_query($conn, $sql2);

                    if($res2==true)
                    {
                        //Query Executed and Category Added
                        $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Failed to Add Category
                        $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
                       header('location:'.SITEURL);
                    }
                }

            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>