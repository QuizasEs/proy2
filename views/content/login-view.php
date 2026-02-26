
            <!---------------------------------------------login--------------------------------------------------->
            <?php
            if (isset($_SESSION['error_login'])) {
                echo '<script>
                    Swal.fire({
                        title: "Ocurrio un error",
                        text: "' . $_SESSION['error_login'] . '",
                        icon: "error",
                        confirmButtonText: "Aceptar"
                    });
                </script>';
                unset($_SESSION['error_login']);
            }
            ?>
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
                            <img src="<?php echo SERVER_URL; ?>image/hero1.jpg" alt="Welcome" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Planeación</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo SERVER_URL; ?>image/hero2.jpg" alt="Injectable" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Organización</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo SERVER_URL; ?>image/hero3.jpg" alt="Patch" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Dirección</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo SERVER_URL; ?>image/hero4.jpg" alt="Vita" class="carousel-image">
                            <div class="carousel-overlay">
                                <h3 class="carousel-title">BIENVENIDO AL SISTEMA</h3>
                                <p class="carousel-subtitle">Control</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                // funcion de carrusel
                let currentSlide = 0;
                const slides = document.querySelectorAll('.carousel-item');
                const dots = [];
                
                // dots
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
                
                // actualizar dot
                function updateDots() {
                    dots.forEach((dot, index) => {
                        dot.classList.toggle('active', index === currentSlide);
                    });
                }
                
                // ir a especifico dot

                function goToSlide(index) {
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[index].classList.add('active');
                    currentSlide = index;
                    updateDots();
                }
                
                // siguiente slider
                function nextSlide() {
                    const nextIndex = (currentSlide + 1) % slides.length;
                    goToSlide(nextIndex);
                }
                
                // iniciador
                updateDots();
                
                // 20 segundos entre imagen
                setInterval(nextSlide, 20000);
                
                // formulario emergente

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