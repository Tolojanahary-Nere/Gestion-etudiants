#!/bin/bash
set -e

echo "==================================="
echo "Fixing storage permissions..."
echo "==================================="
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

echo ""
echo "==================================="
echo "Clearing and caching configuration..."
echo "==================================="
php artisan config:clear
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
# Retry DB connection up to 5 times (Render cold-starts can be slow)
MAX_RETRIES=5
COUNT=0
until php artisan migrate --force --seed; do
  COUNT=$((COUNT + 1))
  if [ "$COUNT" -ge "$MAX_RETRIES" ]; then
    echo "Migration failed after $MAX_RETRIES attempts. Continuing anyway..."
    break
  fi
  echo "Database not ready yet. Retrying in 5 seconds... ($COUNT/$MAX_RETRIES)"
  sleep 5
done

echo ""
echo "==================================="
echo "Starting Apache..."
echo "==================================="
exec apache2-foreground
