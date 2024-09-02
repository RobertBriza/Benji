FROM nginx:1.19

COPY ./.docker/nginx/vhost.conf.template /etc/nginx/templates/vhost.conf.template
COPY ./www /var/www/html/www

WORKDIR /var/www/html

ENV PHP_HOST=fpm
