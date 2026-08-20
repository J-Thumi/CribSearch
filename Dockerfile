# ============================================================
# CribSearch - Production Dockerfile
# ============================================================

# ------------------------------------------------------------
# Stage 1: Build frontend assets
# ------------------------------------------------------------
FROM node:20-alpine AS frontend

WORKDIR /app

# Copy dependency files first for better Docker caching
COPY package*.json ./

# Install only what's required to build
RUN npm ci

# Copy only frontend-related source files
COPY resources ./resources
COPY public ./public
COPY vite.config.* ./

# Build production assets
RUN npm run build


# ------------------------------------------------------------
# Stage 2: Install PHP dependencies
# ------------------------------------------------------------
FROM composer:2 AS composer

WORKDIR /app

# Copy Composer files first for caching
COPY composer.json composer.lock ./

# Install production dependencies only
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts


# ------------------------------------------------------------
# Stage 3: Production runtime
# ------------------------------------------------------------
FROM webdevops/php-nginx:8.4-alpine

SHELL ["/bin/bash", "-c"]

ENV PHP_MAX_EXECUTION_TIME=110

# Laravel application location
ARG LARAVEL_PATH=/production/cribsearch
ARG WEB_PATH=/production/cribsearch/public

ENV WEB_DOCUMENT_ROOT=$WEB_PATH

WORKDIR $LARAVEL_PATH


# ------------------------------------------------------------
# Install only runtime PHP extensions/dependencies
# ------------------------------------------------------------

RUN apk add --no-cache \
        libpng \
        libzip \
        oniguruma \
        libxml2 \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip


# ------------------------------------------------------------
# Copy application source
# ------------------------------------------------------------

COPY . $LARAVEL_PATH


# ------------------------------------------------------------
# Copy Composer dependencies from Composer stage
# ------------------------------------------------------------

COPY --from=composer /app/vendor ./vendor


# ------------------------------------------------------------
# Copy compiled frontend assets
# ------------------------------------------------------------

COPY --from=frontend /app/public/build ./public/build


# ------------------------------------------------------------
# Laravel directories
# ------------------------------------------------------------

RUN mkdir -p \
        bootstrap/cache \
        storage/logs \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
    && chown -R application:application \
        storage \
        bootstrap/cache \
    && chmod -R 775 \
        storage \
        bootstrap/cache


# ------------------------------------------------------------
# Laravel storage symlink
# ------------------------------------------------------------

RUN php artisan storage:link || true


# ------------------------------------------------------------
# Laravel production optimizations
# ------------------------------------------------------------

RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear


# ------------------------------------------------------------
# Supervisor configuration
# ------------------------------------------------------------

COPY docker-configs/supervisord.conf \
    /opt/docker/etc/supervisor.d/laravel.conf


# ------------------------------------------------------------
# Runtime directories
# ------------------------------------------------------------

RUN mkdir -p /var/log/supervisor /tmp \
    && touch /var/log/cron.log \
    && chmod 755 /var/log/supervisor \
    && chown application:application /tmp


# ------------------------------------------------------------
# Port
# ------------------------------------------------------------

EXPOSE 80


# ------------------------------------------------------------
# Start Laravel
# ------------------------------------------------------------

CMD ["bash", "-c", "php artisan migrate --force && supervisord"]
