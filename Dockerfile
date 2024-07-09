FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install zip unzip
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
COPY .devcontainer/000-default.conf /etc/apache2/sites-enabled

RUN composer install

EXPOSE 80