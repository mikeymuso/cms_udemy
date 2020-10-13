<div class="col-md-4">

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- search form -->
    </div>


    <!-- Loginh Well -->
    <div class="well">

        <?php
    
    if(isset($_SESSION['user_role'])){
        $user_name = escape($_SESSION['user_name']);
    ?>

        <form action="index.php" method="post">
            <div>
                <h4>Logged in as: <?php echo $user_name;?></h4>
                <a href="includes/logout.php" class="btn btn-primary">Log Out</a>
            </div>
        </form>
    </div>

    <?php
        
    } else {
        
    ?>

    <h4>Login</h4>
    <form action="includes/login.php" method="post">
        <div class="form-group">
            <input name="user_name" type="text" class="form-control" placeholder="Enter username">
        </div>

        <div class="input-group">
            <input name="user_password" type="password" class="form-control" placeholder="Enter password">
            <span class="input-group-btn">
                <button class="btn btn-primary" name="login" type="submit">Login</button>
            </span>
        </div>
    </form>
    <!-- Login form -->
</div>

<?php
    
    }
        
        ?>

<!-- Blog Categories Well -->
<div class="well">
    <h4>Blog Categories</h4>
    <div class="row">
        <div class="col-lg-6">
            <ul class="list-unstyled">

                <?php 
                    
                    $query = 'SELECT * FROM categories';
                    $select_all_categories = mysqli_query($connection,$query);
                    
                    while($row = mysqli_fetch_assoc($select_all_categories)){
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        
                        echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }
                    
                ?>

            </ul>
        </div>
    </div>
    <!-- /.row -->
</div>

<!-- Side Widget Well -->
<div class="well">
    <h4>Side Widget Well</h4>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
</div>

</div>