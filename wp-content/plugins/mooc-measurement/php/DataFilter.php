<?php

//Función que filtra los datos leídos de la base de datos para que los valores vayan de 0 a 1 
//para poder mostrarlos correctamente en la gráfica comparativa. 
//Tiene en cuenta diferentes criterios dependiendo del indicador que se va a filtrar
function filter($data) {

    $filteredDataArray = array();
    //Número de cursos de los que contiene datos el array
    $massive = array();
    $open = array();
    $online = array();
    $course = array();
    $cursos = array();
    $massive_numeros = array();
    $open_numeros = array();
    $online_numeros = array();
    $course_numeros = array();
    $filteredMassive = array();
    $filteredOpen = array();
    $filteredOnline = array();
    $filteredCourse = array();

    //Guardo los datos en array separados para trabajar con ellos
    foreach ($data as $key => $value) {
        array_push($cursos, $key);
        foreach ($value as $type => $datas) {
            switch ($type) {
                case "MASSIVE":
                    $massive[$key] = $datas;
                    break;
                case "OPEN":
                    $open[$key] = $datas;
                    break;
                case "ONLINE":
                    $online[$key] = $datas;
                    break;
                case "COURSE":
                    $course[$key] = $datas;
                    break;
                case "MASSIVE_numeros":
                    $massive_numeros[$key] = $datas;
                    break;
                case "OPEN_numeros":
                    $open_numeros[$key] = $datas;
                    break;
                case "ONLINE_numeros":
                    $online_numeros[$key] = $datas;
                    break;
                case "COURSE_numeros":
                    $course_numeros[$key] = $datas;
                    break;
            }
        }
    }

    foreach ($massive as $key => $array) {
        $temporal = array();
        foreach ($array as $indicator => $value) {
            $filteredData = $value;
            switch ($indicator) {
                /* case 'Certificates by apprentice track':
                  $total = $array['Number of certificates'];
                  $filteredData = $value / $total;

                  break;
                  case 'Certificates by studio practicum':
                  $total = $array['Number of certificates'];
                  $filteredData = $value / $total;

                  break;
                  case 'Certificates by studio track':
                  $total = $array['Number of certificates'];
                  $filteredData = $value / $total;

                  break;
                  case 'Number of certificates':
                  $max=0;
                  for ($i = 0; $i < count($cursos); $i++) {
                  $tempMassive = $massive[$cursos[$i]];
                  if ($tempMassive[$indicator] > $max) {
                  $max = $tempMassive[$indicator];
                  }
                  }
                  $filteredData = $value / $max;

                  break;
                  case 'Number of official certificates':
                  $max=0;
                  for ($i = 0; $i < count($cursos); $i++) {
                  $tempMassive = $massive[$cursos[$i]];
                  if ($tempMassive[$indicator] > $max) {
                  $max = $tempMassive[$indicator];
                  }
                  }
                  $filteredData = $value / $max;

                  break;
                  case 'Participants active the entire course':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants active the first and second weeks':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants active the first three weeks':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants active the first week':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants completed':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants not started':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants registered at the beginning':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants registered from the second week':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants who accessed to less than a half of the materials':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants who accessed to more than a half of the materials':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants with all the tasks':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants with good mark':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break;
                  case 'Participants with mandatory tasks':
                  $total = $array['Total participants'];
                  $filteredData = $value / $total;

                  break; */
                case 'Posts published by participants':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempMassive = $massive[$cursos[$i]];
                            if ($tempMassive[$indicator] > $max) {
                                $max = $tempMassive[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }

                    break;
                case 'Total participants':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempMassive = $massive[$cursos[$i]];
                            if ($tempMassive[$indicator] > $max) {
                                $max = $tempMassive[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }

                    break;
            }
            $temporal[$indicator] = $filteredData;
        }
        $filteredMassive[$key] = $temporal;
    }

    foreach ($open as $key => $array) {
        $temporal = array();
        foreach ($array as $indicator => $value) {
            $filteredData = $value;
            /* switch ($indicator) {
              case 'Percentage of open resources':
              $array2 = $course[$key];
              $total = $array2['Total resources'];
              $filteredData = $value / $total;
              break;
              case 'Percentage of tasks with deadline':
              $array2 = $course[$key];
              $total = $array2['Total number of tasks'];
              $filteredData = 100 - ($value / $total * 100);
              break;
              } */
            $temporal[$indicator] = $filteredData;
        }
        $filteredOpen[$key] = $temporal;
    }

    foreach ($online as $key => $array) {
        $temporal = array();
        foreach ($array as $indicator => $value) {
            $filteredData = $value;
            /* switch ($indicator) {
              case 'Percentage of online resources':
              $array2 = $course[$key];
              $total = $array2['Total resources'];
              $filteredData = $value / $total;
              break;
              case 'Percentage of online tasks':
              $array2 = $course[$key];
              $total = $array2['Total number of tasks'];
              $filteredData = $value / $total;
              break;
              case 'Percentage of online videos':
              $array2 = $course[$key];
              $total = $array2['Total number of videos'];
              $filteredData = $value / $total;
              break;
              } */
            $temporal[$indicator] = $filteredData;
        }
        $filteredOnline[$key] = $temporal;
    }

    foreach ($course as $key => $array) {
        $temporal = array();
        foreach ($array as $indicator => $value) {
            $filteredData = $value;
            switch ($indicator) {
                case 'Average length of videos':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempCourse = $course[$cursos[$i]];
                            if ($tempCourse[$indicator] > $max) {
                                $max = $tempCourse[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }

                    break;
                case 'Length of the course':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempCourse = $course[$cursos[$i]];
                            if ($tempCourse[$indicator] > $max) {
                                $max = $tempCourse[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }
                    break;
                case 'Number videos by week':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempCourse = $course[$cursos[$i]];
                            if ($tempCourse[$indicator] > $max) {
                                $max = $tempCourse[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }
                    break; /*
                  case 'Required tasks':
                  $max=0;
                  for ($i = 0; $i < count($cursos); $i++) {
                  $tempCourse = $course[$cursos[$i]];
                  if ($tempCourse[$indicator] > $max) {
                  $max = $tempCourse[$indicator];
                  }
                  }
                  $filteredData = $value / $max;
                  break; */
                case 'Number of tasks':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempCourse = $course[$cursos[$i]];
                            if ($tempCourse[$indicator] > $max) {
                                $max = $tempCourse[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }
                    break;
                case 'Number of videos':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempCourse = $course[$cursos[$i]];
                            if ($tempCourse[$indicator] > $max) {
                                $max = $tempCourse[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }
                    break;
                case 'Number of resources':
                    if ($value != '') {
                        $max = 0;
                        for ($i = 0; $i < count($cursos); $i++) {
                            $tempCourse = $course[$cursos[$i]];
                            if ($tempCourse[$indicator] > $max) {
                                $max = $tempCourse[$indicator];
                            }
                        }
                        $filteredData = $value / $max;
                    } else {
                        $filteredData = $value;
                    }
                    break;
            }
            $temporal[$indicator] = $filteredData;
        }
        $filteredCourse[$key] = $temporal;
    }

    for ($i = 0; $i < count($cursos); $i++) {
        //$filteredDataArray[$key] = array();

        if (isset($filteredMassive[$cursos[$i]])) {
            $filteredDataArray[$cursos[$i]]['MASSIVE'] = $filteredMassive[$cursos[$i]];
            $filteredDataArray[$cursos[$i]]['MASSIVE_numeros'] = $massive_numeros[$cursos[$i]];
        }
        if (isset($filteredOpen[$cursos[$i]])) {
            $filteredDataArray[$cursos[$i]]['OPEN'] = $filteredOpen[$cursos[$i]];
            $filteredDataArray[$cursos[$i]]['OPEN_numeros'] = $open_numeros[$cursos[$i]];
        }
        if (isset($filteredOnline[$cursos[$i]])) {
            $filteredDataArray[$cursos[$i]]['ONLINE'] = $filteredOnline[$cursos[$i]];
            $filteredDataArray[$cursos[$i]]['ONLINE_numeros'] = $online_numeros[$cursos[$i]];
        }
        if (isset($filteredCourse[$cursos[$i]])) {
            $filteredDataArray[$cursos[$i]]['COURSE'] = $filteredCourse[$cursos[$i]];
            $filteredDataArray[$cursos[$i]]['COURSE_numeros'] = $course_numeros[$cursos[$i]];
        }
    }
    return $filteredDataArray;
}
