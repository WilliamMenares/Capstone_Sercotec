document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('graficoBarras').getContext('2d');
    var empresasPorMes = JSON.parse(document.getElementById('empresasPorMesData').textContent);

    // Convertir las claves a nombres de meses
    var labels = Object.keys(empresasPorMes).map(function(key) {
        var date = new Date(key + '-01');
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
                        stepSize: 1 
                    }
                }
            }
        }
    });
});
