Requisitos (verificar otras versiones a las señaladas): 
Composer 1.9.1,
php 7.2,
laravel 6.0.1,
node 10.15.3,
npm 6.4.1,
postgres 10.11,
pgAdmin 4

Pasos para ejecutar la aplicación:
Habilitar los drivers php asociados a postgres (editar el archivo php.ini y descomentar las lineas: extension=pdo_pgsql y extension=pgsql).
Crear la base de datos postgres:
Utilizando la herramienta pgsql ejecutar los comandos:
CREATE USER admin WITH PASSWORD ‘admin2546!!’;
CREATE DATABASE admin;
GRANT ALL PRIVILEGES ON DATABASE  admin TO admin;
Renombrar los archivos browserslistrc y eslintrc.js a ".browserslistrc." y ".eslintrc.js." (ocultarlos) ubicados dentro de la carpeta Application
Dentro de la carpeta Application ejecutar npm install.
Renombrar el archivo env a ".env." ubicado en la carpeta GCS.
Crear las carpetas: "sessions" y "views" dentro de la carpeta GCS/storage/framework (verificar que una vez creadas NO esten en modo de solo lectura).
Dentro de la carpeta GCS ejecutar el comando composer install.
Dentro de la carpeta GCS ejecutar el comando php artisan serve (para levantar la api).
Dentro de la carpeta Application ejecutar el comando npm run serve (ejecutar la aplicación en su versión web) ó npm run electron:build para crear un archivo de escritorio (.exe en windows)
