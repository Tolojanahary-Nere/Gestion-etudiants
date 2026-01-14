#!/usr/bin/env bash
# Exit on error
set -o errexit

echo "--- Installing Node Dependencies ---"
npm install

echo "--- Building Frontend Assets ---"
npm run build

echo "--- Installing PHP Dependencies ---"
composer install --no-dev --optimize-autoloader --no-interaction

echo "--- Caching Config/Routes ---"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "--- Running Migrations ---"
php artisan migrate --force
