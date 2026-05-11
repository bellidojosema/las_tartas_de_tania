🍰 Las Tartas de Tania - Repostería Artesanal

Sistema de gestión para una pastelería artesanal desarrollado con **Symfony 7** y **Bootstrap 5**. La aplicación permite gestionar un catálogo de productos, categorías y organizar las citas para la recogida de pedidos.

## 📋 Dominio del Problema
El negocio "Las Tartas de Tania" necesitaba digitalizar la gestión de sus pedidos y productos. El sistema resuelve:
- **Gestión de Inventario:** Control total sobre tartas y dulces categorizados.
- **Reserva de Citas:** Los clientes pueden agendar día, hora y lugar (Tienda u Obrador) para recoger sus dulces.
- **Roles de Usuario:** Diferenciación entre administración (control total) y clientes (visualización y citas).

## 🚀 Instrucciones de Ejecución

### Requisitos previos
- PHP 8.2 o superior
- Composer
- Symfony CLI 
- Servidor de Base de Datos (MySQL)

### Instalación
1. **Clonar el repositorio:**
   
   git clone [https://github.com/tu-usuario/las-tartas-de-tania.git](https://github.com/tu-usuario/las-tartas-de-tania.git)
   cd las-tartas-de-tania
   
2. Instalar dependencias:
composer install

3. Configurar variables de entorno:
   Crea un archivo .env y configura tu base de datos:
   DATABASE_URL="mysql://usuario:password@127.0.0.1:3306/tartas_tania?serverVersion=8.0"

4.Preparar la Base de Datos:
    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

5.Cargar datos de prueba:
    php bin/console doctrine:fixtures:load --append
    
6. Iniciar el servidor:
   symfony serve
   
## 🔐 Credenciales de Prueba

| Rol | Email | Contraseña |
| :--- | :--- | :--- |
| **Administrador** | `admin@taniatartas.com` | `admin123` |
| **Cliente** | `cliente@hola.com` | `cliente123` |

