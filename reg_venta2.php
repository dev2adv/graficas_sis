<?php
    include('cabecera.php');
    include('login.php');
    include('reg_venta_cod.php');
    //include('guardar2.php');
    
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
    <form class="form" id="miFormulario" action="" method="POST">
        <div class="card border-danger ">
            <div class="card-header bg-danger text-white border-danger ">Registro Embarque</div>
                <div class="card-body" >
                    <div class="row">
                        <div class="col-md-3">
                            <label for="inputAddress2" class="form-label form-control-sm text-danger">RO (*)</label>
                            <input type="text" class="form-control form-control-sm" id="ro" name="ro"  autocomplete="off"  style="text-transform:uppercase" required>
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
                        <div class="col-md-6">
                            <label for="inputCity" class="form-label form-control-sm text-danger">PROVEEDOR: (*)</label>
                            <input type="text" class="form-control form-control-sm" id="proveedor" name="proveedor" autocomplete="off"  onkeyup="autocompletarProveedor()" style="text-transform:uppercase" required>
                            <ul id="lista_prov"></ul>
                        </div>
                     
                        <div class="col-md-6 ">
                            <label for="inputCity" class="form-label form-control-sm text-danger">CONSIGNATARIO: (*)</label>
                            <input type="text" autofocus class="form-control form-control-sm" id="consig" name="consig" autocomplete="off" onkeyup="autocompletarConsig()" style="text-transform:uppercase" required>
                            <ul id="lista_con"></ul>
                        </div>
                        <div class="col-md-2">
                                
                                <input type="text" id="mblBooking" class="form-label form-control-sm text-danger" style="border: none;outline: none;background: transparent;" value="B/L" readonly>
                                <input type="text" class="form-control form-control-sm" id="mbl" name="mbl" autocomplete="off" style="text-transform:uppercase" required>
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
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label form-control-sm text-danger">FECHA SALIDA:</label>
                            <input type="date" class="form-control form-control-sm" id="salida" name="salida" autocomplete="off" required>
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
                        
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label form-control-sm text-danger">FECHA LLEGADA:</label>
                            <input type="date" class="form-control form-control-sm" id="Fllegada" name="Fllegada" autocomplete="off" required>
                        </div>
                        <br><br><br><br>
                        <div class="col-md-2">
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Agregar Datos de Contenedores
                        </button>
                        </div>
                        <div class="col-md-10">
                            <!-- TABLA -->
                            <table class="table">
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
                                <th scope="col">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                            </table>
                            <!-- TABLA -->
                            </div>
                        <div class="row">
                        <div class="col-md-2">
                            
                        </div>
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label form-control-sm text-danger">Total Contenedores:</label>
                            <input type="number" step="0.01"  class="form-control form-control-sm" id="tcontenedoresT" name="tcontenedoresT" autocomplete="off" value="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label form-control-sm text-danger">Venta:</label>
                            <input type="number" step="0.01"  class="form-control form-control-sm" id="tventaT" name="tventaT" autocomplete="off" value="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label form-control-sm text-danger">Compra:</label>
                            <input type="number" step="0.01"  class="form-control form-control-sm" id="compraT" name="compraT" autocomplete="off" value="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label form-control-sm text-danger">Profit:</label>
                            <input type="number" step="0.01"  class="form-control form-control-sm" id="profitT" name="profitT" autocomplete="off" value="0" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="inputCity" class="form-label form-control-sm text-danger">T CONTABLE:</label>
                            <input type="number" step="0.01"  class="form-control form-control-sm" id="tcontable" name="tcontable" autocomplete="off" value="0" >
                        </div>
                        </div
                        <div class="col-md-16">
                            <label for="inputCity" class="form-label form-control-sm text-danger">OBSERVACIONES:</label>
                            <input type="text" class="form-control form-control-sm" style="text-transform:uppercase" rows="10" cols="50" id="obs" name="obs" autocomplete="off">
                        </div>
                        <br>
                        <div class="col-md-16"> <?php if(isset($climen)) { ?>
                                <div class="alert alert-danger" role="alert" >
                                    <strong><?php echo $climen; ?></strong> 
                                </div>
                            <?php } ?>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <button class="btn btn-success"  type="submit" onclick="FormSubmitgk(event)">Guardar</button>
                            <button class="btn btn-danger" data-dismiss="modal" onclick="cerrar()">Cancelar</button>
                        </div>
                        <br>
                </div>
            </div>
        </div>
        </div>
    </form>
</div>
<!-- MODAL -->
<div class="modal" id="exampleModal" width="1600" >
    <div class="modal-dialog border-danger modal-xl ">
        <div class="modal-content  border-danger modal-xl">
            <div class="modal-header  border-danger modal-xl">
                <h5>Datos de Contenedores</h5>
            </div>
            <div class="modal-body border-danger modal-xl formBody">
                <div class="row">
                    <div class="col-md-2">
                        <label for="inputCity" class="form-label form-control-sm text-danger">NUMERO</label>
                        <input type="text" class="form-control form-control-sm" id="contenedor" name="contenedor" autocomplete="off"  style="text-transform:uppercase" >
                    </div>
                    <div class="col-md-3">
                        <label for="inputState" class="form-label form-control-sm text-danger">TIPO </label>
                        <select id="tipo" name="tipo[]" class="form-select form-select-sm text-uppercase" >
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
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label form-control-sm text-danger">MERCANCIA O PRODUCTO</label>
                        <input type="text" class="form-control form-control-sm" id="producto" name="producto" style="text-transform:uppercase" autocomplete="off">
                    </div>
                    <div class="col-md-2">
                        <label for="inputCity" class="form-label form-control-sm text-danger">CANTIDAD</label>
                        <input type="number" class="form-control form-control-sm" id="ccontenedor" name="ccontenedor" autocomplete="off" value="0">
                    </div>
                    <div class="col-md-2">
                        <label for="inputCity" class="form-label form-control-sm text-danger">VENTA UNITARIA</label>
                        <input type="number" step="0.01"  class="form-control form-control-sm" id="venta" name="venta" autocomplete="off" value="0">
                    </div>     
                    <div class="col-md-2">
                        <label for="inputCity" class="form-label form-control-sm text-danger">VENTA</label>
                        <input type="number" step="0.01"  class="form-control form-control-sm" id="vtotal" name="vtotal" autocomplete="off" value="0" readonly>
                    </div>
                    <div class="col-md-2">
                        <label for="inputCity" class="form-label form-control-sm text-danger">COMPRA</label>
                        <input type="number" step="0.01" class="form-control form-control-sm" id="compra" name="compra" autocomplete="off" value="0" >
                    </div>
                    <div class="col-md-2">
                        <label for="inputCity" class="form-label form-control-sm text-danger">PROFIT</label>
                        <input type="number" step="0.01"  class="form-control form-control-sm" id="vprofit" name="vprofit" autocomplete="off" value="0" readonly>
                    </div>
                </div>
        </div>
        <div class="modal-footer border-danger modal-xl">
            <button class="btn btn-dark" id="btnAgregar" data-dismiss="modal" onclick="$('#exampleModal').modal('hide');" >Agregar</button>
            <button class="btn btn-danger" id="btnCancelar" data-dismiss="modal" onclick="$('#exampleModal').modal('hide');" >Cancelar</button>
        </div>
    </div>
</div>
<!-- FIN MODAL -->


<script src="codigo.js"></script>
<script src="calculo.js"></script></script>
<script>
    document.getElementById("listatrans").addEventListener("change", function() {
    
        // Obtener el valor seleccionado
    var valorSeleccionado = this.value;
    console.log("valor seleccionado en transporte ");
    console.log(valorSeleccionado);
    
    if (valorSeleccionado == 'AEREO') {
        // Mostrarlo en el campo MBL BOOKING
        document.getElementById("mblBooking").value = 'AW';
    }else if(valorSeleccionado == 'TERRESTRE') {
        // Mostrarlo en el campo MBL BOOKING
        document.getElementById("mblBooking").value = 'CMR';
    }else{
        // Mostrarlo en el campo MBL BOOKING
    document.getElementById("mblBooking").value = 'MBL';
    }
    
    });
    function FormSubmitgk(event) {
    event.preventDefault(); // Evita recargar la página

    console.log("Estamos en la acción del botón");

    if (bandera) { 
        console.log("Antes de guardar...");

        // Recopilar datos del formulario en un objeto
        let formDataObject = {};
        let formElement = document.getElementById("miFormulario");
        let formData = new FormData(formElement);
        let camposVacios = []; // Lista de campos vacíos

        formData.forEach((value, key) => {
            if (value.trim() === "") {
            camposVacios.push(key);
            
        } else {
            formDataObject[key] = value.trim();
        }

        });
        // Validar si hay campos vacíos
        if (camposVacios.length > 0) {
        alert("Por favor completa los siguientes campos antes de enviar: " + camposVacios.join(", "));
        return;
        }

        // Recopilar datos de la tabla en un array
    let datosTabla = [];
    let tablaVacia = true;

    $(".table tbody tr").each(function () {
        let fila = {
            contenedor: $(this).find("td:nth-child(2)").text().trim(),
            tipo: $(this).find("td:nth-child(3)").text().trim(),
            producto: $(this).find("td:nth-child(4)").text().trim(),
            cantidad: parseFloat($(this).find("td:nth-child(5)").text().trim()) || 0,
            ventaUnitaria: parseFloat($(this).find("td:nth-child(6)").text().trim()) || 0,
            totalVenta: parseFloat($(this).find("td:nth-child(7)").text().trim()) || 0,
            compra: parseFloat($(this).find("td:nth-child(8)").text().trim()) || 0,
            profit: parseFloat($(this).find("td:nth-child(9)").text().trim()) || 0
        };

        if (fila.contenedor !== "" && fila.tipo !== "" && fila.producto !== "") {
            tablaVacia = false;
        }

        datosTabla.push(fila);
    });

    // Validar si la tabla está vacía
    if (tablaVacia) {
        alert("La tabla no puede estar vacía. Por favor ingresa datos antes de enviar.");
        return;
    }
        // Crear objeto para enviar los datos al servidor
        let datosEnviar = {
            formulario: formDataObject,
            tabla: datosTabla
        };

        console.log("Datos a enviar:", datosEnviar); // Verifica en la consola

        // Enviar datos al servidor en formato JSON
        fetch("guardar2.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datosEnviar)
        })
        .then(response => response.text())
        .then(data => {
            console.log("Datos a enviar al servidor:", JSON.stringify(datosEnviar));
            console.log("Respuesta del servidor:", data);
            alert("Datos guardados correctamente");
             // Limpiar los campos del formulario
             document.getElementById("miFormulario").reset();

            // Vaciar la tabla eliminando todas las filas del tbody
            $(".table tbody").empty();
        })
        .catch(error => console.error("Error al guardar:", error));
    }
}



  // Función para calcular y mostrar el resultado del profit
  function calculateprofit() {
    const val3 = parseFloat(document.getElementById("vtotal").value) || 0;
    const val4 = parseFloat(document.getElementById("compra").value) || 0;
    const results = val3 - val4;
    console.log("en la resta")
    console.log(val3)
    console.log(val4)
    console.log(results)
    document.getElementById("vprofit").value = results.toFixed(2);
  }

  // Agregar eventos para que la función se ejecute al escribir en los inputs
  document.getElementById("vtotal").addEventListener("input", calculateprofit);
  document.getElementById("compra").addEventListener("input", calculateprofit);

  $("#btnAgregar").click(function() {
    let contenedor = $("#contenedor").val();
    let tipo = $("#tipo").val();
    let producto = $("#producto").val();
    let cantidad = $("#ccontenedor").val();
    let ventaUnitaria = $("#venta").val();
    let totalVenta = $("#vtotal").val();
    let compra = $("#compra").val();
    let profit = $("#vprofit").val();

    // Verifica que los campos no estén vacíos
    if (contenedor.trim() !== "" && tipo.trim() !== "" && producto.trim() !== "") {
        agregarFila(contenedor, tipo, producto, cantidad, ventaUnitaria, totalVenta, compra, profit);
        $("#exampleModal").modal("hide"); // Oculta el modal después de guardar
    } else {
        alert("Por favor, completa todos los campos obligatorios.");
    }
});
let num = 0;
function agregarFila(contenedor, tipo, producto, cantidad, ventaUnitaria, totalVenta, compra, profit) {
    num++;
    let filaNueva = `<tr>
        <td>${num}</td> 
        <td>${contenedor}</td>
        <td>${tipo}</td>
        <td>${producto}</td>
        <td>${cantidad}</td>
        <td>${ventaUnitaria}</td>
        <td>${totalVenta}</td>
        <td>${compra}</td>
        <td>${profit}</td>
        <td><i class="btn btn-outline-danger eliminarFila">
    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
    </svg>
</i>

        </td>
    </tr>`;

    $(".table tbody").append(filaNueva); // Agrega la fila a la tabla
    actualizarTotales();
}

$(document).on("click", ".eliminarFila", function() {
    $(this).closest("tr").remove();
});

// Función para sumar columnas y actualizar el input
function actualizarTotales() {
    let sumaCantidad = 0;
    let sumaTotal = 0;
    let sumaCompra = 0;
    let sumaProfit = 0;

    $(".table tbody tr").each(function() {
        console.log(" para conocer los valores de las filas ");
        console.log($(this).children("td:nth-child(5)").text().trim());
        sumaCantidad += parseFloat($(this).children("td:nth-child(5)").text().trim()) || 0;
        sumaTotal += parseFloat($(this).children("td:nth-child(7)").text().trim()) || 0;
        sumaCompra += parseFloat($(this).children("td:nth-child(8)").text().trim()) || 0;
        sumaProfit += parseFloat($(this).children("td:nth-child(9)").text().trim()) || 0;
    });
    console.log("valor total de contenedores ",sumaCantidad);
    
    $("#tcontenedoresT").val(sumaCantidad);
    $("#tventaT").val(sumaTotal);
    $("#compraT").val(sumaCompra);
    $("#profitT").val(sumaProfit);
}

// Llamar `actualizarTotales()` cada vez que se elimine una fila
$(document).on("click", ".eliminarFila", function() {
    $(this).closest("tr").remove();
    actualizarTotales(); // Recalcular totales después de eliminar
});


</script>

<?php  include_once("pie.php");?>