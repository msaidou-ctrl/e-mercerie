# Stage 1: Build Image
FROM php:8.3-fpm AS build

# Install system dependencies
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

# Install Composer
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install project dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Stage 2: Production Image (using the www-data user for better security)
FROM php:8.3-fpm AS production

# Copy artifacts from the build stage
COPY --from=build /var/www /var/www

# Set working directory
WORKDIR /var/www

# Ensure correct permissions for the www-data user
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Switch to the non-root user for security
USER www-data

# The CMD should be defined in a separate entrypoint script for better control,
# but for a simple fix using php artisan serve with the PORT env variable:
CMD ["sh", "-c", "php artisan config:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT"]

# Use Railway's environment variable for the port
EXPOSE $PORT
