<?php
require_once __DIR__ . "/../../controllers/servicioController.php";
$ins_servicio = new servicioController();
$resultado = $ins_servicio->listar_servicios_controller();
$lista_servicios = $resultado['datos'];
$paginacion = $resultado['paginacion'];
?>

<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">Servicios</h1>
            <p class="page-subtitle">
                bienvenido de nuevo — <?php echo date('l d M Y'); ?>
            </p>
        </div>
        <div style="display: flex; gap: var(--space-3);">
            <button class="btn-nx btn-primary btn-md" onclick="openModal('modalAdd')">
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
                    <th class="col-priority">tipo</th>
                    <th class="col-status">creado</th>
                    <th class="col-value">estado</th>
                    <th class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $lista_servicios->fetch()) { ?>
                <tr>
                    <td class="col-id text-mono text-muted"><?php echo $row['se_id']; ?></td>
                    <td class="col-entity" title="<?php echo $row['se_nombre']; ?>">
                        <div class="entity-cell">
                            <div class="entity-avatar"><?php echo strtoupper(substr($row['se_nombre'], 0, 2)); ?></div>
                            <div>
                                <span class="entity-name"><?php echo $row['se_nombre']; ?></span>
                                <div class="text-muted" style="font-size: var(--text-xs);"><?php echo $row['se_descripcion']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="col-priority text-mono"><?php echo $row['se_tipo_sistema']; ?></td>
                    <td class="col-status text-muted" style="font-size: var(--text-xs)">
                        <?php echo date('d/m/Y', strtotime($row['se_creado_en'])); ?>
                    </td>
                    <td class="col-value">
                        <?php if ($row['se_estado'] == 1) { ?>
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>activo</span>
                        <?php } else { ?>
                        <span class="badge-nx badge-red"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>inactivo</span>
                        <?php } ?>
                    </td>
                    <td class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: var(--space-2);">
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="editar" onclick="editarServicio('<?php echo mainModel::encryption($row['se_id']); ?>')">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="ver" onclick="verServicio('<?php echo mainModel::encryption($row['se_id']); ?>')">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="desactivar" style="color: var(--color-warning)" onclick="desactivarServicio('<?php echo mainModel::encryption($row['se_id']); ?>')">
                                <ion-icon name="power-outline"></ion-icon>
                            </button>
                            <?php if ($_SESSION['rol_smp'] == 1) { ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="eliminar" style="color: var(--color-danger)" onclick="eliminarServicio('<?php echo mainModel::encryption($row['se_id']); ?>')">
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
            <h3 class="modal-title-nx">agregar servicio</h3>
            <button class="modal-close" onclick="closeModal('modalAdd')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/servicioAjax.php" method="POST" data-form="save" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="agregar_servicio" value="1">
                <div class="form-group-nx">
                    <label class="form-label-nx">nombre del servicio *</label>
                    <input class="form-control-nx" type="text" name="nombre" placeholder="ingrese el nombre del servicio" required>
                </div>
                <div class="form-group-nx">
                    <label class="form-label-nx">descripcion</label>
                    <textarea class="form-control-nx" name="descripcion" placeholder="ingrese una descripcion del servicio" rows="3"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">tipo de sistema *</label>
                            <select class="form-control-nx" name="tipo_sistema" required>
                                <option value="">seleccione una opcion</option>
                                <option value="inventario">inventario</option>
                                <option value="facturacion">facturacion</option>
                                <option value="contabilidad">contabilidad</option>
                                <option value="otros">otros</option>
                            </select>
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
            <h3 class="modal-title-nx">editar servicio</h3>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/servicioAjax.php" method="POST" data-form="update" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="actualizar_servicio" value="1">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group-nx">
                    <label class="form-label-nx">nombre del servicio *</label>
                    <input class="form-control-nx" type="text" id="edit_nombre" name="nombre" placeholder="ingrese el nombre del servicio" required>
                </div>
                <div class="form-group-nx">
                    <label class="form-label-nx">descripcion</label>
                    <textarea class="form-control-nx" id="edit_descripcion" name="descripcion" placeholder="ingrese una descripcion del servicio" rows="3"></textarea>
                </div>
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">tipo de sistema *</label>
                            <select class="form-control-nx" id="edit_tipo_sistema" name="tipo_sistema" required>
                                <option value="">seleccione una opcion</option>
                                <option value="inventario">inventario</option>
                                <option value="facturacion">facturacion</option>
                                <option value="contabilidad">contabilidad</option>
                                <option value="otros">otros</option>
                            </select>
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
            <h3 class="modal-title-nx">detalle del servicio</h3>
            <button class="modal-close" onclick="closeModal('modalView')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <div class="modal-body-nx">
            <div style="display: flex; align-items: center; gap: var(--space-4); margin-bottom: var(--space-4);">
                <div class="entity-avatar" style="width: 60px; height: 60px; font-size: 1.5rem;" id="view_avatar"></div>
                <div>
                    <div style="font-weight: 600; font-size: var(--text-lg);" id="view_nombre"></div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">tipo</label>
                        <div id="view_tipo">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">descripcion</label>
                        <div id="view_descripcion">-</div>
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
                <div class="col-12">
                    <div class="form-group-nx">
                        <label class="form-label-nx">ultima actualizacion</label>
                        <div id="view_actualizado">-</div>
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
            <h3 class="modal-title-nx">eliminar servicio</h3>
            <button class="modal-close" onclick="closeModal('modalConfirm')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/servicioAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx" style="text-align: center">
                <div style="display:flex;justify-content:center;margin-bottom:16px;">
                    <ion-icon name="warning-outline" style="font-size:48px;color:var(--color-warning);"></ion-icon>
                </div>
                <p>esta seguro de eliminar este servicio? esta accion no se puede deshacer.</p>
            </div>
            <div class="modal-footer-nx">
                <input type="hidden" name="eliminar_servicio" value="1">
                <input type="hidden" name="id" id="delete_id">
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
            <h3 class="modal-title-nx">desactivar servicio</h3>
            <button class="modal-close" onclick="closeModal('modalDesactivar')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/servicioAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx" style="text-align: center">
                <div style="display:flex;justify-content:center;margin-bottom:16px;">
                    <ion-icon name="power-outline" style="font-size:48px;color:var(--color-warning);"></ion-icon>
                </div>
                <p>esta seguro de desactivar este servicio? podra reactivarlo mas adelante.</p>
            </div>
            <div class="modal-footer-nx">
                <input type="hidden" name="desactivar_servicio" value="1">
                <input type="hidden" name="id" id="desactivar_id">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalDesactivar')">cancelar</button>
                <button type="submit" class="btn-nx btn-warning btn-md">desactivar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editarServicio(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/servicioAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_servicio=1&id=' + encodeURIComponent(id)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nombre').value = data.se_nombre;
            document.getElementById('edit_descripcion').value = data.se_descripcion || '';
            document.getElementById('edit_tipo_sistema').value = data.se_tipo_sistema;
            openModal('modalEdit');
        })
        .catch(error => console.error('error:', error));
    }

    function verServicio(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/servicioAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_servicio=1&id=' + encodeURIComponent(id)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_avatar').textContent = data.se_nombre.substring(0, 2).toUpperCase();
            document.getElementById('view_nombre').textContent = data.se_nombre;
            document.getElementById('view_tipo').textContent = data.se_tipo_sistema;
            document.getElementById('view_descripcion').textContent = data.se_descripcion || 'sin descripcion';
            document.getElementById('view_usuario').textContent = (data.us_nombres || '') + ' ' + (data.us_apellido_paterno || '');
            document.getElementById('view_fecha').textContent = data.se_creado_en;
            document.getElementById('view_actualizado').textContent = data.se_actualizado_en;
            document.getElementById('view_estado').innerHTML = data.se_estado == 1 ? '<span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>activo</span>' : '<span class="badge-nx badge-red"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>inactivo</span>';
            openModal('modalView');
        })
        .catch(error => console.error('error:', error));
    }

    function eliminarServicio(id) {
        document.getElementById('delete_id').value = id;
        openModal('modalConfirm');
    }

    function desactivarServicio(id) {
        document.getElementById('desactivar_id').value = id;
        openModal('modalDesactivar');
    }
</script>
