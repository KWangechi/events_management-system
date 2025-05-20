#!/usr/bin/env bash

echo "Caching config (if not already cached)..."
php artisan config:cache

# Caching routes (if not already cached)
echo "Caching routes (if not already cached)..."
php artisan route:cache


echo "Starting Nginx..."
nginx -g "daemon off;" &

echo "Starting PHP-FPM..."
php-fpm
