# LARAVEL
Laravel es un framework de desarrollo web en PHP, es decir, un conjunto de herramientas, librerías y reglas que te ayudan a crear aplicaciones web de forma más rápida, organizada y segura que si escribieras todo el código PHP desde cero.

Lo primero que se debe hacer es: 
- instalar composer  
Una vez instalado debemos instalar laravel de forma global para no tener ningun problema, lo hacemos con el siguiente comando:

```bash
composer  global require laravel/installer
```
----
# CREAR UN PROYECTO POR TERMINAL 
```bash
Laravel new <name_proyect>
```
----
# CORRER UN SERVIDOR PHP POR CONSOLA 
```bash
php -S localhost:8080 -t public 
```
----
Para correr el sistema y ver que funciona debemos tomar en cuenta varios factores:  
- Tener encendido xamp
- revisar el archivo .env que esta en la raiz del proyecto que creaste
- crear la BD en phpmyAdmin con el mismo nombre que viene en ese archivo en la parte de BD
- usar el puerto correspondiente (en mi caso es el 3307)
----

# EJECUTAR MIGRACIONES 

```bash
php artisan migrate 
```
Es una herramienta de Laravel para crear las tablas de la base de datos automáticamente según lo que hayas definido en tus archivos de migraciones.

## ¿Qué hace? 
1. **Busca las migraciones**   
Laravel guarda en la carpeta database/migrations archivos que definen cómo deben crearse las tablas (usuarios, sesiones, posts, etc.).
2. **Ejecuta esas instrucciones en la base de datos**  
Crea las tablas con sus columnas, tipos de datos, índices y relaciones
3. **Lleva un control de qué migraciones se han aplicado**  
Laravel guarda en la tabla migrations un registro de todas las migraciones ya ejecutadas para no repetirlas.

## ¿Para que sirve? 
1. Evita escribir SQL a mano cada vez que creas una tabla.
2. Permite versionar tu base de datos, ideal si trabajas en equipo.
3. Facilita migrar cambios a producción sin perder datos.
4. Con el mismo comando puedes deshacer migraciones si algo salió mal (php artisan migrate:rollback).
