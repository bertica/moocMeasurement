var miCanvas;

function setup() {
    miCanvas = createCanvas(500, 500);
    miCanvas.parent("miCanvas");
    miCanvas.class("canvas");
    noLoop();
    button = createButton("Compare");
    button.parent("compare");
    button.class("btn btn-primary");
    button.mouseClicked(compara);
}

function draw() {
    var M = 50;
    background(255);
    strokeWeight(1);  //Grosor de las lineas
    stroke(0); //Color de las lineas
    line(M, height / 2, width - M, height / 2); //linea desde (50,300) a (250,300)
    line(width / 2, M, width / 2, height - M); //linea desde (300,50) a (300,250) --> Son los ejes de coordenadas
    textSize(20); //Tamaño de la fuente
    fill(0); //Color de relleno de las áreas dibujadas
    textAlign(LEFT); //Alineación del texto
    text("Massive", M - 20, M - 20); //Escribe "Massive" en la coordenada (50,50)
    text("Course", M - 20, height - M + 30); //Escribe "Course" en la coordenada (50,250)
    textAlign(RIGHT); //Alineación del texto
    text("Open", width - M + 20, M - 20); //Escribe "Open" en la coordenada (250,50)
    text("Online", width - M + 20, height - M + 30); //Escribe "Online" en la coordenada (250,250)*/

}

function vacia() {
    miCanvas = createCanvas(520, 520);
    miCanvas.parent("miCanvas");
    miCanvas.class("canvas");
    noLoop();
    var M = 50;
    background(255);
    strokeWeight(1);  //Grosor de las lineas
    stroke(0); //Color de las lineas
    line(M, height / 2, width - M, height / 2); //linea desde (50,300) a (250,300)
    line(width / 2, M, width / 2, height - M); //linea desde (300,50) a (300,250) --> Son los ejes de coordenadas
    textSize(20); //Tamaño de la fuente
    fill(0); //Color de relleno de las áreas dibujadas
    textAlign(LEFT); //Alineación del texto
    text("Massive", M - 20, M - 20); //Escribe "Massive" en la coordenada (50,50)
    text("Course", M - 20, height - M + 30); //Escribe "Course" en la coordenada (50,250)
    textAlign(RIGHT); //Alineación del texto
    text("Open", width - M + 20, M - 20); //Escribe "Open" en la coordenada (250,50)
    text("Online", width - M + 20, height - M + 30); //Escribe "Online" en la coordenada (250,250)
}

function compara(e) {
//function draw() {
    //var VM = 250;
    vacia();
    e.preventDefault();

    var arrayCursos = new Array();
    var datos = new Array();
    var arrayMassiveNames = new Array();
    var arrayCourseNames = new Array();
    var arrayOpenNames = new Array();
    var arrayOnlineNames = new Array();
    var arraymassive = new Array();
    var arrayopen = new Array();
    var arrayonline = new Array();
    var arraycourse = new Array();
    var massiveIdeal = new Array();
    var openIdeal = new Array();
    var onlineIdeal = new Array();
    var courseIdeal = new Array();
    var $postData = jQuery("#send_comparation").serialize();
    var $massive_n;
    var $open_n;
    var $online_n;
    var $course_n;
    var $colors_c;
    //Obtengo los datos de los cursos que se han seleccionado en el formulario
    jQuery.ajax({
        url: '../wp-content/plugins/mooc-measurement/php/getDatas.php',
        dataType: 'json',
        data: $postData,
        method: 'POST',
        async: false,
        error: function (error) {/*
         jQuery.each(data, function (i, item) {
         alert(i+" : "+item);
         });*/
            alert(error.responseText);
        },
        success: function (data) {
            //alert('success -- ' +data);
            var num = 0;
            jQuery.each(data, function (i, item) {
                if (i !== 'colores') {
                    arrayMassiveNames = new Array();
                    arrayCourseNames = new Array();
                    arrayOpenNames = new Array();
                    arrayOnlineNames = new Array();
                    arraymassive = new Array();
                    arrayopen = new Array();
                    arrayonline = new Array();
                    arraycourse = new Array();
                    massiveIdeal = new Array();
                    openIdeal = new Array();
                    onlineIdeal = new Array();
                    courseIdeal = new Array();
                    var $curso = i;
                    arrayCursos.push($curso);
                    var $massive = item.MASSIVE;
                    var $open = item.OPEN;
                    var $online = item.ONLINE;
                    var $course = item.COURSE;
                    $massive_n = item.MASSIVE_numeros;
                    $open_n = item.OPEN_numeros;
                    $online_n = item.ONLINE_numeros;
                    $course_n = item.COURSE_numeros;
                    if (typeof $massive !== 'undefined') {
                        jQuery.each($massive, function (j, m) {
                            //alert(j + "->" + m);
                            arrayMassiveNames.push(j);
                            arraymassive.push(m);
                            //arraymassive[j] = m;
                            massiveIdeal.push(1);
                        });
                        datos[num * 4] = arraymassive;
                    } else {
                        datos[num * 4] = new Array();
                    }
                    if (typeof $open !== 'undefined') {
                        jQuery.each($open, function (j, m) {
                            //alert(j + "->" + m);
                            arrayOpenNames.push(j);
                            arrayopen.push(m);
                            //arrayopen[j] = m;
                            openIdeal.push(1);
                        });
                        datos[num * 4 + 1] = arrayopen;
                    } else {
                        datos[num * 4 + 1] = new Array();
                    }
                    if (typeof $online !== 'undefined') {
                        jQuery.each($online, function (j, m) {
                            /*alert(j + "->" + m);*/
                            arrayOnlineNames.push(j);
                            arrayonline.push(m);
                            //arrayonline[j] = m;
                            onlineIdeal.push(1);
                        });
                        datos[num * 4 + 2] = arrayonline;
                    } else {
                        datos[num * 4 + 2] = new Array();
                    }
                    if (typeof $course !== 'undefined') {
                        jQuery.each($course, function (j, m) {
                            /*alert(j + "->" + m);*/
                            arrayCourseNames.push(j);
                            arraycourse.push(m);
                            //arraycourse[j] = m;
                            courseIdeal.push(1);
                        });
                        datos[num * 4 + 3] = arraycourse;
                    } else {
                        datos[num * 4 + 3] = new Array();
                    }
                    num++;
                }else{
                    $colors_c = item;
                }
            });

        }
    });


    /*var colores = [color(228,26,28),color(55,126,184),color(77,175,74),color(152,78,163)];*/
    var colores = [color(55, 126, 184), color(228, 26, 28), color(77, 175, 74), color(255, 255, 0)];
    /*Dibujo las líneas "guía"*/
    stroke(color(240, 240, 240));
    textSize(10);
    dibuja(massiveIdeal, openIdeal, onlineIdeal, courseIdeal, 1, $massive_n, $open_n, $online_n, $course_n);

    /*Dibujo cada curso*/
    for (i = 1; i <= arrayCursos.length; i++) {
        noFill();
        textAlign(CENTER, TOP);
        textSize(18);
        //text(arrayCursos[i-1],width/2,height-M/2);

        ellipseMode(CENTER);



        /*Dibujo las líneas de los cursos elegidos*/
        //stroke(colores[i - 1]);
        stroke(colores[$colors_c[i-1]]);
        /*stroke(colores[0]);*/
        strokeWeight(2);
        //MASSIVE
        var massive = datos[(i - 1) * 4];
        /* Open */
        var open = datos[(i - 1) * 4 + 1];
        /* Online */
        var online = datos[(i - 1) * 4 + 2];
        /* Course */
        var course = datos[(i - 1) * 4 + 3];

        dibuja(massive, open, online, course, 0, $massive_n, $open_n, $online_n, $course_n);

    }
    return false;
}
function dibuja(massive, open, online, course, ideal, massive_n, open_n, online_n, course_n) {

    var VM = 250;
    var MODEZERO = 1;
    var MODEFILL = 0;
    var px, py, prx = 0, pry = 0;
    var ux = 0, uy = 0;

    //MASSIVE
    //var massive = datos[(i-1)*4];
    var vacio = false;
    if (MODEZERO === 1) {
        ux = width / 2;
        uy = height / 2;
    }
    for (j = 0; j < massive.length; j++) {
        px = width / 2 + (VM * massive[j]) * cos((j + 1) * (PI / 2.0) / (massive.length + 1.0) - PI);
        py = height / 2 + (VM * massive[j]) * sin((j + 1) * (PI / 2.0) / (massive.length + 1.0) - PI);
        if (j === 0) {
            prx = px;
            pry = py;
        }
        if (massive[j] !== "") {
            ellipse(px, py, 8, 8);
            if (ideal === 1) {
                color(0, 0, 0);
                noStroke();
                text(massive_n[j], px - 5, py - 5);
                stroke(color(240, 240, 240));
            }
        }
        if ((ux !== 0) && (uy !== 0)) {
            if (massive[j] !== "") {
                line(ux, uy, px, py);
                vacio = false;
            } else {
                vacio = true;
            }
        }
        if (j > 0 && MODEFILL === 1) {
            triangle(width / 2, height / 2, px, py, ux, uy);
        }
        if (vacio === false) {
            ux = px;
            uy = py;
        }
    }
    if (MODEZERO === 1) {
        line(ux, uy, width / 2, height / 2);
        ux = width / 2;
        uy = height / 2;
    }

    /* Quadrant Open */
    for (j = 0; j < open.length; j++) {
        px = width / 2 + (VM * open[j]) * cos((j + 1) * (PI / 2.0) / (open.length + 1.0) - PI / 2.0);
        py = height / 2 + (VM * open[j]) * sin((j + 1) * (PI / 2.0) / (open.length + 1.0) - PI / 2.0);
        if (open[j] !== "") {
            ellipse(px, py, 8, 8);
            if (ideal === 1) {
                color(0, 0, 0);
                noStroke();
                text(open_n[j], px + 12, py - 5);
                stroke(color(240, 240, 240));
            }
        }
        if ((ux !== 0) && (uy !== 0)) {
            if (open[j] !== "") {
                line(ux, uy, px, py);
                vacio = false;
            } else {
                vacio = true;
            }
        }
        if (j > 0 && MODEFILL === 1) {
            triangle(width / 2, height / 2, px, py, ux, uy);
        }
        if (vacio === false) {
            ux = px;
            uy = py;
        }
    }
    if (MODEZERO === 1) {
        line(ux, uy, width / 2, height / 2);
        ux = width / 2;
        uy = height / 2;
    }


    /* Quadrant Online */
    for (j = 0; j < online.length; j++) {
        px = width / 2 + (VM * online[j]) * cos((j + 1) * (PI / 2.0) / (online.length + 1.0));
        py = height / 2 + (VM * online[j]) * sin((j + 1) * (PI / 2.0) / (online.length + 1.0));
        if (online[j] !== "") {
            ellipse(px, py, 8, 8);
            if (ideal === 1) {
                color(0, 0, 0);
                noStroke();
                text(online_n[j], px + 12, py + 12);
                stroke(color(240, 240, 240));
            }
        }
        if ((ux !== 0) && (uy !== 0)) {
            if (online[j] !== "") {
                line(ux, uy, px, py);
                vacio = false;
            } else {
                vacio = true;
            }
        }
        if (j > 0 && MODEFILL === 1) {
            triangle(width / 2, height / 2, px, py, ux, uy);
        }
        if (vacio === false) {
            ux = px;
            uy = py;
        }
    }
    if (MODEZERO === 1) {
        line(ux, uy, width / 2, height / 2);
        ux = width / 2;
        uy = height / 2;
    }


    /* Quadrant Course */
    for (j = 0; j < course.length; j++) {
        px = width / 2 + (VM * course[j]) * cos((j + 1) * (PI / 2.0) / (course.length + 1.0) + PI / 2.0);
        py = height / 2 + (VM * course[j]) * sin((j + 1) * (PI / 2.0) / (course.length + 1.0) + PI / 2.0);
        if (course[j] !== "") {
            ellipse(px, py, 8, 8);
            if (ideal === 1) {
                color(0, 0, 0);
                noStroke();
                text(course_n[j], px - 5, py + 12);
                stroke(color(240, 240, 240));
            }
        }
        if ((ux !== 0) && (uy !== 0)) {
            if (course[j] !== "") {
                line(ux, uy, px, py);
                vacio = false;
            } else {
                vacio = true;
            }
        }
        if (j > 0 && MODEFILL === 1) {
            triangle(width / 2, height / 2, px, py, ux, uy);
        }
        if (vacio === false) {
            ux = px;
            uy = py;
        }
    }
    if (MODEZERO === 1) {
        line(ux, uy, width / 2, height / 2);
        ux = width / 2;
        uy = height / 2;
    } else {
        /* tancar el graf */
        line(ux, uy, prx, pry);
    }
    return false;
}
/*
 function calculaProporciones(criterios,numeroCursos){
 todosDatos = new Array();
 
 for (i = 0; i < numeroCursos; i++) {
 todos
 }
 }*/

