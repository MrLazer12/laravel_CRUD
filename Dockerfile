FROM php:8.2.11-fpm

RUN apt-get update

# Install useful tools
RUN apt-get -y install apt-utils nano wget dialog vim

# Install important libraries
RUN apt-get -y install --fix-missing \
    apt-utils build-essential git curl libcurl4 libcurl4-openssl-dev zlib1g-dev libzip-dev zip \
    libbz2-dev locales libmcrypt-dev libicu-dev libonig-dev libxml2-dev

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.0

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Set the working directory
WORKDIR /var/www

# Copy the application files
COPY . /var/www

RUN composer update \
    && composer install

RUN chmod -R 777 /var/www
