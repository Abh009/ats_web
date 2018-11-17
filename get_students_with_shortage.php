<?php
    require('db.php');
    $con = connect_db();

    // get faculty id
    $faculty_id = $_POST['faculty_id'];

    if( ! isset( $faculty_id ) ){
        echo json_encode( array('status'=>0, 'text'=>'Invalid Request'));
        exit();
    }

    // get all the attendance records of this faculty
    $sql = "SELECT * FROM attendance WHERE faculty_id = '$faculty_id' ";
    $result = $con->query( $sql );

    $students_with_shortage = array();
    while( $row = $result->fetch_assoc() ){
        $student = array();
        $student_id = $row['student_id'];

        $sql = "SELECT * FROM student s JOIN total_attendance t ON s.admno = t.student_id WHERE s.admno = '$student_id'";
        
        // $sql = "SELECT * FROM student WHERE admno = '$student_id'";
        $result = $con->query( $sql );
        $student_details = $result->fetch_assoc();

        $attended = $student_details['attended'];
        $total = $student_details['total'];
        $percentage = $attended / $total * 100;

        if( $percentage >= 75 ){
            continue;
        }

        $sql = "SELECT * FROM teaches_at WHERE ";
        // TODO

        $student['student_id'] = $student_id;
        $student['name'] = $student_details['name'];
        $student['email'] = $student_details['email'];
        $student['branch'] = $student_details['branch'];
        $student['sem'] = $student_details['sem'];
        $student['batch'] = $student_details['batch'];
        $student['attended'] = $student_details['attended'];
        $student['total'] = $student_details['total'];

        array_push( $students_with_shortage, $student );
    }
    
    echo json_encode( $students_with_shortage );

?>