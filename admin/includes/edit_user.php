<?php

if(isset($_GET['user_id'])){
    $user_id = escape($_GET['user_id']);
    
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $select_user_query = mysqli_query($connection,$query);
    
    confirmQuery($select_user_query);
    
    while($row = mysqli_fetch_assoc($select_user_query)){
        $user_name = $row['user_name'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];    
        
    }


if(isset($_POST['update_user'])){
    $user_name = escape($_POST['user_name']);
    $user_password = escape($_POST['user_password']);
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_email = escape($_POST['user_email']);
    
    $user_image = escape($_FILES['user_image']['name']);
    $user_image_temp = escape($_FILES['user_image']['tmp_name']);
    
    $user_role = escape($_POST['user_role']);
    
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
        $query .= "user_image = '{$user_image}', ";
        $query .= "user_role = '{$user_role}' ";
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
        $query .= "user_image = '{$user_image}', ";
        $query .= "user_role = '{$user_role}' ";
        $query .= "WHERE user_id = {$user_id} ";

        $update_user_query = mysqli_query($connection,$query);

        confirmQuery($update_user_query);

        echo "<h4 class='alert alert-success'>User Updated: " . " " . "<a href='users.php'>Back to users...</a></h4>";
    }
}

} else {
    // if user_id is not set...
    header("Location: index.php");
}
        

if(isset($_POST['cancel_update'])){
    header ("Location: users.php?source=view_all_users");
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
        <label for="post_category">Role</label><br>
        <select class="form-control" name="user_role" id="">
            <option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
            <?php
            
                if($user_role == 'Admin'){
                    echo '<option value="Subscriber">Subscriber</option>';
                } else {
                    echo '<option value="Admin">Admin</option>';
                }            
            ?>

        </select>
    </div>


    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_user" value="Update user" onclick="javascript: return confirm('Confirm update?'); ">
        <a href="users.php" class="btn btn-danger">Cancel</a>
    </div>
</form>