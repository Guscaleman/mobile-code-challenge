FROM php:8.2-cli

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY . .

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php \
 && php composer.phar install --no-dev --optimize-autoloader \
 && rm composer-setup.php

RUN php artisan key:generate || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=${PORT}
