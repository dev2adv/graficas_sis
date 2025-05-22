// Función para calcular y mostrar el resultado de vental total
function calculateAndDisplayResult() {
    const val1 = parseFloat(document.getElementById("ccontenedor").value) || 0;
    const val2 = parseFloat(document.getElementById("venta").value) || 0;
    const result = val1 * val2;
    document.getElementById("vtotal").value = result;
  }

  // Agregar eventos para que la función se ejecute al escribir en los inputs
  document.getElementById("ccontenedor").addEventListener("input", calculateAndDisplayResult);
  document.getElementById("venta").addEventListener("input", calculateAndDisplayResult);

  