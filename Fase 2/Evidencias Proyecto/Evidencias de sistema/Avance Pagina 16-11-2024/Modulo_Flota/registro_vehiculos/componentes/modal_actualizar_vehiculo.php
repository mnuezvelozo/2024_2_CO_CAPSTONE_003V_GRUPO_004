<div class="modal fade" id="modal_actualizar" tabindex="-1" aria-labelledby="modal_actualizar_label" aria-hidden="true">
    <div class="modal-dialog">
        <form action="php/actualizar_vehiculo.php" method="POST" onsubmit="return validarFormulario()">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_actualizar_label">Actualizar Vehículo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Campo Patente (readonly) -->
                    <label for="input_patente">Patente</label>
                    <input type="text" name="patente" id="input_patente" class="form-control" readonly required>

                    <!-- Campo Marca -->
                    <label for="input_marca">Marca</label>
                    <input type="text" name="marca" id="input_marca" class="form-control" required>

                    <!-- Campo Modelo -->
                    <label for="input_modelo">Modelo</label>
                    <input type="text" name="modelo" id="input_modelo" class="form-control" required>

                    <!-- Campo Año (validación para 4 dígitos y solo números) -->
                    <label for="input_año">Año</label>
                    <input type="text" name="año" id="input_año" class="form-control" maxlength="4" required>

                    <!-- Campo Kilometraje Actual (solo números) -->
                    <label for="input_km_actual">Kilometraje Actual</label>
                    <input type="number" name="km_actual" id="input_km_actual" class="form-control" min="0" required>

                    <!-- Campo Fecha de Revisión Técnica -->
                    <label for="input_fecha_revision_tecnica">Fecha de Revisión Técnica</label>
                    <input type="date" name="fecha_revision_tecnica" id="input_fecha_revision_tecnica" class="form-control" required>

                    <!-- Campo Responsable -->
                    <label for="input_rut">Responsable</label>
                    <select name="rut" id="input_rut" class="form-control">
                        <option value="" disabled selected>Seleccione un responsable</option>
                        <option value="NULL">Sin responsable</option>
                        <?php
                        // Conectarse a la base de datos y obtener los usuarios registrados
                        $sql_usuarios = "SELECT rut, nombre FROM usuario WHERE activo = 'Si'";
                        $resultado_usuarios = $conexion->query($sql_usuarios);

                        // Iterar sobre los resultados y crear una opción para cada usuario
                        while ($usuario = $resultado_usuarios->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($usuario['rut']) . '">' . htmlspecialchars($usuario['rut']) . ' | ' . htmlspecialchars($usuario['nombre']) . '</option>';
                        }
                        ?>
                    </select>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>