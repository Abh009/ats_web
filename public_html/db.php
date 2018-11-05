<?php

    function connect_db(){
        $host = 'mysql';
        $user = 'root';
        $pass = 'rootpassword';
        $db_name = 'ats';
        $conn = new mysqli($host, $user, $pass);

        if ($conn->connect_error) {
            return 0;
        } 
        return $conn;
    }

?>