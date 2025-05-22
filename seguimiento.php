<?php
  $ro = "";

  include_once("seguiDet.php");

  if(empty($segEmb)){
    $segEmb = array(array('VENTA' => 0, 'CANTIDAD DE CONTENEDOR' => 0, 'COMPRA TOTAL' => 0, 'VENTA SEGURO' => 0,'COMPRA SEGURO' => 0, 'VENTA TOTAL' => 0, 'TOTAL PROFIT' => 0, 'T CONTABLE' => 0, 'ro' => "",'shipper' => "", 'mbl' => "", 'consignatario' => "", 'numero de contenedor' => "", 'tipo de contenedor' => "", 'MERCANCIA O PRODUCTO' => "", 'PUERTO ORIGEN' => "", 'PUERTO LLEGADA' => "", 'FECHA SALIDA' => "", 'fllegada' => "", 'INVOICE DE LA CARGA' => "", 'tipot' => "", 'NAVIERA' => "", 'OBSERVACIONES' => "" , 'proveedor' => "", 'nro' => "" ));
  }

  // $usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Seguimiento</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">
  </head>
  <body>
    <form id="segForm" method="POST" data="editar.php">
    <div class="row">
      <div class="col-md-4">  
        <label for="ro">RO:</label>
        <input class="form-control" type="text" id="ro" name="ro" required>
      </div>
      <div class="col-md-4">
        <label for="mbl">MBL BOOKING:</label>
        <input class="form-control" type="mbl" id="mbl" name="mbl" required>
      </div>
      <div class="col-md-4">  
        <label for="proveedor">PROVEEDOR:</label>
        <input onclick="" class="form-control" type="text" id="proveedor" name="proveedor" >
        <ul id="lista"></ul>
      </div>
      <div class="col-md-4">  
        <label for="consig">CONSIGNATARIO:</label>
        <input class="form-control" type="consig" id="consignatario" name="consig" required>
        <ul id="lista2"></ul>
      </div>
      <div class="col-md-4">  
        <label for="contenedor">NUMERO DE CONTENEDOR:</label>
        <input class="form-control" type="text" id="contenedor" name="contenedor" required>
      </div>
      <div class="col-md-4">  
        <label for="tipo">TIPO CONTENEDOR:</label>
        <select class="form-control" id="tipo" name="tipo" required>
          <option selected=""> --Seleccione el tipo de Contenedor-- </option>
          <option value="20DRY">20DRY</option>
          <option value="40DRY">40DRY</option>
          <option value="40HC">40HC</option>
          <option value="40NOR">40NOR</option>
          <option value="40FLAT RACK">40 FLAT RACK</option>
          <option value="40OT">40 OT</option>
          <option value="LCL CONSOLIDADO ">LCL CONSOLIDADO</option>
        </select>
      </div>
      <div class="col-md-4">  
        <label for="CANTIDAD">CANTIDAD DE CONTENEDOR:</label>
        <input class="form-control" type="number" id="ccontenedor" name="ccontenedor" >
      </div>
      <div class="col-md-4">  
      <label for="producto">MERCANCIA O PRODUCTO:</label>
      <input class="form-control" type="producto" id="producto" name="producto" required>
    </div>
    <div class="col-md-4">  
      <label for="origen">PUERTO ORIGEN:</label>
      <input class="form-control" type="origen" id="origen" name="origen" required>
    </div>
    <div class="col-md-4">       
        <label for="llegada">PUERTO LLEGADA:</label>
        <input class="form-control" type="llegada" id="llegada" name="llegada" required>
    </div>
    <div class="col-md-4">  
        <label for="salida">FECHA SALIDA:</label>
        <input class="form-control" type="date" id="salida" name="salida" required>
    </div>  
    <div class="col-md-4">  
        <label for="Fllegada">FECHA LLEGADA:</label>
        <input class="form-control" type="date" id="Fllegada" name="Fllegada" required>
    </div>
    <div class="col-md-4">    
        <label for="invoice">INVOICE DE LA CARGA:</label>
        <input class="form-control" type="text" id="invoice" name="invoice" >
    </div>
    <div class="col-md-4">        
        <label for="venta">VENTA:</label>
        <input class="form-control" type="number" id="venta" name="venta" required>
    </div>
    <div class="col-md-4">    
        <label for="compra">COMPRA TOTAL:</label>
        <input class="form-control" type="number" id="compra" name="compra" required>
    </div>
    <div class="col-md-4">      
          <label for="vtotal">VENTA TOTAL:</label>
          <input class="form-control" type="number" id="vtotal" name="vtotal" required>
    </div>
    <div class="col-md-4">  
          <label for="profit">TOTAL PROFIT:</label>
          <input class="form-control" type="number" id="profit" name="profit" required>
    </div>
    <div class="col-md-4">  
          <label for="tcontable">T CONTABLE:</label>
          <input class="form-control" type="number" id="tcontable" name="tcontable" >
    </div>
    <div class="col-md-4">     
          <label for="transporte">TIPO DE TRANSPORTE:</label>
    
          <select class="form-control" id="transporte" name="transporte" required>
            <option selected=""> --Seleccione el tipo de Flete-- </option>
            <option value="AEREO">AEREO</option>
            <option value="MARITIMO">MARITIMO</option>
            <option value="TERRESTRE">TERRESTRE</option>
            <option value="LCL CONSOLIDADO">LCL CONSOLIDADO</option>
            <option value="SEGURO DE CARGA">SEGURO DE CARGA</option>
          </select>
    </div>
    <div class="col-md-4">     
          <label for="naviera">MEDIO DE TRANSPORTE:</label>
          <br>
          <select class="form-control" id="naviera" name="naviera" required>
            <option selected=""> --Seleccione una Naviera-- </option>
            <option value="MAERSK">MAERSK</option>
            <option value="SEALAND">SEALAND</option>
            <option value="MSC">MSC</option>
            <option value="HAPAG LLOYD">HAPAH LLOYD</option>
            <option value="CMA CGM">CMA CGM</option>
            <option value="ONE">ONE</option>
            <option value="COSCO">COSCO</option>
            <option value="HAMBURG SUD">HAMBURG SUD</option>
            <option value="OTROS">OTROS</option>
          </select>
    </div>
    <div class="col-md-4">  
          <label for="obs">OBSERVACIONES:</label>
          
          <textarea class="form-control" rows="10" cols="50" id="obs" name="obs" placeholder="Escribe tus observaciones"></textarea>
    </div>
    <div class="col-md-4">  
          <label for="naviera">NRO:</label>
          <input class="form-control" type="number" id="nro" name="nro" >
    </div>
    </div>
    </form>
    <script src="codigo.js"></script>
  </body>
</html>

