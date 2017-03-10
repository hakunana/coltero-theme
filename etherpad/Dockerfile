# ------------------------------------------------------------------------------
# Etherpad build for Humhub-Enterprise Docker-Compose setup
#
# Stable version of etherpad doesn't support npm 2
# ------------------------------------------------------------------------------

# ------------------------------------------------------------------------------
# Pull base image.
FROM debian:jessie
MAINTAINER Fabian Odoni <fabian.odoni@htwchur.ch>

# ------------------------------------------------------------------------------
# Setting up etherpad user and group
RUN groupadd -r etherpad && useradd -r --create-home -g etherpad etherpad

# ------------------------------------------------------------------------------
# Installing additional software
# (optional)
RUN apt-get update && \
    apt-get install -y \
        less \
        nano \
    ;

# ------------------------------------------------------------------------------
# Installing dependencies
RUN apt-get update && \
    apt-get install -y \
        curl \
        mysql-client \
        nodejs-legacy \
        npm \
        unzip \
    ;

# ------------------------------------------------------------------------------
# Setting etherpad version to be installed
ENV ETHERPAD_VERSION 1.6.1

# ------------------------------------------------------------------------------
# Downloading and unpacking etherpad
WORKDIR /opt/
RUN curl -SL https://github.com/ether/etherpad-lite/archive/${ETHERPAD_VERSION}.zip > etherpad.zip \
 && unzip etherpad \
 && rm etherpad.zip \
 && mv etherpad-lite-${ETHERPAD_VERSION} ./etherpad-lite \
 && chown -Rv etherpad etherpad-lite

# ------------------------------------------------------------------------------
# Running etherpad installation and replacing settings.json with own file
USER etherpad
WORKDIR etherpad-lite

RUN bin/installDeps.sh \
 && rm settings.json
COPY config/etherpad-settings.json settings.json
COPY config/SESSIONKEY.txt SESSIONKEY.txt

# ------------------------------------------------------------------------------
# Running etherpad
CMD ["bin/run.sh"]
