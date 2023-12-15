FROM php:8.2-fpm AS base

# Install extensions
RUN apt-get update && apt-get install -y \
		libzip-dev \
        zip \
  && docker-php-ext-install pdo_mysql bcmath zip \
  && pecl install xdebug \
  && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Create container's user based on provided user ID if the current container's user id is not equal to host_uid 
ARG HOST_UID

RUN /bin/bash -c 'user_exists(){ id "$HOST_UID" &>/dev/null; }; \
if [[ $HOST_UID -ne $(id -u) ]] && ! user_exists; then adduser --disabled-password --gecos \"\" --uid $HOST_UID new_user; fi'

# Switch to that user
USER ${HOST_UID}

WORKDIR /var/www/html/

