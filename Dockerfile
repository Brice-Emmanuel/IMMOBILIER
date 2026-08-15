FROM php:8.2-apache

/* STREAMING_CHUNK:Installing system dependencies and PHP extensions... */
RUN apt-get update && apt-get install -y 

libpng-dev 

libonig-dev 

libxml2-dev 

zip 

unzip 

git 

curl 

&& docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

/* STREAMING_CHUNK:Configuring Apache document root and rewrite module... /
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

/* STREAMING_CHUNK:Copying project files and installing Composer... */
COPY . /var/www/html
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

/* STREAMING_CHUNK:Setting permissions for storage and cache... */
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80