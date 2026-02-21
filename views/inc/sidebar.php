    <!-- sidebar -->
    <aside class="sidebar" id="sidebar">
      <!-- marca -->
      <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
          <ion-icon name="home-outline"></ion-icon>
        </div>
        <span class="sidebar-brand-text">Sistemas<span> Admin</span></span>
      </div>

      <!-- navegacion -->
      <nav class="sidebar-nav">
        <!-- principal -->
        <div class="sidebar-section-label">Principal</div>

        <!-- dashboard -->
        <a class="sb-row sidebar-item is-active" data-tip="Dashboard" href="index.php?views=dashboard" onclick="
              activateItem(this);
            ">
          <ion-icon name="grid-outline" class="sb-icon"></ion-icon>
          <span class="sb-label">Dashboard</span>
        </a>

        <!-- Servicios -->
        <div class="sidebar-group" data-group="analytics">
          <button class="sb-row sidebar-group-trigger" onclick="toggleGroup(this)">
            <ion-icon name="bar-chart-outline" class="sb-icon"></ion-icon>
            <span class="sb-label">Servicios</span>
            <ion-icon name="chevron-forward-outline" class="sb-chevron"></ion-icon>
          </button>
          <div class="sidebar-submenu">
            <span class="flyout-title">Lista</span>
            <a class="sidebar-subitem" href="index.php?views=servicios" onclick="
                  activateItem(this);
                ">
              <ion-icon name="analytics-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Lista</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="git-branch-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Tráfico</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="repeat-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Conversiones</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="funnel-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Embudos</span>
            </a>
          </div>
        </div>

        <!-- empresas -->
        <div class="sidebar-group" data-group="rendimiento">
          <button class="sb-row sidebar-group-trigger" onclick="toggleGroup(this)">
            <ion-icon name="pulse-outline" class="sb-icon"></ion-icon>
            <span class="sb-label">Empresas</span>
            <ion-icon name="chevron-forward-outline" class="sb-chevron"></ion-icon>
          </button>
          <div class="sidebar-submenu">
            <span class="flyout-title">Lista</span>
            <a class="sidebar-subitem" href="index.php?views=empresas" onclick="
                  activateItem(this);
                ">
              <ion-icon name="radio-button-on-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Lista</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="server-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Servidor</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="database-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Base de datos</span>
            </a>
          </div>
        </div>

        <!-- gestion -->
        <div class="sidebar-section-label">Gestion planes</div>

        <!-- usuarios -->
        <div class="sidebar-group" data-group="usuarios">
          <button class="sb-row sidebar-group-trigger" onclick="toggleGroup(this)">
            <ion-icon name="people-outline" class="sb-icon"></ion-icon>
            <span class="sb-label">Usuarios</span>
            <ion-icon name="chevron-forward-outline" class="sb-chevron"></ion-icon>
          </button>
          <div class="sidebar-submenu">
            <span class="flyout-title">Usuarios</span>
            <a class="sidebar-subitem" href="index.php?views=clientes" onclick="
                  activateItem(this);
                ">
              <ion-icon name="list-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Lista de usuarios</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="key-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Roles y permisos</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="albums-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Grupos</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="time-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Actividad</span>
            </a>
          </div>
        </div>



        <!-- reportes -->
        <div class="sidebar-group" data-group="reportes">
          <button class="sb-row sidebar-group-trigger" onclick="toggleGroup(this)">
            <ion-icon name="document-text-outline" class="sb-icon"></ion-icon>
            <span class="sb-label">Reportes</span>
            <ion-icon name="chevron-forward-outline" class="sb-chevron"></ion-icon>
          </button>
          <div class="sidebar-submenu">
            <span class="flyout-title">Reportes</span>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="today-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Resumen diario</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="cash-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Financiero</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="archive-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Inventario</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="download-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Exportar datos</span>
            </a>
          </div>
        </div>





        <!-- sistema -->
        <div class="sidebar-section-label">Sistema</div>

        <!-- configuracion -->
        <div class="sidebar-group" data-group="config">
          <button class="sb-row sidebar-group-trigger" onclick="toggleGroup(this)">
            <ion-icon name="settings-outline" class="sb-icon"></ion-icon>
            <span class="sb-label">Configuración</span>
            <ion-icon name="chevron-forward-outline" class="sb-chevron"></ion-icon>
          </button>
          <div class="sidebar-submenu">
            <span class="flyout-title">Configuración</span>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="options-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">General</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="color-palette-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Apariencia</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="notifications-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Notificaciones</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="extension-puzzle-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Integraciones</span>
            </a>
            <a class="sidebar-subitem" href="#" onclick="
                  activateItem(this);
                  return false;
                ">
              <ion-icon name="code-slash-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">API & Webhooks</span>
            </a>
          </div>
        </div>


        <!-- ayuda -->
        <a class="sb-row sidebar-item" data-tip="Ayuda" href="#" onclick="
              activateItem(this);
              return false;
            ">
          <ion-icon name="help-circle-outline" class="sb-icon"></ion-icon>
          <span class="sb-label">Ayuda</span>
        </a>
      </nav>

      <!-- pie -->
      <div class="sidebar-footer">
        <div class="sidebar-footer-avatar" onclick="
              showToast('info', 'usuario', 'usuario')
            ">
          AJ
        </div>
        <div class="sidebar-footer-info">
          <div class="sidebar-footer-name">Admin</div>
          <div class="sidebar-footer-role">Rol Admin</div>
        </div>
      </div>
    </aside>

    <!-- overlay mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>
