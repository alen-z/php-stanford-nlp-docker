# Define your app’s environment
# Official PHP image https://hub.docker.com/_/php/
FROM php:5.6.30-apache

# Additional metadata
MAINTAINER Alen Zubic <alen.zubic@srce.hr>

# Backports
RUN echo "deb http://ftp.debian.org/debian jessie-backports main" >> /etc/apt/sources.list

# Get current updates
RUN apt-get update && apt-get install -y \
    locate \
    nano \
    wget \
    unzip \
    git

RUN apt-get -t jessie-backports install -y "openjdk-8-jre"

# Install composer
RUN bash -c "wget http://getcomposer.org/composer.phar && mv composer.phar /usr/local/bin/composer"
RUN chmod +x /usr/local/bin/composer

# Put data into container
WORKDIR /var/www/html
RUN git clone https://github.com/alen-z/php-stanford-nlp-docker

# Stanford NLP PHP wrapper
RUN composer install

# Java app
RUN wget https://nlp.stanford.edu/software/stanford-parser-full-2016-10-31.zip && unzip stanford-parser-full-2016-10-31.zip
RUN rm stanford-parser-full-2016-10-31.zip