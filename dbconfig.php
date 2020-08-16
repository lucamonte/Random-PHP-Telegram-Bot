<?php

define('DB_SERVER', 'your_db_host');
define('DB_USERNAME', 'your_db_username');
define('DB_PASSWORD', 'your_db_password');
define('DB_NAME', 'your_db_name');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($link === false){
    die("ERRORE: Impossibile connettersi al database. " . mysqli_connect_error());
}

?>