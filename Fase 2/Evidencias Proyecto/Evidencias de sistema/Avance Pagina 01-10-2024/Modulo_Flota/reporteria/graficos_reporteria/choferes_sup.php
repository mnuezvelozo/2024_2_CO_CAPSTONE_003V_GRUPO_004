<canvas id="choferesPorSupervisorChart" width="400" height="400"></canvas>

<script>
    var ctx = document.getElementById('choferesPorSupervisorChart').getContext('2d');
    var choferesPorSupervisorData = {
        labels: [
            <?php foreach ($choferes_por_supervisor_data as $choferes) {
                echo "'" . $choferes['supervisor'] . "',";
            } ?>
        ],
        datasets: [{
            label: 'Cantidad de Choferes',
            data: [
                <?php foreach ($choferes_por_supervisor_data as $choferes) {
                    echo $choferes['cantidad_choferes'] . ",";
                } ?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    };

    var choferesPorSupervisorChart = new Chart(ctx, {
        type: 'doughnut', // Tipo de gráfico: dona
        data: choferesPorSupervisorData,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
</script>
