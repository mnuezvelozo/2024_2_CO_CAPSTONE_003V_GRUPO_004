<div class="modal fade" id="modal_actualizar" tabindex="-1" aria-labelledby="modal_actualizar" aria-hidden="true">
    <div class="modal-dialog">
        <form action="php/actualizar_personal.php" method="POST" onsubmit="return validarFormulario()">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal_actualizar">Actualizar Personal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <!-- Campo RUT (readonly) -->
                    <label for="input_rut">RUT</label>
                    <input type="text" name="rut" id="input_rut" class="form-control" readonly required>
                    <br>

                    <!-- Campo Nombre -->
                    <label for="input_nombre">Nombre</label>
                    <input type="text" name="nombre" id="input_nombre" class="form-control" required>
                    <br>

                    <!-- Campo Fecha de Ingreso -->
                    <label for="input_fecha_ingreso">Fecha de Ingreso</label>
                    <input type="date" name="fecha_ingreso" id="input_fecha_ingreso" class="form-control" required>
                    <br>

                    <!-- Campo Rol (select con id_cargo y nombre_cargo) -->
                    <label for="input_cargo">Cargo</label>
                    <select name="id_cargo" id="input_cargo" class="form-control" required>
                        <option value="">Seleccione un cargo</option>
                        <?php
                        // Conectarse a la base de datos y obtener los roles disponibles
                        $sql_cargo = "SELECT id_cargo, nombre_cargo FROM cargo";
                        $resultado_cargo = $conexion->query($sql_cargo);

                        // Iterar sobre los resultados y crear una opción para cada rol
                        while ($rol = $resultado_cargo->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($rol['id_cargo']) . '">' . htmlspecialchars($rol['nombre_cargo']) . '</option>';
                        }
                        ?>
                    </select>
                    <br>

                    <!-- Campo Supervisor (select con supervisores) -->
                    <label for="input_supervisor">Supervisor</label>
                    <select name="supervisor" id="input_supervisor" class="form-control">
                        <option value="">Seleccione un Supervisor</option>
                        <?php
                        // Conectarse a la base de datos y obtener los supervisores (id_cargo = 2)
                        $sql_supervisor = "SELECT rut, nombre FROM usuario WHERE id_cargo = 2";
                        $resultado_supervisor = $conexion->query($sql_supervisor);

                        // Iterar sobre los supervisores y crear una opción para cada uno
                        while ($supervisor = $resultado_supervisor->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($supervisor['rut']) . '">' . htmlspecialchars($supervisor['nombre']) . '</option>';
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