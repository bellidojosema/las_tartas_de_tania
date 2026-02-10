# Las Tartas de Tania (Symfony)

Aplicación web desarrollada en Symfony para la gestión del negocio **Las Tartas de Tania**.

## Dominio del problema
Tania vende tartas y galletas caseras y necesita una aplicación que le permita administrar su catálogo, usuarios, pedidos y citas de recogida con acceso seguro y persistencia en base de datos.

## Requisitos implementados
- Página de inicio (`/`) rediseñada con Bootstrap.
- Página de login (`/login`) y registro (`/registro`).
- Gestión de datos del dominio (CRUD completo de productos).
- Formularios Symfony con validaciones.
- Controladores con rutas por atributos `#[Route]`.
- Vistas Twig con plantilla base reutilizable.
- Persistencia con Doctrine ORM + migraciones.

## Entidades del dominio
1. `User`
2. `Product`
3. `Category` ✅ (nueva)
4. `Order` ✅ (nueva)
5. `OrderItem` ✅ (nueva)
6. `PickupAppointment` ✅ (nueva)

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

## Credenciales de prueba (admin)
- **Usuario/email:** `admin@tartas.local`
- **Contraseña:** `Admin1234!`
