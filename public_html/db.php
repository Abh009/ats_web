<?php

    function connect_db(){
        $host = 'localhost';
        $user = 'test';
        $password = 'testpwd';
        $db_name = 'test';

        $con = mysqli_connect( $host, $user, $password, $db_name );

        if ( mysqli_connect_errno() ){
            return 0;
        }
        return $con;
    }

?>