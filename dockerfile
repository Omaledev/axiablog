FROM php:8.2-apache

WORKDIR /var/www/html

# Install only essential dependencies (minimal set)
RUN apt-get update && apt-get install -y \
    git curl zip unzip

# Install only the most basic PHP extensions that always work
RUN docker-php-ext-install pdo mysqli

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Configure Apache to serve from public directory
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Simple start command
CMD apache2-foreground
