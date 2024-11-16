<!-- Modal Agregar Personal -->
<div class="modal fade" id="modalAgregarPersonal" tabindex="-1" role="dialog" aria-labelledby="modalAgregarPersonalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formAgregarPersonal" method="POST" action="php/agregar_personal.php">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAgregarPersonalLabel">Agregar Nuevo Personal</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>

                <div class="modal-body">
                    <!-- Campo RUT -->
                    <label for="rut">RUT</label>
                    <input type="text" class="form-control" id="rut" name="rut" placeholder="Ingrese el rut con puntos y guión" required>
                    <br>

                    <!-- Campo Nombre -->
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Primer Nombre y los dos Apellidos" required>
                    <br>

                    <!-- Campo Fecha de Ingreso -->
                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                    <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                    <br>

                    <!-- Campo Rol (select con id_cargo y nombre_cargo) -->
                    <label for="id_cargo">Cargo</label>
                    <select name="id_cargo" id="id_cargo" class="form-control" required>
                        <option value="">Seleccione un Cargo</option>
                        <?php
                        // Conectarse a la base de datos y obtener los cargo disponibles
                        $sql_cargo = "SELECT id_cargo, nombre_cargo FROM cargo";
                        $resultado_cargo = $conexion->query($sql_cargo);

                        // Iterar sobre los resultados y crear una opción para cada rol
                        while ($cargo = $resultado_cargo->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($cargo['id_cargo']) . '">' . htmlspecialchars($cargo['nombre_cargo']) . '</option>';
                        }
                        ?>
                    </select>
                    <br>

                    <!-- Campo Supervisor -->
                    <label for="supervisor">Supervisor</label>
                    <select name="supervisor" id="supervisor" class="form-control" required>
                        <option value="" disabled selected>Seleccione un Supervisor</option>
                        <?php
                        // Consulta para obtener los supervisores (id_cargo = 2)
                        $sql_supervisor = "SELECT rut, nombre FROM usuario WHERE id_rol IN (1,2)";
                        $resultado_supervisor = $conexion->query($sql_supervisor);

                        // Iterar sobre los supervisores y crear una opción para cada uno
                        while ($supervisor = $resultado_supervisor->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($supervisor['rut']) . '">' . htmlspecialchars($supervisor['nombre']) . '</option>';
                        }
                        ?>
                        <option value="">N/A</option> <!-- Opción N/A al final -->
                    </select>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Agregar Personal</button>
                </div>
        </form>
    </div>
</div>
</div>