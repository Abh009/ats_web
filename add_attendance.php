<?php
    
    require('db.php');
    $con = connect_db();

    if( !isset( $_POST['faculty_id'], $_POST['absentees'])){
        echo json_encode( array( 'status'=>0, 'text'=>'Invalid Request'));
        exit();
    }

    $faculty_id = $_POST['faculty_id'];
    $branch = $_POST['branch'];
    $sem = $_POST['sem'];
    $batch = $_POST['batch'];
    $absentees_list = $_POST['absentees'] ;

    // get subject
    $sql = "SELECT * FROM teaches_at WHERE faculty_id = '$faculty_id' and batch = '$batch' and sem = '$sem' and batch = '$batch'";
    $result = $con->query( $sql );

    $row = $result->fetch_assoc();
    $subject = $row['subject'];

    // get student list
    $students = explode( " ", $absentees_list );
    print_r( $students);

    foreach( $students as $student ){
        // get the student id
        $sql = "SELECT * FROM student WHERE branch = '$batch' and sem = '$sem' and batch = '$batch' and rollno = $student ";
        $result = $con->query( $sql );
        $student_id = $result->fetch_assoc()['admno'];

        // mark the attendance
        $sql = "INSERT INTO attendance VALUES( '$student_id', CURRENT_DATE(), 0, '$subject' )";
        $result = $con->query( $sql );
    }

    echo json_encode( array( 'status'=>1 ));
?>