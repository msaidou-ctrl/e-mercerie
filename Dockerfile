# Stage 1: Build Image
FROM php:8.3-fpm AS build

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

# ✅ Installation des dépendances
RUN composer install --no-dev --optimize-autoloader

# ✅ Permissions correctes
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Stage 2: Production Image
FROM php:8.3-fpm AS production

RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www
COPY --from=build /var/www /var/www

# 🔥 Grands permissions pour storage et public
RUN chown -R www-data:www-data storage bootstrap/cache public && \
    chmod -R 775 storage bootstrap/cache public

# ✅ Créer le lien symbolique UNIQUEMENT s'il n'existe pas déjà
CMD ["sh", "-c", "\
    php artisan config:cache && \
    php artisan config:clear && \
    php artisan migrate --force && \
    if [ ! -L public/storage ]; then php artisan storage:link; fi && \
    php artisan serve --host=0.0.0.0 --port=\$PORT\
"]

EXPOSE $PORT