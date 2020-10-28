FROM php:7.4-fpm
ARG TIMEZONE

RUN apt-get update && apt-get install -y nano sudo wget

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
  && printf 'date.timezone = "%s"' ${TIMEZONE} > /usr/local/etc/php/conf.d/timezone.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN  apt-get update && \
  apt-get install -y libpq-dev \
  libxml2-dev \
  libzip-dev \
  libpng-dev \
  libjpeg-dev \
  librabbitmq-dev \
  zip \
  && docker-php-ext-configure zip \
  && docker-php-ext-configure gd \
  && docker-php-ext-install \
    zip \
    gd \
    pdo_mysql \
    pdo_pgsql \
    bcmath \
    opcache \
    sockets

RUN apt-get install -y autoconf g++ make git \
  && docker-php-source extract \
  && pecl install \
    redis \
    amqp \
  && docker-php-ext-enable \
    redis \
    amqp \
  && docker-php-source delete \
  && mkdir /xdebug_installer && cd /xdebug_installer && git clone https://github.com/xdebug/xdebug.git && cd xdebug && sh ./rebuild.sh && cd / && rm -rf /xdebug_installer \
  && rm -rf /tmp/*

RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY conf.d/* /usr/local/etc/php/conf.d/

RUN adduser www-data sudo && usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

RUN mkdir /var/www/.composer/ && chown www-data /var/www/.composer/ \
  &&  mkdir /var/www/.symfony/ && chown www-data /var/www/.symfony/

USER www-data

WORKDIR /var/www/api-example-symfony