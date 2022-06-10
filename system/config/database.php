<?php
if(file_exists(APPPATH . '/config/database.php')){
    require_once APPPATH . '/config/database.php';
}

defined('DB_HOST') || define('DB_HOST', 'localhost');
defined('DB_USER') || define('DB_USER', 'root');
defined('DB_PASSWORD') || define('DB_PASSWORD', 'password');

try{
    define('DB_CONNECTION', mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD));

    if(!DB_CONNECTION){
        exit("Database connection error");
    }
}catch (Throwable $exception){
    exit("Connection to database failed: " . $exception->getMessage());
}