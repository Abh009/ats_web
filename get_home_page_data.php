<?php
    require("get_students_with_shortage.php");
    require("get_faculty_timetable.php");
    
    $faculty_timetable =  get_faculty_timetable();
    $students_with_shortage = get_students_with_shortage();

    $faculty_timetable['students_with_shortage'] = $students_with_shortage;
    echo json_encode( $faculty_timetable );
?>