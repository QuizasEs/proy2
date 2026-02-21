<script src="<?php echo SERVER_URL; ?>views/script/alertas.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /* barra lateral */
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const toggleIcon = document.getElementById('sidebarToggleIcon');
    const overlay = document.getElementById('sidebarOverlay');

    // estado
    let isCollapsed = false;

    const isMobile = () => window.innerWidth <= 991;

    /* funciones de ayuda */
    function closeAllSubmenus() {
        sidebar.querySelectorAll('.sidebar-submenu.is-open').forEach(sm => {
            sm.classList.remove('is-open');
        });
        sidebar.querySelectorAll('.sidebar-group-trigger.is-open').forEach(t => {
            t.classList.remove('is-open');
        });
    }

    function openGroup(trigger) {
        const submenu = trigger.closest('.sidebar-group').querySelector('.sidebar-submenu');
        trigger.classList.add('is-open');
        submenu.classList.add('is-open');
    }

    function closeGroup(trigger) {
        const submenu = trigger.closest('.sidebar-group').querySelector('.sidebar-submenu');
        trigger.classList.remove('is-open');
        submenu.classList.remove('is-open');
    }

    /* boton hamburguesa */
    function toggleSidebar() {
        if (isMobile()) {
            // mobile: abrir cerrar menu
            const open = sidebar.classList.contains('is-open');
            sidebar.classList.toggle('is-open', !open);
            overlay.classList.toggle('is-visible', !open);
            toggleIcon.setAttribute('name', open ? 'menu-outline' : 'close-outline');
        } else {
            // desktop: contraer expandir
            isCollapsed = !isCollapsed;
            sidebar.classList.toggle('is-collapsed', isCollapsed);
            mainContent.classList.toggle('collapsed', isCollapsed);
            toggleIcon.setAttribute('name', 'menu-outline');

            // al contraer cerrar submenu
            if (isCollapsed) closeAllSubmenus();
        }
    }

    /* capa oscura mobile */
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');
        toggleIcon.setAttribute('name', 'menu-outline');
    });

    /* evento redimensionar */
    window.addEventListener('resize', () => {
        if (!isMobile()) {
            // limpiar estado mobile
            sidebar.classList.remove('is-open');
            overlay.classList.remove('is-visible');
            toggleIcon.setAttribute('name', 'menu-outline');
            // restaurar estado desktop
            sidebar.classList.toggle('is-collapsed', isCollapsed);
            mainContent.classList.toggle('collapsed', isCollapsed);
        } else {
            // limpiar estado desktop
            sidebar.classList.remove('is-collapsed');
            mainContent.classList.remove('collapsed');
        }
    });

    /* clic fuera del menu */
    document.addEventListener('click', e => {
        if (!isCollapsed) return;
        if (sidebar.contains(e.target)) return;
        closeAllSubmenus();
    });

    /* alternar submenu */
    function toggleGroup(trigger) {
        const group = trigger.closest('.sidebar-group');
        const submenu = group.querySelector('.sidebar-submenu');
        const isOpen = submenu.classList.contains('is-open');

        // si esta contraido en desktop
        if (!isMobile() && isCollapsed) {
            isCollapsed = false;
            sidebar.classList.remove('is-collapsed');
            mainContent.classList.remove('collapsed');
            closeAllSubmenus();
            setTimeout(() => openGroup(trigger), 50);
            return;
        }

        // cerrar otros submenus
        sidebar.querySelectorAll('.sidebar-group-trigger.is-open').forEach(t => {
            if (t !== trigger) closeGroup(t);
        });

        // alternar este grupo
        if (isOpen) closeGroup(trigger);
        else openGroup(trigger);
    }

    /* marcar elemento activo */
    function activateItem(el) {
        // limpiar estado activo anterior
        sidebar.querySelectorAll('.is-active').forEach(i => i.classList.remove('is-active'));
        sidebar.querySelectorAll('.has-active').forEach(t => t.classList.remove('has-active'));

        // activar el elemento
        el.classList.add('is-active');

        // si es un subitem
        const group = el.closest('.sidebar-group');
        if (group) {
            const trigger = group.querySelector('.sidebar-group-trigger');
            const submenu = group.querySelector('.sidebar-submenu');

            trigger.classList.add('has-active');
            trigger.classList.add('is-open');
            submenu.classList.add('is-open');

            // en modo contraido
            if (!isMobile() && isCollapsed) {
                setTimeout(() => {
                    trigger.classList.remove('is-open');
                    submenu.classList.remove('is-open');
                }, 200);
            }

            // en mobile
            if (isMobile()) {
                setTimeout(() => {
                    sidebar.classList.remove('is-open');
                    overlay.classList.remove('is-visible');
                    toggleIcon.setAttribute('name', 'menu-outline');
                }, 150);
            }
        } else {
            // item simple
            closeAllSubmenus();

            // en mobile
            if (isMobile()) {
                setTimeout(() => {
                    sidebar.classList.remove('is-open');
                    overlay.classList.remove('is-visible');
                    toggleIcon.setAttribute('name', 'menu-outline');
                }, 150);
            }
        }
    }

    /* iniciar estado al cargar */
    document.addEventListener('DOMContentLoaded', () => {
        const activeSubitem = sidebar.querySelector('.sidebar-subitem.is-active');
        if (activeSubitem) {
            const group = activeSubitem.closest('.sidebar-group');
            const trigger = group?.querySelector('.sidebar-group-trigger');
            const submenu = group?.querySelector('.sidebar-submenu');
            if (trigger && submenu) {
                trigger.classList.add('is-open', 'has-active');
                submenu.classList.add('is-open');
            }
        }
    });

    /* modo oscuro */
    const themeIcon = document.getElementById('themeIcon');

    // aplicar tema guardado
    (function applyStoredTheme() {
        const saved = localStorage.getItem('nexus-theme');
        if (saved === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            themeIcon.setAttribute('name', 'sunny-outline');
        }
    })();

    function toggleTheme() {
        const html = document.documentElement;
        const isDark = html.getAttribute('data-theme') === 'dark';
        const next = isDark ? 'light' : 'dark';
        html.setAttribute('data-theme', next);
        themeIcon.setAttribute('name', isDark ? 'moon-outline' : 'sunny-outline');
        localStorage.setItem('nexus-theme', next);
    }

    /* ventanas modales */
    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('open');
        document.body.style.overflow = '';
    }
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    /* pestañas */
    function switchTab(btn, panelId) {
        btn.closest('.tabs-nx').querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.tab-panel').forEach(p => {
            if (['tab-all', 'tab-success', 'tab-pending', 'tab-failed'].includes(p.id)) p.classList.remove('active');
        });
        document.getElementById(panelId).classList.add('active');
    }

    /* notificaciones toast */
    const toastIcons = {
        success: 'checkmark-circle-outline',
        error: 'close-circle-outline',
        info: 'information-circle-outline',
        warning: 'warning-outline'
    };

    function showToast(type, title, message) {
        const container = document.getElementById('toastContainer');
        const toast = document.createElement('div');
        toast.className = `toast-nx ${type}`;
        toast.innerHTML = `
      <div class="toast-icon-wrap"><ion-icon name="${toastIcons[type]}"></ion-icon></div>
      <div style="flex:1;"><div class="toast-title">${title}</div><div class="toast-msg">${message}</div></div>
      <button onclick="this.parentElement.remove()" style="border:none;background:none;cursor:pointer;color:var(--color-text-muted);padding:0;display:flex;align-items:center;">
        <ion-icon name="close-outline" style="font-size:18px;"></ion-icon>
      </button>`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'slideInToast 0.3s ease reverse';
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }

    /* paginacion */
    document.querySelectorAll('.page-btn:not(:disabled)').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.querySelector('ion-icon')) return;
            this.closest('.pagination-nx').querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });
</script>