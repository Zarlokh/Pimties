FROM php:8.1-fpm

ENV APCU_VERSION 5.1.19
ENV COMPOSER_VERSION 2.4.3

RUN apt update &&  \
    apt install -y ca-certificates  \
    git \
    libxml2-dev \
    unzip \
    zip \
    libzip-dev \
    libonig-dev  \
    procps \
    vim \
    s6 && \
    pecl install apcu-${APCU_VERSION} && \
    #TODO : Enable & configure xdebug
#    pecl install xdebug && \
    docker-php-ext-install intl zip mysqli pdo_mysql mbstring && \
    #TODO : Enable & configure xdebug
#    docker-php-ext-enable  xdebug && \
    docker-php-ext-enable opcache apcu
RUN apt auto-clean
RUN addgroup bar
RUN adduser --home /home foo --shell /bin/bash --disabled-password --ingroup bar --gecos ""

# S6 supervision overlay for docker ; Cf. https://skarnet.org/software/s6, https://github.com/just-containers/s6-overlay
RUN curl -L https://github.com/just-containers/s6-overlay/releases/download/v1.22.1.0/s6-overlay-amd64.tar.gz | tar xz -C /

# Composer
RUN curl -sS https://getcomposer.org/installer \
        | php -- --filename=composer --install-dir=/usr/local/bin --version=${COMPOSER_VERSION}

COPY config/php.ini /usr/local/etc/php/php.ini
COPY config/xdebug.ini /usr/local/etc/php/conf.d/debug.ini

COPY rootfs /

WORKDIR /srv

ENTRYPOINT ["/init"]