# Stage 1: Build frontend assets
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# Stage 2: PHP App
FROM php:8.4-fpm-alpine AS php-app
WORKDIR /var/www/html

# Install system dependencies
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the Laravel application files
COPY . .

# Copy the built frontend assets from Stage 1
COPY --from=frontend /app/public/build ./public/build

# Install Composer dependencies (excluding dev packages)
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Switch to non-root user for security
USER www-data

EXPOSE 9000
CMD ["php-fpm"]

# Stage 3: Nginx Web Server
FROM nginx:alpine AS nginx
# Copy the entire public folder (including the built CSS/JS) from Stage 1
COPY --from=frontend /app/public /var/www/html/public
# Copy the nginx config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf