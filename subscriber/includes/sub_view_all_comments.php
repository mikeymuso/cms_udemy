<?php

    if(isset($_POST['checkboxArray'])){
        
        foreach($_POST['checkboxArray'] as $checkbox_comment_id){
            $bulk_options = $_POST['bulk_options'];

            switch($bulk_options){
                case "approved":
                    
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$checkbox_comment_id}";
                    $approve_comments = mysqli_query($connection,$query);
                    break;
                    
                case "unapproved":
                    
                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$checkbox_comment_id}";
                    $update_post_to_draft = mysqli_query($connection,$query);
                    break;
                    
                case "delete":
                    
                    $query = "DELETE FROM comments WHERE comment_id = {$checkbox_comment_id}";
                    $bulk_delete = mysqli_query($connection,$query);
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
                <option disabled value="approved">Mark as read</option>
                <option disabled value="unapproved">Delete</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply" onclick="javascript: return confirm('No function yet');">
        </div>

        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Status</th>
                <!--            <th>In Response to</th>-->
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Delete</th>

            </tr>
        </thead>
        <tbody>
            <tr>

                <?php
                
                if(isset($_SESSION['user_id'])){
                    $user_id = $_SESSION['user_id'];
                }
                                
                $query = "SELECT * FROM comments WHERE comment_author_id = $user_id";
                $query .= " ORDER BY comment_status DESC, comment_date DESC";
                $select_comments = mysqli_query($connection,$query);
                
                if(!mysqli_num_rows($select_comments) == 0) {      
                
                    while($row = mysqli_fetch_assoc($select_comments)){
                        $comment_id = $row['comment_id'];
                        $comment_post_id = $row['comment_post_id'];
                        $comment_author = $row['comment_author'];
                        $comment_author_id = $row['comment_author_id'];

                        $comment_content = substr($row['comment_content'],0,100) . "...";
                        $comment_status = $row['comment_status'];
                        $comment_date = $row['comment_date'];

                        echo "<tr>";

                    ?>

                <td><input type="checkbox" class="checkboxes" name="checkboxArray[]" value="<?php echo $comment_id;?>"></td>

                <?php

                        echo "<td>{$comment_id}</td>";
                        echo "<td>{$comment_author}</td>";

                        echo "<td><a href='../post.php?post_id=$comment_post_id'>{$comment_content}</a></td>";



                        if($comment_status == 'approved'){
                            echo '<td><i class="fa fa-check" style="color:#8FBC8F;"></i></td>';
                        } else {
                            echo '<td><i class="fa fa-times" style="color:#8B0000;"></i></td>';
                        }

                        $query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                        $select_post = mysqli_query($connection, $query);
                  
                        echo "<td>{$comment_date}</td>";


                        echo "<td><a href='comments.php?approve=$comment_id'>Approve</a></td>";
                        echo "<td><a href='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
                        echo "<td><a href='comments.php?delete=$comment_id'>Delete</a></td>";


                        
                    }
                    
                    echo "</tr></tbody></table>";
                    // End of table 
                    
                } else {
                        echo "</tr></tbody></table><div class='alert alert-info'>No comments</div>";
                }
                

            
                
                
                
                if(isset($_GET['delete'])){
                    
                    $delete_comment_id = escape($_GET['delete']);
                    $query = "DELETE FROM comments WHERE comment_id = {$delete_comment_id}";
                    
                    $delete_query = mysqli_query($connection,$query);
                    
                    confirmQuery($delete_query);
                    
                    header("Location: comments.php");
                    
                }
            
                if(isset($_GET['unapprove'])){
                    
                    $disapprove_comment_id = escape($_GET['unapprove']);
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

                ?>

