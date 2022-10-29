FROM php:8.1-fpm

# Copy composer.lock and composer.json into the working directory
COPY composer.lock composer.json /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Install dependencies for the operating system software
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    zip \
    vim \
    git \
    curl

# Install extensions for php
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install gd

# Install composer (php package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents to the working directory
COPY . /var/www/html

RUN rm -rf vendor composer.lock
RUN composer install

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

RUN php artisan cache:clear
RUN php artisan key:generate
RUN php artisan config:cache

# Comando para ejecutar migraciones. Lo dejo comentado porque yo no tengo la DB.
RUN php artisan migrate
RUN php artisan passport:install
RUN php artisan token:update

EXPOSE 5000
CMD php artisan serve --host=0.0.0.0 --port=5000