<?php include "includes/admin_header.php";?>


<div id="wrapper">

    <?php include "includes/admin_navigation.php";?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to admin
                        <small><?php echo $_SESSION['user_firstname']; ?></small>
                    </h1>


                    <?php

    if(isset($_SESSION['user_name'])){
        $user_name = escape($_SESSION['user_name']);

        $query = "SELECT * FROM users WHERE user_name = '{$user_name}'";
        $select_user_profile = mysqli_query($connection, $query);


        while($row = mysqli_fetch_assoc($select_user_profile)){
            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];

        }
    }

    if(isset($_POST['update_profile'])){
    $user_name = escape($_POST['user_name']);
    $user_password = escape($_POST['user_password']);
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    
    $user_image = escape($_FILES['user_image']['name']);
    $user_image_temp = escape($_FILES['user_image']['tmp_name']);
        
    // This uploads the image to the image folder...(make sure access is set to read/write)
    move_uploaded_file($user_image_temp, "../images/user_images/$user_image");
    
    if(empty($user_image)){
            $query = "SELECT * FROM users WHERE user_id = $user_id";
            $select_image = mysqli_query($connection,$query);
            
            while($row = mysqli_fetch_assoc($select_image)){
                $user_image = $row['user_image'];
            }
 
        }     
    
    if(!empty($user_password)){
        
        $user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        $query = "UPDATE users SET ";
        $query .= "user_name = '{$user_name}', ";
        $query .= "user_password = '{$user_password}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_image = '{$user_image}' ";
        $query .= "WHERE user_id = {$user_id} ";

        $update_user_query = mysqli_query($connection,$query);

        confirmQuery($update_user_query);

        echo "<h4 class='alert alert-success'>User Updated: " . " " . "<a href='users.php'>Back to users...</a></h4>";
        
    } else {
        
        $query = "UPDATE users SET ";
        $query .= "user_name = '{$user_name}', ";
        $query .= "user_firstname = '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_image = '{$user_image}' ";
        $query .= "WHERE user_id = {$user_id} ";

        $update_user_query = mysqli_query($connection,$query);

        confirmQuery($update_user_query);

        echo "<h4 class='alert alert-success'>User Updated: " . " " . "<a href='users.php'>Back to users...</a></h4>";
    }
}    
                
    
?>


                    <form action="" method="post" enctype="multipart/form-data">
                        <!-- Enctype is for image uploading -->

                        <div class="form-group">
                            <label for="user_name">Username</label>
                            <input type="text" class="form-control" name="user_name" value="<?php echo $user_name;?>">
                        </div>

                        <div class="form-group">
                            <label for="user_password">Password</label>
                            <input autocomplete="off" type="password" class="form-control" name="user_password">
                        </div>

                        <div class="form-group">
                            <label for="user_firstname">First Name</label>
                            <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname;?>">
                        </div>

                        <div class="form-group">
                            <label for="user_lastname">Last Name</label>
                            <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>">
                        </div>

                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input type="email" class="form-control" name="user_email" value="<?php echo $user_email;?>">
                        </div>

                        <div class="form-group">
                            <img src="../images/user_images/<?php echo $user_image;?>" width="50" alt="">
                        </div>

                        <div class="form-group">
                            <label for="post_image">User Image</label>
                            <input type="file" name="user_image">
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php";?>