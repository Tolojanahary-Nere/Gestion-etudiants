#!/bin/bash

echo "==================================="
echo "Checking migration files..."
echo "==================================="
ls -la /var/www/html/database/migrations/

echo ""
echo "==================================="
echo "Running migrations with fresh start..."
echo "==================================="
php artisan migrate:fresh --force --seed -vvv

echo ""
echo "==================================="
echo "Starting Apache..."
echo "==================================="
exec apache2-foreground
