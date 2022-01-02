FROM ghcr.io/blumilksoftware/php:8.1

ARG INSTALL_XDEBUG=false

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    apk --no-cache add $PHPIZE_DEPS \
    && pecl install xdebug-3.1.2 \
    && docker-php-ext-enable xdebug \
;fi

RUN apk --no-cache add \
    zip \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install \
    zip \
    gd \
    && docker-php-ext-configure \
    zip
