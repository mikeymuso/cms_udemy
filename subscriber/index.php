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
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file-text fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php

                                        if(isset($_SESSION['user_id'])){
                                            $user_id = $_SESSION['user_id'];
                                        }    

                                        $query = "SELECT * FROM posts WHERE post_author_id = $user_id";
                                        $select_all_posts = mysqli_query($connection,$query);                            
                                        
                                        if($select_all_posts) {
                                            $posts_count = mysqli_num_rows($select_all_posts);
                                        } else {
                                            $posts_count = 0;
                                        }

                                        $posts_count = mysqli_num_rows($select_all_posts);

                                    ?>
                                    
                                    <div class="huge"><?php echo $posts_count;?></div>
                                    <div>Posts</div>
                                </div>
                            </div>
                        </div>
                        <a href="posts.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">

                                    <?php
                                        $query = "SELECT * FROM comments WHERE user_id = $user_id";
                                        $select_all_comments = mysqli_query($connection,$query);

                                        if($select_all_comments) {
                                            $comments_count = mysqli_num_rows($select_all_comments);
                                        } else {
                                            $comments_count = 0;
                                        }
                                    ?>

                                    <div class="huge"><?php echo $comments_count;?></div>
                                    <div>Comments</div>
                                </div>
                            </div>
                        </div>
                        <a href="comments.php">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>        
            </div>
            <!-- /.widgets -->

            <?php
           
                $query = "SELECT * FROM posts WHERE post_author_id = $user_id AND post_status = 'Published'";
                $select_all_published_posts = mysqli_query($connection,$query);
                $posts_published_count = mysqli_num_rows($select_all_published_posts);
            
                $query = "SELECT * FROM posts WHERE post_author_id = $user_id AND post_status = 'Draft'";
                $select_all_draft_posts = mysqli_query($connection,$query);
                $posts_draft_count = mysqli_num_rows($select_all_draft_posts);
                
                // This needs implementing - COMMENT AUTHOR ID
//                $query = "SELECT * FROM comments WHERE comment_author_id = $user_id";
//                $unapproved_comments = mysqli_query($connection,$query);
                $comments_count = 2;
            
                // This needs implementing - UNREAD COMMENTS
//                $query = "SELECT * FROM users WHERE user_role = 'Subscriber'";
//                $select_all_subscribers = mysqli_query($connection,$query);
                $unread_comment_count = 2;
            
            
           
            ?>



            <div class="row">

                <script type="text/javascript">
                    google.charts.load('current', {
                        'packages': ['bar']
                    });
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Data', ''],


                            <?php
                            
                                $element_text = ['All posts', 'Active Posts', 'Draft Posts', 'Comments', 'Unread Comments'];
                                $element_count = [$posts_count, $posts_published_count, $posts_draft_count, $comments_count, $unread_comment_count];
                            
                                for($i = 0;$i < 5;$i++) {
                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
                                    
                                }
                            
                            ?>

                        ]);

                        var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                        };

                        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                        chart.draw(data, google.charts.Bar.convertOptions(options));
                    }
                </script>

                <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

            </div>




        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php";?>