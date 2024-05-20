<?php include('../config/constants.php'); ?>


<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/style-login.css">
    </head>

    <body>

        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }


            ?>
            <br><br>


            <!-- Login start -->
            <div class="login-text">
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"><br><br>

                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"><br><br>

                <input type="submit" name="submit" value="Login" class="btn-primary">
                <br><br>

            </form>
            </div>

            

            <!-- Login end -->


            <p class="link">Created By - <a href="#">Jofred Gil</a></p>
        </div>
        
    </body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //2. SQL to check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the Query
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count==1)
        {

            //User Available and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username;

            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/');

        }
        else
        {
            //User not Available and Login Fail
            $_SESSION['login'] = "<div class='error text-center'>Username or Password Did Not Match.</div>";
            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>