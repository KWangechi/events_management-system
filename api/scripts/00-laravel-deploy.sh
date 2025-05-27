#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Delete all the cache files..."
rm -rf /var/www/html/bootstrap/cache/*

echo "Clearing cache..."
php artisan optimize:clear

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "View all routes"
php artisan route:list
