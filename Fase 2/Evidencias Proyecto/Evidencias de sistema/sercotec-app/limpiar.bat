@echo off
cd /d %~dp0

echo Limpiando la caché de Laravel...

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

REM Opcional: Regenerar caché
php artisan config:cache
php artisan route:cache

echo Caché de Laravel limpiado con éxito.
pause
