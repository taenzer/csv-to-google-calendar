FROM php:8-apache 
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

WORKDIR /var/www/html

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apt-get update
RUN apt-get install zip unzip curl -y

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Copy Files
COPY ./src/. /var/www/html/
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Install Dependencies
RUN composer install --no-dev

#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf