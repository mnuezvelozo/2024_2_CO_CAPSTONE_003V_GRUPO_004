<script>
    // Grafico Vehiculos Activos/Inactivos
    var ctxVehiculos = document.getElementById('vehiculosActivosChart').getContext('2d');
    var vehiculosActivosData = {
        labels: ['Activo', 'Inactivo'],
        datasets: [{
            label: 'Vehículos Activos/Inactivos',
            data: [
                <?php
                // Extraer los datos de activos e inactivos del array vehiculos_activos_data
                $activo = 0;
                $inactivo = 0;
                foreach ($vehiculos_activos_data as $vehiculo) {
                    if ($vehiculo['activo'] == 'Si') {
                        $activo = $vehiculo['cantidad'];
                    } else {
                        $inactivo = $vehiculo['cantidad'];
                    }
                }
                echo $activo . ',' . $inactivo;
                ?>
            ],
            backgroundColor: [
                'rgba(54, 162, 235, 0.6)', // Color para Activo
                'rgba(255, 99, 132, 0.6)' // Color para Inactivo
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)', // Borde para Activo
                'rgba(255, 99, 132, 1)' // Borde para Inactivo
            ],
            borderWidth: 1
        }]
    };

    var vehiculosActivosChart = new Chart(ctxVehiculos, {
        type: 'bar', // Tipo de gráfico de torta
        data: vehiculosActivosData,
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