<?php

// 1st and most secure way
$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_password'] = '';
$db['db_name'] = 'cms';

foreach($db as $key => $value){
    define(strtoupper($key), $value);
}


// 3rd Way to connect to database
$connection = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);


//if($connection){
//echo "We are connected";
//} else {
//echo "We are NOT connected";
//}

?>
