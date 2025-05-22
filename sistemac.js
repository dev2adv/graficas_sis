// Función autocompletar consignatario
function autocompletarConsig() {
    console.log("autocompletarConsig");
	var minimo_letras = 1 ; // minimo letras visibles en el autocompletar
	var palabrac = $('#consig').val();
	//Contamos el valor del input mediante una condicional
	if (palabrac.length >= minimo_letras) {
		$.ajax({
			url: 'mostrarc.php',
			type: 'POST',
			data: {palabrac:palabrac},
			success:function(data){
				$('#lista_con').show();
				$('#lista_con').html(data);
			}
		});
	} else {
		//ocultamos la lista
		$('#lista_con').hide();
	}
}


// Funcion Mostrar valores
function set_itemc(opcionesc) {
	// Cambiar el valor del formulario input
    console.log("item autocompletarConsig");
	$('#consig').val(opcionesc);
	// ocultar lista de proposiciones
	$('#lista_con').hide();
}