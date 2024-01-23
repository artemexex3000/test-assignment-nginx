FROM php:8-fpm-alpine

ENV PHPUSER=laravel
ENV PHPGROUP=laravel

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html

RUN apk add --no-cache postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

RUN chmod -R 755 /var/www/html/
RUN chown -R ${PHPUSER}:${PHPGROUP} /var/www/html/

COPY ./src /var/www/html

#USER ${PHPUSER}

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
