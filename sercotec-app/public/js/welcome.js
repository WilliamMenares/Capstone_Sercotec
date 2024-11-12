document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('graficoBarras').getContext('2d');
    var empresasPorMes = JSON.parse(document.getElementById('empresasPorMesData').textContent);

    // Convertir las claves a nombres de meses
    var labels = Object.keys(empresasPorMes).map(function(key) {
        var [year, month] = key.split('-');
        var date = new Date(year, month - 1); // Restar 1 al mes porque los meses en JavaScript son 0-indexados
        return date.toLocaleString('default', { month: 'long' });
    });
    var data = Object.values(empresasPorMes);

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Número de empresas',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Asegurar que los números del eje Y sean enteros
                    }
                }
            }
        }
    });
});
