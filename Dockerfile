FROM php:8.2-apache

WORKDIR /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy only necessary files for Composer
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

# Copy the rest of the application
COPY . .
COPY .devcontainer/000-default.conf /etc/apache2/sites-enabled

# Finish Composer setup
RUN composer dump-autoload --optimize

# Adjust ownership
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80