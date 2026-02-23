<?php
require_once __DIR__ . "/../../models/userModel.php";
$usuario_id = $_SESSION['id_smp'];
$datos_usuario = userModel::obtener_usuario($usuario_id);
$usuario = $datos_usuario->fetch();
?>

<div class="row g-4">
  <div class="col-12">
    <div class="card-nx animate-in">
      <div class="card-header-nx">
        <h2 class="section-title" style="margin: 0">Informacion personal</h2>
      </div>
      <div class="card-body-nx">
        <form id="formPerfil" class="FormularioAjax row g-4" method="POST" action="<?php echo SERVER_URL; ?>ajax/userAjax.php" data-form="update" enctype="multipart/form-data">
          <input type="hidden" name="Usuario_id_up" value="<?php echo mainModel::encryption($_SESSION['id_smp']); ?>">

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Nombres <span style="color: var(--color-danger)">*</span></label>
            <input class="form-control-nx" type="text" name="Nombres_up" value="<?php echo $usuario['us_nombres']; ?>" required />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Apellido paterno <span style="color: var(--color-danger)">*</span></label>
            <input class="form-control-nx" type="text" name="ApellidoPaterno_up" value="<?php echo $usuario['us_apellido_paterno']; ?>" required />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Apellido materno <span style="color: var(--color-danger)">*</span></label>
            <input class="form-control-nx" type="text" name="ApellidoMaterno_up" value="<?php echo $usuario['us_apellido_materno']; ?>" required />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Numero de carnet</label>
            <input class="form-control-nx" type="text" name="Carnet_up" value="<?php echo $usuario['us_numero_carnet']; ?>" placeholder="Ingrese su numero de carnet" />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Telefono</label>
            <input class="form-control-nx" type="tel" name="Telefono_up" value="<?php echo $usuario['us_telefono']; ?>" placeholder="Ingrese su telefono" />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Correo electronico</label>
            <input class="form-control-nx" type="email" name="Correo_up" value="<?php echo $usuario['us_correo']; ?>" />
          </div>

          <div class="col-12">
            <label class="form-label-nx">Direccion</label>
            <textarea class="form-control-nx" name="Direccion_up" rows="3" placeholder="Ingrese su direccion"><?php echo $usuario['us_direccion']; ?></textarea>
          </div>

          <div class="col-12">
            <div style="display: flex; gap: var(--space-3); justify-content: flex-end">
              <button type="button" class="btn-nx btn-danger btn-md" onclick="window.location.href='index.php?views=dashboard'">
                <ion-icon name="close-outline"></ion-icon>
                Cancelar
              </button>
              <button type="submit" class="btn-nx btn-primary btn-md">
                <ion-icon name="save-outline"></ion-icon>
                Guardar cambios
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php if ($_SESSION['rol_smp'] == 1) { ?>
  <div class="col-12">
    <div class="card-nx animate-in">
      <div class="card-header-nx">
        <h2 class="section-title" style="margin: 0">Cambiar usuario y contraseña</h2>
      </div>
      <div class="card-body-nx">
        <form id="formCredenciales" class="FormularioAjax row g-4" method="POST" action="<?php echo SERVER_URL; ?>ajax/userAjax.php" data-form="update" enctype="multipart/form-data">
          <input type="hidden" name="Usuario_id_up" value="<?php echo mainModel::encryption($_SESSION['id_smp']); ?>">

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Nuevo nombre de usuario <span style="color: var(--color-danger)">*</span></label>
            <input class="form-control-nx" type="text" name="NuevoUsuario_up" value="<?php echo $usuario['us_username']; ?>" required />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Contraseña actual</label>
            <input class="form-control-nx" type="password" id="Password_actual_up" name="Password_actual_up" placeholder="Ingrese la contraseña actual" />
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Nueva contraseña</label>
            <div style="position: relative;">
              <input class="form-control-nx" type="password" id="NuevoPassword_up" name="NuevoPassword_up" placeholder="Ingrese la nueva contraseña" style="padding-right: 40px;" />
              <button type="button" onclick="togglePassword('NuevoPassword_up', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--color-text-muted); padding: 0;">
                <ion-icon name="eye-outline"></ion-icon>
              </button>
            </div>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label-nx">Confirmar contraseña</label>
            <div style="position: relative;">
              <input class="form-control-nx" type="password" id="ConfirmarPassword_up" name="ConfirmarPassword_up" placeholder="Confirme la nueva contraseña" style="padding-right: 40px;" />
              <button type="button" onclick="togglePassword('ConfirmarPassword_up', this)" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--color-text-muted); padding: 0;">
                <ion-icon name="eye-outline"></ion-icon>
              </button>
            </div>
          </div>

          <div class="col-12">
            <div style="display: flex; gap: var(--space-3); justify-content: flex-end">
              <button type="submit" class="btn-nx btn-primary btn-md">
                <ion-icon name="key-outline"></ion-icon>
                Actualizar credenciales
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php } ?>
</div>