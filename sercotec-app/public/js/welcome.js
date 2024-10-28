document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('graficoBarras').getContext('2d');

    const data = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
        datasets: [{
            label: 'Empresas por Mes',
            data: [12, 15, 18, 22, 30, 25], // Ejemplo de datos
            backgroundColor: 'rgba(76, 175, 80, 0.7)', 
            borderColor: '#388E3C', 
            borderWidth: 1
        }]
    };

    const graficoBarras = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: true, // Ajusta el gráfico sin distorsión
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: 'white' // Color de la leyenda
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: 'white'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)'
                    },
                    ticks: {
                        color: 'white'
                    }
                }
            },
            layout: {
                padding: 10
            }
        }
    });
});

//grafico torta
document.addEventListener('DOMContentLoaded', function() {
    const ctxTorta = document.getElementById('graficoTorta').getContext('2d');

    const dataTorta = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
        datasets: [{
            label: 'Empresas por Mes',
            data: [12, 15, 18, 22, 30, 25], // Datos de ejemplo
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    const graficoTorta = new Chart(ctxTorta, {
        type: 'pie',
        data: dataTorta,
        options: {
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: 'white'
                    }
                }
            },
            layout: {
                padding: 10
            }
        }
    });
});
