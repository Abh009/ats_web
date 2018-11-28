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

        $sql = "SELECT * FROM teaches_at WHERE faculty_id = '$faculty_id'";
        $result = $conn->query( $sql );

        $subjects = array();
        while( $row = $result->fetch_assoc() ){
            array_push( $subjects, array( 'branch'=>$row['branch'], 'batch'=>$row['batch'], 'sem'=>$row['sem'], 'subject'=>$row['subject']) );
        }

        $sql = "SELECT * FROM timetable";
        $result = $conn->query( $sql );

        $full_timetable = array("0", "0", "0", "0", "0" );

        $weekday = 0;
        while( $row = $result->fetch_assoc() ){
            $day = array( "0", "0", "0", "0", "0", "0" );
            // removing unwanted fields
            unset( $timetable['branch']);
            unset( $timetable['batch']);
            unset( $timetable['sem']);
            unset( $timetable['weekday']);
            // now only hour_1, hour_2, ....
            foreach( $subjects as $subject ){
                $x = is_subject_on_this_day( $row, $subject );
                if( ! $x ){
                    continue;
                }
                for( $i = 0; $i < count( $x ); $i++ ){
                    $h = $x[ $i ];
                    $day[ $h ] = $subject;
                }
            }
            $full_timetable[ $weekday ] = $day;
            $weekday += 1;
        }

        echo json_encode( $full_timetable );
    }

    function is_subject_on_this_day( $day, $subject ){
        $hours = array();
        foreach( $day as $hour=>$sub ){
            if( $sub == $subject ){
                $h = substr( $hour, -1 );
                array_push( $hours, $h );
            }
        }
        return $hours;
    }
    get_full_timetable();
?>