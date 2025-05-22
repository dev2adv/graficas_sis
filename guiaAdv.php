


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guía ADVANCELINE</title>
    <link rel="shortcut icon" href="images/SoloA Logo.png " type="image/x-icon" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
    font-family: 'Montserrat', sans-serif;
}

    .container {
    display: flex;
    justify-content: center;
    align-items: center;
}

</style>

</head>
<body>




<nav class="navbar navbar-light bg-light">
  <div class="container d-flex justify-content-center">
      <img src="/images/NUEVO.png" alt="Logo" width="250" height="100">
  </div>
</nav>
<br>
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="GERENCIA" type="button" role="tab" aria-controls="home" aria-selected="true">GERENCIA</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="PRICING" type="button" role="tab" aria-controls="profile" aria-selected="false">PRICING</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="COMERCIAL" type="button" role="tab" aria-controls="comer" aria-selected="false">COMERCIAL</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="oper-tab" data-bs-toggle="tab" data-bs-target="OPERACIONES" type="button" role="tab" aria-controls="opera" aria-selected="false">OPERACIONES</button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="cob-tab" data-bs-toggle="tab" data-bs-target="COBRANZAS" type="button" role="tab" aria-controls="cobra" aria-selected="false">COBRANZAS</button>
  </li> 
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="cont-tab" data-bs-toggle="tab" data-bs-target="CONTABILIDAD" type="button" role="tab" aria-controls="contab" aria-selected="false">CONTABILIDAD</button>
  </li> 
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="mark-tab" data-bs-toggle="tab" data-bs-target="MARKETING" type="button" role="tab" aria-controls="marck" aria-selected="false">MARKETING</button>
  </li> 
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="sist-tab" data-bs-toggle="tab" data-bs-target="SISTEMAS" type="button" role="tab" aria-controls="siste" aria-selected="false">SISTEMAS</button>
  </li> 
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="recu-tab" data-bs-toggle="tab" data-bs-target="RRHH" type="button" role="tab" aria-controls="recur" aria-selected="false">RRHH</button>
  </li>
  
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab"><div class="accordion-body">
        <div class="d-md-flex align-items-center justify-content-center ">
        <div class="table-responsive">
            <BR></BR>
                <table class="table table-hover table-sm" id="regGDT" style="font-size: 14px;">
                    <thead class="table-danger" style="text-align: center; font-weight: bold;" >
                        <tr style="text-align: center; font-weight: bold;" >
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th>Cargo</th>
                            <th>Email</th>
                            <th>Celular</th>
                            <th>Sucursal</th>
                            <th>Ciudad</th>
                        </tr>
                    </thead>
                    <tbody >
                    
                    </tbody>
                </table>
        </div>
    </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   
document.querySelectorAll(".nav-link").forEach(button => {
    button.addEventListener("click", function() {
        var areaSeleccionada = this.innerText.trim(); // Obtener el texto del botón como área
        console.log("Área seleccionada:", areaSeleccionada);
        var idBoton = this.getAttribute("id");
    var targetTab = this.getAttribute("data-bs-target");
    
    console.log("ID 2 del botón:", idBoton);
    console.log("Target 2 de la pestaña:", targetTab);

    fetch("guia_cod.php?area=" + encodeURIComponent(targetTab))
            .then(response => response.json())
            .then(data => {
                let tabla = document.getElementById("regGDT").getElementsByTagName("tbody")[0];
                tabla.innerHTML = ""; // Limpiar tabla antes de agregar nuevos datos
                data.forEach(trabajador => {
                    let fila = `<tr style="font-size: 14px;">
                        <td>${trabajador.nro}</td>
                        <td>${trabajador.trabajador}</td>
                        <td>${trabajador.cargo}</td>
                        <td>${trabajador.email}</td>
                        <td>${trabajador.celular}</td>
                        <td>${trabajador.sucursal}</td>
                        <td>${trabajador.ciudad}</td>
                    </tr>`;
                    tabla.innerHTML += fila;
                });
            })
            .catch(error => console.error("Error al cargar los datos:", error));
    });
});

</script>

</body>
</html>

