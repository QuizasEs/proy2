<header class="navbar-top">
        <!-- Botón sidebar: colapsa en desktop, abre drawer en mobile -->
        <button class="navbar-sidebar-btn" id="sidebarToggleBtn" onclick="toggleSidebar()" title="Menú">
          <ion-icon name="menu-outline" id="sidebarToggleIcon"></ion-icon>
        </button>

        <!-- <div class="navbar-search">
          <ion-icon name="search-outline"></ion-icon>
          <input type="text" placeholder="Buscar en el sistema..." />
        </div> -->

        <div class="navbar-actions">
          <!-- <button class="navbar-btn" title="Notificaciones" onclick="
                showToast(
                  'info',
                  'Notificaciones',
                  'No tienes nuevas notificaciones.',
                )
              ">
            <ion-icon name="notifications-outline"></ion-icon>
            <span class="navbar-notif-dot"></span>
          </button> -->
<!--           <button class="navbar-btn" title="Mensajes">
            <ion-icon name="chatbubble-outline"></ion-icon>
          </button> -->
          <button class="navbar-btn" id="themeToggle" title="Cambiar tema" onclick="toggleTheme()">
            <ion-icon name="moon-outline" id="themeIcon"></ion-icon>
          </button>
          <div style="width: 1px; height: 24px; background: var(--color-border)"></div>
          <div class="navbar-user-info">
            <?php
            require_once __DIR__ . "/../../models/userModel.php";
            $usuario_id = $_SESSION['id_smp'];
            $datos_usuario = userModel::obtener_usuario($usuario_id);
            $usuario = $datos_usuario->fetch();
            ?>
            <span class="navbar-user-name"><?php echo $usuario['us_nombres'] . ' ' . $usuario['us_apellido_paterno']; ?></span>
            <span class="navbar-user-role"><?php echo $usuario['us_username']; ?></span>
          </div>
          <a class="navbar-avatar" href="index.php?views=perfil" onclick="activateItem(this)" style="text-decoration: none; color: inherit; cursor: pointer;">
            <?php
            $iniciales = strtoupper(substr($usuario['us_nombres'], 0, 1) . substr($usuario['us_apellido_paterno'], 0, 1));
            echo $iniciales;
            ?>
          </a>
          <button class="navbar-btn btn-exit-system" title="cerrar sesion">
            <ion-icon name="log-out-outline"></ion-icon>
          </button>
        </div>
      </header>