FROM php:8.1-fpm-alpine

# Instalar dependencias del sistema
RUN apk --no-cache add git curl bash nodejs npm

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install && npm install && npm run build

CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000