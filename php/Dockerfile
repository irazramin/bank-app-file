# php/Dockerfile
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nano \
    vim \
    curl \
    telnet \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www/html
COPY . .

RUN chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["php-fpm"]