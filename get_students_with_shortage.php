<?php
    require('db.php');
    $con = connect_db();

    // get faculty id
    $faculty_id = $_POST['faculty_id'];

    // get all the attendance records of this faculty
    $sql = "SELECT * FROM attendance WHERE faculty_id = '$faculty_id' ";
    $result = $con->query( $sql );

    $students_with_shortage = array();
    while( $row = $result->fetch_assoc() ){
        $student = array();
        $student_id = $row['student_id'];
        
        $sql = "SELECT * FROM student WHERE admno = '$student_id'";
        $result = $con->query( $sql );
        $student_details = $result->fetch_assoc();

        $student['student_id'] = $student_id;
        $student['name'] = $student_details['name'];
        $student['email'] = $student_details['email'];
        $student['branch'] = $student_details['branch'];
        $student['sem'] = $student_details['sem'];
        $student['batch'] = $student_details['batch'];
        $student['attended'] = ;
    }
?>