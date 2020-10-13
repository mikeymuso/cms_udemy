<?php include "delete_modal.php"?>

<?php

    if(isset($_POST['checkboxArray'])){
        
        foreach($_POST['checkboxArray'] as $checkbox_post_id){
            $bulk_options = $_POST['bulk_options'];

            switch($bulk_options){
                case "Published":
                    
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkbox_post_id}";
                    $update_post_to_published = mysqli_query($connection,$query);
                    break;
                    
                case "Draft":
                    
                    $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$checkbox_post_id}";
                    $update_post_to_draft = mysqli_query($connection,$query);
                    break;
                    
                case "delete":
                    
                    $query = "DELETE FROM posts WHERE post_id = {$checkbox_post_id}";
                    $bulk_delete = mysqli_query($connection,$query);
                    
                    // Remove all associated comments also
                    $query = "DELETE FROM comments WHERE comment_post_id = {$checkbox_post_id}";
                    $bul_delete_comments = mysqli_query($connection,$query);
                    
                    break;
                    
                case "clone":
                    
                    $query = "SELECT * FROM posts WHERE post_id = {$checkbox_post_id}";
                    $select_posts = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_posts)){
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
                    
                    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_author_id, post_date, post_image, post_content, post_tags, post_status) ";
    
                    $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_author_id}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";

                    $clone_post_query = mysqli_query($connection,$query);
                    
                    if(!$clone_post_query){
                        die("Query Failed" . mysqli_error($connection));
                    }
                    
                    break;
                    
                case "reset_views":
                    
                    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$checkbox_post_id}";
                    $reset_views_query= mysqli_query($connection,$query);
                    break;
                    
            }
        
        }
    }


?>


<form action="" method="post">
    <table class="table table-bordered table-hover">

        <div id="bulkOptionContainer" class="col-xs-4" style="padding:0 0 20px 0 !important">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Option</option>
                <option value="Published">Publish</option>
                <option value="Draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
                <option value="reset_views">Reset View Count</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply" onclick="javascript: return confirm('Are you sure you want to do this?');">
            <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Views</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr>

                <?php
                       
                $query = "SELECT * FROM posts ORDER BY post_date DESC";
                $select_posts = mysqli_query($connection,$query);

                 if(!mysqli_num_rows($select_posts) == 0) {
                
                    while($row = mysqli_fetch_assoc($select_posts)){
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_category_id = $row['post_category_id'];
                        $post_author_id = $row['post_author_id'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_tags = $row['post_tags'];
                        $post_status = $row['post_status'];
                        $post_views_count = $row['post_views_count'];

                        echo "<tr>";

                        ?>

                <td><input type="checkbox" class="checkboxes" name="checkboxArray[]" value="<?php echo $post_id;?>"></td>

                <?php
                    
                    echo "<td>{$post_id}</td>";
                    
                    $query = "SELECT * FROM users WHERE user_id = $post_author_id";
                    $get_author_name = mysqli_query($connection,$query);
                    
                    confirmQuery($get_author_name);
                    
                    $row = mysqli_fetch_assoc($get_author_name);
                    $post_author = $row['user_firstname'] . " " . $row['user_lastname'];
                    
                    echo "<td>{$post_author}</td>";
                    echo "<td><a href='../post.php?post_id={$post_id}'>{$post_title}</a></td>";
                    
                    
                    $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                    
                    $select_categories_id = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_categories_id)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    }
                    
                    echo "<td>{$cat_title}</td>";
                    echo "<td>{$post_status}</td>";
                    echo "<td><img width='100' src='../images/{$post_image}' alt='image'</td>";
                    echo "<td>{$post_tags}</td>";
                    
                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $get_comments_query = mysqli_query($connection,$query);
                    $comment_count = mysqli_num_rows($get_comments_query);
                    
                    echo "<td><a href='comments.php?source=view_comments&post_id=$post_id'>{$comment_count}</a></td>";
                    echo "<td>{$post_views_count}</td>";
                    echo "<td>{$post_date}</td>";
                    
                    echo "<td><a href='../post.php?post_id={$post_id}'>View Post</a></td>";

                    echo "<td><a href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a></td>";
                    echo "<td><a rel='{$post_id}' href='javascript: void(0)' class='delete_link'>Delete</a></td>";
                        
                }
                     
                    echo "</tr></tbody></table>";
                    // End of table 
                     
                } else {
                     echo "</tr></tbody></table><div class='alert alert-info'>No posts</div>";
                }


                // Delete posts
                if(isset($_GET['delete'])){
                    $delete_post_id = escape($_GET['delete']);
                    
                    $query = "DELETE FROM posts WHERE post_id = {$delete_post_id}";
                    $delete_query = mysqli_query($connection,$query);
                    
                    // Remove all associated comments also
                    $query = "DELETE FROM comments WHERE comment_post_id = {$delete_post_id}";
                    $delete_assoc_comments = mysqli_query($connection,$query);
                    
                    header("Location: posts.php");
                    
                    confirmQuery($delete_query);
                        
                }
                
                ?>

                <script>
                    // Script for delete modal
                    $(document).ready(function() {

                        $(".delete_link").on('click', function() {
                            var id = $(this).attr("rel");
                            var delete_url = "posts.php?delete=" + id;

                            $(".modal_delete_link").attr("href", delete_url);
                            $("#myModal").modal('show');
                        });

                    })
                </script>

            </tr>
        </tbody>
    </table>
</form>