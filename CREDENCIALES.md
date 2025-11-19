# Sistema de Biblioteca - Credenciales de Acceso

## Usuarios de Prueba

### Usuario Administrador
- **Email:** admin@biblioteca.com
- **Password:** password
- **Rol:** Administrador del sistema

### Usuario Regular
- **Email:** user@biblioteca.com
- **Password:** password
- **Rol:** Usuario estándar

## Acceso al Sistema

1. Visita: http://localhost:8001
2. Haz clic en "Iniciar Sesión"
3. Utiliza cualquiera de las credenciales anteriores

## Funcionalidades Disponibles

### Para usuarios autenticados:
- Ver catálogo de libros
- Gestionar autores y categorías
- Realizar préstamos de libros
- Ver historial de préstamos personales
- Gestión completa CRUD (Create, Read, Update, Delete)

### Páginas principales:
- `/` - Página de inicio
- `/login` - Iniciar sesión
- `/register` - Registro de nuevos usuarios
- `/dashboard` - Panel principal (requiere autenticación)
- `/books` - Catálogo de libros
- `/authors` - Gestión de autores
- `/categories` - Gestión de categorías
- `/loans` - Gestión de préstamos
- `/my-loans` - Mis préstamos personales

## Tecnologías Utilizadas

- **Backend:** Laravel 11
- **Frontend:** Blade Templates con Tailwind CSS
- **Autenticación:** Laravel Breeze
- **Base de datos:** SQLite
- **Assets:** Vite

## Comandos Útiles

```bash
# Iniciar servidor de desarrollo
php artisan serve

# Crear nuevos usuarios de prueba
php artisan user:create-test

# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed
```