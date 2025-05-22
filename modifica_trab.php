<?php
	
	include_once("Conexion.php");
    $con=CConexion::ConexionDB();
	
	$id = $_POST['id'];
	$nombre = $_POST['trabajador'];
	$email = $_POST['email'];
	$telefono = $_POST['telefono'];
	$estado_civil = $_POST['direccion'];
	$hijos = isset($_POST['sucursal']) ? $_POST['sucursal'] : 0;
	$intereses = isset($_POST['cargo']) ? $_POST['cargo'] : null;
	
	$arrayIntereses = null;
	
	//$num_array = count($intereses);
	$contador = 0;
	
	/*if($num_array>0){
		foreach ($intereses as $key => $value) {
			if ($contador != $num_array-1)
			$arrayIntereses .= $value.' ';
			else
			$arrayIntereses .= $value;
			$contador++;
		}
	}*/
	
	$sql = "UPDATE trabajador SET trabajador='$nombre', email='$email', telefono='$telefono', direccion='$estado_civil', sucursal='$hijos', cargo='$arrayIntereses' WHERE id = '$id'";
	$resultado = $con->query($sql);
	
?>

<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
        <title>ADVANCELINE SRL</title>
        <link rel="shortcut icon" href="images/SoloA Logo.png " type="image/x-icon" />
        <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="estilos.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="row" style="text-align:center">
					<?php if($resultado) { ?>
						<h3>REGISTRO MODIFICADO</h3>
						<?php } else { ?>
						<h3>ERROR AL MODIFICAR</h3>
					<?php } ?>
					
					<a href="tbl.php" class="btn btn-primary">Regresar</a>
					
				</div>
			</div>
		</div>
	</body>
</html>