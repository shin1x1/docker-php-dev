FROM php:8.4.13-cli-bookworm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
      libpq-dev \
      libicu-dev \
      libzip-dev \
      libpng-dev \
      libjpeg-dev \
      ssh \
      rsync \
      netcat-openbsd \
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
    && pecl install redis \
    && docker-php-ext-enable redis \
    && curl -L --output /usr/local/bin/pie https://github.com/php/pie/releases/latest/download/pie.phar \
    && chmod +x /usr/local/bin/pie \
    && pie install xdebug/xdebug:3.4.0beta1 \
    && docker-php-ext-enable xdebug
