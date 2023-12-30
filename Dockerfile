# Stage 1: PHP and Composer
FROM php:8.1-fpm as php_stage

# Install necessary dependencies and Composer
RUN apt-get update \
    && apt-get install -y git curl libpng-dev libonig-dev libxml2-dev zip unzip zlib1g-dev libpq-dev libzip-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.0

# Set the working directory
WORKDIR /var/www/html

# Copy the application files
COPY . /var/www/html

# Install Composer dependencies
RUN composer update \
    && composer install

# Stage 2: PostgreSQL (using official PostgreSQL image)
FROM postgres:latest as postgres_stage

# Set permissions on the PostgreSQL data directory
RUN chmod -R 700 /var/lib/postgresql/data

# Final Stage
FROM php_stage

# Set the working directory
WORKDIR /var/www/html

# Expose port 8000
EXPOSE 8000

# Start the PHP server
CMD ["php", "artisan", "serve"]
