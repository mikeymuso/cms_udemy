<?php

if(isset($_POST['add_user'])){
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
    
    // Encrypt password
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, ['cost' => 12]);
    
    $query = "INSERT INTO users(user_name, user_password, user_firstname, user_lastname, user_email, user_image, user_role) ";
    
    $query .= "VALUES('{$user_name}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', '{$user_role}')";
    
    
    $add_user_query = mysqli_query($connection,$query);
    
    confirmQuery($add_user_query);
    
    echo "<h5 class='alert alert-success'>User Created: " . " " . "<a href='users.php'>View users</a></h5>";
    
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <!-- Enctype is for image uploading -->

    <div class="form-group">
        <label for="user_name">Username</label>
        <input type="text" class="form-control" name="user_name">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <label for="user_firstname">First Name</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last Name</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="post_image">User Image</label>
        <input type="file" name="user_image">
    </div>

    <div class="form-group">
        <label for="post_category">Role</label><br>
        <select class="form-control" name="user_role" id="">
            <option value="Subscriber">Select Option</option>
            <option value="Admin">Admin</option>
            <option value="Subscriber">Subscriber</option>
        </select>
    </div>


    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_user" value="Add user">
        <a href="users.php" class="btn btn-danger">Cancel</a>

    </div>
</form>
