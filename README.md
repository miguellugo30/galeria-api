git clone https://github.com/miguellugo30/galeria-api.git

cd galera-api

composer install

cp .env.example .env

php artisan key:generate

Cambiar los valores de la base de datos

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=galeria_app
DB_USERNAME=root
DB_PASSWORD=

php artisan config:cache

php artisan migrate

php artisan db:seed

php artisan serve
