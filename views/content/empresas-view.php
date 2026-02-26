<?php
require_once __DIR__ . "/../../controllers/empresaController.php";
$ins_empresa = new empresaController();
$resultado = $ins_empresa->listar_empresas_controller();
$lista_empresas = $resultado['datos'];
$paginacion = $resultado['paginacion'];
?>

<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">Empresas</h1>
            <p class="page-subtitle">
                Bienvenido de nuevo — <?php echo date('l d M Y'); ?>
            </p>
        </div>
        <div style="display: flex; gap: var(--space-3); align-items: center;">
            <label class="switch-nx">
                <input type="checkbox" 
                    onchange="location = this.checked ? '<?php echo SERVER_URL; ?>index.php?views=empresas&ver=todos' : '<?php echo SERVER_URL; ?>index.php?views=empresas';" 
                    <?php echo isset($_GET['ver']) && $_GET['ver'] == 'todos' ? 'checked' : ''; ?> 
                />
                <span class="switch-track"></span>
            </label>
            <span style="font-size: var(--text-sm);">Ver inactivos</span>
            <button class="btn-nx btn-primary btn-md" onclick="openModal('modalAdd')" style="margin-left: auto;">
                <ion-icon name="add-outline"></ion-icon>
                Nuevo
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
                    <th class="col-entity">Empresa</th>
                    <th class="col-priority">NIT</th>
                    <th class="col-status">Estado</th>
                    <th class="col-value">Comisión</th>
                    <th class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $lista_empresas->fetch()) { ?>
                <tr>
                    <td class="col-id text-mono text-muted"><?php echo $row['em_id']; ?></td>
                    <td class="col-entity" title="<?php echo $row['em_nombre']; ?>">
                        <div class="entity-cell">
                            
                            <div>
                                <span class="entity-name"><?php echo $row['em_nombre']; ?></span>
                                <div class="text-muted" style="font-size: var(--text-xs);"><?php echo $row['em_celular']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="col-priority text-mono"><?php echo $row['em_nit']; ?></td>
                    <td class="col-status">
                        <?php if ($row['em_estado'] == 1) { ?>
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>activo</span>
                        <?php } else { ?>
                        <span class="badge-nx badge-red"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>inactivo</span>
                        <?php } ?>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        <?php echo $row['em_comision']; ?>%
                    </td>
                    <td class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: var(--space-2);">
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Editar" onclick="editarEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Ver" onclick="verEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <?php if ($row['em_estado'] == 1) { ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Desactivar" style="color: var(--color-warning)" onclick="desactivarEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
                                <ion-icon name="power-outline"></ion-icon>
                            </button>
                            <?php } else { ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Activar" style="color: var(--color-success)" onclick="activarEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
                                <ion-icon name="power"></ion-icon>
                            </button>
                            <?php } ?>
                            <?php if ($_SESSION['rol_smp'] == 1) { ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Eliminar" style="color: var(--color-danger)" onclick="eliminarEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
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
            <h3 class="modal-title-nx">Agregar empresa</h3>
            <button class="modal-close" onclick="closeModal('modalAdd')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/empresaAjax.php" method="POST" data-form="save" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="agregar_empresa" value="1">
                
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Nombre <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nombre" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">NIT <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nit" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Celular</label>
                            <input class="form-control-nx" type="text" name="celular" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Comisión (%)</label>
                            <input class="form-control-nx" type="number" name="comision" value="0" min="0" max="100" step="0.01" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalAdd')">Cancelar</button>
                <button type="submit" class="btn-nx btn-success btn-md">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal editar -->
<div class="modal-overlay" id="modalEdit">
    <div class="modal-nx">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Editar empresa</h3>
            <button class="modal-close" onclick="closeModal('modalEdit')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/empresaAjax.php" method="POST" data-form="update" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="actualizar_empresa" value="1">
                <input type="hidden" name="empresa_id" id="edit_id">
                
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Nombre <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nombre" id="edit_nombre" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">NIT <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nit" id="edit_nit" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Celular</label>
                            <input class="form-control-nx" type="text" name="celular" id="edit_celular" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">Comisión (%)</label>
                            <input class="form-control-nx" type="number" name="comision" id="edit_comision" min="0" max="100" step="0.01" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalEdit')">Cancelar</button>
                <button type="submit" class="btn-nx btn-success btn-md">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal ver -->
<div class="modal-overlay" id="modalView">
    <div class="modal-nx" style="max-width: 480px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Ver empresa</h3>
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
                        <label class="form-label-nx">NIT</label>
                        <div id="view_nit">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Celular</label>
                        <div id="view_celular">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Comisión</label>
                        <div id="view_comision">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Creado por</label>
                        <div id="view_usuario">-</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Fecha de creación</label>
                        <div id="view_fecha">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">Estado</label>
                        <div id="view_estado">-</div>
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
            <h3 class="modal-title-nx">Eliminar empresa</h3>
            <button class="modal-close" onclick="closeModal('modalConfirm')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/empresaAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="eliminar_empresa" value="1">
                <input type="hidden" name="id" id="delete_id">
                <p>¿Está seguro de eliminar esta empresa? Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalConfirm')">Cancelar</button>
                <button type="submit" class="btn-nx btn-danger btn-md">Eliminar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal desactivar -->
<div class="modal-overlay" id="modalDesactivar">
    <div class="modal-nx" style="max-width: 420px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Desactivar empresa</h3>
            <button class="modal-close" onclick="closeModal('modalDesactivar')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/empresaAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="desactivar_empresa" value="1">
                <input type="hidden" name="id" id="desactivar_id">
                <p>¿Está seguro de desactivar esta empresa? Podrá reactivarla más adelante.</p>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalDesactivar')">Cancelar</button>
                <button type="submit" class="btn-nx btn-warning btn-md">Desactivar</button>
            </div>
        </form>
    </div>
</div>

<!-- modal activar -->
<div class="modal-overlay" id="modalActivar">
    <div class="modal-nx" style="max-width: 420px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">Activar empresa</h3>
            <button class="modal-close" onclick="closeModal('modalActivar')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/empresaAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="activar_empresa" value="1">
                <input type="hidden" name="id" id="activar_id">
                <p>¿Está seguro de activar esta empresa? Estará disponible para su uso.</p>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalActivar')">Cancelar</button>
                <button type="submit" class="btn-nx btn-success btn-md">Activar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editarEmpresa(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/empresaAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_empresa=1&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_nombre').value = data.em_nombre;
            document.getElementById('edit_nit').value = data.em_nit;
            document.getElementById('edit_celular').value = data.em_celular || '';
            document.getElementById('edit_comision').value = data.em_comision || 0;
            openModal('modalEdit');
        });
    }

    function verEmpresa(id) {
        fetch('<?php echo SERVER_URL; ?>ajax/empresaAjax.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'obtener_empresa=1&id=' + id
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('view_avatar').textContent = data.em_nombre.charAt(0).toUpperCase() + data.em_nombre.charAt(1).toUpperCase();
            document.getElementById('view_nombre').textContent = data.em_nombre;
            document.getElementById('view_nit').textContent = data.em_nit || '-';
            document.getElementById('view_celular').textContent = data.em_celular || '-';
            document.getElementById('view_comision').textContent = (data.em_comision || 0) + '%';
            document.getElementById('view_usuario').textContent = data.us_nombres ? data.us_nombres + ' ' + data.us_apellido_paterno : '-';
            document.getElementById('view_fecha').textContent = data.em_creado_en;
            document.getElementById('view_estado').innerHTML = data.em_estado == 1 ? '<span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>activo</span>' : '<span class="badge-nx badge-red"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>inactivo</span>';
            openModal('modalView');
        });
    }

    function eliminarEmpresa(id) {
        document.getElementById('delete_id').value = id;
        openModal('modalConfirm');
    }

    function desactivarEmpresa(id) {
        document.getElementById('desactivar_id').value = id;
        openModal('modalDesactivar');
    }

    function activarEmpresa(id) {
        document.getElementById('activar_id').value = id;
        openModal('modalActivar');
    }
</script>
