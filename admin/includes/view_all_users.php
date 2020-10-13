<?php

if(isset($_POST['checkboxArray'])){
        
        foreach($_POST['checkboxArray'] as $checkbox_user_id){
            $bulk_options = $_POST['bulk_options'];

            switch($bulk_options){
                case "Admin":
                    
                    $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$checkbox_user_id}";
                    $update_user_admin = mysqli_query($connection,$query);
                    break;
                    
                case "Subscriber":
                    
                    $query = "UPDATE users SET user_role = '{$bulk_options}' WHERE user_id = {$checkbox_user_id}";
                    $update_user_subscriber = mysqli_query($connection,$query);
                    break;
                    
                case "delete":
                    
                    $query = "DELETE FROM users WHERE user_id = {$checkbox_user_id}";
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
                <option value="Admin">Make Admin</option>
                <option value="Subscriber">Make Subscriber</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply" onclick="javascript: return confirm('Are you sure you want to do this? Note: when deleting users - user posts/comments will not be removed');">
            <a href="users.php?source=add_user" class="btn btn-primary">Add New User</a>
        </div>

        <thead>
            <tr>
                <th><input type="checkbox" id="selectAllBoxes"></th>
                <th>ID</th>
                <th>Usernme</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Image</th>
                <th>Role</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr>

                <?php
                                
                $query = 'SELECT * FROM users ';
//                $query .= "ORDER BY comment_status DESC";
                $select_users = mysqli_query($connection,$query);

                while($row = mysqli_fetch_assoc($select_users)){
                    $user_id = $row['user_id'];
                    $user_name = $row['user_name'];
                    $user_password = $row['user_password'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];
                    
    
                    echo "<tr>";
                
                    ?>

                    <td><input type="checkbox" class="checkboxes" name="checkboxArray[]" value="<?php echo $user_id;?>"></td>

                    <?php
                    
                        echo "<td>{$user_id}</td>";
                        echo "<td>{$user_name}</td>";
                        echo "<td>{$user_firstname}</td>";                    
                        echo "<td>{$user_lastname}</td>";

                        echo "<td>{$user_email}</td>";
                        echo "<td><img width='30' src='../images/user_images/{$user_image}' alt='image'</td>";
                        echo "<td>{$user_role}</td>";                    

                        echo "<td><a href='users.php?source=edit_user&user_id={$user_id}'>Edit</a></td>";
                        echo "<td><a onclick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='users.php?delete={$user_id}'>Delete</a></td>";
                            
                    echo "</tr>";
                }


                ?>



                <?php
            
                if(isset($_GET['delete'])){
                    if(isset($_SESSION['user_role'])){
                       if($_SESSION['user_role'] == 'Admin'){
                        
                        $delete_user_id = escape($_GET['delete']);
                           
                        $query = "DELETE FROM users WHERE user_id = {$delete_user_id}";

                        $delete_user_query = mysqli_query($connection,$query);

                        confirmQuery($delete_user_query);

                        header("Location: users.php");
                        }
                    }
                }

                ?>

            </tr>
        </tbody>
    </table>