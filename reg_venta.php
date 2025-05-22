<?php
    include('cabecera.php');
    include('login.php');
    include('reg_venta_cod.php');
    include('guardar.php');
    
    //include_once("Conexion.php");
    //session_start();
    if (!isset($_SESSION['usuario'])) {
        echo "Usuario no autenticado.";
        exit;
       
}

    $usuario = $_SESSION['usuario'];
?>
<link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
<!--link rel="stylesheet" href="estilos.css"-->
<link rel="stylesheet" href="style.css" />
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="sistema.js"></script>
<script type="text/javascript" src="sistemac.js"></script>
<div class="p-12 bg-light">
    <form class="form" id="mi-modal" action="" method="POST">
        <div class="card border-danger ">
            <div class="card-header bg-danger text-white border-danger ">Registro Embarque</div>
                <div class="card-body" >
                    <div class="row">
                        
                        <div class="col-md-4">
                            <label for="inputAddress2" class="form-label form-control-sm text-danger">RO (*)</label>
                            <input type="text" class="form-control form-control-sm" id="ro" name="ro"  autocomplete="off"  style="text-transform:uppercase" required>
                        </div>
                        <form action="">
                        <div class="input_container col-md-4 ">
                            <label for="inputAddress2" class="form-label form-control-sm text-danger">SHIPPER PROFORM INVOICE: (*)</label>
                            <input type="text" autofocus  class="form-control form-control-sm" id="shipper" name="shipper" onkeyup="autocompletarShipper()" autocomplete="off"  style="text-transform:uppercase" required>
                            <ul id="lista_id"></ul>
                        </div>
                        </form>
                        <div class="col-md-4">
                                <label for="inputCity" class="form-label form-control-sm text-danger">MBL BOOKING: (*)</label>
                                <input type="text" class="form-control form-control-sm" id="mbl" name="mbl" autocomplete="off" style="text-transform:uppercase" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">PROVEEDOR: (*)</label>
                            <input type="text" class="form-control form-control-sm" id="proveedor" name="proveedor" autocomplete="off"  style="text-transform:uppercase" required>
                            
                        </div>
                     
                        <div class="input_container col-md-4 ">
                            <label for="inputCity" class="form-label form-control-sm text-danger">CONSIGNATARIO: (*)</label>
                            <input type="text" autofocus class="form-control form-control-sm" id="consig" name="consig" autocomplete="off" onkeyup="autocompletarConsig()" style="text-transform:uppercase" required>
                            <ul id="lista_con"></ul>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">NUMERO DE CONTENEDOR: (*)</label>
                            <input type="text" class="form-control form-control-sm" id="contenedor" name="contenedor" autocomplete="off"  style="text-transform:uppercase" required>
                        </div>
                        <div class="col-md-4">
                            <label for="inputState" class="form-label form-control-sm text-danger">TIPO CONTENEDOR:</label>
                            <select id="listaTContenedor" name="tipo[]" class="form-select form-select-sm text-uppercase">
                                <option selected> </option>
                                <?php foreach ($tipo as $tContenedores) { ?>	
                                    <option  style="text-transform:uppercase" <?php
                                            if (!empty($listaTContenedor)) {
                                                    if (in_array($tContenedores['tipo'],$tipo)) {
                                                    echo 'selected';
                                                    }
                                            }
                                            ?>
									value="<?php echo $tContenedores['tipo']; ?>" ><?php echo $tContenedores['tipo']; ?>
							        </option>  
							    <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">CANTIDAD DE CONTENEDOR:</label>
                            <input type="number" class="form-control form-control-sm" id="ccontenedor" name="ccontenedor" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">MERCANCIA O PRODUCTO:</label>
                            <input type="text" class="form-control form-control-sm" id="producto" name="producto" style="text-transform:uppercase" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">PUERTO ORIGEN: (*)</label>
                                <select id="listapor" name="origen[]" class="form-select form-select-sm text-uppercase">
                                <option selected> </option>
                                    <?php foreach ($origen as $origen) { ?>	
                                    <option  <?php
                                        if (!empty($listapor)) {
                                                if (in_array($origen['puerto'],$origen)) {
                                                echo 'selected';
                                                }

                                            }
                                        ?>
                                        value="<?php echo $origen['puerto']; ?>" ><?php echo $origen['puerto']; ?>
							        </option>  
							        <?php } ?>
                                </select>
                        </div>
                        
                        <div class="col-md-4">
                        <label for="inputCity" class="form-label form-control-sm text-danger">PUERTO LLEGADA: (*)</label>
                                <select id="listapod" name="llegada[]" class="form-select form-select-sm text-uppercase">
                                <option selected> </option>    
                                <?php foreach ($llegada as $puertod) { ?>	
                                        <option  <?php
                                        if (!empty($listapod)) {
                                                if (in_array($puertod['puerto'],$puertod)) {
                                                echo 'selected';
                                                }

                                            }
                                        ?>
                                        value="<?php echo $puertod['puerto']; ?>" ><?php echo $puertod['puerto']; ?>
							        </option>  
							        <?php } ?>
                                </select>
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">FECHA SALIDA:</label>
                            <input type="date" class="form-control form-control-sm" id="salida" name="salida" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">FECHA LLEGADA:</label>
                            <input type="date" class="form-control form-control-sm" id="Fllegada" name="Fllegada" autocomplete="off">
                        </div>

                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">INVOICE DE LA CARGA:</label>
                            <input type="text" class="form-control form-control-sm" id="invoice" name="invoice" style="text-transform:uppercase" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">VENTA:</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="venta" name="venta" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">COMPRA TOTAL:</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="compra" name="compra" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">VENTA SEGURO:</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="vseguro" name="vseguro" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">COMPRA SEGURO:</label>
                            <input type="number" class="form-control form-control-sm" id="cseguro" name="cseguro" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">VENTA TOTAL:</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="vtotal" name="vtotal" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">TOTAL PROFIT:</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="profit" name="profit" autocomplete="off">
                        </div><div class="col-md-4">
                            <label for="inputCity" class="form-label form-control-sm text-danger">T CONTABLE:</label>
                            <input type="number" step="0.01" class="form-control form-control-sm" id="tcontable" name="tcontable" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label for="inputState" class="form-label form-control-sm text-danger">TIPO DE TRANSPORTE:</label>
                            <select id="listatrans" name="transporte[]" class="form-select form-select-sm text-uppercase">
                            <option selected> </option>    
                            <?php foreach ($transporte as $transportes) { ?>	
                                    
                                    <option  style="text-transform:uppercase" <?php
                                            if (!empty($listatrans)) {
                                                    if (in_array($transportes['transporte'],$transporte)) {
                                                    echo 'selected';
                                                    }
                                            }
                                            ?>
									value="<?php echo $transportes['transporte']; ?>" ><?php echo $transportes['transporte']; ?>
							        </option>  
							    <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                          
                            <label for="inputState" class="form-label form-control-sm text-danger">MEDIO DE TRANSPORTE:</label>
                            <select id="listnav" name="navieras[]" class="form-select form-select-sm text-uppercase">
                            <option selected> </option>    
                            <?php foreach ($navieras as $nav) { ?>	
                                    
                                    <option  style="text-transform:uppercase" <?php
                                            if (!empty($listnav)) {
                                                    if (in_array($nav['naviera'],$navieras)) {
                                                    echo 'selected';
                                                    }
                                            }
                                            ?>
									value="<?php echo $nav['naviera']; ?>" ><?php echo $nav['naviera']; ?>
							        </option>  
							    <?php } ?>
                            </select>
                        </div>
                        
                        </div><div class="col-md-12">
                            <label for="inputCity" class="form-label form-control-sm text-danger">OBSERVACIONES:</label>
                            <input type="text" class="form-control form-control-sm" style="text-transform:uppercase" rows="10" cols="50" id="obs" name="obs" autocomplete="off">
                        </div>
                        
                        <div class="col-4"> </div>  
                        </div>
                              
                            <div class="col-12"> <?php if(isset($climen)) { ?>
                                    <div class="alert alert-danger" role="alert" >
                                        <strong><?php echo $climen; ?></strong> 
                                    </div>
                                <?php } ?>
                            </div>  
                        
                        <div class="modal-footer">
                        </div><div class="col-md-12">
                        <button class="btn btn-danger" data-dismiss="modal" onclick="cerrar()">Cancelar</button>
                        
                        <button class="btn btn-success"  type="submit" onclick="FormSubmit()">Guardar</button>
                            </div>
                        </div>
                        </div>  
                </div>
            </div>
        </div>
        </div>
    </form>
</div>

<script src="codigo.js"></script>


<?php  include_once("pie.php");?>