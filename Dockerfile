# Use the official PHP image as a base image
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip exif pcntl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer.json and composer.lock
COPY composer*.json ./

# Set proper permissions
RUN chown www-data:www-data /var/www/html

# Install dependencies
USER www-data
RUN composer install --no-scripts --no-autoloader

# Copy the existing application directory contents to the working directory
COPY --chown=www-data:www-data . .

# Generate optimized autoload files
RUN composer dump-autoload --optimize

# Switch back to root to create directories and set permissions
USER root

# Create Laravel storage and cache directories
RUN mkdir -p /var/www/html/storage/framework/sessions \
             /var/www/html/storage/framework/views \
             /var/www/html/storage/framework/cache \
             /var/www/html/storage/logs \
             /var/www/html/bootstrap/cache

# Set proper ownership and permissions
RUN chown -R www-data:www-data /var/www/html/storage \
                               /var/www/html/bootstrap/cache

RUN chmod -R 775 /var/www/html/storage \
             /var/www/html/bootstrap/cache

# Switch back to www-data user
USER www-data

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
