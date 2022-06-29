FROM php:8.0-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    cron

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli mbstring exif pcntl bcmath gd zip soap intl

# Install GRPC
RUN pecl install grpc

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
#RUN useradd -G www-data,root -u $uid -d /home/$user $user
#RUN mkdir -p /home/$user/.composer && \
#COPY . /var/www
#RUN     chown -R www-data:www-data /var/www && \
#        chmod -R 755 /var/www


# Set working directory
WORKDIR /var/www

## Add provision scripts
#ADD ./docker-compose/scripts /scripts
#RUN chmod 755 -R /scripts

# Cronjobs
#COPY ./docker-compose/cron.txt /etc/crontab
#RUN cat /etc/crontab | crontab -


#RUN npm install
# Install composer on build
#RUN composer install
#USER $user
CMD composer install && cp .env.example .env && php artisan key:generate && php artisan storage:link && php artisan migrate && php-fpm
