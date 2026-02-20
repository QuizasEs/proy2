<div class="login-layout">
    <div class="login-left">
        <div class="login-form-container">
            <h2 class="login-title">RECUPERAR CONTRASEÑA</h2>
            <p style="color: #666; margin-bottom: 2rem; font-size: 0.9rem;">
                Ingresa tu correo electrónico registrado y te enviaremos las instrucciones para restablecer tu contraseña.
            </p>
            
            <form action="" class="login-form" method="POST" id="email-form">
                <div class="form-group">
                    <label for="recovery_email" class="form-label">CORREO ELECTRÓNICO</label>
                    <input type="email" id="recovery_email" name="Email_recovery" maxlength="120" required placeholder="ejemplo@correo.com">
                </div>
                <button type="submit" class="login-button" id="btn-email">ENVIAR CÓDIGO</button>
                <div class="form-footer">
                    <a href="<?php echo SERVER_URL; ?>index.php?views=login" class="forgot-password">Volver al Inicio de Sesión</a>
                </div>
            </form>

            <form action="" class="login-form" method="POST" id="codigo-form" style="display: none;">
                <div class="form-group">
                    <label for="recovery_codigo" class="form-label">CÓDIGO DE VERIFICACIÓN</label>
                    <input type="text" id="recovery_codigo" name="Codigo_recovery" maxlength="6" required placeholder="000000" pattern="[0-9]{6}" style="letter-spacing: 5px; text-align: center; font-size: 1.5rem;">
                </div>
                <button type="submit" class="login-button" id="btn-codigo">VERIFICAR CÓDIGO</button>
                <div class="form-footer">
                    <a href="#" id="btn-volver-email" class="forgot-password">Volver</a>
                </div>
            </form>

            <form action="" class="login-form" method="POST" id="password-form" style="display: none;">
                <div class="form-group">
                    <label for="new_password" class="form-label">NUEVA CONTRASEÑA</label>
                    <input type="password" id="new_password" name="Password_new" maxlength="100" required placeholder="Ingresa tu nueva contraseña">
                </div>
                <div class="form-group">
                    <label for="confirm_password" class="form-label">CONFIRMAR CONTRASEÑA</label>
                    <input type="password" id="confirm_password" name="Password_confirm" maxlength="100" required placeholder="Confirma tu nueva contraseña">
                </div>
                <button type="submit" class="login-button" id="btn-password">CAMBIAR CONTRASEÑA</button>
                <div class="form-footer">
                    <a href="<?php echo SERVER_URL; ?>index.php?views=login" class="forgot-password">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
    <div class="login-right">
        <div class="carousel-container">
            <div class="carousel-item active">
                <img src="<?php echo SERVER_URL; ?>views/image/background-logo.png" alt="Recovery" class="carousel-image">
                <div class="carousel-overlay">
                    <h3 class="carousel-title">SEGURIDAD Y CONTROL</h3>
                    <p class="carousel-subtitle">Protegiendo tu acceso al sistema farmacéutico</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo SERVER_URL; ?>views/image/injectable.jpeg" alt="Pharmacy" class="carousel-image">
                <div class="carousel-overlay">
                    <h3 class="carousel-title">ASISTENCIA TÉCNICA</h3>
                    <p class="carousel-subtitle">Estamos aquí para ayudarte a recuperar tu cuenta</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo SERVER_URL; ?>views/image/parche.jpg" alt="Support" class="carousel-image">
                <div class="carousel-overlay">
                    <h3 class="carousel-title">GESTIÓN EFICIENTE</h3>
                    <p class="carousel-subtitle">Acceso seguro a todas nuestras herramientas</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="<?php echo SERVER_URL; ?>views/image/vita.jpg" alt="Access" class="carousel-image">
                <div class="carousel-overlay">
                    <h3 class="carousel-title">SISTEMA INTEGRAL</h3>
                    <p class="carousel-subtitle">Farmacia, Inventario y Facturación en un solo lugar</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-item');
    const dots = [];
    
    const carouselContainer = document.querySelector('.carousel-container');
    const controlsContainer = document.createElement('div');
    controlsContainer.className = 'carousel-controls';
    
    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.className = 'carousel-dot';
        dot.addEventListener('click', () => goToSlide(index));
        controlsContainer.appendChild(dot);
        dots.push(dot);
    });
    
    carouselContainer.appendChild(controlsContainer);
    
    function updateDots() {
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === currentSlide);
        });
    }
    
    function goToSlide(index) {
        slides.forEach(slide => slide.classList.remove('active'));
        slides[index].classList.add('active');
        currentSlide = index;
        updateDots();
    }
    
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        goToSlide(nextIndex);
    }
    
    updateDots();
    setInterval(nextSlide, 20000);

    function mostrarFormularioCodigo() {
        document.getElementById('email-form').style.display = 'none';
        document.getElementById('codigo-form').style.display = 'block';
        document.getElementById('password-form').style.display = 'none';
    }

    function mostrarFormularioPassword() {
        document.getElementById('email-form').style.display = 'none';
        document.getElementById('codigo-form').style.display = 'none';
        document.getElementById('password-form').style.display = 'block';
    }

    document.getElementById('btn-volver-email').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('email-form').style.display = 'block';
        document.getElementById('codigo-form').style.display = 'none';
        document.getElementById('password-form').style.display = 'none';
    });

    document.getElementById('email-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const emailInput = document.querySelector('#recovery_email');
        const btn = document.querySelector('#btn-email');
        
        if (!emailInput.value || !emailInput.checkValidity()) {
            Swal.fire({
                title: 'Correo Inválido',
                text: 'Por favor ingresa un correo electrónico válido.',
                icon: 'warning',
                confirmButtonColor: '#00305A'
            });
            return;
        }

        btn.disabled = true;
        btn.innerHTML = 'ENVIANDO...';

        const formData = new FormData(this);
        formData.append('Email_recovery', emailInput.value);

        fetch('<?php echo SERVER_URL; ?>ajax/recuperarPasswordAjax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data;
            const scriptTag = tempDiv.querySelector('script');
            if (scriptTag) {
                eval(scriptTag.innerHTML);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerHTML = 'ENVIAR CÓDIGO';
        });
    });

    document.getElementById('codigo-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const emailInput = document.querySelector('#recovery_email');
        const codigoInput = document.querySelector('#recovery_codigo');
        const btn = document.querySelector('#btn-codigo');
        
        if (!codigoInput.value || codigoInput.value.length !== 6) {
            Swal.fire({
                title: 'Código Inválido',
                text: 'El código debe tener exactamente 6 dígitos.',
                icon: 'warning',
                confirmButtonColor: '#00305A'
            });
            return;
        }

        btn.disabled = true;
        btn.innerHTML = 'VERIFICANDO...';

        const formData = new FormData();
        formData.append('Email_recovery', emailInput.value);
        formData.append('Codigo_recovery', codigoInput.value);

        fetch('<?php echo SERVER_URL; ?>ajax/recuperarPasswordAjax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data;
            const scriptTag = tempDiv.querySelector('script');
            if (scriptTag) {
                eval(scriptTag.innerHTML);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerHTML = 'VERIFICAR CÓDIGO';
        });
    });

    document.getElementById('password-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const emailInput = document.querySelector('#recovery_email');
        const passwordInput = document.querySelector('#new_password');
        const confirmInput = document.querySelector('#confirm_password');
        const btn = document.querySelector('#btn-password');
        
        if (!passwordInput.value || !confirmInput.value) {
            Swal.fire({
                title: 'Campos Vacíos',
                text: 'Por favor completa todos los campos.',
                icon: 'warning',
                confirmButtonColor: '#00305A'
            });
            return;
        }

        if (passwordInput.value !== confirmInput.value) {
            Swal.fire({
                title: 'Contraseñas No Coinciden',
                text: 'Las contraseñas no coinciden.',
                icon: 'warning',
                confirmButtonColor: '#00305A'
            });
            return;
        }

        btn.disabled = true;
        btn.innerHTML = 'CAMBIANDO...';

        const formData = new FormData();
        formData.append('Email_recovery', emailInput.value);
        formData.append('Password_new', passwordInput.value);
        formData.append('Password_confirm', confirmInput.value);

        fetch('<?php echo SERVER_URL; ?>ajax/recuperarPasswordAjax.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data;
            const scriptTag = tempDiv.querySelector('script');
            if (scriptTag) {
                eval(scriptTag.innerHTML);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            btn.disabled = false;
            btn.innerHTML = 'CAMBIAR CONTRASEÑA';
        });
    });
</script>
