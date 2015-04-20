<?php
session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="es"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="es"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="es"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="es"> <!--<![endif]-->
<head>

    <meta charset="utf-8">
    <title>Mariana Avigo | Models</title>
    <meta name="description" content="Sitio web dedicado a la venta y suministro de artículos para la cocina gourmet">
    <meta name="author" content="Mariana Avigo Models">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">


    <link rel="stylesheet" href="stylesheets/base.css">
    <link rel="stylesheet" href="stylesheets/skeleton1200.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="stylesheets/layout.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/slick.css"/><!-- Carrusel de imagenes -->
    <link href='http://fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,700' rel='stylesheet' type='text/css'>


    <script src="js/jquery-1.11.1.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script type="text/javascript" src="js/slick.min.js"></script><!-- Carrusel de imagenes -->
    <script type="text/javascript" src="js/ajaxfunctions.js"></script>
    <script src="//unslider.com/unslider.min.js"></script>


    <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">

</head>
<body>

<?php include("menu.php");?>


<!-- <div class="cover">
    <div class="container">
        <div class="ten columns offset-by-three">
            <h1>Modelamos tu imagen</h1>
        </div>
    </div>
</div> -->

<div class="cover">
    <div class="image-slider-wrapper">
        <ul id="image_slider">
            <li><img src="images/cover11.jpg"><h1 class="fade">Modelamos tu imagen</h1></li>
            <li><img src="images/cover21.jpg"></li>
        </ul> 
        <span class="nvgt" id="prev"></span>
                <span class="nvgt" id="next"></span>
    </div>
</div>


<script type="text/javascript">
    //1. set ul width 
//2. image when click prev/next button
var ul;
var li_items;
var imageNumber;
var imageWidth;
var prev, next;
var currentPostion = 0;
var currentImage = 0;
var h1;

function init(){
    ul = document.getElementById('image_slider');
    li_items = ul.children;
    imageNumber = li_items.length;
    imageWidth = li_items[0].children[0].clientWidth;
    ul.style.width = parseInt(imageWidth * imageNumber) + 'px';
    prev = document.getElementById("prev");
    next = document.getElementById("next");
    //.onclike = slide(-1) will be fired when onload;
    /*
    prev.onclick = function(){slide(-1);};
    next.onclick = function(){slide(1);};*/
    prev.onclick = function(){ onClickPrev();};
    next.onclick = function(){ onClickNext();};
}

function animate(opts){
    var start = new Date;
    var id = setInterval(function(){
        var timePassed = new Date - start;
        var progress = timePassed / opts.duration;
        if (progress > 1){
            progress = 1;
        }
        var delta = opts.delta(progress);
        opts.step(delta);
        if (progress == 1){
            clearInterval(id);
            opts.callback();
        }
    }, opts.delay || 17);
    //return id;
}

function slideTo(imageToGo){
    var direction;
    var numOfImageToGo = Math.abs(imageToGo - currentImage);
    // slide toward left

    direction = currentImage > imageToGo ? 1 : -1;
    currentPostion = -1 * currentImage * imageWidth;
    var opts = {
        duration:1000,
        delta:function(p){return p;},
        step:function(delta){
            ul.style.left = parseInt(currentPostion + direction * delta * imageWidth * numOfImageToGo) + 'px';
        },
        callback:function(){currentImage = imageToGo;}  
    };
    animate(opts);
}

function onClickPrev(){
    if (currentImage == 0){
        slideTo(imageNumber - 1);
    }       
    else{
        slideTo(currentImage - 1);
    }       
}

function onClickNext(){
    if (currentImage == imageNumber - 1){
        slideTo(0);
    }       
    else{
        slideTo(currentImage + 1);
    }       
}

window.onload = init;
</script>


<div class="carrousel">
    <div class="container">
            <div class="title">
                <h2>&nbsp;&nbsp;Modelos&nbsp;&nbsp;</h2>
            </div>
            <div class="one-third column prod">
              <img src="images/prod1.png">
              <div id="overlays"><h3>Modelos</h3></div>
            </div>
            <div class="one-third column prod">
              <img src="images/prod2.png">
              <div id="overlays"><h3>Edecanes</h3></div>
            </div>
            <div class="one-third column prod">
              <img src="images/prod3.png">
              <div id="overlays"><h3>Gios</h3></div>
            </div>
<!--             <div class="eight columns prod">
              <img src="images/prod4.png">
              <h3>Mecánicos y Eléctricos</h3>
            </div><div class="eight columns prod">
              <img src="images/prod5.png">
              <h3>Libros y Aprendizaje</h3>
            </div> -->
      
    </div>
</div>

<script type="text/javascript">
$(window).scroll(function() {    
    var scroll = $(window).scrollTop();

    if (scroll >=600) {
        $(".fade").addClass("scrolling");
    } else {
        $(".fade").removeClass("scrolling");
    }
});
});</script>


<div class="boton">
<div class="container">
    <div class="sixteen colums asder">
    <div class="button" id="dos"><a>Ver más</a></div>
    </div>
</div>
</div>


<?php include("footer.php");?>






</body>
</html>
