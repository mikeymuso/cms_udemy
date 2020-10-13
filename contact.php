<!-- Header -->
<?php include 'includes/db.php';?>
<?php include 'includes/header.php';?>
<?php include 'admin/includes/functions.php';?>


<!-- Navigation -->
<?php include 'includes/navigation.php';?>


<?php

    if(isset($_POST['submit'])){
        $to = "mikeyc87@me.com";
        $from = escape($_POST['email']);
        $subject = escape($_POST['subject']);
        $body = escape($_POST['body']);
        $header = "From: " . $from;
        
        
        
        
        
        
        if(!empty($from) && !empty($subject) && !empty($body)){
        
            $body = wordwrap($body, 70);
        
            // Send the email
            mail($to, $subject, $body, $header);
            
            $message = '<h6 class="alert alert-success text-center">Message sent</h6>';
            
        } else {
            
            $message = '<h6 class="alert alert-danger text-center">Please complete all fields</h6>';
            
        }
    } else {
        
        $message = '';
    
    } 

?>




<!-- Page Content -->
<div class="container">


    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="contact.php" method="post" id="contact-form" autocomplete="off">
                            <?php echo $message;?>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Enter email">
                            </div>

                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input class="form-control" type="text" name="subject" id="subject" placeholder="Enter subject">
                            </div>


                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <textarea class="form-control" name="body" id="body" cols="30" rows="7"></textarea>
                            </div>

                            <input class="btn btn-custom btn-lg btn-block" type="submit" name="submit" value="Contact">
                        </form>
                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>
    <!-- /.row -->


    <hr>

    <?php include 'includes/footer.php';?>