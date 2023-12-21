Pré requisitos 

Docker <br>
Docker-compose <br>
composer <br>
php <br>

----------------------------------------------
Docker <br>

sudo docker-compose up -d --build  <br>

----------------------------------------------
Laravel <br>

composer install  <br>
php artisan key:generate <br> 

Configurar o .ENV para usar o Banco

DB_CONNECTION=mysql <br> 
DB_HOST={HOST} <br> 
DB_PORT=3306 <br> 
DB_DATABASE={DB} <br> 
DB_USERNAME={USER} <br> 
DB_PASSWORD={PASSWORD} <br> 

php artisan migrate <br>

----------------------------------------------