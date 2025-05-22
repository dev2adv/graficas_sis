// Función autocompletar cliente
function autocompletarConsigV() {
    console.log("autocompletarConsigvvvvv");
	var minimo_letras = 1 ; // minimo letras visibles en el autocompletar
	var palabracl = $('#clien').val();
	//Contamos el valor del input mediante una condicional
	if (palabracl.length >= minimo_letras) {
		$.ajax({
			url: 'mostrarcv.php',
			type: 'POST',
			data: {palabracl:palabracl},
			success:function(data){
				$('#lista_clie').show();
				$('#lista_clie').html(data);
			}
		});
	} else {
		//ocultamos la lista
		$('#lista_clie').hide();
	}
}



// Funcion Mostrar valores
function set_itemc(opcionesc) {
	// Cambiar el valor del formulario input
    console.log("item autocompletarConsig");
	$('#clien').val(opcionesc);
	// ocultar lista de proposiciones
	$('#lista_clie').hide();
}