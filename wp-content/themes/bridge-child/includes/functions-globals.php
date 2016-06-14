<?php
global $class_types;

$programs = get_field('programs_description', 'option');
$class_types = array(/*'Amazing Athletes', 'Amazing Tots', 'Amazing Warriors'*/);

foreach($programs as $program){
    $class_types[$program['program']] = $program['program'];
}

?>