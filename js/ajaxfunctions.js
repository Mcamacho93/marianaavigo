function signUp(ev, name, lastname, email, conemail, password, cpassword){
    $(document).ready(function(){
        ev.preventDefault();
        if(name == ""){
            alert('El campo nombre no puede quedar vac\u00edo');
            return;
        }
        if(lastname == ""){
            alert("El campo de apellidos no puede quedar vac\u00edo");
            return;
        }
        if($.trim(email) == ""){
            alert('El campo de correo no puede quedar vac\u00edo');
            return;
        }
        if($.trim(conemail) == ""){
            alert("El campo confirmar correo no puede quedar vac\u00edo")
        }
        if(!validateEmail(email)){
            alert('El correo electr\u00f3nico no es v\u00e1lido');
            return;
        }
        if(!validateEmail(conemail)){
            alert('El correo electr\u00f3nico no es v\u00e1lido');
            return;
        }
        if(email != conemail){
            alert('Los correos no coinciden');
            return;
        }
        if($.trim(password) == ""){
            alert('El campo contrase\u00f1a no puede quedar vac\u00edo');
            return;
        }
        if($.trim(cpassword) == ""){
            alert('El campo de confirmar contrase\u00f1a no puede quedar vac\u00edo');
            return;
        }
        if($.trim(password) != cpassword){
            alert('Las contrase\u00f1as no coinciden');
            return;
        }
        if($.trim(password.length) <= 6){
            alert('La contrase\u00f1a debe tener m\u00e1s de 6 caracteres');
            return;
        }
        else{
            $.ajax({
                beforeSend: function(){
                    $('#enviar').attr('disabled', true);
                    $('#enviar').html('Espere...');
                },
                url: 'sign.php',
                type: 'POST',
                data: {Name: name, LastName:lastname, Email: email, PassworD: password},
                success: function(r){
                    alert(r);
                    $('#enviar').attr('disabled', false);
                    $('#enviar').html('Enviar');
                    document.getElementById('registros').reset();
                }
            });
        }
    });
}

function validateEmail(email){
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!filter.test(email))
        return false;
    else
        return true;
}

function validaentero(ev) {
            var Event = ev || window.event;
        var key = Event.keyCode || Event.which;
        key = String.fromCharCode( key );
        var permitidos = /[0-9]/;
        if( !permitidos.test(key) ) {
             Event.returnValue = false;
             if(Event.preventDefault) Event.preventDefault();
    }
}

//
function login(evlog, user, password){
    evlog.preventDefault();
        if($.trim(user) == ""){
            alert ('El campo correo no puede quedar vac\u00edo');
            return;
        }
        if($.trim(password) == ""){
            alert('El campo contrase\u00f1a no puede quedar vac\u00edo');
            return;
        }
        else{
            $.ajax({
                beforeSend: function(){
                    $('#button').html('Espere');
                    $('#button').attr('disabled', true);
                    $('#estado').fadeOut(500);

                },
                url: 'login.php',
                type: 'POST',
                data: {Mail: user, Contrasena: password},
                success: function(reslog){
                    console.log(reslog);
                    $('#button').html('INICIAR SESIÓN');
                    $('#button').attr('disabled', false);
                    if(reslog == "OKCTE")
                        window.location = "tienda.php";
                    if(reslog == "OKADMIN")
                        window.location = "admin/";
                    else if(reslog != "OKCTE" && reslog != "OKADMIN"){
                        $('#estado').html("Datos erroneos");
                        $('#estado').fadeIn(500);
                        setTimeout(function(){
                            $('#estado').fadeOut(500);
                        }, 3000);
                    }

                }
            })
        }
}


//<--------Inicio about.php#Contacto
$(document).ready(function(){
    $('#contact').submit(function(econ){
        econ.preventDefault();
        var nombre = $('#nombre').val();
        var email = $('#email').val();
        var msg = $('#mensaje').val();
        if(nombre == ""){
            alert('El campo nombre no puede quedar vac\u00edo');
            return;
        }
        if($.trim(email) == ""){
            alert('El campo de correo no puede quedar vac\u00edo');
            return;
        }
        if(!validateEmail(email)){
            alert('El correo electr\u00f3nico no es v\u00e1lido');
            return;
        }
        if($.trim(msg) == ""){
            alert('El campo mensaje no puede quedar vac\u00edo');
            return;
        }
        else{
            $.ajax({
                beforeSend: function(){
                    $('#enviar').attr("disabled", true);
                    $('#enviar').html('Enviando...');
                },

                url: 'enviocontacto.php',
                type: 'POST',
                data: {Nombre: nombre, Email: email, Msg: msg},
                success: function(rc){
                    alert(rc);
                    $('#enviar').attr("disabled", false);
                    $('#enviar').html('Enviar');
                    document.getElementById('contact').reset();
                }
            });
        }
    });
});

function recuperarC(evrc, correo){
    evrc.preventDefault();
    if($.trim(correo) == ""){
        $('#msgr').html('Ingrese un correo electrónico');
        return;
    }
    if(!validateEmail(correo)){
            alert('El correo electr\u00f3nico no es v\u00e1lido');
            return;
    }
    else{
        $.ajax({
            beforeSend: function(){
                $('enviarC').attr('disabled', true);
                $('enviarC').html('Enviando...');
            },
            url: 'correorc.php',
            method: 'POST',
            data: {Correo: correo},
            success: function(resrc){
                $('enviarC').attr('disabled', false);
                $('enviarC').html('ENVIAR');
                $('#msgr').fadeIn(500);
                $('#msgr').html(resrc);
                setTimeout(function(){
                    $('#msgr').fadeOut(500);
                },4000);
            }
        });
    }

}

//Contador de presentación
/*
function contadorMas(){
    //alert($(this));
    alert($(this).attr('class'));
    console.log($(this));
}

function contadorMenos(){
    //alert($(this));
    alert($(this).attr('class'));
    console.log($(this));
}


$(document).ready(function(){
    $('.contador').parent().find('.mas').click(function(){
        alert("mas");
        var num = $(this).prev().find('.cantidad').val();
        $(this).prev().find('.cantidad').val(++num);
    });

    $('.contador').parent().find('.menos').click(function(){
        alert("menos");
        var num = $(this).next().val();
        if(num <= 0)
            $(this).next().val(0);b
        else
            $(this).next().val(--num);
    });
}); */


//Contador de presentación
var numerodearticulos = [];
var ides = [];
var arrayt = new Array();
function datosDeProducto(idp){
    $.ajax({
        url: 'datosdeproducto.php',
        type: 'POST',
        data: {IDP: idp},
        success: function(resddp){
            ides = [];
            numerodearticulos = [];
            arrayt = {};
            // $('#productoCL').empty();
            var prods = JSON.parse(resddp);
            $('#presentacionesprod').empty();
            $('#listadepresentaciones').empty();
            $('#imgprod').attr('src', prods['img']);
            $('#nombrep').html(prods['productName']);
            $('#marcaprod').html(prods['brandName']);
            $('#descripcion').html(prods['productDesc']);
            $.each(prods['presentName'], function (index, val){
                //$('#presentacionesprod').append('<label>' + index + "&nbsp;&nbsp;&nbsp;" + val + '</label>');
                $('#presentacionesprod').append('<div class="cantida"><label>'+ index +'</label></div><div class="preci"><label>'+ val +'</label></div><div class="nomarg"><div class="contadordos"><button class="menoscarrito" type="button">-</button><input type="text" value="0" class="articuloscarrito" onkeypress="validaentero(event)" id="'+ index + '" onchange="actualizarObj(this.id)"><button class="mascarrito" type="button">+</button></div></div>');
                //$('#listadepresentaciones').append('<option value="'+ index +'">'+ index +'</option>');
                ides.push(index);
                numerodearticulos.push(document.getElementById(index).value);
            });

            $('.mascarrito').click(function(){
                var num = $(this).prev().val();
                $(this).prev().val(++num);
                //alert($(this).prev().attr('id'));
                arrayt[$(this).prev().attr('id')] = document.getElementById($(this).prev().attr('id')).value;
                /*$.each(arrayt, function(index, val){
                    alert("Index: " + index + "\n Valor: " + val + "\n");
                });*/
            });

            $('.menoscarrito').click(function(){
               var num = $(this).next().val();
                if(num <= 0)
                    $(this).next().val(0);
                else
                    $(this).next().val(--num);
                //alert($(this).next().attr('id'));
                arrayt[$(this).next().attr('id')] = document.getElementById($(this).next().attr('id')).value;
                /*$.each(arrayt, function(index, val){
                    alert("Index: " + index + "\n Valor: " + val + "\n");
                });*/
            });
            //var prods = [];
            /*for(i in ides){
                alert("ID: " + ides[i] + "\n");
            }
            for (i in numerodearticulos){
                alert("Articulos: " + numerodearticulos[i] + "\n");
            }*/
            for (var i = 0; i < ides.length; i++){
                arrayt[ides[i]] = numerodearticulos[i];
            }
            /*$.each(arrayt, function(index, val){
                alert("Index: " + index + "\n Valor: " + val + "\n");
            });*/
        }
    })
}


function actualizarObj(id){
    arrayt[id] = document.getElementById(id).value;
    //alert("Nada: " + id + "\n" + "Valor: " + document.getElementById(id).value);
    /*$.each(arrayt, function(index, val){
        alert("Index: " + index + "\n Valor: " + val + "\n");
    });*/
}

/*$('.contador2').find('.mascarrito').click(function({
    alert($(this).next().val());
}));*/

/*
function enviaras(){
    var nombredelprod = $('#nombrep').html();
    $.ajax({
        url: 'testobj.php',
        data: {OBJ: arrayt, Nombre: nombredelprod},
        type: 'POST',
        success: function(res){
            alert(res);
        }
    });
}
*/






//Agregar al carrito

$(document).ready(function(){
    $('#agregaralcarro').click(function(evagregar){
        evagregar.preventDefault();
        var nombredelprod = $('#nombrep').html();
        var marcadelprod = $('#marcaprod').html();
        //var presentaciondelprod = $('#listadepresentaciones').val();
        if($.trim(nombredelprod) == ""){
            $('#edoagregar').html("Datos erroneos");
            return;
        }
        else{
            $.ajax({
                beforeSend: function(){
                    $('#agregaralcarro').attr('disabled', true);
                    $('#agregaralcarro').html('Espere...');
                },
                url: 'agregaralcarrito.php',
                type: 'POST',
                data: {Info: arrayt, Nombre: nombredelprod, Marca: marcadelprod},
                success: function(resaac){
                    console.log("RESAAC: " + resaac);
                    $('#agregaralcarro').html('Agregar al carrito');
                    $('#agregaralcarro').attr('disabled', false);
                    var splitresp = resaac.split("&@&");
                    var resp = splitresp[0];
                    var json = splitresp[1];
                    var parsedjson = JSON.parse(json);
                    var cont = Object.keys(parsedjson).length;
                    if(resp == "ok"){
                        $('#edoagregar').fadeIn(500);
                        $('#edoagregar').html("Producto Agregado al Carrito");
                        setTimeout(function(){
                        $('#edoagregar').fadeOut(500);
                        },3000);
                        $('.itemsmenu').html("(" + cont + ")");
                        $('.submenucheck').empty();
                        var litotal = 0;
                        $.each(parsedjson, function(index, val){
                            console.log("NOMBRE: " + val['nombre']);
                            console.log("CANTIDAD: " + val['cantidad']);
                            console.log("PRECIO: " + val['precio']);
                            $('.submenucheck').append('<li class="liitemsc"><label id= "names">'+ val['nombre'] +'</label><br><label id="cant">'+ val['cantidad'] +'</label><label id = "prec">$ '+ val['precio']  +'</label>');
                            litotal += val['total'];
                        });
                        //.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
                        $('.submenucheck').append('<li class="litotalcarrito"><label><hr><strong>TOTAL: $ ' + litotal +' </strong></label></li>');
                        window.location = '#close';
                    }

                }
            });
        }
    });
});






/*
$(document).ready(function(){
    $('#agregaralcarro').click(function(evagregar){
        evagregar.preventDefault();
        var nombredelprod = $('#nombrep').html();
        //var marcadelprod = $('#marcaprod').html();
        //var presentaciondelprod = $('#listadepresentaciones').val();
        if($.trim(nombredelprod) == ""){
            $('#edoagregar').html("Datos erroneos");
            return;
        }
        else{
            $.ajax({
                beforeSend: function(){
                    $('#agregaralcarro').attr('disabled', true);
                    $('#agregaralcarro').html('Espere...');
                },
                url: 'agregaralcarrito.php',
                type: 'POST',
                data: {Nombre: nombredelprod, Marca: marcadelprod, Presentacion: presentaciondelprod},
                success: function(resaac){
                    $('#agregaralcarro').html('Agregar al carrito');
                    $('#agregaralcarro').attr('disabled', false);
                    var splitresp = resaac.split("&@&");
                    var resp = splitresp[0];
                    var json = splitresp[1];
                    var parsedjson = JSON.parse(json);
                    var cont = Object.keys(parsedjson).length;
                    if(resp == "ok"){
                        $('#edoagregar').fadeIn(500);
                        $('#edoagregar').html("Producto Agregado al Carrito");
                        setTimeout(function(){
                        $('#edoagregar').fadeOut(500);
                        },3000);
                        $('.itemsmenu').html('ITEMS ('+ cont +')');
                        $('.submenucheck').empty();
                        $.each(parsedjson, function(index, val){
                            $('.submenucheck').append('<li>'+ val['nombre'] + "   " + val['precio'] + '</li>');
                        });
                        window.location = '#close';
                    }

                }
            });
        }
    });
});


*/

function buscarporMarca(id){
    var marca = $.trim(id.substring(1));
    if($.trim(marca) == ""){
        alert("Error");
        return;
    }
    else{
        $.ajax({
            url: 'busqueda.php',
            type: 'POST',
            data: {idmarca: marca, tipo: "1"},
            success: function(resbm){
                console.log(resbm);
                if(resbm == "error"){
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<label class="etiquetacategoria"><p>Sin Resultados<button onclick="eliminarFiltros()">X</button></p></label>');
                }
                else{
                    resbm = resbm.split("$%&");
                    var jsonproductos = JSON.parse(resbm[1]);
                    var nombredelprod;
                    var marcadelprod;
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<label class="etiquetacategoria"><p>Marca: ' + resbm[0]+ '<button onclick="eliminarFiltros()">X</button></p></label>');
                    $.each(jsonproductos, function(index, val){
                        if(typeof(nombredelprod) != 'undefined'){
                            if(nombredelprod == val['productName'] && marcadelprod == val['brandName']) return true;
                        }
$('#catalogodeproductos').append('<div class="proditem"><div class="photo"><a href="#productoCL" id="' + val['productID'] +'" onclick="datosDeProducto(this.id)"><img src="' + val['img'] + '" class="prodimg"><div class="overlay"><span id="plus">+</span></div></div></a><label class="precios">$ '+ val['price'] +'</label><label class="nombreP1">' + val['productName'] +'</label><label class="nombreP">' + val['brandName'] + '</label></div>');						nombredelprod = val['productName'];
                        marcadelprod = val['brandName'];

                    });
                }
            }
        });
    }
}

function buscarporCategoria(id){
    var categoria = $.trim(id.substring(1));
    if($.trim(categoria) == ""){
        alert("Error");
        return;
    }
    else{
        $.ajax({
            url: 'busqueda.php',
            type: 'POST',
            data: {idcategoria: categoria, tipo: "2"},
            success: function(resbm){
                if(resbm == "error"){
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<div class="three columns"><label class="noresult">Sin resultados</div></div>')
                }
                else{
                    resbm = resbm.split("$%&");
                    var jsonproductos = JSON.parse(resbm[1]);
                    var nombredelprod;
                    var marcadelprod;
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<label class="etiquetacategoria"><p>Categor&iacute;a: ' + resbm[0]+ '<button onclick="eliminarFiltros()">X</button></p></label>');
                    $.each(jsonproductos, function(index, val){
                        if(typeof(nombredelprod) != 'undefined'){
                            if(nombredelprod == val['productName'] && marcadelprod == val['brandName']) return true;
                        }
$('#catalogodeproductos').append('<div class="proditem"><div class="photo"><a href="#productoCL" id="' + val['productID'] +'" onclick="datosDeProducto(this.id)"><img src="' + val['img'] + '" class="prodimg"><div class="overlay"><span id="plus">+</span></div></div></a><label class="precios">$ '+ val['price'] +'</label><label class="nombreP1">' + val['productName'] +'</label><label class="nombreP">' + val['brandName'] + '</label></div>');						nombredelprod = val['productName'];
                        marcadelprod = val['brandName'];
                    });
                }
            }
        });
    }
}

function buscarporPresentacion(id){
    var presentacion = $.trim(id.substring(1));
    if($.trim(presentacion) == ""){
        alert("Error");
        return;
    }
    else{
        $.ajax({
            url: 'busqueda.php',
            type: 'POST',
            data: {idpresentacion: presentacion, tipo: "3"},
            success: function(resbm){
                if(resbm == "error"){
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<div class="three columns"><label class="noresult">Sin resultados</label></div></div>')
                }
                else{
                    resbm = resbm.split("$%&");
                    var jsonproductos = JSON.parse(resbm[1]);
                    var nombredelprod;
                    var marcadelprod;
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<label class="etiquetacategoria"><p>Presentaci&oacute;n: ' + resbm[0]+ '<button onclick="eliminarFiltros()">X</button></p></label>');
                    $.each(jsonproductos, function(index, val){
                        if(typeof(nombredelprod) != 'undefined'){
                            if(nombredelprod == val['productName'] && marcadelprod == val['brandName']) return true;
                        }
$('#catalogodeproductos').append('<div class="proditem"><div class="photo"><a href="#productoCL" id="' + val['productID'] +'" onclick="datosDeProducto(this.id)"><img src="' + val['img'] + '" class="prodimg"><div class="overlay"><span id="plus">+</span></div></div></a><label class="precios">$ '+ val['price'] +'</label><label class="nombreP1">' + val['productName'] +'</label><label class="nombreP">' + val['brandName'] + '</label></div>');						nombredelprod = val['productName'];
                        marcadelprod = val['brandName'];
                    });
                }
            }
        });
    }
}


/* Eliminar Filtros */
function eliminarFiltros(){
        $.ajax({
            url: 'busqueda.php',
            type: 'POST',
            data: {tipo: "5"},
            success: function(resbm){
                if(resbm == "error"){
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<div class="three columns"><label class="noresult">Sin resultados</label></div></div>')
                }
                else{
                    resbm = resbm.split("$%&");
                    var jsonproductos = JSON.parse(resbm[1]);
                    var nombredelprod;
                    var marcadelprod;
                    $('#catalogodeproductos').empty();
                    //$('#catalogodeproductos').append('<div class="thirteen columns"><label class="etiquetacategoria">Presentaci&oacute;n: ' + resbm[0]+ '<button>X</button></label></div>');
                    $.each(jsonproductos, function(index, val){
                        if(typeof(nombredelprod) != 'undefined'){
                            if(nombredelprod == val['productName'] && marcadelprod == val['brandName']) return true;
                        }
$('#catalogodeproductos').append('<div class="proditem"><div class="photo"><a href="#productoCL" id="' + val['productID'] +'" onclick="datosDeProducto(this.id)"><img src="' + val['img'] + '" class="prodimg"><div class="overlay"><span id="plus">+</span></div></div></a><label class="precios">$ '+ val['price'] +'</label><label class="nombreP1">' + val['productName'] +'</label><label class="nombreP">' + val['brandName'] + '</label></div>');						nombredelprod = val['productName'];
                        marcadelprod = val['brandName'];
                    });
                }
            }
        });
}

/*Fin eliminar filtros */

function buscar(ev, txt){
    ev.preventDefault();
    var busqueda = $.trim(txt);
    if($.trim(busqueda) == ""){
        alert("Error");
        return;
    }
    else{
        $.ajax({
            url: 'busqueda.php',
            type: 'POST',
            data: {busqueda: busqueda, tipo: "4"},
            success: function(resbm){
                if(resbm == "error"){
                    $('#catalogodeproductos').empty();
                     $('#catalogodeproductos').append('<label class="etiquetacategoria"><p>Sin Resultados<button onclick="eliminarFiltros()">X</button></p></label>');
                }
                else{
                    resbm = resbm.split("$%&");
                    var jsonproductos = JSON.parse(resbm[1]);
                    var nombredelprod;
                    var marcadelprod;
                    $('#catalogodeproductos').empty();
                    $('#catalogodeproductos').append('<label class="etiquetacategoria"><p>Nombre: ' + resbm[0]+ '<button>X</button></p></label>');
                    $.each(jsonproductos, function(index, val){
                        if(typeof(nombredelprod) != 'undefined'){
                            if(nombredelprod == val['productName'] && marcadelprod == val['brandName']) return true;
                        }
                        $('#catalogodeproductos').append('<div class="proditem"><div class="photo"><a href="#productoCL" id="' + val['productID'] +'" onclick="datosDeProducto(this.id)"><img src="' + val['img'] + '" class="prodimg"><div class="overlay"><span id="plus">+</span></div></div></a><label class="precios">$ '+ val['price'] +'</label><label class="nombreP1">' + val['productName'] +'</label><label class="nombreP">' + val['brandName'] + '</label></div>');
                        nombredelprod = val['productName'];
                        marcadelprod = val['brandName'];+'</div>'
                    });
                }
            }
        });
    }
}


function infoDeProductos(ev, pagactual){
    ev.preventDefault();
    pagac = $.trim(pagactual);
    if(pagac == "")
       return;
    else{
        $.ajax({
            url: 'cliente/jsonproductos.php',
            type: 'POST',
            data: {Actual: pagac},
            success: function(respinfo){
                var jsonprods = JSON.parse(respinfo);
                var nombredelprod;
                var marcadelprod;
                $('#productoscasal').empty();
                $.each(jsonprods, function(index, val){
                    if(typeof(nombredelprod) != 'undefined'){
                        if(nombredelprod == val['productName'] && marcadelprod == val['brandName']) return true;
                    }
                    $('#productoscasal').append('<div class="proditem"><div class="photo"><a href="#productoCL" onclick="datosDeProducto(this.id)" id="'+ val['id'] +'"><img src="'+ val['img'] +'" class="prodimg"><div class="overlay"><span id="plus">+</span></div></div></a><label class="precios">$ '+ val['price'] +'</label><label class="nombreP1">'+ val['productName'] +'</label><label class="nombreP">'+ val['brandName'] +'</label></div>');
                    nombredelprod = val['productName'];
                    marcadelprod = val['brandName'];
                });
            }
        })

    }
}


$(document).ready(function(){
    $('.lismenucheck').click(function(){
    $('.submenucheck').slideToggle(200);
    });
});
