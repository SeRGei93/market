FROM php:8.3-fpm-alpine

ARG UID
ARG GID
ARG XDEBUG_REMOTE_HOST

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# MacOS staff group's gid is 20, so is the dialout group in alpine linux. We're not using it, let's just remove it.
RUN delgroup dialout

RUN addgroup -g ${GID} --system laravel
RUN adduser -G laravel --system -D -s /bin/sh -u ${UID} laravel

RUN apk add --no-cache --update \
  bzip2-dev \
  enchant2-dev \
  gmp-dev \
  imap-dev \
  icu-dev \
  openldap-dev \
  freetds-dev \
  libxml2-dev \
  tidyhtml-dev  \
  libxslt-dev \
  libzip-dev \
  musl-dev \
  jpeg-dev \
  libpng-dev \
  oniguruma-dev \
  freetype  \
  libpng  \
  libjpeg-turbo  \
  freetype-dev  \
  libjpeg-turbo-dev \
  bash \
  openrc
  #supervisor

RUN docker-php-ext-configure intl --enable-intl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install -j$(nproc) gd \
    pdo \
    mysqli  \
    pdo_mysql  \
    intl  \
    mbstring  \
    zip  \
    pcntl \
    exif  \
    opcache \
    soap \
    && docker-php-source delete


##Installing xdebug
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS
RUN apk add --update linux-headers
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN apk del -f .build-deps

#Installing redis
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
        && pecl install redis \
        && docker-php-ext-enable redis.so

#copy settings
COPY ./conf.d /usr/local/etc/php/conf.d
RUN printf "\nxdebug.client_host=$XDEBUG_REMOTE_HOST" >> /usr/local/etc/php/conf.d/xdebug.ini


RUN sed -i "s/user = www-data/user = laravel/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = laravel/g" /usr/local/etc/php-fpm.d/www.conf

USER laravel

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
