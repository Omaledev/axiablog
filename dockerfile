FROM php:8.2-apache

WORKDIR /var/www/html

# Install dependencies with all required libraries for GD
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip sqlite3 \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev

# Install PHP extensions (install gd separately with configuration)
RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring

# Install GD extension with freetype and jpeg support
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Create a basic .env file if none exists (with safe defaults)
RUN if [ ! -f .env ]; then \
        echo "APP_ENV=production" > .env; \
        echo "APP_DEBUG=false" >> .env; \
        echo "APP_KEY=base64:b7xL3OZcPwNHwNBvGlU0UO/ctmy5n6MbPPPKL13ZZXM=" >> .env; \
        echo "DB_CONNECTION=sqlite" >> .env; \
        echo "CACHE_STORE=file" >> .env; \
        echo "SESSION_DRIVER=file" >> .env; \
        echo "QUEUE_CONNECTION=sync" >> .env; \
        echo "LOG_CHANNEL=stderr" >> .env; \
    fi

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Create SQLite database file
RUN touch database/database.sqlite
RUN chmod 666 database/database.sqlite

# Configure Apache
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Start command with error handling
CMD php artisan config:clear && \
    php artisan cache:clear && \
    php artisan config:cache && \
    apache2-foreground
