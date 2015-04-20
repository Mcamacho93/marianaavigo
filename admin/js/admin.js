function validateEmail(email){
    var filter = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!filter.test(email))
        return false;
    else
        return true;
}

function validadecimal(ev) {
            var Event = ev || window.event;
        var key = Event.keyCode || Event.which;
        key = String.fromCharCode( key );
        var permitidos = /[0-9]|\./;
        if( !permitidos.test(key) ) {
             Event.returnValue = false;
             if(Event.preventDefault) Event.preventDefault();
    }
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


function cuenta(){
        document.getElementById("contadorpalabras").innerHTML = document.getElementById("descripcion").value.length + "/500";
}

function agregarPresentacion(evp, nombre){
    evp.preventDefault();
    if($.trim(this.nombre) == ""){
        $('#estadoPres').html("El campo es obligatorio");
        $('#estadoPres').fadeIn(500);
        setTimeout(function(){
            $('#estadoPres').fadeOut(500);
        },3000);
        return;
    }
    else{
        $.ajax({
            beforeSend: function(){
                $('#nuevaPres').attr('disabled', true);
                $('#nuevaPres').html("Agregando...");
            },
            url: 'agregar.php',
            type: 'POST',
            data: {Nombre: nombre, tipo:"1"},
            success: function(resPres){
                $('#nuevaPres').attr('disabled', false);
                $('#nuevaPres').html("Agregar");
                if(resPres === "errorc"){
                    console.log(resPres);
                    $('#estadoPres').fadeIn(500);
                    $('#estadoPres').html("Ya existe esa presentación");
                    setTimeout(function(){
                        $('#estadoPres').fadeOut(500)
                    },3000);
                }
                else{
                    var jsonpres = JSON.parse(resPres);
                    $('#presentacion').empty();
                    $.each(jsonpres, function(index, val){
                        $('#presentacion').append('<option value="'+ val['presentID'] +'">'+ val['presentName'] +'</option>');
                    });
                    window.location = "#close";
                }
            }
        })
    }
}

function agregarCategoria(evc, nombre){
    evc.preventDefault();
    if($.trim(nombre) == ""){
        $('#estadoCat').html("El campo es obligatorio");
        $('#estadoCat').fadeIn(500);
        setTimeout(function(){
            $('#estadoCat').fadeOut(500);
        },3000);
        return;
    }
    else{
        //var formCategoria = new FormData(document.getElementById('agregarProd'));
        var formCategoria = new FormData();
        formCategoria.append("tipo", 2);
        formCategoria.append("catNueva", nombre);
        formCategoria.append("imgCat", imgCat.files[0]);
        $.ajax({
            beforeSend: function(){
                $('#nuevaCategoria').attr('disabled', true);
                $('#nuevaCategoria').html("Agregando...");
            },
            url: 'agregar.php',
            type: 'POST',
            data: formCategoria,
            processData: false,
            contentType: false,
            success: function(resCat){
                console.log(resCat);
                $('#nuevaCategoria').attr('disabled', false);
                $('#nuevaCategoria').html("Agregar");
                if(resCat === "errorp"){
                    $('#estadoCat').fadeIn(500);
                    $('#estadoCat').html("Ya existe esa categoria");
                    setTimeout(function(){
                        $('#estadoCat').fadeOut(500)
                    },3000);
                }
                else{
                    var jsoncat = JSON.parse(resCat);
                    $('#categoria').empty();
                    $.each(jsoncat, function(index, val){
                        $('#categoria').append('<option value="'+ val['categoryID'] +'">'+ val['categoryName'] +'</option>');
                    });
                    window.location = "#close";
                }
            }
        })
    }
}

/*
function agregarCategoria(evc, nombre){
    evc.preventDefault();
    if($.trim(nombre) == ""){
        $('#estadoCat').html("El campo es obligatorio");
        $('#estadoCat').fadeIn(500);
        setTimeout(function(){
            $('#estadoCat').fadeOut(500);
        },3000);
        return;
    }
    else{
        var formCategoria = new formCategoria(document.getElementById('formCategoria'));
        formCategoria.append("tipo", 1);
        $.ajax({
            beforeSend: function(){
                $('#nuevaCategoria').attr('disabled', true);
                $('#nuevaCategoria').html("Agregando...");
            },
            url: 'agregar.php',
            type: 'POST',
            data: {Nombre: nombre, tipo:"2"},
            processData: false,
            contentType: false,
            success: function(resCat){
                $('#nuevaCategoria').attr('disabled', false);
                $('#nuevaCategoria').html("Agregar");
                if(resCat === "errorc"){
                    $('#estadoCat').fadeIn(500);
                    $('#estadoCat').html("Ya existe esa categoria");
                    setTimeout(function(){
                        $('#estadoCat').fadeOut(500)
                    },3000);
                }
                else{
                    var jsoncat = JSON.parse(resCat);
                    $('#categoria').empty();
                    $.each(jsoncat, function(index, val){
                        $('#categoria').append('<option value="'+ val['categoryID'] +'">'+ val['categoryName'] +'</option>');
                    });
                }
            }
        })
    }
}
*/



function agregarMarca(evm, nombre){
    evm.preventDefault();
    if($.trim(nombre) == ""){
        $('#estadoMarca').html("El campo es obligatorio");
        $('#estadoMarca').fadeIn(500);
        setTimeout(function(){
            $('#estadoMarca').fadeOut(500);
        },3000);
        return;
    }
    else{
        $.ajax({
            beforeSend: function(){
                $('#nuevaMarca').attr('disabled', true);
                $('#nuevaMarca').html("Agregando...");
            },
            url: 'agregar.php',
            type: 'POST',
            data: {Nombre: nombre, tipo:"3"},
            success: function(resMarca){
                $('#nuevaMarca').attr('disabled', false);
                $('#nuevaMarca').html("Agregar");
                if(resMarca === "errorm"){
                    $('#estadoMarca').fadeIn(500);
                    $('#estadoMarca').html("Ya existe esa marca");
                    setTimeout(function(){
                        $('#estadoMarca').fadeOut(500)
                    },3000);
                }
                else{
                    var jsonmarca = JSON.parse(resMarca);
                    $('#marca').empty();
                    $.each(jsonmarca, function(index, val){
                        $('#marca').append('<option value="'+ val['brandID'] +'">'+ val['brandName'] +'</option>');
                    });
                    window.location = "#close";
                }
            }
        })
    }
}

function agregarProducto(evap, nombre, descripcion, precio, presentacion, categoria, marca, cantidad, descantidad, img){
    evap.preventDefault();
    if($.trim(nombre) == "" || $.trim(descripcion) == "" || $.trim(precio) == "" || $.trim(presentacion) == "" || $.trim(categoria) == "" || $.trim(marca) == "" || $.trim(cantidad) == ""){
        $('#estadoProducto').html("Llene todos los campos");
        $('#estadoProducto').fadeIn(500);
        setTimeout(function(){
            $('#estadoProducto').fadeOut(500);
        },3000);
        return;
    }
    if($.trim(descripcion.length) > 500){
        $('#estadoProducto').html("La descripción no puede contener más de 500 caracteres");
        $('#estadoProducto').fadeIn(500);
        setTimeout(function(){
            $('#estadoProducto').fadeOut(500);
        },3000);
        return;
    }
    if($.trim(img) == ""){
        $('#estadoProducto').html("Tiene que agregar una imagen del producto");
        $('#estadoProducto').fadeIn(500);
        setTimeout(function(){
            $('#estadoProducto').fadeOut(500);
        },3000);
        return;
    }
    else{
        var peso = cantidad + " " + descantidad;
        var formProducto = new FormData(document.getElementById('agregarProd'));
        formProducto.append('peso', peso);
        $.ajax({
            url: 'agregar.php',
            type: 'POST',
            data: formProducto,
            processData: false,
            contentType: false,
            success: function(resNP){
                console.log(resNP);
                $('#estadoProducto').fadeIn(500);
                $('#estadoProducto').html(resNP);
                setTimeout(function(){
                    $('#estadoProducto').fadeOut(500);
                },5000);
            }
        });
    }

}


function validaImg(){
    var archivo = document.getElementById('img');
    imagen = archivo.files;
    $('#imgdisplay').html('<label>La imagen seleccionada tiene un peso de: ' + imagen[0].size/1000 +' Kb</label>');
    if(imagen[0].type.match("image.jpeg") || imagen[0].type.match("image.png")){
        if(imagen[0].size >500000){
            var tamano = imagen[0].size/1000;
            var diferencia = tamano-500;
            var excede = diferencia.toFixed(2);
            //$('#imgdisplay').html('<label>Solo archivos menores a 500Kb, la imagen seleccionada pesa '+ tamano  +' Kb, por tanto excede el limite por '+ excede + ' Kb </label>');
            $('#imgdisplay').html('<label>Solo archivos menores a 500Kb</label>');
            document.getElementById('img').value = "";
            return;
        }
        else{
            var lector = new FileReader();
            lector.onloadend = function(){
                $('#imgdisplay').html('<img class="prodicon" src="'+ lector.result +'" >');
            }
            lector.readAsDataURL(imagen[0]);
        }


    }
    else{
        $('#imgdisplay').html('<label>Formato de imagen no soportado, seleccione otra</label>');
        document.getElementById('img').value = "";
        return;
    }
}

function validaImgModal(){
    var archivo = document.getElementById('imgCat');
    imagen = archivo.files;
    $('#imgModalDisplay').html('<label>La imagen seleccionada tiene un peso de: ' + imagen[0].size/1000 +' Kb</label>');
    if(imagen[0].type.match("image.jpeg") || imagen[0].type.match("image.png")){
        if(imagen[0].size >500000){
            var tamano = imagen[0].size/1000;
            var diferencia = tamano-500;
            var excede = diferencia.toFixed(2);
            //$('#imgModalDisplay').html('<label>Solo archivos menores a 500Kb, la imagen seleccionada pesa '+ tamano  +' Kb, por tanto excede el limite por '+ excede + ' Kb </label>');
            $('#imgModalDisplay').html('<label>Solo archivos menores a 500Kb</label>');
            document.getElementById('imgCat').value = "";
            return;
        }
        else{
            var lector = new FileReader();
            lector.onloadend = function(){
                $('#imgModalDisplay').html('<img class="prodicon" src="'+ lector.result +'" >');
            }
            lector.readAsDataURL(imagen[0]);
        }


    }
    else{
        $('#imgModalDisplay').html('<label>Formato de imagen no soportado, seleccione otra</label>');
        document.getElementById('imgCat').value = "";
        return;
    }
}

function infoCte(idcte){
    var idct = idcte.substr(6);
    if($.trim(idcte) == "")
        return
    else{
        $.ajax({
            url: 'admincte.php',
            method: 'POST',
            data: {ID: idct, tipo: "1"},
            success: function(respinfo){
                console.log(respinfo);
                var parsed = JSON.parse(respinfo);
                $.each(parsed, function(index, val){
                    $('#formcte').attr('id', val['clientCode'])
                    $('#nombreCte').val(val['clientName']);
                    $('#correoCte').val(val['clientEmail']);
                });
            }
        });
    }
}

function cambiosCliente(evcte, id, nombre, correo){
    evcte.preventDefault();
    if($.trim(nombre) == "" || $.trim(correo) == ""){
        $('#edocte').html('No puede quedar ningun campo vacío');
        $('#edocte').fadeIn(500);
        setTimeout(function(){
            $('#edocte').fadeOut(500)
        },3000);
    }
    else{
        $.ajax({
            url: 'admincte.php',
            type: 'POST',
            data: {Nombre: nombre, Correo:correo, Id: id, tipo: 2},
            success: function(respcc){
                var resp = respcc.split('#&@');
                if(resp[0] == "OK"){
                    console.log("0 -> " + resp[0]);
                    console.log("1 -> " + resp[1]);
                    $('#edocte').html('Cambios Guardados');
                    $('#edocte').fadeIn(500);
                    setTimeout(function(){
                        $('#edocte').fadeOut(500);
                    },3000);
                    var jsonctes = JSON.parse(respcc);
                    $('#listactes').empty();
                    $.each(jsonctes, function(index, val){
                        $('#listactes').append('<hr><div class="ten columns omega"><ul class="adminUsuarios"><li class="nombreus">'+ val['nombre'] +'</li><li class="correous">'+ val['email'] +'</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus"><a href="index.php" id="borrar'+ val['id'] + '" onclick="borrarCte(event,this.id)">BORRAR</a></li><li class="editarus"><a href="#modalEditar" id="editar' + val['id'] + '" onclick="infoCte(this.id)">EDITAR</a></li></ul></div>');
                    });
                    $('#listactes').append('<hr>');
                }
            }
        });
    }
}

function borrarCte(evborrar, id){
    evborrar.preventDefault();
    var id = $.trim(id.substr(6));
    if($.trim(id) == "")
        return;
    if(!confirm("¿Eliminar Cliente?"))
        return;
    else{
        $.ajax({
            url: 'admincte.php',
            type: 'POST',
            data: {Id: id, tipo: "3"},
            success: function(respborrar){
                console.log(respborrar);
                var resp = respborrar.split('#&@');
                if(resp[0] == "Error: 1451"){
                    alert("No puede eliminar, existen datos asociados a este cliente");
                    return;
                }
                if(resp[0] == "OK"){
                    alert("Eliminado");
                    var jsoncte = JSON.parse(resp[1]);
                    $('#cteadmin').empty();
                    $.each(jsoncte, function(index, val){
                        $('#cteadmin').append('<ul class="cliente"><div class="three columns alpha"><li>Nombre:' + val['clientName'] + '</li><li>Correo: ' + val['clientEmail'] + '</li></div><div class="three columns alpha"><a href="#modalEditar" id="editar' + val['clientCode'] +'" onclick="infoCte(this.id)"><li>Editar</li></a><br><a href=""><li id="borrar' + val['clientCode'] + '">Borrar</li></a></div></ul><hr>');
                    });
                }
            }
        });
    }
}

function infoAdmin(idadmin){
    var idadmin = idadmin.substr(8);
    if($.trim(idadmin) == "")
        return
    else{
        $.ajax({
            url: 'admincte.php',
            method: 'POST',
            data: {ID: idadmin, tipo: "4"},
            success: function(respinfo){
                console.log(respinfo);
                var parsed = JSON.parse(respinfo);
                $.each(parsed, function(index, val){
                    $('#formadmin').attr('id', val['adminID'])
                    $('#nombreAdmin').val(val['adminName']);
                    $('#correoAdmin').val(val['adminEmail']);
                    $('#telAdmin').val(val['adminPhone']);
                });
            }
        });
    }
}

function cambiosAdmin(evadmin, id, nombre, correo, telefono, rol){
    evadmin.preventDefault();
    if($.trim(nombre) == "" || $.trim(correo) == "" || $.trim(telefono) == "" || $.trim(rol) == ""){
        $('#edoadmin').html('No puede quedar ningun campo vacío');
        $('#edoadmin').fadeIn(500);
        setTimeout(function(){
            $('#edoadmin').fadeOut(500)
        },3000);
    }
    else{
        $.ajax({
            url: 'admincte.php',
            type: 'POST',
            data: {Nombre: nombre, Correo:correo, Id: id, Telefono: telefono, Rol: rol, tipo: "5"},
            success: function(respcc){
                var resp = respcc.split('#&@');
                if(resp[0] == "OK"){
                    $('#edoadmin').html('Cambios Guardados');
                    $('#edoadmin').fadeIn(500);
                    setTimeout(function(){
                        $('#edoadmin').fadeOut(500);
                    },3000);
                    var jsoncte = JSON.parse(resp[1]);
                    $('#admins').empty();
                    $.each(jsoncte, function(index, val){
                        $('#admins').append('<ul class="cliente"><div class="three columns alpha"><li>Nombre:' + val['adminName'] + '</li><li>Correo: ' + val['adminEmail'] + '</li></div><div class="three columns alpha"><a href="#modalEditarAdmin" id="editarad' + val['adminID'] +'" onclick="infoAdmin(this.id)"><li>Editar</li></a><br><a href=""><li id="borrarAdm' + val['adminID'] + '">Borrar</li></a></div></ul><hr>');
                    });
                }
            }
        });
    }
}

function borrarAdmin(evborrar, id){
    evborrar.preventDefault();
    var id = $.trim(id.substr(9));
    if($.trim(id) == "")
        return;
    if(!confirm("¿Eliminar Usuario?"))
        return;
    else{
        $.ajax({
            url: 'admincte.php',
            type: 'POST',
            data: {Id: id, tipo: "6"},
            success: function(respborrar){
                console.log(respborrar);
                var resp = respborrar.split('#&@');
                if(resp[0] == "Error: 1451"){
                    alert("No puede eliminar, existen datos asociados a este usuario");
                    return;
                }
                if(resp[0] == "OK"){
                    alert("Eliminado");
                    var jsonadmin = JSON.parse(resp[1]);
                    $('#admins').empty();
                    $.each(jsonadmin, function(index, val){
                        $('#admins').append('<ul class="cliente"><div class="three columns alpha"><li>Nombre:' + val['adminName'] + '</li><li>Correo: ' + val['adminEmail'] + '</li></div><div class="three columns alpha"><a href="#modalEditarAdmin" id="editarad' + val['adminID'] +'" onclick="infoAdmin(this.id)"><li>Editar</li></a><br><a href=""><li id="borrarAdm' + val['adminID'] + '">Borrar</li></a></div></ul><hr>');
                    });
                }
            }
        });
    }
}

function autorizarPedidoIndex(evap, id){
    evap.preventDefault();
    var idp = $.trim(id.substr(3));
    if(idp == "" || idp == undefined)
        return;
    if(!confirm("¿Autorizar?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, tipo: "1"},
            success: function(respap){
                console.log(respap);
                var resarray = respap.split('#&@');
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                        var li = "";
                        var nombre = val['nombre'];
                        var preciounitario = val['preciounit'];
                        var presentacion = val['presentacion'];
                        var unidades = val['unidades'];
                        //alert(nombre.length);
                        for(i in nombre){
                            //alert(unidades [i]);
                            li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                            li += "<li><div class='three columns omega'>"+ nombre[i] +"</div></li>";
                            li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                            li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                        }
                        var numeropedido = val['id'];
                        var numceros = 7-numeropedido.length;
                        var i = 0;
                        var cadceros = "";
                        while(i<numceros){
                            cadceros += "0";
                            i++;
                        }
                        var folioDelPedido = cadceros + numeropedido;

                        var fechahora = val['orderDate'].split(" ");
                        var fechaPedido = fechahora[0];
                        var horaPedido = fechahora[1];

                        $('#todoslospedidos').append('<div class="itemss"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span></h2><hr></div><div class="listapedido"><div class="seven columns offset-by-one omega">' + li +'</div> <div class="three columns omega"><label>TOTAL: $'+ val['totalapagar'] +'</label><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoIndex(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estado'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div><br>');

                    });
                    $('#todoslospedidos').find('.triglista').click(function(){
                        $(this).parent().next().slideToggle(200);
                    });
                }
            }

        })
    }
}


function autorizarPedidoIndex(evap, id){
    evap.preventDefault();
    var idp = $.trim(id.substr(3));
    if(idp == "" || idp == undefined)
        return;
    if(!confirm("¿Autorizar?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, tipo: "1"},
            success: function(respap){
                console.log(respap);
                var resarray = respap.split('#&@');
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                    var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    $('#todoslospedidos').append('<div class="itemss"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span></h2><hr></div><div class="listapedido"><div class="seven columns offset-by-one omega">' + li +'</div> <div class="three columns omega"><label>TOTAL: $'+ val['totalapagar'] +'</label><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoIndex(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estado'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div><br>');

                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }
            }

        })
    }
}
/*
function enviarPedido(evep, id){
    evep.preventDefault();
    var idp = $.trim(id.substr(3));
    if(idp == "" || idp == undefined)
        return;
    if(!confirm("¿Enviar Pedido?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, tipo: "2"},
            success: function(respep){
                console.log(respep);
                var resarray = respep.split('#&@');
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                    $.each(json, function(index, val){
                        var li = "";
                        var nombre = val['nombre'];
                        var preciounitario = val['preciounit'];
                        var presentacion = val['presentacion'];
                        var unidades = val['unidades'];
                        //alert(nombre.length);
                        for(i in nombre){
                            //alert(unidades [i]);
                            li += "<hr><ul class='detallesdepedido'><li>"+ unidades[i] +"</li>";
                            li += "<li>"+ nombre[i] +"</li>";
                            li += "<li>"+ presentacion[i] +"</li>";
                            li += "<li>$ "+ preciounitario[i] +"</li></ul>";
                        }
                            //alert(li);
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2>PEDIDO NO. '+ val['id'] +' </h2><hr></div><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button id="aut'+ val['id'] +'" onclick="autorizarPedido(event, this.id)">AUTORIZAR PEDIDO</button><br><button id="env'+ val['id'] +'" onclick="enviarPedido(event, this.id)">ENVIAR PEDIDO</button><br><button id="rec'+ val['id'] +'" onclick="rechazarPedido(event, this.id)">RECHAZAR PEDIDO</button></div></div></div><br>');

                    });
                }
            }

        })
    }
}*/

function rechazarPedido(evrp, id, texto){
    evrp.preventDefault();
    var idp = $.trim(id.substr(3));
    if($.trim(texto) == ""){
        $('#estadoRechazado').html("Indique el motivo por el que rechaza el pedido");
        $('#estadoRechazado').fadeIn(500);
        setTimeout(function(){
            $('#estadoRechazado').fadeOut(500);
        }, 3000);
        return;
    }
    if(idp == "" || idp == undefined)
        return;
    if(!confirm("¿Rechazar Pedido?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, Motivo: texto, tipo: "3"},
            success: function(resprp){
                console.log(resprp);
                var resarray = resprp.split('#&@');
                if(resarray[0] == "OK"){
                    window.location = "#close";
                    $('#estadoRechazado').fadeIn(500);
                    setTimeout(function(){
                        $('#estadoRechazado').fadeOut(500);
                    }, 3000);
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                  var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button id="aut'+ val['id'] +'" onclick="autorizarPedido(event, this.id)">AUTORIZAR PEDIDO</button><br><br><button id="rec'+ val['id'] +'" onclick="rechazarPedido(event, this.id)">RECHAZAR PEDIDO</button></div></div></div></div><br>');
                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }
            }

        })
    }
}

function rechazarPedido(evrp, id, texto){
    evrp.preventDefault();
    var idp = $.trim(id.substr(3));
    if($.trim(texto) == ""){
        $('#estadoRechazado').html("Indique el motivo por el que rechaza el pedido");
        $('#estadoRechazado').fadeIn(500);
        setTimeout(function(){
            $('#estadoRechazado').fadeOut(500);
        }, 3000);
        return;
    }
    if(idp == "" || idp == undefined)
        return;
    if(!confirm("¿Rechazar Pedido?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, Motivo: texto, tipo: "3"},
            success: function(resprp){
                console.log(resprp);
                var resarray = resprp.split('#&@');
                if(resarray[0] == "OK"){
                    window.location = "#close";
                    $('#estadoRechazado').fadeIn(500);
                    setTimeout(function(){
                        $('#estadoRechazado').fadeOut(500);
                    }, 3000);
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                  var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    $('#todoslospedidos').append('<div class="itemss"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span></h2><hr></div><div class="listapedido"><div class="seven columns offset-by-one omega">' + li +'</div> <div class="three columns omega"><label>TOTAL: $'+ val['totalapagar'] +'</label><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoIndex(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estado'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div><br>');
                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }
            }

        })
    }
}

function cambiarContrasena(evcc, canterior, cnueva, confirmarc){
    evcc.preventDefault();
    if($.trim(canterior) == "" || $.trim(cnueva) == "" || $.trim(confirmarc) == ""){
        $('#msgcc').fadeIn(500);
        $('#msgcc').html('No omita ningun campo');
        setTimeout(function(){
            $('#msgcc').fadeOut(500);
        },3000);
        return;
    }
    if($.trim(cnueva) != $.trim(confirmarc)){
        $('#msgcc').fadeIn(300);
        setTimeout(function(){
            $('#msgcc').fadeOut(300);
        },3000)
        $('#msgcc').html('Las contrase\u00f1as no coinciden');
    }
    if($.trim(cnueva.length) <= 6 || $.trim(confirmarc.length) <= 6){
        $('#msgcc').fadeIn(300);
        setTimeout(function(){
            $('#msgcc').fadeOut(300);
        },3000)
        $('#msgcc').html('La contrase\u00f1a debe tener m\u00e1s de 6 caracteres');
        return;
    }
    else{
        $.ajax({
            beforeSend: function(){
                $('#msgcc').fadeOut(500);
                $('#cambiarCont').attr('disabled', true);
                $('#cambiarCont').html('Espere...');
            },
            url: 'cambiar.php',
            type:'POST',
            data: {ContAnterior: canterior, ContrasenaNueva: cnueva, tipo: "1"},
            success: function(rccon){
                $('#cambiarCont').attr('disabled', false);
                $('#cambiarCont').html('Cambiar Contraseña');
                if(rccon == "OK"){
                    document.getElementById('cambiarcont').reset();
                    $('#msgcc').fadeIn(500);
                    $('#msgcc').html('Contraseña cambiada con éxito');
                }
                else{
                    $('#msgcc').fadeIn(500);
                    $('#msgcc').html(rccon);
                }
            }
        })
    }
}


$(document).ready(function(){
    $('#cambiarcorreo').submit(function(eventcorreo){
        eventcorreo.preventDefault();
        var correoanterior = $('#correoanterior').val();
        var correonuevo = $('#nuevocorreo').val();
        var confirmarcorreo = $('#confirmarcorreo').val();
        if($.trim(correoanterior) == "" || $.trim(correonuevo) == "" || $.trim(confirmarcorreo)==""){
        $('#msgcco').fadeIn(500);
        $('#msgcco').html("No omita ningun campo");
        setTimeout(function(){
            $('#msgcco').fadeOut(500);
        },5000);
        return;
        }
        if(!validateEmail(correonuevo) || !validateEmail(confirmarcorreo)){
            $('#msgcco').fadeIn(500);
            $('#msgcco').html('El correo electrónico');
            setTimeout(function(){
                $('#msgcco').fadeOut(500);
            },5000);
            return;
        }
        if(correonuevo != confirmarcorreo){
            $('#msgcco').fadeIn(500);
            $('#msgcco').html('Los correos no coinciden, revise la información proporcionada');
            setTimeout(function(){
                $('#msgcco').fadeOut(500);
            },5000);
            return;
        }
        else{
            $.ajax({
                beforeSend: function(){
                    $('#cambiarCorreoE').attr('disabled', true);
                    $('#cambiarCorreoE').html('Espere...');
                },
                url: 'cambiar.php',
                type: 'POST',
                data: {correoAnterior:correoanterior, correoNuevo: correonuevo, tipo: "2"},
                success: function(rescamcor){
                    console.log(rescamcor);
                    $('#cambiarCorreoE').attr('disabled', false);
                    $('#cambiarCorreoE').html('Cambiar Correo');
                    if(rescamcor == "OK"){
                        document.getElementById('cambiarcorreo').reset();
                        $('#msgcco').fadeIn(500);
     					$('#msgcco').html('Correo cambiado con éxito');
                    }
                    else{
                        $('#msgcco').fadeIn(500);
     					$('#msgcco').html(rescamcor);
                    }

                }
            });
        }
    });
});

function infoDeCtes(pagactual){
    pagac = $.trim(pagactual);
    if(pagac == "")
       return;
    else{
        $.ajax({
            url: 'jsonctes.php',
            type: 'POST',
            data: {Actual: pagac},
            success: function(respinfo){
                var jsonctes = JSON.parse(respinfo);
                $('#listactes').empty();
                $.each(jsonctes, function(index, val){
                    $('#listactes').append('<hr><div class="ten columns omega"><ul class="adminUsuarios"><li class="nombreus">'+ val['nombre'] +'</li><li class="correous">'+ val['email'] +'</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus"><a href="index.php" id="borrar'+ val['id'] + '" onclick="borrarCte(event,this.id)">BORRAR</a></li><li class="editarus"><a href="#modalEditar" id="editar' + val['id'] + '" onclick="infoCte(this.id)">EDITAR</a></li></ul></div>');
                });
                $('#listactes').append('<hr>');
            }
        })

    }
}

function infoDeAdmin(pagactual){
    pagac = $.trim(pagactual);
    if(pagac == "")
       return;
    else{
        $.ajax({
            url: 'jsonadmin.php',
            type: 'POST',
            data: {Actual: pagac},
            success: function(respinfo){
                var jsonadmin = JSON.parse(respinfo);
                $('#listactes').empty();
                $.each(jsonadmin, function(index, val){
                    $('#listactes').append('<hr><div class="ten columns omega"><ul class="adminUsuarios"><li class="nombreus">'+ val['nombre'] +'</li><li class="correous">'+ val['email'] +'</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus">EDITAR</li><li class="editarus">ELIMINAR</li></ul></div>');
                });
                $('#listactes').append('<hr>');
            }
        })

    }
}

function buscarCtes(cadena){
        $.ajax({
            url: 'buscarus.php',
            type: 'POST',
            data: {Cadena: cadena, tipo: "1"},
            success: function(respct){
                var json = JSON.parse(respct);
                $('#listactes').empty();
                $.each(json, function(index, val){
                    $('#listactes').append('<hr><div class="ten columns omega"><ul class="adminUsuarios"><li class="nombreus">'+ val['nombre'] +'</li><li class="correous">'+ val['email'] +'</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus">EDITAR</li><li class="editarus">ELIMINAR</li></ul></div>');
                });
                $('#listactes').append('<hr>');
            }
        });

}

function buscarAdmin(cadena){
        $.ajax({
            url: 'buscarus.php',
            type: 'POST',
            data: {Cadena: cadena, tipo: "2"},
            success: function(respct){
                var json = JSON.parse(respct);
                $('#listactes').empty();
                $.each(json, function(index, val){
                    $('#listactes').append('<hr><div class="ten columns omega"><ul class="adminUsuarios"><li class="nombreus">'+ val['nombre'] +'</li><li class="correous">'+ val['email'] +'</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus">EDITAR</li><li class="editarus">ELIMINAR</li></ul></div>');
                });
                $('#listactes').append('<hr>');
            }
        });

}

function filtrarPedidos(val){
    if($.trim(val) == "")
        return;
    else{
        $.ajax({
            url: 'jsonfiltropedidos.php',
            type: 'POST',
            data:{ID: val, tipo:"1"},
            success: function(resFP){
                console.log(resFP);
                var resarray = resFP.split('#&@');
                console.log(resarray[0]);
                console.log(resarray[1]);
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                    var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    if (val['estado'] == "Enviado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br> <br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');


                    else if (val['estado'] == "Cancelado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoIndex(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');

                    else if(val['estado'] == "Autorizado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><a href="#datosDeEnvio"><button class="full-width env" id="aut'+ val['id'] +'" onclick="obtenerInfoDatosDeEnvio(this.id)">ENVIAR PEDIDO <img src="../images/check.png"></button></a><br><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');


                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }
                else if(resFP == "NO"){
                    alert("SIN RESULTADOS");
                }
            }
        })
    }
}


function filtroPedidos(val){
    if($.trim(val) == "")
        return;
    else{
        $.ajax({
            url: 'jsonfiltropedidos.php',
            type: 'POST',
            data:{tipo: val},
            success: function(resFP){
                console.log(resFP);
                var resarray = resFP.split('#&@');
                console.log(resarray[0]);
                console.log(resarray[1]);
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                    var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    if (val['estado'] == "Enviado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br> <br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');


                    else if (val['estado'] == "Cancelado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoIndex(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');

                    else if(val['estado'] == "Autorizado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><a href="#datosDeEnvio"><button class="full-width env" id="aut'+ val['id'] +'" onclick="obtenerInfoDatosDeEnvio(this.id)">ENVIAR PEDIDO <img src="../images/check.png"></button></a><br><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');


                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }
                else if(resFP == "NO"){
                    alert("SIN RESULTADOS");
                }
            }
        })
    }
}


function buscarProducto(val){
    $.ajax({
        url: 'jsonproductos.php',
        type: 'POST',
        data: {Cadena: val, Tipo: "1"},
        success: function(resBP){
            var respslit = resBP.split("#&@");
            if(respslit[0] == "OK"){
                $('#listaDeProductos').empty();
                var json = JSON.parse(respslit[1]);
                $.each(json, function(index, val){
                    $('#listaDeProductos').append('<hr><div class="ten columns omega"><ul class="listadeproductostabla"><li><img src="../' + val['img'] + '"></li><li class="aguacate">' + val['productName'] +' </li><br><li class="descripciondelproductodelalista">' + val['categoryName'] + '</li><li class="descripciondelproductodelalista">' + val['brandName'] + '</li><li class="descripciondelproductodelalista">' + val['presentName'] + '</li><li class="descripciondelproductodelalista">' + val['existencia'] + '</li><li class="descripciondelproductodelalista">$ ' + val['price'] + '</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus"><a href="index.php" id="borrar' + val['clientCode'] + '" onclick="borrarCte(event,this.id)">BORRAR</a></li><li class="editarus"><a href="#modalEditar" id="editar' + val['clientCode'] + '" onclick="infoProd(this.id)">EDITAR</a></li></ul></div>');
                });
            }
            else if(respslit[0] == "NO"){
                $('#listaDeProductos').empty();
                $('#listaDeProductos').append('<hr><h3>SIN RESULTADOS</h3>');
            }

        }
    });
}

function infoProd(idp){
    var idp = $.trim(idp.substr(6));
    if(idp == "")
        return;
    else{
        $.ajax({
            url: 'jsonproductos.php',
            type: 'POST',
            data: {ID: idp, Tipo: "2"},
            success: function(respIP){
                var resplit = respIP.split("#&@");
                if(resplit[0] == "OK"){
                    var json = JSON.parse(resplit[1]);
                    console.log(json);
                    $.each(json, function(index, val){
                        $('#form').attr('id', "form" + val['id']);
                        $('#nombreProducto').val(val['productName']);
                        $('#descripcionProducto').val(val['productDesc']);
                        $('#precioProducto').val(val['price']);
                        $('#existenciaProducto').val(val['existencia']);
                    });
                }
                else if(resplit[0] == "NO"){
                    alert("Ha ocurrido un error al recuperar los datos del producto");
                    window.location = "#close";
                }
            }
        });
    }
}

function cambiosProducto(ev, id, nombre, descripcion, precio, presentacion, categoria, marca, existencia){
    ev.preventDefault();
    var id = $.trim(id.substr(4)); //filtramos el id, la cadena que se recibe es 'form' + id, con substr eliminamos ese 'form' para dejar solo el   id
    if($.trim(nombre) == "" || $.trim(descripcion) == "" || $.trim(precio) == "" || $.trim(presentacion) == "" || $.trim(categoria) == "" || $.trim(marca) == "" || $.trim(existencia) == ""){
        $('#edoprod').html("Llene todos los campos");
        $('#edoprod').fadeIn(500);
        setTimeout(function(){
            $('#edoprod').fadeOut(500);
        });
        return;
    }
    else{
        $.ajax({
            url: 'cbProductos.php',
            type: 'POST',
            data: {ID: id, Nombre: nombre, Descripcion: descripcion, Precio: precio, Presentacion: presentacion, Categoria: categoria, Marca: marca, Existencia: existencia, Tipo: "1"},
            success: function(respCP){
                console.log(respCP);
                var resplit = respCP.split("#&@");
                if(resplit[0] == "OK"){
                    var json = JSON.parse(resplit[1]);
                    $('#edoprod').html("Cambios Guardados");
                    $('#edoprod').fadeIn(500);
                    setTimeout(function(){
                        $('#edoprod').fadeOut(500);
                    });
                    $('#listaDeProductos').empty();
                    $.each(json, function(index, val){
                        $('#listaDeProductos').append('<hr><div class="ten columns omega"><ul class="listadeproductostabla"><li><img src="../' + val['img'] + '"></li><li class="aguacate">' + val['productName'] +' </li><br><li class="descripciondelproductodelalista">' + val['categoryName'] + '</li><li class="descripciondelproductodelalista">' + val['brandName'] + '</li><li class="descripciondelproductodelalista">' + val['presentName'] + '</li><li class="descripciondelproductodelalista">' + val['existencia'] + '</li><li class="descripciondelproductodelalista">$ ' + val['price'] + '</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus"><a href="index.php" id="borrar' + val['id'] + '" onclick="borrarCte(event,this.id)">BORRAR</a></li><li class="editarus"><a href="#modalEditar" id="editar' + val['id'] + '" onclick="infoProd(this.id)">EDITAR</a></li></ul></div>');
                    });
                }
                else if(resplit[0] == "NO"){
                    $('#edoprod').html("Ha ocurrido un error");
                    $('#edoprod').fadeIn(500);
                    setTimeout(function(){
                        $('#edoprod').fadeOut(500);
                    });
                }
                else if(resplit[0] == "error"){
                    $('#edoprod').html("Ya existe un producto asi");
                    $('#edoprod').fadeIn(500);
                    setTimeout(function(){
                        $('#edoprod').fadeOut(500);
                    });
                }
            }
        });
    }
}

function borrarProducto(ev, id){
    ev.preventDefault();
    var id = $.trim(id.substr(6));
    if(id == "")
        return;
    if(!confirm("¿Desea eliminar este producto?"))
        return;
    else{
        $.ajax({
            url: 'cbProductos.php',
            type: 'POST',
            data: {ID: id, Tipo: "2"},
            success: function(respBP){
                 var resplit = respBP.split("#&@");
                if(resplit[0] == "OK"){
                    var json = JSON.parse(resplit[1]);
                    $('#listaDeProductos').fadeOut(10);
                    $('#listaDeProductos').empty();
                    $.each(json, function(index, val){
                        $('#listaDeProductos').append('<hr><div class="ten columns omega"><ul class="listadeproductostabla"><li><img src="../' + val['img'] + '"></li><li class="aguacate">' + val['productName'] +' </li><br><li class="descripciondelproductodelalista">' + val['categoryName'] + '</li><li class="descripciondelproductodelalista">' + val['brandName'] + '</li><li class="descripciondelproductodelalista">' + val['presentName'] + '</li><li class="descripciondelproductodelalista">' + val['existencia'] + '</li><li class="descripciondelproductodelalista">$ ' + val['price'] + '</li></ul></div><div class="four columns omega"><ul class="adminUsuariosderecha"><li class="editarus"><a href="index.php" id="borrar' + val['id'] + '" onclick="borrarProducto(event,this.id)">BORRAR</a></li><li class="editarus"><a href="#modalEditar" id="editar' + val['id'] + '" onclick="infoProd(this.id)">EDITAR</a></li></ul></div>');
                    });
                    $('#listaDeProductos').fadeIn(500);
                }
            }
        });
    }

}

function autorizarPedidoHP(evap, id){
    evap.preventDefault();
    var idp = $.trim(id.substr(3));
    if(idp == "" || idp == undefined)
        return;
    if(!confirm("¿Autorizar?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, tipo: "4"},
            success: function(respap){
                //console.log(respap);
                var resarray = respap.split('#&@');
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                    //console.log("EL JSON: " + resarray[1]);
                $.each(json, function(index, val){
                    console.log("ESTADO: " + val['estado']);
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                    var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    if (val['estado'] == "Enviado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br> <br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');


                    else if (val['estado'] == "Cancelado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button class="full-width aut" id="aut'+ val['id'] +'" onclick="autorizarPedidoHP(event, this.id)">AUTORIZAR PEDIDO <img src="../images/check.png"></button><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');

                    else if(val['estado'] == "Autorizado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><a href="#datosDeEnvio"><button class="full-width env" id="aut'+ val['id'] +'" onclick="obtenerInfoDatosDeEnvio(this.id)">ENVIAR PEDIDO <img src="../images/check.png"></button></a><br><a href="#pedidoRechazado"><button class="full-width rech" id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO<img src="../images/x.png"></button></a><br><br><div class="cuadrogris"><label><strong>Direcci&oacute;n de env&iacute;o</strong><br>'+ val['calle'] +', No. '+ val['numero'] + '<br>'+ val['ciudad'] + ', '+ val['estadoorden'] + '<br> C.P. '+ val['codigopostal'] +' <br> Tel. '+ val['telefono'] +'  </label></div></div></div></div></div><br>');
                    else
                        console.log("NADA");

                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }

            }

        })
    }
}



function rechazarPedidoHP(evrp, id, texto){
    evrp.preventDefault();
    var idp = $.trim(id.substr(3));
    if(idp == "" || idp == undefined)
        return;
    if($.trim(texto) == ""){
        $('#estadoRechazado').html("Indique el motivo por el que rechaza el pedido");
        $('#estadoRechazado').fadeIn(500);
        setTimeout(function(){
            $('#estadoRechazado').fadeOut(500);
        }, 3000);
        return;
    }
    if(!confirm("¿Rechazar Pedido?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, Motivo: texto, tipo: "5"},
            success: function(resprp){
                console.log(resprp);
                var resarray = resprp.split('#&@');
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                  var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    if (val['estado'] == "Enviado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br></div></div></div></div><br>');
                    else if (val['estado'] == "Cancelado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button id="aut'+ val['id'] +'" onclick="autorizarPedidoHP(event, this.id)">AUTORIZAR PEDIDO</button></div></div></div></div><br>');
                    else if(val['estado'] == "Autorizado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button id="aut'+ val['id'] +'" onclick="enviarPedido(event, this.id)">ENVIAR PEDIDO</button><br><br><a href="#pedidoRechazado"><button id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO</button></a></div></div></div></div><br>');

                });
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }
            }

        })
    }
}


function enviarPedido(evrp, id){
    evrp.preventDefault();
    var idp = $.trim(id.substr(3));
    if(idp == "" || idp == undefined)
        return;
    if(!confirm("¿Enviar Pedido?"))
        return;
    else{
        $.ajax({
            url: 'adminpedidos.php',
            type: 'POST',
            data: {ID: idp, tipo: "2"},
            success: function(resprp){
               console.log(resprp);
                var resarray = resprp.split('#&@');
                if(resarray[0] == "OK"){
                    var json = JSON.parse(resarray[1]);
                    $('#todoslospedidos').empty();
                $.each(json, function(index, val){
                    var li = "";
                    var nombre = val['nombre'];
                    var preciounitario = val['preciounit'];
                    var presentacion = val['presentacion'];
                    var unidades = val['unidades'];
                    //alert(nombre.length);
                    for(i in nombre){
                        //alert(unidades [i]);
                        li += "<ul class='detallesdepedido'><li><div class='one column'>"+ unidades[i] +"</div></li>";
                        li += "<li><div class='six columns omega'>"+ nombre[i] +"</div></li>";
                        li += "<li><div class='one column'>"+ presentacion[i] +"</div></li>";
                        li += "<li><div class='two columns omega'>$ "+ preciounitario[i] +"</div></li></ul><hr>";
                    }
                  var numeropedido = val['id'];
                    var numceros = 7-numeropedido.length;
                    var i = 0;
                    var cadceros = "";
                    while(i<numceros){
                        cadceros += "0";
                        i++;
                    }
                    var folioDelPedido = cadceros + numeropedido;

                    var fechahora = val['orderDate'].split(" ");
                    var fechaPedido = fechahora[0];
                    var horaPedido = fechahora[1];

                    if (val['estado'] == "Enviado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br></div></div></div></div><br>');
                    else if (val['estado'] == "Cancelado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button id="aut'+ val['id'] +'" onclick="autorizarPedidoHP(event, this.id)">AUTORIZAR PEDIDO</button></div></div></div></div><br>');
                    else if(val['estado'] == "Autorizado")
                        $('#todoslospedidos').append('<div class="container"><div class="offset-by-one"><hr><h2 class="triglista"># '+ folioDelPedido +' <span class="pedidoCliente">'+ val['clientName'] +'</span><span class="pedidoFecha">'+ fechaPedido +'</span><span class="pedidoHora">'+ horaPedido +'</span><span class="pedidoCantidad">'+ val['productostotales'] +'</span><span class="pedidoMonto">$ '+ val['totalapagar'] +'</span><span class="pedidoColonia">'+ val['colonia'] +'</span><span class="pedidoEstatus">'+ val['estado'] +'</span></h2><hr></div><div class="listapedido"><div class="container"><div class="ten columns offset-by-two">' + li +'</div> <div class="four columns"><label>TOTAL: $'+ val['totalapagar'] +' <br><button id="aut'+ val['id'] +'" onclick="enviarPedido(event, this.id)">ENVIAR PEDIDO</button><br><br><a href="#pedidoRechazado"><button id="mpr'+ val['id'] +'" onclick="cambiaID(this.id)">RECHAZAR PEDIDO</button></a></div></div></div></div><br>');

                });
                window.location = "#close";
                $('#todoslospedidos').find('.triglista').click(function(){
                    $(this).parent().next().slideToggle(200);
                });
                }
            }

        })
    }
}

function cambiaID(id){
    var id = $.trim(id.substr(3));
    $('.ninguna').attr('id', 'rec' + id);
}

function obtenerInfoDatosDeEnvio(id){
    var id = $.trim(id.substr(3));
    $('.botonconclase').attr('id', 'env' + id);
    if(id == "")
        return;
    else{
        $.ajax({
            url:'jsonpedido.php',
            type: 'POST',
            data: {ID: id},
           success: function(respOIDE){
              console.log(respOIDE);
              var resplit = respOIDE.split("#&@");
              if(resplit[0] == "OK"){
                 var json = JSON.parse(resplit[1]);
                 console.log(json);
                  $('#calle').html("Calle: " + json['orderStreet']);
                  $('#colonia').html("Colonia: " + json['orderColony']);
                  $('#estado').html("Estado: " + json['stateName']);
                  $('#codigoPostal').html("Codigo Postal: " + json['orderZip']);
                  $('#telefono').html("Tel&eacute;fono: " + json['orderPhone']);
              }
           }
        })
    }
}

function nuevoAdmin(ev, nombre, correo, telefono, contrasena, confcontrasena, puesto){
    ev.preventDefault();
    if($.trim(nombre) == "" || $.trim(correo) == "" || $.trim(telefono) == "" || $.trim(contrasena) == "" || $.trim(confcontrasena) == ""){
        $('#edoagregaradmin').html("Llene todos los campos");
        $('#edoagregaradmin').fadeIn(500);
        setTimeout(function(){
            $('#edoagregaradmin').fadeOut(500);
        }, 3000);
        return;
    }
    if(contrasena.length < 7 || confcontrasena.length < 7){
        $('#edoagregaradmin').html("La contraseña debe contener más de 6 caracteres");
        $('#edoagregaradmin').fadeIn(500);
        setTimeout(function(){
            $('#edoagregaradmin').fadeOut(500);
        }, 3000);
        return;
    }
    if(contrasena != confcontrasena){
        $('#edoagregaradmin').html("Las contraseñas no coincideb");
        $('#edoagregaradmin').fadeIn(500);
        setTimeout(function(){
            $('#edoagregaradmin').fadeOut(500);
        }, 3000);
        return;
    }
    else{
        $.ajax({
            url: 'abcAdmin.php',
            type: 'POST',
            data: {Nombre: nombre, Correo: correo, Telefono: telefono, Contrasena: contrasena, Confcontrasena: confcontrasena, Puesto: puesto, tipo: "1"},
            success: function(resNA){
                console.log(resNA);
                var resplit = resNA.split('#&@');
                if(resplit[0] == "OK"){
                    window.location = "usuarios.php?administradores";
                }
                else if(resplit[0] == "error1"){
                    $('#edoagregaradmin').html("Ya existe un administrador registrado con ese correo");
                    $('#edoagregaradmin').fadeIn(500);
                    setTimeout(function(){
                        $('#edoagregaradmin').fadeOut(500);
                    }, 3000);
                }
            }
        })
    }
}

function infoAdministrador(id){
    var id = $.trim(id.substr(6));
    if(id == "")
        return;
    else{
        $.ajax({
            url: 'abcAdmin.php',
            type: 'POST',
            data: {ID: id, tipo: "2"},
            success: function(respIA){
                var resplit = respIA.split("#&@");
                if(resplit[0] == "OK"){
                    var json = JSON.parse(resplit[1]);
                    $('.modalEdicionAdmin').attr('id', json['adminID']);
                    $('#nombreAdminEditar').val(json['adminName']);
                    $('#correoAdminEditar').val(json['adminEmail']);
                    $('#telAdminEditar').val(json['adminPhone']);
                }
            }
        })
    }
}

function cambiosAdministrador(ev, id, nombre, correo, telefono){
    ev.preventDefault();
    if($.trim(id) == "" || $.trim(nombre) == "" || $.trim(correo) == "" || $.trim(telefono) == ""){
        $('#edoeditadmin').html("Llene todos los campos");
        $('#edoeditadmin').fadeIn(500);
        setTimeout(function(){
            $('#edoeditadmin').fadeOut(500);
        }, 3000);
        return;
    }
    else{
        $.ajax({
            url: 'abcAdmin.php',
            type: 'POST',
            data: {ID: id, Nombre: nombre, Correo: correo, Telefono: telefono, tipo: "3"},
            success: function (resCA){
                console.log(resCA);
                if(resCA == "OK"){
                    window.location = "usuarios.php?administradores";
                }

            }
        });
    }
}

function borrarAdministrador(ev, id){
    ev.preventDefault();
    var id = $.trim(id.substr(6));
    if(id == "")
        return;
    if(!confirm("¿Desea eliminar a este administrador?"))
        return;
    else{
        $.ajax({
            url: 'abcAdmin.php',
            type: 'POST',
            data: {ID: id, tipo: "4"},
            success: function(resBA){
            var resplit = resBA.split("#&@");
            if(resplit[0] == "OK"){
                window.location = "usuarios.php?administradores"
            }
        }
        })
    }
}
/*function mostrar(){
    $('#todoslospedidos').find('.triglista').click(function(){
        $(this).parent().next().slideToggle(200);
    });
}*/

