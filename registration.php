<!-- Header -->
<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>
<?php include 'admin/includes/functions.php';?>


<!-- Navigation -->
<?php include 'includes/navigation.php';?>


<?php

    if(isset($_POST['submit'])){
        $user_name = escape($_POST['user_name']);
        $user_email = escape($_POST['user_email']);
        $user_password = escape($_POST['user_password']);
        
        if(!empty($user_name) && !empty($user_email) && !empty($user_password)){
        
            $user_name = mysqli_real_escape_string($connection,$user_name);
            $user_email = mysqli_real_escape_string($connection,$user_email);
            $user_password = mysqli_real_escape_string($connection,$user_password);
            
            // Encrypt password with blowfish
            $user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 12]);

            $query = "INSERT INTO users (user_name, user_password, user_email, user_role) ";
            $query .= "VALUES('{$user_name}', '{$user_password}', '{$user_email}', 'Subscriber')";

            $register_user_query = mysqli_query($connection,$query);

            if(!$register_user_query){
                die("Query Failed" . mysqli_error($connection));
            }
            
            $message = '<h6 class="alert alert-success text-center">Registration succesful</h6>';
            $message .= "<a href='index.php' class='btn btn-primary btn-lg btn-block'>Login</a><br>";
            
            
        } else {
            
            $message = '<h6 class="alert alert-danger text-center">Please complete all fields</h6>';
//            echo "<script>alert('All fields must be filled')</script>";
        }
    } else {
        $message = '';
    } 


?>




<!-- Page Content -->
<div class="container">


    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Register</h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                           <?php echo $message;?>
                            <div class="form-group">
                                <label for="user_name" class="sr-only">Username</label>
                                <input class="form-control" type="text" name="user_name" id="username" placeholder="Enter username">
                            </div>

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input class="form-control" type="email" name="user_email" id="email" placeholder="somebody@example.com">
                            </div>

                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input class="form-control" type="password" name="user_password" id="key" placeholder="Password">
                            </div>

                            <input class="btn btn-custom btn-lg btn-block" type="submit" name="submit" value="Register">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <!-- /.row -->


    <hr>

    <?php include 'includes/footer.php';?>