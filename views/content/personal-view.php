<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(['name' => 'SMP']);
}
if (!isset($_SESSION['rol_smp']) || $_SESSION['rol_smp'] != 1) {
    echo "<script>window.location.href='" . SERVER_URL . "index.php?views=404';</script>";
    exit();
}

require_once __DIR__ . "/../../controllers/userController.php";
$ins_personal = new userController();
$resultado = $ins_personal->listar_personal_controller();
$lista_personal = $resultado['datos'];
$paginacion = $resultado['paginacion'];
$lista_roles = $ins_personal->listar_roles_controller();
?>

<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">Personal</h1>
            <p class="page-subtitle">
                Bienvenido de nuevo — <?php echo date('l d M Y'); ?>
            </p>
        </div>
        <div style="display: flex; gap: var(--space-3);">
            <?php if ($_SESSION['rol_smp'] == 1) { ?>
            <button class="btn-nx btn-primary btn-md" onclick="openModal('modalAdd')">
                <ion-icon name="add-outline"></ion-icon>
                Nuevo
            </button>
            <?php } ?>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table-nx">
            <colgroup>
                <col class="col-id" />
                <col class="col-entity" />
                <col class="col-priority" />
                <col class="col-status" />
                <col class="col-tags" />
                <col class="col-entity" />
                <col class="col-actions" />
            </colgroup>
            <thead>
                <tr>
                    <th class="col-id">ID</th>
                    <th class="col-entity">Personal</th>
                    <th class="col-priority">Carnet</th>
                    <th class="col-entity">Usuario</th>
                    <th class="col-status">Estado</th>
                    <th class="col-tags">Rol</th>
                    <th class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody id="tablaPersonal">
                <?php while ($row = $lista_personal->fetch()) { ?>
                <tr>
                    <td class="col-id text-mono text-muted"><?php echo $row['us_id']; ?></td>
                    <td class="col-entity" title="<?php echo $row['us_nombres'] . ' ' . $row['us_apellido_paterno']; ?>">
                        <div class="entity-cell">
                            <div class="entity-avatar"><?php echo strtoupper(substr($row['us_nombres'], 0, 1) . substr($row['us_apellido_paterno'], 0, 1)); ?></div>
                            <div>
                                <span class="entity-name"><?php echo $row['us_nombres'] . ' ' . $row['us_apellido_paterno']; ?></span>
                                <div class="text-muted" style="font-size: var(--text-xs);"><?php echo $row['us_correo']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="col-priority text-mono"><?php echo $row['us_numero_carnet']; ?></td>
                    <td class="col-entity text-mono"><?php echo $row['us_username']; ?></td>
                    <td class="col-status">
                        <?php if ($row['us_estado'] == 1) { ?>
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>Activo</span>
                        <?php } else { ?>
                        <span class="badge-nx badge-red"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>Inactivo</span>
                        <?php } ?>
                    </td>
                    <td class="col-tags">
                        <span class="badge-nx badge-blue"><?php echo $row['ro_nombre']; ?></span>
                    </td>
                    <td class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: var(--space-2);">
                            <?php if ($_SESSION['rol_smp'] == 1) { ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Editar" onclick="editarPersonal('<?php echo mainModel::encryption($row['us_id']); ?>')">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Eliminar" style="color: var(--color-danger)" onclick="eliminarPersonal('<?php echo mainModel::encryption($row['us_id']); ?>')">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                            <?php } ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Ver" onclick="verPersonal('<?php echo mainModel::encryption($row['us_id']); ?>')">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php echo $paginacion; ?>

</div>

<!-- modal agregar -->
<div class="modal-overlay" id="modalAdd">
    <div class="modal-nx">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Agregar Personal</h3>
            <button class="modal-close" onclick="closeModal('modalAdd')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form id="formAgregar" class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/userAjax.php" method="POST" data-form="save" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="Usuario_reg" value="1">
                
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Nombres <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="Nombres_reg" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Apellido paterno <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="ApellidoPaterno_reg" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Apellido materno <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="ApellidoMaterno_reg" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Numero de carnet</label>
                            <input class="form-control-nx" type="text" name="Carnet_reg" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Telefono</label>
                            <input class="form-control-nx" type="text" name="Telefono_reg" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Correo electronico</label>
                            <input class="form-control-nx" type="email" name="Correo_reg" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Direccion</label>
                            <textarea class="form-control-nx" name="Direccion_reg" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Nombre de usuario <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="UsuarioName_reg" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Contrasena <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="password" name="Password_reg" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Confirmar contrasena <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="password" name="PasswordConfirm_reg" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Rol <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="Rol_reg" required>
                                <option value="">Seleccionar rol</option>
                                <?php while ($rol = $lista_roles->fetch()) { ?>
                                <option value="<?php echo $rol['ro_id']; ?>"><?php echo $rol['ro_nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Estado <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="Estado_reg" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalAdd')">Cancelar</button>
                <button type="submit" class="btn-nx btn-primary btn-md">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal editar -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-nx">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Editar Personal</h3>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form id="formEditar" class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/userAjax.php" method="POST" data-form="update" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="actualizar_usuario" value="1">
                <input type="hidden" name="Usuario_id_up" id="edit_id">
                
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Nombres <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nombres" id="edit_nombres" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Apellido paterno <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="apellido_paterno" id="edit_apellido_paterno" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Apellido materno <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="apellido_materno" id="edit_apellido_materno" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Numero de carnet</label>
                            <input class="form-control-nx" type="text" name="carnet" id="edit_carnet" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Telefono</label>
                            <input class="form-control-nx" type="text" name="telefono" id="edit_telefono" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Correo electronico</label>
                            <input class="form-control-nx" type="email" name="correo" id="edit_correo" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Direccion</label>
                            <textarea class="form-control-nx" name="direccion" id="edit_direccion" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Usuario</label>
                            <input class="form-control-nx" type="text" name="username" id="edit_username" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Nueva contrasena</label>
                            <input class="form-control-nx" type="password" name="password" id="edit_password" placeholder="Dejar vacio para mantener" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Rol <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="rol" id="edit_rol" required>
                                <option value="">Seleccionar rol</option>
                                <?php $lista_roles2 = $ins_personal->listar_roles_controller(); ?>
                                <?php while ($rol = $lista_roles2->fetch()) { ?>
                                <option value="<?php echo $rol['ro_id']; ?>"><?php echo $rol['ro_nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Estado <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="estado" id="edit_estado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalEdit')">Cancelar</button>
                <button type="submit" class="btn-nx btn-primary btn-md">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal ver -->
<div class="modal-overlay" id="modalView">
    <div class="modal-nx" style="max-width: 480px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Ver Personal</h3>
            <button class="modal-close" onclick="closeModal('modalView')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <div class="modal-body-nx">
            <div style="display: flex; align-items: center; gap: var(--space-4); margin-bottom: var(--space-4);">
                <div class="entity-avatar" style="width: 60px; height: 60px; font-size: 1.5rem;" id="view_avatar"></div>
                <div>
                    <div style="font-weight: 600; font-size: var(--text-lg);" id="view_nombre"></div>
                    <div style="color: var(--color-text-secondary);" id="view_usuario"></div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Carnet</label>
                        <div id="view_carnet">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Telefono</label>
                        <div id="view_telefono">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Correo</label>
                        <div id="view_correo">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Rol</label>
                        <div id="view_rol">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Estado</label>
                        <div id="view_estado">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Fecha de creacion</label>
                        <div id="view_fecha">-</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Direccion</label>
                        <div id="view_direccion">-</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer-nx">
            <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalView')">Cerrar</button>
        </div>
    </div>
</div>

<!-- modal eliminar -->
<div class="modal-overlay" id="modalConfirm">
    <div class="modal-nx" style="max-width: 420px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Eliminar Personal</h3>
            <button class="modal-close" onclick="closeModal('modalConfirm')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form id="formEliminar" class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/userAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="eliminar_usuario" value="1">
                <input type="hidden" name="id" id="delete_id">
                <p>Esta seguro de eliminar este personal? Esta accion no se puede deshacer.</p>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalConfirm')">Cancelar</button>
                <button type="submit" class="btn-nx btn-danger btn-md">Eliminar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editarPersonal(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/userAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_personal=1&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nombres').value = data.us_nombres;
            document.getElementById('edit_apellido_paterno').value = data.us_apellido_paterno;
            document.getElementById('edit_apellido_materno').value = data.us_apellido_materno;
            document.getElementById('edit_carnet').value = data.us_numero_carnet || '';
            document.getElementById('edit_telefono').value = data.us_telefono || '';
            document.getElementById('edit_correo').value = data.us_correo || '';
            document.getElementById('edit_direccion').value = data.us_direccion || '';
            document.getElementById('edit_username').value = data.us_username;
            document.getElementById('edit_rol').value = data.ro_id;
            document.getElementById('edit_estado').value = data.us_estado;
            openModal('modalEdit');
        });
    }

    function verPersonal(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/userAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_personal=1&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_avatar').textContent = data.us_nombres.charAt(0).toUpperCase() + data.us_apellido_paterno.charAt(0).toUpperCase();
            document.getElementById('view_nombre').textContent = data.us_nombres + ' ' + data.us_apellido_paterno + ' ' + data.us_apellido_materno;
            document.getElementById('view_usuario').textContent = '@' + data.us_username;
            document.getElementById('view_carnet').textContent = data.us_numero_carnet || '-';
            document.getElementById('view_telefono').textContent = data.us_telefono || '-';
            document.getElementById('view_correo').textContent = data.us_correo || '-';
            document.getElementById('view_rol').textContent = data.ro_nombre || '-';
            document.getElementById('view_estado').innerHTML = data.us_estado == 1 ? '<span class="badge-nx badge-green">Activo</span>' : '<span class="badge-nx badge-red">Inactivo</span>';
            document.getElementById('view_fecha').textContent = data.us_creado_en;
            document.getElementById('view_direccion').textContent = data.us_direccion || '-';
            openModal('modalView');
        });
    }

    function eliminarPersonal(id) {
        document.getElementById('delete_id').value = id;
        openModal('modalConfirm');
    }
</script>
