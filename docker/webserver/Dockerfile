FROM webdevops/php-nginx:7.3

RUN apt update

# Install composer
ENV COMPOSER_HOME /composer
ENV PATH ./vendor/bin:/composer/vendor/bin:$PATH
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

#RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
#RUN apt install -y nodejs

RUN apt install -y procps
RUN apt install -y redis-server
RUN apt install -y ffmpeg

#RUN npm install -g laravel-echo-server

RUN wget -q -O - https://dl-ssl.google.com/linux/linux_signing_key.pub | apt-key add -
RUN sh -c 'echo "deb [arch=amd64] http://dl.google.com/linux/chrome/deb/ stable main" >> /etc/apt/sources.list.d/google-chrome.list'
RUN apt update && apt install -y google-chrome-stable

ENV CHROMEDRIVER_VERSION 78.0.3904.105
ENV CHROMEDRIVER_DIR /chromedriver
RUN mkdir $CHROMEDRIVER_DIR

# Download and install Chromedriver
RUN wget -q --continue -P $CHROMEDRIVER_DIR "https://chromedriver.storage.googleapis.com/$CHROMEDRIVER_VERSION/chromedriver_linux64.zip"
RUN unzip $CHROMEDRIVER_DIR/chromedriver* -d $CHROMEDRIVER_DIR

COPY ./webserver/config/nginx.conf /opt/docker/etc/nginx/vhost.conf
COPY ./webserver/config/php.ini /opt/docker/etc/php/php.ini
COPY ./webserver/config/laravel-websockets.conf /opt/docker/etc/supervisor.d/laravel-websockets.conf
COPY ./webserver/config/redis.conf /opt/docker/etc/supervisor.d/redis.conf

COPY ./webserver/config/redis-conf-addendum.txt /tmp/redis-conf-addendum.txt
RUN cat /tmp/redis-conf-addendum.txt >> /etc/redis/redis.conf

COPY ./webserver/config/init.sh /opt/docker/provision/entrypoint.d/25-partymeister.sh
RUN chmod +x /opt/docker/provision/entrypoint.d/25-partymeister.sh
RUN chmod -R 777 /composer

COPY ./webserver/config/pm-installation.sh /tmp/pm-installation.sh
RUN chmod +x /tmp/pm-installation.sh

# TODO
# cron
