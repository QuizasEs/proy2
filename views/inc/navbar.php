<header class="navbar-top">
        <!-- Botón sidebar: colapsa en desktop, abre drawer en mobile -->
        <button class="navbar-sidebar-btn" id="sidebarToggleBtn" onclick="toggleSidebar()" title="Menú">
          <ion-icon name="menu-outline" id="sidebarToggleIcon"></ion-icon>
        </button>

        <div class="navbar-search">
          <ion-icon name="search-outline"></ion-icon>
          <input type="text" placeholder="Buscar en el sistema..." />
        </div>

        <div class="navbar-actions">
          <button class="navbar-btn" title="Notificaciones" onclick="
                showToast(
                  'info',
                  'Notificaciones',
                  'No tienes nuevas notificaciones.',
                )
              ">
            <ion-icon name="notifications-outline"></ion-icon>
            <span class="navbar-notif-dot"></span>
          </button>
<!--           <button class="navbar-btn" title="Mensajes">
            <ion-icon name="chatbubble-outline"></ion-icon>
          </button> -->
          <button class="navbar-btn" id="themeToggle" title="Cambiar tema" onclick="toggleTheme()">
            <ion-icon name="moon-outline" id="themeIcon"></ion-icon>
          </button>
          <div style="width: 1px; height: 24px; background: var(--color-border)"></div>
          <div class="navbar-user-info">
            <span class="navbar-user-name">Admin</span>
            <span class="navbar-user-role">Rol Admin</span>
          </div>
          <div class="navbar-avatar" onclick="
                showToast(
                  'success',
                  'Perfil',
                  'Admin — Rol Admin',
                )
              ">
            AJ
          </div>
        </div>
      </header>