<script>
    var ctx2 = document.getElementById('kmVehiculoChart').getContext('2d');

    var kmVehiculoData = {
        labels: [
            <?php foreach ($vehiculo_data as $km_vehiculo) {
                echo "'" . $km_vehiculo['patente'] . "',";
            } ?>
        ],
        datasets: [{
            label: 'Kilometraje por Vehículo (Km)',
            data: [
                <?php foreach ($vehiculo_data as $km_vehiculo) {
                    echo $km_vehiculo['total_km'] . ",";
                } ?>
            ],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2,
            fill: false, // No rellenar debajo de la línea
            tension: 0.1 // Suavizar las líneas entre puntos
        }]
    };

    var kmVehiculoChart = new Chart(ctx2, {
        type: 'line', // Tipo de gráfico 'line' para líneas
        data: kmVehiculoData,
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Vehículos'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Kilometraje (Km)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>