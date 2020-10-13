<?php

if(isset($_GET['post_id'])){
    $edit_post_id = escape($_GET['post_id']);

    $query = "SELECT * FROM posts WHERE post_id = $edit_post_id";
    $select_posts_by_id = mysqli_query($connection,$query);

    while($row = mysqli_fetch_assoc($select_posts_by_id)){
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_author = $row['post_author'];
        $post_author_id = $row['post_author_id'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_tags = $row['post_tags'];
        $post_status = $row['post_status'];

    }
}
    
if(isset($_POST['update_post'])){

    $post_title = escape($_POST['post_title']);
    $post_category_id = escape($_POST['post_category_id']);
    $post_author_id = escape($_POST['post_author_id']);
    
    $query = "SELECT * FROM users WHERE user_id = $post_author_id";
    $user_id_query = mysqli_query($connection, $query);
    
    confirmQuery($user_id_query);
    
    $row = mysqli_fetch_assoc($user_id_query);
    $post_author = $row['user_firstname'] . " " . $row['user_lastname'];
    
    $post_image = escape($_FILES['post_image']['name']);
    $post_image_temp = escape($_FILES['post_image']['tmp_name']);

    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);
    $post_status = escape($_POST['post_status']);

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image)){
        $query = "SELECT * FROM posts WHERE post_id = $edit_post_id";
        $select_image = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_image)){
            $post_image = $row['post_image'];
        }

    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = {$post_category_id}, ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '{$post_author}', ";
    $query .= "post_author_id = '{$post_author_id}', "; 
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "WHERE post_id = {$edit_post_id}";
        
    $update_post = mysqli_query($connection,$query);
    
    echo "<h5 class='alert alert-success'>Post Updated: <a href='posts.php'>Edit more posts</a> or <a href='../post.php?post_id={$post_id}'>View Post</a></h5>";

}

if(isset($_POST['reset_views'])){
    
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $post_id";
    $reset_views_query = mysqli_query($connection, $query);
    
    echo "<h5 class='alert alert-success'>Views count reset: <a href='posts.php'>Edit more posts</a> or <a href='../post.php?post_id={$post_id}'>View Post</a></h5>";
    
}

?>



<form action="" method="post" enctype="multipart/form-data">
    <!-- Enctype is for image uploading -->

    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title?>">
    </div>

    <div class="form-group">
        <label for="post_category">Category</label>
        <select class="form-control" name="post_category_id" id="">

            <?php
            
                $query = "SELECT * FROM categories";
                $select_categories = mysqli_query($connection,$query);
               
                confirmQuery($select_categories);

                while($row = mysqli_fetch_assoc($select_categories)){
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
               
                if($post_category_id == $cat_id){
                    echo "<option value='{$cat_id}' selected>{$cat_title}</option>";
                } else {
                    echo "<option value='{$cat_id}'>{$cat_title}</option>";
                }}
               
            ?>


        </select>
    </div>

    <div class="form-group">
        <label for="post_author">Post Author</label>
        <select class="form-control" name="post_author_id" id="">

            <?php
            
                $user_query = "SELECT * FROM users";
                $select_users = mysqli_query($connection,$user_query);
               
                confirmQuery($select_users);

                while($row = mysqli_fetch_assoc($select_users)){
                    $user_id = $row['user_id'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_fullname = $user_firstname . " " . $user_lastname;
                    
                    if($post_author_id == $user_id){
                        echo "<option value='{$user_id}' selected>{$user_fullname}</option>";
                    } else {
                        if(!empty($user_firstname)){
                        echo "<option value='{$user_id}'>{$user_fullname}</option>";     
                    }
                }
                }

            ?>
        </select>
    </div>




    <div class="form-group">
        <label for="post_status">Post Status</label><br>
        <select class="form-control" name="post_status" id="">
            <option value="<?php echo $post_status;?>"><?php echo $post_status;?></option>
            <?php
            
                if($post_status == 'Draft'){
                    echo '<option value="Published">Published</option>';
                } else {
                    echo '<option value="Draft">Draft</option>';
                }            
            ?>

        </select>
    </div>

    <div class="form-group">
        <img src="../images/<?php echo $post_image;?>" width="100" alt="">
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="post_image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags;?>">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content;?></textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post" onclick="javascript: return confirm('Confirm update?'); ">
        <input type="submit" class="btn btn-info" name="reset_views" value="Reset Views" onclick="javascript: return confirm('Are you sure you want to reset view count?'); ">
        <a href="posts.php" class="btn btn-danger">Cancel</a>

    </div>
</form>