FROM nginx:latest AS nginx
COPY ./etc/nginx/nginx.conf /etc/nginx/templates/default.conf.template
WORKDIR /opt/app
COPY ./app/public /opt/app/public

FROM php:fpm-buster as php_builder
ENV APP_ENV=prod
# Extension & Configuration
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        zip \
        libicu-dev
RUN docker-php-ext-configure intl \
    && docker-php-ext-install zip \
    opcache \
    intl \
    zip \
    pdo_mysql
COPY ./etc/php-fpm/php.ini /usr/local/etc/php/conf.d/99-overrides.ini.template
COPY ./etc/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf.template
# Composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN set -eux; \
  composer global require "symfony/flex" --prefer-dist --no-progress --classmap-authoritative; \
 composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"
RUN mkdir /opt/app/
RUN mkdir /var/www/.composer
COPY ./app /opt/app
WORKDIR /opt/app/
CMD ["php-fpm"]

FROM php_builder as php
RUN chown -R www-data:www-data /opt/app/
RUN chown -R www-data:www-data /var/www/.composer
USER www-data
CMD ["php-fpm"]