FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y sudo libzip-dev zlib1g-dev vim nano graphviz libfreetype6-dev libjpeg62-turbo-dev libpng-dev libmcrypt-dev zip && \
    a2enmod rewrite

RUN docker-php-ext-install bcmath

RUN curl -sS https://getcomposer.org/installer \
    |  php -- \
        --filename=composer \
        --install-dir=/usr/local/bin

RUN \
    pecl install xdebug \
    && docker-php-ext-enable \
        xdebug \
    && rm -rf /tmp/*

COPY ./dev.ini /usr/local/etc/php/conf.d/dev.ini