Requisitos: 
Composer
php 7.2
laravel
node

Pasos para ejecutar la aplicación:
Habilitar los drivers php asociados a postgres (editar el archivo php.ini y descomentar las lineas: extension=pdo_pgsql y extension=pgsql).
Renombrar el archivo env a .env.
Renombrar los archivos browserslistrc y eslintrc.js a .browserslistrc y .eslintrc.js (ocultarlos)
Dentro de la carpeta Application ejecutar npm install.
Dentro de la carpeta GCS ejecutar el comando composer install.
Dentro de la carpeta GCS ejecutar el comando php artisan serve (para levantar la api).
Dentro de la carpeta Application ejecutar el comando npm run serve (ejecutar la aplicación en su versión web) ó npm run electron:build para crear un archivo de escritorio (.exe en windows)
