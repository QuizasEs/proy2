<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">Empresas</h1>
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
                    <th class="col-entity">Empresa</th>
                    <th class="col-priority">RUC</th>
                    <th class="col-status">Estado</th>
                    <th class="col-tags">Etiquetas</th>
                    <th class="col-value">Valor</th>
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
                    <td class="col-id text-mono ">EMP-001</td>
                    <td class="col-entity" title="Empresa Demo S.A.C.">
                        <div class="entity-cell">
                            <div class="entity-avatar">ED</div>
                            <span class="entity-name">Empresa Demo S.A.C.</span>
                        </div>
                    </td>
                    <td class="col-priority text-mono">20123456789</td>
                    <td class="col-status">
                        <span class="badge-nx badge-green"><ion-icon name="ellipse" style="font-size: 8px"></ion-icon>Activo</span>
                    </td>
                    <td class="col-tags">
                        <span class="badge-nx badge-blue">VIP</span>
                    </td>
                    <td class="col-value text-mono" style="font-weight: var(--fw-semi)">
                        S/ 5,000
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