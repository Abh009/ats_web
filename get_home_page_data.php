<?php
    $faculty_timetable =  get_faculty_timetable();
    echo "1";
    $students_with_shortage = get_students_with_shortage();
    echo "2";

    $faculty_timetable['students_with_shortage'] = $students_with_shortage;
    echo json_encode( $faculty_timetable );
?>