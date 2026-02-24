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
                    <th class="col-entity">empresa</th>
                    <th class="col-priority">nit</th>
                    <th class="col-status">estado</th>
                    <th class="col-value">comision</th>
                    <th class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $lista_empresas->fetch()) { ?>
                <tr>
                    <td class="col-id text-mono text-muted"><?php echo $row['em_id']; ?></td>
                    <td class="col-entity" title="<?php echo $row['em_nombre']; ?>">
                        <div class="entity-cell">
                            <div class="entity-avatar"><?php echo strtoupper(substr($row['em_nombre'], 0, 2)); ?></div>
                            <div>
                                <span class="entity-name"><?php echo $row['em_nombre']; ?></span>
                                <div class="text-muted" style="font-size: var(--text-xs);"><?php echo $row['em_celular']; ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="col-priority text-mono"><?php echo $row['em_nit']; ?></td>
                    <td class="col-status">
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>activo</span>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        <?php echo $row['em_comision']; ?>%
                    </td>
                    <td class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: var(--space-2);">
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="editar" onclick="editarEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="ver" onclick="verEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <?php if ($_SESSION['rol_smp'] == 1) { ?>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="eliminar" style="color: var(--color-danger)" onclick="eliminarEmpresa('<?php echo mainModel::encryption($row['em_id']); ?>')">
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
            <h3 class="modal-title-nx">agregar empresa</h3>
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
                            <label class="form-label-nx">nombre <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nombre" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">nit <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nit" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">celular</label>
                            <input class="form-control-nx" type="text" name="celular" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">comision (%)</label>
                            <input class="form-control-nx" type="number" name="comision" value="0" min="0" max="100" step="0.01" />
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
            <h3 class="modal-title-nx">editar empresa</h3>
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
                            <label class="form-label-nx">nombre <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nombre" id="edit_nombre" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">nit <span style="color: var(--color-danger)">*</span></label>
                            <input class="form-control-nx" type="text" name="nit" id="edit_nit" required />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">celular</label>
                            <input class="form-control-nx" type="text" name="celular" id="edit_celular" />
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-group-nx">
                            <label class="form-label-nx">comision (%)</label>
                            <input class="form-control-nx" type="number" name="comision" id="edit_comision" min="0" max="100" step="0.01" />
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
            <h3 class="modal-title-nx">ver empresa</h3>
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
                        <label class="form-label-nx">nit</label>
                        <div id="view_nit">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">celular</label>
                        <div id="view_celular">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">comision</label>
                        <div id="view_comision">-</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group-nx">
                        <label class="form-label-nx">creado por</label>
                        <div id="view_usuario">-</div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group-nx">
                        <label class="form-label-nx">fecha de creacion</label>
                        <div id="view_fecha">-</div>
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
            <h3 class="modal-title-nx">eliminar empresa</h3>
            <button class="modal-close" onclick="closeModal('modalConfirm')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <form class="FormularioAjax" action="<?php echo SERVER_URL; ?>ajax/empresaAjax.php" method="POST" data-form="delete" autocomplete="off">
            <div class="modal-body-nx">
                <input type="hidden" name="eliminar_empresa" value="1">
                <input type="hidden" name="id" id="delete_id">
                <p>esta seguro de eliminar esta empresa? esta accion no se puede deshacer.</p>
            </div>
            <div class="modal-footer-nx">
                <button type="button" class="btn-nx btn-danger btn-md" onclick="closeModal('modalConfirm')">cancelar</button>
                <button type="submit" class="btn-nx btn-danger btn-md">eliminar</button>
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
            openModal('modalView');
        });
    }

    function eliminarEmpresa(id) {
        document.getElementById('delete_id').value = id;
        openModal('modalConfirm');
    }
</script>
