# Download base php
FROM php:8.2-fpm

# Disable Prompt During Packages Installation
ARG DEBIAN_FRONTEND=noninteractive
ENV NODE_ENV production

# Update Software repository
RUN apt update -y && apt -y upgrade &&  apt install -y software-properties-common && apt update

# Install php-fpm and supervisord from  repository
RUN apt install -y supervisor libxrender-dev libfontconfig1 libxext6 libx11-dev \
nginx cron libpq-dev libpng++-dev libcurl4-openssl-dev libxml2-dev nodejs npm unzip libpng-dev libzip-dev zlib1g-dev curl mariadb-client libicu-dev && \
    rm -rf /var/lib/apt/lists/* && apt clean

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql gd dom zip exif pcntl bcmath intl calendar \
&& docker-php-ext-install pdo_pgsql

RUN docker-php-ext-configure calendar

# Install Yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install -y yarn


# Define the ENV variable
ENV php_conf /etc/php/8.2/fpm/php.ini
ENV supervisor_conf /etc/supervisor/supervisord.conf

RUN mkdir /var/www/app

RUN mkdir -p /run/php && \
    chown -R www-data:www-data /var/www/app && \
    chown -R www-data:www-data /run/php


WORKDIR /var/www/app

# Install composer
COPY --from=composer:2.2.0 /usr/bin/composer /usr/local/bin/composer

# Add user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/app
# Install PHP dependencies using Composer
# RUN composer install --no-dev --optimize-autoloader

# Install node dependencies using Yarn
# RUN yarn install --production
# RUN yarn build



# Change current user to www
USER www

# Expose Port for the Application
EXPOSE 8080

# CMD ["./.docker/start.sh"]
ENTRYPOINT ["/usr/bin/supervisord", "-n" ,"-c", "/etc/supervisor/supervisord.conf"]
