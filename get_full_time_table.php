<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);
    function get_full_timetable(){
        require('db.php');
        $conn = connect_db();

        $faculty_id = $_POST['regno'];
        if( ! isset( $faculty_id ) ){
            return 0;
        }

        $t = [ "0", "0", "0", "0", "0" ];
        $subjects = [];

        // get all subjects
        $sql = "SELECT * FROM teaches_at WHERE faculty_id = '$faculty_id'";
        $result = $conn->query( $sql );

        while( $row = $result->fetch_assoc() ){
            array_push( $subjects, $row );
        }

        // get entire time table 
        $sql = "SELECT * FROM timetable";
        $result = $conn->query( $sql );
        // find my hours from that and fill out t
        while( $row = $result->fetch_assoc() ){
            $today = ["0", "0", "0", "0", "0", "0"];
            $branch = $row['branch'];
            $sem = $row['sem'];
            $batch = $row['batch'];
            $weekday = $row['weekday'];
            
            unset( $row['weekday']);
            unset( $row['branch']);
            unset( $row['sem']);
            unset( $row['batch']);

            foreach( $row as $hour=>$sub ){
                if( is_in_subjects( $sub, $subjects )){
                    $h = substr( $hour, -1 );
                    $today[ $h ] = array( 'branch'=>$branch, 'sem'=>$sem, 'batch'=>$batch, 'subject'=>$sub );
                }
            }
            $t[ $weekday ] = $today;
        }
        echo json_encode( $t );

    }
    function is_in_subjects( $subject, $subjects ){
        foreach( $subjects as $sub ){
            if( $sub['subject'] == $subject ){
                return true;
            }
        }
        return false;
    }
    get_full_timetable();
?>