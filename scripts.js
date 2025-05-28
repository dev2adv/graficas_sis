const opcionesBarras = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            categoryPercentage: 1, // Reducir el espacio ocupado por la categoría
            barPercentage: 0.6, // Reducir el tamaño relativo de las barras
            ticks: { autoSkip: false }
        },
        y: { beginAtZero: true }
    }
};

const opcionesBarrasAjustadas = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        x: {
            categoryPercentage: 1, // Controlar el espacio asignado a cada barra
            barPercentage: 0.6, // Ajustar el tamaño relativo
            ticks: { autoSkip: false }
        },
        y: { beginAtZero: true }
    },
    plugins: {
        legend: { display: false },
        tooltip: { enabled: true }
    },
    elements: {
        bar: { maxBarThickness: 60 } // Limitar el grosor máximo de una barra
    }
};

function actualizarGraficas([datos1, datos2, datos3]) {
    // Obtener los contextos de los canvas donde se renderizarán los gráficos
    const ctx1 = document.getElementById("ventasChart").getContext("2d");
    const ctx2 = document.getElementById("cobrosChart").getContext("2d");
    const ctx3 = document.getElementById("pagosChart").getContext("2d");

    // Verificar si los datos están vacíos antes de generar los gráficos
    if (datos1.length === 0) console.warn("Sin datos para Ventas.");
    if (datos2.length === 0) console.warn("Sin datos para Tipo de Transporte.");
    if (datos3.length === 0) console.warn("Sin datos para Tipo de Vendedor.");

     // Si ya existe un gráfico, destruirlo antes de crear uno nuevo
    if (charts["ventasChart"]) charts["ventasChart"].destroy();
    if (charts["cobrosChart"]) charts["cobrosChart"].destroy();
    if (charts["pagosChart"]) charts["pagosChart"].destroy();    


    // Función auxiliar para construir datasets
    const generarDataset = (datos, titulo) => {
        const labels = [...new Set(datos.map(row => row.periodo))];
        const tiposUnicos = [...new Set(datos.map(row => row.tipo))];

        return {
            labels,
            datasets: tiposUnicos.map(tipo => ({
                label: `${titulo} - ${tipo}`,
                data: labels.map(periodo => {
                    const entry = datos.find(row => row.periodo === periodo && row.tipo === tipo);
                    return entry ? entry.cantidad : 0;
                }),
                backgroundColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.6)`,
                borderWidth: 2
            }))
        };
    };

    const opcionesBarras = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                categoryPercentage: 0.6, // Ajusta el espacio que ocupa cada barra dentro del eje
                barPercentage: 0.8, // Ajusta el tamaño relativo de cada barra
                ticks: { autoSkip: false }
            },
            y: { beginAtZero: true }
        }
    };

     // Crear nuevos gráficos y almacenarlos en `charts`
    charts["ventasChart"] = new Chart(ctx1, { type: "bar", data: generarDataset(datos1, "Ventas Sucursal"), options: opcionesBarrasAjustadas });
    charts["cobrosChart"] = new Chart(ctx2, { type: "bar", data: generarDataset(datos2, "Tipo de Transporte"), options: opcionesBarrasAjustadas });
    charts["pagosChart"] = new Chart(ctx3, { type: "bar", data: generarDataset(datos3, "Vendedor"), options: opcionesBarrasAjustadas }); // Crear gráficos con los datos obtenidos
    /*new Chart(ctx1, { type: "bar", data: generarDataset(datos1, "Ventas Sucursal"), options: { responsive: true, maintainAspectRatio: false } });
    new Chart(ctx2, { type: "bar", data: generarDataset(datos2, "Tipo de Transporte"), options: { responsive: true, maintainAspectRatio: false } });
    new Chart(ctx3, { type: "bar", data: generarDataset(datos3, "Tipo de Vendedor"), options: { responsive: true, maintainAspectRatio: false } });
    */
    }
let charts = {}; // Almacenar las instancias de los gráficos

function procesarDatos(usuario, mes) {
    const urlBase = "http://192.168.0.117/"; // Cambia esto a la URL base correcta

    const endpoints = [
        `${urlBase}estadisticaSuc_cod2.php?usuario=${usuario}&mes=${mes}`,
        `${urlBase}estadisticaSuc_cod.php?usuario=${usuario}&mes=${mes}`,
        `${urlBase}estadisticaSuc_cod3.php?usuario=${usuario}&mes=${mes}`
    ];

    Promise.all(endpoints.map(url => fetch(url).then(res => res.json())))
        .then(data => {
            console.log("Datos recibidos:", data);
            if (data.every(arr => arr.length === 0)) {
               console.warn("Las APIs devolvieron datos vacíos para el mes seleccionado.");
            return;
    }
            actualizarGraficas(data);
        })
        .catch(error => console.error("Error en fetch:", error));
}
document.addEventListener("DOMContentLoaded", () => {
    function procesarGrafico (endpoint,usuario,mes, canvasId, titulo) {
        const url = `${urlBase}${endpoint}?usuario=${usuario}&mes=${mes}`; // Construir la URL correctamente
        fetch(url) // Agregar el usuario a la URL
            .then(response => response.json())
            .then(data => {
                 console.log(`JSON recibido de ${titulo}:`, JSON.stringify(data, null, 2));
                if (data.length === 0) {
                    console.warn(`No hay datos para ${titulo}`);
                    return; // No generar el gráfico si no hay datos
                }
                const labels = [...new Set(data.map(row => row.periodo))];
                const tiposUnicos = [...new Set(data.map(row => row.tipo))];

                const datasets = tiposUnicos.map(tipo => ({
                    label: `${titulo} - ${tipo}`,
                    data: labels.map(periodo => {
                    const entry = data.find(row => row.periodo === periodo && row.tipo === tipo);
                    return entry ? entry.cantidad : 0;  // Si no hay datos, usa 0
                    }), 
                    backgroundColor: `rgba(${Math.random() * 255}, ${Math.random() * 255}, ${Math.random() * 255}, 0.6)`,
                    borderWidth: 2,
                    barThickness: 'flex', // Ajusta el grosor automáticamente
                    maxBarThickness: 80 // Limita el tamaño máximo de las barras
                }));


                //console.log("Datos recibidos de estadisticaSuc_cod2.php:", JSON.stringify(data, null, 2));
                //console.log("Datos recibidos de estadisticaSuc_cod.php:", JSON.stringify(data, null, 2));

                /*datasets.forEach(dataset => {
                    console.log(`Dataset: ${dataset.label}`, dataset.data);
                });
                */

                new Chart(document.getElementById(canvasId).getContext("2d"), {
                    type: "bar",
                    data: { labels, datasets },
                    options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
                });
            });
            //.catch(error => console.error(`Error al cargar datos de ${titulo}:`, error));
    };

    // Llamadas para generar ambos gráficos
    //fetch(`estadisticaSuc_cod2.php?usuario=<?php echo $usuario; ?>`)
    //procesarGrafico("estadisticaSuc_cod2.php", "ventasChart", "Ventas sucursal: ");
    //procesarGrafico("estadisticaSuc_cod.php", "cobrosChart", "Tipo");
    //procesarGrafico("estadisticaSuc_cod3.php", "pagosChart", "Vendedor");
    /*document.addEventListener("DOMContentLoaded", () => {
            const usuario = document.getElementById("usuario").textContent.trim(); // Tomar usuario desde un elemento HTML
            const mes = document.getElementById("mesSeleccionado").value; // Obtener mes seleccionado
            //procesarDatos(usuario, mes);
           // procesarGrafico(`estadisticaSuc_cod2.php`, usuario, mes, "ventasChart", "Ventas sucursal");
            //procesarGrafico(`estadisticaSuc_cod.php`, usuario, mes, "cobrosChart", "tipo");
            //procesarGrafico(`estadisticaSuc_cod3.php`, usuario, mes, "pagosChart", "Vendedor");
        });
    */
//modificacion para mostrar datos solo si selecciona mes
document.getElementById("mesSeleccionado").addEventListener("change", function() {
    const usuario = document.getElementById("usuario").textContent.trim(); // Obtener usuario
    const mes = this.value; // Capturar el periodo seleccionado

    if (mes) {
        console.log("Nuevo periodo seleccionado:", mes);

        // Mostrar los gráficos cuando se selecciona un periodo
        document.getElementById("graficosContainer").style.display = "block";

        // Llamar a la función para cargar los datos y generar los gráficos
        procesarDatos(usuario, mes);
    }
});

});
