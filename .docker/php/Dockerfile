FROM php:8.3-fpm

USER root

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    netcat-openbsd \
    cron \
    libpq-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install mysqli pgsql pdo pdo_mysql pdo_pgsql

RUN pecl install xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./.docker/php /opt/rb
RUN chmod +x /opt/rb/entrypoint.sh

COPY --chown=www-data ./ /var/www/html
WORKDIR /var/www/html

RUN composer install && composer dump-autoload -o --apcu

ARG SECRET_DIR
RUN mkdir -p $SECRET_DIR && chmod -R 0777 $SECRET_DIR

COPY ./deploy/cron/cron /etc/cron.d/cron
RUN chmod 0644 /etc/cron.d/cron
RUN crontab /etc/cron.d/cron
RUN touch /var/log/cron.log

ENTRYPOINT ["/opt/rb/entrypoint.sh"]

CMD ["php-fpm"]
