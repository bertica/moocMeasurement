<?php

require_once('../../../../wp-load.php');
include_once('DataFilter.php');
//Variable para trabajar con la base de datos
$wpdb = $GLOBALS['wpdb'];
//Obtengo el número de datos que se envían desde el formulario 
// y guardo los nombres y valores en arrays para poder recorrerlos después
$numero = count($_POST);
$indicators = array_keys($_POST);
$values = array_values($_POST);

//Voy a ver cuántos cursos voy a tener que comparar
$c = 0;
$cursos = array();
$colores = array();
if (isset($_POST['mooc1']) && $_POST['mooc1'] !== '') {
    $c++;
    array_push($cursos, $_POST['mooc1']);
    array_push($colores,0);
}
if (isset($_POST['mooc2']) && $_POST['mooc2'] !== '') {
    $c++;
    array_push($cursos, $_POST['mooc2']);
    array_push($colores,1);
}
if (isset($_POST['mooc3']) && $_POST['mooc3'] !== '') {
    $c++;
    array_push($cursos, $_POST['mooc3']);
    array_push($colores,2);
}
if (isset($_POST['mooc4']) && $_POST['mooc4'] !== '') {
    $c++;
    array_push($cursos, $_POST['mooc4']);
    array_push($colores,3);
}

//Ahora voy a preparar los datos de cada uno de estos cursos 
$datosArray = array();
for ($j = 0; $j < $c; $j++) {
    //Preparo la consulta para buscar los datos que se piden en la base de datos
    $query = "select m.name, i_order, indicator, value, idI_GROUP"
            . " from " . $wpdb->prefix . "MOOC m join " . $wpdb->prefix . "MOOC_INDICATOR mi on (m.idMOOC=mi.MOOC) "
            . "join " . $wpdb->prefix . "INDICATOR i on (mi.indicator=i.name) join " . $wpdb->prefix . "INDICATOR_GROUP ig "
            . "on (i.id_group=ig.idI_GROUP) where idMOOC = %d and (";
    $idMOOC = $cursos[$j];
    $in = 0;
    for ($i = 0; $i < $numero; $i++) {
        if ($values[$i] === 'on') {
            if ($in === 0) {
                $query.= ' indicator like "' . $indicators[$i] . '" ';
                $in++;
            } else {
                $query.= ' or indicator like "' . $indicators[$i] . '" ';
            }
        }
    }
    $query.=") order by idI_GROUP,i_order";

    $preparedQuery = $wpdb->prepare($query, $idMOOC);
    $resultado = $wpdb->get_results($preparedQuery);
    $criterios = array();
    $numeroCriterio = array();
    $gruposArray = array();
    $grupo = '';
    foreach ($resultado as $fila) {
        if ($grupo === $fila->idI_GROUP) {
            $criterios[$fila->indicator] = $fila->value;
            array_push($numeroCriterio, $fila->i_order);
        }
        if ($grupo !== $fila->idI_GROUP) {
            if (count($criterios) !== 0) {
                $gruposArray[$grupo] = $criterios;
                $gruposArray[$grupo . "_numeros"] = $numeroCriterio;
            }
            $criterios = array();
            $numeroCriterio = array();
            $criterios[$fila->indicator] = $fila->value;
            array_push($numeroCriterio, $fila->i_order);
        }
        $grupo = $fila->idI_GROUP;
    }
    $gruposArray[$grupo] = $criterios;
    $gruposArray[$grupo . "_numeros"] = $numeroCriterio;
    $datosArray[$fila->name] = $gruposArray;
}
$filtered = filter($datosArray);
$filtered['colores'] = $colores;
echo json_encode($filtered);
?>