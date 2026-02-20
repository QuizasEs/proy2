<?php
                if(isset($_POST['Usuario_log']) && isset($_POST['Password_log'])){
                    require_once "./controllers/loginController.php";
                    $ins_login = new loginController();
                    echo $ins_login->iniciar_sesion_controller();
                    exit();
                }
            ?>
            <!---------------------------------------------login--------------------------------------------------->
            <div class="login-layout">
                <div class="login-left">
                    <div class="login-form-container">
                        <h2 class="login-title">INICIAR SESIÓN</h2>
                        <form action="" class="login-form" method="POST">
                            <div class="form-group">
                                <label for="username" class="form-label">NOMBRE DE USUARIO</label>
                                <input type="text" id="username" name="Usuario_log" pattern="^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ_]{3,100}" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label">CONTRASEÑA</label>
                                <input type="password" id="password" name="Password_log" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ0-9@$!%*?&._#\]{3,100}" maxlength="100" required>
                            </div>
                            <button type="submit" class="login-button">INGRESAR</button>
                            <div class="form-footer">
                                <a href="<?php echo SERVER_URL; ?>index.php?views=recuperarPassword" class="forgot-password">¿Olvidaste tu contraseña?</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="login-right">
                    <div class="carousel-container">
                        <div class="carousel-item active">
                            <img src="<?php echo SERVER_URL; ?>views/image/background-logo.png" alt="Welcome" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Sistema de Gestión Farmacéutica</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo SERVER_URL; ?>views/image/injectable.jpeg" alt="Injectable" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Sistema de Gestión Farmacéutica</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo SERVER_URL; ?>views/image/parche.jpg" alt="Patch" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Sistema de Gestión Farmacéutica</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo SERVER_URL; ?>views/image/vita.jpg" alt="Vita" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Sistema de Gestión Farmacéutica</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                // Carousel functionality
                let currentSlide = 0;
                const slides = document.querySelectorAll('.carousel-item');
                const dots = [];
                
                // Create dots
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
                
                // Update active dot
                function updateDots() {
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === currentSlide);
                    });
                }
                
                // Go to specific slide
                function goToSlide(index) {
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[index].classList.add('active');
                    currentSlide = index;
                    updateDots();
                }
                
                // Next slide
                function nextSlide() {
                    const nextIndex = (currentSlide + 1) % slides.length;
                    goToSlide(nextIndex);
                }
                
                // Initialize
                updateDots();
                
                // Auto-advance every 20 seconds
                setInterval(nextSlide, 20000);
                
                // Form submission
                document.querySelector('.login-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const username = document.querySelector('#username').value;
                    const password = document.querySelector('#password').value;
                    
                    if (username && password) {
                        this.submit();
                    } else {
                        alert('Por favor complete todos los campos');
                    }
                });
            </script>