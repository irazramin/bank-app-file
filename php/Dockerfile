FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nano \
    vim \
    curl \
    telnet \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY php.ini /usr/local/etc/php/php.ini

COPY . /var/www/html

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
