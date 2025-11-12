FROM code4romania/php:8.4 AS vendor

# Switch to root so we can do root things
USER root

# Install additional PHP extensions
RUN set -ex; \
    install-php-extensions \
    sockets

# Drop back to our unprivileged user
USER www-data

COPY --chown=www-data:www-data . /var/www/html

RUN set -ex; \
    composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-plugins \
    --no-dev \
    --prefer-dist

FROM node:24-alpine AS assets

WORKDIR /build

COPY \
    package.json \
    package-lock.json \
    postcss.config.js \
    tailwind.config.js \
    vite.config.js \
    ./

RUN set -ex; \
    npm ci --no-audit --ignore-scripts

COPY --from=vendor /var/www/html /build

RUN set -ex; \
    npm run build

FROM vendor

ARG VERSION
ARG REVISION

RUN echo "$VERSION (${REVISION:0:7})" > /var/www/.version

# COPY --chmod=755 docker/ /
COPY --from=assets --chown=www-data:www-data /build/public/build /var/www/public/build

ENV WORKER_ENABLED=true

ENV PHP_PM_MAX_CHILDREN=64

EXPOSE 80
