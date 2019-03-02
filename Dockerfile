FROM composer:latest AS build

WORKDIR /app

COPY composer.json ./
COPY composer.lock ./

RUN composer install --no-scripts --no-autoloader --ignore-platform-reqs

COPY . ./

RUN composer dump-autoload --optimize

FROM php:7.3-fpm AS app

RUN apt-get update && apt-get install -y \
    cron \
    wget && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd && \
    docker-php-ext-install pdo_mysql

WORKDIR /usr/share/nginx/html

COPY --chown=www-data:www-data . ./
COPY --chown=www-data:www-data --from=build /app/vendor ./vendor

FROM nginx:latest AS web

COPY ./nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /usr/share/nginx/html/public

COPY ./public ./