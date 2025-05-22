function cerrarSesion() {
            
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "salir.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            //alert(xhr.responseText);
            alert("Esta seguro de salir?");
            window.location.href = "index.php"; // Redirigir a la página de inicio de sesión
        }
    };
    xhr.send();
}