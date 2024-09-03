FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libssl-dev \
    openssl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip \
    && a2enmod rewrite ssl

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www/html

COPY package*.json ./

RUN npm install

COPY --chown=www-data:www-data . /var/www/html

RUN npm run build

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY converthub.ortegaf.fr.conf /etc/apache2/sites-available/converthub.ortegaf.fr.conf

RUN a2ensite converthub.ortegaf.fr.conf

RUN a2dissite 000-default.conf

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/apache-selfsigned.key \
    -out /etc/ssl/certs/apache-selfsigned.crt \
    -subj "/C=FR/ST=Ile-de-France/L=Paris/O=MyCompany/OU=Dev/CN=converthub.ortegaf.fr"

EXPOSE 80 443
