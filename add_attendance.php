<?php
    
    require('db.php');
    $con = connect_db();

    if( !isset( $_POST['faculty_id'], $_POST['absentees'])){
        echo json_encode( array( 'status'=>0, 'text'=>'Invalid Request'));
        exit();
    }

    $faculty_id = $_POST['faculty_id'];
    $absentees_list = $_POST['absentees'] ;

    echo $absentees_list;
?>