<!-- Header -->
<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>
<?php include 'admin/includes/functions.php';?>


<!-- Navigation -->
<?php include 'includes/navigation.php';?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">


            <?php
            
            if(isset($_GET['post_id'])){
                
            $post_id = escape($_GET['post_id']);
                
            $query = "UPDATE posts SET post_views_count = post_views_count + 1 ";
            $query .= "WHERE post_id = $post_id";
                
            $view_count_query = mysqli_query($connection,$query);
                
            if(!$view_count_query){
                die("Query Failed" . mysqli_error($connection));
            }
            
            $query = "SELECT * FROM posts WHERE post_id = $post_id";
            $select_all_posts_query = mysqli_query($connection,$query);
                            
            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
                
            ?>

            <!--
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
-->

            <!-- Blog Post -->
            <h2>
                <a href="#"><?php echo $post_title; ?></a>
            </h2>
            <p class="lead">
                by <a href="author_posts.php?post_author=<?php echo $post_author;?>&post_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
            <hr>
            <img class="img-responsive" src=<?php echo "images/$post_image";?> alt="">
            <hr>
            <p><?php echo $post_content; ?></p>

            <hr>

            <?php 
                
            }} else {
                
                header("Location: index.php");
                
            }
            
            ?>





            <!-- Blog Comments -->
            <?php
            
            if(isset($_SESSION['user_id'])){
                $user_id = $_SESSION['user_id'];
                $user_name = $_SESSION['user_name'];
                
                if(isset($_POST['create_comment'])) {

                    $comment_post_id = escape($_GET['post_id']);
                    $comment_author = $user_name;
                    $comment_author_id = $user_id;
                    $comment_content = escape($_POST['comment_content']);
                    $comment_status = "approved";

                    if(!empty($comment_content)) {

                        $query = "INSERT INTO comments (comment_post_id, comment_author, comment_author_id, comment_content, comment_status, comment_date) ";
                        $query .= "VALUES ('$comment_post_id', '{$comment_author}', '{$comment_author_id}', '{$comment_content}', '{$comment_status}', now())";

                        $add_comment = mysqli_query($connection, $query);

                        if(!$add_comment){
                            die("Add Query Failed" . mysqli_error($connection));
                        }

                    } else {

                        echo "<script>alert('Fields can not be empty')</script>";


                    }
                }
            
            ?>

            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="comment_content">Comment from: <?php echo $user_name;?></label>
                        <textarea class="form-control" rows="3" name="comment_content"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                </form>
            </div>

            <hr>


            <?php
            } else {
            ?>

            <div class="well">
                <h4><a href="index.php">Login</a> to leave a Comment</h4>
            </div>

            <?php   
            }
            ?>
            <!-- /. Comments form -->





            <!-- Posted Comments -->
            <?php
            
            $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
            $query .= "AND comment_status = 'approved' ";
            $query .= "ORDER BY comment_id DESC";
            
            $select_comment_query = mysqli_query($connection,$query);
                        
            if(!$select_comment_query){
                die("Get Comment Query failed" . mysqli_error($select_comment_query));
            };
            
            while($row = mysqli_fetch_assoc($select_comment_query)){
                $comment_date = $row['comment_date'];
                $comment_content = $row['comment_content'];
                $comment_author = $row['comment_author'];
                
            ?>

            <!-- Comment -->
            <div class="media">
                <a class="pull-left" href="#">
                    <img class="media-object" src="http://placehold.it/64x64" alt="">
                </a>
                <div class="media-body">
                    <h4 class="media-heading"><?php echo $comment_author;?>
                        <small><?php echo $comment_date;?></small>
                    </h4>
                    <?php echo $comment_content;?>
                </div>
            </div>


            <?php
                
            }
                  
            ?>







        </div>


        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php';?>


    </div>
    <!-- /.row -->

    <hr>

    <?php include 'includes/footer.php';?>