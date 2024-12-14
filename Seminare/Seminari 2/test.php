<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "test";


$db_conn = mysqli_connect($host, $username, $password, $database);

if (!$db_conn){
    echo "Error ne lidhjen me databazen";
}


$query_insert = "INSERT INTO users SET
                   name = '".$_POST['name']."',
                   surname = '".$_POST['surname']."',
                   email = '".$_POST['email']."',
                   password = '".password_hash($_POST['password'], PASSWORD_DEFAULT)."',
                   created_at ='".date("Y-m-d H:i:s")."'
                  ";

$result_insert = mysqli_query($db_conn, $query_insert);

if (!$result_insert){
    echo "error";
} else {
    echo "<h1>Data saved successfully</h1>";
}


