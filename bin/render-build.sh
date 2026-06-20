#!/usr/bin/env bash
# Exit on error
set -o errexit

echo "--- Installing Node Dependencies ---"
npm install

echo "--- Building Frontend Assets ---"
npm run build

echo "--- Installing PHP Dependencies ---"
composer install --no-dev --optimize-autoloader --no-interaction

echo "--- Fixing Storage Permissions ---"
chmod -R 775 storage bootstrap/cache
mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views

echo "--- Caching Config/Routes ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Creating Storage Symlink ---"
php artisan storage:link --force

echo "--- Running Migrations ---"
php artisan migrate --force --seed
