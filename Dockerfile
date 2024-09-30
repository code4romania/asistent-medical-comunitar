FROM code4romania/php:8.2 AS vendor

WORKDIR /var/www

RUN set -ex; \
    install-php-extensions \
    sockets

COPY --chown=www-data:www-data . /var/www

RUN set -ex; \
    composer install \
    --no-plugins \
    --no-dev

FROM node:20-alpine AS assets

WORKDIR /build

COPY \
    package.json \
    package-lock.json \
    postcss.config.js \
    tailwind.config.js \
    vite.config.js \
    ./

RUN npm ci --no-audit --ignore-scripts

COPY --from=vendor /var/www /build

RUN npm run build

FROM vendor

COPY docker/s6-rc.d /etc/s6-overlay/s6-rc.d
COPY --from=assets --chown=www-data:www-data /build/public/build /var/www/public/build


ENV WORKER_ENABLED=true

ENV PHP_PM_MAX_CHILDREN=64

EXPOSE 80
