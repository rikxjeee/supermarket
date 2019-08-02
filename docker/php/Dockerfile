FROM php:7.2-fpm

WORKDIR /var/www/supermarket

RUN apt-get update && \
    apt-get install -y --no-install-recommends zip unzip

RUN docker-php-ext-install pdo pdo_mysql
RUN curl --silent --show-error https://getcomposer.org/installer | php
RUN mv composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer
