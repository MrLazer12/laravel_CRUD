FROM php:8.1-fpm

# Install Composer
RUN apt-get update && apt-get install -y composer

# Set the working directory
WORKDIR /var/www/html

# Copy the application files
COPY . /var/www/html

# Install dependencies with Composer
RUN composer install

# Expose port 80
EXPOSE 80

# Run migrations and seed the database
RUN composer install
RUN php artisan migrate --seed

# Start the PHP development server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
