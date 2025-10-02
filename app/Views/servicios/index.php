<div class="servicios-hero">
    <div class="container">
        <h1><i class="fas fa-cogs me-3"></i>Nuestros Servicios</h1>
        <p>Soluciones tecnológicas innovadoras para hacer crecer tu negocio</p>
    </div>
</div>

<div class="container">
    <!-- Servicios Principales -->
    <div class="row g-4 mb-5">
        <div class="col-lg-4 col-md-6">
            <div class="card servicio-card">
                <div class="card-header">
                    <i class="fas fa-code"></i>
                    <h3>Desarrollo Web</h3>
                </div>
                <div class="card-body">
                    <p>Creamos sitios web modernos y responsivos usando las últimas tecnologías.</p>
                    <ul class="caracteristicas-lista">
                        <li>Diseño responsive</li>
                        <li>PHP, JavaScript, MySQL</li>
                        <li>SEO optimizado</li>
                        <li>Panel de administración</li>
                    </ul>
                    <div class="precio-badge">Desde 800€</div>
                    <a href="<?= Core\Helpers::baseUrl('/servicios/desarrollo-web') ?>" class="btn btn-servicio w-100">
                        Ver Detalles
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card servicio-card">
                <div class="card-header">
                    <i class="fas fa-database"></i>
                    <h3>Base de Datos</h3>
                </div>
                <div class="card-body">
                    <p>Diseño y optimización de bases de datos escalables y seguras.</p>
                    <ul class="caracteristicas-lista">
                        <li>Diseño normalizado</li>
                        <li>Optimización de consultas</li>
                        <li>Backup automático</li>
                        <li>Seguridad avanzada</li>
                    </ul>
                    <div class="precio-badge">Desde 500€</div>
                    <a href="<?= Core\Helpers::baseUrl('/servicios/base-datos') ?>" class="btn btn-servicio w-100">
                        Ver Detalles
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card servicio-card">
                <div class="card-header">
                    <i class="fas fa-mobile-alt"></i>
                    <h3>Apps Móviles</h3>
                </div>
                <div class="card-body">
                    <p>Desarrollo de aplicaciones móviles nativas y multiplataforma.</p>
                    <ul class="caracteristicas-lista">
                        <li>iOS y Android</li>
                        <li>React Native / Flutter</li>
                        <li>API integration</li>
                        <li>Push notifications</li>
                    </ul>
                    <div class="precio-badge">Desde 1200€</div>
                    <a href="<?= Core\Helpers::baseUrl('/servicios/apps-moviles') ?>" class="btn btn-servicio w-100">
                        Ver Detalles
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Consultoría -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card servicio-card">
                <div class="card-header">
                    <i class="fas fa-lightbulb"></i>
                    <h3>Consultoría Tecnológica</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="lead">Asesoramos a empresas en la transformación digital y implementación de
                                soluciones tecnológicas innovadoras.</p>
                            <ul class="caracteristicas-lista">
                                <li>Análisis de necesidades tecnológicas</li>
                                <li>Planificación de proyectos digitales</li>
                                <li>Optimización de procesos</li>
                                <li>Capacitación de equipos</li>
                                <li>Auditorías de seguridad</li>
                                <li>Migración a la nube</li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="precio-badge mb-3">Desde 150€/hora</div>
                            <a href="<?= Core\Helpers::baseUrl('/servicios/consultoria') ?>" class="btn btn-servicio">
                                Ver Detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="row">
        <div class="col-12 text-center">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body py-5">
                    <h2 class="mb-3">¿Listo para comenzar tu proyecto?</h2>
                    <p class="lead mb-4">Contáctanos hoy mismo y comencemos a trabajar juntos</p>
                    <a href="<?= Core\Helpers::baseUrl('/servicios/contacto') ?>" class="btn btn-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>Solicitar Presupuesto
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>