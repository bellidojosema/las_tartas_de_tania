# Las Tartas de Tania (Symfony)

Aplicación web desarrollada en Symfony para la gestión de productos del negocio **Las Tartas de Tania**.

## Dominio del problema
Tania vende tartas y galletas caseras y necesita una aplicación que le permita administrar su catálogo de productos de forma segura, con persistencia en base de datos y acceso mediante autenticación.

## Requisitos implementados
- Página de inicio (`/`) con propósito de la app y enlaces principales.
- Página de login (`/login`).
- Gestión de datos del dominio (CRUD completo de productos): crear, listar, editar y eliminar.
- Formularios Symfony con validaciones.
- Controladores con rutas por atributos `#[Route]`.
- Vistas Twig con plantilla base reutilizable.
- Persistencia con Doctrine ORM + migraciones.

## Entidad principal gestionada (CRUD)
`Product` con estos campos:
- `name`
- `description`
- `category`
- `price`
- `stock`
- `imageUrl`
- `isAvailable`

## Puesta en marcha
1. Instalar dependencias:
   ```bash
   composer install
   ```
2. Configurar la conexión en `.env` (`DATABASE_URL`).
3. Ejecutar migraciones:
   ```bash
   php bin/console doctrine:migrations:migrate -n
   ```
4. Crear usuario administrador de prueba:
   ```bash
   php bin/console app:create-admin
   ```
5. Arrancar servidor:
   ```bash
   symfony serve -d
   ```
   o
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

## Credenciales de prueba
- **Email:** `admin@tartas.local`
- **Password:** `Admin1234!`

(Se generan con `php bin/console app:create-admin`).
