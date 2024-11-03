<div class="modal fade" id="modalAgregarSolicitud" tabindex="-1" aria-labelledby="modalAgregarSolicitudLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarSolicitudLabel">Nueva Solicitud de Combustible</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Cambiar el formulario para manejar el submit con JavaScript -->
            <form id="formAgregarSolicitud" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="patente" class="form-label">Patente</label>
                        <select class="form-select" name="patente" id="patente" onchange="obtenerKilometraje()" required>
                            <option selected disabled>Seleccione un vehículo</option>
                            <?php
                            $sql_vehiculos = "SELECT patente, marca, modelo FROM vehiculo WHERE rut = ?";
                            $stmt_vehiculos = $conexion->prepare($sql_vehiculos);
                            if ($stmt_vehiculos) {
                                $stmt_vehiculos->bind_param('s', $rut);
                                $stmt_vehiculos->execute();
                                $resultado_vehiculos = $stmt_vehiculos->get_result();
                                if ($resultado_vehiculos && $resultado_vehiculos->num_rows > 0) {
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById("formAgregarSolicitud").addEventListener("submit", function(event) {
        event.preventDefault(); // Evitar el envío estándar del formulario

        // Obtener los datos del formulario
        var formData = new FormData(this);

        // Enviar la solicitud AJAX para agregar la solicitud
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "php/agregar_solicitud.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Si la solicitud es exitosa, mostrar una alerta de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Solicitud agregada',
                        text: 'La solicitud de combustible se ha agregado exitosamente.',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Recargar la página después de cerrar la alerta
                        window.location.reload();
                    });
                } else {
                    // Mostrar una alerta de error si falla la solicitud
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo agregar la solicitud de combustible.',
                        confirmButtonText: 'OK'
                    });
                }
            }
        };

        // Enviar el formulario
        xhr.send(formData);
    });

    var kilometrajeActual = 0;

    function obtenerKilometraje() {
        var patenteSeleccionada = document.getElementById("patente").value;

        if (patenteSeleccionada) {
            // Realizar la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "AJAX/obtener_kilometraje.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    kilometrajeActual = parseInt(xhr.responseText);
                    document.getElementById("kilometraje_actual").value = kilometrajeActual;
                    validarKilometraje();
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
            btnSubmit.disabled = true;
        } else {
            errorMensaje.style.display = "none";
            btnSubmit.disabled = false;
        }
    }
</script>
