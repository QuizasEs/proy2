<?php
require_once __DIR__ . "/../../controllers/habilitacionController.php";
$ins_habilitacion = new habilitacionController();
$resultado = $ins_habilitacion->listar_habilitaciones_controller();
$lista_habilitaciones = $resultado['datos'];
$paginacion = $resultado['paginacion'];

// listar empresas y servicios para los selects
$lista_empresas = $ins_habilitacion->listar_empresas_controller();
$lista_servicios = $ins_habilitacion->listar_servicios_controller();
?>

<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">habilitaciones</h1>
            <p class="page-subtitle">
                bienvenido de nuevo — <?php echo date('l d M Y'); ?>
            </p>
        </div>
        <div style="display: flex; gap: var(--space-3); align-items: center;">
            <label class="switch-nx">
                <input type="checkbox" 
                    onchange="location = this.checked ? '<?php echo SERVER_URL; ?>index.php?views=habilitaciones&ver=todos' : '<?php echo SERVER_URL; ?>index.php?views=habilitaciones';" 
                    <?php echo isset($_GET['ver']) && $_GET['ver'] == 'todos' ? 'checked' : ''; ?> 
                />
                <span class="switch-track"></span>
            </label>
            <span style="font-size: var(--text-sm);">ver inactivos</span>
            <button class="btn-nx btn-primary btn-md" onclick="openModal('modalAdd')" style="margin-left: auto;">
                <ion-icon name="add-outline"></ion-icon>
                nuevo
            </button>
        </div>
    </div>

    <div class="table-wrapper">
        <table class="table-nx">
            <colgroup>
                <col class="col-id" />
                <col class="col-entity" />
                <col class="col-priority" />
                <col class="col-status" />
                <col class="col-value" />
                <col class="col-actions" />
            </colgroup>
            <thead>
                <tr>
                    <th class="col-id">id</th>
                    <th class="col-entity">servicio</th>
                    <th class="col-priority">empresa</th>
                    <th class="col-status">suscripcion</th>
                    <th class="col-value">sucursal</th>
                    <th class="col-status">estado</th>
                    <th class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $lista_habilitaciones->fetch()) { ?>
                <tr>
                    <td class="col-id text-mono text-muted"><?php echo $row['ha_id']; ?></td>
                    <td class="col-entity" title="<?php echo $row['se_nombre']; ?>">
                        <div class="entity-cell">
                            <div class="entity-avatar"><?php echo strtoupper(substr($row['se_nombre'], 0, 2)); ?></div>
                            <div>
                                <span class="entity-name"><?php echo $row['se_nombre']; ?></span>
                                <div class="text-muted" style="font-size: var(--text-xs);"><?php echo $row['se_tipo_sistema']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="col-priority text-mono"><?php echo $row['em_nombre']; ?></td>
                    <td class="col-status">
                        <?php if ($row['ha_tipo_suscripcion'] == 1) { ?>
                        <span class="badge-nx badge-blue"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>mensual</span>
                        <?php } else { ?>
                        <span class="badge-nx badge-amber"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>anual</span>
                        <?php } ?>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        <?php echo $row['ha_sucursal'] ? $row['ha_sucursal'] : '-'; ?>
                    </td>
                    <td class="col-status">
                        <?php if ($row['ha_estado'] == 1) { ?>
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>activo</span>
                        <?php } else { ?>
                        <span class="badge-nx badge-red"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>inactivo</span>
                        <?php } ?>
                    </td>
                    <td class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: var(--space-2);">
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="editar" onclick="editarHabilitacion('<?php echo mainModel::encryption($row['ha_id']); ?>')">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="ver" onclick="verHabilitacion('<?php echo mainModel::encryption($row['ha_id']); ?>')">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="desactivar" style="color: var(--color-warning)" onclick="desactivarHabilitacion('<?php echo mainModel::encryption($row['ha_id']); ?>')">
                                <ion-icon name="power-outline"></ion-icon>
                            </button>
                            <?php if ($_SESSION['rol_smp'] == 1) { ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="eliminar" style="color: var(--color-danger)" onclick="eliminarHabilitacion('<?php echo mainModel::encryption($row['ha_id']); ?>')">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                            <?php } ?>
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
            <h3 class="modal-title-nx">agregar habilitacion</h3>
            <button class="modal-close" onclick="closeModal('modalAdd')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/habilitacionAjax.php" method="POST" data-form="save" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="agregar_habilitacion" value="1">
                
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">servicio <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="servicio" required>
                                <option value="">seleccionar servicio</option>
                                <?php while ($servicio = $lista_servicios->fetch()) { ?>
                                <option value="<?php echo $servicio['se_id']; ?>"><?php echo $servicio['se_nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">empresa <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="empresa" required>
                                <option value="">seleccionar empresa</option>
                                <?php while ($empresa = $lista_empresas->fetch()) { ?>
                                <option value="<?php echo $empresa['em_id']; ?>"><?php echo $empresa['em_nombre'] . ' - ' . $empresa['em_nit']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">tipo de suscripcion <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="tipo_suscripcion" required>
                                <option value="1">mensual</option>
                                <option value="2">anual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">sucursal</label>
                            <input class="form-control-nx" type="text" name="sucursal" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">link del sistema</label>
                            <input class="form-control-nx" type="url" name="link" placeholder="https://..." style="word-break: break-all;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalAdd')">cancelar</button>
                <button type="submit" class="btn-nx btn-primary btn-md">guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal editar -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-nx">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">editar habilitacion</h3>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/habilitacionAjax.php" method="POST" data-form="update" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="actualizar_habilitacion" value="1">
                <input type="hidden" name="habilitacion_id" id="edit_id">
                
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">servicio <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="servicio" id="edit_servicio" required>
                                <option value="">seleccionar servicio</option>
                                <?php $lista_servicios = $ins_habilitacion->listar_servicios_controller(); ?>
                                <?php while ($servicio = $lista_servicios->fetch()) { ?>
                                <option value="<?php echo $servicio['se_id']; ?>"><?php echo $servicio['se_nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">empresa <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="empresa" id="edit_empresa" required>
                                <option value="">seleccionar empresa</option>
                                <?php $lista_empresas = $ins_habilitacion->listar_empresas_controller(); ?>
                                <?php while ($empresa = $lista_empresas->fetch()) { ?>
                                <option value="<?php echo $empresa['em_id']; ?>"><?php echo $empresa['em_nombre'] . ' - ' . $empresa['em_nit']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">tipo de suscripcion <span style="color: var(--color-danger)">*</span></label>
                            <select class="form-control-nx" name="tipo_suscripcion" id="edit_tipo_suscripcion" required>
                                <option value="1">mensual</option>
                                <option value="2">anual</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">sucursal</label>
                            <input class="form-control-nx" type="text" name="sucursal" id="edit_sucursal" />
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">link del sistema</label>
                            <input class="form-control-nx" type="url" name="link" id="edit_link" placeholder="https://..." style="word-break: break-all;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalEdit')">cancelar</button>
                <button type="submit" class="btn-nx btn-primary btn-md">actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal ver -->
<div class="modal-overlay" id="modalView">
    <div class="modal-nx" style="max-width: 480px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">ver habilitacion</h3>
            <button class="modal-close" onclick="closeModal('modalView')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <div class="modal-body-nx">
            <div style="display: flex; align-items: center; gap: var(--space-4); margin-bottom: var(--space-4);">
                <div class="entity-avatar" style="width: 60px; height: 60px; font-size: 1.5rem;" id="view_avatar"></div>
                <div>
                    <div style="font-weight: 600; font-size: var(--text-lg);" id="view_servicio"></div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">empresa</label>
                        <div id="view_empresa">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">tipo de sistema</label>
                        <div id="view_tipo_sistema">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">suscripcion</label>
                        <div id="view_suscripcion">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">sucursal</label>
                        <div id="view_sucursal">-</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-nx">
                        <label class="form-label-nx">link del sistema</label>
                        <div id="view_link" style="word-break: break-all;">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">creado por</label>
                        <div id="view_usuario">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">fecha de creacion</label>
                        <div id="view_fecha">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">estado</label>
                        <div id="view_estado">-</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer-nx">
            <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalView')">cerrar</button>
        </div>
    </div>
</div>

<!-- modal eliminar -->
<div class="modal-overlay" id="modalConfirm">
    <div class="modal-nx" style="max-width: 420px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">eliminar habilitacion</h3>
            <button class="modal-close" onclick="closeModal('modalConfirm')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/habilitacionAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="eliminar_habilitacion" value="1">
                <input type="hidden" name="id" id="delete_id">
                <p>esta seguro de eliminar esta habilitacion? esta accion no se puede deshacer.</p>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalConfirm')">cancelar</button>
                <button type="submit" class="btn-nx btn-danger btn-md">eliminar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal desactivar -->
<div class="modal-overlay" id="modalDesactivar">
    <div class="modal-nx" style="max-width: 420px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">desactivar habilitacion</h3>
            <button class="modal-close" onclick="closeModal('modalDesactivar')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/habilitacionAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="desactivar_habilitacion" value="1">
                <input type="hidden" name="id" id="desactivar_id">
                <p>esta seguro de desactivar esta habilitacion? podra reactivarla mas adelante.</p>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalDesactivar')">cancelar</button>
                <button type="submit" class="btn-nx btn-warning btn-md">desactivar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editarHabilitacion(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/habilitacionAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_habilitacion=1&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_servicio').value = data.se_id;
            document.getElementById('edit_empresa').value = data.em_id;
            document.getElementById('edit_tipo_suscripcion').value = data.ha_tipo_suscripcion;
            document.getElementById('edit_sucursal').value = data.ha_sucursal || '';
            document.getElementById('edit_link').value = data.ha_link_sistema || '';
            openModal('modalEdit');
        });
    }

    function verHabilitacion(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/habilitacionAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_habilitacion=1&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_avatar').textContent = data.se_nombre ? data.se_nombre.charAt(0).toUpperCase() + data.se_nombre.charAt(1).toUpperCase() : 'HA';
            document.getElementById('view_servicio').textContent = data.se_nombre || '-';
            document.getElementById('view_empresa').textContent = data.em_nombre || '-';
            document.getElementById('view_tipo_sistema').textContent = data.se_tipo_sistema || '-';
            document.getElementById('view_suscripcion').textContent = data.ha_tipo_suscripcion == 1 ? 'mensual' : 'anual';
            document.getElementById('view_sucursal').textContent = data.ha_sucursal || '-';
            document.getElementById('view_link').innerHTML = data.ha_link_sistema ? '<a href="' + data.ha_link_sistema + '" target="_blank">' + data.ha_link_sistema + '</a>' : '-';
            document.getElementById('view_usuario').textContent = data.us_nombres ? data.us_nombres + ' ' + data.us_apellido_paterno : '-';
            document.getElementById('view_fecha').textContent = data.ha_creado_en;
            document.getElementById('view_estado').innerHTML = data.ha_estado == 1 ? '<span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>activo</span>' : '<span class="badge-nx badge-red"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>inactivo</span>';
            openModal('modalView');
        });
    }

    function eliminarHabilitacion(id) {
        document.getElementById('delete_id').value = id;
        openModal('modalConfirm');
    }

    function desactivarHabilitacion(id) {
        document.getElementById('desactivar_id').value = id;
        openModal('modalDesactivar');
    }
</script>
