FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache \
    nginx \
    curl \
    supervisor


RUN docker-php-ext-install pdo pdo_mysql

COPY nginx-root.conf /etc/nginx/nginx.conf
COPY nginx.conf /etc/nginx/http.d/default.conf
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY www.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www

COPY . .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN composer install


EXPOSE 8181

CMD ["/usr/bin/supervisord"]
