FROM php:8.0.28-fpm-bullseye

# Install PHP extensions
RUN apt-get update && apt-get install -y \
      libpq-dev \
      libicu-dev \
      libzip-dev \
      libpng-dev \
      libjpeg-dev \
      ssh \
      rsync \
      netcat \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure \
      gd --with-jpeg \
    && docker-php-ext-install \
      pdo_pgsql \
      pdo_mysql \
      pgsql \
      opcache \
      exif \
      gd \
      zip \
    && pecl install xdebug redis \
    && docker-php-ext-enable xdebug redis
