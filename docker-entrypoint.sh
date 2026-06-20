#!/bin/bash
set -e

echo "==================================="
echo "Fixing storage permissions..."
echo "==================================="
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo ""
echo "==================================="
echo "Caching configuration..."
echo "==================================="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "==================================="
echo "Creating storage symlink..."
echo "==================================="
php artisan storage:link --force || true

echo ""
echo "==================================="
echo "Running migrations..."
echo "==================================="
php artisan migrate --force --seed

echo ""
echo "==================================="
echo "Starting Apache..."
echo "==================================="
exec apache2-foreground
