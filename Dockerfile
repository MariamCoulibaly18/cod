FROM php:8.2-cli

RUN apt-get update -y
RUN apt-get -y install curl git unzip libpng-dev zlib1g-dev libonig-dev libzip-dev

# Installing PHP Extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql mbstring zip  gd && docker-php-ext-enable pdo_mysql mbstring zip gd

# Installing Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Setting up the project
WORKDIR /var/www/html
