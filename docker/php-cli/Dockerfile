FROM php:8.0-cli

RUN apt-get -y update && \
    apt-get install -y --no-install-recommends curl git unzip libzip-dev

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o
