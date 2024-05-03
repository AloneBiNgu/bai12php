<?php
    $host_name = 'localhost';
    $username = 'root';
    $password = '';
    $db_name = 'news';
    $connect = mysqli_connect($host_name, $username, $password, $db_name);
    if (!$connect) {
        return $connect->error();
    }

    return $connect;
?>