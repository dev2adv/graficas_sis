function iframeRef(frameRef)
{
  return frameRef.contentWindow
        ? frameRef.contentWindow.document
        : frameRef.contentDocument
}

var bandera = true;
var banderames = 1;


  function buscar()
  {
    console.log("En el método buscar");
    //console.log("Valor de pmes:", pmes);
    //banderames = pmes;
    //console.log("Valor de banderames:", banderames);
    const pmes = document.getElementById("clien"); 
    let url = "seguiEdit.php";
    let formData = new FormData();
    formData.append("palabracl", pmes);
    console.log("Contenido de formData:", [...formData.entries()]);
    var tabla = document.getElementById('tabla');
    console.log("Elemento tabla:", tabla);
    fetch(url, {
      method: "POST",
      body: formData,
      mode: "cors"
    }).then(response => response.json())
    .then(data => {
      console.log("Información recibida:");
      console.log(data);
      tabla.innerHTML = data;
      // location.reload();
    })
    .catch(err => console.error("Error en fetch:", err));
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