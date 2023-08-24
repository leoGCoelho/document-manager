FROM php:8.0-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    nano \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

RUN docker-php-ext-install pdo_mysql

COPY etc/default.ini /usr/local/etc/php/conf.d/default.ini

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY ./app .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install
#RUN php artisan storage:link
#RUN php artisan migrate

COPY --chown=www:www . /var/www/
USER www
EXPOSE 9000

CMD ["php-fpm"]