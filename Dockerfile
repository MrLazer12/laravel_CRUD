FROM php:8.1-fpm

# Instalează Composer la o anumită versiune
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.1.5

# Setează directorul de lucru
WORKDIR /var/www/html

# Copiază fișierele aplicației
COPY . /var/www/html

# Instalarea pachetelor necesare pentru proiect
RUN composer update
RUN composer install

# Rulează migrările și populează baza de date
RUN php artisan migrate --seed

# Expose portul 8000
EXPOSE 8000

# Porneste serverul
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
