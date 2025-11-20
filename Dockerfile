# Stage 1: Composer dependencies
FROM composer:2.5 AS vendor
WORKDIR /app

# Copy full Laravel project (agar artisan tersedia saat composer install)
COPY . /app

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader


# Stage 2: Node build
FROM node:18 AS node_build
WORKDIR /assets

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build


# Stage 3: Final PHP Image
FROM php:8.0-cli

RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev libzip-dev zip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u 1000 -m developer

WORKDIR /var/www

# Copy project
COPY . /var/www

# Copy vendor from build stage
COPY --from=vendor /app/vendor /var/www/vendor

# Copy built assets
COPY --from=node_build /assets/public/build /var/www/public/build

RUN chown -R developer:www-data /var/www \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

USER developer

# Laravel setup
RUN php artisan key:generate --ansi || true
RUN php artisan storage:link || true
RUN php artisan migrate --force || true
RUN php artisan db:seed --force || true

EXPOSE 8080

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
