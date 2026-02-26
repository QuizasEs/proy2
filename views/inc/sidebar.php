    <!-- sidebar -->
    <aside class="sidebar" id="sidebar">
      <!-- marca -->
      <div class="sidebar-brand">

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
        <a class="sb-row sidebar-item" data-tip="Servicios" href="index.php?views=servicios" onclick="
              activateItem(this);
              return false;
            ">
          <ion-icon name="bar-chart-outline" class="sb-icon"></ion-icon>
          <span class="sb-label">Servicios</span>
        </a>
        <!-- <div class="sidebar-group" data-group="analytics">
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
              <ion-icon name="list-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Lista</span>
            </a>
          </div>
        </div> -->

        <!-- empresas -->
        <a class="sb-row sidebar-item" data-tip="Empresas" href="index.php?views=empresas" onclick="
              activateItem(this);
              return false;
            ">
          <ion-icon name="business-outline" class="sb-icon"></ion-icon>
          <span class="sb-label">Empresas</span>
        </a>
        <!-- <div class="sidebar-group" data-group="rendimiento">
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
              <ion-icon name="list-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Lista</span>
            </a>

          </div>
        </div> -->

        <!-- habilitaciones -->
        <a class="sb-row sidebar-item" data-tip="Habilitaciones" href="index.php?views=habilitaciones" onclick="
              activateItem(this);
              return false;
            ">
          <ion-icon name="checkbox-outline" class="sb-icon"></ion-icon>
          <span class="sb-label">Habilitaciones</span>
        </a>
        <!-- <div class="sidebar-group" data-group="habilitaciones">
          <button class="sb-row sidebar-group-trigger" onclick="toggleGroup(this)">
            <ion-icon name="checkbox-outline" class="sb-icon"></ion-icon>
            <span class="sb-label">Habilitaciones</span>
            <ion-icon name="chevron-forward-outline" class="sb-chevron"></ion-icon>
          </button>
          <div class="sidebar-submenu">
            <span class="flyout-title">Lista</span>
            <a class="sidebar-subitem" href="index.php?views=habilitaciones" onclick="
                  activateItem(this);
                ">
              <ion-icon name="list-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Lista</span>
            </a>
          </div>
        </div> -->





        <!-- sistema -->
        <?php if ($_SESSION['rol_smp'] == 1) { ?>
          <div class="sidebar-section-label">Sistema</div>

          <!-- configuracion -->
          <a class="sb-row sidebar-item" data-tip="Personal" href="index.php?views=personal" onclick="
              activateItem(this);
              return false;
            ">
            <ion-icon name="settings-outline" class="sb-icon"></ion-icon>
            <span class="sb-label">Personal</span>
          </a>
          <!-- <div class="sidebar-group" data-group="config">
            <button class="sb-row sidebar-group-trigger" onclick="toggleGroup(this)">
              <ion-icon name="settings-outline" class="sb-icon"></ion-icon>
              <span class="sb-label">Configuración</span>
              <ion-icon name="chevron-forward-outline" class="sb-chevron"></ion-icon>
            </button>
            <div class="sidebar-submenu">
              <span class="flyout-title">Configuración</span>
              
              <a class="sidebar-subitem" href="index.php?views=personal" onclick="
                  activateItem(this);
                ">
                <ion-icon name="list-outline" class="sb-icon"></ion-icon>
                <span class="sb-label">Lista de usuarios</span>
              </a>

            </div>
          </div> -->
        <?php } ?>


        <!-- ayuda -->
        <!-- <a class="sb-row sidebar-item" data-tip="Ayuda" href="#" onclick="
              activateItem(this);
              return false;
            ">
          <ion-icon name="help-circle-outline" class="sb-icon"></ion-icon>
          <span class="sb-label">Ayuda</span>
        </a> -->
      </nav>

      <!-- pie -->
      <div class="sidebar-footer">
        <a class="sidebar-footer-avatar" href="index.php?views=perfil" onclick="activateItem(this)" style="text-decoration: none; color: inherit; cursor: pointer;">
          <?php
          require_once __DIR__ . "/../../models/userModel.php";
          $usuario_id = $_SESSION['id_smp'];
          $datos_usuario = userModel::obtener_usuario($usuario_id);
          $usuario = $datos_usuario->fetch();
          $iniciales = strtoupper(substr($usuario['us_nombres'], 0, 1) . substr($usuario['us_apellido_paterno'], 0, 1));
          echo $iniciales;
          ?>
        </a>
        <div class="sidebar-footer-info">
          <div class="sidebar-footer-name"><?php echo $usuario['us_nombres'] . ' ' . $usuario['us_apellido_paterno']; ?></div>
          <div class="sidebar-footer-role"><?php echo $usuario['us_username']; ?></div>
        </div>
      </div>
    </aside>

    <!-- overlay mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="closeMobileSidebar()"></div>