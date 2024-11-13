<!-- Modal Actualizar Personal -->
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

                    <!-- Campo Rol -->
                    <label for="input_cargo">Cargo</label>
                    <select name="id_cargo" id="input_cargo" class="form-control" required>
                        <option value="">Seleccione un cargo</option>
                        <?php
                        $sql_cargo = "SELECT id_cargo, nombre_cargo FROM cargo";
                        $resultado_cargo = $conexion->query($sql_cargo);
                        while ($rol = $resultado_cargo->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($rol['id_cargo']) . '">' . htmlspecialchars($rol['nombre_cargo']) . '</option>';
                        }
                        ?>
                    </select>
                    <br>

                    <!-- Campo Supervisor -->
                    <label for="input_supervisor">Supervisor</label>
                    <select name="supervisor" id="input_supervisor" class="form-control" required>
                        <option value="" disabled selected>Selecciona un Supervisor</option> <!-- Solo como título -->
                        <?php
                        $sql_supervisor = "SELECT rut, nombre FROM usuario WHERE id_rol IN (1, 2)";
                        $resultado_supervisor = $conexion->query($sql_supervisor);
                        while ($supervisor = $resultado_supervisor->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($supervisor['rut']) . '">' . htmlspecialchars($supervisor['nombre']) . '</option>';
                        }
                        ?>
                        <option value="">N/A</option> <!-- Opción N/A al final -->
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function validarFormulario() {
        const supervisor = document.getElementById('input_supervisor').value;
        if (supervisor === "") {
            // Permitir el envío sin supervisor, ya que puede ser NULL
            return true;
        }
        return true;
    }
</script>