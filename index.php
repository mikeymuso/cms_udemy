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

            <h1 class="page-header">
                All Posts
                <!--                <small>Secondary Text</small>-->
            </h1>

            <?php
            
            // Set this first
            $posts_per_page = 5;
            
            // Pagination
            if(isset($_GET['page'])){
                $page = escape($_GET['page']);
            } else {
                $page = "";
            }
            
            if($page == "" || $page == 1){
                $page_1 = 0;
            } else {
                $page_1 = ($page * $posts_per_page) - $posts_per_page;
            }
            

            // Count the number of total posts
            $query = "SELECT * FROM posts WHERE post_status = 'Published'";
            $post_count_query = mysqli_query($connection,$query);
            $post_count = mysqli_num_rows($post_count_query);            
            
            $page_count = ceil($post_count / $posts_per_page);
            $posts_per_page = 5;                     
            
            
            // Display posts
            $query = "SELECT * FROM posts WHERE post_status = 'published'";
            $query .= " ORDER BY post_date DESC LIMIT $page_1, $posts_per_page";
            $select_all_posts_query = mysqli_query($connection,$query);
        
            if(!$select_all_posts_query){
                die("Query failed" . mysqli_error($connection));
            }
        
            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'],0,200) . " . . .";
                $post_status = $row['post_status'];
            
                
            ?>


            <!-- Blog Post -->
            <h2>
                <a href="post.php?post_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
            </h2>
            <p class="lead">
                by <a href="author_posts.php?post_author=<?php echo $post_author;?>&post_id=<?php echo $post_id; ?>"><?php echo $post_author; ?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
            <hr>
            <a href="post.php?post_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
            </a>
            <hr>
            <p><?php echo $post_content; ?></p>
            <a class="btn btn-primary" href="post.php?post_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

            <hr>

            <?php 
                
            }
            
            ?>

        </div>
        <!-- /.Blog entries -->


        <!-- Blog Sidebar Widgets Column -->
        <?php include 'includes/sidebar.php';?>

    </div>
    <!-- /.row -->

    <hr>


    <ul class="pager">


        <?php
        
            for($i = 1;$i<=$page_count;$i++){
        
                if($i == $page){
                    echo "<li><a class='active_link' href='index.php?per_page=$posts_per_page&page=$i'>$i</a></li>";
                } else {
                    echo "<li><a href='index.php?per_page=$posts_per_page&page=$i'>$i</a></li>";
                }   
            }
        
        
        ?>




    </ul>

    <?php include 'includes/footer.php';?>