<?php
    require("get_students_with_shortage.php");
    require("get_faculty_timetable.php");

    echo "1";
    $faculty_timetable =  get_faculty_timetable();
    echo "2";
    $students_with_shortage = get_students_with_shortage();
    echo "3";

    $faculty_timetable['students_with_shortage'] = $students_with_shortage;
    echo json_encode( $faculty_timetable );
?>