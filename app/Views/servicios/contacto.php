<div class="servicios-hero">
    <div class="container">
        <h1><i class="fas fa-envelope me-3"></i>Contacto</h1>
        <p>Solicita tu presupuesto personalizado sin compromiso</p>
    </div>
</div>

<div class="container">
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= Core\Helpers::e($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulario de Contacto -->
        <div class="col-lg-8">
            <div class="contacto-form">
                <h2 class="mb-4">Solicitar Presupuesto</h2>
                <form method="POST" action="<?= Core\Helpers::baseUrl('/servicios/contacto') ?>">
                    <?= Core\CSRF::getTokenInput() ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono *</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="empresa" class="form-label">Empresa</label>
                                <input type="text" class="form-control" id="empresa" name="empresa">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="servicio" class="form-label">Servicio de Interés *</label>
                        <select class="form-select" id="servicio" name="servicio" required>
                            <option value="">Selecciona un servicio</option>
                            <option value="desarrollo-web">Desarrollo Web</option>
                            <option value="base-datos">Base de Datos</option>
                            <option value="apps-moviles">Apps Móviles</option>
                            <option value="consultoria">Consultoría Tecnológica</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="presupuesto" class="form-label">Presupuesto Estimado</label>
                        <select class="form-select" id="presupuesto" name="presupuesto">
                            <option value="">Selecciona un rango</option>
                            <option value="500-1000">500€ - 1.000€</option>
                            <option value="1000-2500">1.000€ - 2.500€</option>
                            <option value="2500-5000">2.500€ - 5.000€</option>
                            <option value="5000+">Más de 5.000€</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="mensaje" class="form-label">Mensaje *</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="5" 
                                  placeholder="Describe tu proyecto, necesidades específicas, plazos, etc." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-servicio btn-lg">
                        <i class="fas fa-paper-plane me-2"></i>Enviar Solicitud
                    </button>
                </form>
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="col-lg-4">
            <div class="contacto-info">
                <h4>Información de Contacto</h4>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong><br>
                        info@innovacode.com
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <strong>Teléfono</strong><br>
                        +34 600 000 000
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Oficina</strong><br>
                        Madrid, España
                    </div>
                </div>

                <div class="info-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Horario</strong><br>
                        Lun - Vie: 9:00 - 18:00
                    </div>
                </div>

                <hr class="my-4">

                <h5>¿Por qué elegirnos?</h5>
                <ul class="caracteristicas-lista">
                    <li>Más de 5 años de experiencia</li>
                    <li>Proyectos entregados a tiempo</li>
                    <li>Soporte post-lanzamiento</li>
                    <li>Tecnologías más actuales</li>
                    <li>Precios competitivos</li>
                </ul>

                <div class="mt-4">
                    <h6>Síguenos</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-linkedin fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-github fa-2x"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="text-center mb-4">Preguntas Frecuentes</h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                            ¿Cuánto tiempo toma desarrollar un proyecto?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Los tiempos varían según la complejidad. Un sitio web básico: 2-4 semanas. 
                            Aplicaciones complejas: 2-6 meses. Te daremos una estimación precisa tras el análisis inicial.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                            ¿Ofrecen soporte después del lanzamiento?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Sí, todos nuestros proyectos incluyen soporte post-lanzamiento. 
                            El período depende del paquete contratado, desde 1 mes hasta 1 año.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                            ¿Trabajan con empresas internacionales?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Absolutamente. Trabajamos con clientes de toda Europa y América. 
                            Usamos metodologías ágiles y herramientas de colaboración remota.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>