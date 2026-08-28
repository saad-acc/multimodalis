FROM php:8.3-apache

RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite headers \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/apache2.conf \
    && printf '%s\n' \
      '<Directory /var/www/html/public>' \
      '  AllowOverride All' \
      '  Require all granted' \
      '</Directory>' \
      >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY public/ /var/www/html/public/

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
EXPOSE 80
