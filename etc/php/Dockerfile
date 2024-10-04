FROM php:8.1-fpm

ENV DEBIAN_FRONTEND noninteractive

# Install necessary packages
RUN apt-get update && apt-get install -y \
git \
unzip \
libfreetype6-dev \
libjpeg62-turbo-dev \
libmcrypt-dev \
libpng-dev \
libssl-dev \
libz-dev \
zlib1g-dev \
libsqlite3-dev \
zip \
libxml2-dev \
libcurl4-openssl-dev \
libedit-dev \
libpspell-dev \
libldap2-dev \
unixodbc-dev \
libpq-dev

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl

# Create directory for PHP-FPM configuration
RUN mkdir -p /usr/local/etc/php-fpm.d/

# Fix for LDAP library issue
RUN ln -fs /usr/lib/x86_64-linux-gnu/libldap.so /usr/lib/

# Install PHP extensions individually
RUN docker-php-ext-install iconv \
&& docker-php-ext-install pcntl \
&& docker-php-ext-install bcmath \
&& docker-php-ext-install simplexml \
&& docker-php-ext-install soap \
&& docker-php-ext-install pspell \
&& docker-php-ext-install ldap

# Enable PHP extensions
RUN docker-php-ext-enable iconv \
&& docker-php-ext-enable pcntl \
&& docker-php-ext-enable bcmath \
&& docker-php-ext-enable simplexml \
&& docker-php-ext-enable soap \
&& docker-php-ext-enable pspell \
&& docker-php-ext-enable ldap

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Clean up
RUN apt-get autoremove -y \
&& dpkg -la | awk '{print $2}' | grep '\-dev' | xargs apt-get remove -y \
&& apt-get clean all \
&& rm -rvf /var/lib/apt/lists/* \
&& rm -rvf /usr/share/doc /usr/share/man /usr/share/locale \
&& rm -rvf /usr/src/php

EXPOSE 8080