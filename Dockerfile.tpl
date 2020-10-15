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
{{- if or (or (matchVersion "^7.4" .Tag) (matchVersion "^8" .Tag)) (eq "7" .Version)  }}
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
{{- if matchVersion "^8" .Tag }}
    # Xdebug
    && mkdir -p /usr/src/php/ext/xdebug \
    && curl -fsSL https://xdebug.org/files/xdebug-3.0.0beta1.tgz | tar xvz -C "/usr/src/php/ext/xdebug" --strip 1 \
    && cd /usr/src/php/ext/xdebug \
    && phpize \
    && ./configure --enable-xdebug \
    && make install \
    && echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
{{- else }}
    && pecl install xdebug redis \
    && docker-php-ext-enable xdebug redis
{{- end }}
