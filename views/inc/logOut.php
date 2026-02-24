<?php
require_once __DIR__ . "/../../models/mainModel.php";
require_once __DIR__ . "/../../controllers/loginController.php";
$lc = new loginController();
?>
<div class="modal-overlay" id="modalLogout">
    <div class="modal-nx" style="max-width: 420px">
        <div class="modal-header-nx">
            <h3 class="modal-title-nx">cerrar sesion</h3>
            <button class="modal-close" onclick="closeModal('modalLogout')">
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>
        <div class="modal-body-nx" style="text-align: center">
            <div style="display:flex;justify-content:center;margin-bottom:16px;">
                <ion-icon name="log-out-outline" style="font-size:48px;color:var(--color-warning);"></ion-icon>
            </div>
            <p style="margin:0;color:var(--color-text);">esta seguro de que desea cerrar sesion?</p>
        </div>
        <div class="modal-footer-nx">
            <button class="btn-nx btn-secondary btn-md" onclick="closeModal('modalLogout')">
                cancelar
            </button>
            <button class="btn-nx btn-danger btn-md" id="btnConfirmLogout">
                cerrar sesion
            </button>
        </div>
    </div>
</div>

<script>
    function initLogout() {
        const btn_salir = document.querySelector(".btn-exit-system");
        const btn_confirm = document.getElementById("btnConfirmLogout");

        if (!btn_salir) return;

        btn_salir.addEventListener('click', (e) => {
            e.preventDefault();
            openModal('modalLogout');
        });

        if (btn_confirm) {
            btn_confirm.addEventListener('click', () => {
                closeModal('modalLogout');
                
                const url = '<?php echo SERVER_URL; ?>ajax/loginAjax.php';
                const token = '<?php echo mainModel::encryption($_SESSION['token_smp']); ?>';
                const usuario = '<?php echo mainModel::encryption($_SESSION['usuario_smp']); ?>';

                const datos = new FormData();
                datos.append("token", token);
                datos.append("usuario", usuario);

                fetch(url, {
                        method: 'POST',
                        body: datos
                    })
                    .then(res => res.json())
                    .then(respuesta => {
                        if (respuesta.Alerta === "redireccionar") {
                            Swal.fire({
                                title: "sesion cerrada",
                                text: "redirigiendo al login...",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = respuesta.URL;
                            });
                        } else {
                            Swal.fire({
                                title: "error",
                                text: "no se pudo cerrar la sesion",
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error("error al cerrar sesion:", error);
                        Swal.fire({
                            title: "error",
                            text: "ocurrio un problema al cerrar sesion",
                            icon: "error"
                        });
                    });
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLogout);
    } else {
        initLogout();
    }
</script>
