# Sistema de Ventas y Reportes - IDBI

Este proyecto es una API RESTful desarrollada en Laravel para gestionar un sistema básico de ventas y generación de reportes. Cumple con los requerimientos funcionales y no funcionales solicitados en el reto técnico.

## Requisitos

- PHP 8.0 o superior
- Composer
- MySQL 8.0 o MariaDB 10.5
- Laravel 8.0 o superior

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tu-usuario/reto-idbi.git
   cd reto-idbi


## Estructura del Proyecto
app/Models: Contiene los modelos de la aplicación (User, Product, Sale, etc.).

app/Http/Controllers: Contiene los controladores de la API.

database/migrations: Contiene las migraciones para crear las tablas de la base de datos.

routes/api.php: Define las rutas de la API.


##Endpoints de la API

Autenticación
POST /api/register: Registro de usuarios.

POST /api/login: Inicio de sesión (genera un token).

POST /api/logout: Cierre de sesión (invalida el token).

Productos
GET /api/products: Listar todos los productos.

POST /api/products: Crear un producto (solo admin y seller).

GET /api/products/{id}: Mostrar un producto específico.

PUT /api/products/{id}: Actualizar un producto (solo admin y seller).

DELETE /api/products/{id}: Eliminar un producto (solo admin y seller).

Ventas
POST /api/sales: Registrar una venta.

GET /api/reports/sales: Generar un reporte de ventas en JSON.

GET /api/reports/sales/export: Exportar un reporte de ventas en Excel.


DIAGRAMA ERD: 
+-----------------+          +-----------------+          +-----------------+
|     Users       |          |    Products     |          |      Sales      |
+-----------------+          +-----------------+          +-----------------+
| id (PK)         |<-------->| id (PK)         |<-------->| id (PK)         |
| name            |          | sku             |          | code            |
| lastname        |          | name            |          | client_name     |
| email           |          | unit_price      |          | client_ident... |
| password        |          | stock           |          | client_email    |
| role            |          +-----------------+          | total           |
+-----------------+                                       | user_id (FK)    |
                                                          +-----------------+
                                                                  |
                                                                  |
                                                                  v
                                                          +-----------------+
                                                          |   SaleItems     |
                                                          +-----------------+
                                                          | id (PK)         |
                                                          | sale_id (FK)    |
                                                          | product_id (FK) |
                                                          | quantity        |
                                                          | unit_price      |
                                                          | subtotal        |
                                                          +-----------------+
