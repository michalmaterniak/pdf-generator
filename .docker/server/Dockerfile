FROM php:8.3.4
RUN apt update
RUN apt install -y git sudo unzip libzip-dev
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
#RUN curl -sS https://getcomposer.org/installer | php
#RUN mv composer.phar /usr/local/bin/composer
RUN install-php-extensions zip pdo_mysql mongodb amqp
RUN install-php-extensions @composer

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | sudo -E bash
RUN apt install -y symfony-cli wkhtmltopdf

RUN useradd -m user --uid 1000 -s /usr/bin/bash
RUN echo "user:user" | chpasswd
RUN usermod -aG sudo user

USER user
