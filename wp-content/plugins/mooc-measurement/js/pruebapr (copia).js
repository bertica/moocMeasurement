var miCanvas;

function setup(){
  miCanvas = createCanvas(500,500);
  miCanvas.parent("miCanvas");
  miCanvas.class("canvas");
  noLoop();/*
  button = createButton();
  button.parent("compare");
  button.mousePressed(draw);*/
}


function draw(){
  background(255); 
  var M=50;
  var VM=250;
  
  var arrayCursos = ["curso1","curso2","curso3","curso4"];
  
  var arrayMassiveNames = ["Masivo1","Masivo2","Masivo3","Masivo4"];
  var arrayCourseNames = ["Curso1","Curso2","Curso3","Curso4"];
  var arrayOpenNames = ["Open1","Open2","Open3","Open4"];
  var arrayOnlineNames = ["Online1","Online2","Online3","Online4"];
  
  var datos={};
  
  for(i=0;i<arrayCursos.length;i++){
    /*float[] massive = {0.6,1,0,0.4};
    float[] open = {0.5,0.2,0.9,1};
    float[] online = {1,1,0,0.1};
    float[] course = {0.1,0.3,1,0.8};*/
    var massive = [Math.random(),Math.random(),Math.random(),Math.random()];
    var open = [Math.random(),Math.random(),Math.random(),Math.random()]; 
    var online = [Math.random(),Math.random(),Math.random(),Math.random()]; 
    var course = [Math.random(),Math.random(),Math.random(),Math.random()]; 
    datos[i*4] = massive;
    datos[i*4+1] = open;
    datos[i*4+2]= online;
    datos[i*4+3]= course;
  }
  
  /*var colores = [color(228,26,28),color(55,126,184),color(77,175,74),color(152,78,163)];*/
  var colores = [color(228,26,28),color(55,126,184),color(77,175,74),color(255,255,0)];
  
  strokeWeight(1);  //Grosor de las lineas
  stroke(0); //Color de las lineas
  line(M,height/2,width-M,height/2); //linea desde (50,300) a (250,300)
  line(width/2,M,width/2,height-M); //linea desde (300,50) a (300,250) --> Son los ejes de coordenadas
  
  textSize(20); //Tamaño de la fuente
  fill(0); //Color de relleno de las áreas dibujadas
  textAlign(LEFT); //Alineación del texto
  text("Massive",M-20,M-20); //Escribe "Massive" en la coordenada (50,50)
  text("Course",M-20,height-M+30); //Escribe "Course" en la coordenada (50,250)
  textAlign(RIGHT); //Alineación del texto
  text("Open",width-M+20,M-20); //Escribe "Open" en la coordenada (250,50)
  text("Online",width-M+20,height-M+30); //Escribe "Online" en la coordenada (250,250)
  
  for(i=1;i<=arrayCursos.length;i++){
    noFill();
    textAlign(CENTER,TOP);
    textSize(18);
    //text(arrayCursos[i-1],width/2,height-M/2);
    
    ellipseMode(CENTER);
    
    /*Dibujo las líneas "guía"*/
    var massiveIdeal=[1,1,1,1];
    var openIdeal=[1,1,1,1];
    var onlineIdeal=[1,1,1,1];
    var courseIdeal=[1,1,1,1];
    stroke(color(240,240,240));
    dibuja(massiveIdeal,openIdeal,onlineIdeal,courseIdeal);
    
    /*Dibujo las líneas de los cursos elegidos*/
    stroke(colores[i-1]);
    /*stroke(colores[0]);*/
    strokeWeight(2);
    //MASSIVE
    var massive = datos[(i-1)*4];
    /* Open */
    var open = datos[(i-1)*4+1];
    /* Online */
    var online = datos[(i-1)*4+2];
    /* Course */
    var course = datos[(i-1)*4+1];
    
    dibuja(massive,open,online,course);
  
   }
   
   
   function dibuja(massive,open,online,course){
    var MODEZERO=1;
    var MODEFILL=0;
    var px,py,prx=0,pry=0;
    var ux=0,uy=0;
        
    //MASSIVE
    //var massive = datos[(i-1)*4];
    
    if (MODEZERO===1) {
      ux=width/2; uy=height/2;
    }
    for (j=0; j<massive.length; j++) {
      px=width/2+(VM*massive[j])*cos((j+1)*(PI/2.0)/(massive.length+1.0)-PI);
      py=height/2+(VM*massive[j])*sin((j+1)*(PI/2.0)/(massive.length+1.0)-PI);
      if (j===0) {
        prx=px; pry=py;
      }
      ellipse(px,py,8,8);
      if ((ux!==0) && (uy!==0)) {
        line(ux, uy, px, py);
      } 
      if (j>0 && MODEFILL===1) {
         triangle(width/2,height/2,px,py,ux,uy);
      }
      ux=px; uy=py;
    }
    if (MODEZERO===1) {
      line(ux, uy, width/2, height/2);
      ux=width/2; uy=height/2; 
    } 
    
    /* Quadrant Open */
    for (j=0; j<open.length; j++) {
      px=width/2+(VM*open[j])*cos((j+1)*(PI/2.0)/(open.length+1.0)-PI/2.0);
      py=height/2+(VM*open[j])*sin((j+1)*(PI/2.0)/(open.length+1.0)-PI/2.0);
      ellipse(px,py,8,8);
      if ((ux!==0) && (uy!==0)) {
        line(ux, uy, px, py);
      } 
      if (j>0 && MODEFILL===1) {
        triangle(width/2,height/2,px,py,ux,uy);
      }
      ux=px; uy=py;
    }     
    if (MODEZERO===1) {
      line(ux, uy, width/2, height/2);
      ux=width/2; uy=height/2; 
    }
    

    /* Quadrant Online */
    for (j=0; j<online.length; j++) {
      px=width/2+(VM*online[j])*cos((j+1)*(PI/2.0)/(online.length+1.0));
      py=height/2+(VM*online[j])*sin((j+1)*(PI/2.0)/(online.length+1.0));
      ellipse(px,py,8,8);
      if ((ux!==0) && (uy!==0)) {
        line(ux, uy, px, py);
      } 
      if (j>0 && MODEFILL===1){
        triangle(width/2,height/2,px,py,ux,uy);
      }
      ux=px; uy=py;
    }     
    if (MODEZERO===1) {
      line(ux, uy, width/2, height/2);
      ux=width/2; uy=height/2; 
    }
    

    /* Quadrant Course */
    for (j=0; j<course.length; j++) {
      px=width/2+(VM*course[j])*cos((j+1)*(PI/2.0)/(course.length)+PI/2.0);
      py=height/2+(VM*course[j])*sin((j+1)*(PI/2.0)/(course.length+1.0)+PI/2.0);
      ellipse(px,py,8,8);
      if ((ux!==0) && (uy!==0)) {
        line(ux, uy, px, py);
      } 
      if (j>0 && MODEFILL===1) {
        triangle(width/2,height/2,px,py,ux,uy);
      }
      ux=px; uy=py;
    }   
    if (MODEZERO===1) {
      line(ux, uy, width/2, height/2);
      ux=width/2; uy=height/2; 
    } else {    
      /* tancar el graf */
      line(ux, uy, prx, pry);
    }
  
   }
  
}