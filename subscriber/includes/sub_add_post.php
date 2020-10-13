<?php

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $user_firstname = $_SESSION['user_firstname'];
    $user_lastname = $_SESSION['user_lastname'];
}


if(isset($_POST['create_post'])){
    
    $post_title = escape($_POST['post_title']);
    $post_author_id = escape($_POST['post_author_id']);

    $query = "SELECT * FROM users WHERE user_id = $post_author_id";
    $select_user = mysqli_query($connection,$query);
    
    confirmQuery($select_user);
    
    $row = mysqli_fetch_assoc($select_user);
    $post_author = $row['user_firstname'] . " " . $row['user_lastname'];    
    
    $post_category_id = escape($_POST['post_category_id']);
    $post_status = escape($_POST['post_status']);

    $post_image = escape($_FILES['post_image']['name']);
    $post_image_temp = escape($_FILES['post_image']['tmp_name']);
    
    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);
    $post_date = date('d-m-y');
    
    // This uploads the image to the image folder...
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_author_id, post_date, post_image, post_content, post_tags, post_status) ";
    
    $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', {$post_author_id}, now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
    
    
    $send_query = mysqli_query($connection,$query);
    
    confirmQuery($send_query);
    
    
    $post_id = mysqli_insert_id($connection);
    
    echo "<h5 class='alert alert-success'>Post Succesfully Created: <a href='posts.php'>Edit posts</a> or <a href='../post.php?post_id={$post_id}'>View Post</a></h5>";

}

?>

<form action="" method="post" enctype="multipart/form-data">
    <!-- Enctype is for image uploading -->

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="post_category">Post Category</label><br>
        <select class="form-control" name="post_category_id" id="">

            <?php
            
                $category_query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection,$category_query);
               
                confirmQuery($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)){
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
               
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";     
                } 
               
            ?>

        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <select class="form-control" name="post_author_id" id="">
            <option value="<?php echo $user_id?>"><?php echo $user_firstname . " " . $user_lastname;?></option>
        </select>
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select class="form-control" name="post_status" id="">
            <option value="Draft">Select Option</option>
            <option value="Draft">Draft</option>
            <option value="Published">Published</option>

        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>



    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Title</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
        <a href="posts.php" class="btn btn-danger">Cancel</a>

    </div>
</form>