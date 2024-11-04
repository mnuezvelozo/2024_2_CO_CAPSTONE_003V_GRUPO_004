<script>
    var ctx3 = document.getElementById('estadoSiniestroChart').getContext('2d');
    var estadoSiniestroData = {
        labels: [
            <?php foreach ($estado_siniestro_data as $estado_siniestro) {
                echo "'" . $estado_siniestro['estado'] . "',";
            } ?>
        ],
        datasets: [{
            label: 'Cantidad de Siniestros',
            data: [
                <?php foreach ($estado_siniestro_data as $siniestro) {
                    echo $siniestro['cantidad'] . ",";
                } ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)', // Color para En Reparación
                'rgba(54, 162, 235, 0.6)', // Color para Pendiente
                'rgba(255, 206, 86, 0.6)', // Color para Pérdida Total
                'rgba(75, 192, 192, 0.6)' // Color para Reparado
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)', // Borde para En Reparación
                'rgba(54, 162, 235, 1)', // Borde para Pendiente
                'rgba(255, 206, 86, 1)', // Borde para Pérdida Total
                'rgba(75, 192, 192, 1)' // Borde para Reparado
            ],
            borderWidth: 1
        }]
    };

    var estadoSiniestroChart = new Chart(ctx3, {
        type: 'bar', // Gráfico de barras
        data: estadoSiniestroData,
        options: {
            indexAxis: 'y', // Orienta las barras horizontalmente
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Estados de Siniestro'
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