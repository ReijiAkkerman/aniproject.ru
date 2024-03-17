#syntax=docker/dockerfile:1

FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
apt-get install -y php php-mysql php-mbstring php-xml apache2 
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
php composer-setup.php \
php -r "unlink('composer-setup.php');" \
mv composer.phar /usr/local/bin/composer

COPY 000-default.conf /etc/apache2/sites-available/

WORKDIR /var/www/html