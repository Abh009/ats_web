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

    foreach( $students as $student ){
        // get the student id
        $sql = "SELECT * FROM student WHERE branch = '$branch' and sem = '$sem' and batch = '$batch' and rollno = $student ";
        $result = $con->query( $sql );
        $row = $result->fetch_assoc();
        $student_id = $row['admno'];

        // mark the attendance
        $sql = "INSERT INTO attendance VALUES( '$student_id', CURRENT_DATE(), 0, '$subject', '$faculty_id' )";
        $result = $con->query( $sql );

        // update total also
        // get current
        $sql = "SELECT * FROM total_attendance WHERE student_id = '$student_id' and $subject = '$subject'";
        $result = $con->query( $sql );

        $attended = 1;
        $total = 1;
        $sql = "INSERT INTO total_attendance VALUES('$student_id', $attended, $total, '$subject', '$faculty_id')";
        if( $result->num_rows > 0 )
        {
            $row = $result->fetch_assoc();
            $attended = $row['attended'] + 1;
            $total = $row['total'] + 1;
            $sql = "UPDATE total_attendance SET attended = $attended, total = $total WHERE student_id = '$student_id' and subject = '$subject'";
        }

        // update or insert
        $result = $con->query( $sql );

    }

    echo json_encode( array( 'status'=>1 ));
?>