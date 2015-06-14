<?php
/*
  Plugin Name: Mooc Measurement
  Plugin URI: https://github.com/bertica/moocMeasurement
  Description: A plugin that allows measure different MOOCs
  Version: 1.0
  Author: Berta Besteiro
 */

global $mocmeas_db_version;
$mocmeas_db_version = '1.0';

function mooc_measuremet_tool_install() {
    global $wpdb;
    global $mocmeas_db_version;

    $charset_collate = $wpdb->get_charset_collate();

    $table_name = $wpdb->prefix . 'INDICATOR_GROUP';
    $sql = "CREATE TABLE $table_name (
		idI_GROUP varchar(20) PRIMARY KEY,
		description varchar(150) NOT NULL
	) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);

    $table_name = $wpdb->prefix . 'INDICATOR';
    $sql = "CREATE TABLE $table_name (
		name varchar(100) PRIMARY KEY,
                description varchar(150),
                id_group varchar(20),
                i_order int,
                clickable boolean,
                foreign key (id_group) references " . $wpdb->prefix . "INDICATOR_GROUP (idI_GROUP),
                constraint " . $table_name . "_unique unique key(i_order,id_group,clickable) 
	) $charset_collate;";

    dbDelta($sql);
    /*
      $table_name = $wpdb->prefix . 'TOPIC';
      $sql = "CREATE TABLE $table_name (
      idTOPIC int PRIMARY KEY AUTO_INCREMENT,
      name varchar(100) NOT NULL
      ) $charset_collate;";

      dbDelta( $sql );
     */
    $table_name = $wpdb->prefix . 'MOOC';
    $sql = "CREATE TABLE $table_name (
		idMOOC int PRIMARY KEY AUTO_INCREMENT,
		name varchar(100) NOT NULL,
                description varchar(150),
                year_of_tuition char(4),
                start date,
                end date,
                no_date boolean                
	) $charset_collate;";
    /* se ha quitado de momento las columnas --topic_idtopic int, level int, -- y las claves ajenas a nivel y a topic que aún no sé si ponerlos --
      foreign key (level) references ".$wpdb->prefix."LEVEL(idLevel), foreign key (topic_idtopic) references ".$wpdb->prefix."TOPIC(idTOPIC) */
    dbDelta($sql);
    /*
      $table_name = $wpdb->prefix . 'LEVEL';
      $sql = "CREATE TABLE $table_name (
      idLevel int PRIMARY KEY AUTO_INCREMENT,
      name varchar(100) NOT NULL
      ) $charset_collate;";

      dbDelta( $sql );

      $levels = array ("not indicated","pre-secondary","secondary","pre-university","university","master","doctoral");

      $table_name = $wpdb->prefix . 'MOOC_LEVEL';
      $sql = "CREATE TABLE $table_name (
      idLevel int ,
      MOOC int,
      primary key (idLevel,MOOC),
      foreign key (idLevel) references ".$wpdb->prefix."LEVEL(idLevel),
      foreign key (MOOC) references ".$wpdb->prefix."MOOC(idMOOC)
      ) $charset_collate;";

      dbDelta( $sql );
     */
    $table_name = $wpdb->prefix . 'INDICATOR_POSIBLE_VALUES';
    $sql = "CREATE TABLE $table_name (
		indicator varchar(100),
		value varchar(150),
        description varchar(150),
        primary key (indicator,value),
        foreign key (indicator) references " . $wpdb->prefix . "INDICATOR(name)
	) $charset_collate;";

    dbDelta($sql);

    $table_name = $wpdb->prefix . 'MOOC_INDICATOR';
    $sql = "CREATE TABLE $table_name (
		indicator varchar(100),
		MOOC int,
                value varchar(50),
        primary key (indicator,MOOC),
        foreign key (indicator) references " . $wpdb->prefix . "INDICATOR(name),
        foreign key (MOOC) references " . $wpdb->prefix . "MOOC(idMOOC)
	)$charset_collate;";

    dbDelta($sql);

    add_option('mocmeas_db_version', $mocmeas_db_version);

    //Insert the indicators by default in the plugin starting by indicator groups
    $wpdb->insert($wpdb->prefix . 'INDICATOR_GROUP', array("idI_GROUP" => "MASSIVE", "description" => "The massive dimension of MOOC"));
    $wpdb->insert($wpdb->prefix . 'INDICATOR_GROUP', array("idI_GROUP" => "OPEN", "description" => "The open dimension of MOOC"));
    $wpdb->insert($wpdb->prefix . 'INDICATOR_GROUP', array("idI_GROUP" => "ONLINE", "description" => "The online dimension of MOOC"));
    $wpdb->insert($wpdb->prefix . 'INDICATOR_GROUP', array("idI_GROUP" => "COURSE", "description" => "The course dimension of MOOC"));

    //The massive ones
    $massiveArrayQ = array(
        "Total participants" => "Total number of participants",
        "Percentage of participants who completed the course" => "Percentage of participants who completed the course",
        "Percentage of participants who didn't start the course" => "Percentage of participants who didn't start the course",
        "Certificates issued/Total participants" => "Relationship between certificates issued and participants",
        "Percentage of certificates by apprentice track" => "Certificates issued by completing readings and tests",
        "Percentage of certificates by studio track" => "Certificates issued by completing readings, tests and peer assessment tasks",
        "Percentage of certificates by studio practicum" => "The same as studio track but participants with another edition of the MOOC completed",
        "Official certificates issued/Total participants" => "Relationship between official certificates issued and participants",
        "Percentage of participants registered at the beginning" => "Percentage of participants registered at the beginning",
        "Percentage of participants registered from the second week" => "Percentage of participants registered from the second week in advanced",
        "Percentage of participants with mandatory tasks completed" => "Percentage of participants who completed all mandatory tasks",
        "Percentage of participants with all the tasks completed" => "Percentage of participants who completed all the tasks, included not mandatory ones",
        "Percentage of participants with mark>=8.5" => "Participants who have passed the MOOC with 8.5 points or more",
        "Percentage of participants active the entire course" => "Percentage of participants who have been active the entire course",
        "Percentage of participants active the first week" => "Percentage of participants who were active the first week",
        "Percentage of participants active the first and second week" => "Percentage of participants who were active the first and second weeks",
        "Percentage of participants active first three weeks" => "Percentage of participants who were active the first three weeks",
        "Percentage of participants who accessed to less than a half of the resources" => "Participants who accessed to less than half of the materials",
        "Percentage of participants who accessed to more than a half of the resources" => "Participants who accessed to more than half of the materials",
        "Posts published by participants" => "Quantity of posts published by participants"
    );

    $massiveArrayNQ = array(
        "Participants completed" => "Number of participants who have completed the course",
        "Participants not started" => "Number of participants who haven't started the course",
        "Number of certificates" => "Number of certificates issued at the end of the MOOC",
        "Certificates by apprentice track" => "Certificates issued by completing readings and tests",
        "Certificates by studio track" => "Certificates issued by completing readings, tests and peer assessment tasks",
        "Certificates by studio practicum" => "The same as studio track but participants with another edition of the MOOC completed",
        "Number of official certificates" => "Number of official certificates issued at the end of the MOOC",
        "Participants registered at the beginning" => "Number of participants registered at the beginning oft he MOOC",
        "Participants registered from the second week" => "Number of participants registered from the second week in advanced",
        "Participants with mandatory tasks" => "Participants who have completed all mandatory tasks",
        "Participants with all the tasks" => "Participants who have completed all the tasks, included not mandatory ones",
        "Participants with good mark" => "Participants who have passed the MOOC with 8.5 points or more",
        "Participants active the entire course" => "Participants who have been active the entire course",
        "Participants active the first week" => "Participants who have been active the first week",
        "Participants active the first and second weeks" => "Participants who have been active the first and second weeks",
        "Participants active the first three weeks" => "Participants who have been active the first three weeks",
        "Participants who accessed to less than a half of the materials" => "Participants who have accessed to less than half of the materials",
        "Participants who accessed to more than a half of the materials" => "Participants who have accessed to more than half of the materials"
    );
    $order = 1;
    foreach ($massiveArrayQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "MASSIVE", "clickable" => true, "i_order" => $order));
        $order++;
    }
    $order = 1;
    foreach ($massiveArrayNQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "MASSIVE", "clickable" => false, "i_order" => $order));
        $order++;
    }

    //The open ones
    $openArrayQ = array(
        "Is the official certificate free?" => "If the final official certificate is free",
        "License of resources" => "What people can do with materials of the course",
        "Percentage of tasks without deadline" => "Percentage of tasks that has deadline to be completed",
        "Is the MOOC free?" => "If the MOOC is free/gratis or not"
    );
    $openArrayNQ = array(
        "Download" => "Participants can download material of the MOOC",
        "Copy" => "Participants can copy material of the MOOC",
        "Distribute" => "Participants can distribute material of the MOOC",
        "Display" => "Participants can display material of the MOOC",
        "Perform" => "Participants can perform material of the MOOC",
        "Make derivative work" => "Participants can make derivative work material of the MOOC",
        "None" => "Participants haven't any right over material of the MOOC",
        "Number of required tasks" => "Number of required tasks",
        "Number of tasks with deadline" => "Number of tasks with deadline",
        "Free platform?" => "License of the plaform in which MOOC is"
    );
    $order = 1;
    foreach ($openArrayQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "OPEN", "clickable" => true, "i_order" => $order));
        $order++;
    }
    $order = 1;
    foreach ($openArrayNQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "OPEN", "clickable" => false, "i_order" => $order));
        $order++;
    }

    //The online ones
    $onlineArrayQ = array(
        "Percentage of online videos" => "Percentage of videos which are online",
        "Percentage of online resources" => "Percentage of resources online",
        "Percentage of online tasks" => "Percentage of online tasks in the MOOC"
    );
    $onlineArrayNQ = array(
        "Number of online videos" => "Number of videos which are online",
        "Number of online resources" => "Number of resources online",
        "Number of online tasks" => "Number of online tasks in the MOOC"
    );
    $order = 1;
    foreach ($onlineArrayQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "ONLINE", "clickable" => true, "i_order" => $order));
        $order++;
    }
    $order = 1;
    foreach ($onlineArrayNQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "ONLINE", "clickable" => false, "i_order" => $order));
        $order++;
    }

    //The course ones
    $courseArrayQ = array(
        "Length of the course" => "Length of the course in weeks",
        "Number videos by week" => "Number of videos by week (average)",
        "Percentage of required tasks" => "Percentage of required tasks the MOOC has",
        "Number of tasks" => "Total number tasks the MOOC has",
        "Number of videos" => "Total videos in the MOOC",
        "Number of resources" => "Total resources the MOOc has",
        "Average length of videos" => "Average length of videos",
        "Type of assesments" => "Type of assesments in the MOOC",
        "Has the MOOC a guide?" => "Has the MOOC a guide?"
    );
    $courseArrayNQ = array(
        "Platform" => "Platform of the MOOC",
        "Institution" => "Institution of the MOOC",
        "Social interaction assesments" => "MOOC used social assesments to evaluate the MOOC",
        "Based on authority assesments" => "MOOC used based on authority assesments to evaluate the MOOC",
        "Automatic assesments" => "MOOC used automatic assesments to evaluate the MOOC",
        "Final certificate" => "If the MOOC issues a final certificate",
        "Official final certificate" => "If the MOOC issues an official final certificate",
        "Use of social networks" => "If the MOOC makes use of social networks",
        "Use of forum" => "If the MOOC makes use of forum",
        "Use of blog" => "If the MOOC makes use of blog",
        "Use of RSS" => "If the MOOC makes use of RSS"
    );
    $order = 1;
    foreach ($courseArrayQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "COURSE", "clickable" => true, "i_order" => $order));
        $order++;
    }
    $order = 1;
    foreach ($courseArrayNQ as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR', array("name" => $nombre, "description" => $description, "id_group" => "COURSE", "clickable" => false, "i_order" => $order));
        $order++;
    }

    $indicatorPlatformValues = array(
        "Udacity" => "Platform Udacity",
        "Coursera" => "Platform Coursera",
        "Edx" => "Platform Edx",
        "Miriada X" => "Platform Miriada X"
    );
    $indicatorInstitutionValues = array(
        "University of Rochester" => "University of Rochester",
        "University of Zurich" => "University of Zurich",
        "Universidad de Columbia" => "Universidad de Columbia",
        "ESSEC" => "ESSEC",
        "Wesleyan University" => "Wesleyan University",
        "Copenhagen Business School" => "Copenhagen Business School",
        "Tecnológido de Monterrey" => "Tecnológido de Monterrey",
        "Technische Universität München" => "Technische Universität München",
        "Johns Hopkins University" => "Johns Hopkins University",
        "Vanderbilt University" => "Vanderbilt University",
        "Tel Aviv University" => "Tel Aviv University",
        "Icahn School of Medicine at Mount Sinai" => "Icahn School of Medicine at Mount Sinai",
        "Northwestern University" => "Northwestern University",
        "The University of Melbourne" => "The University of Melbourne",
        "The University of Tokyo" => "The University of Tokyo",
        "University of California, San Francisco" => "University of California, San Francisco",
        "Universidad Nacional Autónoma de México" => "Universidad Nacional Autónoma de México",
        "Caltech" => "Caltech",
        "University of Toronto" => "University of Toronto",
        "University of London" => "University of London",
        "University of Pennsylvania" => "University of Pennsylvania",
        "University of California, Santa Cruz" => "University of California, Santa Cruz",
        "University of Lausanne" => "University of Lausanne",
        "University of Florida" => "University of Florida",
        "Xi'an Jiaotong University" => "Xi'an Jiaotong University",
        "Korea Advanced Institute of Science and Technology" => "Korea Advanced Institute of Science and Technology",
        "University of Michigan" => "University of Michigan",
        "Saint Petersburg State University" => "Saint Petersburg State University",
        "University of Colorado System" => "University of Colorado System",
        "University of Minnesota" => "University of Minnesota",
        "Exploratorium" => "Exploratorium",
        "Commonwealth Education Trust" => "Commonwealth Education Trust",
        "Technion - Israel Institute of Technology" => "Technion - Israel Institute of Technology",
        "University of Virginia" => "University of Virginia",
        "University of Western Australia" => "University of Western Australia",
        "National Taiwan University" => "National Taiwan University",
        "Lund University" => "Lund University",
        "Shanghai Jiao Tong University" => "Shanghai Jiao Tong University",
        "Emory University" => "Emory University",
        "UNED" => "UNED",
        "Fundación Albéniz" => "Fundación Albéniz",
        "Universitat de Girona" => "Universitat de Girona",
        "Universidad de Huelva" => "Universidad de Huelva",
        "Universidad de Ibagué" => "Universidad de Ibagué",
        "Universidad Pompeu Fabra" => "Universidad Pompeu Fabra",
        "Universidad Rey Juan Carlos" => "Universidad Rey Juan Carlos",
        "Universidad de Murcia" => "Universidad de Murcia",
        "UNNE" => "UNNE",
        "Universidad Politécnica de Cartagena" => "Universidad Politécnica de Cartagena",
        "Universidad Tecnológica Nacional" => "Universidad Tecnológica Nacional",
        "Universidad de Málaga" => "Universidad de Málaga",
        "Universitat Oberta de Catalunya" => "Universitat Oberta de Catalunya",
        "Universidad de Cantabria" => "Universidad de Cantabria",
        "Universidad de San Martin de Porres" => "Universidad de San Martin de Porres",
        "Universidad Tecnológica de Pereira" => "Universidad Tecnológica de Pereira",
        "Universidad de Alicante" => "Universidad de Alicante",
        "Universidade Nova de Lisboa" => "Universidade Nova de Lisboa",
        "Universidad Blas Pascal" => "Universidad Blas Pascal",
        "Universidad San Pablo" => "CEU Universidad San Pablo",
        "Universidad de La Laguna" => "Universidad de La Laguna",
        "Universidad de Alcalá" => "Universidad de Alcalá",
        "Universidad Autónoma de Occidente" => "Universidad Autónoma de Occidente",
        "Universidad Cardenal Herrera" => "Universidad Cardenal Herrera",
        "Telefónica" => "Telefónica",
        "National University College" => "National University College",
        "Universitat de les illes Balears" => "Universitat de les illes Balears",
        "Universidad del País Vasco" => "Universidad del País Vasco",
        "Universidad Católica Santo Toribio de Mogrovejo" => "Universidad Católica Santo Toribio de Mogrovejo",
        "Universidad Complutense de Madrid" => "Universidad Complutense de Madrid",
        "Universidad Carlos III de Madrid" => "Universidad Carlos III de Madrid",
        "Universidad de Palermo" => "Universidad de Palermo",
        "Universidad Nacional de Quilmes" => "Universidad Nacional de Quilmes",
        "Universidad Ricardo Palma" => "Universidad Ricardo Palma",
        "Universidad de Castilla-La Mancha" => "Universidad de Castilla-La Mancha",
        "Universidad de Zaragoza" => "Universidad de Zaragoza",
        "Universidad Europea" => "Universidad Europea",
        "Universidad Católica de Murcia" => "Universidad Católica de Murcia",
        "Universidad de Navarra" => "Universidad de Navarra",
        "Universitat politècnica de València" => "Universitat politècnica de València",
        "Universidad politécnica de Madrid" => "Universidad politécnica de Madrid",
        "Universidad Pontifica de Salamanca" => "Universidad Pontifica de Salamanca",
        "Universitat Abat Oliba CEU" => "Universitat Abat Oliba CEU",
        "Universidad de Salamanca" => "Universidad de Salamanca"
    );

    foreach ($indicatorPlatformValues as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR_POSIBLE_VALUES', array("indicator" => 'Platform', "value" => $nombre, "description" => $description));
    }
    foreach ($indicatorInstitutionValues as $nombre => $description) {
        $wpdb->insert($wpdb->prefix . 'INDICATOR_POSIBLE_VALUES', array("indicator" => 'Institution', "value" => $nombre, "description" => $description));
    }
    //$topics = array("Mathematics","Game","Web","Learning");
}

register_activation_hook(__FILE__, 'mooc_measuremet_tool_install');

function mooc_measurement() {
    add_menu_page('MOOC Measurement', 'MOOC MEASUREMENT', 'manage_options', 'MOOC-Measurement', 'mooc_measurement_tool', '', 26);
}

add_action('admin_menu', 'mooc_measurement');

//interfaz de comparación/medición de MOOCs
function mooc_measurement_tool() {
    global $moocmeas_load_css;

    // set this to true so the CSS is loaded
    $moocmeas_load_css = true;
    $wpdb = $GLOBALS['wpdb'];
    ?>
    <div id="project_ini">
        <div id="moocmeasurement_comparation" class="wrap muestra">
            <h3 class="mooc_title">MOOC MEASUREMENT</h3>
            <form id="send_comparation">
                <div class="col-sm-8">
                    <p>Comparation: select between 1 and 4 courses</p>

                    <div id="comparation_form" class="caja">
                        <div id="selectores" class="col-sm-8">
                            <img src="../wp-content/plugins/mooc-measurement/img/azul.png" class="col-sm-1"/>
                            <select class="col-sm-5" id="mooc1" name="mooc1">
                                <option value=''>Select one...</option>
                                <?php
                                /* Aquí habrá que hacer que se carguen los select con los MOOC de la BD */
                                $consulta = "select idMOOC,name from " . $wpdb->prefix . "MOOC";
                                $mooc = $wpdb->get_results($consulta);
                                foreach ($mooc as $fila) {
                                    ?>
                                    <option value='<?php echo $fila->idMOOC; ?>'><?php echo $fila->name; ?></option>
                                <?php }
                                ?>

                            </select>
                            <img src="../wp-content/plugins/mooc-measurement/img/rojo.png" class="col-sm-1"/>
                            <select class="col-sm-5" id="mooc2" name="mooc2">
                                <option value=''>Select one...</option>
                                <?php
                                /* Aquí habrá que hacer que se carguen los select con los MOOC de la BD */
                                foreach ($mooc as $fila) {
                                    ?>
                                    <option value='<?php echo $fila->idMOOC; ?>'><?php echo $fila->name; ?></option>
                                <?php } ?>
                            </select>
                            <div class="clearfix"></div>
                            <img src="../wp-content/plugins/mooc-measurement/img/verde.png" class="col-sm-1"/>
                            <select class="col-sm-5" id="mooc3" name="mooc3">
                                <option value=''>Select one...</option>
                                <?php
                                /* Aquí habrá que hacer que se carguen los select con los MOOC de la BD */
                                foreach ($mooc as $fila) {
                                    ?>
                                    <option value='<?php echo $fila->idMOOC; ?>'><?php echo $fila->name; ?></option>
                                <?php } ?>
                            </select>
                            <img src="../wp-content/plugins/mooc-measurement/img/amarillo.png" class="col-sm-1"/>
                            <select class="col-sm-5" id="mooc4" name="mooc4">
                                <option value=''>Select one...</option>
                                <?php
                                /* Aquí habrá que hacer que se carguen los select con los MOOC de la BD */
                                foreach ($mooc as $fila) {
                                    ?>
                                    <option value='<?php echo $fila->idMOOC; ?>'><?php echo $fila->name; ?></option>
                                <?php }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2" id="type">
                            <input type="radio" name="type" id="basic" value="basic">Basic<br/>
                            <input type="radio" name="type" id="intermediate" value="intermediate">Intermediate<br/>
                            <input type="radio" name="type" id="high" value="high">High<br/>
                        </div>
                        <div id="compare" class="col-sm-1">
                            
                        </div>
                    </div>
                    <!--</form>-->
                    <div id="newmooc" class="col-sm-5 col-sm-offset-4">
                        <a>To introduce a new MOOC click here</a>
                    </div>
                    <div id="miCanvas" class="" ></div>
                </div>
                <div class="col-sm-4" id="criterios">
                    <h4>Massive</h4>
                    <div id="massive" class="caja criterios">
                        <?php
                        /* mediante un for para cada criterio de medición "massive" saca un checkbox */
                        $consulta = "select i_order,name,description from " . $wpdb->prefix . "INDICATOR where id_group like 'massive' and clickable=1 order by i_order";
                        $massive = $wpdb->get_results($consulta);
                        //$n=1;
                        foreach ($massive as $fila) {
                            ?><div>
                                <span><?php echo $fila->i_order; ?></span><input type='checkbox' name="<?php echo $fila->name; ?>" id="<?php echo $fila->name; ?>"/>
                                <span for="<?php echo $fila->name; ?>" title="<?php echo $fila->description; ?>"><?php echo $fila->name; ?></span></div>
                        <?php }
                        ?>
                        <input type="hidden" name="total_massive" value="0"/>
                    </div>
                    <h4>Open</h4>
                    <div id="open" class="caja criterios">
                        <?php
                        /* mediante un for para cada criterio de medición "open" sacar un checkbox */
                        $consulta = "select i_order,name,description from " . $wpdb->prefix . "INDICATOR where id_group like 'open' and clickable=1 order by i_order";
                        $open = $wpdb->get_results($consulta);
                        foreach ($open as $fila) {
                            ?><div>
                                <span><?php echo $fila->i_order; ?><input type='checkbox' name="<?php echo $fila->name; ?>" id="<?php echo $fila->name; ?>"/>
                                    <span for="<?php echo $fila->name; ?>" title="<?php echo $fila->description; ?>"><?php echo $fila->name; ?></span></div>
                        <?php }
                        ?>
                        <input type="hidden" name="total_open" value="0"/>
                    </div>
                    <h4>Online</h4>
                    <div id="online" class="caja criterios">
                        <?php
                        /* mediante un for para cada criterio de medición "online" sacar un checkbox */
                        $consulta = "select i_order,name,description from " . $wpdb->prefix . "INDICATOR where id_group like 'online' and clickable=1 order by i_order";
                        $online = $wpdb->get_results($consulta);
                        foreach ($online as $fila) {
                            ?><div>
                                <span><?php echo $fila->i_order; ?><input type='checkbox' name="<?php echo $fila->name; ?>" id="<?php echo $fila->name; ?>"/>
                                    <span for="<?php echo $fila->name; ?>" title="<?php echo $fila->description; ?>"><?php echo $fila->name; ?></span></div>
                        <?php }
                        ?>
                        <input type="hidden" name="total_online" value="0"/>
                    </div>
                    <h4>Course</h4>
                    <div id="course" class="caja criterios">
                        <?php
                        /* mediante un for para cada criterio de medición "course" sacar un checkbox */
                        $consulta = "select i_order,name,description from " . $wpdb->prefix . "INDICATOR where id_group like 'course' and clickable=1 order by i_order";
                        $course = $wpdb->get_results($consulta);
                        foreach ($course as $fila) {
                            ?><div>
                                <span><?php echo $fila->i_order; ?><input type='checkbox' name="<?php echo $fila->name; ?>" id="<?php echo $fila->name; ?>"/>
                                    <span for="<?php echo $fila->name; ?>" title="<?php echo $fila->description; ?>"><?php echo $fila->name; ?></span></div>
                        <?php }
                        ?>
                        <input type="hidden" name="total_course" value="0"/>
                    </div>
                </div>
            </form>
        </div>
        <!-- Formulario de inserción de MOOC -->
        <div id="moocmeasurement_newmooc" class='wrap oculto'>
            <form id="mooc_measurement_form" class="form-horizontal" action="" method="POST">
                <h3 class="mooc_title">MOOC MEASUREMENT</h3>
                <div class="col-sm-12">
                    <div id="errorBox" class="col-sm-12"></div>
                    <div id="error" class="col-sm-12 oculto"></div>
                    <h4 class="col-sm-3">BASIC INFORMATION</h4>
                    <div class="col-sm-8 dcha" id="button_home">
                        <button type="button" class="btn btn-primary">BACK TO HOMEPAGE</button>
                    </div>
                </div>
                <hr class="col-sm-11"/>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="name" class="col-sm-1">Name: </label>
                    <div class="col-sm-3"><input type="text" id="name" name="name" class="ancho_total"/></div> 
                    <label for="year" class="col-sm-2 dcha">Year of tuition: </label>
                    <div class="col-sm-1">
                        <select class="ancho_total" id="year" name="year"/>
                        <option>Select one...</option>
                        <?php
                        $hoy = getdate();
                        $año = $hoy['year'];
                        for ($i = 2010; $i <= $año; $i++) {
                            echo "<option value='" . $i . "'>" . $i . "</option>";
                        }
                        ?>
                        </select>
                    </div>                            
                </div>
                <div class="form-group">
                    <div class="clearfix"></div>
                    <label for="start_date" class="col-sm-1">Start: </label>
                    <div class="col-sm-2"><input type="date" name="start_date" id="start_date" class="ancho_total"/></div>
                    <label for="end_date" class="col-sm-1">End: </label>
                    <div class="col-sm-2"><input type="date" name="end_date" id="end_date" class=""/></div>
                    <label for="duration" class="col-sm-2">Duration (weeks): </label>
                    <div class="col-sm-1"><input type="text" name="duration" id="duration" class="ancho_total"/></div>               
                    <div class="clearfix"></div>
                    <div class="col-sm-3 col-sm-offset-2">
                        <div class="col-sm-1 col-sm-offset-1"><input type="checkbox" name="no_date" id="no_date" class=""/></div>
                        <label for="no_date" class="col-sm-7 izda">It has no date </label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="description" class="col-sm-1">Description</label>
                    <textarea id="description" name="description" class="col-sm-4"></textarea>
                    <!--<label for="topic" class="col-sm-1">Topic:</label>
                    <select name="topic" id="topic">
                        <option>Rellenar con temas</option>
                    </select>-->
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-5 moocmeas">
                    <label for="total_p" class="col-sm-7">Total participants: </label>
                    <div class="col-sm-3"><input type="text" name="total_p" id="total_p" class="ancho_total"/></div>
                    <label for="" class="col-sm-7">Participants who have completed: </label>
                    <div class="col-sm-3"><input type="text" name="total_completed" id="total_completed" class="ancho_total"/></div>
                    <label for="not_started" class="col-sm-7">Participants who haven't started: </label> 
                    <div class="col-sm-3"><input type="text" id="not_started" name="not_started" class="ancho_total"/></div>
                </div>

                <div class="clearfix"></div>

                <div class="form-group">
                    <label for="platform" class="col-sm-1">Platform: </label>
                    <div class="col-sm-2"><select name="platform" id="platform" class="ancho_total">
                            <option>Select one...</option>
                            <option value="include"><b>Include new platform</b></option>
                            <?php
                            /* mediante un for para cada criterio de medición "massive" saca un checkbox */
                            $consulta = "select indicator,value,description from " . $wpdb->prefix . "INDICATOR_POSIBLE_VALUES where indicator like 'Platform' order by value";
                            $platform = $wpdb->get_results($consulta);
                            //$n=1;
                            foreach ($platform as $fila) {
                                ?><option value="<?php echo $fila->value ?>"><?php echo $fila->value ?></option>
                            <?php }
                            ?>
                        </select></div>
                        <!--<div class="col-sm-2"><input type="text" name="platform" id="platform" class="ancho_total" /></div>-->
                    <label for="license_platform" class="col-sm-offset-1 col-sm-4">Is the plaform implemented in a free license?</label>
                    <div class="col-sm-4" id="license_platform_group">
                        <div ><input type="radio" id="license_platform" name="license_platform" value="yes"></div>
                        <div><label>Yes</label></div>
                        <div ><input type="radio" id="license_platform" name="license_platform" value="no"></div>
                        <div><label>No</label></div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="div_new_platform" class="oculto">
                        <label for="new_platform" class="col-sm-2 dcha">New platform: </label>
                        <div class="col-sm-4"><input type="text" name="new_platform" id="new_platform" class="ancho_total" /></div>
                    </div>
                    <div class="clearfix"></div>
                    <label for="institution" class="col-sm-1">Institution: </label>
                    <div class="col-sm-2"><select name="institution" id="institution" class="ancho_total">
                            <option>Select one...</option>
                            <option value="include">Include new institution</option>
                            <?php
                            /* mediante un for para cada criterio de medición "massive" saca un checkbox */
                            $consulta = "select indicator,value,description from " . $wpdb->prefix . "INDICATOR_POSIBLE_VALUES where indicator like 'Institution' order by value";
                            $institutions = $wpdb->get_results($consulta);
                            //$n=1;
                            foreach ($institutions as $fila) {
                                ?><option value="<?php echo $fila->value ?>"><?php echo $fila->value ?></option>
                            <?php }
                            ?>
                        </select></div>
                        <!--<div class="col-sm-2"><input type="text" name="institution" id="institution" class="ancho_total" /></div>-->
                    <div class="clearfix"></div>
                    <div id="div_new_institution" class="oculto">
                        <label for="new_institution" class="col-sm-2 dcha">New institution: </label>
                        <div class="col-sm-4"><input type="text" name="new_institution" id="new_institution" class="ancho_total" /></div>
                    </div>

                </div>
                <div class="clearfix"></div>
                <div class="form-group">
                    <label for="final_certificate" class="col-sm-2">Final certificate?</label>
                    <div class="col-sm-4" id="final_certificate_group">
                        <div ><input type="radio" id="final_certificate" name="final_certificate" value="yes"></div>
                        <div><label>Yes</label></div>
                        <div ><input type="radio" id="final_certificate" name="final_certificate" value="no"></div>
                        <div><label>No</label></div>
                    </div>
                    <label for="number_certificates" class="col-sm-3">Number of certificates issued: </label>
                    <div class="col-sm-2"><input type="number" class="ancho_total" name="number_certificates" id="number_certificates"></div>
                </div>
                <div class="form-group">
                    <label for="official_final_certificate" class="col-sm-2">Official final certificate?</label>
                    <div class="col-sm-4" id="official_final_certificate_group">
                        <div><input type="radio" id="official_final_certificate" name="official_final_certificate" value="yes"></div>
                        <div><label>Yes</label></div>
                        <div> <input type="radio" id="official_final_certificate" name="official_final_certificate" value="no"></div>
                        <div><label>No</label></div>
                    </div>
                    <label for="number_official_certificates" class="col-sm-3">Number of official certificates issued: </label>
                    <div class="col-sm-2"><input type="number" class="ancho_total" name="number_official_certificates" id="number_official_certificates"></div>
                </div>
                <div class="form-group">
                    <label for="number_videos_week" class="col-sm-3">Number of videos/week:</label>
                    <input type="text" name="number_videos_week" id="number_videos_week" class="ancho_total col-sm-1">
                    <div class="clearfix"></div>
                    <label for="video_online" class="col-sm-3">Number of video/audio lectures online:</label>
                    <input class="col-sm-1" type="number" name="video_online" id="video_online" required>
                    <label for="video_total" class="col-sm-3 dcha">Total number of video/audio lectures:</label>
                    <input class="col-sm-1 ancho_total" type="number" name="video_total" id="video_total" required>
                    <div class="clearfix"></div>
                    <label for="material_online" class="col-sm-3">Number of resources online:</label>
                    <input class="col-sm-1" type="number" name="material_online" id="material_online" required>
                    <label for="reference_material_total" class="col-sm-3 dcha">Total number of resources:</label>
                    <input class="col-sm-1 ancho_total" type="number" name="reference_material_total" id="reference_material_total" required>
                    <div class="clearfix"></div>
                    <label for="deadline_tasks" class="col-sm-3">Number of tasks with deadline:</label>
                    <input type="text" name="deadline_tasks" id="deadline_tasks" class="col-sm-1">
                    <label for="online_tasks" class="col-sm-3 dcha">Number of online tasks:</label>
                    <input type="text" name="online_tasks" id="online_tasks" class="col-sm-1 ancho_total">
                    <div class="clearfix"></div>
                    <label for="required_tasks" class="col-sm-3">Number of required tasks to complete course: </label> 
                    <div class="second_line"><input type="text" name="required_tasks" id="required_tasks" class="ancho_total col-sm-1" ></div>
                    <label for="total_tasks" class="col-sm-3">Total number of tasks (required ones and not): </label> 
                    <div class="second_line"><input type="text" name="total_tasks" id="total_tasks" class="ancho_total col-sm-1"></div>
                </div>

                <div class="clearfix"></div>
                <div class="form-group col-sm-12" id="license_material">
                    <label>What can participants do with materials from the course?</label><br/>
                    <div><input class="license_group" type="checkbox" id="license_download" name="license_download"></div>
                    <div><label for="license_download">Download</label></div>
                    <div ><input class="license_group" type="checkbox" id="license_copy" name="license_copy"></div>
                    <div><label for="license_copy">Copy</label></div>
                    <div><input class="license_group" type="checkbox" id="license_distribute" name="license_distribute"></div>
                    <div><label for="license_distribute">Distribute</label></div>
                    <div ><input class="license_group" type="checkbox" id="license_display" name="license_display"></div>
                    <div><label for="license_display" >Display</label></div>
                    <div ><input class="license_group" type="checkbox" id="license_perform" name="license_perform"></div>
                    <div><label for="license_perform" >Perform</label></div>
                    <div ><input class="license_group" type="checkbox" id="license_derivative" name="license_derivative"></div>
                    <div><label for="license_derivative" >Make derivative work</label></div>
                    <div ><input class="license_group" type="checkbox" id="license_none" name="license_none"></div>
                    <div><label for="license_none" >None of them</label></div>
                </div>
                <div class="clearfix"></div>
                <h4>ADDITIONAL INFORMATION</h4>
                <hr class="col-sm-11"/>

                <div class="form-group">
                    <div class="col-sm-6">
                        <label for="participants_beginning" class="col-sm-9">Participants registered at the beginning of the course: </label>
                        <div class="col-sm-3"><input type="text" class="ancho_total" name="participants_beginning"  id="participants_beginning"></div>
                        <label  for="participants_second_week" class="col-sm-9">Participants registered from second week in advanced: </label>
                        <div class="col-sm-3"><input type="number" class="ancho_total" name="participants_second_week"  id="participants_second_week"></div>
                        <label for="participants_tasks_mandatory" class="col-sm-9">Participants with all required tasks completed: </label>
                        <div class="col-sm-3"><input type="number" class="ancho_total" name="participants_tasks_mandatory" id="participants_tasks_mandatory"></div>
                        <label for="total_last_task" class="col-sm-9">Participants who have completed the last task/exam:</label>
                        <div class="col-sm-3"><input type="text" name="total_last_task" id="total_last_task" class="ancho_total"/></div>
                        <label class="col-sm-9">Participants with all tasks completed </label><br>
                        <label for="participants_all_tasks" class="second_line col-sm-9">(included not mandatory ones): </label>
                        <div class="second_line col-sm-3"><input type="number" class="ancho_total" name="participants_all_tasks" id="participants_all_tasks"></div>
                        <label for="participants_good_marks"class="col-sm-9">Participants with a mark equals or superior to 8.5: </label>
                        <div class="col-sm-3"><input type="number" class="ancho_total" name="participants_good_marks" id="participants_good_marks"></div>
                    </div>

                    <div class="col-sm-6">
                        <label class="col-sm-offset-2 col-sm-6">Number of certificates issued: </label>
                        <div class="col-sm-7 col-sm-offset-4 caja">
                            <label for="certificates_apprentice" class="col-sm-8">By apprentice track: </label>
                            <div class="col-sm-4"><input type="number" class="ancho_total" name="certificates_apprentice" id="certificates_apprentice"></div>
                            <label for="certificates_studio_track" class="col-sm-8">By studio track: </label>
                            <div class="col-sm-4"><input type="number" class="ancho_total" name="certificates_studio_track" id="certificates_studio_track"></div>
                            <label for="certificates_practicum" class="col-sm-8">By studio practicum: </label><br>
                            <div class="col-sm-4"><input type="number" class="ancho_total" name="certificates_practicum" id="certificates_practicum"></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-6">
                        <label for="participants_active_entire_course" class="col-sm-9">Active participants during the entire course: </label>
                        <div class="col-sm-3"><input type="number" class="ancho_total" name="participants_active_entire_course" id="participants_active_entire_course"></div>
                        <label for="participants_active_first_second" class="col-sm-9">Active participants during the first and second week: </label>
                        <div class="col-sm-3"><input type="number" class="ancho_total" name="participants_active_first_second" id="participants_active_first_second"></div>
                        <label for="participants_less_materials" class="col-sm-9">Participants who accessed less than a half of materials: </label>
                        <div class="col-sm-3"><input type="number" class="ancho_total" name="participants_less_materials" id="participants_less_materials"></div>
                        <label for="posts_published" class="col-sm-9">If there's a forum</label><br>
                        <label for="posts_published" class="second_line col-sm-9">Number of posts published by participants: </label>
                        <div class="second_line col-sm-3"><input type="number" class="ancho_total" name="posts_published" id="posts_published"></div>
                    </div>

                    <div class="col-sm-5">
                        <label for="active_first_week" class="col-sm-9">Active participants during the first week: </label>
                        <div class="col-sm-3"><input type="number" class="ancho_total" name="active_first_week" id="active_first_week"></div>
                        <label for="active_three_weeks" class="col-sm-9">Active participants during the first three weeks</label>
                        <label for="active_three_weeks" class="second_line col-sm-9"> and/or following: </label>
                        <div class="second_line col-sm-3"><input type="number" class="ancho_total" name="active_three_weeks" id="active_three_weeks"></div>
                        <label for="participants_more_materials" class="col-sm-9">Participants who accessed more than </label>
                        <label for="participants_more_materials" class="second_line col-sm-9">a half of materials: </label>
                        <div class="second_line col-sm-3"><input type="number" class="ancho_total" name="participants_more_materials" id="participants_more_materials"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-6" id="assesments">
                    <label>Type of assesments</label><br/>
                    <div ><input class="assesment_group" type="checkbox" id="automatic_assesment" name="automatic_assesment"></div>
                    <div><label for="automatic_assesment" >Automatic</label></div>
                    <div ><input class="assesment_group" type="checkbox" name="authority_assesment" id="authority_assesment"></div>
                    <div><label for="authority_assesment" >Based on authority</label></div>
                    <div ><input class="assesment_group" type="checkbox" name="social_assesment" id="social_assesment"></div>
                    <div><label for="social_assesment">Social interaction</label></div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-12">
                    
                    <label for="average_length_videos" class="col-sm-3">Average length of videos:</label>
                    <div class="col-sm-1"><input type="text" name="average_length_videos" id="average_length_videos" class="ancho_total"></div>
                    <label class="holder col-sm-2 left">hh:mm:ss</label>
                    <div class="clearfix"></div>

                    <label class="col-sm-3">The course make use of:</label>
                    <div class="col-sm-9" id="social_networks">
                        <div class="col-sm-4"><div class="col-sm-1"><input type="checkbox" name="social" id="social"></div>
                            <label for="social" class="col-sm-8">Social networks</label></div>
                        <div class="col-sm-3"><div class="col-sm-1"><input type="checkbox" name="forum" id="forum"></div>
                            <label for="forum" class="col-sm-8">Forum</label></div>
                        <div class="col-sm-3"><div class="col-sm-1"><input type="checkbox" name="blog" id="blog"></div>
                            <label for="blog" class="col-sm-6">Blog</label></div>
                        <div class="col-sm-2"><div class="col-sm-1"><input type="checkbox" name="rss" id="rss"></div>
                            <label for="rss" class="col-sm-6">RSS</label></div>
                    </div>
                    <div class="clearfix"></div>

                    <label class="col-sm-5">In case of official final certificate: is it free or on payment?</label>
                    <div class="col-sm-5" id="open_official_group">
                        <div ><input type="radio" id="official_certificate_price_yes" name="official_certificate_price" value="free"></div>
                        <div ><label for="official_certificate_price_yes" >Free</label></div>
                        <div ><input type="radio" id="official_certificate_price_no" name="official_certificate_price" value="payment"></div>
                        <div ><label for="official_certificate_price_no">On payment</label></div>
                    </div>
                    <div class="clearfix"></div>

                    <label class="col-sm-5">Has it a guide with indications to follow the course?</label>
                    <div class="col-sm-4" id="guide_group">
                        <div ><input type="radio" id="guide_yes" name="guide" value="yes"></div>
                        <div><label for="guide_yes">Yes</label></div>
                        <div ><input type="radio" id="guide_no" name="guide" value="no"></div>
                        <div><label for="guide_no">No</label></div>
                    </div>
                    <div class="clearfix"></div>

                    <label class="col-sm-3">Is the course free/gratis?</label>
                    <div class="col-sm-4" id="open_course_group">
                        <div><input type="radio" id="gratis_yes" name="gratis" value="yes"></div>
                        <div><label for="gratis_yes">Yes</label></div>
                        <div><input type="radio" id="gratis_no" name="gratis" value="no"></div>
                        <div><label for="gratis_no">No</label></div>
                    </div>
                    <div class="clearfix"></div>                
                    <div class="clearfix"></div>
                </div>

                <div class="col-sm-2 col-sm-offset-4">
                    <button type="reset" name="rest" value="RESET" class="btn btn-primary ancho_total">RESET</button>
                </div>
                <div class="col-sm-2">
                    <button type="button" name="send" value="SEND" class="btn btn-primary ancho_total">SEND</button>
                </div>

            </form>
        </div>
    </div>
    <?php
}

// register our form no 
function moocmeas_register_css() {
    wp_register_style('moocmeas-form-css', plugins_url('/css/moocmeas-form.css', __FILE__));
    wp_register_style('bootstrap-form', plugins_url('/css/bootstrap.project.css', __FILE__));
    wp_enqueue_style('moocmeas-form-css');
    wp_enqueue_style('bootstrap-form');
}

add_action('init', 'moocmeas_register_css');

function moocmeas_register_js() {
    wp_register_script('jquery-validate-script', plugins_url('/js/jquery.validate.min.js', __FILE__), array('jquery'));
    wp_enqueue_script('jquery-validate-script');
    wp_register_script('jquery-validate-methods', plugins_url('/js/additional-methods.min.js', __FILE__));
    wp_enqueue_script('jquery-validate-methods');
    wp_register_script('moocmeas-script', plugins_url('/js/moocmeas.js', __FILE__));
    wp_enqueue_script('moocmeas-script');
    wp_register_script('p5-script', plugins_url('/js/p5.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_script('p5-script');
    wp_register_script('p5-dom', plugins_url('/js/p5.dom.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_script('p5-dom');
    wp_register_script('radialMOOC-script', plugins_url('/js/radialMOOC.js', __FILE__), array('jquery'), null, true);
    wp_enqueue_script('radialMOOC-script');
}

add_action('admin_menu', 'moocmeas_register_js');