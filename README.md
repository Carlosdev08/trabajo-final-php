# 🚀 InnovaCode - Sistema de Gestión PHP

Sistema web completo desarrollado en PHP puro con arquitectura MVC para la gestión de usuarios, noticias y citaciones.

## 📋 Características Principales

### ✅ **Funcionalidades Implementadas**
- 🔐 **Sistema de Autenticación** - Login/registro con roles (admin/user)
- 👥 **Gestión de Usuarios** - CRUD completo con panel administrativo
- 📰 **Sistema de Noticias** - Administración de contenido
- 📅 **Sistema de Citaciones** - Programación de citas
- 🏠 **Dashboard Administrativo** - Panel de control
- 👤 **Perfil de Usuario** - Gestión de datos personales

### 🛡️ **Características de Seguridad**

#### 🔒 **Autenticación y Autorización**
- Hash seguro de contraseñas con `PASSWORD_DEFAULT`
- Verificación con `password_verify()`
- Control de acceso basado en roles
- Protección de rutas administrativas

#### 🛡️ **Protección CSRF**
- Tokens CSRF en todos los formularios
- Validación automática en controladores
- Regeneración segura de tokens

#### ⚠️ **Rate Limiting**
- **Login**: 5 intentos máximo en 5 minutos
- **Registro**: 3 intentos máximo en 10 minutos
- Mensajes informativos de tiempo de espera

#### 🔍 **Validación Mejorada**
- **Email**: Validación con `filter_var()`
- **Contraseñas Fuertes**: 
  - Mínimo 8 caracteres
  - 1 letra mayúscula
  - 1 letra minúscula
  - 1 número
  - 1 carácter especial
- **Unicidad**: Verificación de usuario/email únicos

#### 📊 **Sistema de Logs de Seguridad**
- Registro de intentos de login
- Logs de accesos no autorizados
- Detección de tokens CSRF inválidos
- Auditoría de creación/modificación de usuarios

#### 🔐 **Protección contra Vulnerabilidades**
- **SQL Injection**: PDO prepared statements
- **XSS**: `htmlspecialchars()` en todas las salidas
- **Directory Traversal**: `.htaccess` protege directorios sensibles
- **Session Security**: Gestión segura de sesiones

## 🏗️ Arquitectura

### 📁 **Estructura del Proyecto**
```
innovacode/
├── app/
│   ├── Controllers/     # Lógica de negocio
│   ├── Models/         # Acceso a datos
│   └── Views/          # Presentación
├── core/               # Framework core
│   ├── Autoloader.php  # Cargador automático
│   ├── Controller.php  # Controlador base
│   ├── CSRF.php        # Protección CSRF
│   ├── DB.php          # Conexión base de datos
│   ├── RateLimit.php   # Limitación de intentos
│   ├── SecurityLogger.php # Sistema de logs
│   ├── Session.php     # Gestión de sesiones
│   ├── Validator.php   # Validaciones
│   └── View.php        # Motor de vistas
├── public/             # Punto de entrada web
│   ├── index.php       # Entrada principal
│   └── assets/         # CSS, JS, imágenes
├── config/             # Configuración
├── database/           # Scripts SQL
├── logs/               # Logs de seguridad
└── routes/             # Definición de rutas
```

### 🎯 **Patrón MVC**
- **Models**: Gestión de datos con PDO
- **Views**: Templates PHP con separación completa
- **Controllers**: Lógica de aplicación y validaciones

## 🔧 Instalación y Configuración

### 📋 **Requisitos**
- PHP 8.0+
- MySQL/MariaDB
- Servidor web (Apache/Nginx)
- mod_rewrite habilitado

### ⚙️ **Configuración**
1. **Base de Datos**: Importar `database/innovacode.sql`
2. **Configuración**: Copiar `config/env.example.php` a `config/env.php`
3. **Permisos**: Configurar permisos de escritura en `logs/`

### 🔑 **Configuración de Base de Datos**
```php
// config/env.php
<?php
return [
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'innovacode',
    'DB_USER' => 'usuario',
    'DB_PASS' => 'contraseña',
];
```

## 💻 Tecnologías Utilizadas

### 🎨 **Frontend**
- **Bootstrap 5** - Framework CSS responsivo
- **JavaScript ES6+** - Funcionalidad dinámica
- **Font Awesome** - Iconografía
- **CSS3 Custom** - Estilos personalizados con gradientes

### ⚙️ **Backend**
- **PHP 8** - Lenguaje principal
- **PDO** - Acceso seguro a base de datos
- **MySQL** - Sistema de gestión de base de datos
- **Arquitectura MVC** - Patrón de diseño

### 🛠️ **Herramientas de Desarrollo**
- **Git** - Control de versiones
- **GitHub** - Repositorio remoto
- **Composer** (preparado) - Gestión de dependencias

## 🚦 Uso del Sistema

### 👤 **Roles de Usuario**

#### 🔓 **Usuario Regular**
- Ver noticias públicas
- Solicitar citaciones
- Gestionar perfil personal
- Acceso al dashboard básico

#### 👑 **Administrador**
- Gestión completa de usuarios (CRUD)
- Administración de noticias
- Gestión de citaciones
- Acceso a logs de seguridad
- Panel de administración completo

### 🔐 **Flujo de Autenticación**
1. **Registro**: Validación estricta + confirmación de email
2. **Login**: Rate limiting + logs de seguridad
3. **Sesión**: Gestión segura con roles
4. **Logout**: Limpieza completa de sesión

## 🛡️ Consideraciones de Seguridad

### ✅ **Implementado**
- Hash seguro de contraseñas
- Protección CSRF completa
- Validación de entrada estricta
- Rate limiting en acciones críticas
- Logs de seguridad detallados
- Protección XSS y SQL Injection
- Control de acceso basado en roles

### 🔄 **Mejoras Futuras Sugeridas**
- Autenticación de dos factores (2FA)
- Recuperación de contraseña por email
- Bloqueo de IP por intentos fallidos
- Audit trail completo
- Cifrado de datos sensibles

## 📈 Estado del Proyecto

### ✅ **Completado (100%)**
- ✅ Arquitectura MVC limpia
- ✅ Funcionalidades CRUD completas
- ✅ Sistema de seguridad robusto
- ✅ Interfaz responsive con Bootstrap
- ✅ Control de versiones con Git
- ✅ Documentación completa

### 🎯 **Listo para Producción**
El proyecto cumple con todos los estándares de seguridad modernos y está preparado para entornos de producción con las configuraciones adecuadas.

---

## 👨‍💻 Desarrollo

**Proyecto**: Trabajo Final Master D  
**Tecnología**: PHP MVC + Bootstrap 5  
**Repositorio**: [GitHub - trabajo-final-php](https://github.com/Carlosdev08/trabajo-final-php)  
**Estado**: ✅ Completado y Auditado

---

> 🚀 **Sistema robusto, seguro y escalable desarrollado con las mejores prácticas de PHP moderno**