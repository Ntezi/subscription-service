#!/bin/bash
set -e

echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h"$DB_HOST" --silent; do
    sleep 1
done

echo "MySQL is ready!"

echo "Running Laravel migrations..."
php artisan migrate

echo "Running Laravel seeders for websites..."
php artisan db:seed

exec apache2-foreground
