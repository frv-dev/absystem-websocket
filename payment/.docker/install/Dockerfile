FROM php:8.3.12-cli-alpine
ARG USER=felps
ARG UID=1000
ARG GID=1000

RUN addgroup ${USER}

RUN adduser -D -G ${USER} -u ${UID} ${USER}

RUN apk update && apk add \
      ghostscript \
      iputils \
      libzip-dev \
      gd-dev \
      geoip-dev \
      git \
      gnupg \
      imagemagick \
      jpegoptim \
      libffi-dev \
      libgit2 \
      libxslt-dev \
      make \
      openssh \
      openssl-dev \
      optipng \
      pcre-dev \
      pngquant \
      unzip \
      wget \
      zip \
      zlib-dev \
      curl \
      curl-dev \
      libpq \
      libevent \
      libevent-dev \
      bash

# Swoole

RUN  apk add --no-cache --virtual .build-deps \
      autoconf \
      $PHPIZE_DEPS \
      automake \
      g++ \
      gcc \
      gettext \
      libc-dev \
      libtool \
      linux-headers \
      musl-dev \
      perl-dev \
      zlib-dev \
      icu \
      icu-dev \
      c-ares \
      c-ares-dev

# Pcntl
RUN docker-php-ext-install pcntl

# intl
RUN docker-php-ext-configure intl && docker-php-ext-install intl \
    && docker-php-ext-enable intl

#soap
RUN docker-php-ext-configure soap --enable-soap  && docker-php-ext-install soap

# php sockets
RUN docker-php-ext-configure sockets
RUN docker-php-ext-install sockets
RUN docker-php-ext-enable sockets

# Swoole
RUN pecl install --configureoptions 'enable-debug="yes" enable-debug-log="yes" enable-sockets="no" enable-openssl="no" enable-http2="no" enable-swoole-json="yes" enable-swoole-curl="yes" enable-cares="no"' openswoole && \
docker-php-ext-enable openswoole --ini-name zz-swoole.ini openswoole

# php pgsql
RUN apk add --update-cache --no-cache libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-enable opcache \
      && docker-php-ext-install zip \
      && docker-php-ext-install intl

# php libevent
RUN apk add --update-cache --no-cache autoconf gcc coreutils build-base git && \
    git clone https://bitbucket.org/osmanov/pecl-event.git  && \
    cd pecl-event && \
    phpize && \
    ./configure --with-event-extra && \
    make && \
    make install && \
    docker-php-ext-enable event && \
    mv /usr/local/etc/php/conf.d/docker-php-ext-event.ini \
        /usr/local/etc/php/conf.d/docker-php-ext-zz-event.ini

# php msgpack
RUN pecl install msgpack
RUN docker-php-ext-enable msgpack

# php zeromq
RUN apk add --update-cache --no-cache libzmq zeromq-dev zeromq && \
  apk add --update-cache --no-cache --virtual=.build-php-dependencies \
  autoconf gcc coreutils build-base git && \
  git clone https://github.com/mkoppanen/php-zmq.git && \
  cd php-zmq && \
  phpize && \
  ./configure && \
  make && \
  make install && \
  docker-php-ext-enable zmq

#imagick
RUN set -eux; \
	apk add --no-cache imagemagick-dev; \
	curl -fL -o imagick.tgz 'https://pecl.php.net/get/imagick-3.7.0.tgz'; \
	echo '5a364354109029d224bcbb2e82e15b248be9b641227f45e63425c06531792d3e *imagick.tgz' | sha256sum -c -; \
	tar --extract --directory /tmp --file imagick.tgz imagick-3.7.0; \
	grep '^//#endif$' /tmp/imagick-3.7.0/Imagick.stub.php; \
	test "$(grep -c '^//#endif$' /tmp/imagick-3.7.0/Imagick.stub.php)" = '1'; \
	sed -i -e 's!^//#endif$!#endif!' /tmp/imagick-3.7.0/Imagick.stub.php; \
	grep '^//#endif$' /tmp/imagick-3.7.0/Imagick.stub.php && exit 1 || :; \
	docker-php-ext-install /tmp/imagick-3.7.0; \
	rm -rf imagick.tgz /tmp/imagick-3.7.0

# php exif
RUN docker-php-ext-configure exif \
&& docker-php-ext-install exif \
&& docker-php-ext-enable exif


# php gd
RUN apk add --no-cache \
      freetype \
      libjpeg-turbo \
      libpng \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && docker-php-ext-configure gd \
      --with-freetype=/usr/include/ \
      # --with-png=/usr/include/ \ # No longer necessary as of 7.4; https://github.com/docker-library/php/pull/910#issuecomment-559383597
      --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable gd \
    && apk del --no-cache \
      freetype-dev \
      libjpeg-turbo-dev \
      libpng-dev \
    && rm -rf /tmp/*

WORKDIR /var/www/

# Get latest Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

RUN rm -rf /var/cache/apk/* && apk cache clean

RUN chown -R ${USER}:${USER} /usr/bin/composer
RUN chown -R ${USER}:${USER} /var/www/

USER $USER
