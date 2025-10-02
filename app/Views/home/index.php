<!-- Hero Section -->
<div class="jumbotron text-white rounded-3 p-5 mb-4 fade-in">
    <div class="container-fluid">
        <h1 class="display-4">Bienvenido a InnovaCode</h1>
        <p class="lead">Tu plataforma de desarrollo web y tecnología más avanzada</p>
        <a class="btn btn-light btn-lg" href="<?= \Core\Helpers::baseUrl('/noticias') ?>" role="button">Ver Noticias</a>
    </div>
</div>

<!-- Secciones de contenido -->
<div class="row">
    <div class="col-md-6 mb-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Servicios de Desarrollo</h5>
                <p class="card-text">Ofrecemos servicios completos de desarrollo web usando las últimas tecnologías como
                    PHP, MySQL, JavaScript y más.</p>
                <a href="<?= \Core\Helpers::baseUrl('/servicios') ?>" class="btn btn-primary">Conocer más</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4 fade-in">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">Consultoría Tecnológica</h5>
                <p class="card-text">Asesoramos a empresas en la transformación digital y implementación de soluciones
                    tecnológicas innovadoras.</p>
                <a href="<?= \Core\Helpers::baseUrl('/servicios/consultoria') ?>" class="btn btn-primary">Solicitar
                    consulta</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4 fade-in">
        <div class="card text-center h-100 clickable-card"
            onclick="location.href='<?= \Core\Helpers::baseUrl('/servicios/desarrollo-web') ?>'"
            style="cursor: pointer;">
            <div class="card-body">
                <i class="fas fa-code fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Desarrollo Web</h5>
                <p class="card-text">Creamos sitios web modernos y responsivos</p>
                <a href="<?= \Core\Helpers::baseUrl('/servicios/desarrollo-web') ?>"
                    class="btn btn-outline-primary btn-sm">Ver más</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4 fade-in">
        <div class="card text-center h-100 clickable-card"
            onclick="location.href='<?= \Core\Helpers::baseUrl('/servicios/base-datos') ?>'" style="cursor: pointer;">
            <div class="card-body">
                <i class="fas fa-database fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Base de Datos</h5>
                <p class="card-text">Diseño y optimización de bases de datos</p>
                <a href="<?= \Core\Helpers::baseUrl('/servicios/base-datos') ?>"
                    class="btn btn-outline-primary btn-sm">Ver más</a>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4 fade-in">
        <div class="card text-center h-100 clickable-card"
            onclick="location.href='<?= \Core\Helpers::baseUrl('/servicios/apps-moviles') ?>'" style="cursor: pointer;">
            <div class="card-body">
                <i class="fas fa-mobile-alt fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Apps Móviles</h5>
                <p class="card-text">Desarrollo de aplicaciones móviles nativas</p>
                <a href="<?= \Core\Helpers::baseUrl('/servicios/apps-moviles') ?>"
                    class="btn btn-outline-primary btn-sm">Ver más</a>
            </div>
        </div>
    </div>
</div>

<!-- Sección de contacto -->
<div class="row mt-5">
    <div class="col-12 fade-in">
        <div class="card bg-light">
            <div class="card-body text-center py-5">
                <h3>¿Listo para comenzar tu proyecto?</h3>
                <p class="lead">Contáctanos hoy mismo y comencemos a trabajar juntos</p>
                <a href="<?= \Core\Helpers::baseUrl('/servicios/contacto') ?>"
                    class="btn btn-primary btn-lg me-2">Contactar Ahora</a>
                <a href="<?= \Core\Helpers::baseUrl('/registro') ?>" class="btn btn-success btn-lg me-2">Registrarse</a>
                <a href="<?= \Core\Helpers::baseUrl('/login') ?>" class="btn btn-outline-primary btn-lg">Iniciar
                    Sesión</a>
            </div>
        </div>
    </div>
</div>