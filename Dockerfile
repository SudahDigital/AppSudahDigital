FROM php:8.0-fpm

# Set working directory
WORKDIR /var/www

RUN umask 0000

# Add docker php ext repo
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install php extensions
RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions mbstring pdo_mysql zip exif pcntl gd memcached3
    
RUN apt-get update -y && \
    apt-get install -y build-essential libfuse-dev libcurl4-openssl-dev libxml2-dev pkg-config libssl-dev mime-support automake libtool wget tar git unzip kmod
RUN apt-get install lsb-release -y  && apt-get install zip -y && apt-get install vim -y

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip \
    git \
    curl \
    lua-zlib-dev \
    libmemcached-dev \
    nginx

# Install supervisor
RUN apt-get install -y supervisor

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy code to /var/www
COPY --chown=root:root . /var/www

# add root to www group
RUN chmod -R ug+w /var/www/storage

# Copy nginx/php/supervisor configs
RUN cp docker/supervisor.conf /etc/supervisord.conf
RUN cp docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

ARG CONSUL_TOKEN

RUN curl -s --header "X-Consul-Token:$CONSUL_TOKEN" -XGET https://consul.sudahdigital.com/v1/kv/prod/app.sudahdigital.com?raw=true > .env
RUN chown root:root .env

# Deployment steps
RUN composer install --optimize-autoloader --no-dev
RUN chmod +x /var/www/docker/run.sh

RUN chown -R root:root vendor
RUN chown -R root:root storage/logs/
RUN chmod -R 777 /var/www/storage/framework/sessions
RUN chmod -R 777 /var/www/storage/framework/views
RUN chmod -R 777 /var/www/storage/framework/cache

EXPOSE 443
ENTRYPOINT ["/var/www/docker/run.sh"]
