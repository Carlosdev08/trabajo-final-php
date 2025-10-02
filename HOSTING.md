# 🚀 Guía de Despliegue en Hosting

## 📋 Requisitos del Servidor
- **PHP**: 7.4 o superior (recomendado 8.0+)
- **MySQL**: 5.7 o superior
- **Apache/Nginx**: con mod_rewrite habilitado
- **Espacio**: Mínimo 50MB

## 🗂️ Estructura de Archivos para Hosting

### 1. Carpeta `public_html` o `www`
```
public_html/
├── index.php
├── .htaccess
├── assets/
│   ├── bootstrap/
│   ├── css/
│   └── js/
└── logs/ (crear manualmente, permisos 755)
```

### 2. Carpeta fuera de `public_html` (más seguro)
```
tu-hosting/
├── public_html/
│   ├── index.php
│   ├── .htaccess
│   └── assets/
└── innovacode-app/
    ├── app/
    ├── config/
    ├── core/
    ├── database/
    └── routes/
```

## ⚙️ Configuración paso a paso

### Paso 1: Subir archivos
1. **Comprimir** toda la carpeta del proyecto
2. **Subir** via FTP/FileManager del hosting
3. **Extraer** en el servidor

### Paso 2: Configurar Base de Datos
1. **Crear base de datos** en el panel del hosting
2. **Importar** `database/newsletters.sql`
3. **Actualizar** credenciales en `config/env.php`

### Paso 3: Configurar permisos
```bash
chmod 755 public/logs/
chmod 644 config/env.php
chmod 644 .htaccess
```

### Paso 4: Verificar URLs
- Actualizar `APP_URL` en `config/env.php`
- Verificar que las rutas funcionen

## 📊 Configuración de Base de Datos

### En el panel de hosting:
1. Crear base de datos: `tunombre_newsletters`
2. Crear usuario: `tunombre_user`
3. Asignar permisos al usuario

### Actualizar config/env.php:
```php
$_ENV['DB_HOST'] = 'localhost'; // o IP del hosting
$_ENV['DB_NAME'] = 'tunombre_newsletters';
$_ENV['DB_USER'] = 'tunombre_user';
$_ENV['DB_PASS'] = 'tu_password';
$_ENV['APP_URL'] = 'https://tudominio.com';
```

## 🌐 Recomendaciones de Hosting

### Hosting Gratuitos (para pruebas):
- **InfinityFree**: PHP 8.1, MySQL, SSL gratis
- **000WebHost**: PHP 8.0, MySQL, 1GB espacio
- **AwardSpace**: PHP 8.0, MySQL, 1GB espacio

### Hosting de Pago (para producción):
- **Hostinger**: Desde $1.99/mes
- **SiteGround**: Desde $3.99/mes
- **Bluehost**: Desde $2.95/mes

## 🔧 Solución de Problemas

### Error 500:
- Verificar permisos de archivos
- Revisar logs de error del servidor
- Comprobar sintaxis PHP

### Base de datos no conecta:
- Verificar credenciales en `config/env.php`
- Comprobar que la BD existe
- Verificar permisos del usuario

### CSS/JS no cargan:
- Verificar rutas en `core/Helpers.php`
- Comprobar permisos de carpeta `assets/`
- Verificar .htaccess

## ✅ Lista de Verificación Final

- [ ] Base de datos creada e importada
- [ ] config/env.php actualizado
- [ ] Permisos de archivos correctos
- [ ] .htaccess configurado
- [ ] URLs funcionando
- [ ] Formularios funcionando
- [ ] Login/registro funcionando
- [ ] Panel admin accesible

## 📞 Datos de Acceso por Defecto

**Administrador:**
- Usuario: admin
- Contraseña: admin123

**Usuario Normal:**
- Usuario: miralofles
- Contraseña: user123

---
**Proyecto:** InnovaCode - Plataforma de Desarrollo Web
**Versión:** 1.0
**Framework:** PHP MVC Personalizado