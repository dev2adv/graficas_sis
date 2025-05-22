function iframeRef(frameRef)
{
  return frameRef.contentWindow
        ? frameRef.contentWindow.document
        : frameRef.contentDocument
}

var bandera = true;
var banderames = 1;cerrar

document.addEventListener("DOMContentLoaded", () => {
    //const saveButton = document.getElementById("btnregistro");
    // var action = "guardar.php";

    // if(saveButton != null)
    // {
    //   saveButton.addEventListener("click", () => {
    //     var inside = iframeRef(document.getElementById('one'));
    //     const form = inside.getElementById("editableForm");
    //     form.setAttribute('action', action);
    //     console.log(form);
    //     form.submit();
    //   });
    // }
  });

  
  function mes(pmes)
  {
    console.log("En el método mes");
    console.log("Valor de pmes:", pmes);
    banderames = pmes;
    console.log("Valor de banderames:", banderames);
    let url = "listar.php?mes="+pmes;
    console.log("url ", url);
    let formData = new FormData();
    formData.append("mes", pmes);
    console.log("Contenido de formData:", [...formData.entries()]);
    var tabla = document.getElementById('tabla');
    console.log("Elemento tabla:", tabla);
    
    fetch(url, {
      method: "POST",
      body: formData,
      mode: "cors"
    }).then(response => response.json())
    .then(data => {
      console.log("Respuesta del servidor:", data); // Verificar si es JSON válido
      tabla.innerHTML = data;
      // location.reload();
    })
    .catch(err => console.error("Error en fetch:", err));
  }

  function modal(ron)
  {
    console.log("en el modalllll");
    document.getElementById("mi-modal").style.display = "block";

    var inside = iframeRef(document.getElementById('one'));
    const field = inside.getElementById("proveedor");
    const field2 = inside.getElementById("consignatario");
    document.getElementById("mi-modal").removeAttribute("aria-hidden");
    document.getElementById("mi-modal").querySelector(":focus")?.blur();


    
    if(ron != 0)
    {
      document.getElementById("mi-modal").removeAttribute("inert");

      bandera = false;
      var tipo = ron.split(",");
      console.log("pasa saber el valor del nro1526354");
      console.log(tipo);
      var modal = document.getElementById('modal');
      var form = inside.querySelectorAll("#editableForm");
      var table = inside.querySelectorAll("#Table tbody");
      console.log("formulario",table);
      modal.click();
      var nro = tipo[0];
      let url = "listEdit.php";
      let formData = new FormData();
      formData.append("nro", ron);
      console.log("este es ron",ron);
      //formData.append("tipo", tipo[1]);
      //console.log(tipo[1]);
      console.log(" entra ",url);
       
  fetch(url, {
        method: "POST",
        body: formData,
        mode: "cors"
    }).then(response => response.json())
    .then(data => {
      
      console.log("Datos recibidos:", data['embarques']);
        console.log("table",table[0]);
        // Obtener referencia a la tabla
        let tbody = document.querySelector(".table tbody");
        tbody.innerHTML = ""; // Limpiar datos previos

        data['embarques'].forEach((element, index) => {
            // Agregar datos al formulario
            form.forEach(tres => {
                tres[0].value = element['ro'];
                tres[1].value = element['servicio'];
                tres[2].value = element['ttransporte'];
                tres[3].value = element['naviera'];
                tres[4].value = element['proveedor'];
                tres[5].value = element['consignatario'];
                tres[6].value = element['mbl'];
                tres[7].value = element['porigen'];
                tres[8].value = element['fsalida'];
                tres[9].value = element['pllegada'];            
                tres[10].value = element['fllegada'];
                tres[11].value = element['tccontenedor'];
                tres[12].value = element['ventat'];
                tres[13].value = element['comprat'];
                tres[14].value = element['totalp'];
                tres[15].value = element['tcontable'];
                tres[16].value = element['nro'];
                tres[17].value = element['obs'];
            });
            
        });

        data['embarquesdet'].forEach((element, index) => {
          // Agregar fila a la tabla
          let row = `<tr>
            <td>${element['idemb']}</td>
            <td contenteditable="true">${element['ncontenedor']}</td>
            <td contenteditable="true">${element['tcontenedor']}</td>
            <td contenteditable="true">${element['mercancia']}</td>
            <td contenteditable="true">${element['ccontenedor']}</td>
            <td contenteditable="true">${element['venta']}</td>
            <td contenteditable="true">${element['ventat']}</td>
            <td contenteditable="true">${element['comprat']}</td>
            <td contenteditable="true">${element['totalp']}</td>
                <th>
                    <i class='btn btn-outline-primary' id='btnModal2'  onclick=\"mostrarModal2(this)\" >
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                    <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                    <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z'/>
                    </svg></i>
 
                </th>
                <th>
                    <i onclick=\"borrar('".$row['nro']."')\" class='btn btn-outline-danger'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='18' height='18' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 18 18'>
                    
                    <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0'/>
                    </svg></i>
                </th>
          </tr>`;

          table[0].innerHTML += row;

        })
    })
    .catch(err => console.log(err));
    
   
        
    if(field != null)
    {
      field.addEventListener("keyup", autocompletar);
    }

    if(field2 != null)
    {
      field2.addEventListener("keyup", autocompletar2);
    }

  }

}

$(document).ready(function() {
  $("#btnModal2").on("click", function() {
      mostrarModal2();
  });
});

function mostrarModal2(btn) {
  console.log("Entrando al modal2 con botón:", btn);

  let fila = btn.closest("tr"); // Obtener la fila correcta
  console.log("Fila encontrada:", fila);

  if (!fila) {
      console.error("Error: No se pudo encontrar la fila.");
      return;
  }

  var datos = fila.querySelectorAll("td");

  // Asignar valores al modal2
  document.getElementById("id2").value = datos[0]?.innerText.trim() || "";
  document.getElementById("contenedor").value = datos[1]?.innerText.trim() || "";
  document.getElementById("tipo").value = datos[2]?.innerText.trim() || "";
  document.getElementById("producto").value = datos[3]?.innerText.trim() || "";
  document.getElementById("ccontenedor2").value = datos[4]?.innerText.trim() || "";
  document.getElementById("venta2").value = datos[5]?.innerText.trim() || "";
  document.getElementById("vtotal2").value = datos[6]?.innerText.trim() || "";
  document.getElementById("compra2").value = datos[7]?.innerText.trim() || "";
  document.getElementById("vprofit2").value = datos[8]?.innerText.trim() || "";

  // Guardar el índice de la fila para modificarla después
  document.getElementById("modal2").setAttribute("data-fila", fila.rowIndex);

  // Mostrar el modal correctamente
  var modal = new bootstrap.Modal(document.getElementById("modal2"));
  modal.show();
}

  function seg(ron)
  {
    console.log("en el modalll seguimiento");
    console.log(ron);
    
    var inside = iframeRef(document.getElementById('ones'));
    
    if(ron != 0)
    {
      bandera = false;
      console.log("pasa saber el valor del nro");
      console.log(ron);
      var modal1 = document.getElementById('modal');
      var form = inside.querySelectorAll("#segForm");
      console.log(form);
      modal1.click();
      let url = "seguiEdit.php";
      let formDatas = new FormData();
      formDatas.append("nro", ron);
      console.log(ron);
      
      fetch(url, {
        method: "POST",
        body: formDatas,
        mode: "cors"
      })
        .then(response => {
          if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status}`);
          }
          return response.json(); // Intenta convertir la respuesta a JSON
        })
        .then(data => {
          console.log("Datos recibidos:", data);
          if (data.error) {
            console.error("Error del servidor:", data.error);
          } else {
            data.forEach(element => {
              form.forEach(tres => {
                const row = document.createElement('tr');
                row.innerHTML = `
                  <th>${element.nro}</th>
                  <th>${element.proveedor}</th>
                  <th>${element.consignatario}</th>
                  <th>${element.porigen}</th>
                  <th>${element.ro}</th>
                  <th>${element.tccontenedor}</th>
                  <th>${element.ncontenedor}</th>
                  <th>${element.tcontenedor}</th>
                  <th>${element.fsalida}</th>
                  <th>${element.fllegada}</th>
                  <th>${element.servicio}</th>
                  <th>${element.mbl}</th>
                  <th>${element.tipot}</th>
                  <th>${element.naviera}</th>
                  <th>${element.venta}</th>
                  <th>${element.obs}</th>
                `;
                tres.appendChild(row);
              });
            });
          }
        })
        .catch(err => {
          console.error("Error durante la llamada a fetch:", err);
        });
    }
    console.log('fin de seguimiento modal1');
  }

  function FormSubmit(pmes)
  {
    console.log('estamos en la accion del boton  '.pmes);
    //console.log(pmes);
    console.log(bandera);
    
    if (bandera) { 
      console.log("antes del guardar ");
      var action = "guardar.php";
      console.log('entra para guardar');
    }else
    {
      console.log(mode);
      var periodo = pmes;
      var mode = document.getElementById("mi-modal").value;
      var action = "editar.php";
      console.log('entra para editar');
      var inside = iframeRef(document.getElementById('one'));
      const form = inside.getElementById("editableForm");
      form.setAttribute('action', action);
      form.submit();
      console.log('------ FIN DE LA MODIFICACION -------');
      //cerrar(); 
      document.getElementById("btnregistro").blur(); 
      document.getElementById("mi-modal").setAttribute("aria-hidden", "false");
      //document.getElementById("miFormulario").onsubmit = function() {
      //  window.location.reload();
      let url2 = "Registro.php";
      let formData2 = new FormData();
      formData2.append("periodo", periodo);
      
      fetch(url2, {
        method: "POST",
        body: formData2,
        mode: "cors"
      }).then(response => response)
      .then(data => {
        mes(banderames);
      })
      .catch(err => console.log(err))
      
    };
    
  }


  function autocompletar()
  {
      var inside = iframeRef(document.getElementById('one'));
      let inputCP = inside.getElementById("proveedor").value
      let lista = inside.getElementById("lista")

      if(inputCP.length > 0)
      { 
        let url = "autocompletar.php";
        let formData = new FormData();
        formData.append("proveedor", inputCP);
        
        fetch(url, {
          method: "POST",
          body: formData,
          mode: "cors"
        }).then(response => response.json())
        .then(data => {
          lista.style.display = 'block'
          lista.innerHTML = data
        })
        .catch(err => console.log(err))
      }
      else
      {
        lista.style.display = 'none';
      }
  }

  function mostrar(pro)
  {
    lista.style.display = 'none';
    let inputCP = document.getElementById("proveedor");
    inputCP.value = pro;
  }

  function autocompletar2()
  {
      var inside = iframeRef(document.getElementById('one'));
      let inputCP2= inside.getElementById("consignatario").value
      let lista2 = inside.getElementById("lista2")

      if(inputCP2.length > 0)
      { 
        let url2 = "autocompletar2.php";
        let formData2 = new FormData();
        formData2.append("consignatario", inputCP2);
        
        fetch(url2, {
          method: "POST",
          body: formData2,
          mode: "cors"
        }).then(response => response.json())
        .then(data => {
          lista2.style.display = 'block'
          lista2.innerHTML = data
        })
        .catch(err => console.log(err))
      }
      else
      {
        lista2.style.display = 'none';
      }
  }

  //function mostrar2(pro)
 // {
    //lista2.style.display = 'none';
    //let inputCP2 = document.getElementById("consignatario");
    //inputCP2.value = pro;
 // }
  
  function editar(dato)
  {
    let url2 = "formuario.php";
    let formData2 = new FormData();
    formData2.append("ro", dato['ro']);
    
    fetch(url2, {
      method: "POST",
      body: formData2,
      mode: "cors"
    }).then(response => response.json())
    .then(data => {
      lista2.style.display = 'block'
      lista2.innerHTML = data
    })
    .catch(err => console.log(err))
  }

  function cerrar() {
    console.log("boton cerrar");  

    var modal = document.getElementById("mi-modal");

    // Move focus to another element before closing the modal
    document.getElementById('tipos').focus(); 

    // Close the modal using Bootstrap method
    var bootstrapModal = new bootstrap.Modal(modal);
    bootstrapModal.hide(); 

    // Ensure modal is completely hidden before setting inert
    modal.addEventListener('hidden.bs.modal', function () {
        modal.setAttribute("inert", ""); 
    });
}

  function borrar(inc)
  {
    let url2 = "eliminar.php";
    let formData2 = new FormData();
    formData2.append("inc", inc);
    console.log("borrar");
    fetch(url2, {
      method: "POST",
      body: formData2,
      mode: "cors"
    }).then(response => response)
    .then(data => {
      mes(banderames);
    })
    .catch(err => console.log(err))
    document.getElementById("mi-modal").removeAttribute("aria-hidden");
  }

  function PDF()
  {
    console.log("function PDF() ");
    const selectElement = document.getElementById("meses"); 
    console.log(selectElement.value);
    const selectedValue = selectElement.value;
    console.log(selectedValue); 
    if (selectElement.value.trim().length === 0) {
      alert("El campo está vacío");  
      console.log('El campo está vacío');
    } else {
        console.log('El campo no está vacío');
        const url = "reporte.php?mes=" + encodeURIComponent(selectedValue); 
        location.replace(url);
    }

  }

  function REPX()
  {
    const mes = $('#tipos').val();
    console.log(mes);
    //console.log(document.getElementById("mes"));
    //const selectElement = document.getElementById("mes"); 
    //const selectedValue = selectElement.value;
    //console.log(selectedValue); 
    const url = "geraRep.php?mes=" + encodeURIComponent(mes); 
    location.replace(url);
    alert("Reporte generado con éxito! RUTA ->  D:/Ventas/reporte.xls");
    //alert("Esta seguro de salir?");
    window.location.href = "Registro.php";
  }

  