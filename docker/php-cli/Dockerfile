FROM php:8.0-cli

RUN apt-get -y update

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
