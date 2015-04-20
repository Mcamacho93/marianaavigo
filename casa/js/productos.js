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
				if(resPres === "errorp"){
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
		$.ajax({
			beforeSend: function(){
				$('#nuevaCategoria').attr('disabled', true);
				$('#nuevaCategoria').html("Agregando...");
			},
			url: 'agregar.php',
			type: 'POST',
			data: {Nombre: nombre, tipo:"2"},
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
				}	
			}
		})
	}
}

function agregarProducto(evap, nombre, descripcion, precio, presentacion, categoria, marca, img){
	evap.preventDefault();
	if($.trim(nombre) == "" || $.trim(descripcion) == "" || $.trim(precio) == "" || $.trim(presentacion) == "" || $.trim(categoria) == "" || $.trim(marca) == ""){
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
		var formProducto = new FormData(document.getElementById('agregarProd'));
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
			$('#imgdisplay').html('<label>Solo archivos menores a 500Kb, la imagen seleccionada pesa '+ tamano  +' Kb, por tanto excede el limite por '+ excede + ' Kb </label>');
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