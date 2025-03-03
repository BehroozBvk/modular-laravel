@echo off
REM Run migrations and seeders
php artisan migrate:fresh --seed


REM Get the new client IDs and secrets
php artisan passport:client --password --name="Baraeim Backend Password Grant Client" --provider=users
php artisan passport:client --personal --name="Baraeim Backend Personal Access Client"

REM Note: You will need to manually update your .env file with the new client IDs and secrets
echo "Don't forget to update your .env file with the new client IDs and secrets!" 