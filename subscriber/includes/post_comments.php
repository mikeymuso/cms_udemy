<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
<!--            <th>In Response to</th>-->
            <th>Date</th>
            <th>Approve</th>
            <th>Disapprove</th>
            <th>Delete</th>

        </tr>
    </thead>
    <tbody>
        <tr>

        <?php

            if(isset($_GET['post_id'])){
                $post_id = escape($_GET['post_id']);

                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                $query .= "ORDER BY comment_status DESC, comment_date DESC";
                $select_comments = mysqli_query($connection,$query);
                
                $rows = mysqli_num_rows($select_comments);
                confirmQuery($select_comments);

                if($rows == 0){
                    echo "<h2 class='alert alert-success'>No comments</h2>";
                } else {
                
                while($row = mysqli_fetch_assoc($select_comments)){
                    $comment_id = $row['comment_id'];
                    $comment_post_id = $row['comment_post_id'];
                    $comment_author = $row['comment_author'];
                    $comment_content = substr($row['comment_content'],0,100) . "...";
                    $comment_email = $row['comment_email'];
                    $comment_status = $row['comment_status'];
                    $comment_date = $row['comment_date'];

                    echo "<tr>";

                    echo "<td>{$comment_id}</td>";
                    echo "<td>{$comment_author}</td>";
                    echo "<td><a href='../post.php?post_id=$comment_post_id'>{$comment_content}</a></td>";


    //                    $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
    //                    
    //                    $select_categories_id = mysqli_query($connection,$query);
    //
    //                    while($row = mysqli_fetch_assoc($select_categories_id)){
    //                    $cat_id = $row['cat_id'];
    //                    $cat_title = $row['cat_title'];
    //                    
    //                    }

                    echo "<td>{$comment_email}</td>";                    
                    echo "<td>{$comment_status}</td>";

//                    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
//                    $select_post = mysqli_query($connection, $query);
//
//                    while($row = mysqli_fetch_assoc($select_post)){
//                        $post_id = $row['post_id'];
//                        $post_title = $row['post_title'];
//                    }
//
//                    echo "<td><a href='../post.php?post_id=$post_id'>{$post_title}</a></td>";                    
                    echo "<td>{$comment_date}</td>";


                    echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
                    echo "<td><a href='comments.php?disapprove=$comment_id'>Disapprove</a></td>";
                    echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";


                    echo "</tr>";
                }


                if(isset($_GET['delete'])){

                    $delete_comment_id = escape($_GET['delete']);
                    $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";

                    $delete_query = mysqli_query($connection,$query);

                    confirmQuery($delete_query);

                    header("Location: comments.php");

                }

                if(isset($_GET['disapprove'])){

                    $disapprove_comment_id = escape($_GET['disapprove']);
                    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$disapprove_comment_id}";

                    $delete_query = mysqli_query($connection,$query);
                    header("Location: comments.php");

                    confirmQuery($delete_query);

                }

                if(isset($_GET['approve'])){

                    $approve_comment_id = escape($_GET['approve']);
                    $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$approve_comment_id}";

                    $delete_query = mysqli_query($connection,$query);
                    header("Location: comments.php");

                    confirmQuery($delete_query);

                }
                }
            }

            ?>

        </tr>
    </tbody>
</table>