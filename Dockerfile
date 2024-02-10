FROM composer:2.6.6 AS build_1
WORKDIR /app

COPY ./composer.json .
COPY ./composer.lock .
RUN composer install --no-dev --no-scripts --ignore-platform-reqs

COPY ./ .
RUN composer dumpautoload --optimize

FROM php:8-fpm-alpine

ENV PHPUSER=laravel
ENV PHPGROUP=laravel

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/listen = 127\.0\.0\.1:9000/listen = 0.0.0.0:9000/g" /usr/local/etc/php-fpm.d/www.conf

RUN apk add --no-cache postgresql-dev
RUN docker-php-ext-install pdo pdo_pgsql

COPY --from=build_1 /app /var/www/html

RUN chmod -R 755 /var/www/html/
RUN chown -R ${PHPUSER}:${PHPGROUP} /var/www/html/

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
