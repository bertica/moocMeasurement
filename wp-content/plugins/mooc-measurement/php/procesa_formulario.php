<?php

require_once('../../../../wp-load.php');
//Variable para trabajar con la base de datos
//global $wpdb;
$wpdb = $GLOBALS['wpdb'];


//Recojo los datos del formulario
$datosArray = array(
    'name' => $_POST['name'],
    'year' => $_POST['year'],
    'description' => $_POST['description'],
    'topic' => $_POST['topic'], //no está
    'start_date' => $_POST['start_date'],
    'end_date' => $_POST['end_date'],
    'Length of the course' => $_POST['duration'],
    'Total participants' => $_POST['total_p'],
    'Participants completed' => $_POST['total_completed'],
    'Participants not started' => $_POST['not_started'],
    'Number of tasks' => $_POST['total_tasks'],
    'Number of required tasks' => $_POST['required_tasks'],
    "Number of tasks with deadline" => $_POST['deadline_tasks'],
    'Automatic assesments' => $_POST['automatic_assesment'],
    'Based on authority assesments' => $_POST['authority_assesment'],
    'Social interaction assesments' => $_POST['social_assesment'],
    'Final certificate' => $_POST['final_certificate'],
    'Official final certificate' => $_POST['official_final_certificate'],
    'Number of videos' => $_POST['video_total'],
    'Number of resources' => $_POST['reference_material_total'],
    'Download' => $_POST['license_download'],
    'Copy' => $_POST['license_copy'],
    'Distribute' => $_POST['license_distribute'],
    'Display' => $_POST['license_display'],
    'Perform' => $_POST['license_perform'],
    'Make derivative work' => $_POST['license_derivative'],
    'None' => $_POST['license_none'],
    'Participants registered at the beginning' => $_POST['participants_beginning'],
    'Participants registered from the second week' => $_POST['participants_second_week'],
    'Participants with mandatory tasks' => $_POST['participants_tasks_mandatory'],
    'Participants with all the tasks' => $_POST['participants_all_tasks'],
    'Participants with good mark' => $_POST['participants_good_marks'],
    'Number of certificates' => $_POST['number_certificates'],
    'Number of official certificates' => $_POST['number_official_certificates'],
    'Certificates by apprentice track' => $_POST['certificates_apprentice'],
    'Certificates by studio track' => $_POST['certificates_studio_track'],
    'Certificates by studio practicum' => $_POST['certificates_practicum'],
    'Participants active the entire course' => $_POST['participants_active_entire_course'],
    'Participants active the first week' => $_POST['active_first_week'],
    'Participants active the first and second weeks' => $_POST['participants_active_first_second'],
    'Participants active the first three weeks' => $_POST['active_three_weeks'],
    'Participants who accessed to less than a half of the materials' => $_POST['participants_less_materials'],
    'Participants who accessed to more than a half of the materials' => $_POST['participants_more_materials'],
    'Posts published by participants' => $_POST['posts_published'],
    'Number videos by week' => $_POST['number_videos_week'],
    'Average length of videos' => $_POST['average_length_videos'],
    'Use of social networks' => $_POST['social'],
    'Use of forum' => $_POST['forum'],
    'Use of blog' => $_POST['blog'],
    'Use of RSS' => $_POST['rss'],
    'Is the official certificate free?' => $_POST['official_certificate_price'],
    'Has the MOOC a guide?' => $_POST['guide'],
    'Is the MOOC free?' => $_POST['gratis'],
    'Number of online tasks' => $_POST['online_tasks'],
    'Number of online resources' => $_POST['material_online'],
    'Number of online videos' => $_POST['video_online'],
    'Free platform?' => $_POST['license_platform']
);


//Compruebo si hay que insertar plataforma o institución que imparte el curso antes de nada
if (isset($_POST['new_platform']) && $_POST['new_platform'] !== '') {
    $queryRepeated = "select count(*) as num from " . $wpdb->prefix . "INDICATOR_POSIBLE_VALUES where indicator like 'Platform' "
            . "and value like " . $_POST['new_platform'];
    $results = $wpdb->get_results($queryRepeated);
    $num = 0;
    foreach ($results as $fila) {
        if ($fila->num !== '0') {
            $num = 1;
        }
    }
    if ($num !== 1) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR_POSIBLE_VALUES', array("indicator" => 'Platform', "value" => $_POST['new_platform'], "description" => $_POST['new_platform']));
    }
    $datosArray['Platform'] = $_POST['new_platform'];
} else {
    $datosArray['Platform'] = $_POST['platform'];
}

if (isset($_POST['new_institution']) && $_POST['new_institution'] !== '') {
    $queryRepeated = "select count(*) as num from " . $wpdb->prefix . "INDICATOR_POSIBLE_VALUES where indicator like 'Institution' "
            . "and value like '" . $_POST['new_institution'] . "'";
    $results = $wpdb->get_results($queryRepeated);
    $num = 0;
    foreach ($results as $fila) {
        if ($fila->num !== '0') {
            $num = 1;
        }
    }
    if ($num !== 1) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR_POSIBLE_VALUES', array("indicator" => 'Institution', "value" => $_POST['new_institution'], "description" => $_POST['new_institution']));
    }
    $datosArray['Institution'] = $_POST['new_institution'];
} else {
    $datosArray['Institution'] = $_POST['institution'];
}

if (isset($_POST['start_date']) && $_POST['start_date'] != "") {
    $datosArray['no_date'] = 0;
} else {
    $datosArray['no_date'] = 1;
}

$open_resources = 0;
if ($datosArray['None'] === 'false') {
    if ($datosArray['Download'] === 'true') {
        $open_resources++;
    }
    if ($datosArray['Copy'] === 'true') {
        $open_resources++;
    }
    if ($datosArray['Distribute'] === 'true') {
        $open_resources++;
    }
    if ($datosArray['Display'] === 'true') {
        $open_resources++;
    }
    if ($datosArray['Perform'] === 'true') {
        $open_resources++;
    }
    if ($datosArray['Make derivative work'] === 'true') {
        $open_resources++;
    }
}else{
    $datosArray['License of resources'] = $open_resources / 6;
}
$datosArray['License of resources'] = $open_resources / 6;

if ($datosArray['Number of certificates'] > 0) {
    $datosArray['Percentage of certificates by apprentice track'] = ($datosArray['Certificates by apprentice track']!='' ? $datosArray['Certificates by apprentice track'] / $datosArray['Number of certificates'] : '');
    $datosArray['Percentage of certificates by studio practicum'] = ($datosArray['Certificates by studio practicum']!='' ? $datosArray['Certificates by studio practicum'] / $datosArray['Number of certificates'] : '');
    $datosArray['Percentage of certificates by studio track'] = ($datosArray['Certificates by studio track'] !='' ? $datosArray['Certificates by studio track'] / $datosArray['Number of certificates'] : '');
}
$datosArray['Certificates issued/Total participants'] = ($datosArray['Number of certificates']!='' ? $datosArray['Number of certificates'] / $datosArray['Total participants'] : '');
$datosArray['Official certificates issued/Total participants'] = ($datosArray['Number of official certificates']!='' ? $datosArray['Number of official certificates'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of online resources'] = ($datosArray['Number of online resources'] !='' ? $datosArray['Number of online resources'] / $datosArray['Number of resources'] : '');
$datosArray['Percentage of online tasks'] = ($datosArray['Number of online tasks'] !='' ? $datosArray['Number of online tasks'] / $datosArray['Number of tasks'] : '');
$datosArray['Percentage of online videos'] = ($datosArray['Number of online videos']!='' ? $datosArray['Number of online videos'] / $datosArray['Number of videos'] : '');
$datosArray['Percentage of participants active first three weeks'] = ($datosArray['Participants active the first three weeks'] !='' ? $datosArray['Participants active the first three weeks'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants active the entire course'] = ($datosArray['Participants active the entire course']!= '' ? $datosArray['Participants active the entire course'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants active the first and second week'] = ($datosArray['Participants active the first and second week']!='' ? $datosArray['Participants active the first and second week'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants active the first week'] = ($datosArray['Participants active the first week']!='' ? $datosArray['Participants active the first week'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants registered at the beginning'] = ($datosArray['Participants registered at the beginning']!='' ? $datosArray['Participants registered at the beginning'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants registered from the second week'] = ($datosArray['Participants registered from the second week']!='' ? $datosArray['Participants registered from the second week'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants who accessed to less than a half of the resources'] = ($datosArray['Participants who accessed to less than a half of the resources']!='' ? $datosArray['Participants who accessed to less than a half of the resources'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants who accessed to more than a half of the resources'] = ($datosArray['Participants who accessed to more than a half of the resources']!='' ? $datosArray['Participants who accessed to more than a half of the resources'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants who completed the course'] = ($datosArray['Participants completed']!='' ? $datosArray['Participants completed'] / $datosArray['Total participants'] : '');
$datosArray["Percentage of participants who didn't start the course"] = ($datosArray['Participants not started'] !='' ? $datosArray['Participants not started'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants with all the tasks completed'] = ($datosArray['Participants with all the tasks']!='' ? $datosArray['Participants with all the tasks'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants with mandatory tasks completed'] = ($datosArray['Participants with mandatory tasks'] !='' ? $datosArray['Participants with mandatory tasks'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of participants with mark>=8.5'] = ($datosArray['Participants with good mark']!='' ? $datosArray['Participants with good mark'] / $datosArray['Total participants'] : '');
$datosArray['Percentage of required tasks'] = ($datosArray['Number of required tasks']!='' ? $datosArray['Number of required tasks'] / $datosArray['Number of tasks'] : '');
$datosArray['Percentage of tasks without deadline'] = ($datosArray['Number of tasks with deadline']!=''? 1 - $datosArray['Number of tasks with deadline'] / $datosArray['Number of tasks'] : '');
$type_assesments = 0;
if ($datosArray['Automatic assesments'] === 'true') {
    $type_assesments++;
}
if ($datosArray['Based on authority assesments'] === 'true') {
    $type_assesments++;
}
if ($datosArray['Social interaction assesments'] === 'true') {
    $type_assesments++;
}
$datosArray['Type of assesments'] = ($type_assesment!=0 ? $type_assesments / 3 : '');
if ($datosArray['Is the MOOC free?'] === "yes") {
    $datosArray['Is the MOOC free?'] = 1;
}
if ($datosArray['Is the MOOC free?'] === "no") {
    $datosArray['Is the MOOC free?'] = 0;
}
if ($datosArray['Is the official certificate free?'] === "free") {
    $datosArray['Is the official certificate free?'] = 1;
}
if ($datosArray['Is the official certificate free?'] === "payment") {
    $datosArray['Is the official certificate free?'] = 0;
}
if ($datosArray['Free platform?'] === "yes") {
    $datosArray['Free platform?'] = 1;
}
if ($datosArray['Free platform?'] === "no") {
    $datosArray['Free platform?'] = 0;
}
if ($datosArray['Has the MOOC a guide?'] === "yes") {
    $datosArray['Has the MOOC a guide?'] = 1;
}
if ($datosArray['Has the MOOC a guide?'] === "no") {
    $datosArray['Has the MOOC a guide?'] = 0;
}
if (isset($datosArray['Average length of videos']) && $datosArray['Average length of videos']!=='') {
    $length = split($datosArray['Average length of videos'], ':');
    $minutes = (float) $length[3] / 60 + (float) $length + (float) $length * 60;
    $datosArray['Average length of videos'] = $minutes;
}


$wpdb->show_errors();
//Ahora insertamos los datos en la Base de Datos
$ok = $wpdb->insert($wpdb->prefix . 'MOOC', array("name" => $datosArray['name'], "description" => $datosArray['description'], /* "topic_idtopic"=>$datosArray['topic'], */ "start" => $datosArray['start_date'], "end" => $datosArray['end_date'], "no_date" => $datosArray['no_date'], "year_of_tuition" => $datosArray['year']));
if (!$ok) {
    //Lanzar excepción
    $error1 = $wpdb->print_error();
}
unset($datosArray['name']);
unset($datosArray['description']);
unset($datosArray['topic']);
unset($datosArray['start_date']);
unset($datosArray['end_date']);
unset($datosArray['no_date']);
unset($datosArray['year']);
//Obtengo el id generado por el insert para poder asociarle los indicadores
$lastid = $wpdb->insert_id;
foreach ($datosArray as $indicador => $valor) {
    if (isset($valor) /*&& $valor != ''*/) {
        //$ok = $wpdb -> insert($wpdb->prefix.'MOOC_INDICATOR',array("mooc"=>$lastid,"indicator"=>$indicador,"value"=>$valor));
        $ok = $wpdb->insert($wpdb->prefix . 'MOOC_INDICATOR', array("mooc" => $lastid, "indicator" => $indicador, "value" => $valor));
        if (!$ok) {
            //Lanzar excepción
            $error2 .= $wpdb->print_error();
        }
    }
}
echo "error1:" . $error1 . " --- error2:" . $error2;
?>