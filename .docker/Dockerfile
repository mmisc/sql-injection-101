FROM php:7.4-apache

MAINTAINER Mischa Meier

COPY . /srv/app
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY ./db/zwitscher.sql /docker-entrypoint-initdb.d/zwitscher.sql

WORKDIR /srv/app

RUN docker-php-ext-install mysqli\
    && chown -R www-data:www-data /srv/app\
    && a2enmod rewrite
