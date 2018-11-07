<?php

require( 'db.php' );

$con = connect_db();

if( ! isset( $_POST['regno'] ) ){
    echo json_encode( array( 'status'=>0, 'text'=>'Invalid request'));
    exit();
}

$regno = $_POST['regno'];

// get those classess he teaches at
$sql = "SELECT * FROM teaches_at WHERE faculty_id = '$regno'";
$result = $con->query( $sql );

if( $result->num_rows <= 0 ){
    echo json_encode( array( 'status'=>0, 'text'=>'No Classes found', 'batches'=> array() ));
}

$batches = array();
while( $row = $result->fetch_assoc() ){
    $d = array();
    $d['branch'] = $row['branch'];
    $d['sem'] = $row['sem'];
    $d['batch'] = $row['batch'];
    $d['subject'] = $row['subject'];
    
    array_push( $batches, $d );
}

echo json_encode( array( 'status'=>1, 'batches'=> $batches ));

?>