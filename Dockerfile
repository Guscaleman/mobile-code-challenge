FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libsqlite3-dev \
    libpq-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pdo_sqlite \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --no-scripts

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=${PORT}

