git clone https://github.com/yesa0798/Secure-Programming-Kelompok-9.git

cd Secure-Programming-Kelompok-9

docker-compose up -d --build

docker exec -it laravel_app php artisan migrate --seed

docker exec -it laravel_app php artisan storage:link

Setelah semua langkah dijalankan, aplikasi dapat diakses melalui browser di: http://localhost:8080
