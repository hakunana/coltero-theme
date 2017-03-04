# ------------------------------------------------------------------------------
# Humhub - Das flexible Open Source Social Network Kit
# https://www.humhub.org
# ------------------------------------------------------------------------------

# ------------------------------------------------------------------------------
FROM debian:jessie
MAINTAINER Fabian Odoni <fabian.odoni@htwchur.ch>

# ------------------------------------------------------------------------------
# Set Arguments
ARG TERM=linux
ARG DEBIAN_FRONTEND=noninteractive

# ------------------------------------------------------------------------------
# Set Environmental Arguments
ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2/apache2.pid
ENV SERVER_URL localhost:8081

# ------------------------------------------------------------------------------
# Setting up server
# ------------------------------------------------------------------------------
# Set up base system
RUN apt-get update --quiet &&\
    apt-get install --quiet --yes --no-install-recommends \
        ca-certificates \
        cron \
        curl \
        less \
        nano \
    ;

# ------------------------------------------------------------------------------
# Set up php environment
RUN apt-get update --quiet &&\
    apt-get install --quiet --yes --no-install-recommends \
        imagemagick \
        mcrypt \
        php5-apcu \
        php5-memcached \
        php5 \
        php5-cli \
        php5-curl \
        php5-gd \
        php5-intl \
        php5-ldap \
        php5-mcrypt \
        php5-mysql \
        php5-sqlite \
    ;

# ------------------------------------------------------------------------------
# Set up apache server
RUN apt-get update --quiet &&\
    apt-get install --quiet --yes --no-install-recommends \
        apache2 \
        libapache2-mod-php5 \
        libapache2-mod-xsendfile \
    ;

# ------------------------------------------------------------------------------
# Setting up php
# Increase php's max allowed memory size
RUN sed -i 's;memory_limit = .*;memory_limit = -1;' /etc/php5/apache2/php.ini &&\
    sed -i 's;memory_limit = .*;memory_limit = -1;' /etc/php5/cli/php.ini &&\
    sed -i 's;display_errors = .*;display_errors = Off;' /etc/php5/apache2/php.ini &&\
# Change apache php to allow larger uploads/POSTs
    sed -i 's;post_max_size = .*;post_max_size = 4000M;' /etc/php5/apache2/php.ini &&\
    sed -i 's;upload_max_filesize = .*;upload_max_filesize = 2000M;' /etc/php5/apache2/php.ini &&\
# Set the max execution time
    sed -i 's;max_execution_time = .*;max_execution_time = 300;' /etc/php5/apache2/php.ini &&\
    sed -i 's;max_execution_time = .*;max_execution_time = 300;' /etc/php5/cli/php.ini &&\
# This is also needed for execution time
    sed -i 's;max_input_time = .*;max_input_time = 300;' /etc/php5/apache2/php.ini

# ------------------------------------------------------------------------------
# Configuring apache2 for etherpad
COPY config/proxy.conf /etc/apache2/mods-available/proxy.conf
COPY config/000-default.conf /etc/apache2/sites-available/000-default.conf

# ------------------------------------------------------------------------------
# Enable the php mod we just installed
# Set up url rewrite ability (for etherpad; see etherpad plugin notes)
RUN a2enmod php5 &&\
    a2enmod rewrite &&\
    php5enmod mcrypt &&\
    a2enmod ssl &&\
    a2enmod proxy &&\
    a2enmod proxy_balancer &&\
    a2enmod proxy_http &&\
    service apache2 restart

# ------------------------------------------------------------------------------
# Setting CRON Jobs
RUN (crontab -u www-data -l 2>/dev/null; \
        echo "00 18 * * * /var/www/html/protected/yii cron/daily >/dev/null 2>&1") \
        | crontab -u www-data - &&\

    (crontab -u www-data -l 2>/dev/null; \
        echo "30 * * * * /var/www/html/protected/yii cron/hourly >/dev/null 2>&1") \
        | crontab -u www-data -

# ------------------------------------------------------------------------------
# Needed to get write permission on volumes
RUN usermod -u 1000 www-data
RUN usermod -G staff www-data

RUN mkdir /humhub
VOLUME /humhub
RUN ln -s /humhub/ /var/www/html

# ------------------------------------------------------------------------------
# Starting apache server
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
