<?php session_start() ?>



<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CMS</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php
                
            global $connection;
            $query = 'SELECT * FROM categories';
            $select_all_categories_query = mysqli_query($connection,$query);
                
            while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                
                $category_class = '';
                $registration_class = '';
                $contact_class = '';
                $page_name = basename($_SERVER['PHP_SELF']);
                
                if(isset($_GET['category']) && $_GET['category'] == $cat_id) {
                    $category_class = 'active';  
                } else if($page_name == 'registration.php') {
                    $registration_class = 'active';
                } else if($page_name == 'contact.php') {
                    $contact_class = 'active';
                };
                    
                    
                echo "<li class='$category_class'><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
            }

            // Decides what to show to user based on role/login state   
            if(isset($_SESSION['user_role'])){                    
                if($_SESSION['user_role'] == 'Admin'){

                    echo "<li><a href='admin/index.php'>Admin</a></li>";

                    if(isset($_GET['post_id'])){
                        $post_id = escape($_GET['post_id']);
                        echo "<li><a href='admin/posts.php?source=edit_post&post_id=$post_id'>Edit Post</a></li>";   
                    }   
                } else {
                    echo "<li><a href='subscriber/index.php'>Profile</a></li>";
                }
                
            } else {
                echo "<li class='$registration_class'><a href='registration.php'>Register</a></li>";
            }


            echo "<li class='$contact_class'><a href='contact.php'>Contact</a></li>";

            ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>