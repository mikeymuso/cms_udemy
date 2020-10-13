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

<?php

if(isset($_GET['source'])){   
    $source = escape($_GET['source']);
    
} else {
    
    $source = '';

}
                                      
switch($source){
        case 'view_comments';
            include "includes/post_comments.php";
            break;
        default:
            include "includes/view_all_comments.php";      
    }      
                 
?>





                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php";?>