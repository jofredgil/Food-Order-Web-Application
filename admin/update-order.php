<?php include('partials/menu.php'); ?>

<?php

     //Check whether the id is set or not 
     if(isset($_GET['id']))
     {
         //Get the ID and all other details
        //echo "Getting the Data";
        $id = $_GET['id'];

        //Create SQL Query to get all other details
        $sql = "SELECT * FROM tbl_order WHERE id=$id";

         //Execute the Query
         $res = mysqli_query($conn, $sql);
                
         //Count the Rows to check whether the id is valid or not
         $count = mysqli_num_rows($res);

         if($count==1)
         {
            $row = mysqli_fetch_assoc($res);

            $food=$row['food'];
            $price=$row['price'];
            $qty = $row['qty'];
            $total = $row['total'];
            $order_date = $row['order_date'];
            $status=$row['status'];
            $customer_name=$row['customer_name'];
            $customer_contact = $row['customer_contact'];
            $customer_email = $row['customer_email'];
            $customer_address = $row['customer_address'];
            $payment = $row['payment'];
         }
         else
         {
             //redirect to manage category with session message
            header('location:'.SITEURL. 'admin/manage-order.php');
         }


     }
     else
     {
        //redirect to manage category with session message
        header('location:'.SITEURL. 'admin/manage-order.php');
     }

?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br><br>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Food Name:</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>

                <tr>
                    <td>Price:</td>
                    <td>₱ <?php echo $price; ?></td>
                </tr>

                <tr>
                    <td>Qty:</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo "selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancel</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" cols="30" row="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
        
            if(isset($_POST['submit']))
            {
            
                 //1. Get all the values from our form
                 $id = $_POST['id'];
                 $price=$_POST['price'];
                 $qty = $_POST['qty'];
 
                 $total = $price * $qty;
 
                 $status=$_POST['status'];
                 
                 $customer_name=$_POST['customer_name'];
                 $customer_contact = $_POST['customer_contact'];
                 $customer_email = $_POST['customer_email'];
                 $customer_address = $_POST['customer_address'];
                 $payment = $_POST['payment'];
 
                 // Update the Database
                 $sql2 = "UPDATE tbl_order SET
                     qty = '$qty',
                     total = $total,
                     status = '$status',
                     customer_name = '$customer_name',
                     customer_contact = '$customer_contact',
                     customer_email = '$customer_email',
                     customer_address = '$customer_address',
                     payment = '$payment'
                     WHERE id=$id
                 ";
 
                  //Execute the Query
                  $res2 = mysqli_query($conn, $sql2);
 
                 // Redirect to Manage Category with Message
                 //Check whether executed or not
                 if($res2==true)
                 {
                     //Order Updated
                     $_SESSION['update'] = "<div class='success'>Order Updated Successfully.</div>"; 
                     header('location:'.SITEURL.'admin/manage-order.php');
                 }
                 else
                 {
                     //failed to update order
                     $_SESSION['update'] = "<div class='error'>Failed to Update Order.</div>";
                     header('location:'.SITEURL.'admin/manage-order.php');
                 }
             }
             else
             {
 
            }
        
        ?>

    </div>    
</div>

<?php include('partials/footer.php'); ?>