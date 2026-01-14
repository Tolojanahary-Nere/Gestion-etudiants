#!/bin/bash

echo "Running migrations..."
php artisan migrate --force

echo "Seeding database..."
php artisan db:seed --force || echo "Seeding failed or already done, continuing..."

echo "Starting Apache..."
exec apache2-foreground
