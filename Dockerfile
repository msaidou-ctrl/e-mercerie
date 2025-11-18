# Stage 1: Build Image
FROM php:8.3-fpm AS build

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .
RUN composer install --no-dev --optimize-autoloader
RUN chown -R www-data:www-data storage bootstrap/cache

# Stage 2: Production Image
FROM php:8.3-fpm AS production

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

WORKDIR /var/www
COPY --from=build /var/www /var/www
RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data

CMD ["sh", "-c","php artisan config:cache && php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]

EXPOSE $PORT
