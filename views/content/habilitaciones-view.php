<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">Habilitaciones</h1>
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
                <col class="col-check" />
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
                    <th class="col-check" style="padding-left: var(--space-4)">
                        <input type="checkbox" />
                    </th>
                    <th class="col-id">ID</th>
                    <th class="col-entity">Habilitacion</th>
                    <th class="col-priority">Tipo</th>
                    <th class="col-status">Estado</th>
                    <th class="col-tags">Etiquetas</th>
                    <th class="col-value">Fecha</th>
                    <th class="col-actions" style="text-align: right; padding-right: var(--space-4)">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="col-check" style="padding-left: var(--space-4); overflow: visible">
                        <input type="checkbox" />
                    </td>
                    <td class="col-id text-mono text-muted">HAB-001</td>
                    <td class="col-entity" title="Habilitacion Sanitaria">
                        <div class="entity-cell">
                            <div class="entity-avatar">HS</div>
                            <span class="entity-name">Habilitacion Sanitaria</span>
                        </div>
                    </td>
                    <td class="col-priority text-mono">Sanitaria</td>
                    <td class="col-status">
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>Aprobado</span>
                    </td>
                    <td class="col-tags">
                        <span class="badge-nx badge-blue">Urgente</span>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        15/03/2025
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
                    <td class="col-check" style="padding-left: var(--space-4); overflow: visible">
                        <input type="checkbox" />
                    </td>
                    <td class="col-id text-mono text-muted">HAB-002</td>
                    <td class="col-entity" title="Habilitacion Municipal">
                        <div class="entity-cell">
                            <div class="entity-avatar" style="background: linear-gradient(135deg, #10b981, #047857);">HM</div>
                            <span class="entity-name">Habilitacion Municipal</span>
                        </div>
                    </td>
                    <td class="col-priority text-mono">Municipal</td>
                    <td class="col-status">
                        <span class="badge-nx badge-amber"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>En proceso</span>
                    </td>
                    <td class="col-tags">
                        <span class="badge-nx badge-cyan">Nuevo</span>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        20/03/2025
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