# Use the official PHP 8.4 FPM image as the base
FROM php:8.4-fpm

# Install system dependencies and PHP extensions (as above)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    && docker-php-ext-install \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application code
COPY . /var/www/html
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose ports
EXPOSE 80 9000

# Start Nginx and PHP-FPM
CMD ["./scripts/render-deploy.sh"]
