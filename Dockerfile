FROM php:8.2-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pdo_sqlite zip

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Diretório da aplicação
WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 storage bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --no-scripts

EXPOSE 9000
CMD ["php-fpm"]
