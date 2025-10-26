# Use official PHP 8.2 image with Debian Bullseye
FROM php:8.2-apache-bullseye

# Enable Apache mod_rewrite (needed for Laravel routing)
RUN a2enmod rewrite

# Install required system dependencies
RUN apt-get update && apt-get install -y \
    git curl libzip-dev unzip zip libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql bcmath zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy all files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Fix permissions for Laravel storage & cache
RUN chmod -R 775 storage bootstrap/cache

# Set Apache document root to Laravel public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Expose default HTTP port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
