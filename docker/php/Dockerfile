FROM php:8.1-fpm-alpine

ENV APCU_VERSION 5.1.19
ENV COMPOSER_VERSION 2.4.3

RUN apk add --update --no-cache \
        bash \
        ca-certificates \
        git \
        icu-libs \
        libxml2-dev \
        unzip \
        zip \
        oniguruma-dev \
        libzip-dev && \
    apk add --update --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev && \
    pecl install apcu-${APCU_VERSION} xdebug && \
    docker-php-ext-install intl zip mysqli pdo_mysql mbstring && \
    docker-php-ext-enable opcache apcu xdebug && \
    apk del .build-deps && \
    apk add su-exec && \
    addgroup bar && \
    adduser -D -h /home -s /bin/bash -G bar foo

# Composer
RUN curl -sS https://getcomposer.org/installer \
        | php -- --filename=composer --install-dir=/usr/local/bin --version=${COMPOSER_VERSION}

ADD entrypoint.sh /entrypoint
COPY config/php.ini /usr/local/etc/php/php.ini
COPY config/xdebug.ini /usr/local/etc/php/conf.d/debug.ini

WORKDIR /srv

ENTRYPOINT ["/entrypoint"]
