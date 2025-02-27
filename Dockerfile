
FROM php:8.2.6-fpm-alpine

ARG PHP_EXTS="bcmath ctype fileinfo mbstring pdo pdo_mysql dom pcntl gd"
ARG PHP_PECL_EXTS="redis"
ARG PHP_EXT_DEPS="freetype-dev libjpeg-turbo-dev libwebp-dev libpng-dev"
ARG PHP_EXT_CONF="gd --enable-gd --with-freetype --with-jpeg --with-webp"

WORKDIR /var/www/images_server

RUN apk add --virtual build-dependencies --no-cache ${PHPIZE_DEPS} ${PHP_EXT_DEPS} openssl ca-certificates libxml2-dev oniguruma-dev \
    && docker-php-ext-configure ${PHP_EXT_CONF} \
    && docker-php-ext-install -j$(nproc) ${PHP_EXTS} \
    && pecl install ${PHP_PECL_EXTS} \
    && docker-php-ext-enable ${PHP_PECL_EXTS}
    # && apk del build-dependencies
