FROM php:8-apache 
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

WORKDIR /var/www/html
COPY ./src/. /var/www/html/
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
RUN composer install --no-dev

#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf