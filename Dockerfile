FROM php:8.2-fpm-alpine AS vendor

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV COMPOSER_CACHE_DIR /dev/null

WORKDIR /var/www

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk update && \
    #
    # production dependencies
    apk add --no-cache \
    nginx && \
    #
    # install extensions
    install-php-extensions \
    excimer \
    exif \
    gd \
    intl \
    mbstring \
    opcache \
    pdo_mysql \
    sockets \
    zip

COPY --chown=www-data:www-data . /var/www
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-plugins \
    --no-dev \
    --prefer-dist

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

ARG S6_OVERLAY_VERSION=3.2.0.0

ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-noarch.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-noarch.tar.xz
ADD https://github.com/just-containers/s6-overlay/releases/download/v${S6_OVERLAY_VERSION}/s6-overlay-x86_64.tar.xz /tmp
RUN tar -C / -Jxpf /tmp/s6-overlay-x86_64.tar.xz

ENTRYPOINT ["/init"]

COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY docker/s6-rc.d /etc/s6-overlay/s6-rc.d

COPY --from=assets --chown=www-data:www-data /build/public/build /var/www/public/build

ARG VERSION
ARG REVISION

RUN echo "$VERSION (${REVISION:0:7})" > /var/www/.version

ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV CACHE_DRIVER=database
ENV QUEUE_CONNECTION=database
ENV SESSION_DRIVER=database

# The number of jobs to process before stopping
ENV WORKER_MAX_JOBS=50

# Number of seconds to sleep when no job is available
ENV WORKER_SLEEP=30

# Number of seconds to rest between jobs
ENV WORKER_REST=1

# The number of seconds a child process can run
ENV WORKER_TIMEOUT=600

# Number of times to attempt a job before logging it failed
ENV WORKER_TRIES=3

ENV SENTRY_SAMPLE_RATE=0

ENV PHP_PM_MAX_CHILDREN=64

EXPOSE 80
