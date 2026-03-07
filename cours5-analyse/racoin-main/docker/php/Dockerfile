FROM php:8.1

RUN apt update 
RUN apt install git zip unzip libxml2-dev -y

RUN docker-php-ext-install pdo_mysql 

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Masquer les deprecated warnings pour compatibilité avec Slim 2 et Illuminate 4.2
RUN echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT" > /usr/local/etc/php/conf.d/error-reporting.ini

WORKDIR /var/www/html