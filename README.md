# 📚 Sistema de Biblioteca

Sistema completo de gestión de biblioteca desarrollado con **Laravel 11** y **TailwindCSS**. Incluye gestión de libros, autores, géneros y préstamos con control de roles (Administrador, Bibliotecario, Lector).

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=flat&logo=laravel)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.0-38B2AC?style=flat&logo=tailwind-css)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php)

---

## ✨ Características Principales

### 🎨 Diseño
- Interfaz moderna con sidebar responsivo
- Fuente **Poppins** desde Google Fonts
- Paleta de colores personalizada:
  - Primary: `#1E3A8A` (Azul oscuro)
  - Primary Light: `#3B82F6` (Azul claro)
  - Background: `#F1F5F9` (Gris claro)

### 🔐 Sistema de Roles

#### 👑 Administrador
- ✅ CRUD completo de **Libros**
- ✅ CRUD completo de **Autores**
- ✅ CRUD completo de **Géneros**
- ✅ Gestión total de **Préstamos**
- ✅ Dashboard con estadísticas completas
- ✅ Ver todos los usuarios por rol

#### 📚 Bibliotecario
- ✅ Visualizar catálogo de libros
- ✅ Gestionar préstamos (crear, devolver)
- ✅ Ver estadísticas de libros y préstamos
- ❌ No puede editar libros, autores ni géneros

#### 👤 Lector
- ✅ Ver catálogo de libros
- ✅ Solicitar préstamos
- ✅ Ver historial personal de préstamos
- ✅ Dashboard con estadísticas personales

### 🚀 Funcionalidades

- **Búsqueda y Filtros**: Buscar libros por título, autor, género y disponibilidad
- **Control Automático**: Los libros se marcan automáticamente como no disponibles al prestarse
- **Gestión de Atrasos**: Cálculo automático de préstamos atrasados
- **Relaciones Eloquent**: Modelos completamente relacionados
- **Validaciones**: Validación completa en formularios
- **API REST**: Endpoints para libros, autores y géneros
- **Seeders**: Datos de prueba pre-cargados

---

## 📋 Requisitos

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite (incluido) o MySQL/PostgreSQL

---

## 🛠️ Instalación

### 1. Clonar el repositorio
```bash
git clone <tu-repositorio>
cd biblioteca
```

### 2. Instalar dependencias
```bash
composer install
npm install
```

### 3. Configurar variables de entorno
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar base de datos
El proyecto usa SQLite por defecto. Si quieres usar MySQL/PostgreSQL, edita el archivo `.env`:

```env
DB_CONNECTION=sqlite
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=biblioteca
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Ejecutar migraciones y seeders
```bash
php artisan migrate:fresh --seed
```

### 6. Compilar assets
```bash
npm run build
```

### 7. Iniciar servidor
```bash
php artisan serve
```

Accede a: **http://127.0.0.1:8000**

---

## 👥 Credenciales de Acceso

El seeder crea 3 usuarios de prueba:

| Rol | Email | Contraseña |
|-----|-------|------------|
| **Administrador** | admin@biblioteca.com | password |
| **Bibliotecario** | bibliotecario@biblioteca.com | password |
| **Lector** | lector@biblioteca.com | password |

---

## 📊 Estructura de la Base de Datos

### Tablas Principales

#### `users`
- `id`, `name`, `email`, `password`
- `rol` → enum('admin', 'bibliotecario', 'lector')

#### `autores`
- `id`, `nombre`, `nacionalidad`, `fecha_nacimiento`

#### `generos`
- `id`, `nombre`, `descripcion`

#### `libros`
- `id`, `titulo`, `autor_id` (FK), `genero_id` (FK)
- `anio_publicacion`, `isbn` (unique), `disponible` (boolean)

#### `prestamos`
- `id`, `user_id` (FK), `libro_id` (FK)
- `fecha_prestamo`, `fecha_devolucion`
- `estado` → enum('prestado', 'devuelto', 'atrasado')

### Relaciones

```
User ──< Prestamo >── Libro ──> Autor
                        │
                        └──> Genero
```

---

## 🎯 Funcionalidades Implementadas

### Modelos con Lógica Avanzada

#### `Libro.php`
```php
// Scope para libros disponibles
Libro::disponibles()->get();

// Scope para búsqueda (incluye búsqueda por autor)
Libro::buscar('García Márquez')->get();
```

#### `Prestamo.php`
```php
// Control automático de disponibilidad en eventos boot()
// Cuando se crea un préstamo → libro.disponible = false
// Cuando se marca devuelto → libro.disponible = true

// Scope para préstamos activos
Prestamo::activos()->get();

// Scope para préstamos atrasados
Prestamo::atrasados()->get();

// Método para verificar si está atrasado
$prestamo->estaAtrasado(); // boolean
```

#### `User.php`
```php
// Métodos helper para roles
$user->isAdmin();
$user->isBibliotecario();
$user->isLector();
```

### Rutas API

```php
GET /api/libros       // Libros disponibles con autor y género
GET /api/autores      // Lista de autores ordenada
GET /api/generos      // Lista de géneros ordenada
```

---

## 🔐 Seguridad y Middlewares

### Middleware Personalizado: `CheckRole`

El sistema implementa protección profesional a nivel de rutas mediante el middleware `CheckRole`:

```php
// app/Http/Middleware/CheckRole.php
public function handle(Request $request, Closure $next, ...$roles)
{
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    if (!in_array(auth()->user()->rol, $roles)) {
        abort(403, 'No tienes permisos para acceder a esta página.');
    }

    return $next($request);
}
```

### Protección de Rutas por Rol

#### Solo Administrador (`role:admin`)
- **Libros**: `create`, `store`, `edit`, `update`, `destroy`
- **Autores**: CRUD completo
- **Géneros**: CRUD completo

#### Administrador y Bibliotecario (`role:admin,bibliotecario`)
- **Préstamos**: `devolver`, `destroy`

#### Todos los usuarios autenticados
- **Libros**: `index`, `show` (catálogo)
- **Préstamos**: `index`, `create`, `store`, `show`

### Ejemplo de uso en rutas:
```php
// routes/web.php
Route::middleware('role:admin')->group(function () {
    Route::resource('autores', AutorController::class);
    Route::resource('generos', GeneroController::class);
});

Route::middleware('role:admin,bibliotecario')->group(function () {
    Route::patch('/prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver']);
});
```

### Página de Error 403
El sistema incluye una vista personalizada `errors/403.blade.php` que muestra:
- Icono de acceso denegado
- Mensaje explicativo del error
- Rol actual del usuario
- Botones para volver al dashboard o página anterior

---

## 📁 Estructura de Vistas

```
resources/views/
├── layouts/
│   ├── sidebar.blade.php      # Layout principal con sidebar
│   └── guest.blade.php         # Layout para login/register
├── dashboard.blade.php         # Dashboard con estadísticas
├── libros/
│   ├── index.blade.php         # Catálogo con filtros
│   ├── create.blade.php        # Formulario crear
│   ├── edit.blade.php          # Formulario editar
│   └── show.blade.php          # Detalle del libro
├── autores/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
├── generos/
│   ├── index.blade.php
│   ├── create.blade.php
│   ├── edit.blade.php
│   └── show.blade.php
└── prestamos/
    ├── index.blade.php         # Lista con filtros
    ├── create.blade.php        # Nuevo préstamo
    └── show.blade.php          # Detalle con alertas
```

---

## 🎨 Componentes de Diseño

### Sidebar
- Navegación adaptada por rol
- Links activos resaltados
- Información del usuario
- Botón de logout

### Cards de Estadísticas
- Total de libros
- Libros disponibles
- Préstamos activos
- Préstamos atrasados
- Contador de usuarios (solo admin)

### Formularios
- Validación en tiempo real
- Mensajes de error
- Selects dinámicos
- Fechas con restricciones

---

## 🔧 Comandos Útiles

```bash
# Limpiar y recargar base de datos
php artisan migrate:fresh --seed

# Compilar assets en desarrollo
npm run dev

# Compilar assets para producción
npm run build

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Crear un nuevo usuario
php artisan tinker
>>> User::create(['name' => 'Test', 'email' => 'test@test.com', 'password' => Hash::make('password'), 'rol' => 'lector'])
```

---

## 📝 Datos de Prueba

El seeder incluye:

- **3 Usuarios**: 1 admin, 1 bibliotecario, 1 lector
- **8 Géneros**: Ficción, No Ficción, Ciencia Ficción, Romance, Misterio, Biografía, Historia, Poesía
- **8 Autores**: Gabriel García Márquez, Isabel Allende, Jorge Luis Borges, Pablo Neruda, Octavio Paz, Mario Vargas Llosa, Julio Cortázar, Carlos Fuentes
- **10 Libros**: Clásicos de la literatura latinoamericana
- **3 Préstamos**: 2 activos, 1 devuelto

---

## 🚀 Próximas Mejoras

- [ ] Multas por atraso
- [ ] Reservas de libros
- [ ] Notificaciones por email
- [ ] Exportar reportes en PDF/Excel
- [ ] Sistema de calificaciones/reseñas
- [ ] Historial completo de préstamos por libro
- [ ] Gráficos y estadísticas avanzadas
- [ ] Búsqueda avanzada con múltiples criterios

---

## 📄 Licencia

Este proyecto es de código abierto bajo la licencia MIT.

---

## 👨‍💻 Desarrollado con

- [Laravel 11](https://laravel.com)
- [TailwindCSS 3](https://tailwindcss.com)
- [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#breeze)
- [SQLite](https://www.sqlite.org)
- [Vite](https://vitejs.dev)

---

**¡Disfruta gestionando tu biblioteca!** 📚✨

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
