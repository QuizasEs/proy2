<div class="page-content">

    <div class="page-header" style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: var(--space-5); flex-wrap: wrap; gap: var(--space-3);">
        <div>
            <h1 class="page-title">Dashboard</h1>
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


    <div class="row g-3 mb-4">
        <!-- Ventas Totales -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card animate-in">
                <div class="stat-card-header">
                    <div>
                        <div class="card-title">Ventas Totales</div>
                        <div class="stat-value">12,450Bs</div>
                    </div>
                    <div class="stat-icon blue">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="stat-delta up">
                        <ion-icon name="trending-up-outline"></ion-icon>
                        +12.5%
                    </span>
                    <span class="text-muted" style="font-size: var(--text-xs)">vs mes anterior</span>
                </div>
                <div class="progress-nx">
                    <div class="progress-fill" style="width: 72%"></div>
                </div>
            </div>
        </div>

        <!-- Nuevos Usuarios -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card animate-in">
                <div class="stat-card-header">
                    <div>
                        <div class="card-title">Nuevos Usuarios</div>
                        <div class="stat-value">1,205</div>
                    </div>
                    <div class="stat-icon green">
                        <ion-icon name="people-outline"></ion-icon>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="stat-delta up">
                        <ion-icon name="trending-up-outline"></ion-icon>
                        +6.2%
                    </span>
                    <span class="text-muted" style="font-size: var(--text-xs)">vs mes anterior</span>
                </div>
                <div class="progress-nx">
                    <div class="progress-fill success" style="width: 61%"></div>
                </div>
            </div>
        </div>

        <!-- Ingresos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card animate-in">
                <div class="stat-card-header">
                    <div>
                        <div class="card-title">Ingresos</div>
                        <div class="stat-value">45,200Bs</div>
                    </div>
                    <div class="stat-icon purple">
                        <ion-icon name="wallet-outline"></ion-icon>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="stat-delta up">
                        <ion-icon name="trending-up-outline"></ion-icon>
                        +8.1%
                    </span>
                    <span class="text-muted" style="font-size: var(--text-xs)">vs mes anterior</span>
                </div>
                <div class="progress-nx">
                    <div class="progress-fill" style="width: 85%; background: var(--color-purple)"></div>
                </div>
            </div>
        </div>

        <!-- Pedidos -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="stat-card animate-in">
                <div class="stat-card-header">
                    <div>
                        <div class="card-title">Pedidos</div>
                        <div class="stat-value">320</div>
                    </div>
                    <div class="stat-icon amber">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span class="stat-delta down">
                        <ion-icon name="trending-down-outline"></ion-icon>
                        -2.4%
                    </span>
                    <span class="text-muted" style="font-size: var(--text-xs)">vs mes anterior</span>
                </div>
                <div class="progress-nx">
                    <div class="progress-fill warning" style="width: 43%"></div>
                </div>
            </div>
        </div>
    </div>



</div>