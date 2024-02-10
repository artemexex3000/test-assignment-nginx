FROM node:21.2.0-alpine AS build_1
WORKDIR /app

COPY ./package.json .
COPY ./package-lock.json .
COPY ./vite.config.js .
COPY ./tailwind.config.js .
COPY ./postcss.config.js .
COPY ./public/build/assets ./public/build/assets
COPY ./resources/ ./resources/

RUN npm install && npm run build

FROM nginx:stable-alpine

ENV NGINXUSER=laravel
ENV NGINXGROUP=laravel

RUN mkdir -p /var/www/html

ADD nginx/default.conf /etc/nginx/conf.d/default.conf

COPY --from=build_1 /app /var/www/html/

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}

RUN chmod -R 755 /var/www/html/public
RUN chown -R ${NGINXUSER}:${NGINXGROUP} /var/www/html/public
