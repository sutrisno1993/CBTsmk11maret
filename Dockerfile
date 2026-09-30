FROM php:8.2-apache

# Install dependencies and required PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd mysqli pdo_mysql zip opcache \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for CodeIgniter URL routing
RUN a2enmod rewrite

# Configure PHP settings for file uploads and execution timeout
RUN echo "upload_max_filesize = 100M\npost_max_size = 100M\nmax_execution_time = 300\nmemory_limit = 256M" > /usr/local/etc/php/conf.d/custom.ini

# Set working directory
WORKDIR /var/www/html

# Copy all files
COPY . /var/www/html/

# Set appropriate permissions for web server
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/uploads \
    && chmod -R 777 /var/www/html/application/cache \
    && chmod -R 777 /var/www/html/application/logs

EXPOSE 80

CMD ["apache2-foreground"]
