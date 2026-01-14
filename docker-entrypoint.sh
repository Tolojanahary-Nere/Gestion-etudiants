#!/bin/bash

echo "==================================="
echo "Checking migration files..."
echo "==================================="
ls -la /var/www/html/database/migrations/

echo ""
echo "==================================="
echo "Running migrations with verbose output..."
echo "==================================="
php artisan migrate --force -vvv

echo ""
echo "==================================="
echo "Seeding database..."
echo "==================================="
php artisan db:seed --force || echo "Seeding failed or already done, continuing..."

echo ""
echo "==================================="
echo "Starting Apache..."
echo "==================================="
exec apache2-foreground
