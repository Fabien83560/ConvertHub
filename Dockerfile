FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    certbot \
    python3-certbot-apache \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql zip \
    && a2enmod rewrite \
    && a2enmod ssl

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY ./converthub.ortegaf.fr.conf /etc/apache2/sites-available/converthub.ortegaf.fr.conf
COPY ./init-certbot.sh /usr/local/bin/init-certbot.sh
RUN chmod +x /usr/local/bin/init-certbot.sh

RUN echo 'ServerName converthub.ortegaf.fr' >> /etc/apache2/apache2.conf
COPY --chown=www-data:www-data . /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install \
    && npm run build

RUN chown -R www-data:www-data /var/www/html/public

EXPOSE 80 443

CMD ["/usr/local/bin/init-certbot.sh"]