<div class="login-layout">
    <div class="login-left">
        <div class="login-form-container">
            <h2 class="login-title">RECUPERAR CONTRASEÑA</h2>
            <p style="color: #666; margin-bottom: 2rem; font-size: 0.9rem;">
                Ingresa tu correo electrónico registrado y te enviaremos las instrucciones para restablecer tu contraseña.
            </p>
            <form action="" class="login-form" method="POST" id="recovery-form">
                <div class="form-group">
                    <label for="recovery_email" class="form-label">CORREO ELECTRÓNICO</label>
                    <input type="email" id="recovery_email" name="Email_recovery" maxlength="120" required placeholder="ejemplo@correo.com">
                </div>
                <button type="submit" class="login-button" id="btn-recovery">ENVIAR INSTRUCCIONES</button>
                <div class="form-footer">
                    <a href="<?php echo SERVER_URL; ?>index.php?views=login" class="forgot-password">Volver al Inicio de Sesión</a>
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
    // Reutilización del funcionamiento del Carousel
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

    // Funcionalidad mejorada con JS para el formulario
    document.querySelector('#recovery-form').addEventListener('submit', function(e) {
        const emailInput = document.querySelector('#recovery_email');
        const btn = document.querySelector('#btn-recovery');
        
        if (!emailInput.value || !emailInput.checkValidity()) {
            e.preventDefault();
            Swal.fire({
                title: 'Correo Inválido',
                text: 'Por favor ingresa un correo electrónico válido.',
                icon: 'warning',
                confirmButtonColor: '#00305A'
            });
            return;
        }

        // Simulación de carga visual antes de la integración
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ENVIANDO...';
        
        // El envío real se manejará cuando se genere el módulo
        console.log("Formulario listo para envío: ", emailInput.value);
    });
</script>
