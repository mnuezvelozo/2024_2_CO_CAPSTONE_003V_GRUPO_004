<div class="modal fade" id="modalAgregarSolicitud" tabindex="-1" aria-labelledby="modalAgregarSolicitudLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarSolicitudLabel">Nueva Solicitud de Combustible</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="php/agregar_solicitud.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patente" class="form-label">Patente</label>
                        <select class="form-select" name="patente" id="patente" onchange="obtenerKilometraje()" required>
                            <option selected disabled>Seleccione un vehículo</option>
                            <?php
                            // Obtener la lista de vehículos donde el rut del encargado es el mismo que el del usuario autenticado
                            $sql_vehiculos = "SELECT patente, marca, modelo FROM vehiculo WHERE rut = ?";
                            $stmt_vehiculos = $conexion->prepare($sql_vehiculos);
                            if ($stmt_vehiculos) {
                                $stmt_vehiculos->bind_param('s', $rut); // $rut contiene el rut del usuario autenticado
                                $stmt_vehiculos->execute();
                                $resultado_vehiculos = $stmt_vehiculos->get_result();

                                // Verificar si hay vehículos asociados al rut
                                if ($resultado_vehiculos && $resultado_vehiculos->num_rows > 0) {
                                    // Mostrar los vehículos disponibles en el select
                                    while ($vehiculo = $resultado_vehiculos->fetch_assoc()):
                            ?>
                                        <option value="<?= htmlspecialchars($vehiculo['patente']) ?>">
                                            <?= htmlspecialchars($vehiculo['patente']) ?> - <?= htmlspecialchars($vehiculo['marca']) ?> <?= htmlspecialchars($vehiculo['modelo']) ?>
                                        </option>
                                    <?php endwhile;
                                } else { ?>
                                    <option disabled>No tiene vehículos disponibles</option>
                                <?php }
                            } else { ?>
                                <option disabled>Error al obtener vehículos</option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kilometraje" class="form-label">Kilometraje</label>
                        <input type="number" class="form-control" name="kilometraje_actual" id="kilometraje_actual" required oninput="validarKilometraje()">
                        <small id="error_kilometraje" class="text-danger" style="display: none;">El kilometraje ingresado no puede ser menor al actual.</small>
                    </div>
                    <div class="mb-3">
                        <label for="monto_solicitado" class="form-label">Monto Solicitado</label>
                        <input type="number" step="0.01" class="form-control" name="monto_solicitado" id="monto_solicitado" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>Agregar Solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var kilometrajeActual = 0;

    function obtenerKilometraje() {
        var patenteSeleccionada = document.getElementById("patente").value;

        if (patenteSeleccionada) {
            // Realizar la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "AJAX/obtener_kilometraje.php", true); // Archivo PHP que manejará la solicitud
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Obtener el kilometraje actual
                    kilometrajeActual = parseInt(xhr.responseText);
                    document.getElementById("kilometraje_actual").value = kilometrajeActual;
                    validarKilometraje(); // Validar de nuevo al obtener el kilometraje
                }
            };
            xhr.send("patente=" + encodeURIComponent(patenteSeleccionada));
        }
    }

    function validarKilometraje() {
        var kilometrajeIngresado = parseInt(document.getElementById("kilometraje_actual").value);
        var errorMensaje = document.getElementById("error_kilometraje");
        var btnSubmit = document.getElementById("btnSubmit");

        if (isNaN(kilometrajeIngresado) || kilometrajeIngresado < kilometrajeActual) {
            errorMensaje.style.display = "block";
            btnSubmit.disabled = true; // Deshabilitar el botón de envío
        } else {
            errorMensaje.style.display = "none";
            btnSubmit.disabled = false; // Habilitar el botón de envío
        }
    }
</script>