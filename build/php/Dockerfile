FROM php:8.2-fpm


RUN docker-php-ext-install pdo pdo_mysql && docker-php-ext-install mysqli && docker-php-ext-enable mysqli


WORKDIR /var/www/html/public



RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html