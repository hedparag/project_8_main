<?php
    //database connection settings

    $host="localhost";
    $port="5432";
    $dbname="employee_db";
    $user="postgres";
    $password="padmin";

    //create a connection
    
    $conn = pg_connect("host=$host  port=$port dbname=$dbname  user=$user  password=$password");

    //check if connection is successful

    if(!$conn){
        die("Connection failed:".pg_last_error());
    }
    else{
        echo "Database connection successful";
    }
?>