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

function agregarDir(evdf, desc, calle, num, col, del, edo, ciudad, cp, rfc, tel, telalt, email){
    evdf.preventDefault();
    if($.trim(desc)=="" || $.trim(rfc)==""){
        alert("Llene los campos marcados con *");
        return;
    }
    if($('#checkboxfacturacion').is(':checked')){
        if($.trim(desc)=="" || $.trim(calle)=="" || $.trim(col)=="" || $.trim(edo)=="" || $.trim(cp)=="" || $.trim(rfc)=="" ||$.trim(tel)==""){
            alert("Para usar la dirección como dirección de envío tiene que llenar todos los campos");
            return;
        }
        else{
            $.ajax({
                url:'nuevaDireccion.php',
                type: 'POST',
                data: {Descripcion: desc, Calle: calle, Numero: num, Colonia: col, Delegacion: del, Estado: edo, Ciudad: ciudad, CodigoPostal: cp, RFC: rfc, Tel: tel, TelAlterno: telalt, Email: email, Tipo: "3"},
                success: function(resDF){
                    console.log(resDF);
                    var splitresp = resDF.split("$%&");
                    console.log(splitresp[0]);
                    console.log(splitresp[1]);
                    console.log(splitresp[2]);
                    if(splitresp[0] == "OK"){
                        $('#estadodirfact').html("Dirección de factuación y envío agregadas");
                        $('#estadodirfact').fadeIn(500);
                        setTimeout(function(){
                            $('#estadodirfact').fadeOut(500);
                        }, 5000);
                        var jsondir = JSON.parse(splitresp[1]);
                        $('#direccionesDeFacturacion').empty();
                        $.each(jsondir, function(index, val){
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                            $('#direccionesDeFacturacion').append('<div class="cuenta2"><ul><li><a href="#editarModal" id="edit"><label onclick="editarDireccion(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+val['addressID']+'" onclick="eliminarDF(this.className)" id="">Eliminar</label></li></ul></div><hr>');
                        });

                        var jsondiren = JSON.parse(splitresp[2]);
                    $('#direccionesDeEnvio').empty();
                    $.each(jsondiren, function(index, val){
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                        $('#direccionesDeEnvio').append('<div class="cuenta2"><ul><li><a href="#editarDE"><label onclick="editarDireccionEn(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+ val['addressID'] +'" onclick="eliminarDE(this.className)" id="">Eliminar</label></li></ul></div><hr>');

                    });

                        document.getElementById('datosFacturacion').reset();
                        window.location = "#close";
                    }
                    else{
                        $('#estadodirfact').html("Ha ocurrido un error, inténtelo nuevamente");
                    }
                }
            });
        }
    }
    else if(!$('#checkboxfacturacion').is(':checked')){
        if(desc == "")
            desc = "No especificado";
        if(calle == "")
            calle = "No especificado";
        if(num == "")
            num = "0";
        if(col == "")
            col = "No especificado";
        if(del == "")
            del = "No especificado";
        if(edo == "")
            edo = "No especificado";
        if(ciudad == "")
            ciudad = "No especificado";
        if(cp == "")
            cp = "No especificado";
        if(rfc == "")
            rfc = "No especificado";
        if(tel == "")
            tel = "No especificado";
        if(telalt == "")
            telalt = "No especificado";
        if(email == "")
            email = "No especificado";
        $.ajax({
            url:'nuevaDireccion.php',
            type: 'POST',
            data: {Descripcion: desc, Calle: calle, Numero: num, Colonia: col, Delegacion: del, Estado: edo, Ciudad: ciudad, CodigoPostal: cp, RFC: rfc, Tel: tel, TelAlterno: telalt, Email: email, Tipo: "1"},
            success: function(resDF){
                console.log(resDF);
                var splitresp = resDF.split("$%&");
                console.log(splitresp[0]);
                console.log(splitresp[1]);
                if(splitresp[0] == "OK"){
                    $('#estadodirfact').html("Dirección de factuación agregada");
                    $('#estadodirfact').fadeIn(500);
                    setTimeout(function(){
                        $('#estadodirfact').fadeOut(500);
                    }, 5000);
                    var jsondir = JSON.parse(splitresp[1]);
                    $('#direccionesDeFacturacion').empty();
                    $.each(jsondir, function(index, val){
                        $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                        $('#direccionesDeFacturacion').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                        $('#direccionesDeFacturacion').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                        $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                        $('#direccionesDeFacturacion').append('<div class="cuenta2"><ul><li><a href="#editarModal" id="edit"><label onclick="editarDireccion(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+val['addressID']+'" onclick="eliminarDF(this.className)" id="">Eliminar</label></li></ul></div><hr>');
                    });
                    document.getElementById('datosFacturacion').reset();
                    window.location = "#close";
                }
                else{
                    $('#estadodirfact').html("Ha ocurrido un error, inténtelo nuevamente");
                }
            }
        });
    }
}



function agregarDirEn(evde, desc, calle, num, col, del, edo, ciudad, cp, tel, telalt, email){
    evde.preventDefault();
    if($.trim(desc)=="" || $.trim(calle)=="" || $.trim(col)=="" || $.trim(edo)=="" || $.trim(cp)=="" || $.trim(tel)==""){
        alert("Llene todos los campos");
        return;
    }
    else{
        $.ajax({
            url:'nuevaDireccion.php',
            type: 'POST',
            data: {Descripcion: desc, Calle: calle, Numero: num, Colonia: col, Delegacion: del, Estado: edo, Ciudad: ciudad, CodigoPostal: cp, Tel: tel, TelAlterno: telalt, Email: email, Tipo: "2"},
            success: function(resDE){
                console.log(resDE);
                var splitresp = resDE.split("$%&");
                console.log(splitresp[0]);
                console.log(splitresp[1]);
                if(splitresp[0] == "OK"){
                    $('#estadodirenvio').html("Dirección de envío agregada");
                    $('#estadodirenvio').fadeIn(500);
                    setTimeout(function(){
                        $('#estadodirenvio').fadeOut(500);
                    }, 5000);
                    var jsondir = JSON.parse(splitresp[1]);
                    $('#direccionesDeEnvio').empty();
                    $.each(jsondir, function(index, val){
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                        $('#direccionesDeEnvio').append('<div class="cuenta2"><ul><li><a href="#editarDE"><label onclick="editarDireccionEn(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+ val['addressID'] +'" onclick="eliminarDE(this.className)" id="">Eliminar</label></li></ul></div><hr>');

                    });
                    document.getElementById('datosDeEnvio').reset();
                    window.location = "#close";
                }
                else{
                    $('#estadodirenvio').html("Ha ocurrido un error, inténtelo nuevamente");
                }
            }
        });
    }
}

function editarDireccion(id){
    $.ajax({
        url: 'direccionInfo.php',
        type: 'POST',
        data: {ID: id},
        success: function(resEdit){
            console.log(resEdit);
            var dirinfo = JSON.parse(resEdit);
            $.each(dirinfo, function(index, val){
                $('#editarDesc').val(val['addressDesc']);
                $('#editarCalle').val(val['street']);
                $('#editarNumero').val(val['number']);
                $('#editarCol').val(val['colony']);
                $('#editarDel').val(val['delegation']);
                $('#editarCiudad').val(val['city']);
                $('#editarCp').val(val['zip']);
                $('#editarRFC').val(val['RFC']);
                $('#editarTel').val(val['addressPhone']);
                $('#editarTelAlt').val(val['addressPhone2']);
                $('#editarEmail').val(val['email']);
                $('#idDir').html(val['addressID']);
            });
        }
    });
}

function editarDireccionEn(id){
    $.ajax({
        url: 'direccionInfo.php',
        type: 'POST',
        data: {ID: id},
        success: function(resEdit){
            console.log(resEdit);
            var dirinfo = JSON.parse(resEdit);
            $.each(dirinfo, function(index, val){
                $('#editarDescE').val(val['addressDesc']);
                $('#editarCalleE').val(val['street']);
                $('#editarNumeroE').val(val['number']);
                $('#editarColE').val(val['colony']);
                $('#editarDelE').val(val['delegation']);
                $('#editarCiudadE').val(val['city']);
                $('#editarCpE').val(val['zip']);
                $('#editarTelE').val(val['addressPhone']);
                $('#editarTelAltE').val(val['addressPhone2']);
                $('#editarEmailE').val(val['email']);
                $('#idDirE').html(val['addressID']);
            });
        }
    });
}

//Para editar direcciones de facturación --Inicio--
$(document).ready(function(){
    $('#editarDir').submit(function(evcdf){
        evcdf.preventDefault();
        var desc = $('#editarDesc').val();
        var calle = $('#editarCalle').val();
        var numero = $('#editarNumero').val();
        var col = $('#editarCol').val();
        var delegacion = $('#editarDel').val();
        var ciudad = $('#editarCiudad').val();
        var edo = $('#editarEstado').val();
        var cp = $('#editarCp').val();
        var rfc = $('#editarRFC').val();
        var tel = $('#editarTel').val();
        var telalterno = $('#editarTelAlt').val();
        var email = $('#editarEmail').val();
        var iddir = $('#idDir').html();
        if($.trim(desc)=="" || $.trim(calle)=="" || $.trim(col)=="" || $.trim(edo)=="" || $.trim(cp)=="" || $.trim(rfc)=="" ||$.trim(tel)==""){
        alert("Llene todos los campos");
        return;
        }
        else{
            $.ajax({
                url:'editarDireccion.php',
                type: 'POST',
                data: {Descripcion: desc, Calle: calle, Numero: numero, Colonia: col, Delegacion: delegacion, Ciudad: ciudad, Estado: edo, CodigoPostal: cp, RFC: rfc, Tel: tel, TelAlterno: telalterno, Email: email, IDdir: iddir, Tipo: "1"},
                success: function(resCDF){
                    var splitresp = resCDF.split("$%&");
                    if(splitresp[0] == "OK"){
                        $('#estadoEditDF').html("Cambios Guardados");
                        $('#estadoEditDF').fadeIn(500);
                        setTimeout(function(){
                            $('#estadoEditDF').fadeOut(500);
                        }, 5000);
                        var jsondir = JSON.parse(splitresp[1]);
                        $('#direccionesDeFacturacion').empty();
                        $.each(jsondir, function(index, val){
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                            $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                            $('#direccionesDeFacturacion').append('<div class="cuenta2"><ul><li><a href="#editarModal" id="edit"><label onclick="editarDireccion(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+val['addressID']+'" onclick="eliminarDF(this.className)" id="">Eliminar</label></li></ul></div><hr>');
                        });
                        window.location = "#close";
                    }
                    else{
                        $('#estadoEditDF').html("Ha ocurrido un error, inténtelo nuevamente");
                    }
                }
            });
        }
    });
});
//-->Fin

//Para editar direcciones de Envío --Inicio--
$(document).ready(function(){
    $('#editarDirEn').submit(function(evcde){
        evcde.preventDefault();
        var desc = $('#editarDescE').val();
        var calle = $('#editarCalleE').val();
        var numero = $('#editarNumeroE').val();
        var col = $('#editarColE').val();
        var delegacion = $('#editarDelE').val();
        var ciudad = $('#editarCiudadE').val();
        var edo = $('#editarEstadoE').val();
        var cp = $('#editarCpE').val();
        var tel = $('#editarTelE').val();
        var telalterno = $('#editarTelAltE').val();
        var email = $('#editarEmailE').val();
        var iddir = $('#idDirE').html();
        if($.trim(desc)=="" || $.trim(calle)=="" || $.trim(col)=="" || $.trim(edo)=="" || $.trim(cp)=="" || $.trim(tel)==""){
        alert("Llene todos los campos");
        return;
        }
        else{
            $.ajax({
                url:'editarDireccion.php',
                type: 'POST',
                data: {Descripcion: desc, Calle: calle, Numero: numero, Colonia: col, Delegacion: delegacion, Ciudad: ciudad, Estado: edo, CodigoPostal: cp, Tel: tel, TelAlterno: telalterno, Email: email, IDdir: iddir, Tipo: "2"},
                success: function(resCDE){
                var splitresp = resCDE.split("$%&");
                if(splitresp[0] == "OK"){
                    $('#estadoEditEn').html("Dirección de envío agregada");
                    $('#estadoEditEn').fadeIn(500);
                    setTimeout(function(){
                        $('#estadoEditEn').fadeOut(500);
                    }, 5000);
                    var jsondir = JSON.parse(splitresp[1]);
                    $('#direccionesDeEnvio').empty();
                    $.each(jsondir, function(index, val){
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                        $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                        $('#direccionesDeEnvio').append('<div class="cuenta2"><ul><li><a href="#editarDE"><label onclick="editarDireccionEn(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+ val['addressID'] +'" onclick="eliminarDE(this.className)" id="">Eliminar</label></li></ul></div><hr>');

                    });
                    window.location = "#close";
                }
                else{
                    $('#estadoEditEn').html("Ha ocurrido un error, inténtelo nuevamente");
                }
                }
            });
        }
    });
});
//-->Fin

function eliminarDF(iddf){
    var opcion = confirm('¿Realmente desea eliminar esta direcci\u00f3n?');
    if(!opcion)
        return;
    else{
        $.ajax({
            url: 'eliminarDireccion.php',
            type: 'POST',
            data: {IDDF: iddf, tipo: "1"},
            success: function(resedf){
                console.log(resedf);
                var dirarray = JSON.parse(resedf);
                $('#direccionesDeFacturacion').empty();
                $.each(dirarray, function(index, val){
                    console.log("1er each" + val['addressDesc'] + val['street'] +  ',' + val['colony']);
                    $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                    $('#direccionesDeFacturacion').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                    $('#direccionesDeFacturacion').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                    $('#direccionesDeFacturacion').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                    $('#direccionesDeFacturacion').append('<div class="cuenta2"><ul><li><a href="#editarModal" id="edit"><label onclick="editarDireccion(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+val['addressID']+'" onclick="eliminarDF(this.className)" id="">Eliminar</label></li></ul></div><hr>');


                });

            }
        });
    }
}

function eliminarDE(idde){
    var opcion = confirm('¿Realmente desea eliminar esta direcci\u00f3n?');
    if(!opcion)
        return;
    else{
        $.ajax({
            url: 'eliminarDireccion.php',
            type: 'POST',
            data: {IDDF: idde, tipo: "2"},
            success: function(resede){
                var arraydir = JSON.parse(resede);
                $('#direccionesDeEnvio').empty();
                $.each(arraydir, function(index, val){
                    $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressDesc'] + '</label>');
                    $('#direccionesDeEnvio').append('<label class="nerd">' + val['street'] +  ',' + val['colony'] +'</label>');
                    $('#direccionesDeEnvio').append('<label class="nerd">' + val['zip'] + ' ' + val['stateName'] + '</label>');
                    $('#direccionesDeEnvio').append('<label class="nerd">' + val['addressPhone'] + '</label>');
                    $('#direccionesDeEnvio').append('<div class="cuenta2"><ul><li><a href="#editarDE"><label onclick="editarDireccionEn(this.id)" id="'+ val['addressID']+'">Editar</label></a></li><li><label class="'+ val['addressID'] +'" onclick="eliminarDE(this.className)" id="">Eliminar</label></li></ul></div><hr>');

                });

            }
        });
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


function preciounitario(pu){
    return this.pu;
}

function cantidad(c){
    return this.c;
}

function subtotalactual(sa){
    return this.sa
}

function subtotal(cantidad, id){
    if($.trim(cantidad) == ""){
        alert('Cantidad Inv\u00e1lida');
        return;
    }
    if(isNaN(cantidad)){
        alert('Cantidad Inv\u00e1lida');
        return;
    }
    else{
        $.ajax({
            url: 'modificarcarrito.php',
            type: 'POST',
            data: {Cantidad: cantidad, Id: id,tipo: "1"},
            success: function(ressubtotal){
                var resultado = ressubtotal.split("%&=");
                if(resultado[0] == "ok"){
                    $('#subtotal').html("$ " + resultado[1] + " MXN");
                }
                else if(resultado[0] == "excede"){
                    alert("No hay suficientes productos en existencia");
                    document.getElementById(resultado[2]).value = resultado[1];
                }
            }
        });
    }
}

function subtotalBtnMas(cantidad, id){
    cantidad++;
    if($.trim(cantidad) == ""){
        alert('Cantidad Inv\u00e1lida');
        return;
    }
    if(isNaN(cantidad)){
        alert('Cantidad Inv\u00e1lida NaN');
        return;
    }
    else{
        $.ajax({
            url: 'modificarcarrito.php',
            type: 'POST',
            data: {Cantidad: cantidad, Id: id,tipo: "1"},
            success: function(ressubtotal){
                var resultado = ressubtotal.split("%&=");
                if(resultado[0] == "ok"){
                    $('#subtotal').html("$ " + resultado[1] + " MXN");
                }
                else if(resultado[0] == "excede"){
                    alert("No hay suficientes productos en existencia");
                    document.getElementById(resultado[2]).value = resultado[1];
                }
            }
        });
    }
}

function subtotalBtnMenos(cantidad, id){
    cantidad--;
    if($.trim(cantidad) == ""){
        alert('Cantidad Inv\u00e1lida');
        return;
    }
    if(isNaN(cantidad)){
        alert('Cantidad Inv\u00e1lida');
        return;
    }
    else{
        $.ajax({
            url: 'modificarcarrito.php',
            type: 'POST',
            data: {Cantidad: cantidad, Id: id,tipo: "1"},
            success: function(ressubtotal){
                var resultado = ressubtotal.split("%&=");
                if(resultado[0] == "ok"){
                    $('#subtotal').html("$ " + resultado[1] + " MXN");
                }
                else if(resultado[0] == "excede"){
                    alert("No hay suficientes productos en existencia");
                    document.getElementById(resultado[2]).value = resultado[1];
                }
            }
        });
    }
}


function quitarDelCarrito(id){
    var idp = $.trim(id.substring(1));
    var confirmar = confirm("¿Desea eliminar este art\u00edculo del carrito");
    if(!confirmar)
        return;
    else{
        $.ajax({
            url: 'modificarcarrito.php',
            type: 'POST',
            data: {IDP: idp, tipo: "2"},
            success: function(resqdc){
                if(resqdc == "eliminado")
                    window.location = 'carrito.php';
                else
                    alert("Ha ocurrido un error");
            }
        });
    }
}


function ordenarAhora(dirid){
    var direnvio = $.trim(dirid.substring(1));
    if($.trim(dirid) == ""){
        alert("Error");
        return;
    }
    var confirmaror = confirm("¿Completar Orden?");
    if(!confirmaror)
        return;
    else{
        $.ajax({
            url: 'completarorden.php',
            type: 'POST',
            data: {iddir: direnvio},
            success: function(resoa){
                console.log(resoa);
                if(resoa == "ok"){
                    //$('#msgpedido').fadeIn(500);
                    //$('#msgpedido').html("Su pedido ha sido procesado, espere confirmaci\u00f3n");
                    alert("Su pedido ha sido procesado, espere confirmaci\u00f3n");
                    window.location = "index.php";
                }
                else{

                }
            }
        });
    }
}

function cambiaDireccionFacturacion(evf, id){
    evf.preventDefault();
    if($.trim(id) == "")
        return
    else{
        $.ajax({
            url: 'direccionpedido.php',
            type: 'POST',
            data: {idf: id, tipo: "1"},
            success: function(rescdf){
                var jsonfactuacion = JSON.parse(rescdf);
                $('#labfacturacion').html('DATOS DE FACTURACIÓN:<br>'+ jsonfactuacion['street'] +' <br>' + jsonfactuacion['zip'] + " " + jsonfactuacion['stateName'] + '  <br>' + jsonfactuacion['addressPhone'] + '</label>');
            }
        });
    }
}

function cambiaDireccionEnvio(eve, id){
    eve.preventDefault();
    if($.trim(id) == "")
        return
    else{
        $.ajax({
            url: 'direccionpedido.php',
            type: 'POST',
            data: {ide: id, tipo: "2"},
            success: function(rescde){
                var jsonenvio = JSON.parse(rescde);
                $('#labenvio').html('DATOS DE ENVÍO:<br>'+ jsonenvio['street'] +' <br>' + jsonenvio['zip'] + " " + jsonenvio['stateName'] + '  <br>' + jsonenvio['addressPhone'] + '</label>');
            }
        });
    }
}

function msgdedf(){
    $('#msgpedido').html('Por favor agregue sus datos de env&iacute;o y facturaci&oacute;n para poder realizar su orden de compra');
    $('#msgpedido').fadeIn(500);
    setTimeout(function(){
        $('#msgpedido').fadeOut(500);
    }, 3000);
}
//Contador
/*$(document).ready(function(){
    $('.cantidad').parent().find('.mas').click(function(){
        var num = $(this).prev().find('.cantidad').val();
        $(this).prev().find('.cantidad').val(++num);
    });

    $('.cantidad').parent().find('.menos').click(function(){
        var num = $(this).next().val();
        if(num <= 0)
            $(this).next().val(0);
        else
            $(this).next().val(--num);
    });
});*/

$(document).ready(function(){
    $('.cantidadcontador').parent().find('.mas').click(function(){
        //alert("No: " + $(this).attr('class') + "\n" + "Clase siguiente: " + $(this).prev().attr('class') + "\n" + "valor siguiente clase: " + $(this).prev().val() );
        var num = $(this).prev().val();
        $(this).prev().val(++num);
    });

    $('.cantidadcontador').parent().find('.menos').click(function(){
        var num = $(this).next().val();
        if(num <= 1)
            $(this).next().val(1);
        else
            $(this).next().val(--num);
    });
});
// Contador

function reenviarCorreoConfirmacion(ev){
    ev.preventDefault();
        $.ajax({
            url: 'reenviarcc.php',
            type: 'POST',
            data: {var: "var"},
            success: function(respreenvio){
                console.log(respreenvio);
                if(respreenvio == "OK"){
                    $('#reenviar').fadeOut(500);
                    $('#edoreenvio').html('Se le ha reenviado el correo de confirmación');
                    $('#edoreenvio').fadeIn(500);
                    setTimeout(function(){
                        $('#edoreenvio').fadeOut(500);
                        $('#reenviar').fadeIn(500);
                    }, 3000);
                }
                else{
                    $('#reenviar').fadeOut(500);
                    $('#edoreenvio').html('Ha ocurrido un error, intente nuevamente o más tarde');
                    $('#edoreenvio').fadeIn(500);
                    setTimeout(function(){
                        $('#edoreenvio').fadeOut(500);
                        $('#reenviar').fadeIn(500);
                    }, 3000);
                }
            }
        });
}

 /*$(document).ready(function() {
     $('.editable').editable(function(value, settings){
         console.log("THIS: " + this);
         console.log("VALUE: " + value);
         console.log("SETTINGS: " + settings);
         return (value);

     } , {
         indicator : '<img src="../images/ajax-loader.gif">',
         tooltip   : 'Click para editar'
     });

 });
*/
/*
$(document).ready(function() {
     $('.editable').editable('cambiar.php', {
         name:'neim',
         id: 'aidi',
         submitdata: {tipo: "3", ID: ($(this).attr('id'))},
         onblur : 'submit'
    });
 });
*/


var bol = false;
function rfcgenerico(){
    if(!bol){
        $('.autorfc').attr('src', '../images/okicon.png');
        $('#rfcF').val('XAXX010101000');
        bol = true;
    }
    else if(bol){
        $('.autorfc').attr('src', '../images/okicon2.png');
        $('#rfcF').val('');
        bol = false;
    }
}

function comrfcgen(val){
    if(val != "XAXX010101000"){
        $('.autorfc').attr('src', '../images/okicon2.png');
        bol = false;
    }
    else if(val == $.trim("XAXX010101000")){
        $('.autorfc').attr('src', '../images/okicon.png');
        bol = true;
    }
}
