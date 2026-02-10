# Memoria técnica - Proyecto final

## 1. Introducción
### Dominio
El proyecto modela el dominio de **Las Tartas de Tania**, un negocio artesanal de tartas y galletas que necesita digitalizar la gestión de su catálogo.

### Objetivos
- Disponer de una aplicación web funcional en Symfony.
- Proteger el acceso con login.
- Gestionar productos con operaciones CRUD.
- Persistir datos en base de datos con Doctrine y migraciones.

## 2. Análisis del sistema
### Funcionalidades principales
- Página de inicio informativa.
- Inicio de sesión para acceder al área de gestión.
- Alta, listado, edición y borrado de productos.

### Flujo principal
1. Usuario entra en `/`.
2. Se autentica en `/login`.
3. Accede a `/productos` para administrar el catálogo.

## 3. Diseño
### Entidades y campos
- **User**: `id`, `email`, `password`, `roles`, `fullName`, `phone`.
- **Product**: `id`, `name`, `description`, `category`, `price`, `stock`, `imageUrl`, `isAvailable`.

### Justificación del modelo
- `User` permite controlar acceso y roles.
- `Product` contiene la información esencial del catálogo para el negocio.

### Estructura general
- `src/Controller`: control de rutas y lógica HTTP.
- `src/Entity`: modelo Doctrine.
- `src/Form`: definición de formularios.
- `templates/`: vistas Twig y layout base.
- `migrations/`: versionado de esquema de base de datos.

## 4. Implementación
### Controladores relevantes
- `HomeController`: página principal.
- `SecurityController`: login y logout.
- `ProductController`: CRUD de productos.

### Formularios y validaciones
Formulario `ProductType` con más de 5 campos y validaciones:
- Obligatorios (`NotBlank`).
- Longitud mínima (`Length`).
- Precio positivo (`Positive`).
- Stock no negativo (`PositiveOrZero`).
- URL válida para imagen (`Url`).

### Acceso a datos
- Doctrine ORM con entidades por atributos.
- Repositorios para consulta.
- Migración inicial para tablas `user` y `product`.

## 5. Conclusiones
### Dificultades encontradas
- Definición inicial del esquema de seguridad y autenticación.
- Ajuste de validaciones de formulario al dominio real.

### Aprendizajes adquiridos
- Integración completa de Symfony (controladores + formularios + Twig + seguridad).
- Gestión de persistencia y versionado de base de datos con Doctrine y migraciones.
- Organización de una aplicación MVC con buenas prácticas básicas.
