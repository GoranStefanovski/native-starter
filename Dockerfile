#base-image
FROM ubuntu

#UPDATE
RUN apt-get update

#create a new user named newuser with empty password neede for installing composer (Shouldnt work as root but it does)
ENV USERNAME=testuser
RUN adduser --disabled-password --gecos '' $USERNAME

#package needed for adding repo
RUN apt-get update && apt-get --assume-yes install apt-transport-https software-properties-common python-software-properties apt-utils curl
#add repo
RUN LC_ALL=C.UTF-8 add-apt-repository -y ppa:ondrej/php; exit 0;

#npm
RUN add-apt-repository -y -r ppa:chris-lea/node.js
RUN curl --silent https://deb.nodesource.com/gpgkey/nodesource.gpg.key | apt-key add -
RUN echo "deb https://deb.nodesource.com/node_10.x $(lsb_release -s -c) main" | tee /etc/apt/sources.list.d/nodesource.list
RUN echo "deb-src https://deb.nodesource.com/node_10.x $(lsb_release -s -c) main" | tee -a /etc/apt/sources.list.d/nodesource.list

#install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list

#install needed packages for LAMP stack except MYSQL(it runs in separate container)
RUN apt-get update && apt-get --assume-yes install apache2 php7.1 php7.1-cli php7.1-common php7.1-json php7.1-opcache php7.1-mysql php7.1-mbstring php7.1-mcrypt php7.1-zip php7.1-fpm php7.1-xml php7.1-gd php7.1-soap php7.1-curl\
    libapache2-mod-php7.1 git acl vim memcached php7.1-memcached php7.1-intl php7.1-bcmath php-amqplib nodejs yarn\
    #mkcert
    libnss3-tools build-essential wget\
    php7.1-xdebug

RUN echo 'export PATH="$PATH:/opt/yarn-1.21.1/bin"' >> /home/testuser/.profile

#get composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#gulp
RUN npm install --global --silent gulp-cli

#this installs gulp 
RUN npm install gulp

WORKDIR /home/$USERNAME

RUN rm -rf /var/lib/apt/lists/*

RUN wget https://github.com/FiloSottile/mkcert/releases/download/v1.1.2/mkcert-v1.1.2-linux-amd64
RUN mv mkcert-v1.1.2-linux-amd64 mkcert
RUN chmod +x mkcert
RUN cp mkcert /usr/local/bin/

RUN mkcert -install
RUN mkdir ssl-certs
WORKDIR /home/$USERNAME/ssl-certs
RUN mkcert zoom.local

ADD apache/apache2.conf /etc/apache2/apache2.conf

RUN a2enmod ssl
#disable default apache landing site and enable the one that is going to run in the container
RUN a2dissite 000-default.conf

RUN echo ";xdebug configuration" >> /etc/php/7.1/cli/php.ini \
     && echo "zend_extension=$(php -i | awk '/extension_dir/ {print $3."/xdebug.so"}')" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.remote_enable = 1" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.remote_port = 9006" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.remote_handler = dbgp" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.remote_mode = req" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.profiler_enable=0" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.profiler_enable_trigger=1" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.remote_autostart=1" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.idekey=docker" >> /etc/php/7.1/cli/php.ini \
     && echo "xdebug.remote_log='/tmp/xdebug.log'" >> /etc/php/7.1/cli/php.ini 

ENV PHP_IDE_CONFIG="serverName=Docker"

RUN echo ";xdebug configuration" >> /etc/php/7.1/apache2/php.ini \
     && echo "zend_extension=$(php -i | awk '/extension_dir/ {print $3."/xdebug.so"}')" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.remote_enable = 1" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.remote_port = 9006" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.remote_handler = dbgp" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.remote_mode = req" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.profiler_enable=0" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.profiler_enable_trigger=1" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.remote_autostart=1" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.idekey=docker" >> /etc/php/7.1/apache2/php.ini \
     && echo "xdebug.remote_log='/tmp/xdebug.log'" >> /etc/php/7.1/apache2/php.ini

RUN sed -i "s/error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT/error_reporting = E_ALL/g"  /etc/php/7.1/apache2/php.ini 
RUN sed -i "s/memory_limit = 128M/memory_limit = 1536M/g"  /etc/php/7.1/apache2/php.ini
RUN sed -i "s/post_max_size = 8M/post_max_size = 140M/g"  /etc/php/7.1/apache2/php.ini
RUN sed -i "s/upload_max_filesize = 2M/upload_max_filesize = 140M/g"  /etc/php/7.1/apache2/php.ini

RUN phpenmod xdebug

#not sure if needed (i think it tells the gest to make the port available to host)
EXPOSE 80

RUN a2enmod rewrite

ENTRYPOINT ["apachectl", "-D", "FOREGROUND"]
