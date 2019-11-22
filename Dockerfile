FROM php:fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql