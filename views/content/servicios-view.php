<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">Servicios</h1>
            <p class="page-subtitle">
                Bienvenido de nuevo — <?php echo date('l d M Y'); ?>
            </p>
        </div>
        <div style="display: flex; gap: var(--space-3);">
            <button class="btn-nx btn-secondary btn-md">
                <ion-icon name="download-outline"></ion-icon>
                Exportar
            </button>
            <button class="btn-nx btn-primary btn-md">
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
                <col class="col-tags" />
                <col class="col-value" />
                <col class="col-actions" />
            </colgroup>
            <thead>
                <tr>

                    <th class="col-id">ID</th>
                    <th class="col-entity">Servicio</th>
                    <th class="col-priority">Categoria</th>
                    <th class="col-status">Estado</th>
                    <th class="col-tags">Etiquetas</th>
                    <th class="col-value">Precio</th>
                    <th class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>

                    <td class="col-id text-mono text-muted">SER-001</td>
                    <td class="col-entity" title="Servicio de Inyecciones">
                        <div class="entity-cell">
                            <div class="entity-avatar">SI</div>
                            <span class="entity-name">Servicio de Inyecciones</span>
                        </div>
                    </td>
                    <td class="col-priority text-mono">Medicina</td>
                    <td class="col-status">
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>Activo</span>
                    </td>
                    <td class="col-tags">
                        <span class="badge-nx badge-blue">Popular</span>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        S/ 50.00
                    </td>
                    <td class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: var(--space-2);">
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Editar" onclick="openModal('modalEdit')">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Ver" onclick="openModal('modalView')">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Eliminar" style="color: var(--color-danger)" onclick="openModal('modalConfirm')">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    
                    <td class="col-id text-mono text-muted">SER-002</td>
                    <td class="col-entity" title="Servicio de Curaciones">
                        <div class="entity-cell">
                            <div class="entity-avatar" style="background: linear-gradient(135deg, #10b981, #047857);">SC</div>
                            <span class="entity-name">Servicio de Curaciones</span>
                        </div>
                    </td>
                    <td class="col-priority text-mono">Enfermeria</td>
                    <td class="col-status">
                        <span class="badge-nx badge-amber"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>Pendiente</span>
                    </td>
                    <td class="col-tags">
                        <span class="badge-nx badge-cyan">Nuevo</span>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        S/ 35.00
                    </td>
                    <td class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        <div style="display: flex; align-items: center; justify-content: flex-end; gap: var(--space-2);">
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Editar" onclick="openModal('modalEdit')">
                                <ion-icon name="create-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Ver" onclick="openModal('modalView')">
                                <ion-icon name="eye-outline"></ion-icon>
                            </button>
                            <button class="btn-nx btn-icon btn-ghost btn-sm" title="Eliminar" style="color: var(--color-danger)" onclick="openModal('modalConfirm')">
                                <ion-icon name="trash-outline"></ion-icon>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>