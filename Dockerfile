FROM php:8.1-fpm

# Instalează Composer la o anumită versiune
RUN apt-get update \
  && apt-get install -y \
  git \
  curl \
  libpng-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip \
  zlib1g-dev \
  libpq-dev \
  libzip-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install pdo pdo_pgsql pgsql zip bcmath gd
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.0

# Setează directorul de lucru
WORKDIR /var/www/html

# Copiază fișierele aplicației
COPY . /var/www/html

# Instalarea pachetelor necesare pentru proiect
RUN composer update
RUN composer install

# Expose portul 8000
EXPOSE 8000

# Porneste serverul
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & php artisan migrate --seed"]
