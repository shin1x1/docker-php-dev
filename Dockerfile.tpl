FROM php:{{.Tag}}

# Install PHP extensions
RUN apt-get update && apt-get install -y \
      libpq-dev \
      libicu-dev \
      libzip-dev \
      libpng-dev \
      libjpeg-dev \
    && rm -r /var/lib/apt/lists/* \
    && docker-php-ext-configure \
{{- if or (matchVersion "^7.4" .Tag) (eq "7" .Version)  }}
      gd --with-jpeg \
{{- else }}
      gd --with-jpeg-dir=/usr/include \
{{- end }}
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
