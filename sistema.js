// Función autocompletar shipper
function autocompletarProveedor() {
    console.log("autocompletarProveedor");
	var minimo_letras = 1 ; // minimo letras visibles en el autocompletar
	var palabra = $('#proveedor').val();
	console.log(palabra);
	//Contamos el valor del input mediante una condicional
	if (palabra.length >= minimo_letras) {
		$.ajax({
			url: 'mostrar.php',
			type: 'POST',
			data: {palabra:palabra},
			success:function(data){
				$('#lista_prov').show();
				$('#lista_prov').html(data);
			}
		});
	} else {
		//ocultamos la lista
		$('#lista_prov').hide();
	}
}

// Funcion Mostrar valores
function set_item(opciones) {
	// Cambiar el valor del formulario input
    console.log("itemmmm autocompletarProveedor");
	$('#proveedor').val(opciones);
	// ocultar lista de proposiciones
	$('#lista_prov').hide();
}

