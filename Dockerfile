FROM php:8.2-cli

# Install dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip mbstring gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chmod -R 755 storage bootstrap/cache

# Cache
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

EXPOSE 8080

CMD php -S 0.0.0.0:8080 -t public
