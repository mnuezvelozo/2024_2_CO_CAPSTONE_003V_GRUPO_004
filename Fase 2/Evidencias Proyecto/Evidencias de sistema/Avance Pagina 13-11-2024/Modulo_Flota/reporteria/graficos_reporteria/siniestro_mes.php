<script>
    var ctx1 = document.getElementById('siniestrosMesChart').getContext('2d');

    var siniestrosMesData = {
        labels: [
            <?php foreach ($siniestro_data as $siniestro) {
                echo "'" . $siniestro['mes_nombre'] . "',";
            } ?>
        ],
        datasets: [{
            label: 'Siniestros por Mes',
            data: [
                <?php foreach ($siniestro_data as $siniestro) {
                    echo $siniestro['cantidad'] . ",";
                } ?>
            ],
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2
        }]
    };

    var siniestrosMesChart = new Chart(ctx1, {
        type: 'bar',
        data: siniestrosMesData,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stepSize: 1, // Aumenta de 1 en 1 en el eje Y
                    ticks: {
                        precision: 0 // Asegura que solo se muestren números enteros
                    },
                    title: {
                        display: true,
                        text: 'Cantidad de Siniestros'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mes'
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
