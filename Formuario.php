<?php
  $ro = "";

  include_once("listEdit.php");
  include_once("reg_venta_cod.php");

  if(empty($embarques)){
    $embarques = array(array('VENTA' => 0, 'CANTIDAD DE CONTENEDOR' => 0, 'COMPRA TOTAL' => 0, 'VENTA SEGURO' => 0,'COMPRA SEGURO' => 0, 'VENTA TOTAL' => 0, 'TOTAL PROFIT' => 0, 'T CONTABLE' => 0, 'ro' => "",'shipper' => "", 'mbl' => "", 'consignatario' => "", 'numero de contenedor' => "", 'tipo de contenedor' => "", 'MERCANCIA O PRODUCTO' => "", 'PUERTO ORIGEN' => "", 'PUERTO LLEGADA' => "", 'FECHA SALIDA' => "", 'fllegada' => "", 'INVOICE DE LA CARGA' => "", 'tipot' => "", 'NAVIERA' => "", 'OBSERVACIONES' => "" , 'proveedor' => "", 'nro' => "" ));
  }

  
   

  // $usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Editable</title>
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


  </head>
  <body>
    <form id="editableForm" method="POST" data="editar.php">
    <div class="row">
      <div class="col-md-3">  
        <label class="form-label form-control-sm text-danger" for="ro">RO:</label>
        <input class="form-control form-select-sm" type="text" id="ro" name="ro" required>
      </div>
      <div class="col-md-3">
          <label for="inputState" class="form-label form-control-sm text-danger">SERVICIO:</label>
          <select id="listaserv" name="vservicio[]" class="form-select form-select-sm text-uppercase">
          <option selected> </option>    
          <?php foreach ($vservicio as $servicios) { ?>
                  <option  style="text-transform:uppercase" <?php
                          if (!empty($listaserv)) {
                                  if (in_array($servicios['servicio'],$vservicio)) {
                                  echo 'selected';
                                  }
                          }
                          ?>
          value="<?php echo $servicios['servicio']; ?>" ><?php echo $servicios['servicio']; ?>
              </option>  
          <?php } ?>
                    </select>
      </div>
      <div class="col-md-3">
        <label for="inputState" class="form-label form-control-sm text-danger">TIPO DE TRANSPORTE:</label>
            <select id="listatrans" name="transporte[]" class="form-select form-select-sm text-uppercase">
                <option selected>Seleccione...</option>    
                <?php foreach ($transporte as $transportes) { ?>    
                    <option style="text-transform:uppercase"
                        value="<?php echo $transportes['transporte']; ?>">
                        <?php echo $transportes['transporte']; ?>
                    </option>  
                <?php } ?>
            </select>
      </div>
      <div class="col-md-3">
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
      <div class="col-md-5">  
        <label class="form-label form-control-sm text-danger" for="proveedor">PROVEEDOR:</label>
        <input onclick="" class="form-control form-select-sm" type="text" id="proveedor" name="proveedor" >
        <ul id="lista"></ul>
      </div>
      <div class="col-md-5">  
        <label class="form-label form-control-sm text-danger" for="consig">CONSIGNATARIO:</label>
        <input class="form-control form-select-sm" type="consig" id="consignatario" name="consignatario" required>
        <ul id="lista2"></ul>
      </div>
      <div class="col-md-2">
        <label class="form-label form-control-sm text-danger" for="mbl">MBL BOOKING:</label>
        <input class="form-control form-select-sm" type="text" id="mbl" name="mbl" required>
      </div>
      <div class="col-md-3">
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
    <div class="col-md-3">  
        <label class="form-label form-control-sm text-danger" for="salida">FECHA SALIDA:</label>
        <input class="form-control form-select-sm" type="date" id="fsalida" name="fsalida" required>
    </div>  
    <div class="col-md-3">
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
    
    <div class="col-md-3">  
        <label class="form-label form-control-sm text-danger" for="Fllegada">FECHA LLEGADA:</label>
        <input class="form-control form-select-sm" type="date" id="fllegada" name="fllegada" required>
    </div>
    <br><br><br><br>
    <div class="col-md-12">
      <!-- TABLA -->
      <table class="table table-bordered border-black" id="Table">
      <thead>
          <tr>
          <th scope="col">#</th>
          <th scope="col">Nro. Contenedor</th>
          <th scope="col">Tipo</th>
          <th scope="col">Mercadería</th>
          <th scope="col">Cantidad</th>
          <th scope="col">Venta unitaria</th>
          <th scope="col">Total</th>
          <th scope="col">Compra</th>
          <th scope="col">Profit</th>
          <th scope="col">Modificar</th>
          <th scope="col">Eliminar</th>
          </tr>
      </thead>
      <tbody>
          
      </tbody>
      </table>
      <!-- TABLA -->
    </div>

    <div class="col-md-2">  
        <label class="form-label form-control-sm text-danger" for="CANTIDAD">CANTIDAD CONT:</label>
        <input class="form-control form-select-sm" type="number" id="tccontenedor" name="tccontenedor" readonly>
    </div>
    <div class="col-md-2">      
          <label class="form-label form-control-sm text-danger" for="vtotal">VENTA TOTAL:</label>
          <input class="form-control form-select-sm" type="number" id="ventat" name="ventat" value="0" readonly>
    </div>
    <div class="col-md-2">    
        <label class="form-label form-control-sm text-danger" for="compra">COMPRA:</label>
        <input class="form-control form-select-sm" type="number" id="comprat" name="comprat" value="0" readonly>
    </div>
    
    <div class="col-md-2">  
          <label class="form-label form-control-sm text-danger" for="profit">VENTA PROFIT:</label>
          <input class="form-control form-select-sm" type="number" id="totalp" name="totalp" value="0" readonly>
    </div>
    <div class="col-md-2">  
          <label class="form-label form-control-sm text-danger" for="tcontable">T CONTABLE:</label>
          <input class="form-control form-select-sm" type="number" id="tcontable" name="tcontable" value="0" >
    </div>
    <div class="col-md-2">  
          <label class="form-label form-control-sm text-danger" for="naviera">NRO:</label>
          <input class="form-control form-select-sm" type="number" id="nro" name="nro" readonly>
    </div>
    <div class="col-md-12">  
          <label class="form-label form-control-sm text-danger" for="obs">OBSERVACIONES:</label>
          <input class="form-control form-select-sm" type="text" id="obs" name="obs" >
    </div>
    
    </div>
    </form>
    <!-- MODAL -->
<div class="modal" id="modal2" width="1600" >
    <div class="modal-dialog border-danger modal-sm ">
        <div class="modal-content  border-danger modal-sm">
            <div class="modal-header  border-danger modal-sm">
                <h5>Datos de Contenedores</h5>
            </div>
            <div class="modal-body border-danger modal-sm formBody">
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">ID</label>
                        <input type="text" class="form-control form-control-sm w-100" id="id2" name="id2" autocomplete="off"  style="text-transform:uppercase" readonly>
                    </div>
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">NUMERO</label>
                        <input type="text" class="form-control form-control-sm w-100" id="contenedor" name="contenedor" autocomplete="off"  style="text-transform:uppercase" >
                    </div>
                    <div class="col">
                        <label for="inputState" class="form-label form-control-sm text-danger">TIPO </label>
                        <select id="tipo" name="tipo[]" class="form-select form-select-sm text-uppercase w-100" >
                            <option selected> </option>
                            <?php foreach ($tipo as $tContenedores) { ?>    
                                <option style="text-transform:uppercase" <?php
                                    if (!empty($listaTContenedor)) {
                                        if (in_array($tContenedores['tipo'], $tipo)) { // Aquí cambio $tipo por $listaTContenedor
                                            echo 'selected';
                                        }
                                    }
                                ?>
                                value="<?php echo $tContenedores['tipo']; ?>"><?php echo $tContenedores['tipo']; ?>
                                </option>  
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">MERCANCIA O PRODUCTO</label>
                        <input type="text" class="form-control form-control-sm w-100" id="producto" name="producto" style="text-transform:uppercase" autocomplete="off">
                    </div>
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">CANTIDAD</label>
                        <input type="number" class="form-control form-control-sm w-100" id="ccontenedor2" name="ccontenedor2" autocomplete="off" value="0">
                    </div>
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">VENTA UNITARIA</label>
                        <input type="number" step="0.01"  class="form-control form-control-sm w-100" id="venta2" name="venta2" autocomplete="off" value="0">
                    </div>     
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">VENTA</label>
                        <input type="number" step="0.01"  class="form-control form-control-sm w-100" id="vtotal2" name="vtotal2" autocomplete="off" value="0" readonly>
                    </div>
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">COMPRA</label>
                        <input type="number" step="0.01" class="form-control form-control-sm w-100" id="compra2" name="compra2" autocomplete="off" value="0" >
                    </div>
                    <div class="col">
                        <label for="inputCity" class="form-label form-control-sm text-danger">PROFIT</label>
                        <input type="number" step="0.01"  class="form-control form-control-sm w-100" id="vprofit2" name="vprofit2" autocomplete="off" value="0" readonly>
                    </div>
                
        </div>
        <div class="modal-footer border-danger modal-sm">
            <button class="btn btn-dark" id="btnAgregar2" data-dismiss="modal" onclick="actualizarFila();" >Aceptar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<!-- FIN MODAL -->
    <script src="codigo.js"></script>
    <script >
      // Función para calcular y mostrar el resultado de vental total
      function calculateAndDisplayResult() {
          const val1 = parseFloat(document.getElementById("ccontenedor2").value) || 0;
          const val2 = parseFloat(document.getElementById("venta2").value) || 0;
          const result = val1 * val2;
          document.getElementById("vtotal2").value = result;
        }

        // Agregar eventos para que la función se ejecute al escribir en los inputs
        document.getElementById("ccontenedor2").addEventListener("input", calculateAndDisplayResult);
        document.getElementById("venta2").addEventListener("input", calculateAndDisplayResult);
        

    </script>
    <script>
      // Función para calcular y mostrar el resultado del profit
        function calculateprofit() {
          const val3 = parseFloat(document.getElementById("vtotal2").value) || 0;
          const val4 = parseFloat(document.getElementById("compra2").value) || 0;
          const results = val3 - val4;
          console.log("en la resta")
          console.log(val3)
          console.log(val4)
          console.log(results)
          document.getElementById("vprofit2").value = results;
        }

        // Agregar eventos para que la función se ejecute al escribir en los inputs
        document.getElementById("vtotal2").addEventListener("input", calculateprofit);
        document.getElementById("compra2").addEventListener("input", calculateprofit);
    </script>
    <script>

        document.querySelectorAll("tr").forEach((fila) => {
            fila.addEventListener("click", function () {
                document.querySelectorAll("tr").forEach(f => f.classList.remove("selected")); // Limpiar selección previa
                this.classList.add("selected"); // Agregar clase solo a la fila clickeada
            });
        });

       function actualizarFila() {
            console.log("dentro de actualizarFila");
            let filaSeleccionada = document.querySelector("tr.selected");

            if (!filaSeleccionada) {
                alert("Por favor, selecciona una fila antes de modificar.");
                return;
            }

            let nuevosValores = [
                document.getElementById("id2").value.trim(),
                document.getElementById("contenedor").value.trim(),
                document.getElementById("tipo").value.trim(),
                document.getElementById("producto").value.trim(),
                document.getElementById("ccontenedor2").value.trim(),
                document.getElementById("venta2").value.trim(),
                document.getElementById("vtotal2").value.trim(),
                document.getElementById("compra2").value.trim(),
                document.getElementById("vprofit2").value.trim()
            ];

            let celdas = filaSeleccionada.querySelectorAll("td");

            nuevosValores.forEach((valor, index) => {
                celdas[index].innerText = valor;
            });

            console.log("Fila actualizada correctamente.");
            
        }
        
        function cerrarModal2() {
            let modal = document.getElementById("modal2");
            let modalInstance = bootstrap.Modal.getInstance(modal);
            modalInstance.hide(); // Cierra modal2

            // Esperar un poco y forzar el foco al modal principal
            setTimeout(() => {
                let modalPrincipal = document.getElementById("mi-modal"); // Asegúrate que este es el ID del modal principal
                let modalPrincipalInstance = bootstrap.Modal.getInstance(modalPrincipal);
                modalPrincipalInstance.show(); // Reabre el modal principal si es necesario
            }, 300);
        }


    </script>
    
  </body>
</html>
