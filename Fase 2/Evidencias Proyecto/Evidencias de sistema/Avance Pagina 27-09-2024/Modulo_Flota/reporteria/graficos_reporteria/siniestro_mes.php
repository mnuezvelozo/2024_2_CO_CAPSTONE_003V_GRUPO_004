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
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 2
    }]
};

var siniestrosMesChart = new Chart(ctx1, {
    type: 'bar',
    data: siniestrosMesData
});
</script>