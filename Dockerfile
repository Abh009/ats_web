FROM ubuntu:latest
RUN apt-get update && apt-get -y install apache2 mysql-server php
COPY . /var/www/html